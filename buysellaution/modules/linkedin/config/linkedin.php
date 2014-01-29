<?php defined('SYSPATH') or die('No direct script access.');

define('CALLBACK_URL', URL_BASE.'users/linkedinconnect');
define('BASE_API_URL', 'https://api.linkedin.com');

define('REQUEST_PATH', '/uas/oauth/requestToken');
define('AUTH_PATH', '/uas/oauth/authorize');
define('ACC_PATH', '/uas/oauth/accessToken');

return array(	
	'id', 
	'first-name', 
	'last-name', 
	'picture-url',
	'public-profile-url',
	'headline', 
	'current-status', 
	'location', 
	'distance', 
	'summary',
	'industry', 
	'specialties',
	'positions',
	'educations'
);