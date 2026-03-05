
<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class pweb {

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
		public function wheader($Menu,$Session)
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
				   
            $Menu->TopMenu_($Session);     		
					    
			  echo ' </nav></header>';
		}
		public function wheader1()
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
				   </ul></div>   ';
		   echo ' </nav></header>';
	  
		}
		
		public function Menu($Menu,$Session)
		{
			echo '<aside class="main-sidebar">';
			echo ' <section class="sidebar">';
			
			// $this->UserPanel($Session);
			 $Menu->Menu_($Menu,$Session);
			
			echo '</ul></section></aside><div class="content-wrapper">';
		}			
		public function Menu1()
		{
			echo '<aside class="main-sidebar">';
			echo '<section class="sidebar">';
			echo '<ul class="sidebar-menu" data-widget="tree">
				<ul class="sidebar-menu">
				<li style="background-color:rgba(221,216,216,1.00)" ><a href="<?php echo scs_url;?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>';
			
			 //$Menu->Menu_($Menu,$Session);
			
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
		
		
		public function sms_footer($Menu)
		{		
			//  $Menu->Sms_Footer();
		}

		public function timezone() {
			date_default_timezone_set('Asia/Kolkata');
		}
		
		
		public function nightaudit() {
			$this->CI =& get_instance(); 
			date_default_timezone_set('Asia/Kolkata');
		
			$currdate = date('Y-m-d');
		
			$res = $this->CI->db->query("SELECT DateofAudit FROM night_audit ORDER BY DateofAudit DESC");
		
			$showAlert = false;
		
			if ($row = $res->row_array()) {
				$auditdate = date('Y-m-d', strtotime($row['DateofAudit']));
				if ($auditdate < $currdate) {
					$showAlert = true; // Night audit not completed for today
				}
			} else {
				$showAlert = true; // No night audit record found
			}
		
			if ($showAlert) {
				echo '
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        Swal.fire({
            title: "Night Audit Not Completed",
            text: "Kindly do the Date Change Process",
            icon: "warning",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "'.scs_index.'Transaction/PostRent";
            }
        });
    </script>
';
				
			}
			
		}


		
		public function sidebar_style(){
			echo '<style>

	/* Force ALL sidebar text to be white */
.sidebar-menu li a,
.sidebar-menu li a span,
.sidebar-menu li a i,
.sidebar-menu .treeview-menu li a {
    color: #ffffff !important;   /* Always white */
}

/* Hover and active background in gold */
.sidebar-menu li a:hover,
.sidebar-menu li.active > a,
.sidebar-menu li.menu-open > a {
    background-color: #C5A64F !important; /* Gold background */
    color: #ffffff !important; /* Keep text white */
}

/* Submenu text also white */
.sidebar-menu .treeview-menu li a {
    color: #ffffff !important;
}

/* Submenu hover */
.sidebar-menu .treeview-menu li a:hover {
    background-color: #C5A64F !important;
    color: #ffffff !important;
}

/* Make icons white */
.sidebar-menu li a i {
    color: #ffffff !important;
}
.sidebar-menu li a:hover i,
.sidebar-menu li.active > a i,
.sidebar-menu li.menu-open > a i {
    color: #ffffff !important;
}


	/* Sidebar base */
.sidebar-menu {
    width: 100%;
    background-color: #0b2c4d; /* Dark navy */
    min-height: 100vh;
    list-style: none;
    margin: 0;
    padding: 20px 0;
    font-family: "Segoe UI", sans-serif;
	border-radius:10px;
}

/* Sidebar links (default = white text + white icons) */
.sidebar-menu li a {
    display: flex;
    align-items: center;
    padding: 14px 22px;
    font-size: 15px;
    color: #ffffff !important;       /* Text always white */
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.sidebar-menu li a i {
    margin-right: 12px;
    font-size: 16px;
    color: #ffffff !important;       /* Icons always white */
}

/* Spacing between menu items */
.sidebar-menu li {
    margin-bottom: 8px;
}

/* Hover (gold background, black text + black icons) */
.sidebar-menu li a:hover,
.sidebar-menu li a:focus {
    background-color: #d9b54a !important; 
    color: #000000 !important;
}

.sidebar-menu li a:hover i,
.sidebar-menu li a:focus i {
    color: #000000 !important;
}

/* Active state */
.sidebar-menu li.active > a,
.sidebar-menu li.menu-open > a {
    background-color: #d9b54a !important;
    color: #000000 !important;
    font-weight: 600;
}

.sidebar-menu li.active > a i,
.sidebar-menu li.menu-open > a i {
    color: #000000 !important;
}

/* Submenu */
.treeview-menu {
    display: none;
    padding-left: 20px;
    margin-top: 5px;
    background-color: #0b2c4d !important;  /* Dark navy */

}

.treeview-menu li a {
    font-size: 14px;
    padding: 12px 20px;
    color: #ffffff !important;
    /* background-color: #ffffff !important;  */
	   /* White text */
}

.treeview-menu li a i {
    color: #ffffff !important;   /* White icons */
}

.treeview-menu li a:hover {
    background-color: #d9b54a !important;
    color: black !important;
}

.treeview-menu li a:hover i {
    color:black !important;
}

.treeview-menu li.active > a {
    background-color: #d9b54a !important;
    color: #ffffff !important;
    font-weight: 600;
}

.treeview-menu li.active > a i {
    color: #ffffff !important;
}

	.modal-backdrop.in {
		opacity: 0;
	}
</style>';
		}


		public function Dashboard(){
			echo '<style>
  :root {
  --c-navy-900:#001A33;
  --c-navy-800:#01264A;
  --c-accent:#AA933E;
  --c-grey-100:#F4F4F4;
  --c-white:#FFFFFF;

  --ff: "Montserrat", sans-serif;

  --fs-50:50px;
  --fs-30:30px;
  --fs-22:22px;
  --fs-20:20px;
  --fs-18:18px;
  --fs-16:16px;
  --fs-14:14px;
  --fs-12:12px;

  --fw-light:300;
  --fw-regular:400;
  --fw-medium:500;
  --fw-semibold:600;

  --radius:16px;
  --gap:24px;
  --card-bg:#fff;
  --shadow:0 4px 12px rgba(0, 0, 0, 0.21);
}

.icon {
  width: 32px;
  height: 32px;
  display: inline-block;
}
.logo{
  width: 200px;
  height: auto;
  display: block;
}




.bicon{
  border-radius:100%;
  background:var(--c-navy-800);
  padding: 6px;

}

.hiicon{
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  padding: 0%;
  border-radius: 200px;
  border: none;

}

/* GRID */
.grid {
  display:grid;
  height: 100vh;
  grid-template-columns: repeat(12, 1fr);
  grid-template-rows: repeat(10, 1fr);  
  gap: var(--gap);
  gap: 1rem;
}

/* CARD */
.card {
  background:var(--card-bg);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
  padding:16px;
  display:flex;
  flex-direction:column;
  justify-content: space-between;
  overflow: hidden;
  height: 100%;
}
.card--center {
  justify-content:center;
  align-items:center;
  text-align:center;
}
.card--dark {
  background:var(--c-navy-800);
  color:#fff;
}
.card__title {
  font-size:var(--fs-18);
  font-weight:var(--fw-medium);
  margin:0 0 16px;
}
.card__sub {
  font-size:var(--fs-14);
  color:#666;
}
.value {
  font-size:42px;
  font-weight:var(--fw-semibold);
}
.value small {
  font-size:16px;
  opacity:.7;
}

/* CHART PLACEHOLDER */
.chart-placeholder {
  flex:1;
  border-radius:12px;
  background:linear-gradient(135deg, rgba(13,40,69,0.05) 0%, rgba(13,40,69,0.08) 100%);
}
.horizontal-list{
  display: flex;
    list-style: none;
    padding: 0;
    gap: 72px;
  color:#666;
  font-size:var(--fs-14);

}
.table {
  width:100%;
  flex-grow: 1;
  overflow: auto;
  border-collapse:collapse;
  font-size:var(--fs-14);
  text-align: center;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table thead th {
  text-align:left;
  background-color: #F2EEDA;
  font-weight:var(--fw-medium);
  color:#555;
  border-bottom:1px solid #eee;
  padding:12px 8px;
}
.table tbody td {
  border-bottom:1px solid #f0f0f0;
  padding:12px 8px;
}

/* BUTTONS */
.btn {
  border:none;
  outline:none;
  cursor:pointer;
  font-family:inherit;
  border-radius:8px;
  padding:12px 22px;
  font-weight:var(--fw-medium);
  font-size:var(--fs-14);
}

/* .space{
  margin-left: 16px;
  justify-content: space-between;
} */
.btn + .btn { 
  margin-left: 80px;
}
.btn--filled { 
  background:var(--c-accent); 
  color:#fff; 
  box-shadow: inset  4px 4px 10px #d7b109,inset  -4px -4px 10px #615002;
 }
.btn--outline { 
  background:transparent; 
  border:1.6px solid #A8943E; 
  color:#A8943E; 
}
.btn--tonal { 
  background:#F2EEDA; 
  color:#A8943E;
 }


/* GRID AREA LAYOUT */
.area-revenue       { grid-column:1 / span 6; grid-row:1  / span 4; }
.area-room-revenue  { grid-column:7 / span 3; grid-row:1  / span 3; }
.area-reservation   { grid-column:10 / span 3; grid-row:1 / span 3; }
.area-strip         { grid-column:7 / span 6; grid-row:4  / span 2; }
.area-checkin       { grid-column:1 / span 3; grid-row:5  / span 3; }
.area-checkout      { grid-column:4 / span 3; grid-row:5  / span 3; }
.area-available     { grid-column:7 / span 2; grid-row:6  / span 2; }
.area-booked        { grid-column:9 / span 2; grid-row:6  / span 2; }
.area-inuse         { grid-column:11 / span 2; grid-row:6 / span 2; }
.area-connection    { grid-column:1 / span 3; grid-row:8  / span 3; }
.area-table         { grid-column:4 / span 9; grid-row:8  / span 3; }

   .btn--filled {
      background: #b59e5f;
      color: white;
    }

    .btn--outline {
      background: white;
      border: 1px solid #ccc;
      color: #333;
    }

    .space {
      margin-top: 18px;
    }

    .chart-placeholder {
      position: relative;
      height: 300px;
    }
</style>
';
		}

		


		
		
}


