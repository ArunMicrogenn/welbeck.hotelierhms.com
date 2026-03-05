<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
//$this->pweb->Cheader('Transaction','RoomStatusOnline');
//$this->pfrm->FrmHead1('Transaction / RoomStatusOnline',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
?>
<?php
$res = $this->db->query("SELECT DateofAudit FROM night_audit ORDER BY DateofAudit DESC");

if ($row = $res->row_array()) {
  $auditdate = date('Y/m/d', strtotime($row['DateofAudit']));
}
// date_default_timezone_set('Asia/Kolkata'); 
?>

<?php
  $sql = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Checkin') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql);
foreach ($exe->result_array() as $row) {
  $view = $row['Fview'];
  $edit = $row['FEdit'];
  $add = $row['FAdd'];
  $delete = $row['Fdelete'];
}
 $sql1 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Allowance') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "') ";
$exe = $this->db->query($sql1);
foreach ($exe->result_array() as $row) {
  $aview = $row['Fview'];
  $aedit = $row['FEdit'];
  $aadd = $row['FAdd'];
  $adelete = $row['Fdelete'];
}

$sql2 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Roomtransfer') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql2);
foreach ($exe->result_array() as $row) {
  $rview = $row['Fview'];
  $redit = $row['FEdit'];
  $radd = $row['FAdd'];
  $rdelete = $row['Fdelete'];
}

$sql3 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Guest Amendment') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql3);
foreach ($exe->result_array() as $row) {
  $gview = $row['Fview'];
  $gedit = $row['FEdit'];
  $gadd = $row['FAdd'];
  $gdelete = $row['Fdelete'];
}
$sql4 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Checkout') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql4);
foreach ($exe->result_array() as $row) {
  $cview = $row['Fview'];
  $cedit = $row['FEdit'];
  $cadd = $row['FAdd'];
  $cdelete = $row['Fdelete'];
}
$sql5 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Complimentary Checkout') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql5);
foreach ($exe->result_array() as $row) {
  $ccview = $row['Fview'];
  $ccedit = $row['FEdit'];
  $ccadd = $row['FAdd'];
  $ccdelete = $row['Fdelete'];
}
$sql6 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Clear Dirty') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql6);
foreach ($exe->result_array() as $row) {
  $cdview = $row['Fview'];
  $cdedit = $row['FEdit'];
  $cdadd = $row['FAdd'];
  $cddelete = $row['Fdelete'];
}
$sql6 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Settlement') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql6);
foreach ($exe->result_array() as $row) {
  $sview = $row['Fview'];
  $sedit = $row['FEdit'];
  $sadd = $row['FAdd'];
  $sdelete = $row['Fdelete'];
}

$sql7 = "select isnull(comcheckoutoption, 0) as comcheckoutoption
   from  usertable where User_id='" . User_id . "'";
$ece = $this->db->query($sql7);
foreach ($ece->result_array() as $row1) {
  $comcheckoutoption = $row1['comcheckoutoption'];
}
?>

<style>
  /* table .fixed{
    table-layout: fixed;
    width:90%;
    word-break: break-all;
}

table .fixed td{
    overflow: hidden;
} */

.popup {
    display: none;
    position: fixed;
    margin-top:325px;
    inset: 0;
    /* background: rgba(0,0,0,0.5); */
    z-index: 9999;
}

.popup-content {
    width: 800px;
    margin: 70px auto;
    background: #FFFAA0;
    position: relative;
}

.popup-header-wrapper {
    background-color: #0057B7; /* any color you want */
}

.popup-header {
    display: flex;               
    justify-content: space-between; 
    align-items: center;          
    padding: 5px 5px;           
}

.popup-title {
  margin: 0;
    font-size: 22px;
    color: white;
    text-align: center;
    flex: 1; /* takes full width for proper centering */
}

.popup-close {
    font-size: 22px;
    cursor: pointer;
    color: white;
}

</style>

<div id="visitingPopup" class="popup">
    <div class="popup-content">

        <div class="popup-header-wrapper"> 
            <div class="popup-header">
                <h1 class="popup-title">Visiting</h1>
                <span class="popup-close" onclick="closeVisit()">X</span>
            </div>
        </div>

        <div class="visiting"></div>

    </div>
</div>

<div id="maintainancePopup" class="popup">
    <div class="popup-content">

        <div class="popup-header-wrapper"> 
            <div class="popup-header">
                <h1 class="popup-title">Maintainance</h1>
                <span class="popup-close" onclick="closeMaintainance()">X</span>
            </div>
        </div>

        <div class="maintainance"></div>

    </div>
</div>

<div id="cleaningPopup" class="popup">
    <div class="popup-content">

        <div class="popup-header-wrapper"> 
            <div class="popup-header">
                <h1 class="popup-title">Cleaning</h1>
                <span class="popup-close" onclick="closeCleaning()">X</span>
            </div>
        </div>

        <div class="cleaning"></div>

    </div>
</div>


<div class="col-sm-12 mt-2 ">
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="row">
        <div class="the-box F_ram">
          <fieldset>
            <table class="FrmTable T-12">
                         
              <?php
               $url1=$_SERVER['REQUEST_URI'];
              //  header("Refresh: 60; URL=$url1");
              $cur = date('Y-m-d');
              $qury = "EXEC Trans_counts '" . $cur . "'";
              $exe = $this->db->query($qury);
              foreach ($exe->result_array() as $count) {
                


              ?>
                <tr>
        
                  <td align="center">
                    <form method="POST" id="occupiedForm"><input type="hidden" name="occ" id="occ" value="1" /><a href="#" name="submit" id="occupied"><img  src="<?php echo scs_url ?>assets/img/occupied.PNG" alt="Girl in a jacket" width="40" height="40"></a> <?php echo $count['occupied']; ?></form>
                  </td>
                  <td align="center">
                    <form method="POST" id="availForm"><input type="hidden" name="ava" id="ava" value="1" /><a href="#" name="submit" id="avail"><img src="<?php echo scs_url ?>assets/img/vacant.png" alt="Girl in a jacket" width="30" height="30"> </a> <?php echo $count['availablerooms']; ?></form>
                  </td>
                  <td align="center">
                    <form method="POST" id="clearForm"><input type="hidden" name="clear" id="clear" value="1" /><a href="#" name="submit" id="cleard"><img src="<?php echo scs_url ?>assets/img/dirty.PNG" alt="Girl in a jacket" width="40" height="40"></a> <?php echo $count['dirtyrooms']; ?></form>
                  </td>
                  <td align="center">
                    <form method="POST" id="blockForm"><input type="hidden" name="blocked" id="blocked" value="1" /><a href="#" name="submit" id="block"><img src="<?php echo scs_url ?>assets/img/maintainance.png" alt="Girl in a jacket" width="30" height="30"></a> <?php echo $count['maintain']; ?></form>
                  </td>
                  <td align="center">
                    <form method="POST" id="mainForm"><input type="hidden" name="mainn" id="mainn" value="1" /><a href="#" name="submit" id="main"><img src="<?php echo scs_url ?>assets/img/foblock.png" alt="Girl in a jacket" width="30" height="30"></a> <?php echo $count['maintainF']; ?></form>
                  </td>
                  <td align="center">
                    <form method="POST" id="billForm"><input type="hidden" name="billed" id="billed" value="1" /><a href="#" name="submit" id="bill"><img src="<?php echo scs_url ?>assets/img/un.PNG" alt="Girl in a jacket" width="40" height="40"></a> <?php echo $count['billsettlement']; ?></form>
                  </td>
                  <td align="center"><img src="<?php echo scs_url ?>assets/img/expected.png" alt="Girl in a jacket" width="30" height="30"><?php echo $count['reserve']; ?></td>
                  <td align="center"><img src="<?php echo scs_url ?>assets/img/depature.png" alt="Girl in a jacket" width="30" height="30"><?php echo $count['checkout']; ?></td>
                </tr>
              <?php
              }
              ?>
            </table>
            <form method="POST">
              <table class="FrmTable T-12">
                <tr>
                  <td align="right" class="F_val">Sort by</td>
                  <td align="left">
                    <select name="selectType" id="selectType" class="scs-ctrl">
                      <option selected value="0">--Select--</option>
                      <option value="1">Room Type</option>
                      <option value="2">Room Number</option>
                      <option value="3">Customer</option>
                    </select>
                  </td>
                  <td align="left"><input type="text" placeholder="Search" id="search" name="search" class="scs-ctrl" />

                    <div class="City"></div>
                  </td>
                  <td align="left"><input type="submit" name="submit" class="btn btn-success btn-sm" />
                    <input type="submit" name="reload" value="Reload" id="reload" class="btn btn-success btn-sm" />
                  </td>

              </table>
            </form>
          </fieldset>
        </div>

        <div class="col-md-12">
          <div class="row">
            <?php
            if (@$_POST['submit']) {
              if ($_POST['selectType'] == 1) {
                $sql = "exec filterbyroomtype '" . "%" . $_POST['search'] . "%" . "' ";
              } else if ($_POST['selectType'] == 2) {
                $sql = "exec filterbyroomno '" . "%" . $_POST['search'] . "%" . "'  ";
              } elseif ($_POST['selectType'] == 3) {
                $sql = "exec filterbyname '" . "%" . $_POST['search'] . "%" . "'  ";
              } else {
                $sql = "exec filterbycommon ";
              }
            } else if (@$_POST['occ']) {
               $sql = "exec fiterbyoccupied";
            } else if (@$_POST['ava']) {
              $sql = "exec fiterbyavailable";
            } else if (@$_POST['clear']) {
              $sql = "exec fiterbyclear";
            } else if (@$_POST['blocked']) {
              $sql = "exec fiterbymblocked";
            } else if (@$_POST['mainn']) {
              $sql = "exec fiterbyblocked";
            } else if (@$_POST['billed']) {
              $sql = "exec fiterbybill"; 
            } else {
                $sql = "exec filterbycommon ";
              // echo "commaon";
            }
            $res = $this->db->query($sql);
            $norows = $res->num_rows();
            if ($norows == 0) {
            ?>
              <div class="col-sm-3 col-lg-12" style="padding: 0.5%;">
                <div class="card-body" style="height:100%">

                  <h3 class="text-center"> No Results found....</h3>
                </div>
              </div>
            <?php
            }
            foreach ($res->result_array() as $row) {
              // print_r($row);
             

            ?>

              <div class="col-sm-3 col-lg-4 col-md-4" style="padding: 0.5%;">
                <div class="card" style="height:100%">
                  <div class="card-head card-head " style="background-color:<?php echo $row['Color']; ?>;">
                    <table style="table-layout:fixed; width:100%;">

                      <tr>
                        <td style="text-align: left; overflow:hidden;  ">#<?php echo $row['RoomNo']; ?></td>
                        <td style="text-align: right; overflow:hidden; display:flex;width:100%;"><?php echo str_replace(' ', '', $row['RoomType']); ?></td>
                      </tr>
                    </table>
                  </div>
                  <?php
                  if ($row['Status'] == 'Y' && $row['billsettle'] <> 1) {
                  ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="4" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-user-secret"></i> <?php echo $row['Name']; ?></td>
                            </tr>
                            <tr>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-male"></i> <?php echo $row['male']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-female"></i> <?php echo $row['female']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-child"></i> <?php echo $row['Child']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-bed"></i> <?php if ($row['days'] == 0) {
                                                                                                                            echo '1';
                                                                                                                          } else {
                                                                                                                            echo $row['days'];
                                                                                                                          } ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-in"></i> <?php echo date('d/m/Y', strtotime($row['checkindate'])) . '-' . substr($row['CheckinTime'], 11, 5); ?></td>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-out"></i> <?php echo date('d/m/Y', strtotime($row['depdate'])) . '-' . substr($row['deptime'], 11, 5); ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="width:43%;padding:0px;text-wrap:nowrap"><i style="color:#0057b7" class="fa fa-phone"></i> <?php echo $row['Mobile']; ?></td>
                              <td colspan="2" style="width: 57%;padding:0px;text-wrap:nowrap"><i style="color:#0057b7" class="fa fa-address-card-o"></i> <?php echo $row['City']; ?></td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-building-o"></i> <?php echo $row['Company']; ?></td>
                            </tr>
                            <tr>
                              <?php
                              $roomId = $row['Roomid'];
                              $sql = "Get_Checkout_Amount_Details ?";
                              $exece = $this->db->query($sql, array($roomId));
                              $row1 = $exece->row_array();

                              // print_r($row1);

                              $billAmount = 0;
                             
                              if (!empty($row1)) {
                                  $billAmount = ($row1['billamount'] + $row1['Tempbillamount']) 
                                              - ($row1['advance'] + $row1['TempDiscamt'] + $row1['discamt'] + $row1['Allowance']);
                              }
                              ?>
                              <td colspan="3" style="width: 100%; padding: 0px;">
                                <i style="color:#0057b7" class="fa fa-inr"></i> <?php echo number_format($billAmount, 2); ?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="dropdown4-content">
                          <a href="#" onclick="postadvance('<?php echo $row['Room_Id']; ?>')">Advance Posting</a>
                          <a href="#" onclick="postbill('<?php echo $row['Room_Id']; ?>')">Bill Posting</a>
                          <?php if (@$aview == 1 ||  @$aedit == 1 || @$aadd == 1 || @$adelete == 1) { ?>
                            <a href="#" onclick="allowance('<?php echo $row['Room_Id']; ?>')">Allowance Posting</a> <?php } ?>
                          <?php if (@$rview == 1 ||  @$redit == 1 || @$radd == 1 || @$rdelete == 1) { ?>
                            <a href="#" onclick="roomtransfer('<?php echo $row['Room_Id']; ?>')">Room Transfer</a> <?php } ?>
                          <?php if (@$gview == 1 ||  @$gedit == 1 || @$gadd == 1 || @$gdelete == 1) { ?>
                            <a href="#" onclick="amendment('<?php echo $row['Room_Id']; ?>')">Guest Amendment</a><?php } ?>
                          <?php if (@$cview == 1 ||  @$cedit == 1 || @$cadd == 1 || @$cdelete == 1) { ?>

                            <?php

 $sql1="select * from Room_Status rs
INNER JOIN Trans_checkin_mas cmas on cmas.grcid=rs.grcid
where rs.Status='Y'   and 
isnull(cmas.cancelflag,0) = 0 and rs.Roomid='".$row['Room_Id']."'";	 

$exe = $this->db->query($sql1);                 
foreach($exe -> result_array() as $rowss){
// $checkoutid= $row1['Checkoutid'];
$GROUPCHECKIN= $rowss['GROUPCHECKIN'];
}



?>
<?php  if($GROUPCHECKIN == 0) { ?>		
 <a href="#" onclick="checkout('<?php echo $row['Room_Id']; ?>')">Checkout</a> 


<?php }else { ?>
 <a href="#" onclick="GroupCheckout('<?php echo $row['Room_Id']; ?>')">GroupCheckout</a>

<?php } ?>
                          <?php } ?>
                          <?php if ((@$ccview == 1 ||  @$ccedit == 1 || @$ccadd == 1 || @$ccdelete == 1) && @$comcheckoutoption != 0) { ?>
                            <!-- <a href="#" onclick="comCheckout('<php echo $row['Room_Id']; ?>')">complementary Checkout</a> -->
                            <?php } ?>
                        </div>
                      </div>
                    </div>
                  <?php } else if ($row['Status'] == 'Y' && $row['billsettle'] == 1) {
                  ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="4" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-user-secret"></i> <?php echo $row['Name']; ?></td>
                            </tr>
                            <tr>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-male"></i> <?php echo $row['male']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-female"></i> <?php echo $row['female']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-child"></i> <?php echo $row['Child']; ?></td>
                              <td style="padding:0px;text-align: center"><i style="color:#0057b7" class="fa fa-bed"></i> <?php if ($row['days'] == 0) {
                                                                                                                            echo '1';
                                                                                                                          } else {
                                                                                                                            echo $row['days'];
                                                                                                                          } ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-in"></i> <?php echo date('d/m/Y', strtotime($row['checkindate'])) . '-' . substr($row['CheckinTime'], 11, 5); ?></td>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-out"></i> <?php echo date('d/m/Y', strtotime($row['depdate'])) . '-' . substr($row['deptime'], 11, 5); ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="width:43%;padding:0px"><i style="color:#0057b7" class="fa fa-phone"></i> <?php echo $row['Mobile']; ?></td>
                              <td colspan="2" style="width: 57%;padding:0px"><i style="color:#0057b7" class="fa fa-address-card-o"></i> <?php echo $row['City']; ?></td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-building-o"></i> <?php echo $row['Company']; ?></td>
                            </tr>
                            <tr>
                              <?php
                              // echo   $sql = "Get_Checkout_Amount_Details  '".$row['Roomid']."'";
                              //   $exece = $this->db->query($sql);
                              //   foreach($exece -> result_array() as $row1){
                              //     $billAmount=($row1['billamount']+ $row1['Tempbillamount']) - ($row1['advance']+$row1['TempDiscamt']+$row1['discamt']+$row1['Allowance'] );
                              //   }

                              // $sql =" Select Checkoutno, isnull(rmas.Amount,0) as receipt, * from Trans_Checkout_mas cmas
                              //   Inner join	Mas_Room rm on rm.Room_Id=cmas.Roomid
                              //   Inner join Trans_checkin_mas cimas on cimas.Grcid=cmas.grcid
                              //   Inner join Trans_Roomdet_det rdd on rdd.grcid=cmas.grcid
                              //   Inner join Mas_Customer cus on cus.Customer_Id=cmas.Customerid
                              //   Inner join Mas_Title mt on mt.Titleid=cus.Titelid
                              //   Inner Join Mas_City ct on ct.Cityid=cus.Cityid
                              //   left join Trans_Receipt_mas rmas on rmas.roomid = cmas.Roomid
                              //   where cmas.Checkoutno like 'CHK%' and isnull(cmas.cancelflag,0)<>1 and cmas.Roomid='".$row['Roomid'].
                              //   "' and cmas.checkoutdate=convert(varchar(25),getdate(),101)";
                             $roomId = $row['Roomid'];
                              $billAmount = 0;
                              $checkoutid = null;

                              $sql = "select tcm.checkoutid,tcm.checkoutno,tcm.totalamount from trans_checkout_mas tcm
                                      inner join room_status rs on rs.roomid = tcm.roomid AND ISNULL (rs.status,'N')='Y'
                                      inner join trans_roomdet_det rdet on rdet.roomgrcid = tcm.roomgrcid
                                      where tcm.roomid = '$roomId'  AND tcm.Checkoutno like 'CHK%' and isnull(settle,0) <>1 and ISNULL(tcm.cancelflag, 0) <> 1";


                              $query = $this->db->query($sql);
                        
                              if ($row1 = $query->row_array()) {     
                                // print_r($row1);                         
                                $billAmount = $row1['totalamount'];
                                $checkoutid = $row1['checkoutid'];
                              }
                              else{
                                $checkoutid = null;
                              }

                              ?>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-inr"></i> <?php echo $billAmount; ?></td>
                            </tr>
                          </tbody>
                        </table>

                        <?php

                         $sql1="select * from Room_Status rs
                        INNER JOIN Trans_checkout_mas cmas on cmas.grcid=rs.grcid
                        INNER JOIN Mas_Customer cus on cus.Customer_Id=cmas.Customerid
                        where rs.Status='Y' and isnull(rs.billsettle,0)='1' and isnull(cmas.Settle,0)=0 and 
                        cmas.Checkoutno like 'CHK%' and isnull(cmas.cancelflag,0) = 0 and isnull(cmas.reinstate,0)=0 and rs.Roomid='".$row['Room_Id']."'";	

                        $exe = $this->db->query($sql1);                 
                        foreach($exe -> result_array() as $row1){
                        $checkoutid= $row1['Checkoutid'];
                        $groupcheckout= $row1['groupcheckout'];

                        }

          

                        ?>
                        <div class="dropdown4-content">
                        <?php if (@$sview == 1 ||  @$sedit == 1 || @$sadd == 1 || @$sdelete == 1) { ?>

<?php  if($groupcheckout == 1) { ?>		
<a href="#" onclick="group_settlement('<?php echo $checkoutid; ?>')">Group Settlement</a>

<?php } else{ ?>			
  <a href="#" onclick="settlement('<?php echo $checkoutid; ?>')">Settlement</a>

    <?php } ?>											
    <?php } ?>															

                        </div>

                      </div>
                    </div>

                  <?php
                  } else if ($row['Status'] == 'N' && $row['notready'] <> 0) {
                  ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td style="width: 50%;padding:0px">&nbsp;</td>
                              <td style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="dropdown4-content">
                          <?php if (@$cdview == 1 ||  @$cdedit == 1 || @$cdadd == 1 || @$cddelete == 1) { ?>
                            <a href="#" onclick="cleardirty('<?php echo $row['Room_Id'] ?>')">Clear Dirty</a>
                            <?php    $setqry = "select enablepower from extraoption";

$set = $this->db->query($setqry)->row_array();

if($set['enablepower'] == 1) { ?>
<?php $optqry = "select * from room_status where Roomid = '".$row['Room_Id']."'";
    $opt = $this->db->query($optqry)->row_array(); ?>
    <?php if($opt['Pwvisiting'] == 1 || $opt['Pwcleaning'] == 1 || $opt['Pwmaintenance'] == 1 ) { ?>
                            <a href="#" onclick="errclean('<?php echo $row['Room_Id'] ?>')">Cleaning</a>
                            <a href="#" onclick="errmaintainance('<?php echo $row['Room_Id'] ?>')">Maintainance</a>
                             <?php } else { ?>
                              <a href="#" onclick="clean('<?php echo $row['Room_Id'] ?>')">Cleaning</a>
                              <a href="#" onclick="maintainance('<?php echo $row['Room_Id'] ?>')">Maintainance</a>

                             <?php } ?>
                             <?php } ?>
                             <?php } ?>
                        </div>
                      </div>
                    </div>

                  <?php
                  } else if ($row['blocked'] == 1 && $row['mblock'] != 0 && $row['foblock'] != 1) {
                  ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-user-times"></i> Under Maintenance </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-hand-o-right"> </i> <?php echo $row['reason']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="padding:0px"><i style="color:#0057b7"></i>Blocked Date</td>
                              <td style="padding:0px"><i style="color:#0057b7"></i>Release Date</td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-in"></i> <?php echo date('d/m/Y', strtotime($row['fromdate'])); ?></td>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-out"></i> <?php echo date('d/m/Y', strtotime($row['todate'])); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>

                            <tr>
                              <td colspan="3" style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="dropdown4-content">
                          <?php if (@$cdview == 1 ||  @$cdedit == 1 || @$cdadd == 1 || @$cddelete == 1) { ?>
                            <!-- <a href="<php echo scs_index; ?>Transaction/RoomBlockRelease">UnBlock </a> -->
                              <?php } ?>
                        </div>
                      </div>
                    </div>

                  <?php
                  } else if ($row['blocked'] == 1 && $row['mblock'] != 1 && $row['foblock'] != 0) {
                  ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-user-times"> </i> Frontoffice Blocked</td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px"><i style="color:#0057b7" class="fa fa-hand-o-right"> </i> <?php echo $row['reason']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td style="padding:0px"><i style="color:#0057b7"></i>Blocked Date</td>
                              <td style="padding:0px"><i style="color:#0057b7"></i>Release Date</td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                          <tr>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-in"></i> <?php echo date('d/m/Y', strtotime($row['fromdate'])); ?></td>
                              <td style="padding:0px"><i style="color:#0057b7" class="fa fa-sign-out"></i> <?php echo date('d/m/Y', strtotime($row['todate'])); ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>

                            <tr>
                              <td colspan="3" style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="dropdown4-content">

                          <!-- <a href="<php echo scs_index; ?>Transaction/RoomBlockRelease">UnBlock </a> -->
                        </div>
                      </div>
                    </div>

                  <?php
                  } else if ($row['Status'] == 'N' && $row['blocked'] != 1 && $row['notready'] == 0) { ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td style="width: 50%;padding:0px">&nbsp;</td>
                              <td style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 50%;padding:0px">&nbsp; </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">&nbsp; </td>
                            </tr>

                          </tbody>
                        </table>
                        <?php if (@$view == 1 ||  @$edit == 1 || @$add == 1 || @$delete == 1) { ?>
                          <div class="dropdown4-content">
                            <a href="#" onclick="checkin('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>' ,'<?php echo date('Y-m-d', strtotime('+1 Day')); ?>');">Checkin</a>
                         <?php    $setqry = "select enablepower from extraoption";

$set = $this->db->query($setqry)->row_array();

if($set['enablepower'] == 1) { ?>

<?php $optqry = "select * from room_status where Roomid = '".$row['Room_Id']."'";
    $opt = $this->db->query($optqry)->row_array(); ?>
    <?php if($opt['Pwvisiting'] == 1 || $opt['Pwcleaning'] == 1 || $opt['Pwmaintenance'] == 1 ) { ?>

                            <a href="#" onclick="errvisit('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>' ,'<?php echo date('Y-m-d', strtotime('+1 Day')); ?>');">Visiting</a>
                            <a href="#" onclick="errmaintainance('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>' ,'<?php echo date('Y-m-d', strtotime('+1 Day')); ?>');">Maintainance</a>
<?php } else {  ?>
  <a href="#" onclick="visit('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>' ,'<?php echo date('Y-m-d', strtotime('+1 Day')); ?>');">Visiting</a>
                            <a href="#" onclick="maintainance('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>' ,'<?php echo date('Y-m-d', strtotime('+1 Day')); ?>');">Maintainance</a>
<?php }  ?>
<?php }  ?>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="card-body" style="color:<?php echo $row['Tcolor']; ?>">
                      <div class="dropdown4">
                        <table class="table table-borderless" style="margin-bottom: 0px;">
                          <tbody style="width: 100%;">
                            <tr>
                              <td colspan="3" style="width: 100%;padding:0px">Room Not Available</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>


                  <?php }

                  ?>
                </div>
              </div>
            <?php } ?>
            <div id="cleardirtydialog" class="cleardirty center" style="display:none;width:450px" title="Unblock"></div>
            <div id="settlement" class="settlement center" style="display:none;width:450px" title="Settlement"></div>
            <div id="dialog" class="Checkin center" style="display:none;width:450px" title="Walkin/Reservation"></div>
            <div id="visiting" class="visiting center" style="display:none;width:450px" title="Visiting"></div>
            <div id="cleaningdialog" class="cleaning center" style="display:none;width:450px" title="Cleaning"></div>
            <div id="maintainancedialog" class="maintainance center" style="display:none;width:450px" title="maintainance"></div>
            <div id="advancedialog" class="postadvance center" style="display:none;width:450px;" title="Post Advance"></div>
            <div id="postbilldialog" class="postbill center" style="display:none;width:450px" title="Bill Posting"></div>
            <div id="allowancedialog" class="allowance center" style="display:none;width:450px" title="Bill Posting"></div>
            <div id="roomtransferdialog" class="roomtransfer center" style="display:none;width:450px" title="Room Transfer"></div>
            <div id="guestamenddialog" class="amendment center" style="display:none;width:450px" title="Guest Amendment"></div>
            <div id="checkoutdialog" class="Checkout center" style="display:none;width:450px" title="Checkout"></div>
            <div id="comcheckoutdialog" class="comCheckout center" style="display:none;width:450px" title="complementary Checkout"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
$this->pweb->sms_footer($this->Menu);
?>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  var today = new Date().getFullYear() + '/' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '/' + ("0" + new Date().getDate()).slice(-2);



  var occupied = document.getElementById("occupied");
  occupied.addEventListener("click", () => {
    document.getElementById("occupiedForm").submit();
  });

  var avail = document.getElementById("avail");
  avail.addEventListener("click", () => {
    document.getElementById("availForm").submit();
  });

  var clead = document.getElementById("cleard");
  clead.addEventListener("click", () => {

    document.getElementById("clearForm").submit();

  });

  var block = document.getElementById("block");
  block.addEventListener("click", () => {

    document.getElementById("blockForm").submit();
  });

  var bill = document.getElementById("bill");
  bill.addEventListener("click", () => {

    document.getElementById("billForm").submit();
  });
  var main = document.getElementById("main");
  main.addEventListener("click", () => {

    document.getElementById("mainForm").submit();
  });
  var reload = document.getElementById("reload");
  reload.addEventListener("click", () => {
    location.reload();
  })

  function checkin(roomid, Fdat, Tdat) {


    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }

    $.ajax({

      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/Checkin",
      data: $('#scsfrm').serialize() + "&Fdat=" + Fdat + "&Tdat=" + Tdat + "&roomid=" + roomid,
      success: function(html) {
        $(".Checkin").html(html);
      }

    });

    $("#nig").on('keyup',function(){

	var nights = parseInt(document.getElementById("nig").value, 10);
  var inDate = new Date(document.getElementById("Indate").value);

    if (!isNaN(nights)) {
        inDate.setDate(inDate.getDate() + nights);
        var outDate = inDate.toISOString().split('T')[0];
        document.getElementById("outdate").value = outDate;
    }
   });


    $("#dialog").dialog({
      height: "auto",
      width: 800,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');



    
  }

  function postadvance(a) {
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/advanceposting/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".postadvance").html(html);
      }
    })
    $("#advancedialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }


  function postbill(a) {
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/billposting/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".postbill").html(html);
      }
    })
    $("#postbilldialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }


  function allowance(a) {
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/allowanceposting/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".allowance").html(html);
      }
    })
    $("#allowancedialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }

  function roomtransfer(a) {
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/roomtransfer/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".roomtransfer").html(html);
      }
    })
    $("#roomtransferdialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }


  function amendment(a) {
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/amendment/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".amendment").html(html);
      }
    })
    $("#guestamenddialog").dialog({
      height: "auto",
      width: 800,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }

  function cleardirty(a) {
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/cleardirty/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".cleardirty").html(html);
      }
    })
    $("#cleardirtydialog").dialog({
      height: "auto",
      width: 300,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }

  function checkout(a) {

    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }

   
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/Checkout/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".Checkout").html(html);
      }
    })
    $("#checkoutdialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }


  function comCheckout(a) {

    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }


    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/Walkout/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".comCheckout").html(html);
      }
    })
    $("#comcheckoutdialog").dialog({
      height: "auto",
      width: 600,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }


  function settlement(a) {
    // alert(a);



    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/settlement/",
      data: $('#scsfrm').serialize() + "&Billid=" + a,
      success: function(html) {
        $(".settlement").html(html);
      }
    })
    $("#settlement").dialog({
      height: "auto",
      width: 740,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }
</script>

<script>
    function GroupCheckout(a){
    if ("<?php echo $auditdate; ?>" < today) {
      swal("Night Audit Not Completed", "Kindly do the Date change Process", "warning");
      return;
    }

   
    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/GroupCheckout/",
      data: $('#scsfrm').serialize() + "&Room_id=" + a,
      success: function(html) {
        $(".Checkout").html(html);
      }
    })
    $("#checkoutdialog").dialog({
      height: "auto",
      width: 710,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }
</script>

<script>
    function group_settlement(a) {
    // alert(a);



    $.ajax({
      type: "POST",
      url: "<?php echo scs_index; ?>Transaction/groupsettlement/",
      data: $('#scsfrm').serialize() + "&Billid=" + a,
      success: function(html) {
        $(".settlement").html(html);
      }
    })
    $("#settlement").dialog({
      height: "auto",
      width: 740,
      modal: true
    });
    $('.ui-dialog-titlebar-close').html('X');
    $('.ui-dialog-titlebar-close').removeClass('ui-button-icon-only');
  }
</script>


<script>
  
  function visit(roomid) {

$.ajax({
    type: "POST",
    url: "<?php echo scs_index; ?>Transaction/visiting",
    data: $('#scsfrm').serialize() + "&roomid=" + roomid,
    success: function (html) {

        $(".visiting").html(html);

        document.getElementById("visitingPopup").style.display = "block";
    }
});
}





function maintainance(roomid) {

$.ajax({
    type: "POST",
    url: "<?php echo scs_index; ?>Transaction/maintainance",
    data: $('#scsfrm').serialize() + "&roomid=" + roomid,
    success: function (html) {

        $(".maintainance").html(html);

        document.getElementById("maintainancePopup").style.display = "block";
    }
});

}





function clean(roomid) {

$.ajax({
    type: "POST",
    url: "<?php echo scs_index; ?>Transaction/cleaning",
    data: $('#scsfrm').serialize() + "&roomid=" + roomid,
    success: function (html) {

        $(".cleaning").html(html);

        document.getElementById("cleaningPopup").style.display = "block";
    }
});

}


</script>

<script>
function errvisit() {
    swal("Please Wait", "Another process is currently running. Please try again in a moment.", "warning");
    return;
}


  function errmaintainance(){
    swal("Please Wait", "Another process is currently running. Please try again in a moment.", "warning");
  return;
  }

  function errclean(){
    swal("Please Wait", "Another process is currently running. Please try again in a moment.", "warning");
  return;
  }
  
  
</script>


<script>
  function closeVisit() {
    document.getElementById("visitingPopup").style.display = "none";
}


function closeMaintainance() {
    document.getElementById("maintainancePopup").style.display = "none";
}


function closeCleaning() {
    document.getElementById("cleaningPopup").style.display = "none";
}


</script>