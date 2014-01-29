<?php defined('SYSPATH') or die('No direct script access.');

require_once Kohana::find_file('vendor','googlecart');
require_once Kohana::find_file('vendor','googleshipping');
require_once Kohana::find_file('vendor','googleitem');
require_once Kohana::find_file('vendor','googletax');

abstract class Kohana_Gc {

	const URL_SANDBOX    = 'https://sandbox.google.com/checkout/api/checkout/v2/request/Merchant/';
	const URL_PRODUCTION = 'https://checkout.google.com/api/checkout/v2/request/Merchant/';

	public static $sandbox = TRUE;
	protected static $instance;

	public static $merchant_id;
	public static $merchant_key;   
	public static $currency = 'USD';
	protected $cart;

	public function __construct($sandbox = NULL)
	{
		self::$merchant_id  = Kohana::$config->load('gcheckout')->merchant_id; 
		self::$merchant_key = Kohana::$config->load('gcheckout')->merchant_key;

		if (isset($sandbox))
		{
			self::$sandbox = $sandbox;
		}
	}
	
	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function cartinstance()
	{
		if ( ! isset(Gc::$instance))
		{
			$class = "GoogleCart"; 
			// Create a new session instance
			Gc::$instance = new $class(Gc::$merchant_id,
						   Gc::$merchant_key,
						   Gc::$sandbox,
						   Gc::$currency);
		} 
		return Gc::$instance;
	} 
	
	/*
	 * Standard checkout
	 * 
	 * @return google checkout button
	 * 
	 * @param items = array('itemname'=>'Your item','itemdescription'=>'Your Description','quantity'=>'Quantity','price'=>'Price')
	 */
	public function standard($items = array(),$returnurl = "",$additional="",$shipping = 0, $tax =0)
	{
		$cart = self::cartinstance(); 
		$this->AddItem($cart,$items);
		if($shipping>0)
		{
			$ship = new GoogleFlatRateShipping("Flat Shipping Rate", $shipping);
			$cart->AddShipping($ship);
		}
		if($tax>0)
		{
			$tax_rule = new GoogleDefaultTaxRule($tax);
			$cart->AddDefaultTaxRules($tax_rule);
		}
		$cart->SetContinueShoppingUrl($returnurl);
		if($additional!="")
			$cart->SetMerchantPrivateData($additional);
		return $this->cart = $cart;
	}
	
	
	public function AddItem($cart , $itemssets = array())
	{
		 
		foreach($itemssets as $itemtype => $value)
		{
			$desc="";
			if(isset($value['itemdescription']))
			{
				$desc = $value['itemdescription'];
			}
			$item = new GoogleItem($value['itemname'], // Item name
					 $desc, // Item description
					 $value['quantity'], // Quantity
					 $value['price']); // Unit price 
			$cart->AddItem($item);
		}
		return $cart;
	}
	
	public function renderbutton($totalitem =0,$buttontype= 'SMALL')
	{
		$variant = true;
		$locale = 'en_US';
		$showinfotext = false;
		if($totalitem<=0)
		{
			$variant = false;
		}
		return $this->cart->CheckoutButtonCode($buttontype,$variant,$locale,$showinfotext);
	}
	
	public static function gcartitems($post= array())
	{
		$cartitems = array();
		$total =0;
		foreach($post as $key => $value)
		{
			 
			if($key=="name")
			{
				$i =0;
				foreach($value as $v)
				{
					$cartitems[$i]['itemname'] =$v;
					$i++;
				}
				
			}
			if($key=="unitprice")
			{
				$i =0;
				foreach($value as $v)
				{
					$total +=$v;
					$cartitems[$i]['price']= $v;
					$i++;
				}
				
			}
			if($key=="quantity")
			{
				$i =0;
				foreach($value as $v)
				{
					$cartitems[$i]['quantity']= $v;
					$i++;
				}
				
			}
			if($key=="description")
			{
				$i =0;
				foreach($value as $v)
				{
					$cartitems[$i]['itemdescription']= $v;
					$i++;
				}
				
			} 
		}
		$items = array('cartitems' =>$cartitems,'total' => $total);
		return $items;
	}

} // End gCheckout
