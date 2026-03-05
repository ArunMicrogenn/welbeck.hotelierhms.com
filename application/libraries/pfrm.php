<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pfrm {

        public function FrmHead1($Title,$load,$view)
        { 
			echo  '<form name="scsfrm" id="scsfrm" >';
			echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					<a href="'.scs_index.$view.'" class="btn   btn-danger btn-sm pull-right" ><i class="fa fa-eye" aria-hidden="true"></i> VIEW</a> 
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> ADD</a> </div>
					<div class="box-body">';		 
			 	   
        }  

		public function FrmHead9($Title,$load,$view)
        { 
			echo  '<form name="scsfrm" id="scsfrm" >';
			echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a> </div>
					<div class="box-body">';		 
			 	   
        } 
		public function wrmHead1($Title,$load,$view)
        {
			 //echo  '<form name="scsfrm" id="scsfrm" >';
			echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					<a href="'.scs_index.$view.'" class="btn   btn-danger btn-sm pull-right" ><i class="fa fa-eye" aria-hidden="true"></i> VIEW</a> 
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a> </div>
					<div class="box-body">';
			 
			 	   
        }
		public function FrmHead2($Title,$load,$view)
        {
			echo  '<form name="scsfrm" id="scsfrm" >';
			echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>					 
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a> </div>
						<div class="box-body">'; 
			 	   
        }
		public function FrmHead3($Title,$load,$view)
        {
			$link = 'Transaction/RoomstatusOnline';
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
			 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			 echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>


					<a href="'.scs_index.$link.'" id="back" class="btn btn-danger btn-sm pull-right" > back</a>
					 
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a> </div>
					
					<div class="box-body">';
        }
		public function FrmHead4($Title,$load,$view)
        {
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
		    $load = "Transaction/RoomstatusOnline";
			$printing="'printing'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					
					 
					<a href="#" id="Rload" onclick="printDiv('.$printing.')" class="btn btn-success btn-sm pull-right" > Print</a>
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-danger btn-sm pull-right" >Back</a> </div>
					<div class="box-body">';		 
			 	   
        }
		public function FrmHeader($Title,$load,$view)
        {
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
		    $load = "Reprint/CheckoutBill";
			$printing="'printing'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					
					 
					<a href="#" id="Rload" onclick="printDiv('.$printing.')" class="btn btn-success btn-sm pull-right" > Print</a>
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-danger btn-sm pull-right" >Back</a> </div>
					<div class="box-body">';		 
			 	   
        }
		public function FrmHead7($Title,$load,$view)
        {
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
		    $load = "Transaction/RoomstatusOnline";
			$printing="'printing'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>				 
					<a href="'.scs_index.'" id="Rload" class="btn btn-danger btn-sm pull-right" >Home</a> </div>
					<div class="box-body">';		 
			 	   
        }
		
		public function FrmHead5($Title,$load,$view)
        {
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			$printing="'exporttable'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3> 
					<a href="#"  id='.$printing.' class="btn btn-success btn-sm pull-right" >Export</a>
					<div class="box-body">';		 
			 	   
        }

		public function FrmHead6($Title,$load,$view)
        {
		//	 echo  '<form name="scsfrm" id="scsfrm" >';
		//	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		//	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
		    $load = "Transaction/RoomstatusOnline";
			$printing="'printing'";
			$excel="'exporttable'";
			$pdf="'exportpdf'";
			echo '<section class="content">
				   <div class="box">
				   <div class="box-header with-border">
					<h3 class="box-title">'.$Title.'</h3>
					
					 
					<a href="#" id="Rload" onclick="printDiv('.$printing.')" class="btn btn-success btn-sm pull-right pt"> Print</a>
					<a href="#"  id='.$excel.' class="btn btn-success btn-sm pull-right ex" >Excel</a>
					<a href="#"  id='.$pdf.'  class="btn btn-success btn-sm pull-right pd" >Pdf</a>
					<a href="'.scs_index.$load.'" id="Rload" class="btn btn-danger btn-sm pull-right bc">Back</a> </div>
					<div class="box-body">';		 
			 	   
        }
		public function FrmHeadD($Title,$load,$view)
        {
			 echo  '<form name="scsfrm" id="scsfrm" >';			 
			 echo '<section class="content">
				   <div class="box">				 
					<div class="box-body">';		 
			 	   
        }
		 public function FrmFoot()
		 {
			 echo '   </div></div></section></form>';
		 }
		  public function wrmFoot()
		 {
			 echo '   </div></div></section>';
		 }

		 public function FrmHead11($Title,$load,$view)
		 { 
			//  echo  '<form name="scsfrm" id="scsfrm" >';
			//  echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			//  echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			 echo '<section class="content">
					<div class="box">
					<div class="box-header with-border">
					 <h3 class="box-title">'.$Title.'</h3>
					 <a href="'.scs_index.$view.'" class="btn   btn-danger btn-sm pull-right" ><i class="fa fa-eye" aria-hidden="true"></i> VIEW</a> 
					 <a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> ADD</a> </div>
					 <div class="box-body">';		 
					 
		 } 


		 public function FrmHead12($Title,$load,$view)
		 { 
			//  echo  '<form name="scsfrm" id="scsfrm" >';
			//  echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
			//  echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			 echo '<section class="content">
					<div class="box">
					<div class="box-header with-border">
					 <h3 class="box-title">'.$Title.'</h3>
					 <a href="'.scs_index.$load.'" id="Rload" class="btn btn-success btn-sm pull-right" ><i class="fa fa-refresh" aria-hidden="true"></i> Reload</a> </div>
					 <div class="box-body">';		 
					 
		 } 
		 public function FrmHead8($Title,$load,$view)
		 {
		 //	 echo  '<form name="scsfrm" id="scsfrm" >';
		 //	 echo '<input type="hidden" name="Mname" id="Mname" value="'.$load.'"  >';
		 //	 echo '<input type="hidden" name="Scs_index" id="Scs_index" value="'.scs_index.'"  >';
			 $load = "Transaction/RoomstatusOnline";
			 $printing="'printing'";
			 $pdf="'exportpdf'";
			 echo '<section class="content">
					<div class="box">
					<div class="box-header with-border">
					 <h3 class="box-title">'.$Title.'</h3>
					 
					  
					 <a href="#" id="Rload" onclick="printDiv('.$printing.')" class="btn btn-success btn-sm pull-right" > Print</a>
					 <a href="#"  id='.$pdf.'  class="btn btn-success btn-sm pull-right" >Pdf</a>
					 <a href="'.scs_index.$load.'" id="Rload" class="btn btn-danger btn-sm pull-right" >Back</a> </div>
					 <div class="box-body">';		 
					 
		 }
}