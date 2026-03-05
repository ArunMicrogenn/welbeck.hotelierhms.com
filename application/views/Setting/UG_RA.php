<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 
<div class="row" >
  <div class="p-2">
  <fieldset style="border:1px solid #DBD5D5;padding:10px" >
  <div class="col-sm-12">
    <legend >Permissions - <?php echo $SMENU ?></legend>
    <?php 
      $qry="SELECT * FROM User_GroupRights where SubMenu_Id='".$UGIDA."' and UserGroup_Id='".$UGID."' ";
      $Res=$this->db->query($qry);
      foreach($Res->result() as $row)
      {  ?> 
       <ul id="tree" style="list-style:none">  
       <li><input Type="checkbox" <?php if($row->FAdd=='1') { ?> checked <?php } ?> onclick="UserRightsGiven(<?php echo $row->GroupRights_Id; ?>,'Add')" id="Add<?php echo $row->GroupRights_Id ?>" name="menuselect" > Add </li>  
       <li><input Type="checkbox" <?php if($row->FEdit=='1') { ?> checked <?php } ?> onclick="UserRightsGiven(<?php echo $row->GroupRights_Id; ?>,'Edit')" id="Edit<?php echo $row->GroupRights_Id ?>" name="menuselect" > Edit</li>  
       <li><input Type="checkbox" <?php if($row->Fview=='1') { ?> checked <?php } ?> onclick="UserRightsGiven(<?php echo $row->GroupRights_Id; ?>,'View')" id="View<?php echo $row->GroupRights_Id ?>" name="menuselect" > View</li>  
       <li><input Type="checkbox" <?php if($row->Fdelete=='1') { ?> checked <?php } ?> onclick="UserRightsGiven(<?php echo $row->GroupRights_Id; ?>,'Delete')" id="Delete<?php echo $row->GroupRights_Id ?>" name="menuselect" > Delete</li>  
    </ul>
    <?php } ?>
    </div>
    </fieldset>
  </div>
</div>
