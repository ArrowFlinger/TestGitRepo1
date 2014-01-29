<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Commonfunction
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Authorize extends Kohana_Authorize {
    
    public static function showlink($formdatas= array() , $currency ="USD",$inc=1)
    {
        $render="";
        if($currency =="USD" || $currency =="EUR")
        {
            $render ="<form action='".URL_BASE."authorize/authorize_payment' name='authorizesubmit{$inc}' id='authorizesubmit{$inc}' method='post'>";
            foreach($formdatas as $value)
            {
                foreach($value as $key => $val)
                {
                    $render .= "<input type='hidden' name='".$key."' value='".$val."'/>";
                }
            } 
            $render .= "<a href='javascript:;' class='view_link fl' onclick='$(\"#authorizesubmit{$inc}\").submit();'>".__('authorize_checkout')."</a>"; 
            $render .="</form>";
        } 
       echo $render;
    }
    
    public static function showlinkdata($formdatas= array() , $currency ="USD",$inc=1,$id)
    {
        $render="";
        
            $render ="<form action='".URL_BASE."authorize/authorize_payment' name='authorizesubmit{$inc}' id='$id' method='post'>";
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
