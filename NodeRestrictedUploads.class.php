<?php



namespace includes\classes\nodes;



use includes\classes\Text;

use includes\classes\Config;

use includes\classes\User;



/**

 * Displays node content

 */

class NodeRestrictedUploads

{

    private $config_class;

    private $config;

    private $text;



    public $countResults = 0;

    public $searchResults;



    /**

     * Constructor function.

     * Gets configurations from Config class and text.

     *

     */

    public function __construct()

    {

        $this->config_class     = new Config;

        $this->config           = $this->config_class->getAll();

        $this->text             = new Text;

    }





    /**

     * Returns the search field for the restricted uploads page

     */

    public function getHTMLrestrictedUploadsSearch($search = '', $filter1 = '', $filter2 = '', $search_page = ''){



        $form_id            = 'qmembers-restricted-uploads-search';

        $qmembers_text      = $this->text;

        $qmembers_config    = $this->config;



        if ( !isset($_POST['request_id']) || $_POST['request_id'] != 'submitRestrictedUploadsSearch' ){



            // No form submitted - Check if there are GET parameters

            if ( isset($_GET[$qmembers_config['list-search-parameter-name']]) )                 $search      = $_GET[$qmembers_config['list-search-parameter-name']];

            if ( isset($_GET[$qmembers_config['list-search-page-name']]) )                      $search_page = $_GET[$qmembers_config['list-search-page-name']];

            if ( isset($_GET[$qmembers_config['restricted-uploads-parameter-name-filter1']]) )  $filter1     = $_GET[$qmembers_config['restricted-uploads-parameter-name-filter1']];

            if ( isset($_GET[$qmembers_config['restricted-uploads-parameter-name-filter2']]) )  $filter2     = $_GET[$qmembers_config['restricted-uploads-parameter-name-filter2']];

        }



        // Sanitize

        $search             = $this->sanitizeSearch($search);

        $filter1            = $this->sanitizeFilter1($filter1);

        $filter2            = $this->sanitizeFilter2($filter2);

        $search_page        = $this->sanitizeSearchPage($search_page);

        if (empty($search_page)) $search_page = 1;



        // Get search results

        $search_results = $this->getRestrictedUploadsSearchResults($search, $filter1, $filter2, $search_page);



        if ($search_results['error']) $this->countResults  = 0;

        else                          $this->countResults  = $search_results['value']['count'];



        // Number of search results (in case it is needed)

        $count      = $this->countResults;



        // Get categories

        $categories = $this->getCategories();



        // Get groups

        $only_subscribed_groups = true;

        $groups     = $this->getGroups($only_subscribed_groups);



        ob_start();

        include QMEMBERS_PATH_FORMS . 'formRestrictedUploadsSearch.php';

        return ob_get_clean();

    }



    /**

     * Returns the upload/download categories

     */

    public function getCategories(){



        // This is the Drupal content type that is being used on all sites for the download categories (added by feature module "fmod_qmembers")

        $content_types   = 'mitgliederseiten_download_kat';



        $categories      = array();

        $nodes           = array();

        $result['error'] = false;



        // Limiting the request, just in case...

        $init_value = 0;

        $max_results = 100;



        // Start Drupal database query

        $query = new \EntityFieldQuery();

        $entities = $query->entityCondition('entity_type', 'node')

            ->propertyCondition('type', $content_types)

            ->propertyCondition('status', 1)

            ->propertyOrderBy('title','ASC')

            ->range($init_value, $max_results)

            ->execute();



        if (!empty($entities['node'])) {

            $node_ids = array_keys($entities['node']);

            $nodes = entity_load('node', $node_ids);

        }



        // Extract category title only

        $i = 0;

        foreach ($nodes as $node){



            $categories[$i]['id'] = $node->nid;
			$categories[$i]['title'] = $node->title;



            $i++;

        }



        return $categories;

    }



    /**

     * Returns the available groups

     */

    public function getGroups($only_subscribed_groups = false){



        // These are the content types which are used by Drupal for the 2 types of groups (regional groups and working groups)

        $content_types = explode(',', $this->config['group_content_types']);



        $groups          = array();

        $nodes           = array();

        $result['error'] = false;



        // Limiting the request, just in case...

        $init_value = 0;

        $max_results = 100;



        // Start Drupal database query

        $query = new \EntityFieldQuery();

        $entities = $query->entityCondition('entity_type', 'node')

            ->propertyCondition('type', $content_types)

            ->propertyCondition('status', 1)

            ->propertyOrderBy('title','ASC')

            ->range($init_value, $max_results)

            ->execute();



        if (!empty($entities['node'])) {

            $node_ids = array_keys($entities['node']);

            $nodes = entity_load('node', $node_ids);

        }



        // Extract group title only

        $i = 0;

        foreach ($nodes as $node){



            // Get group ID  (we allow 5 different group types, but currently all Drupal sites using this module only use 2 group types)

            if (isset ($node->field_group_id_for_qmembers['und'][0]['value']))      $group_id  = trim($node->field_group_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group2_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group2_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group3_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group3_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group4_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group4_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group5_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group5_id_for_qmembers['und'][0]['value']);

            else                                                                    $group_id  = '';



            if ($only_subscribed_groups){



                $NodeGroups = new NodeGroups;

                if ( in_array($group_id, $NodeGroups->subscribed_groups) ){



                    $groups[$i]['title']     = $node->title;

                    $groups[$i]['id']        = $group_id;

                }

            }

            else{

                $groups[$i]['title']     = $node->title;

                $groups[$i]['id']        = $group_id;

            }



            $i++;

        }



        return $groups;

    }




   /* ASIM: GET Landesgruppen GROUPS, start */
   public function getRegionalGroups(){



        // These are the content types which are used by Drupal for the 2 types of groups (regional groups and working groups)

        $content_types = $this->config['group_content_type_regional_groups'];



        $groups          = array();

        $nodes           = array();

        $result['error'] = false;



        // Limiting the request, just in case...

        $init_value = 0;

        $max_results = 100;



        // Start Drupal database query

        $query = new \EntityFieldQuery();

        $entities = $query->entityCondition('entity_type', 'node')

            ->propertyCondition('type', $content_types)

            ->propertyCondition('status', 1)

            ->propertyOrderBy('title','ASC')

            ->range($init_value, $max_results)

            ->execute();



        if (!empty($entities['node'])) {

            $node_ids = array_keys($entities['node']);

            $nodes = entity_load('node', $node_ids);

        }



        // Extract group title only

        $i = 0;

        foreach ($nodes as $node){



            // Get group ID  (we allow 5 different group types, but currently all Drupal sites using this module only use 2 group types)

            if (isset ($node->field_group_id_for_qmembers['und'][0]['value']))      $group_id  = trim($node->field_group_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group2_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group2_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group3_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group3_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group4_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group4_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group5_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group5_id_for_qmembers['und'][0]['value']);

            else                                                                    $group_id  = '';



            if ($only_subscribed_groups){



                $NodeGroups = new NodeGroups;

                if ( in_array($group_id, $NodeGroups->subscribed_groups) ){



                    $groups[$i]['title']     = $node->title;

                    $groups[$i]['id']        = $group_id;

                }

            }

            else{

                $groups[$i]['title']     = $node->title;

                $groups[$i]['id']        = $group_id;

            }



            $i++;

        }



        return $groups;

    }

   /* ASIM: GET  Landesgruppen GROUPS, end */
   
   
     /* ASIM: GET getFachgruppenGroups GROUPS, start */
   public function getWorkGroups(){



        // These are the content types which are used by Drupal for the 2 types of groups (regional groups and working groups)

        $content_types = $this->config['group_content_type_work_groups'];



        $groups          = array();

        $nodes           = array();

        $result['error'] = false;



        // Limiting the request, just in case...

        $init_value = 0;

        $max_results = 100;



        // Start Drupal database query

        $query = new \EntityFieldQuery();

        $entities = $query->entityCondition('entity_type', 'node')

            ->propertyCondition('type', $content_types)

            ->propertyCondition('status', 1)

            ->propertyOrderBy('title','ASC')

            ->range($init_value, $max_results)

            ->execute();



        if (!empty($entities['node'])) {

            $node_ids = array_keys($entities['node']);

            $nodes = entity_load('node', $node_ids);

        }



        // Extract group title only

        $i = 0;

        foreach ($nodes as $node){



            // Get group ID  (we allow 5 different group types, but currently all Drupal sites using this module only use 2 group types)

            if (isset ($node->field_group_id_for_qmembers['und'][0]['value']))      $group_id  = trim($node->field_group_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group2_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group2_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group3_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group3_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group4_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group4_id_for_qmembers['und'][0]['value']);

            elseif (isset ($node->field_group5_id_for_qmembers['und'][0]['value'])) $group_id  = trim($node->field_group5_id_for_qmembers['und'][0]['value']);

            else                                                                    $group_id  = '';



            if ($only_subscribed_groups){



                $NodeGroups = new NodeGroups;

                if ( in_array($group_id, $NodeGroups->subscribed_groups) ){



                    $groups[$i]['title']     = $node->title;

                    $groups[$i]['id']        = $group_id;

                }

            }

            else{

                $groups[$i]['title']     = $node->title;

                $groups[$i]['id']        = $group_id;

            }



            $i++;

        }



        return $groups;

    }

   /* ASIM: GET  getFachgruppenGroups GROUPS, end */
   
   

        /**

     * Return the restricted uploads search results

    */

    public function getHTMLRestrictedUploadsSearchResults($search = '', $filter1 = '', $filter2 = '', $search_page = ''){



        $form_id            = 'qmembers-restricted-uploads-search';

        $qmembers_text      = $this->text;

        $qmembers_config    = $this->config;



        if ( !isset($_POST['request_id']) || $_POST['request_id'] != 'submitRestrictedUploadsSearch' ){



            // No form submitted - Check if there are GET parameters

            if ( isset($_GET[$qmembers_config['list-search-parameter-name']]) )                 $search      = $_GET[$qmembers_config['list-search-parameter-name']];

            if ( isset($_GET[$qmembers_config['list-search-page-name']]) )                      $search_page = $_GET[$qmembers_config['list-search-page-name']];

            if ( isset($_GET[$qmembers_config['restricted-uploads-parameter-name-filter1']]) )  $filter1     = $_GET[$qmembers_config['restricted-uploads-parameter-name-filter1']];

            if ( isset($_GET[$qmembers_config['restricted-uploads-parameter-name-filter2']]) )  $filter2     = $_GET[$qmembers_config['restricted-uploads-parameter-name-filter2']];

        }



        // Sanitize

        $search             = $this->sanitizeSearch($search);

        $filter1            = $this->sanitizeFilter1($filter1);

        $filter2            = $this->sanitizeFilter2($filter2);

        $search_page        = $this->sanitizeSearchPage($search_page);

        if (empty($search_page)) $search_page = 1;



        // Get search results

        $search_results = $this->getRestrictedUploadsSearchResults($search, $filter1, $filter2, $search_page);



        if ($search_results['error']){



            $this->searchResults = '';

            $this->countResults  = 0;

        }

        else{

            $this->searchResults = $search_results['value']['search-results'];

            $this->countResults  = $search_results['value']['count'];

        }



        // Use these variables in the template file

        $count          = $this->countResults;

        $search_results = $this->searchResults;



        // Check if user belongs to content team

        $User = new User;

        $user_belongs_to_content_team = $User->belongsToContentTeam(); // true or false



        ob_start();

        include QMEMBERS_PATH_RESTRICTED_UPLOADS . 'restrictedUploadsSearchResults.php';

        return ob_get_clean();

    }



    /**

     * Get the restricted uploads search results data

     */

    public function getRestrictedUploadsSearchResults($search = '', $filter1 = '', $filter2 = '', $search_page = ''){



        // Get search results

        // Todo: Get search results here (qmembers database request to the respective table for uploaded files)

        // if there is an error and we can't get any results, please set:

        // $result['error'] = true;

        // return $result;



        // Dummy data to show that the form submit works

        if ( empty($search) && empty($filter1) && empty($filter2) ){

            $search_results[0]['dummy-data1'] = 'Dummy Data 1';

            $search_results[0]['dummy-data2'] = 'Dummy Data 2';

            $search_results[0]['dummy-data3'] = 'Dummy Data 3';

            $search_results[0]['dummy-data4'] = 'Dummy Data 4';



            $search_results[1]['dummy-data1'] = 'Dummy Data 1';

            $search_results[1]['dummy-data2'] = 'Dummy Data 2';

            $search_results[1]['dummy-data3'] = 'Dummy Data 3';

            $search_results[1]['dummy-data4'] = 'Dummy Data 4';



            $search_results[2]['dummy-data1'] = 'Dummy Data 1';

            $search_results[2]['dummy-data2'] = 'Dummy Data 2';

            $search_results[2]['dummy-data3'] = 'Dummy Data 3';

            $search_results[2]['dummy-data4'] = 'Dummy Data 4';



            $search_results[3]['dummy-data1'] = 'Dummy Data 1';

            $search_results[3]['dummy-data2'] = 'Dummy Data 2';

            $search_results[3]['dummy-data3'] = 'Dummy Data 3';

            $search_results[3]['dummy-data4'] = 'Dummy Data 4';

        }

        elseif ( empty($search) && (!empty($filter1) || !empty($filter2)) ){

            $search_results[0]['dummy-data1'] = 'Dummy Data 1';

            $search_results[0]['dummy-data2'] = 'Dummy Data 2';

            $search_results[0]['dummy-data3'] = 'Dummy Data 3';

            $search_results[0]['dummy-data4'] = 'Dummy Data 4';



            $search_results[1]['dummy-data1'] = 'Dummy Data 1';

            $search_results[1]['dummy-data2'] = 'Dummy Data 2';

            $search_results[1]['dummy-data3'] = 'Dummy Data 3';

            $search_results[1]['dummy-data4'] = 'Dummy Data 4';

        }

        elseif ( !empty($search) ){

            $search_results[0]['dummy-data1'] = 'Dummy Data 1';

            $search_results[0]['dummy-data2'] = 'Dummy Data 2';

            $search_results[0]['dummy-data3'] = 'Dummy Data 3';

            $search_results[0]['dummy-data4'] = 'Dummy Data 4';

        }

        // End: Dummy data







        // Count search results (just in case we need this later)

        $count = 0;

        if (isset($search_results)) $count = count($search_results);



        // Return search result list

        $result['value']['search-results']  = $search_results;

        $result['value']['count']          = $count;

        return $result;

    }



    /**

     * Return the file upload overlay

     */

    public function getHTMLrestrictedUploadsFileUploadOverlay(){



        $form_id            = 'qmembers-restricted-uploads-file-upload';

        $qmembers_text      = $this->text;

        $qmembers_config    = $this->config;



        // Check if user has file upload permission

        $User = new User;

        $user_has_file_upload_permission = $User->hasFileUploadPermission(); // true or false


       // Current USER ROLE ID, like : user_with_uploads
	   $current_user_rid = $User->getUserRole();

         
		// GET uploader_function_professional        
        $uploader_function_professional = $User->getFunctionProfessional();
   
		
		// GET First Name 
        $uploader_first_name = $User->getFirstNamePersonal();
		
		// GET Last Name 
        $uploader_last_name = $User->getLastNamePersonal();		
   
   
   
   
        // Get categories		

        $categories = $this->getCategories();



        // Get groups

        $only_subscribed_groups = false;

        $groups     = $this->getGroups($only_subscribed_groups);

        $getRegionalGroups     = $this->getRegionalGroups();
		$getWorkGroups     = $this->getWorkGroups();

        ob_start();

        include QMEMBERS_PATH_RESTRICTED_UPLOADS . 'restrictedUploadsFileUploadOverlay.php';

        return ob_get_clean();

    }



    /**

     * Sanitize filter1

     */

    public function sanitizeFilter1($filter1){



        // Sanitize according to the type of search filter that is being used



        $filter1 = filter_var($filter1,FILTER_SANITIZE_STRING);

        if ( strlen($filter1) > 200 ) $filter1 = substr($filter1, 0, 200);



        return $filter1;

    }



    /**

     * Sanitize filter2

     */

    public function sanitizeFilter2($filter2){



        // Sanitize according to the type of search filter that is being used



        $filter2 = filter_var($filter2,FILTER_SANITIZE_STRING);

        if ( strlen($filter2) > 200 ) $filter1 = substr($filter2, 0, 200);



        return $filter2;

    }



    /**

     * Sanitize search

     */

    public function sanitizeSearch($search){



        $search = filter_var ( $search, FILTER_SANITIZE_STRING);

        if ( strlen($search) > 100 ) $search = substr($search, 0, 100);



        return $search;

    }



    /**

     * Sanitize search_page

     */

    public function sanitizeSearchPage($search_page){



        $search_page = filter_var($search_page,  FILTER_SANITIZE_NUMBER_INT);

        return $search_page;

    }



}
