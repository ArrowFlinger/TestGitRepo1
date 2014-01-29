<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Modulename — My own custom module.
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Buynow {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		$this->session=Session::instance();
		 
	}
	
	public function structure()
	{	
		//$beginner -> action_process();
		//echo "asdasd";exit;
	}
	
	
	/*** Added By Venkatraja  on 14-March-2012****/
	
	static function BuynowOrdermail($response=array(),$replace =array())
	{
		/*
		 * @response array lists
		 * 
		 * order_id - manditory
		 * user_id - manditory
		 * currency -manditory
		 * price - optional (price will be applicable only for single product)
		 * order_date - optional
		 * billinginfo -optional
		 * shippinginfo - optional
		 * notification -optional (Add you custom message to notify the customer)
		 * products - optional - array format is Eg: array(array('name'=>'','quantity' =>'','price' =>''),array('name'=>'','quantity' =>'','price' =>''))
		 * product_id - optional if above products index not given means this will be manditory
		 * type -optional (bidding type name)
		 */
		$model = Model::factory('buynow');
		
		$site_name=Commonfunction::get_site_settings();
		$sitename =$site_name[0]['site_name'];	
		$replace_variables = array(SITE_NAME => $sitename ,SITE_URL => URL_BASE, SITE_LINK => URL_BASE,
			  	CONTACT_MAIL => $site_name[0]['common_email_from'],FROM_EMAIL => $site_name[0]['common_email_from']);
		$udetails = $model->getUserdetails($response['user_id']);
		$userdetails = $udetails['userdetails'];
		$orderdate = isset($response['orderdate'])?$response['orderdate']:Commonfunction::getCurrentTimeStamp();
		if(isset($response['shippinginfo']))
		{
			$shippinginfo = $response['shippinginfo'];
		}
		else
		{
			$billinginfo = $udetails['shippinginfo'];
			$shippinginfo=$billinginfo['name']."<br/>".$billinginfo['address']."<br/>".$billinginfo['city']."<br>".$billinginfo['town']."-".$billinginfo['zipcode']."<br/>".$billinginfo['country']."<br/>Phone Number :".$billinginfo['phoneno'];

		}
		if(isset($response['billinginfo']))
		{
			$billinginfo = $response['billinginfo'];
		}
		else
		{
			$billinginfo = $udetails['billinginfo'];
			
			$billinginfo=$billinginfo['name']."<br/>".$billinginfo['address']."<br/>".$billinginfo['city']."<br>".$billinginfo['town']."-".$billinginfo['zipcode']."<br/>".$billinginfo['country']."<br/>Phone Number :".$billinginfo['phoneno'];
			
		} 
		        
			
			if(isset($response['product_unique_details']))
			{
				if(is_array($response['product_unique_details'])){
					if(count($response['product_unique_details'])>0)
					{
						foreach($response['product_unique_details'] as $pdetails)
						{
							$product_details = $model->getAuctiondetails($pdetails['id']);
							$product_result[] = array('name' => $product_details['productdetails']['product_name'],
							'quantity' => $pdetails['quantity'],
							'price' => $pdetails['unitprice']);
							
						}
						
						
					}
				}
				
			}
			
	
		$auction_detail ='<table border="0" width="99%" cellpadding="4">
		    <thead style="background:#ccc">
			<tr><td>Product Name</td>
			<td>Quantity</td>
			<td>Price</td>
			<td>Sub total</td> 
			</tr>
		    </thead>
		    <tbody>';
			$subtot = 0;
			$shipping = isset($response['shipping'])?$response['shipping']:0;
			$tax = isset($response['tax'])?$response['tax']:0;
			foreach($product_result as $result):
			
				$subtot += $result['price'] * $result['quantity'];
						$auction_detail .='	<tr>
				    <td style="line-height:20px;"> '.$result['name'].' </td>
				    <td style="line-height:20px;"> '.$result['quantity'].' </td>
				    <td style="line-height:20px;"> '.$response['currency'].Commonfunction::numberformat($result['price']).' </td>
				    <td style="line-height:20px;"> '.$response['currency'].Commonfunction::numberformat(($result['price'] * $result['quantity'])).' </td> 
				</tr>';
			endforeach;			
			$auction_detail .='<tr>
			    <td colspan="2" style="line-height:20px;">
				
			    </td>
			    <td>Subtotal: </td>
			     <td>'.$response['currency'].Commonfunction::numberformat($subtot).' </td>
			</tr>';
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Shipping Rate: </td>
			     <td>'.$response['currency']. Commonfunction::numberformat($shipping).' </td>
			</tr>';
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Tax: </td>
			    <td>'.$response['currency']. Commonfunction::numberformat($tax).' </td>
			</tr>';
			 
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Total: </td>
			     <td>'.$response['currency']. Commonfunction::numberformat(($shipping+$tax+$subtot)).' </td>
			</tr>';
			
		       $auction_detail .='</tbody>  
                </table>';
		
	$logo_image_path=IMGPATH.SITE_LOGO_IMAGE;
if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
	$logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}
	
		$alternatives = array_merge(array(
						'##NOTIFICATION##' => isset($response['notification'])?$response['notification']:'',	
						USERNAME => $userdetails['username'],
						TO_MAIL=>$userdetails['email'],
						'##AUCTIONDETAIL##'=>$auction_detail,
						'##SHIPPING_INFO##' =>($shippinginfo!="")?$shippinginfo:"-",
						'##BILLING_INFO##' =>($billinginfo!="")?$billinginfo:"-",
						'##LOGO##'=>'<img src="'.$logo_image_path.'" border="0"  />',
						'##ORDER_ID##' =>$response['order_id'],
						'##ORDER_DATE##' => $orderdate),$replace);
		

		$buyer_replace_variable = array_merge($replace_variables,$alternatives);
		 
		//send mail to buyer by defining common function variables from here
		
		
		return Commonfunction::get_email_template_details('buynow_order',$buyer_replace_variable,SEND_MAIL_TRUE,true); 
		
	}

	
	
	
	
	/*** Added By Venkatraja ***/
	
	
	
	
		

	
}
