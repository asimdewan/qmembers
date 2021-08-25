<?php

namespace includes\classes\DatabaseClient;



use includes\classes\Config;

use includes\classes\RabbitMqClient\Entity\AbstractSerializableEntity;

use includes\classes\RabbitMqClient\Entity\BusinessData;

use includes\classes\RabbitMqClient\Entity\Groups;

use includes\classes\RabbitMqClient\Entity\Image;

use includes\classes\RabbitMqClient\Entity\Login;

use includes\classes\RabbitMqClient\Entity\MembershipBilling;

use includes\classes\RabbitMqClient\Entity\MembershipDelivery;

use includes\classes\RabbitMqClient\Entity\PasswordChange;

use includes\classes\RabbitMqClient\Entity\PasswordRecovery;

use includes\classes\RabbitMqClient\Entity\PersonalData;

use includes\classes\RabbitMqClient\Entity\Settings;

use includes\classes\RabbitMqClient\Entity\TerminateMembership;

use ReflectionClass;



class DatabaseClient

{

    /** @var  string */

    private $error;



    /** @var Mapping  */

    private $mapping;



    /** @var string  */

    private $authenticated = false;



    /** @var string  */

    public $memberID;



    /** @var /class  */

    private $config_class;



    /** @var array  */

    private $config;





    public function __construct(Mapping $mapping)

    {

        db_set_active('qmembers');

        $this->mapping = $mapping;



        $this->config_class      =  new Config;

        $this->config            = $this->config_class->getAll();



    }



    public function getError()

    {

        return $this->error;

    }



    public function __destruct()

    {

        db_set_active();

    }



    public function checkLogin(Login $data)

    {

        $query = db_select('member', 'm');

        $query->addField('m', 'password');

        $query->condition('m.email', $data->getEmail());

        $password = $query->execute()->fetchField();

        if ( empty($password) ) {



            // Check if email matches personal email



            // Special requirement: but exclude certain member ids that are set in the config file, because these

            // members have 2 accounts and one of them should not be used to log in.

            // This includes the personal email, because it could be saved in both accounts and both

            // accounts could not have a professional email. In that case there would be a conflict during login.

            // We might catch the wrong account, the one that has a membership level that is not able to login.



            $excluded_member_ids = array();



            if ( isset($this->config['disable-primary-login-email-for-these-member-ids-during-data-import']) && !empty($this->config['disable-primary-login-email-for-these-member-ids-during-data-import']) ){



                $excluded_member_ids = explode(',', $this->config['disable-primary-login-email-for-these-member-ids-during-data-import']);

            }



            $query = db_select('membermeta', 'm');

            $query->addField('m', 'mid');



            if ($excluded_member_ids)

                $query->condition('m.mid', $excluded_member_ids, 'NOT IN');



            $query->condition('m.metaname', 'email_personal');

            $query->condition('m.value', $data->getEmail());

            $member_id = $query->execute()->fetchField();

            if ( empty($member_id) ) {

                $this->error = 'Member not found or password not correct';

                return false;

            }

            else{

                // Check password according to member id

                $query = db_select('member', 'm');

                $query->addField('m', 'password');

                $query->condition('m.memberid', $member_id);

                $password = $query->execute()->fetchField();

                if ( empty($password) || !password_verify($data->getPassword(), $password) ) {

                    $this->error = 'Member not found or password not correct';

                    return false;

                }

            }

        }

        elseif (!password_verify($data->getPassword(), $password)) {

            $this->error = 'Member not found or password not correct';

            return false;

        }





        // Special requirement: Members with membership_level = "Fördermitglied" should not be able to log in

        if( isset($this->config['membership-levels-that-are-not-allowed-to-login']) && !empty($this->config['membership-levels-that-are-not-allowed-to-login']) ){



            $excluded_membership_levels = explode(',',$this->config['membership-levels-that-are-not-allowed-to-login'] );



            // Get member id

            $query = db_select('member', 'm');

            $query->addField('m', 'memberid');

            $query->condition('m.email', $data->getEmail());

            $member_id = $query->execute()->fetchField();

            if ( empty($member_id) ) {



                // Get member id according to personal email

                $query = db_select('membermeta', 'm');

                $query->addField('m', 'mid');

                $query->condition('m.metaname', 'email_personal');

                $query->condition('m.value', $data->getEmail());

                $member_id = $query->execute()->fetchField();

                if ( empty($member_id) ) {

                    $this->error = 'Member not found or password not correct';

                    return false;

                }

            }



            // Get membership level

            $query = db_select('membermeta', 'm');

            $query->addField('m', 'value');

            $query->condition('m.mid', $member_id);

            $query->condition('m.metaname', 'membership_level');

            $membership_level = $query->execute()->fetchField();



            // Check if membership level is listed as to be excluded from login

            if ( in_array($membership_level, $excluded_membership_levels) ){



                $this->error = 'membership_level_excluded_from_login';

                return false;

            }

        }



        $this->authenticated = true;

        $this->memberID      = $member_id;



        return true;

    }



    public function getMemberID(){



        if($this->authenticated) return $this->memberID;

        else return false;

    }



    public function checkOldPassword(Settings $data)

    {

        $query = db_select('member', 'm');

        $query->addField('m', 'password');

        $query->condition('m.memberid', $data->getId());

        $password = $query->execute()->fetchField();



        if (empty($password) || !password_verify($data->getOldPassword(), $password)) {

            $this->error = 'Old password not correct';

            return false;

        }



        return true;

    }



    public function createPasswordRecoveryHash(PasswordRecovery $data)

    {

        $id = $this->checkForExistingUser($data);

        if (empty($id)) {

            $this->error = 'Member not found';

            return false;

        }



        $time = time();

        $hash = hash('sha512', uniqid('', true));



        $table = 'member';

        $entry = array(

            'password_recovery_hash' => $hash,

            'password_recovery_date' => $time,

        );



        $rows = db_update($table, array())->fields($entry)->condition('id', $id)->execute();

        if ($rows != 1) {

            $this->error = 'Could not save hash';

            return false;

        }



        return $hash;

    }



    public function savePassword(PasswordChange $data)

    {

        $id = $this->checkForExistingHash($data);

        if (empty($id)) {

            $this->error = 'Password recovery link expired';

            return false;

        }



        $table = 'member';

        $entry = array(

            'password' => password_hash($data->getPassword(), PASSWORD_DEFAULT),

            'password_recovery_hash' => NULL,

            'password_recovery_date' => NULL,

        );



        $rows = db_update($table, array())->fields($entry)->condition('id', $id)->execute();

        if ($rows != 1) {

            $this->error = 'Could not save password';

            return false;

        }



        return true;

    }



    private function checkForExistingUser(PasswordRecovery $data)

    {

        $query = db_select('member', 'm');

        $query->addField('m', 'id');

        $query->condition('m.email', $data->getEmail());



        $id = $query->execute()->fetchField();

        if(!empty($id)) return $id;



        // Check also for personal email



        // Special requirement: but exclude certain member ids that are set in the config file, because these

        // members have 2 accounts and one of them should not be used to log in



        $excluded_member_ids = array();



        if ( isset($this->config['disable-primary-login-email-for-these-member-ids-during-data-import']) && !empty($this->config['disable-primary-login-email-for-these-member-ids-during-data-import']) ){



            $excluded_member_ids = explode(',', $this->config['disable-primary-login-email-for-these-member-ids-during-data-import']);

        }



        $query = db_select('membermeta', 'm');

        $query->addField('m', 'mid');



        if ($excluded_member_ids)

            $query->condition('m.mid', $excluded_member_ids, 'NOT IN');



        $query->condition('m.metaname', 'email_personal');

        $query->condition('m.value', $data->getEmail());



        $member_id = $query->execute()->fetchField();

        if(empty($member_id)) return '';



        // get id by member id

        $query = db_select('member', 'm');

        $query->addField('m', 'id');

        $query->condition('m.memberid', $member_id);



        $id = $query->execute()->fetchField();

        return $id;

    }



    private function checkForExistingHash(PasswordChange $data)

    {

        $days = (int) variable_get('qmembers_password_recovery', 7);

        $time = time() - (60 * 60 * 24 * $days);

        $query = db_select('member', 'm');

        $query->addField('m', 'id');

        $query->condition('m.password_recovery_hash', $data->getHash());

        $query->condition('m.password_recovery_date', $time, '>=');

        return $query->execute()->fetchField();

    }



    public function doesMemberExist($id) {

        $query = db_select('member', 'm');

        $query->addField('m', 'id');

        $query = $query->condition('m.memberid', $id);

        $exists = $query->execute()->fetchField();

        return $exists;

    }



    public function save(AbstractSerializableEntity $entity)

    {

        $processedData = $this->convertDataToSave($entity);



        foreach ($processedData as $table => $entries) {

            foreach ($entries as $entry) {



                $exists = null;

                if ($table == 'member') {

                    $exists = $this->doesMemberExist($entry['memberid']);

                }



                if ($table == 'membermeta') {

                    $query = db_select($table, 'm');

                    $query->addField('m', 'id');

                    $query = $query->condition('m.mid', $entry['mid']);

                    $query = $query->condition('m.metaname', $entry['metaname']);

                    $query = $query->condition('m.metagroup', $entry['metagroup']);

                    $exists = $query->execute()->fetchField();

                }



                if (!empty($exists)) {

                    db_update($table, array())->fields($entry)->condition('id', $exists)->execute();

                } else {

                    db_insert($table, array())->fields($entry)->execute();

                }

            }

        }

    }



    public function getMember(Login $login)

    {



        $query = db_select('member', 'm');

        $query->fields('m', array('memberid', 'id'));

        $query->condition('m.email', $login->getEmail());

        $member = $query->execute()->fetchAssoc();



        if (empty($member)) {



            // Check if we saved the member id, because the user used his personal email to login

            if (!$login->getMemberID()){

                $this->error = 'Member not found';

                return false;

            }

            else{

                $member['memberid'] = $login->getMemberID();

            }

        }



        $query = db_select('membermeta', 'ma');

        $query->fields('ma');

        $query->condition('ma.mid', $member['memberid']);

        $result = $query->execute();

        while ($row = $result->fetchAssoc()) {

            $member[$row['metaname']] = $row['value'];

        }



        return $member;

    }



    public function getMemberByMemberID($memberid)

    {

        $query = db_select('member', 'm');

        $query->fields('m', array('memberid', 'id'));

        $query->condition('m.memberid', $memberid);

        $member = $query->execute()->fetchAssoc();



        if (empty($member)) {

            $this->error = 'Member not found';

            return false;

        }



        $query = db_select('membermeta', 'ma');

        $query->fields('ma');

        $query->condition('ma.mid', $member['memberid']);

        $result = $query->execute();

        while ($row = $result->fetchAssoc()) {

            $member[$row['metaname']] = $row['value'];

        }



        return $member;

    }



    public function getMembers()

    {

        $members = array();

        $query = db_select('member', 'm');

        $query->fields('m', array('memberid', 'id'));

        $result = $query->execute();

        while ($member = $result->fetchAssoc()) {



            $query = db_select('membermeta', 'ma');

            $query->fields('ma');

            $query->condition('ma.mid', $member['memberid']);

            $resultMeta = $query->execute();

            while ($membermeta = $resultMeta->fetchAssoc()) {

                $member[$membermeta['metaname']] = $membermeta['value'];

            }

            $members[] = $member;

        }



        return $members;

    }



    private function getMetaGroupName($entity)

    {

        $reflect = new ReflectionClass($entity);

        $metaGroupName = $reflect->getShortName();

        return $metaGroupName;

    }



    private function convertDataToSave(AbstractSerializableEntity $entity)

    {

        $processedData = array();

        $data = $entity->jsonSerialize();

        $metaGroup = $this->getMetaGroupName($entity);

        $mapping = $this->getMapping($metaGroup);

        $id = $data['id'];

        unset($data['id']);



        foreach ($data as $fieldName => $value) {

            $metaName = isset($mapping[$fieldName]) ? $mapping[$fieldName] : '';

            if (!empty($metaName)) {



                // special case for password, because it should not be saved in membermeta

                if ($metaName == 'password') {

                    $processedData['member'][] = array(

                        'memberid' => $id,

                        'password' => password_hash($value, PASSWORD_DEFAULT),

                    );

                } else {

                    $processedData['membermeta'][] = array(

                        'mid' => $id,

                        'metaname' => $metaName,

                        'metagroup' => $metaGroup,

                        'value' => $value,

                    );

                }



                // special case if email is saved, because it is also the login email

                if ($metaName == 'email_professional') {

                    $processedData['member'][] = array(

                        'memberid' => $id,

                        'email' => $value,

                    );

                }

            }

        }



        return $processedData;

    }



    private function getMapping($metaGroup)

    {

        if ($metaGroup == 'PersonalData') {

            return $this->mapping->getPersonalData();

        }



        if ($metaGroup == 'BusinessData') {

            return $this->mapping->getBusinessData();

        }



        if ($metaGroup == 'MembershipBilling') {

            return $this->mapping->getMembershipBilling();

        }



        if ($metaGroup == 'MembershipDelivery') {

            return $this->mapping->getMembershipDelivery();

        }



        if ($metaGroup == 'TerminateMembership') {

            return $this->mapping->getTerminateMembership();

        }



        if ($metaGroup == 'Settings') {

            return $this->mapping->getSettings();

        }



        if ($metaGroup == 'Groups') {

            return $this->mapping->getGroups();

        }



        if ($metaGroup == 'Image') {

            return $this->mapping->getImage();

        }



        if ($metaGroup == 'MembershipInfo') {

            return $this->mapping->getMembershipInfo();

        }



        if ($metaGroup == 'MembershipPrimaryEmail') {

            return $this->mapping->getMembershipPrimaryEmail();

        }



        return array();

    }



    /**

     * for data like countries, regions, branches and reasons

     * @param string $table

     * @param string $field

     * @param string $value

     * @return bool

     */

    public function doesMetaExist($table, $field, $value) {

        $query = db_select($table, 't');

        $query->addField('t', $field);

        $query = $query->condition('t.' . $field, $value);

        $exists = $query->execute()->fetchField();

        return empty($exists) ? false : true;

    }



    public function truncateTable($table) {

        db_truncate($table)->execute();

    }



    public function getExpiredMembers()

    {

        $table = 'membermeta';

        $field = 'value';



        $query = db_select($table, 't');

        $query->addField('t', 'mid');

        $query->addField('t', 'value');

        $query = $query->condition('t.metaname', 'membership_until');

        $query = $query->condition('t.' . $field, '', '<>');

        $members = $query->execute()->fetchAll();



        $date = new \DateTime();

        $expiredMembers = array();

        foreach ($members as $member) {

            try {

                $terminationDate = new \DateTime($member->value);

                if ($terminationDate <= $date) {

                    $expiredMembers[$member->mid] = $member->value;

                }

            } catch (\Exception $exception) {

                db_set_active();

                watchdog('qmembers', 'Member ' . $member->mid . ' could not be checked for deletion, because membership_until is no proper date. ("' . $member->value . '")', array(), WATCHDOG_WARNING);

                db_set_active('qmembers');

                continue;

            }



        }

        db_set_active();

        watchdog('qmembers', 'expired: ' . print_r($expiredMembers, true) , array(), WATCHDOG_DEBUG);

        db_set_active('qmembers');



        return $expiredMembers;

    }



    public function deleteMember($memberId)

    {

        db_delete('membermeta')

            ->condition('mid', $memberId)

            ->execute();



        $number = db_delete('member')

            ->condition('memberid', $memberId)

            ->execute();



        return $number > 0 ? true : false;

    }



    /**

     * @param string $table

     * @param string $field

     * @param string $value

     * @return bool

     */

    public function doesSupporterExist($table, $field, $value) {

        $query = db_select($table, 't');

        $query->addField('t', $field);

        $query = $query->condition('t.' . $field, $value);

        $exists = $query->execute()->fetchField();

        return $exists;

    }



    public function getServiceProviders()

    {

        $service_providers = array();

        $query = db_select('service_providers', 'sp');

        $query->fields('sp', array('service_provider_id', 'service_provider_company', 'service_provider_street', 'service_provider_zip', 'service_provider_city', 'service_provider_country', 'service_provider_region', 'service_provider_email', 'service_provider_telephone', 'service_provider_branch'));

        $result = $query->execute();



        while ($row = $result->fetchAssoc()) {

            $service_providers[] = $row;

        }



        return $service_providers;

    }

}

