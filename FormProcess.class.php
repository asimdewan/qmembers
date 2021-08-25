<?php





namespace includes\classes;



use includes\classes\nodes\NodeMemberDataMemberlist;

use includes\classes\nodes\NodeRestrictedUploads;



/**

 * Processes all forms

 */

class FormProcess

{



    private $config_class;

    private $config;

    private $text;





    /**

     * Constructor function.

     * Gets configurations from Config class (to be used in this class).

     * Instantiates text class.

     */

    public function __construct()

    {

        $this->config_class = new Config;

        $this->config = $this->config_class->getAll();



        $this->text = new Text;

    }





    /**

     * Processes the login form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the validation result data.

     */

    public function formLoginSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'login';

        $result = $FormValidate->formValidation($form_config_id, $post);



//      if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        }



        // Authenticate user

        $email = $post['email'];

        $password = $post['password'];

        $user = new User;



        $is_authenticated = $user->authenticate($email, $password);



        if ($is_authenticated['error']) {



            $result['value'] = $is_authenticated['value'];

        }

        elseif ($is_authenticated['value'] === false) {



            $result['value'] = $this->text->get('form-login-submit-wrong-login-data');

        }

        elseif ($is_authenticated['value'] === true) {



            $result['redirect_url'] = $this->config['redirect-url-after-login'];

        }

        else {



            $result['error'] = true;

            $result['value'] = $this->text->get('form-login-submit-error');

        }



        return $result;

    }





    /**

     * Processes the password recover form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formPasswordRecoverSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'password-recover';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        $emailPasswordRecover['email']          = $post['email'];

        $user = new User;



        $is_data_saved = $user->passwordRecover($emailPasswordRecover);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-password-recover-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-password-recover'];

            $result['value'] = $this->text->get('form-password-recover-submit-success');

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-password-recover-submit-error');

        }



        return $result;

    }





    /**

     * Processes the password change form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formPasswordChangeSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'password-change';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        // PASSWORDS MATCH CHECK

        if ($post['change_password'] != $post['repeat_change_password']) {

            $result['value']['repeat_change_password'] = $this->text->get('form-member-data-settings-error-mismatch');

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        $passwordChange['change_password']               = $post['change_password'];

        $passwordChange['hash_password_change']          = $post['hash_password_change'];

        $user = new User;



        $is_data_saved = $user->passwordChange($passwordChange);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-password-change-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            $result['redirect_url'] = $this->config['redirect-url-after-password-change'];

            $result['value'] = $this->text->get('form-password-change-submit-success');

            //$result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-password-change-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data personal form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataPersonalSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-personal';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        }



        // get user data from form

        $memberDataPersonal['salutation_personal']          = $post['salutation_personal'];

        $memberDataPersonal['title_personal']               = $post['title_personal'];

        $memberDataPersonal['first_name_personal']          = $post['first_name_personal'];

        $memberDataPersonal['last_name_personal']           = $post['last_name_personal'];

        $memberDataPersonal['birthdate_personal']           = $post['birthdate_personal_day'] . '.' . $post['birthdate_personal_month'] . '.' . $post['birthdate_personal_year'];

        $memberDataPersonal['street_number_personal']       = $post['street_number_personal'];

        $memberDataPersonal['line_personal']                = $post['line_personal'];

        $memberDataPersonal['zip_personal']                 = $post['zip_personal'];

        $memberDataPersonal['city_personal']                = $post['city_personal'];

        $memberDataPersonal['state_personal']               = $post['state_personal'];

        $memberDataPersonal['country_personal']             = $post['country_personal'];

        $memberDataPersonal['email_personal']               = $post['email_personal'];

        $memberDataPersonal['phone_personal']               = $post['phone_personal'];

        $memberDataPersonal['xing_personal']                = $post['xing_personal'];

        $memberDataPersonal['linkedin_personal']            = $post['linkedin_personal'];

        $memberDataPersonal['picture_personal']             = isset($post['picture_personal']) ? $post['picture_personal'] : '';

        $user = new User;



        $is_data_saved = $user->saveMemberDataPersonal($memberDataPersonal);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-personal-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            $result['redirect_url'] = $this->config['redirect-url-after-save-member-data-personal'];

            $result['value'] = $this->text->get('form-member-data-personal-submit-success');

            //$result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-personal-submit-error');

        }



        return $result;

    }



    

    /**

     * Processes the member data professional form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataProfessionalSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-professional';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        }



        // Special validation: professional email cannot be empty if there is no personal email saved

        if ( empty($post['email_professional']) ){



            $user = new User;



            $email_personal = $user->getEmailPersonal();



            if (!$email_personal){

                $result['value']['email_professional'] = $this->text->get('validation--professional-email-cannot-be-empty-if-no-personal-email-is-set');

                $result['value'] = json_encode($result['value']);

                return $result;

            }

        }



        // get user data from form

        $memberDataProfessional['company_professional']         = $post['company_professional'];

        $memberDataProfessional['function_professional']        = $post['function_professional'];

        $memberDataProfessional['department_professional']      = $post['department_professional'];

        $memberDataProfessional['office_number_professional']   = $post['office_number_professional'];

        $memberDataProfessional['street_number_professional']   = $post['street_number_professional'];

        $memberDataProfessional['line_professional']            = $post['line_professional'];

        $memberDataProfessional['zip_professional']             = $post['zip_professional'];

        $memberDataProfessional['city_professional']            = $post['city_professional'];

        $memberDataProfessional['state_professional']           = $post['state_professional'];

        $memberDataProfessional['country_professional']         = $post['country_professional'];

        $memberDataProfessional['email_professional']           = $post['email_professional'];

        $memberDataProfessional['phone_professional']           = $post['phone_professional'];

        $memberDataProfessional['vat_professional']             = $post['vat_professional'];

        $memberDataProfessional['business_professional']        = $post['business_professional'];

        $user = new User;



        $is_data_saved = $user->saveMemberDataProfessional($memberDataProfessional);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-professional-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            $result['redirect_url'] = $this->config['redirect-url-after-save-member-data-professional'];

            $result['value'] = $this->text->get('form-member-data-professional-submit-success');

            //$result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-professional-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data membership form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataMembershipSubmit($post)

    {

        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-membership';



        // User selected "Other" - Skip validation of empty fields

        if ($post['billing_address_membership'] != '3') {



            $form_config_id = 'member-data-membership-no-other-address';



            unset($post['title_membership']);

            unset($post['first_name_membership']);

            unset($post['last_name_membership']);

            unset($post['company_membership']);

            unset($post['department_membership']);

            unset($post['office_number_membership']);

            unset($post['street_number_membership']);

            unset($post['line_membership']);

            unset($post['zip_membership']);

            unset($post['city_membership']);

            unset($post['state_membership'] );

            unset($post['country_membership']);

            unset($post['email_membership']);

            unset($post['phone_membership']);

        }



        $result = $FormValidate->formValidation($form_config_id, $post);



        if (count($result['value']) != 0) {



            $result['value'] = json_encode($result['value']);

            return $result;

        }



        // get user data from form

        $memberDataMembership['billing_address_membership']             = $post['billing_address_membership'];

        if ($post['billing_address_membership'] == '3') {

            $memberDataMembership['title_membership']                   = $post['title_membership'];

            $memberDataMembership['first_name_membership']              = $post['first_name_membership'];

            $memberDataMembership['last_name_membership']               = $post['last_name_membership'];

            $memberDataMembership['company_membership']                 = $post['company_membership'];

            $memberDataMembership['department_membership']              = $post['department_membership'];

            $memberDataMembership['office_number_membership']           = $post['office_number_membership'];

            $memberDataMembership['street_number_membership']           = $post['street_number_membership'];

            $memberDataMembership['line_membership']                    = $post['line_membership'];

            $memberDataMembership['zip_membership']                     = $post['zip_membership'];

            $memberDataMembership['city_membership']                    = $post['city_membership'];

            $memberDataMembership['state_membership']                   = $post['state_membership'];

            $memberDataMembership['country_membership']                 = $post['country_membership'];

            $memberDataMembership['email_membership']                   = $post['email_membership'];

            $memberDataMembership['phone_membership']                   = $post['phone_membership'];

        } 



        $user = new User;



/*

        $result = array();

        $result['value']['billing_address_membership'] = print_r($memberDataMembership);

        $result['value'] = json_encode($result['value']);

        return $result;

*/

        $is_data_saved = $user->saveMemberDataMembership($memberDataMembership);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        }

        else if ($is_data_saved['value'] === false) {



            $result['value'] = $this->text->get('form-member-data-membership-submit-not-saved');

        }

        else if ($is_data_saved['value'] === true) {



            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-membership'];

            $result['value'] = $this->text->get('form-member-data-membership-submit-success');

            $result['reload_page'] = true;

        }

        else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-membership-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data membership primary email form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataMembershipPrimEmailSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-membership-prim-email';



        $result = $FormValidate->formValidation($form_config_id, $post);



        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        }



        $memberDataMembership['prim_email_membership'] = $post['prim_email_membership'];

        $user = new User;



        $is_data_saved = $user->saveMemberDataMembershipPrimaryEmail($memberDataMembership);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-membership-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-membership'];

            $result['value'] = $this->text->get('form-member-data-membership-submit-success');

            $result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-membership-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data membership press form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataMembershipPressSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-membership-press';



        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        $memberDataMembership['press_magazine_membership'] = $post['press_magazine_membership'];



        // Transform it to integer so that RabbitMQ validation doesn't fail

        $memberDataMembership['press_magazine_membership'] = intval($memberDataMembership['press_magazine_membership']);



        $user = new User;



        $is_data_saved = $user->saveMemberDataMembershipPress($memberDataMembership);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-membership-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-membership'];

            $result['value'] = $this->text->get('form-member-data-membership-submit-success');

            $result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-membership-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data termination form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataTerminationSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-termination';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        // get user data from form

        $memberDataTermination['reason_termination']          = $post['reason_termination'];

        $memberDataTermination['message_termination']         = $post['message_termination'];

        $user = new User;



        $is_data_saved = $user->saveMemberDataTermination($memberDataTermination);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-termination-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            $result['redirect_url'] = $this->config['redirect-url-after-save-member-data-termination'];

            $result['value'] = $this->text->get('form-member-data-termination-submit-success');

            //$result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-termination-submit-error');

        }



        return $result;

    }





    /**

     * Processes the member data settings form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataSettingsSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-settings';

        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        // PASSWORDS MATCH CHECK

        if ($post['password_new_settings'] != $post['password_new_repeat_settings']) {

            $result['value']['password_new_repeat_settings'] = $this->text->get('form-member-data-settings-error-mismatch');

            $result['value'] = json_encode($result['value']);

            return $result;

        } 



        // get user data from form

        $memberDataSettings['password_old_settings']          = $post['password_old_settings'];

        $memberDataSettings['password_new_settings']          = $post['password_new_settings'];

        $user = new User;



        $is_data_saved = $user->saveMemberDataSettings($memberDataSettings);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-settings-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-settings'];

            $result['value'] = $this->text->get('form-member-data-settings-submit-success');

            $result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-settings-submit-error');

        }



        return $result;

    }





    /**

     * Processes the memberlist search form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formMemberDataMemberlistSubmit($post)

    {



        // Validate form

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-memberlist';



        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

//            echo $result['value'];

//            return;

            return $result;

        } 



//        $nodeMemberDataMemberlist = new NodeMemberDataMemberlist;

//        $nodeMemberDataMemberlist->memberDataMemberlistResults($post['search_memberlist']);

        $result['value'] = $this->text->get('form-member-data-memberlist-submit-success');

        $result['redirect_url'] = $this->config['url-member-data-memberlist'].'?'.$this->config['list-search-parameter-name'].'='.$post['search_memberlist'];

        return $result;

    }



    /**

     * Processes the memberlist search form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formPersonalPictureSubmit($post)

    {

        if ( !isset($post['picture_personal']) ) {

            $result['value'] = $this->text->get('no-personal-picture-sent-via-ajax');

            return $result['value'];

        }



        // only original image needs to be validated

        $type = $this->getFileType($post['original_picture_personal']);

        $size = $this->getFileSize($post['original_picture_personal']);



        $fileData = array(

            'type' => $type,

            'size' => $size,

        );



        $FormValidate = new FormValidate;

        $form_config_id = 'form-personal-picture';



        $result = $FormValidate->formValidation($form_config_id, $fileData);



        if (count($result['value']) != 0) {



            $image_fields_validation_failed = $result['value'];

            $result = array();

            $result['value'] = '';



            foreach ($image_fields_validation_failed as $key=>$value){



                $result['value'] .= $this->text->get('validation--personal-image-' . $key . '-failed') . PHP_EOL;

            }



            return $result;

        }



        // Save image file

        $User        = new User;

        $result      = $User->setPersonalPicture($post);



        if ( isset($result['image_url']) ) $result = json_encode($result);



        return $result;

    }











    

    /**

     * Processes the member Groups Join form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formGroupsJoinSubmit($post)

    {



        // Validate form

/* NO VALIDATE FOR NOW

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-membership-press';



        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 

*/

        $groupsJoinSubmit['group_id']          = $post['group_id'];

        $user = new User;



        $is_data_saved = $user->subscribeMemberGroup($groupsJoinSubmit);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-membership-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-membership'];

            $result['value'] = $this->text->get('form-member-data-membership-submit-success');

            $result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-membership-submit-error');

        }



        return $result;

    }



   

    /**

     * Processes the member Groups Leave form submission

     *

     * @param array $post       Contains posted data (may also contain other data, not only form data, e.g. request_id)

     * @return array            Contains the modification of member data result data.

     */

    public function formGroupsLeaveSubmit($post)

    {



        // Validate form

/* NO VALIDATE FOR NOW

        $FormValidate = new FormValidate;

        $form_config_id = 'member-data-membership-press';



        $result = $FormValidate->formValidation($form_config_id, $post);

            

        //if (!empty($result['value'])) return $result;

        if (count($result['value']) != 0) {

            $result['value'] = json_encode($result['value']);

            return $result;

        } 

*/

        $groupsLeaveSubmit['group_id']          = $post['group_id'];

        $user = new User;



        $is_data_saved = $user->unsubscribeMemberGroup($groupsLeaveSubmit);



        if (isset($is_data_saved['error']) && $is_data_saved['error']) {

            $result['value'] = $is_data_saved['value'];

        } else if ($is_data_saved['value'] === false) {

            $result['value'] = $this->text->get('form-member-data-membership-submit-not-saved');

        } else if ($is_data_saved['value'] === true) {

            //$result['redirect_url'] = $this->config['redirect-url-after-save-member-data-membership'];

            $result['value'] = $this->text->get('form-member-data-membership-submit-success');

            $result['reload_page'] = true;

        } else {

            $result['error'] = true;

            $result['value'] = $this->text->get('form-member-data-membership-submit-error');

        }



        return $result;

    }



    private function getFileType($data)

    {

        list($type, $data) = explode(';', $data);

        return str_replace('data:', '', $type);

    }



    private function getFileSize($data)

    {

        return strlen(base64_decode($data));

    }



    /**

     * Handles the search request on the restricted uploads page

     *

     * @return string        Contains search results as html.

     *

     */

    public function submitRestrictedUploadsSearch(){

 
        $search         = $_POST['search'];

        $filter1        = $_POST['filter1'];

        $filter2        = $_POST['filter2'];

        $search_page    = $_POST['search_page'];



        $NodeRestrictedUploads = new NodeRestrictedUploads;

        $result = $NodeRestrictedUploads->getHTMLRestrictedUploadsSearchResults($search, $filter1, $filter2, $search_page);



        return $result;

    }
	
	/* Uploading DELETE Process START */
	public function submitRestrictedUploadsDelete(){
	   // Validate form 
	   
        $FormValidate   = new FormValidate;
        $form_config_id = 'restricted-uploads-delete';
        $post           = $_POST;
		$result         = $FormValidate->formValidation($form_config_id, $post);
		if (count($result['value']) != 0) {
            // Validation error found
            $result['value'] = 'Can not be deleted';
			return $result;
        }
		else{
          $hidden_doc_id         = $_POST['hidden_doc_id']; // ID of the document to be deleted    file_name   file_id
		  $hidden_doc_id = intval($hidden_doc_id);
		  /* DELETE DOCUMENT NOW START*/
		  db_set_active('qmembers');
		  $delete_able_doc_arr = db_select('uploads', 'n')
				->fields('n')
				->condition('file_id',$_POST['hidden_doc_id'],'=')
				->execute()
				->fetchAll();	
           if($delete_able_doc_arr){
		    if(count($delete_able_doc_arr)>0){
				  foreach($delete_able_doc_arr as $delete_able_doc_arr_obj){
					$delete_able_doc_arr_obj_file_name = $delete_able_doc_arr_obj->file_name;
				  }		
			  }
		  }
		  unlink($_SERVER['DOCUMENT_ROOT'].'/sites/default/files/qmembers/user_uploads/'.$delete_able_doc_arr_obj_file_name);
		  db_delete('uploads')
		  ->condition('file_id', $hidden_doc_id)
		  ->execute();
		  return 'Deleted Successfully!';
		  db_set_active();	
		  /* DELETE DOCUMENT NOW END*/		  
		}
        
    }
	/* Uploading DELETE Process END */	
	
	
	/* Uploading submitRestrictedUploadsUploading START */
	public function submitRestrictedUploadsUploading(){



        // Validate form

        $FormValidate   = new FormValidate;

        $form_config_id = 'restricted-uploads-uploading';

        $post           = $_POST;



        $result         = $FormValidate->formValidation($form_config_id, $post);

        if (count($result['value']) != 0) {
            // Validation error found
            // In case of the search form, we don't need to display validation messages
            //$result['value'] = json_encode($result['value']);

            // Just mention that the results couldn't be displayed
            $result['value'] = $this->text->get('error-search-results-cannot-be-displayed');
            //return 'asimdewavs';
        }

        // Prepare Uploading Data

        $file_id                                 = NULL;

        $browse_file                             = $_POST['browse_file'];

        $upload_doc_file_name                    = $_POST['upload_doc_file_name'];

        $file_category                           = $_POST['file_category'];
		
		
		
		if(isset($_POST['access_user_roles'])){
          $access_user_roles                       = implode(',',$_POST['access_user_roles']);		
		}
		else{
		  $access_user_roles = "";
		}
		
		
		if(isset($_POST['access_regional_groups'])){
          $access_regional_groups                  = implode(',',$_POST['access_regional_groups']);	
		}
		else{
		  $access_regional_groups = "";
		}
		
		if(isset($_POST['access_work_groups'])){
          $access_work_groups                      = implode(',',$_POST['access_work_groups']);	
		}
		else{
		  $access_work_groups = "";
		}
		
        $uploder_first_name                      = $_POST['uploder_first_name'];
		
        $uploder_last_name                       = $_POST['uploder_last_name'];
		
        $uploder_funct_prof                       = $_POST['uploder_funct_prof'];
		
        $uploader_user_role                       = $_POST['uploader_user_role'];
		
		$upload_date 							  = date('d-m-Y');	
		
		$upload_timestamp 						  = strtotime(date('d-m-Y'));
		
		$drag_drop_doc_source_target              = $_POST['drag_drop_doc_source_target'];
		
		$uploader_MemberId                        = $_POST['uploader_MemberId'];
		
		/* Final File Name START*/
		$drag_drop_doc_source_target_arr = explode('====',$drag_drop_doc_source_target);
        $drag_drop_doc_source = $drag_drop_doc_source_target_arr[1];
		$drag_drop_doc_source_arr = explode('/',$drag_drop_doc_source);		
		$drag_drop_doc_source_name = $drag_drop_doc_source_arr[count($drag_drop_doc_source_arr)-1];	 // File Name Which Is with Uploaded By User			
		
		$mix_real_file_name = $drag_drop_doc_source_name;
		$mix_real_file_name_arr = explode('***',$mix_real_file_name);
		
		$original_file_name = $mix_real_file_name_arr[1];
		
		$original_file_name_arr = explode('.',$original_file_name);
		$original_file_name_extension = $original_file_name_arr[count($original_file_name_arr)-1]; // Uploaded File Extension
		if(empty($upload_doc_file_name)){
		  $final_file_name = $original_file_name;
		}
		else{
		  $final_file_name = $upload_doc_file_name.'.'.$original_file_name_extension;
		}		
		/* Final File Name START*/
		
		
		$old_file_name = $_SERVER['DOCUMENT_ROOT'].'/sites/default/files/qmembers/user_uploads/'.$uploader_MemberId.'***'.$original_file_name;
		$new_file_name = $_SERVER['DOCUMENT_ROOT'].'/sites/default/files/qmembers/user_uploads/'.$final_file_name;
		if(file_exists($new_file_name)){
		  $new_file_name = $_SERVER['DOCUMENT_ROOT'].'/sites/default/files/qmembers/user_uploads/'.$final_file_name.'_'.date('his').'.'.$original_file_name_extension;
		}
		
									
        if(!isset($drag_drop_doc_source_target)){
		  return 'Please upload file, first';
		}
		else{
		  /* Do Uploading now START*/
		  $new_file_name_db_arr = explode('/',$new_file_name);
		  $new_file_name_db_final = $new_file_name_db_arr[count($new_file_name_db_arr)-1];
		   db_set_active('qmembers');
		   $id_file_upload_inserted = db_insert('uploads')->fields(array(
			  'file_id' => NULL,
			  'file_name' => $new_file_name_db_final,
			  'file_category' => $file_category,
			  'access_user_roles' => $access_user_roles,
			  'access_regional_groups' => $access_regional_groups,
			  'access_work_groups' => $access_work_groups,
			  'uploader_first_name' => $uploder_first_name,
			  'uploader_last_name' => $uploder_last_name,
			  'uploader_function_professional' => $uploder_funct_prof,
			  'uploader_user_role' => $uploader_user_role,
			  'upload_date' => $upload_date,
			  'upload_timestamp' => $upload_timestamp       
			))
			->execute();
		  db_set_active();	 
		  $id_file_upload_inserted = intval($id_file_upload_inserted);
		  if($id_file_upload_inserted>0){
	        rename($old_file_name,$new_file_name);
		    return 'Uploaded Successfully!';

		  }
		  else{
		    
		  }
		  /* Do Uploading now END*/		  
		}


		

    }
	/* Uploading submitRestrictedUploadsUploading END */

}
