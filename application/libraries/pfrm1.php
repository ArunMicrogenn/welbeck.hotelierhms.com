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
}