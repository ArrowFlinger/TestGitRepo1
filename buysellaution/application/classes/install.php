<?php defined('SYSPATH') or die('No direct script access.');


		if (file_exists(DOCROOT.'/application/config/database.php') )
		{	
			// Load default database configuration
			$config = Kohana::$config->load('database');
		

			$prefix=$config['default']['table_prefix'];
			$host=$config['default']['connection']['hostname'];
			$user=$config['default']['connection']['username'];
			$pass=$config['default']['connection']['password'];
			$db=$config['default']['connection']['database'];
			$this->install_model = Model::factory('install'); 

			$total_tables=count($this->install_model->list_tables());
			if($total_tables < TOTAL_NO_TABLES)
			{
				$session->set("table_not_installed","Database Error!. Please Delete the existing tables and try again!.");
				$request->redirect('/install/installation/');
				exit;
			}

		}
		else
		{
			$request->redirect('install/installation');exit;
		}

?>
