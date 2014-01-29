<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * You should have all the module's models inside the module folder
 * so the module can be functional just by copying the module folder.
 *
 * It's recomended to name you Module's Models as Model_Modulename_<Model>
 * to avoid any conflics with any application model
 */

class Model_Install extends Model {



	/**Validating Database details**/
	public function validate_dbdatas($arr) 
	{

		return Validation::factory($arr)       
				->rule('hostname', 'not_empty')
				//->rule('hostname','alpha_dash')
				->rule('database', 'not_empty')
				->rule('database','alpha_dash')
				->rule('username', 'not_empty')
				->rule('username','alpha_dash')
				->rule('username', 'max_length', array(':value', '32'))
				->rule('password', 'max_length', array(':value', '32'))
				->rule('prefix', 'alpha_dash');

	}

	/**Validating Admin details**/
	public function validate_admindatas($arr) 
	{

		return Validation::factory($arr)     
				->rule('title', 'not_empty')
				->rule('title', 'max_length', array(':value', '50'))  
				->rule('title','alpha_space')
				->rule('name', 'not_empty')
				->rule('name','alpha_dash')
				->rule('name', 'max_length', array(':value', '32'))
				->rule('email', 'not_empty')
				->rule('password', 'not_empty')
				->rule('password', 'max_length', array(':value', '32'))
				->rule('apikey', 'not_empty');

	}

	public function execute_query($prefix,$adminname,$adminemail,$adminpassword,$sitename)
	{
		$current_date=date('Y-m-d H:i:s', time());

		// data for table `auction_users`

$sql="INSERT INTO `".$prefix."users` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `country`, `aboutme`, `photo`, `user_bid_account`, `user_bonus`, `other`, `usertype`, `login_type`, `status`, `referral_id`, `created_date`, `updated_date`, `last_login`, `login_ip`, `user_agent`, `newsletter`, `referred_by`, `activation_code`, `activation_code_status`, `paypal_account`) VALUES
(1, '$adminname', '$adminname',  '$adminemail', '$adminname',  md5('$adminpassword'), 'IN', '','3, SH 167, Coimbatore, Tamil Nadu, India', '', '', '', 0, 'A', 'N', 'A', 'wMgk2wCY', '$current_date', '$current_date', '0000-00-00 00:00:00', '', '', 'N', 0, '', '0', '', '11.023389', '76.91110179999998');";

        // mysql_query($sql) or return 0;	
        $result=Db::query(Database::INSERT, $sql)
		->execute();


// data for table `auction_site`

$sql="INSERT INTO `".$prefix."site` (`id`, `site_name`, `site_slogan`, `site_description`, `theme`, `site_logo`, `site_version`, `site_language`, `site_paypal_currency_code`, `site_paypal_currency`, `contact_email`, `common_email_from`, `common_email_to`, `date_format_display`, `time_format_display`, `date_time_format_display`, `date_format_tooltip`, `time_format_tooltip`, `date_time_tooltip`, `date_time_highlight_tooltip`, `site_tracker`, `maintenance_mode`, `status`, `country_time_zone`)  VALUES
(1, '$sitename', 'Auction script ', 'Start your own micro product website with the Industry''s most Powerful, Secure & Highly featured Auction Script script “Auction Script”. We provide a complete solution for starting your own auction script websites.', 'pink', '', '1.0', 'en', 'PLN', 'Rs.', 'ndotauction@gmail.com', 'ndotauction@gmail.com', 'ndotauction@gmail.com', 'Y-m-d', 'g:i:s A', 'Y-m-d g:i:s A', 'F j, Y (l) T (\\G\\M\\TP)', 'g:i:s A', 'F j, Y g:i:s A (l) T (\\G\\M\\TP)', 'F j, Y G:i:s  (l) T (\\G\\M\\TP)', ' var _gaq = _gaq || [];\n  _gaq.push([''_setAccount'', ''UA-20025738-8'']);\n  _gaq.push([''_trackPageview'']);\n\n  (function() {\n    var ga = document.createElement(''script''); ga.type = ''text/javascript''; ga.async = true;\n    ga.src = (''https:'' == document.location.protocol ? ''https://ssl'' : ''http://www'') + ''.google-analytics.com/ga.js'';\n    var s = document.getElementsByTagName(''script'')[0]; s.parentNode.insertBefore(ga, s);\n  })();\n\n\n\n', 'I', 'A', 'Asia/Kolkata');";

        $result=Db::query(Database::INSERT, $sql)->execute();	

            return 1;

	}

	public function list_tables($like = NULL)
	{
		if (is_string($like))
		{
			// Search for table names
			$result = Db::query(Database::SELECT, 'SHOW TABLES LIKE '.$this->quote($like), FALSE)->execute();
		}
		else
		{
			// Find all table names
			$result = Db::query(Database::SELECT, 'SHOW TABLES', FALSE)->execute();
		}
	
		$tables = array();
		foreach ($result as $row)
		{
			$tables[] = reset($row);
		}

		return $tables;
	}
     
} // End User Model
