<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Configurations','Sms Configuration');
$this->pfrm->FrmHead2('Configurations / Sms Configuration',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 
?>
 

<div class="col-sm-12">
  <div class="the-box F_ram">
    <fieldset>
    <div class="table-scrollable">
        <table class="table table-hover table-checkable order-column full-width" id="example">
            <thead>
                <tr>
                    <th class="center">S.No</th>
                    <th class="center">Template Name</th>												
                    <th class="center">Template</th>                                              
                    <th class="center">Action </th>                                              
                </tr>
            </thead>
            <?php 
            	$sql="select * from mas_smsmessage ";
                    $qry = $this->db->query($sql);
                    $count=1;
                     foreach($qry->result_array() as $row)
                        {	$Tname=$row['TemplateName'];														
                            $msg=$row['Template'];
                            $Tid=$row['TemplateId']	;
                          												
             ?>
            <tbody>
                    <tr class="odd gradeX">	
                    <td class="center"><?php echo $count; ?></td>
                    <td class="Right"><?php echo $Tname; ?></td>
                    <td  class="Right"><?php echo $msg; ?></td>																													
                    <td class="center">                 
                    <?php 
                        echo '<a class="btn btn-warning btn-xs" href="'.scs_index.$F_Class."/".$F_Ctrl."_Edit/".$Tid.'/UPDATE"   >
                      <i class="fa fa-edit"></i> Edit</a>';
                      ?>
                    </td>
                    </tr>										
            </tbody>
            <?php 
            $count++; } ?>
        </table>
    </div>
    </fieldset>
  </div>
  <div class="the-box D_IS" ></div>
</div>



<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>