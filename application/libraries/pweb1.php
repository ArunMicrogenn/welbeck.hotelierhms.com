<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pweb1 {

        public function phead()
        {
			 echo '<!DOCTYPE html>
				   <html><head><meta charset="utf-8">
  				   <meta http-equiv="X-UA-Compatible" content="IE=edge">
                   <title>Microgenn PMS</title>';
			 echo '<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">';
			 	   
        }
		public function ltop()
        {
			echo '</head>';
		}
		public function wtop()
        {
			echo '</head><body class="hold-transition skin-green-light sidebar-mini">';
			echo '<div class="wrapper">';
		} 
		public function wheader($Session)
		{
			  echo '<header class="main-header">				 
				    <a href="'.scs_index.'welcome/main" class="logo">				   
				    <span class="logo-mini"><img src="'.scs_url.'assets/lak.PNG" ></span>				  
				    <span class="logo-lg"><img src="'.scs_url.'assets/lak.PNG" ></a> ';
			  
			  echo '<nav class="navbar navbar-static-top">
			        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				    </a>
			       ';
			  echo ' <div class="navbar-custom-menu"><ul class="nav navbar-nav ">
			        <li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					  <img src="'.scs_url.'assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
					  <span class="hidden-xs">'.@$Session->userdata['POS']['EmailId'].'</span>
					</a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                   <img src="'.scs_url.'assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  '.@$Session->userdata['POS']['EmailId'].'
                   
                </p>
              </li>
              <!-- Menu Body -->
               
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="'.scs_index.'login/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
				   </ul></div>
				   ';	   		
					    
			  echo ' </nav></header>';
		}
		
		public function Menu($Menu,$Session)
		{
			echo '<aside class="main-sidebar">';
			echo ' <section class="sidebar">';
			
			$this->UserPanel($Session);
			 $Menu->Menu_($Menu);
			
			echo '</ul></section></aside><div class="content-wrapper">';
		}
		public function wfoot()
        {
			
			echo '</div></div>
			
			<div id="dialogcity" title="City" style="display:none;" ><fieldset>
  			
  			<div  id="City_View" ></div></fieldset></div>	
			<div id="dialogDesignation" title="Designation" style="display:none;" ><fieldset>
  			
  			<div  id="Designation_View" ></div></fieldset></div>		
			</body></html>';
			/*<input id="Supplier_Item" onkeyup="Supplier_ser(this.value)" type="search"   class="search"> */
		}
		
		//##############################
		
		public function UserPanel($Session)
		{
			echo '<div class="user-panel">
					<div class="pull-left image">
					  <img src="'.scs_url.'assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
					</div>
					<div class="pull-left info">
					  <p>'.@$Session->userdata['POS']['EmailId'].'</p>
					  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
				  </div>';
		}
		public function Cheader($Menu,$Title)
		{
			echo '<section class="content-header">
				  <h5>'.$Menu.'</h5>
				  <ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> '.$Menu.'</a></li>
					<li><a href="#">'.$Title.'</a></li>
					 
				  </ol>
				</section>';
		}
}