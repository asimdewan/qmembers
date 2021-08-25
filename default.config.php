<?php



global $qmembers_config;





// ------------------------------------------------------------------------------------

// Environment

// ------------------------------------------------------------------------------------



$qmembers_config['server-name-live-site']                           = 'bdp-net.de';



// Will automatically be overwritten with "live" on live site

$qmembers_config['environment']                                     = 'dev_matt';  // dev_matt, dev_ric, dev_mel, dev_kers





// ------------------------------------------------------------------------------------

// Drupal content types

// ------------------------------------------------------------------------------------

$qmembers_config['content-type-for-member-sites'] 			        = 'mitgliederseiten';





// ------------------------------------------------------------------------------------

// Drupal theme

// ------------------------------------------------------------------------------------

$qmembers_config['drupal-theme-in-use'] 			                = 'bdptheme';





// ------------------------------------------------------------------------------------

// Protect content

// ------------------------------------------------------------------------------------

$qmembers_config['non-protected-page-templates'] 			        = 'login'; // format: comma separated





// ------------------------------------------------------------------------------------

// Drupal IDs

// ------------------------------------------------------------------------------------

// Use drupal ids according to local environment

// Set drupal ids and templates to use



$qmembers_page = 'login';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7924';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6740';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6762';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6719';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6719';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'login';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'login';



$qmembers_page = 'password-recover';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7925';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6791';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6781';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6790';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6783';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'login';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'password-recover';



$qmembers_page = 'password-change';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7926';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6792';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6782';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6784';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'login';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'password-change';



$qmembers_page = 'member-data-personal';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7927';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6738';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6766';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6720';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6720';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'member-data-personal';



$qmembers_page = 'member-data-professional';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7928';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6762';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6773';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6721';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6721';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'member-data-professional';



$qmembers_page = 'member-data-membership';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7929';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6772';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6774';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6722';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6722';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'member-data-membership';



$qmembers_page = 'member-data-settings';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7930';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6773';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6776';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6723';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6723';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'member-data-settings';



$qmembers_page = 'member-data-memberlist';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7933';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6783';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6779';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6788';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6787';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'member-data-memberlist';



$qmembers_page = 'groups';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7931';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6776';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '6793';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6789';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6793';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'groups';



$qmembers_page = 'corporate-benefits';

$qmembers_config['page'][$qmembers_page]['id_source']['live']       = '7934';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_matt']   = '6796';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_ric']    = '';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_mel']    = '';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_kers']   = '';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7934';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6796';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'corporate-benefits';



/*

$qmembers_page = 'app';

$qmembers_config['page'][$qmembers_page]['id_source']['live']       = '5948';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_matt']   = '5948';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_ric']    = '5948';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_mel']    = '5948';

$qmembers_config['page'][$qmembers_page]['id_source']['dev_kers']   = '5948';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7094';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6795';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'app';

*/



$qmembers_page = 'downloads';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7935';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6797';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '6795';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'downloads';



$qmembers_page = 'service-provider';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7936';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6799';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '6799';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'service-provider';



$qmembers_page = 'group-details';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '7932';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6810';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'group-details';



$qmembers_page = 'restricted-uploads';

$qmembers_config['page'][$qmembers_page]['id']['live']		        = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_matt']		    = '6953';

$qmembers_config['page'][$qmembers_page]['id']['dev_ric']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_mel']		    = '';

$qmembers_config['page'][$qmembers_page]['id']['dev_kers']		    = '';

$qmembers_config['page'][$qmembers_page]['template']['page']		= 'default';

$qmembers_config['page'][$qmembers_page]['template']['node']		= 'restricted-uploads';



// ------------------------------------------------------------------------------------

// Membership level excluded from login

// ------------------------------------------------------------------------------------

$qmembers_config['membership-levels-that-are-not-allowed-to-login'] = 'Fördermitglied';  // Comma separated list



// ------------------------------------------------------------------------------------

// Members with primary login email disabled (because they have 2 accounts with the same email)

// ------------------------------------------------------------------------------------

$qmembers_config['disable-primary-login-email-for-these-member-ids-during-data-import'] = '';  // Comma separated list



// ------------------------------------------------------------------------------------

// List settings

// ------------------------------------------------------------------------------------



// General setting for max number of results for lists

$qmembers_config['list-search-max-results']                         = 15;



// Groups

$qmembers_config['group_content_types']		                        = 'fachgruppen,landesgruppen';

$qmembers_config['group_content_type_work_groups']		            = 'fachgruppen';

$qmembers_config['group_content_type_regional_groups']		        = 'landesgruppen';



$qmembers_config['summary_length_groups']		                    = 300;

$qmembers_config['max_results_groups']		                        = 25;



// Service providers

$qmembers_config['max_results_service_providers']		            = 15;



// ------------------------------------------------------------------------------------

// Group details settings

// ------------------------------------------------------------------------------------

$qmembers_config['image-style-for-group-contact-person-image']                  = 'personen_90x120';



// Field names to identify contact person data



// These names vary per content type and per drupal system

// Please enter the field names for "Fachgruppen" and "Landesgruppen" of this Drupal system

// Format: 2 field names, comma separated

$qmembers_config['drupal-field-names-for-contact-person-description-of-groups'] = 'field_ansprech_beschreibung,field_beschreibung';

$qmembers_config['drupal-field-names-for-contact-person-details-of-groups']     = 'field_ansprech_person,field_person';



// ------------------------------------------------------------------------------------

// Profile image settings

// ------------------------------------------------------------------------------------

$qmembers_config['max-image-size-picture-personal']		            = 20; // MB

$qmembers_config['allowed-image-types-picture-personal']            = 'jpg/jpeg/png';

$qmembers_config['crop-image-width-with-imagick']                   = false;

$qmembers_config['max-image-crop-width-picture-personal']		    = 1024; //px



// ------------------------------------------------------------------------------------

// Corporate Benefits

// ------------------------------------------------------------------------------------

$qmembers_config['corporate-benefits-base-url']		                = 'https://bdp.rahmenvereinbarungen.de/';

$qmembers_config['corporate-benefits-token']		                = 'Ft54R%d-120f';



// ------------------------------------------------------------------------------------

// Membership termination period

// ------------------------------------------------------------------------------------

$qmembers_config['membership-termination-period-in-months']		    = 6;



// ------------------------------------------------------------------------------------

// Restricted uploads settings

// ------------------------------------------------------------------------------------

$qmembers_config['user-roles-with-upload-permission']		        = 'user_with_uploads,content_team';

$qmembers_config['user-roles-belonging-to-content-team']		    = 'content_team';



// ------------------------------------------------------------------------------------

// URL parameter

// ------------------------------------------------------------------------------------



// Password change - parameter name

$qmembers_config['hash-password-change-parameter-name']             = 'code';



// View option - parameter name

$qmembers_config['view-option-parameter-name']                      = 'bearbeiten';



// Search - parameter name

$qmembers_config['list-search-parameter-name']                      = 'suchen';



// Page - parameter name

$qmembers_config['list-search-page-name']                           = 'seite';



// Groups filter - parameter name

$qmembers_config['groups-filter-parameter-name']                    = 'filter';



// Service provider filter 1 - parameter name

$qmembers_config['service-provider-parameter-name-filter1']         = 'filter1';



// Service provider filter 2 - parameter name

$qmembers_config['service-provider-parameter-name-filter2']         = 'filter2';



// Group details page --> group id - parameter name

$qmembers_config['group-details-parameter-name-group-id']           = 'gruppe';



// Restricted uploads filter 1 - parameter name

$qmembers_config['restricted-uploads-parameter-name-filter1']         = 'filter1';



// Restricted uploads filter 2 - parameter name

$qmembers_config['restricted-uploads-parameter-name-filter2']         = 'filter2';



// Termination parameter name

//$qmembers_config['termination-parameter-name']                      = 'kuendigung';





// ------------------------------------------------------------------------------------

// URLS

// ------------------------------------------------------------------------------------

// ID to identify member sites by their url

$qmembers_config['member-sites-url-path-parent']                    = 'mitgliederseiten';



// Login Url

$qmembers_config['login-url']                                       = QMEMBERS_HOME_URL . 'mitgliederseiten/mitglieder-login';



// Logout Url

$qmembers_config['logout-url']                                      = QMEMBERS_HOME_URL . 'mitgliederseiten/mitglieder-login?aktion=logout';



// Redirect url after login

$qmembers_config['redirect-url-after-login']                        = QMEMBERS_HOME_URL . 'mitgliederseiten/persoenliche-daten';



// Redirect url after logout

$qmembers_config['redirect-url-after-logout']                       = QMEMBERS_HOME_URL . 'mitgliederseiten/mitglieder-login';



// Redirect url after password recover

$qmembers_config['redirect-url-after-password-recover']             = QMEMBERS_HOME_URL . 'mitgliederseiten/mitglieder-login';



// Redirect url after password change

$qmembers_config['redirect-url-after-password-change']              = QMEMBERS_HOME_URL . 'mitgliederseiten/mitglieder-login?aktion=logout';



// Redirect url after save member personal data

$qmembers_config['redirect-url-after-save-member-data-personal']    = QMEMBERS_HOME_URL . 'mitgliederseiten/persoenliche-daten';



// Redirect url after save member professional data

$qmembers_config['redirect-url-after-save-member-data-professional']= QMEMBERS_HOME_URL . 'mitgliederseiten/berufliche-daten';



// Redirect url after termination data

$qmembers_config['redirect-url-after-save-member-data-termination'] = QMEMBERS_HOME_URL . 'mitgliederseiten/mitgliedschaft';



// Url to member personal data

$qmembers_config['url-member-data-personal']                        = QMEMBERS_HOME_URL . 'mitgliederseiten/persoenliche-daten';



// Url to member professional data

$qmembers_config['url-member-data-professional']                    = QMEMBERS_HOME_URL . 'mitgliederseiten/berufliche-daten';



// Url to member membership data

$qmembers_config['url-member-data-membership']                      = QMEMBERS_HOME_URL . 'mitgliederseiten/mitgliedschaft';



// Url to member settings data

$qmembers_config['url-member-data-settings']                        = QMEMBERS_HOME_URL . 'mitgliederseiten/einstellungen';



// Url to member list

$qmembers_config['url-member-data-memberlist']                      = QMEMBERS_HOME_URL . 'mitgliederseiten/mitgliederliste';



// Url to groups

$qmembers_config['url-member-data-groups']                          = QMEMBERS_HOME_URL . 'mitgliederseiten/gruppen';



// Url to group details page

$qmembers_config['url-group-details']                               = QMEMBERS_HOME_URL . 'mitgliederseiten/gruppendetails';



// Url to service providers

$qmembers_config['url-service-provider']                            = QMEMBERS_HOME_URL . 'mitgliederseiten/dienstleisterverzeichnis';



// Url to password recover

$qmembers_config['url-password-recover']                            = QMEMBERS_HOME_URL . 'mitgliederseiten/passwort-wiederherstellung';



// Url to password change

$qmembers_config['url-password-change']                             = QMEMBERS_HOME_URL . 'mitgliederseiten/passwortaenderung?' . $qmembers_config['hash-password-change-parameter-name'] . '=';





// ------------------------------------------------------------------------------------

// Email

// ------------------------------------------------------------------------------------

$qmembers_config['email-membership-services']                       = 'mitgliederservice@pressesprecherverband.de';





// Passwort recovery



// From email password recover

$qmembers_config['email-password-recover-from']                     = 'mitgliederservice@pressesprecherverband.de';



// From name email password recover

$qmembers_config['email-password-recover-from_name']                = 'BdP';



// Reply email password recover

$qmembers_config['email-password-recover-reply_to']                 = 'mitgliederservice@pressesprecherverband.de';



// Subject email password recover

$qmembers_config['email-password-recover-subject']                  = 'BdP - Passwort-Wiederherstellung';



// BCC email password recover

$qmembers_config['email-password-recover-bcc']                      = '';





// Membership termination



// To

$qmembers_config['email-membership-termination-to']                 = 'mitgliederservice@pressesprecherverband.de';



$qmembers_config['email-membership-termination-from']               = 'mitgliederservice@pressesprecherverband.de';



// From name

$qmembers_config['email-membership-termination-from_name']          = 'BdP';



// Reply to

$qmembers_config['email-membership-termination-reply_to']           = 'mitgliederservice@pressesprecherverband.de';



// Subject

$qmembers_config['email-membership-termination-subject']            = 'BdP-Kündigung';



// BCC

$qmembers_config['email-membership-termination-bcc']                = '';





// ------------------------------------------------------------------------------------

// CSS

// ------------------------------------------------------------------------------------



// Clear out all previous CSS on member sites and start fresh

$qmembers_config['reset_all_drupal_css_on_member_sites'] 	        = true;



// Use css normalization before applying styles

$qmembers_config['normalize_css_on_member_sites']                   = true;





// ------------------------------------------------------------------------------------

// Session

// ------------------------------------------------------------------------------------



// Session data

$qmembers_config['session']['name']                                 = 'qmembers';

$qmembers_config['session']['httponly']                             = true;

$qmembers_config['session']['path']                                 = '/';

$qmembers_config['session']['domain']                               = ''; // Enter only if it should not be the current domain - per default it´s: $_SERVER['SERVER_NAME']

$qmembers_config['session']['time']                                 = 3600; // = 1 Std.





// ------------------------------------------------------------------------------------

// RabbitMQ Config

// ------------------------------------------------------------------------------------



$qmembers_config['rabbitmq']['read']['enable']          = variable_get('qmembers_rabbitmq_read_enable', FALSE);

$qmembers_config['rabbitmq']['write']['enable']         = variable_get('qmembers_rabbitmq_write_enable', FALSE);



if (variable_get('qmembers_rabbitmq_environment', 'dev') == 'live') {

    // Live/Staging Schnittstelle

    $qmembers_config['rabbitmq']['write']['host']       = variable_get('qmembers_rabbitmq_live_host', '');

    $qmembers_config['rabbitmq']['write']['port']       = variable_get('qmembers_rabbitmq_live_port', '');

    $qmembers_config['rabbitmq']['read']['host']        = variable_get('qmembers_rabbitmq_live_host', '');

    $qmembers_config['rabbitmq']['read']['port']        = variable_get('qmembers_rabbitmq_live_port', '');

} else {

    // Testschnittstelle

    $qmembers_config['rabbitmq']['write']['host']       = variable_get('qmembers_rabbitmq_dev_host', '');

    $qmembers_config['rabbitmq']['write']['port']       = variable_get('qmembers_rabbitmq_dev_port', '');

    $qmembers_config['rabbitmq']['read']['host']        = variable_get('qmembers_rabbitmq_dev_host', '');

    $qmembers_config['rabbitmq']['read']['port']        = variable_get('qmembers_rabbitmq_dev_port', '');

}



$qmembers_config['rabbitmq']['write']['user']           = variable_get('qmembers_rabbitmq_write_user', '');

$qmembers_config['rabbitmq']['write']['password']       = variable_get('qmembers_rabbitmq_write_password', '');

$qmembers_config['rabbitmq']['write']['queue']          = variable_get('qmembers_rabbitmq_write_queue', '');

$qmembers_config['rabbitmq']['write']['routing_key']    = variable_get('qmembers_rabbitmq_write_routing_key', '');

$qmembers_config['rabbitmq']['write']['exchange']       = variable_get('qmembers_rabbitmq_write_exchange', '');

$qmembers_config['rabbitmq']['write']['vhost']          = variable_get('qmembers_rabbitmq_write_vhost', '');

$qmembers_config['rabbitmq']['write']['certificate']    = __DIR__ . '/includes/classes/RabbitMqClient/Cert/cacert.pem';



$qmembers_config['rabbitmq']['read']['user']            = variable_get('qmembers_rabbitmq_read_user', '');

$qmembers_config['rabbitmq']['read']['password']        = variable_get('qmembers_rabbitmq_read_password', '');

$qmembers_config['rabbitmq']['read']['queue']           = variable_get('qmembers_rabbitmq_read_queue', '');

$qmembers_config['rabbitmq']['read']['routing_key']     = variable_get('qmembers_rabbitmq_read_routing_key', '');

$qmembers_config['rabbitmq']['read']['exchange']        = variable_get('qmembers_rabbitmq_read_exchange', '');

$qmembers_config['rabbitmq']['read']['vhost']           = variable_get('qmembers_rabbitmq_read_vhost', '');

$qmembers_config['rabbitmq']['read']['certificate']     = __DIR__ . '/includes/classes/RabbitMqClient/Cert/cacert.pem';

$qmembers_config['rabbitmq']['read']['timeout']         = 10;  // in seconds





// ------------------------------------------------------------------------------------

// Add PHP variables to Drupal JS

// ------------------------------------------------------------------------------------

// JS variable names will only use underscores (if "-" was used here, class PHPVarsToDrupalJS will change it to "_" for js)

// JS variables can be used like this, for example: Drupal.settings.qmembers.list_search_parameter_name



$qmembers_config['php-var-to-js'] = array();

$qmembers_config['php-var-to-js']['list_search_parameter_name']              = $qmembers_config['list-search-parameter-name'];

$qmembers_config['php-var-to-js']['service_provider_parameter_name_filter1'] = $qmembers_config['service-provider-parameter-name-filter1'];

$qmembers_config['php-var-to-js']['service_provider_parameter_name_filter2'] = $qmembers_config['service-provider-parameter-name-filter2'];





// ------------------------------------------------------------------------------------

// Other Settings

// ------------------------------------------------------------------------------------

// Remove the VAT field if it should not be displayed

$qmembers_config['display-vat-professional-field'] = false;



// Show membership termination form or info text instead

$qmembers_config['display-membership-termination-form'] = true;





// ------------------------------------------------------------------------------------

// Form validation

// ------------------------------------------------------------------------------------



// Password settings - to be used below

$qmembers_config['password_validation_settings'] = array(



    'required'              => true,

    'min_len'               => 6,

    'max_len'               => 20,

    'alpha_numeric_dash'    => true,

);



// Login

$qmembers_config['form']['login']['email'] = array(



    'required'              => true,

    'valid_email'           => true,

);



$qmembers_config['form']['login']['password'] = $qmembers_config['password_validation_settings'];



// Personal member data



$qmembers_config['form']['member-data-personal']['salutation_personal'] = array(



    'required'               => true,

    'contains_list'          => 'Weiblich;Männlich',

);



$qmembers_config['form']['member-data-personal']['title_personal'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-personal']['first_name_personal'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-personal']['last_name_personal'] = array(



    'required'   => true,

    'max_len' => 50,

);





$qmembers_config['form']['member-data-personal']['birthdate_personal_day'] = array(



    'required'               => true,

    'contains_list'          => '1;2;3;4;5;6;7;8;9;10;11;12;13;14;15;16;17;18;19;20;21;22;23;24;25;26;27;28;29;30;31',

);



$qmembers_config['form']['member-data-personal']['birthdate_personal_month'] = array(



    'required'               => true,

    'contains_list'          => '1;2;3;4;5;6;7;8;9;10;11;12',

);



$qmembers_config['form']['member-data-personal']['birthdate_personal_year'] = array(



    'required'              => true,

    'max_len'               => 4,

    'integer'               => true,

    'doesnt_contain_list'   => date('Y', time() ),

);





$qmembers_config['form']['member-data-personal']['street_number_personal'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-personal']['line_personal'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-personal']['zip_personal'] = array(



    'required'              => true,

    'max_len'               => 10,

);



$qmembers_config['form']['member-data-personal']['city_personal'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-personal']['state_personal'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-personal']['country_personal'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-personal']['email_personal'] = array(



    'required'              => true,

    'valid_email'           => true,

);



$qmembers_config['form']['member-data-personal']['phone_personal'] = array(



    'required'              => true,

    'phone_international'   => true,

);



$qmembers_config['form']['member-data-personal']['xing_personal'] = array(



    'required'              => false,

    'max_len'               => 255,

    'valid_url'             => true,

);



$qmembers_config['form']['member-data-personal']['linkedin_personal'] = array(



    'required'              => false,

    'max_len'               => 255,

    'valid_url'             => true,

);





// Personal Picture (Validating separately)



$qmembers_config['form']['form-personal-picture']['type'] = array(



    'required'   => true,

    'image_type' => $qmembers_config['allowed-image-types-picture-personal'], // format: jpg/jpeg/png

);



$qmembers_config['form']['form-personal-picture']['size'] = array(



    'required'   => true,

    'file_size'  => $qmembers_config['max-image-size-picture-personal'], // MB

);





// Professional member data

$qmembers_config['form']['member-data-professional']['company_professional'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['function_professional'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['department_professional'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['office_number_professional'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['street_number_professional'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['line_professional'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['zip_professional'] = array(



    'required'              => true,

    'max_len'               => 10,

);



$qmembers_config['form']['member-data-professional']['city_professional'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-professional']['state_professional'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-professional']['country_professional'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-professional']['email_professional'] = array(



    'required'              => false,

    'valid_email'           => true,

);



$qmembers_config['form']['member-data-professional']['phone_professional'] = array(



    'required'              => true,

    'phone_international'   => true,

);



$qmembers_config['form']['member-data-professional']['vat_professional'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-professional']['business_professional'] = array(



    'required'              => false,

    'max_len'               => 255,

);





// Membership data



$qmembers_config['form']['member-data-membership-prim-email']['prim_email_membership'] = array(



    'required'              => true,

    'contains_list'         => 'personal_email;business_email',

);



$qmembers_config['form']['member-data-membership-no-other-address']['billing_address_membership'] = array(



    'required'              => true,

    'contains_list'         => '1;2;3',

);



$qmembers_config['form']['member-data-membership']['title_membership'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-membership']['first_name_membership'] = array(



    'required'              => true,

    'max_len'               => 50,

);





$qmembers_config['form']['member-data-membership']['last_name_membership'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-membership']['company_membership'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['department_membership'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['office_number_membership'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['street_number_membership'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['line_membership'] = array(



    'required'              => false,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['zip_membership'] = array(



    'required'              => true,

    'max_len'               => 10,

);



$qmembers_config['form']['member-data-membership']['city_membership'] = array(



    'required'              => true,

    'max_len'               => 255,

);



$qmembers_config['form']['member-data-membership']['state_membership'] = array(



    'required'              => false,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-membership']['country_membership'] = array(



    'required'              => true,

    'max_len'               => 50,

);



$qmembers_config['form']['member-data-membership']['email_membership'] = array(



    'required'              => true,

    'valid_email'           => true,

);



$qmembers_config['form']['member-data-membership']['phone_membership'] = array(



    'required'              => true,

    'phone_international'   => true,

);



$qmembers_config['form']['member-data-membership-press']['press_magazine_membership'] = array(



    'required'              => true,

    'contains_list'         => '1;2',

);





// Termination data

$qmembers_config['form']['member-data-termination']['reason_termination'] = array(



    'required'              => true,

    'max_len'               => 255,   // TODO: Temporary limit until it's sure what this will be. Question: Kerstin, which var type will this be? Int? Only 1,2,3? How many?

);



$qmembers_config['form']['member-data-termination']['message_termination'] = array(



    'required'   => true

);



$qmembers_config['form']['member-data-termination']['disclaimer_termination'] = array(



    'required'   => false

);





// Settings data

$qmembers_config['form']['member-data-settings']['password_old_settings'] = array(



    'required'              => true,

    'max_len'               => 100,  // To have a limit

);



$qmembers_config['form']['member-data-settings']['password_new_settings'] = $qmembers_config['password_validation_settings'];



$qmembers_config['form']['member-data-settings']['password_new_repeat_settings'] = $qmembers_config['password_validation_settings'];





// Memberlist data

$qmembers_config['form']['member-data-memberlist']['search_memberlist'] = array(



    'required'   => false

);





// Password Recover Data

$qmembers_config['form']['password-recover']['email'] = array(



    'required'   => true,

    'valid_email' => true,

);





// Searching uploaded files



$qmembers_config['form']['restricted-uploads-search']['search'] = array(



    'required'   => false,

    'max_len'    => 100,

);



$qmembers_config['form']['restricted-uploads-search']['filter1'] = array(



    'required'   => false,

    'max_len'    => 200,

);



$qmembers_config['form']['restricted-uploads-search']['filter2'] = array(



    'required'   => false,

    'max_len'    => 200,

);



$qmembers_config['form']['restricted-uploads-search']['search_page'] = array(



    'required'   => false,

    'max_len'    => 4,

    'integer'    => true,

);







?>
