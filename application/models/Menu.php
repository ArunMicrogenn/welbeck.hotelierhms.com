<?php

class Menu extends CI_Model
{
	function __construct()
    {
        parent::__construct();
		if(@$this->session->userdata['POS'])
		{
			foreach (@$this->session->userdata['POS'] as $key => $item) {
				define($key,$item);
			}
		}
		
	 
    }
// 	function Menu_($Menu, $Session)
// {
  
//     $user_id = @$Session->userdata['POS']['User_id'];
//      $sql = "
//         SELECT  
//             mn.Menu AS menu_name, 
//             mainmnu.mainMenu AS main_menu_name, sbmnu.Des AS sub_menu_des,
//             sbmnu.Smenu AS sub_menu_name,
//             sbmnu.submenu_id,
//             mn.Menu_Id,
//             mainmnu.Mainmenu_id
//         FROM menu mn
//         INNER JOIN MainMenu mainmnu ON mainmnu.Menu_id = mn.Menu_Id 
//         INNER JOIN SubMenu sbmnu ON sbmnu.mainMenu_Id = mainmnu.mainMenu_Id 
//         INNER JOIN User_GroupRights ugr ON ugr.SubMenu_Id = sbmnu.SubMenu_Id  
//             AND mainmnu.Mainmenu_id = sbmnu.Mainmenu_id 
//         INNER JOIN usergroup ug ON ug.UserGroup_Id = ugr.UserGroup_Id 
//         INNER JOIN usertable us ON us.UserGroup_Id = ug.UserGroup_Id  
//             AND us.UserGroup_Id = ugr.UserGroup_Id 
//         WHERE us.User_id = ?
//         ORDER BY mn.Menu_id, mainmnu.mainmenu
//     ";

//     $query = $this->db->query($sql, [$user_id]);
//     $results = $query->result();


//     $menu_tree = [];

//     foreach ($results as $row) {
//         $menu = $row->menu_name;
//         $main_menu = $row->main_menu_name;
//         $sub_menu = $row->sub_menu_name;
// 		$sub_menu_des = $row->sub_menu_des;



//         if (!isset($menu_tree[$menu])) {
//             $menu_tree[$menu] = [];
//         }

//         if (!isset($menu_tree[$menu][$main_menu])) {
//             $menu_tree[$menu][$main_menu] = [];
//         }

// 		if (!isset($menu_tree[$menu][$main_menu])) {
//             $menu_tree[$menu][$main_menu] = [];
//         }

//         $menu_tree[$menu][$main_menu][] = $sub_menu;

	
//     }

//     echo '<ul class="sidebar-menu" data-widget="tree">';
//     echo '<li><a href="' . scs_url . '"><i class="fa fa-dashboard"></i> Dashboard</a></li>';

//     foreach ($menu_tree as $menu => $main_menus) {
//         echo '<li class="treeview">';
//         echo '<a href="#"><i class="fa fa-folder"></i> <span>' . htmlspecialchars($menu) . '</span> <i class="fa fa-angle-left pull-right"></i></a>';
//         echo '<ul class="treeview-menu">';

//         foreach ($main_menus as $main_menu => $sub_menus) {
			
//             echo '<li class="treeview">';
//             echo '<a href="#"><i class="fa fa-folder-open"></i> ' . htmlspecialchars($main_menu) . ' <i class="fa fa-angle-left pull-right"></i></a>';
//             echo '<ul class="treeview-menu">';

//             foreach ($sub_menus as $sub_menu) {
//                 echo '<li><a href="' . scs_url . 'index.php/' . $menu . '/' . $sub_menu_des . '"><i class="fa fa-circle-o"></i> ' . $sub_menu . '</a></li>';
// 				// echo '<li><a href="' . site_url(urlencode($menu) . '/' . urlencode($sub_menu_des)) . '"><i class="fa fa-circle-o"></i> ' . htmlspecialchars($sub_menu) . '</a></li>';

//             }

//             echo '</ul></li>';
//         }

//         echo '</ul></li>';
//     }

//     echo '</ul>';
// }


// old menu 5-9-2025


// function Menu_($Menu,$Session)
// 	{

// 		<ul class="sidebar-menu" data-widget="tree">
//          <ul class="sidebar-menu">
//          <li style="background-color:rgba(221,216,216,1.00)" ><a href="<php echo scs_url;>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
//          <!-- <li style="background-color:rgba(221,216,216,1.00)" ><a href="<?php echo scs_index;>Report/dailycollection"><i class="fa fa-dashboard"></i> Collection Report </a></li> -->

//         <?php 
// 	    $qry=" EXEC dbo.Gen_Menu ".@$Session->userdata['POS']['User_id'];
// 	   $res=$this->db->query($qry);
// 	   $categories = array("Categories" => array());
// 	   foreach($res->result() as $row)
// 	   {
// 		   $category = array(); 
// 		   $category["Menu"] =$row->Menu;
// 		   $category["Icon"] = $row->Icon;		  
// 		   $category["Des"] = $row->Des;	  
// 		   $category["main_categories"] = array(); 
		   
// 		   $qry1=" EXEC dbo.Gen_Mainmenu ".$row->Menu_Id.",".@$Session->userdata['POS']['UserGroup_Id'];
// 		 $sres1=$this->db->query($qry1);
// 		 foreach($sres1->result() as $srow1)
// 		  { 
// 		    $maincat = array();
// 			$maincat["Menu"] = $srow1->Mainmenu;
// 			$maincat["Icon"] = $srow1->Icon;	
// 			$maincat["Des"] = $srow1->Des;	
// 			$maincat["sub_categories"] = array();   			
		   
// 		   $qry=" EXEC dbo.Gen_Sub ".$srow1->Mainmenu_id.",".@$Session->userdata['POS']['UserGroup_Id'];
// 	        $sres=$this->db->query($qry);
// 		    foreach($sres->result() as $srow)
// 		    {
// 			   $subcat = array();
// 			   $subcat["Menu"] = $srow->Smenu;
//                $subcat["Des"] = $srow->Des;
// 			   array_push($maincat["sub_categories"], $subcat);
// 		    }
// 			array_push($category["main_categories"], $maincat);
// 		  }
		   
// 		   array_push($categories["Categories"], $category);
// 	   } 
	   
// 	   $data= json_encode($categories);
// 		   $data=json_decode($data,true);
		 
	 
// 		   foreach($data['Categories']   as $da)
// 		   {
// 			   if($da['Menu']!="")
// 				  {
// 					  $Rep="#";
			        		   
// 			     echo '<li class="treeview amenus '.$da['Des'].'  "  >
// 			         <a href="'.$Rep.'" class="menuclo" style="color:FFF" > <i class="'.$da['Icon'].' icon-sidebar"></i>
// 					 <i class="fa fa-angle-right chevron-icon-sidebar"></i> '.$da['Menu'].' </a>
// 					 <ul class="treeview-menu D_'.$da['Des'].'">';
					 
// 					 foreach($da['main_categories']   as $da1)
// 					 {   echo '<li class="treeview amenus '.$da1['Des'].'  "  >
// 						 <a href="'.$Rep.'" class="menuclo" style="color:FFF" > <i class="'.$da1['Icon'].' icon-sidebar"></i>
// 						 <i class="fa fa-angle-right chevron-icon-sidebar"></i> '.$da1['Menu'].' </a>
// 						 <ul class="treeview-menu D_'.$da1['Des'].'">';
// 							foreach($da1['sub_categories']  as   $Sub)
// 							 {
// 								// print_r(count($Sub));
								 
// 								 echo '<li class="S_'.$Sub['Des'].'" > <a href="'.scs_url.'index.php/'.$da['Des'].'/'.$Sub['Des'].'"><i class="fa fa-circle-o"></i> '.$Sub['Menu'].'</a></li>';
// 							 }
// 						echo ' </ul></li>';
// 					 }
					 
// 					echo ' </ul></li>';
// 			    }
// 		   }
   
   
//    >
 
 
// <?php
		 
// 		return ;
// 	}



// New menu 5-9-2025

function Menu_($Menu, $Session)
{


    ?>
    <ul class="sidebar-menu" data-widget="tree">
        <!-- Dashboard -->
        <li class="active">
            <a href="<?php echo scs_url; ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>

        <?php
        // Get Top Menus
        $qry = "EXEC dbo.Gen_Menu " . @$Session->userdata['POS']['User_id'];
        $res = $this->db->query($qry);
        $categories = ["Categories" => []];

        foreach ($res->result() as $row) {
            $category = [
                "Menu" => $row->Menu,
                "Icon" => $row->Icon,
                "Des"  => $row->Des,
                "main_categories" => []
            ];

            // Get Main Menu
            $qry1 = "EXEC dbo.Gen_Mainmenu " . $row->Menu_Id . "," . @$Session->userdata['POS']['usergroup_id'];
            $sres1 = $this->db->query($qry1);
            foreach ($sres1->result() as $srow1) {
                $maincat = [
                    "Menu" => $srow1->Mainmenu,
                    "Icon" => $srow1->Icon,
                    "Des"  => $srow1->Des,
                    "sub_categories" => []
                ];

                // Get Sub Menu
                $qry2 = "EXEC dbo.Gen_Sub " . $srow1->Mainmenu_id . "," . @$Session->userdata['POS']['usergroup_id'];
                $sres2 = $this->db->query($qry2);
                foreach ($sres2->result() as $srow2) {
                    $subcat = [
                        "Menu" => $srow2->Smenu,
                        "Des"  => $srow2->Des
                    ];
                    $maincat["sub_categories"][] = $subcat;
                }
                $category["main_categories"][] = $maincat;
            }
            $categories["Categories"][] = $category;
        }

        $data = $categories;

        // Build HTML
        foreach ($data['Categories'] as $da) {
            if ($da['Menu'] != "") {
                echo '<li class="treeview">
                        <a href="#">
                            <i class="'.$da['Icon'].'"></i>
                            <span>'.$da['Menu'].'</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">';
                foreach ($da['main_categories'] as $da1) {
                    echo '<li class="treeview">
                            <a href="#">
                                <i class="'.$da1['Icon'].'"></i> '.$da1['Menu'].'
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">';
                    foreach ($da1['sub_categories'] as $Sub) {
                        echo '<li>
                                <a href="'.scs_url.'index.php/'.$da['Des'].'/'.$Sub['Des'].'">
                                    <i class="fa fa-circle-o"></i> '.$Sub['Menu'].'
                                </a>
                              </li>';
                    }
                    echo '</ul></li>';
                }
                echo '</ul></li>';
            }
        }
        ?>
    </ul>


    <?php
    return;
}


	function TopMenu_($Session)
	{   $notificounts='0';
		$sql="select StartDate,EndDate from Mas_Hotel where Hotel_Id=1";
		$exec=$this->db->query($sql); 
		foreach ($exec->result_array() as $rows)
		{		
		$aa_date =date_create(date('Y-m-d')); // convert the date to string
		$l_date=date_create($rows['EndDate']);
		$diff=date_diff($aa_date ,$l_date );
		$difference = $diff->format("%a");
		}
		if($difference <= 5)
		{
			$notificounts=$notificounts+'1';
		}		
		echo ' <div class="navbar-custom-menu">
		<ul class="nav navbar-nav ">
		 <li class="dropdown user user-menu">
			 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			 <i class="fa fa-bell-o"></i>
			 <span class="badge headerBadgeColor1">'.$notificounts .'</span>
			 </a>
			 <ul class="dropdown-menu">
				<li class="external"><h3><span class="bold">Notifications</span></h3>
				<span class="notification-label blue-bgcolor">New '.$notificounts .'</span></li>
				 <!-- User image -->';
				 if($difference <= 5)
				 {
					echo '<li class="user-header"><a  id="Subscription"><span class="notification-icon circle yellow"><i class="fa fa-warning"></i></span> Your Subscription will expire soon</a></li>';
				 }
			echo	' 				 
				 <!-- Menu Body -->               
			 </ul>
		 </li>
		</ul>
	 </div>  ';	
	}
	
	
	
	function Sms_Footer()
    {  
		$sql = "select isnull(whatsappBusinessSms,0) as wbsmsflag from extraoption";
			$res = $this->db->query($sql);
			foreach($res->result_array() as $row){
				$wbSmsFlag = $row['wbsmsflag'];
				
			}
			if($wbSmsFlag !=0 ){
		?>
        <!-- start footer -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>    
            $(document).ready(function () {
                refresh_Div();
            });

            var i = 1;
            function refresh_Div() {
                $.ajax({
                type: 'POST',
                url: '<?php echo scs_index?>Transaction/WhatsappSmsSending', 
                success: function(message) { 	
                if(message)
                {
					// console.log(message);
                    $( "#top-menu" ).load(window.location.href + " #top-menu" );

                }
                },
                });   
			// console.log("refreshing.....")
             }

            var reloadXML = setInterval(refresh_Div, 10000);
        </script>
		<?php
			}
    }
}
?>
