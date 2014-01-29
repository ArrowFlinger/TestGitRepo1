<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Google Checkout
 * @copyright  (c) 2009 Woody Gilk
 * @author     Woody Gilk
 * @license    MIT
 */
class Gc extends Kohana_Gc {
    
    public static function showlink($formdatas= array() , $currency ="USD",$inc=1)
    {
        $render="";
        if($currency =="USD" || $currency =="EUR")
        {
            $render ="<form action='".URL_BASE."googlecheckout/payment' name='gcsubmit{$inc}' id='gcsubmit{$inc}' method='post'>";
            foreach($formdatas as $value)
            {
                foreach($value as $key => $val)
                {
                    $render .= "<input type='hidden' name='".$key."' value='".$val."'/>";
                }
            } 
            $render .= "<a href='javascript:;' class='view_link fl' onclick='$(\"#gcsubmit{$inc}\").submit();'>".__('google_checkout')."</a>";
            $render .="</form>";
        } 
       echo $render;
    }
    
    
     public static function showlinkdata($formdatas= array() , $currency ="USD",$inc=1,$id)
    {
        $render="";
            $render ="<form action='".URL_BASE."googlecheckout/payment' name='gcsubmit{$inc}' id='$id' method='post'>";
            foreach($formdatas as $value)
            {
                foreach($value as $key => $val)
                {
                     //venkatraja added this condition
                    if(is_array($val))
		    {
					
                        foreach($val as $fieldname=>$fieldvalue)
                        {
                        
                        $render .= "<input type='hidden' name='".$fieldname."' value='".$fieldvalue."'/>";
                        
                        }
                        
                    }else{
                        
                                $render .= "<input type='hidden' name='".$key."' value='".$val."'/>";
                     }
                }
            } 
          
            $render .="</form>";
       echo $render;
    }
    
    
    
    
}
