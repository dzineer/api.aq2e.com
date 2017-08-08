<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/*$route['default_controller'] = 'welcome';*/
/*$route['404_override'] = '';*/
/*$route['translate_uri_dashes'] = FALSE;
*/

// Authorize Endpoints
$route['v1/auth'] = 'auth/authorize';
$route['v1/auth/token']['GET'] = 'auth/index';

// Campaigns
$route['v1/campaigns']['GET'] = 'campaign/index';
$route['v1/campaigns/:num']['GET'] = 'campaign/campaign_lookup/$1';

// External API Forms
$route['v1/external_api_forms']['GET'] = 'apiform/index';
$route['v1/external_api_forms/:num']['GET'] = 'apiform/lookup/$1';

// Capture Links
$route['v1/capture_links']['GET'] = 'capture/index';
$route['v1/capture_links/:num']['GET'] = 'capture/capture_link_lookup/$1';

// Confirmation Pages
$route['v1/confirmation_pages']['GET'] = 'confirmation_page/index';
$route['v1/confirmation_pages/:num']['GET'] = 'confirmation_page/page_lookup/$1';

// Capture Link Rules
$route['v1/capture_link_rules/:num']['GET'] = 'capture/capture_link_rule_lookup/$1';

// Monitored Links
$route['v1/link_monitors']['GET'] = 'link_monitor/index';
$route['v1/link_monitors/:any']['GET'] = 'link_monitor/registered_link_lookup/$1';
$route['v1/link_monitors']['POST'] = 'link_monitor/link_clicked';

// Monitored Campaign Links
$route['v1/campaign_link_monitors']['GET'] = 'campaign_link_monitor/index';
$route['v1/campaign_link_monitors/:any']['GET'] = 'campaign_link_monitor/registered_link_lookup/$1';
$route['v1/campaign_link_monitors']['POST'] = 'campaign_link_monitor/link_clicked';

// Subscribers
$route['v1/subscribers']['GET'] = 'subscriber/index';
$route['v1/subscribers/:num']['GET'] = 'subscriber/subscriber_lookup/$1';
$route['v1/subscribers']['POST'] = 'subscriber/add_subscriber';
$route['v1/new_subscriber']['GET'] = 'subscriber/add_subscriber_form';

// Campaign Subscribers Endpoints
$route['v1/campaign_subscribers/:num']['GET'] = 'campaign_subscriber/campaign_subscriber_lookup/$1';
$route['v1/campaign_subscribers']['GET'] = 'campaign_subscriber/index';
$route['v1/campaign_subscribers']['POST'] = 'campaign_subscriber/add_subscriber';
$route['v1/new_campaign_subscriber']['GET'] = 'campaign_subscriber/add_campaign_subscriber_form';

// Events Endpoints
$route['v1/events/:num']['GET'] = 'event/event_lookup/$1';
$route['v1/events']['GET'] = 'event/index';
$route['v1/events']['POST'] = 'event/add_event';
$route['v1/new_event']['GET'] = 'event/add_event_form';

// Registered Actions Endpoints
$route['v1/registered_actions']['GET'] = 'registered_action/index';
$route['v1/registered_actions/:num']['GET'] = 'registered_action/registered_action_lookup/$1';

// Registered Web Hooks Endpoints
$route['v1/webhook_actions']['GET'] = 'webhook_action/index';
$route['v1/webhook_actions/:num']['GET'] = 'webhook_action/registered_action_lookup/$1';
$route['v1/webhook_actions/:num']['POST'] = 'webhook_action/webhook_callback/$1';
$route['v1/new_webhook_action/:num']['GET'] = 'webhook_action/add_webhook_form/$1';

// Registered Web Hook Reports Endpoints
$route['v1/webhook_reports']['GET'] = 'webhook_report/index';
$route['v1/webhook_reports/:num']['GET'] = 'webhook_report/webhook_report_lookup/$1';

// Form Pages Endpoints
$route['v1/form_pages']['GET'] = 'form_page/index';
$route['v1/form_pages/:num']['GET'] = 'form_page/form_page_action_lookup/$1';

// Fired Events Endpoints
$route['v1/fired_events/:num']['GET'] = 'event/fired_event_lookup/$1';
$route['v1/fired_events']['GET'] = 'event/fired_event';
$route['v1/fired_events']['POST'] = 'event/add_fired_event';
$route['v1/new_fired_event']['GET'] = 'event/add_fired_event_form';

// Products Endpoints
$route['v1/products/:num']['GET'] = 'product/product_lookup/$1';
$route['v1/products']['GET'] = 'product/index';


// Marketing Preferences Endpoints
$route['v1/marketing_preferences']['GET'] = 'marketing_preference/index';

// Sites Endpoints
$route['v1/sites/:num']['GET'] = 'site/site_lookup/$1';
$route['v1/sites']['GET'] = 'site/index';

// http://api.aq2emarketing.com/v1/auth_token?user_id=fdecker&password=btenpEyZmYd2y5cp&api_key=bf32e9fa-73b9-ff00-a5ac-48537833ad3c

