<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Master(Email Templates,Payment Gateways) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Module extends Controller_Welcome 
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
		/*$packname = "pennyauction";
		$file = fopen(DOCROOT."temps.php", "a");
									$packtype = "auction_".$packname;
									$moduledata =" \nKohana::modules(Kohana::modules() + array('{$packtype}' => MODPATH.'{$packname}'));";
									fwrite($file,$moduledata);
									fclose($file);
									exit;*/
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
						exec ("find ".$packpath." -exec chmod 0777 {} +");
					}
					
					if(file_exists($packpath."/classes"))
					{
						chmod($packpath.'/pack.na',0777);
						$myFile = $packpath."/pack.na";
						$fh = fopen($myFile, 'r');
						$theData = fread($fh, 1024);
						fclose($fh);
						$txtvals =  $this->get_string_between($theData,'#!','!#');
						$a = explode("~",$txtvals);
						
						$validpack = true;
						$new_arr = array();
						foreach($a as $b)
						{
							$datas = explode(":",$b);				
							if(array_key_exists(0,$datas) && array_key_exists(1,$datas) )
							{					
								$new_arr[trim($datas[0])]= trim($datas[1]);
							}
						}
						foreach($new_arr as $k => $datas)
						{							
							if($k =='Author')
							{					
								if("Ndot" != $datas)
								{
									$validpack=false;
									break;
								}
							}
							else if($k =='Package Name')
							{
								if($datas!="Nauction")
								{
									$validpack=false;
									break;
								}
							}							
						}
						if($validpack)
						{
							$src = $targettemp.$packname;
							$dest = MODPATH.$packname."/";
							if(is_writable(MODPATH))
							{
								try
								{									
									$this->recurse_copy($src,$dest);
									if(function_exists('exec')) {
										exec ("find ".$dest." -exec chmod 0777 {} +");
									}
									$this->deleteDirectory($src);
									
									//chmod(DOCROOT."index.php",0777);
									$file = fopen(DOCROOT."application/bootstrap".EXT, "a");
									$packtype = "auction_".$packname;
									$moduledata =" \nKohana::modules(Kohana::modules() + array('{$packtype}' => MODPATH.'{$packname}'));";
									fwrite($file,$moduledata);
									fclose($file);
									
									Message::success("Bid Package Added successfully");
									$this->request->redirect('module/');
								}
								catch(Exception $e)
								{
									Message::error("Problem in uploading a package.Please try again later.");
									$this->request->redirect('module/');
								}
							}
						}
						else
						{
							Message::error("Not a valid bid package module");
							$this->request->redirect('module/');
						}
						
					}
					else
					{
						Message::error("Not a valid bid package folder architecture");
						$this->request->redirect('module/');
					}
					
				} else {
					Message::error("Package uploading Failed");
					$this->request->redirect('module/');
				}
			}
			else{
				Message::error("Format is not supported.");
				$this->request->redirect('module/');
			}
			//echo "Files uploaded";
		}
		$view = View::factory('admin/modules/module_list')
				->bind('modules',$modules)
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
			$this->request->redirect('module/');
		}
		
	}
	
	public function action_uninstall()
	{		
		$module_id =$this->request->param('id');
		$delete = $this->commonmodel->makeinactive(AUCTIONTYPE,'typeid',$module_id);
		if($delete)
		{
			Message::success(__('module_uninstalled_successfully'));
			$this->request->redirect('module/');
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
