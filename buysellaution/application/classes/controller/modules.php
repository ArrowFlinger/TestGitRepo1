<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Master(Email Templates,Payment Gateways) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Modules extends Controller_Welcome 
{  
	public function __construct(Request $request, Response $response)
    {
        parent::__construct($request,$response);
		$this->module= Model::factory('module');
		
    }
	
	public function action_getAuctiontypes_ajax()
	{		
			$auction_type = $this->module->select_types();
			echo json_encode($auction_type);exit;
	}
	
	public function action_getAuctiontypesajaxtoadmin()
	{		
			$auction_type = $this->module->select_types(); 
			$types = array();
			foreach($auction_type as $k => $value)
			{
				 $types[] = array('typeid' => $value['typeid'],
						  'typename' => $value['typename'],
						  'settings' => $value['settings']!="" ? unserialize($value['settings']):"");
			}
			echo json_encode($types);exit;
	}
	
	public function action_callback()
	{
		$this->auto_render=FALSE;
		$datas = $_GET;		
		$module = $this->module->select_types($datas['module']);
		if(!file_exists(MODPATH.$module['typename'] .'/'))
		{
			$datas['error']= "Modules Folder Doesn't Exists. Please Add the module folder and Try again";
		}
		echo json_encode($datas);
		
	} 
	private function recurse_copy($src,$dst) {
		$dir = opendir($src); 
		@mkdir($dst); 
		while(false !== ( $file = readdir($dir)) ) { 
		    if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) { 
			    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
			} 
			else { 
			    copy($src . '/' . $file,$dst . '/' . $file); 
			} 
		    } 
		} 
		closedir($dir); 
	}
	
	private function deleteDirectory($dir) {
		if (!file_exists($dir)) return true;
		if (!is_dir($dir) || is_link($dir)) return unlink($dir);
		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') continue;
				if (!$this->deleteDirectory($dir . "/" . $item)) {
				    chmod($dir . "/" . $item, 0777);
				    if (!$this->deleteDirectory($dir . "/" . $item)) return false;
				};
		}
		return rmdir($dir);
	}


	
	private function get_string_between($string, $start, $end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if ($ini == 0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}

	public function action_index()
	{
		$this->page_title = __('menu_modules_edit');
		$this->selected_page_title = __('menu_modules_edit');
		$this->selected_controller_title =__('menu_modules');
		$modules=Kohana::modules();
		$auction_type = $this->module->select_types();
		$types=array(); 
		foreach($auction_type as $auction)
		{
			$types[$auction['typename']]=$auction['typeid'];
		}
		$upload =$this->request->post('upload');
		
		if(isset($upload))
		{
			if(function_exists('exec')) {
			}
			$packagetype = $this->request->post('packagetype'); 
			$pack = Arr::extract($_FILES,array('package'));
			
			if(substr($pack['package']['name'], strripos($pack['package']['name'], '.'))==".zip")
			{
				
				$packname = substr($pack['package']['name'],0,-4);
				$targettemp = DOCROOT."public/uploaded_files/temp/";
				$packpath = $targettemp.$packname;
				
				//Extract ZIP file
				$zip = new ZipArchive;
				if ($zip->open($pack['package']['tmp_name']) === TRUE) {
					$zip->extractTo($targettemp);
					$zip->close();
					if(function_exists('exec')) {
						//Apply permission for all module folder moved
						exec ("find ".$packpath." -exec chmod 0777 {} +");
					}
					
					if(file_exists($packpath."/classes"))
					{
						//Change the permission the pack.na file
						chmod($packpath.'/pack.na',0777);
						
						$myFile = $packpath."/pack.na";
						if(!file_exists($myFile))
						{
							Message::error("Not a valid bid package module.");						
							$this->request->redirect('modules/');
						}
						$fh = fopen($myFile, 'r');
						$theData = fread($fh, 1024);
						fclose($fh);
						
						//Read the text content in the pack.na file with the strings between
						$txtvals =  $this->get_string_between($theData,'#!','!#');
						$a = explode("~",$txtvals);
						
						$validpack = false;
						$new_arr = array();
						foreach($a as $b)
						{
							$datas = explode(":",$b);				
							if(array_key_exists(0,$datas) && array_key_exists(1,$datas) )
							{					
								$new_arr[trim($datas[0])]= trim($datas[1]);
							}
						}
						
						/* Check for the pack it has a valid pack details
						 * Package Name : Nauction ~
						 * Author : Ndot ~
						 * Bidpack : beginner ~
						 */
						//print_r($new_arr);exit;
						$themes = array();
						$ndot_pack_valid = array("Author"=>"Ndot","Package Name"=>"Nauction","pack" => "bidpack");
						if($packagetype=="O")
						{
							$ndot_pack_valid = array("pack" => "other")+ $ndot_pack_valid;
						}
						if(array_key_exists('themes',$new_arr))
						{
							$themes = explode("+",$new_arr['themes']);
							
						}
						
						foreach($ndot_pack_valid as $k => $datas)
						{
						        if(array_key_exists($k,$new_arr) && $new_arr[$k] == $datas){
						                $validpack=true;
								
						        }else{
						                $validpack=false;
						                break;
						        }
						        						
						}
						if($validpack)
						{
							
							$src = $targettemp.$packname;
							$dest = MODPATH.$packname."/";
							if(!file_exists($dest))
							{
								
								if(is_writable(MODPATH))
								{
									 
									try
									{
										//Copy the entire directory structure to module path
										$this->recurse_copy($src,$dest);
										
										if(function_exists('exec')) {
											//Enabling the permission for the module file if needed
											exec ("find ".$dest." -exec chmod 0777 {} +");
										}
										
										$config = Kohana::$config->load('database')->default;
										$dbconfigs = $config['connection'];
										
										/*sql run script */  
										$sqlErrorCode =0;
										$sqlFileToExecute = $src.'/'.$packname.'.sql';
										$file=implode("",file($sqlFileToExecute));
										$fpost=fopen($sqlFileToExecute,'w'); 
										$sqld =TABLE_PREFIX;
										$file = str_replace('TABLE_PREFIX.',$sqld,$file);
										fwrite($fpost,$file,strlen($file));
										fclose($fpost);
										
										$hostname = $dbconfigs['hostname'];
										$db_user = $dbconfigs['username'];
										$db_password = $dbconfigs['password'];
										$link = mysql_connect($hostname, $db_user, $db_password);					
										$database_name = $dbconfigs['database'];
										@mysql_select_db($database_name, $link);									 
										// read the sql file
										$f = fopen($sqlFileToExecute,"r+");
										$sqlFile = fread($f, filesize($sqlFileToExecute));
										$sqlArray = array_filter(explode('--',$sqlFile));									
										foreach ($sqlArray as $stmt) {
										  if (strlen($stmt)>3 && substr(ltrim($stmt),0,2)!='/*') { 
										    $result = @mysql_query($stmt);
										    if(!$result)
										    {
											$sqlErrorCode = mysql_errno();
										    }
										  }
										} 	 						
										/*sql run script */
										
										//Css file move
										foreach($themes as $theme)
										{
											//css move
											$publicfolder = DOCROOT."public/";
											$cssfolder = $publicfolder.$theme."/auction";
											if(!is_dir($cssfolder))
											{
												mkdir($cssfolder);chmod($cssfolder,0777);
											} 
											$cssfile = $src."/public/".$theme."/".$packname;
											$newcss = $cssfolder."/".$packname.'/';
											if(file_exists($cssfile))
												$this->recurse_copy($cssfile,$newcss);
										}
										switch($packagetype)
										{
											case "O":
												$packtype = $packname;
												$this->commonmodel->mod_install(AUCTIONTYPE, array('typename' => $packname,'status' => ACTIVE,'pack_type'=>"O"));
												break;
											default:
												$jsfile = $src."/".$packname.'.js';
												$newjs = DOCROOT."public/js/auction/".$packname.'.js';
												copy($jsfile,$newjs);
												$packtype = "auction_".$packname;
												break;
										} 
										
										//Delete on the temp directory
										$this->deleteDirectory($src);
										
										//Edit the bootstrap file to add kohana module
										$bootstrapfile = DOCROOT."application/bootstrap".EXT;
										$file=implode("",file($bootstrapfile));
										$fpost=fopen($bootstrapfile,'w'); 
										$moduledata =" /* Modules Writes */ \nKohana::modules(Kohana::modules() + array('{$packtype}' => MODPATH.'{$packname}'));";
										$file = str_replace('/* Modules Writes */',$moduledata,$file);
										fwrite($fpost,$file,strlen($file));
										fclose($fpost); 								
										
										Message::success(__('bid_package_added_successfully'));
										
									}
									catch(Exception $e)
									{
										//Message::error($e);
										Message::error(__('problem_uploading_package_check_on_permissions').$e);
										
									}
								}
							}
							else
							{
								Message::error(__('already_bid_package_installed'));
								
								//Delete on the temp directory
								$this->deleteDirectory($src);
								
								
							}
						}
						else
						{
							Message::error(__('not_valid_bidpackage'));						
							
							
						}						
					}
					else
					{
						Message::error(__('not_valid_bidpackage_folder_architecture'));
						
					}
					
				} else {
					Message::error(__('package_uploading_failed'));
					
				}
			}
			else{
				Message::error(__('format_not_supported'));
				
			}
			
			$this->request->redirect('modules/');
		}
		$auction_types = $this->module->select_types("","O",false);
		
		$view = View::factory('admin/modules/module_list')
				->bind('modules',$modules)->bind('auction_type',$auction_types)
				->bind('installed',$types);
		$this->template->content = $view;
	}
	
	public function action_install()
	{		
		$module_name =$this->request->param('id');		
		sleep(2);
		$insert = $this->commonmodel->mod_install(AUCTIONTYPE, array('typename' => $module_name,'status' => ACTIVE,'pack_type'=>"M"));
		if($insert)
		{
			Message::success(__('module_installed_successfully'));
			$this->request->redirect('modules/');
		}
		$this->request->redirect('modules/');
	}
	
	public function action_uninstall()
	{		
		$module_id =$this->request->param('id');		
		$delete = $this->commonmodel->makeinactive(AUCTIONTYPE,'typeid',$module_id);
		if($delete)
		{
			Message::success(__('module_uninstalled_successfully'));
			$this->request->redirect('modules/');
		}
		
	}
	
	public function action_selectauction()
	{
		$this->template->welcomescript = array_merge($this->template->welcomescript,array(SCRIPTPATH.'module.js'));
		$this->page_title = __('menu_select_auction_type');
        $this->selected_page_title = __('menu_select_auction_type');
		$modules=Kohana::modules();
		$auction_type = $this->module->select_types();
		
		$view = View::factory('admin/modules/selectauction')->bind('auction_type',$auction_type);
		$this->template->content = $view;
	}
	
	public function action_checkactive()
	{
		$id=$_GET['id'];
		$check=$this->commonmodel->checkactiv($id);
		if(isset($check))
		{
			if($check[0]['active']==0)
			{
				$data['status']="uninstall";
			}
			else
			{
				$data['status']="active";
			}
		}
		echo $data['status'];
	}
	

} // End Welcome
