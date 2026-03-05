<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<!--[if gt IE 8]><!-->
<html class="no-js" lang="zxx">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Microgenn PMS</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!DOCTYPE html>
<html>
<head>
<title>Web Frontoffice :: Microgenn</title>
<!-- For-Mobile-Apps -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="User Icon Login Form Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->
<!-- Style --> <link rel="stylesheet" href="<?php echo scs_skin?>css/style.css" type="text/css" media="all" />
</head>
<body>
<div class="container">
<h1>Frontoffice</h1>
<form action="<?php echo scs_index?>login"  method="post">
     <div class="contact-form">
	 <div class="profile-pic">
	 <img src="<?php echo scs_skin?>images/1.png" alt="User Icon"/>
	 </div>	 
	 <div class="signin">    
	      <input type="text" placeholder="User Name" name="username" class="user"  " />
		    <input type="password" placeholder="Password" name="password"  class="pass" " />
					  <!--p><a href="#">Forgot Password?</a></p-->		  
   
	 </div>	 
	      <input type="submit" value="Login" />
	 </div>
   </form>
</div>
<div class="footer">
     <p>Copyright &copy; 2022 All Rights Reserved | Design by <a href="http://microgenn.com">Microgenn</a> || Version 1.0</p>
</div>
</body>
</html>