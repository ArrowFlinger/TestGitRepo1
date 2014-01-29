<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Commonfunction Controler
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Nauction Platinum Version 1.0
 * @category   Base
 * @author     NDOT Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 * Created on October 24, 2012
 * @Updated on October 24, 2012
 */
class Controller_Commonfunction extends Controller {

    public function action_index()
    {
       
        // Instanciating the Module Class
        $Commonfunction = new Commonfunction;
        
        // Or Call a Statis Method
       
    }
   
    
    
} // End Welcome
