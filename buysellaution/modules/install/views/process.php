<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>NDOT Installation</title>
<link rel="stylesheet" href="/modules/install/views/style.css" type="text/css">
        <script src="/public/js/jquery.js" type="text/javascript"></script>

    <script src="/public/themes/default/js/jquery.validate.js" type="text/javascript"></script>
    
    <script src="/public/js/jquery.validate.js" type="text/javascript"></script>
<style type="text/css">
<!-- style.css start-->

body{margin:0px; padding:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px; }
 
.instal_outer{ width:960px; margin:0px auto; overflow:hidden;}
.instal_logo{ width:210px; margin:10px 0px 20px 0px; background:url(images/ndot_installogo.png);  overflow:hidden; height:120px; }
.instal_inner{ width:954px; margin:0px auto; overflow:hidden; border:1px solid #DCDCDC;}
.instal_inner h1{   margin:0px auto; padding:0px 0px 5px 10px; overflow:hidden; font-family:Tahoma; font-weight: normal; background:#DCDCDC; font-size:28px;  }
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
.instal_inner .table2 td input="password" , .instal_inner .table2 td input="text" { width: 184px;}
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

body {margin: 0 auto; font-family: sans-serif; font-size: 90%; }
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

</style>
    

<SCRIPT language=JavaScript type=text/javascript>
function checkrequired(which) {
var pass=true;
if (document.images) {
for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
if (tempobj.name.substring(0,8)=="title" || tempobj.name.substring(0,8)=="email" || tempobj.name.substring(0,8)=="name" || tempobj.name.substring(0,8)=="password" || tempobj.name.substring(0,8)=="tbname") {
if (((tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text"||tempobj.type=="text")&&
tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&&
tempobj.selectedIndex==0)) {
pass=false;
break;
}
}
}
}
if (!pass) {
shortFieldName=tempobj.name.substring(8,30).toUpperCase();
alert("Please enter all required fields.");
return false;
}
else
return true;
}

$(document).ready(
  function()
  {
	 // show
	   $("#yourtable").click(function()
	    {
		$("#tblshow").show("slow");
	    });
		 // hide
	   $("#ndottable").click(function()
	    {
		$("#tblshow").hide("slow");
	    }); 
  });
</script>
</head>
<body>	
    <div class="instal_outer">
<div class="instal_logo"></div>
<div class="instal_inner">
<h1>Ndot Auction Script Package Install </h1>
<?php
	$error_msg = null;
	if(isset($errors_msg))
	{
		//print_r($errors_msg);exit;	
		foreach($errors_msg as $key=>$value){
			$error_msg ='<font color="red">'.$value.'</font><br/>';	
		}
	}

	if($error_msg){
		echo $error_msg;
	}

?>
<script type="text/javascript">

$(document).ready(function(){$("#install").validate();});

</script>
<form action="" method="post" name="install_form" id="install" >

<table border="0" align="center" cellpadding="5" cellspacing="5"  class="table2">
<tr><td width="516">
<table width="506" border="0" >
<tr><td width="212">Your Application Name
<td width="10">
<td width="8">:</td>
<td width="268"><input type="text" name="title" value="Ndot Auction Script" maxlength="50" class="required" size="25" title="Enter your Application Name"/></td></tr>
<tr><td>Admin Email id<td><td>:</td><td><input type="text" name="email" value="<?php echo $validator_msg['email'];?>" maxlength="128" class="email required" size="25" title="Enter an e-mail" /></td></tr>
<tr><td>Admin Name<td><td>:</td><td><input type="text" size="25" name="name" value="<?php echo $validator_msg['name'];?>" class="required" maxlength="32" title="Enter the admin name" /></td></tr>
<tr><td>Admin Password<td><td>:</td><td><input type="password" size="25" name="password" maxlength="32" class="required" title="Enter the password"/></td></tr>
 <tr><td>Your License Key<td><td>:</td><td><input type="text" name="apikey" title="Enter the API Code" class="required" size="25" /></td></tr>
<input type="hidden" name="table" value="ndottbl" id="ndottable" title="Create Ndot's User Table"/>


<table width="420" border="0">
<tr><td width="225" align="right"><input name="" type="reset" value="" class="reset"/><td width="13">
<td width="45"></td>
<td width="119"><input name="" type="submit" value="" style="cursor:pointer" class="next"/></td></tr>
</table>
</td>
  </table>
</td></tr></table>

</div>
    <div class="instal_footer">Copyright &copy;NDOT Auction 2011 - 2012 Premium Version 1.1 developed by web development company <a href="http://www.ndot.in" alt="NDOT" >NDOT</a></div>
    </div>
</body>
</html>
<?php exit;?>
