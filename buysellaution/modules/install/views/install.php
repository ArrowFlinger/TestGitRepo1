<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<title>NDOT Auction Script Premium Version 1.1 Installation Step 1</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<style type="text/css">

<!-- style.css start-->

body{margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px; }
 
.instal_outer{ width:960px; margin:0px auto; overflow:hidden;}
.instal_logo{ width:210px; margin:10px 0px 20px 0px; background:url(images/ndot_installogo.png);  overflow:hidden; height:120px; }
.instal_inner{ width:954px; margin:0px auto; overflow:hidden; border:1px solid #DCDCDC; padding:2px; padding-bottom:20px;}
.instal_inner h1{   margin:0px auto; padding:0px 0px 5px 10px; overflow:hidden; font-family:Tahoma; font-weight: normal; background:#DCDCDC; font-size:28px;}
.instal_inner p{  margin:0px auto;margin-bottom:20px; padding: 20px 10px 10px 10px; line-height:20px;   overflow:hidden; font-family:Tahoma; font-weight: normal;   font-size:14px;  }
.mauto{ margin:0px !important;   text-align:center; border-top:#DCDCDC 1px solid;  overflow:hidden; padding:15px !important; font-size:17px!important;margin-bottom: 0px!important;}

.instal_inner .table1{border:1px solid #DCDCDC; background:#EDEDED;   padding:15px;margin-top:10px;padding-bottom:5px;}
.instal_inner .table1 td{  color:#AB1212; font-size:13px; font-weight:bold;background:#EDEDED; padding:15px; padding-bottom:5px; }
.ins_next{  float:left; margin:20px 0px 20px 0px;}
.ins_next input{ height:28px; width:82px;float:left; border:solid #7A7A7A; background:url(<?php echo url::base();?>public/installation_images/install_next.jpg); border:0px; cursor:pointer; }
.instal_footer{ color:#2F2F2F; font-size:13px; text-align:center; margin-top:10px;	}
.instal_inner form{ padding:0px; margin:0px;}

.instal_inner .table2{  background:#fff;   margin-top:20px;  }
.instal_inner .table2 td{  color:#000; font-size:13px; font-weight:bold;  padding: 5px; } 
.instal_inner .step2tex{    border-top:1px solid #7A7A7A; background:#E8E8E8; border-right:1px solid #7A7A7A; width:196px;}
input.reset{ width:82px; height:28px;  background:url(images/instal_reset.gif); margin-left:20px;border:none;}
input.next { width:82px; height:28px;  background:url(<?php echo url::base();?>public/installation_images/install_next.jpg);border:none;}
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


body {
	width: 100% !important;
	margin: 0 auto;
	font-family: sans-serif;
	font-size: 11px;
}
td {
	margin: 0 auto;
	font-family: sans-serif;
	font-size: 11px;
	}

#tests table {
	border-collapse: collapse;
	width: 100%;
}
#tests table th, #tests table td {
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
<table class="shell" align="center" border="0" cellpadding="5" cellspacing="5" style="margin-top:10px; border:5px solid #ddd;">
<tbody>
  <tr>
    <th width="500" class="colorblue" align="left"> <h3 align="center">NDOT Auction Script Premium Version 1.1 Installation...</h3></th>
  </tr>
  <tr>
    <td colspan="2" id="ready_image"><a href="http://http://www.ndot.in/products/auctions-opensource-bidding-application/" target="_blank" title="Auction"> <img src="<?php echo url::base();?>public/installation_images/install.png" alt="Auction" border="0" height="190" width="698" style="margin-top:10px;"></a></td>
  </tr>
  <tr>
    <td>&nbsp;
    <h2 style="border-bottom:1px solid #ddd; background:#ececec; padding:5px;">STEP 1 of 2</h2>
	<div align="center" > For installation instructions <a href="<?php echo url::base();?>readme.txt" target="_blank" title="NDOT">Readme.txt</a></div>
      <p>
        <?php  
	$error_msg = null;

	if(isset($errors_msg))
	{
		//print_r($errors_msg);exit;	
		foreach($errors_msg as $key=>$value){
			$error_msg .='<font color="red">'.$value.'</font><br/>';	
		}
	}

	
		
	if(count($error_codes) > 0){
	
		foreach($error_codes as $error_code){
			
			$error_msg .='<font color="red">'.$validation_msg[$error_code].'</font><br/>';
			
		}
	}
	
	if($error_msg){
		echo $error_msg;
	}
?>
<script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>

<form action="<?php echo url::base();?>install/install/" method="post" name="install_form" id="install" >
  <table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
<tr><td width="414">
  <div align="center">
    <table width="422" border="0" >
      <tr><td width="184">Host Name
    <td width="10">
    <td width="10">:</td>
    <td width="201"><input type="text" name="hostname" maxlength="64" value="<?php echo $validator_msg['hostname'];?>"  class="required" title="Enter your hostname"/></td></tr>
      <tr><td>Database Name<td><td>:</td><td><input type="text" name="database" value="<?php echo $validator_msg['database'];?>"  maxlength="64" class="required" title="Enter your database name correctly"/></td></tr>
      <tr><td>DB Username<td><td>:</td><td><input type="text" name="username" value="<?php echo $validator_msg['username'];?>"  class="required" maxlength="32" title="Enter your database user name"/></td></tr>
      <tr><td>DB Password<td><td>:</td><td><input type="password" name="password" class="" maxlength="32" title="Enter your database password"/></td></tr>
      <tr><td>Table Prefix<td><td>:</td><td><input type="text" name="prefix" maxlength="32" value="auction_" /></td></tr>
     
    </table>
  </div></td><td width="10"></td></table>
</td></tr></table>&nbsp;
<table width="722" border="0">
  <tr>
    <td><div align="right">
      <input name="step2" type="submit" value="" class="next" style="cursor:pointer;"/>
    </div></td>
  </tr>
</table>
</form>
</p> 

 </div>
    <div class="instal_footer" style="text-align:center;">Copyright &copy;NDOT Auction 2011 - 2012 Premium Version 1.1 developed by web development company <a href="http://www.ndot.in" alt="NDOT" >NDOT</a> </div>
    </div>
</body>
</html>
<?php exit;?>
