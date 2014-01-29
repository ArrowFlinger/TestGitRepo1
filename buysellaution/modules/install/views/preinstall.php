<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>Welcome to the NDOT Auction Script Premium Version 1.1 Installation Wizard</title>
<link rel="stylesheet" href="<?php echo INSTALL_CSS_PATH;?>" type="text/css">
</head>
<style type="text/css">
<!-- style.css start-->

body{margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px; }
 
.instal_outer{ width:960px; margin:0px auto; overflow:hidden;}
.instal_logo{ width:210px; margin:10px 0px 20px 0px; background:url(images/ndot_installogo.png);  overflow:hidden; height:120px; }
.instal_inner{ width:954px; margin:0px auto; overflow:hidden; border:1px solid #DCDCDC; padding:2px; padding-bottom:20px;}
.instal_inner h1{   margin:0px auto; padding:0px 0px 5px 10px; overflow:hidden; font-family:Tahoma; font-weight: normal; background:#DCDCDC; font-size:28px;  }
.instal_inner p{  margin:0px auto;margin-bottom:20px; padding: 20px 10px 10px 10px; line-height:20px;   overflow:hidden; font-family:Tahoma; font-weight: normal;   font-size:14px;  }
.mauto{ margin:0px !important;   text-align:center; border-top:#DCDCDC 1px solid;  overflow:hidden; padding:15px !important; font-size:17px!important;margin-bottom: 0px!important;}

.instal_inner .table1{border:1px solid #DCDCDC; background:#EDEDED;   padding:15px;margin-top:10px;padding-bottom:5px;}
.instal_inner .table1 td{  color:#AB1212; font-size:13px; font-weight:bold;background:#EDEDED; padding:15px; padding-bottom:5px; }
.ins_next{  float:left; margin:20px 0px 20px 0px;}
.ins_next input{ height:28px; width:82px;float:left; border:solid #7A7A7A; background:url(<?php echo url::base();?>public/installation_images/install_next.jpg); border:0px; cursor:pointer; }
.instal_footer{ color:#2F2F2F; font-size:13px; text-align:right; margin-top:10px;	}
.instal_inner form{ padding:0px; margin:0px;}

.instal_inner .table2{  background:#fff;   margin-top:20px;  }
.instal_inner .table2 td{  color:#000; font-size:13px; font-weight:bold;  padding: 5px; } 
.instal_inner .step2tex{    border-top:1px solid #7A7A7A; background:#E8E8E8; border-right:1px solid #7A7A7A; width:196px;}
input.reset{ width:82px; height:28px;  background:url(images/instal_reset.gif); margin-left:20px;border:none;}
input.next { width:82px; height:28px;  background:url(<?php echo url::base();?>public/installation_images/install_next.jpg);border:none; margin:0 0 0 3px;}
.ins_stept{ border-bottom:1px solid #ccc;}

.font12{font-size:12px;line-height:16px;}
.font14{font-size:14px;line-height:20px;}
.fontb{font-weight:bold;}
.colorccc{color:#ccc;}
.color999{color:#999;}
.colorblue{color:#1A4680;}
.pb0{padding-bottom:10px;}
.pge6{background:#E6E6E6;}
.p5{padding:5px;}
.pb5{margin-bottom:5px;}
.install_footer { margin:10px 0px 10px 0px; text-align:right;color:#333; }
.install_footer a { text-decoration:none; color:#333;}
.install_footer a:hover { text-decoration:underline;}

body { margin: 0 auto; font-family: sans-serif; font-size: 90%; }
#tests table { border-collapse: collapse; width: 100%; }
#tests table th,
#tests table td { padding: 0.2em 0.4em;  vertical-align: top; }
#tests table th { width: 12em; font-weight: normal; font-size: 1.2em; }
#tests table tr:nth-child(odd) { background: #eee; }
#tests table td.pass { color: #003300; }
#tests table td.fail { color: #911; }
#tests #results { color: #fff; }
#tests #results p { padding: 0.2em 0.4em; }
#tests #results p.pass { background: #003300; }
#tests #results p.fail { background: #911; }
.style1 {font-size: 14px;font-weight: bold;}
.install_footer { margin-bottom:10px; text-align:right;color:#333; }
.install_footer a { text-decoration:none; color:#333;}
.install_footer a:hover { text-decoration:underline;}
.width400 { width:400px;}
<!-- Style ends here-->

body{ width:100% !important; }
body,td {
	margin: 0 auto;
	font-family: sans-serif;
	font-size: 12px;
}
#tests table {
	border-collapse: collapse;
	width: 100%;
}
#tests table th,  #tests table td {
	padding: 0.2em 0.4em;
	text-align: left;
	vertical-align: top;
}
#tests table th {
	width: 12em;
	font-weight: normal;
	font-size: 1.2em;
}
 #tests table tr:nth-child(odd) {
background: #eee;
}
#tests table td.pass {
	color: #003300;
}
#tests table td.fail {
	color: #911;
}
#tests #results {
	color: #fff;
}
#tests #results p {
	padding: 0.2em 0.4em;
}
#tests #results p.pass {
	background: #003300;
}
#tests #results p.fail {
	background: #911;
}
.style1 {
	font-size: 14px;
	font-weight: bold;
}
.install_footer {
	margin-bottom:10px;
	text-align:right;
	color:#333;
}
.install_footer a {
	text-decoration:none;
	color:#333;
}
.install_footer a:hover {
	text-decoration:underline;
}

</style>
<body>

<form action="<?php echo url::base();?>install/install/" method="post" name="form" id="form">
  <table class="shell"  border="0" cellpadding="5" cellspacing="5" style="margin-top:10px; border:5px solid #ddd;" width="680" align="center">
    <tbody>
      <tr>
        <th width="500" class="colorblue" align="left"> <h3 style="width:680px; text-align:center;">Welcome to the NDOT Auction Script Premium Version 1.1 Installation Page</h3></th>
      </tr>
      <tr><td>
      <p style="background:#fffa00; border:1px solid #ff6600; padding:5px;">Read the installation instructions & documentations carefully to setup the application !</p>
	<div align="center" > For installation instructions <a href="<?php echo url::base();?>readme.txt" target="_blank" title="ReadMe">Readme.txt</a></div>
      
      </td></tr>
      <tr>
        <td colspan="2" id="ready_image"><a href="http://http://www.ndot.in/products/auctions-opensource-bidding-application/" target="_blank" title="Auction "> <img src="<?php echo url::base();?>public/installation_images/install.png" alt="Auction" border="0" height="190" width="698" style="margin-top:10px;"></a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" id="ready" class="font12 colorblue"><strong style="margin:0 0 0 3px;">Are you ready to install?</strong> </td>
      </tr>
      <tr>
        <td colspan="2"><p class="color999" style="margin:0 0 0 3px;"><strong>Please
            read the following important information before proceeding with the
            installation. The information will help you to determine whether 
            you are ready to install the application at this time.</strong></p>
          <table class="Welcome" border="0" cellpadding="0" width="100%">
            <tbody>
              <tr>
                <th align="left"><span id="adv_sys_comp" style="display: none; padding-left:-5px;"> <img src="install.php_files/advanced_search.gif" border="0"> </span>&nbsp;<span class="font12 colorblue" style="float:left;">Required System Components</span> </span> </th>
              </tr>
              <tr>
                <td><div id="sys_comp" class="color999"> Before you begin, please be sure that you have the supported versions of the following system components:<br>
                    <ul>
                      <li>MySQL (version 5 or higher) </li>
                      <li>PHP (version 5.2+ ) </li>
                      <li>Apache (version 2.2+ ) </li>
                      <li>Curl (<?php
if(function_exists('curl_init')) {
echo '<span style="font-color:green;">Enabled!</span>';
}else{
echo '<span style="font-color:red;">Must be Enabled!</span>';
}
?>)</li>
                      <li>.htaccess and mod_rewrite should be enabled in your web server</li>
                    </ul>
                    <br>
                  </div></td>
              </tr>
            </tbody>
          </table>
          </ul>
          </li>
          </div>
  <table class="Welcome" border="0" cellpadding="0" width="100%" style="*margin-top:-50px;">
    <tbody>
      <tr>
        <th align="left"><span style="cursor: pointer;">
        <span id="adv_installType" style="display: none;"><img src="install.php_files/advanced_search.gif" border="0"></span>&nbsp;
        <span class="font12 colorblue" style="float:left;">Install Process Flow by steps</span> </span></th>
      </tr>
      <tr>
        <td><div id="installType" class="font12" style="margin-top:10px;">
            <p class="pge6 p5"><strong>Step:1</strong></p>
            <p>If all the Initial system check has passed then give next in the bottom of this page.</p>
            <p>1. Given the host name correctly. For example. &quot;localhost&quot;.</p>
            <p>2. Give the database details - User, Password and DB name correctly. If database has not created yet then first create the database.</p>
            <p class="pge6 p5"><strong>Step:2</strong></p>
            <p>1. Give your site title and admin email id and password.</p>
            <p>2. If there is any problem while installation contact us for clearification.<br>
              <br>
          </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>

      <input name="current_step" value="0" type="hidden">
      <table class="stdTable" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td><input name="goto" value="Back" type="hidden"></td>
            <td><input class="next"  value="" style="cursor:pointer" type="submit"/></td>
          </tr>
        </tbody>
      </table>  
          </td>
      </tr>
    </tbody>
  </table>
  <br/>
<div align="center" > <p  style="width:730px; text-align:center;">Copyright &copy;NDOT Auction 2011 - 2012 Premium Version 1.1 developed by web development company <a href="http://www.ndot.in" alt="NDOT" >NDOT</a></p></div>

  </td>
  </tr>
  </tbody>
  </table>
</form>
</div>
</body>
</html>
<?php exit;?>
