<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu, $this->session);
$this->pweb->menu($this->Menu, $this->session);
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
$sql7 = "select * from User_GroupRights where SubMenu_Id=(select  submenu_id from submenu where Smenu='Settlement') and   userGroup_id=(select usergroup_id from usertable where user_id='" . User_id . "')";
$exe = $this->db->query($sql7);
foreach ($exe->result_array() as $row) {
  $sview = $row['Fview'];
  $sedit = $row['FEdit'];
  $sadd = $row['FAdd'];
  $sdelete = $row['Fdelete'];
}

$sql8 = "select isnull(comcheckoutoption, 0) as comcheckoutoption
   from  usertable where User_id='" . User_id . "'";
$ece = $this->db->query($sql8);
foreach ($ece->result_array() as $row1) {
  $comcheckoutoption = $row1['comcheckoutoption'];
}
?>

<style>
  /* Enhanced Status Cards */
.main-sidebar{
  height:60vh !important;
}

.status-summary {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid #eaeaea;
    position: relative;
}

/* Modified Status Header with Search Input */
.status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    gap: 20px;
    flex-wrap: wrap;
}

.status-title-container {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
    min-width: 200px;
}

.status-title {
    font-size: 24px;
    font-weight: 700;
    color: #0057B7;
    margin: 0;
    white-space: nowrap;
}

/* Search Input in Header */
.header-search-container {
    flex: 1;
    min-width: 300px;
    max-width: 300px;
    
}

.search-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    padding: 5px 15px;
    border-radius: 6px;
    border: 2px solid #e0e0e0;
    transition: all 0.3s ease;
}

.search-wrapper:focus-within {
    background: white;
    border-color: #0057B7;
    box-shadow: 0 0 0 3px rgba(0, 87, 183, 0.1);
}

.search-icon {
    color: #0057B7;
    font-size: 16px;
}

.search-input-group {
    flex: 1;
    position: relative;
}

.search-input {
    width: 100%;
    padding: 5px 5px 5px 0;
    border: none;
    background: transparent;
    font-size: 14px;
    color: #333;
    outline: none;
}

.search-input::placeholder {
    color: #999;
}

.search-clear {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    font-size: 14px;
    display: none;
    padding: 4px;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.search-clear:hover {
    background: #f0f0f0;
    color: #ff4757;
}

/* Filter tabs below search */
.filter-tabs {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    flex-wrap: wrap;
    width: 100%;
}

.filter-tab {
    padding: 6px 12px;
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #666;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.filter-tab.active {
    background: #0057B7;
    border-color: #0057B7;
    color: white;
}

.filter-tab:hover:not(.active) {
    background: #e9ecef;
    border-color: #dee2e6;
}

.status-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 12px;
    margin-bottom: 25px;
}

.status-card {
    background: white;
    border-radius: 10px;
    padding: 5px 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    /* border: 2px solid transparent; */
    box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.status-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    border-color: #0057B7;
}

.status-card.all {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.status-card.occupied {
    background: linear-gradient(135deg, #fff5f5, #ffe3e3);
}

.status-card.available {
    background: linear-gradient(135deg, #f0fff4, #dcffe4);
}

.status-card.dirty {
    background: linear-gradient(135deg, #fff9e6, #fff4d1);
}

.status-card.maintenance {
    background: linear-gradient(135deg, #eef2ff, #e0e7ff);
}

.status-card.blocked {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
}

.status-card.billsettle {
    background: linear-gradient(135deg, #2d3748, #1a202c);
    color: white;
}

.status-card.expected {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
}

.status-card.departure {
    background: linear-gradient(135deg, #fdf2f8, #fce7f3);
}

.status-count {
    font-size: 18px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 5px;
}

.status-label {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-card.all .status-count {
    color: #6c757d;
}

.status-card.occupied .status-count {
    color: #ff4757;
}

.status-card.available .status-count {
    color: #2e8b57;
}

.status-card.dirty .status-count {
    color: #ffa502;
}

.status-card.maintenance .status-count {
    color: #3742fa;
}

.status-card.blocked .status-count {
    color: #747d8c;
}

.status-card.billsettle .status-count {
    color: #ffffff;
}

.status-card.billsettle .status-label {
    color: #ffffff;
}

.status-card.expected .status-count {
    color: #0ea5e9;
}

.status-card.departure .status-count {
    color: #ec4899;
}

/* Loading indicator */
.loading {
    display: none;
    text-align: center;
    padding: 30px;
}

.loading-spinner {
    width: 30px;
    height: 30px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #0057B7;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* No results styling */
.no-results {
    text-align: center;
    padding: 40px 20px;
    background: white;
    border-radius: 12px;
    border: 2px dashed #dee2e6;
    margin: 20px 0;
}

.no-results-icon {
    font-size: 40px;
    color: #6c757d;
    margin-bottom: 15px;
}

.no-results-text {
    color: #6c757d;
    font-size: 16px;
    margin-bottom: 8px;
    font-weight: 600;
}

.no-results-subtext {
    color: #999;
    font-size: 13px;
}

/* Popup styles */
.popup {
    display: none;
    position: fixed;
    margin-top:325px;
    inset: 0;
    z-index: 9999;
}

.popup-content {
    width: 800px;
    margin: 70px auto;
    background: #FFFAA0;
    position: relative;
}

.popup-header-wrapper {
    background-color: #0057B7;
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
    flex: 1;
}

.popup-close {
    font-size: 22px;
    cursor: pointer;
    color: white;
}

/* Simple Room Chart Styles */
.floor-container {
    margin-bottom: 25px;
    background: white;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    border: 1px solid #e0e0e0;
    position: relative;
    overflow: visible;
}

.floor-title {
    font-size: 16px;
    font-weight: bold;
    color: #0057B7;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #0057B7;
}

.rooms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(55px, 1fr));
    gap: 12px;
    position: relative;
}

.room-box {
    width: 50px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-weight: bold;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.room-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.15);
    z-index: 100;
}

.room-box:hover .room-options {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Room Status Colors */
.room-occupied { 
    background: linear-gradient(135deg, #ff4757, #ff3838);
    border: 2px solid #ff4757;
}
.room-available {  
    background: linear-gradient(135deg, #2e8b57, #228b22);
    border: 2px solid #2e8b57;
}
.room-dirty { 
    background: linear-gradient(135deg, #ffa502, #ff7f00);
    border: 2px solid #ffa502;
}
.room-maintenance { 
    background: linear-gradient(135deg, #3742fa, #5352ed);
    border: 2px solid #3742fa;
}
.room-blocked { 
    background: linear-gradient(135deg, #747d8c, #57606f);
    border: 2px solid #747d8c;
}
.room-billsettle { 
    background: linear-gradient(135deg, #000000, #222222);
    border: 2px solid #000000;
}

/* Hover Options Menu */
.room-options {
    position: absolute;
    top: 70%;
    left: 30%;
    transform: translateX(-50%) translateY(5px);
    background: white;
    border-radius: 6px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.2);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    min-width: 160px;
    padding: 5px 0;
}

.room-options:before {
    content: '';
    position: absolute;
    top: -5px;
    left: 50%;
    transform: translateX(-10%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-left: 5px solid white;
}

.room-option {
    padding: 8px 12px;
    display: block;
    color: #333;
    text-decoration: none;
    border-left: 1px solid #f1f2f6;
    font-size: 12px;
    transition: all 0.2s;
    cursor: pointer;
    white-space: nowrap;
    background: white;
    position: relative;
    z-index: 1001;
}

.room-option:last-child {
    border-bottom: none;
}

.room-option:hover {
    background: #f8f9fa;
    color: #0057b7;
}

.room-option i {
    margin-right: 8px;
    width: 14px;
    text-align: center;
    color: #0057b7;
    font-size: 12px;
}

/* Status indicator on cards */
.status-indicator {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.3);
}

.status-card.occupied .status-indicator { background: #ff4757; }
.status-card.available .status-indicator { background: #2e8b57; }
.status-card.dirty .status-indicator { background: #ffa502; }
.status-card.maintenance .status-indicator { background: #3742fa; }
.status-card.blocked .status-indicator { background: #747d8c; }
.status-card.billsettle .status-indicator { background: #ffffff; }
.status-card.expected .status-indicator { background: #0ea5e9; }
.status-card.departure .status-indicator { background: #ec4899; }

/* Responsive adjustments */
@media (max-width: 1200px) {
    .status-grid {
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    }
}

@media (max-width: 992px) {
    .status-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .status-title-container {
        justify-content: space-between;
    }
    
    .header-search-container {
        min-width: 100%;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .status-card {
        padding: 12px 8px;
    }
    
    .status-count {
        font-size: 24px;
    }
    
    .rooms-grid {
        grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
        gap: 10px;
    }
    
    .room-box {
        width: 50px;
        height: 50px;
        font-size: 13px;
    }
    
    .status-title {
        font-size: 20px;
    }
    
    .search-wrapper {
        padding: 5px 10px;
    }
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
            <!-- Enhanced Status Summary with Cards and Search Input in Header -->
            <div class="status-summary">
                <!-- Header with title and search input -->
                <div class="status-header">
                    <div class="status-title-container">
                      
                        <h1 class="status-title">Room Status</h1>
                         </div>
                        <!-- Search Input in Header -->
                        <div class="header-search-container">
                            <div class="search-wrapper">
                                <div class="search-icon">
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="search-input-group">
                                    <input type="text" 
                                           placeholder="Search rooms..." 
                                           id="searchInput" 
                                           class="search-input"
                                           onkeyup="performSearch()" />
                                    <button class="search-clear" onclick="clearSearch()" id="clearSearchBtn">✕</button>
                                </div>
                            </div>
                            
                            <!-- Filter tabs -->
                            <!-- <div class="filter-tabs" id="filterTabs">
                                <button class="filter-tab active" data-filter="all">All</button>
                                <button class="filter-tab" data-filter="room">Room No</button>
                                <button class="filter-tab" data-filter="guest">Guest</button>
                                <button class="filter-tab" data-filter="type">Type</button>
                            </div> -->
                            
                        
                        </div>
                   
                </div>
                
                <?php
                $cur = date('Y-m-d');
                $qury = "EXEC Trans_counts '" . $cur . "'";
                $exe = $this->db->query($qury);
                $count = $exe->row_array();
                
                // Get total count for ALL
                $totalRooms = $count['occupied'] + $count['availablerooms'] + $count['dirtyrooms'] + 
                             $count['maintain'] + $count['maintainF'] + $count['billsettlement'];
                ?>
                
                <div class="status-grid" id="statusCards">
                    <form method="POST" class="status-card all" onclick="this.submit();">
                        <input type="hidden" name="all" value="1" />
                        <div class="status-count"><?php echo $totalRooms; ?></div>
                        <div class="status-label">ALL</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card occupied" onclick="this.submit();">
                        <input type="hidden" name="occ" value="1" />
                        <div class="status-count"><?php echo $count['occupied']; ?></div>
                        <div class="status-label">Occupied</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card available" onclick="this.submit();">
                        <input type="hidden" name="ava" value="1" />
                        <div class="status-count"><?php echo $count['availablerooms']; ?></div>
                        <div class="status-label">Available</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card dirty" onclick="this.submit();">
                        <input type="hidden" name="clear" value="1" />
                        <div class="status-count"><?php echo $count['dirtyrooms']; ?></div>
                        <div class="status-label">Dirty</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card maintenance" onclick="this.submit();">
                        <input type="hidden" name="blocked" value="1" />
                        <div class="status-count"><?php echo $count['maintain']; ?></div>
                        <div class="status-label">Maintenance</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card blocked" onclick="this.submit();">
                        <input type="hidden" name="mainn" value="1" />
                        <div class="status-count"><?php echo $count['maintainF']; ?></div>
                        <div class="status-label">Blocked</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <form method="POST" class="status-card billsettle" onclick="this.submit();">
                        <input type="hidden" name="billed" value="1" />
                        <div class="status-count"><?php echo $count['billsettlement']; ?></div>
                        <div class="status-label">Bill Settlement</div>
                        <div class="status-indicator"></div>
                    </form>
                    
                    <div class="status-card expected">
                        <div class="status-count"><?php echo $count['reserve']; ?></div>
                        <div class="status-label">Expected</div>
                        <div class="status-indicator"></div>
                    </div>
                    
                    <div class="status-card departure">
                        <div class="status-count"><?php echo $count['checkout']; ?></div>
                        <div class="status-label">Departure</div>
                        <div class="status-indicator"></div>
                    </div>
                </div>
                      <div class="loading" id="loadingIndicator" style="display: none;">
                                <div class="loading-spinner"></div>
                            </div>
            </div>

            <!-- SIMPLE ROOM CHART -->
            <div class="col-md-12" id="roomChartContainer">
              <?php
              // Get room data based on filter
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
              } else if(@$_POST['all']){
                $sql = "exec filterbycommon ";
              } else {
                $sql = "exec filterbycommon ";
              }
              
              $res = $this->db->query($sql);
              $norows = $res->num_rows();
              
              if ($norows == 0) {
              ?>
                <div class="no-results">
                  <div class="no-results-icon">🏨</div>
                  <div class="no-results-text">No rooms found</div>
                  <div class="no-results-subtext">Try adjusting your search criteria</div>
                </div>
              <?php
              } else {
                // Get floors from database
                $floorexeqry = "select distinct mf.Floor, mf.Floor_id 
                               from mas_room mr 
                               inner join mas_floor mf on mf.Floor_id = mr.Floor_id 
                               order by mf.Floor_id desc";
                $floorexe = $this->db->query($floorexeqry)->result_array();
                
                // Get all rooms
                $allRooms = $res->result_array();
                
                // Group rooms by floor
                $roomsByFloor = [];
                foreach ($floorexe as $floor) {
                    $roomsByFloor[$floor['Floor']] = [];
                }
                
                // Add default floors if none in database
                if (empty($roomsByFloor)) {
                    $roomsByFloor = [
                        'Ground Floor' => [],
                        'First Floor' => [],
                        'Second Floor' => [],
                        'Third Floor' => []
                    ];
                }
                
                foreach ($allRooms as $row) {
                    $roomNo = $row['RoomNo'];
                    $firstDigit = substr($roomNo, 0, 1);
                    
                    if ($firstDigit == '1') {
                        if (!isset($roomsByFloor['Ground Floor'])) $roomsByFloor['Ground Floor'] = [];
                        $roomsByFloor['Ground Floor'][] = $row;
                    } else if ($firstDigit == '2') {
                        if (!isset($roomsByFloor['First Floor'])) $roomsByFloor['First Floor'] = [];
                        $roomsByFloor['First Floor'][] = $row;
                    } else if ($firstDigit == '3') {
                        if (!isset($roomsByFloor['Second Floor'])) $roomsByFloor['Second Floor'] = [];
                        $roomsByFloor['Second Floor'][] = $row;
                    } else if ($firstDigit == '4') {
                        if (!isset($roomsByFloor['Third Floor'])) $roomsByFloor['Third Floor'] = [];
                        $roomsByFloor['Third Floor'][] = $row;
                    } else {
                        if (!isset($roomsByFloor['Ground Floor'])) $roomsByFloor['Ground Floor'] = [];
                        $roomsByFloor['Ground Floor'][] = $row;
                    }
                }
                
                // Display each floor
                foreach ($roomsByFloor as $floorName => $rooms) {
                    if (count($rooms) > 0) {
              ?>
                      <div class="floor-container" data-floor="<?php echo strtolower(str_replace(' ', '-', $floorName)); ?>">
                        <div class="floor-title"><?php echo $floorName; ?></div>
                        
                        <div class="rooms-grid" id="rooms-<?php echo strtolower(str_replace(' ', '-', $floorName)); ?>">
                          <?php
                          foreach ($rooms as $row) {
                            // Determine room class based on status
                            $roomClass = '';
                            $roomTitle = '';
                            
                            if ($row['Status'] == 'Y' && $row['billsettle'] <> 1) {
                              $roomClass = 'room-occupied';
                              $roomTitle = 'Occupied';
                            } else if ($row['Status'] == 'Y' && $row['billsettle'] == 1) {
                              $roomClass = 'room-billsettle';
                              $roomTitle = 'Bill Settlement';
                            } else if ($row['Status'] == 'N' && $row['notready'] <> 0) {
                              $roomClass = 'room-dirty';
                              $roomTitle = 'Dirty';
                            } else if ($row['blocked'] == 1 && $row['mblock'] != 0 && $row['foblock'] != 1) {
                              $roomClass = 'room-maintenance';
                              $roomTitle = 'Maintenance';
                            } else if ($row['blocked'] == 1 && $row['mblock'] != 1 && $row['foblock'] != 0) {
                              $roomClass = 'room-blocked';
                              $roomTitle = 'Blocked';
                            } else if ($row['Status'] == 'N' && $row['blocked'] != 1 && $row['notready'] == 0) {
                              $roomClass = 'room-available';
                              $roomTitle = 'Available';
                            }

                            // Get guest name if available
                            $guestName = '';
                            if (isset($row['GuestName']) && !empty($row['GuestName'])) {
                              $guestName = $row['GuestName'];
                            }
                            
                            // Get room type
                            $roomType = isset($row['RoomType']) ? $row['RoomType'] : '';
                            
                            // Store room data in data attributes
                            $roomData = htmlspecialchars(json_encode([
                              'room_id' => $row['Room_Id'],
                              'room_no' => $row['RoomNo'],
                              'status' => $row['Status'],
                              'billsettle' => $row['billsettle'],
                              'notready' => $row['notready'],
                              'blocked' => $row['blocked'],
                              'mblock' => $row['mblock'],
                              'foblock' => $row['foblock'],
                              'room_type' => $roomType,
                              'guest_name' => $guestName
                            ]), ENT_QUOTES, 'UTF-8');
                          ?>
                          
                        
                          <div class="room-box <?php echo $roomClass; ?>" 
                               data-room='<?php echo $roomData; ?>'
                               data-number="<?php echo $row['RoomNo']; ?>"
                               data-type="<?php echo $roomType; ?>"
                               data-guest="<?php echo $guestName; ?>"
                               data-roomid="<?php echo $row['Room_Id']; ?>"
                               data-status="<?php echo $roomTitle; ?>"
                               title="<?php echo $roomTitle . ': ' . $row['RoomNo']; if($guestName) echo ' - ' . $guestName; ?>">
                            <?php echo $row['RoomNo']; ?>
                            
                            <!-- Hover Options Menu -->
                            <div class="room-options">
                              <?php if ($row['Status'] == 'Y' && $row['billsettle'] <> 1) { ?>
                                <!-- Occupied Room Options -->
                                <div class="room-option" onclick="postadvance('<?php echo $row['Room_Id']; ?>')">
                                  <i class="fa fa-credit-card"></i> Advance Posting
                                </div>
                                <div class="room-option" onclick="postbill('<?php echo $row['Room_Id']; ?>')">
                                  <i class="fa fa-file-text"></i> Bill Posting
                                </div>
                                
                                <?php if (@$aview == 1 || @$aedit == 1 || @$aadd == 1 || @$adelete == 1) { ?>
                                  <div class="room-option" onclick="allowance('<?php echo $row['Room_Id']; ?>')">
                                    <i class="fa fa-gift"></i> Allowance Posting
                                  </div>
                                <?php } ?>
                                
                                <?php if (@$rview == 1 || @$redit == 1 || @$radd == 1 || @$rdelete == 1) { ?>
                                  <div class="room-option" onclick="roomtransfer('<?php echo $row['Room_Id']; ?>')">
                                    <i class="fa fa-exchange"></i> Room Transfer
                                  </div>
                                <?php } ?>
                                
                                <?php if (@$gview == 1 || @$gedit == 1 || @$gadd == 1 || @$gdelete == 1) { ?>
                                  <div class="room-option" onclick="amendment('<?php echo $row['Room_Id']; ?>')">
                                    <i class="fa fa-edit"></i> Guest Amendment
                                  </div>
                                <?php } ?>
                                
                                <?php if (@$cview == 1 || @$cedit == 1 || @$cadd == 1 || @$cdelete == 1) { ?>
                                  <?php
                                    $sql1="select * from Room_Status rs
                                    INNER JOIN Trans_checkin_mas cmas on cmas.grcid=rs.grcid
                                    where rs.Status='Y' and isnull(cmas.cancelflag,0) = 0 and rs.Roomid='".$row['Room_Id']."'";	 
                                    $exe = $this->db->query($sql1);                 
                                    foreach($exe -> result_array() as $rowss){
                                      $GROUPCHECKIN= $rowss['GROUPCHECKIN'];
                                    }
                                  ?>
                                  <?php if($GROUPCHECKIN == 0) { ?>		
                                    <div class="room-option" onclick="checkout('<?php echo $row['Room_Id']; ?>')">
                                      <i class="fa fa-sign-out"></i> Checkout
                                    </div>
                                  <?php } else { ?>
                                    <div class="room-option" onclick="GroupCheckout('<?php echo $row['Room_Id']; ?>')">
                                      <i class="fa fa-sign-out"></i> Group Checkout
                                    </div>
                                  <?php } ?>
                                <?php } ?>
                                
                              <?php } else if ($row['Status'] == 'N' && $row['blocked'] != 1 && $row['notready'] == 0) { ?>
                                <!-- Available Room Options -->
                                <?php if (@$view == 1 || @$edit == 1 || @$add == 1 || @$delete == 1) { ?>
                                  <div class="room-option" onclick="checkin('<?php echo $row['Room_Id']; ?>','<?php echo date('Y-m-d') ?>','<?php echo date('Y-m-d', strtotime('+1 Day')); ?>')">
                                    <i class="fa fa-sign-in"></i> Check-in
                                  </div>
                                  
                                  <?php
                                    $setqry = "select enablepower from extraoption";
                                    $set = $this->db->query($setqry)->row_array();
                                    
                                    if($set['enablepower'] == 1) {
                                      $optqry = "select * from room_status where Roomid = '".$row['Room_Id']."'";
                                      $opt = $this->db->query($optqry)->row_array();
                                      if($opt['Pwvisiting'] == 1 || $opt['Pwcleaning'] == 1 || $opt['Pwmaintenance'] == 1 ) {
                                  ?>
                                        <div class="room-option" onclick="errvisit()">
                                          <i class="fa fa-user"></i> Visiting
                                        </div>
                                        <div class="room-option" onclick="errmaintainance()">
                                          <i class="fa fa-wrench"></i> Maintainance
                                        </div>
                                  <?php } else { ?>
                                        <div class="room-option" onclick="visit('<?php echo $row['Room_Id']; ?>')">
                                          <i class="fa fa-user"></i> Visiting
                                        </div>
                                        <div class="room-option" onclick="maintainance('<?php echo $row['Room_Id']; ?>')">
                                          <i class="fa fa-wrench"></i> Maintainance
                                        </div>
                                  <?php } ?>
                                <?php } ?>
                                <?php } ?>
                                
                              <?php } else if ($row['Status'] == 'N' && $row['notready'] <> 0) { ?>
                                <!-- Dirty Room Options -->
                                <?php if (@$cdview == 1 || @$cdedit == 1 || @$cdadd == 1 || @$cddelete == 1) { ?>
                                  <div class="room-option" onclick="cleardirty('<?php echo $row['Room_Id'] ?>')">
                                    <i class="fa fa-trash"></i> Clear Dirty
                                  </div>
                                  
                                  <?php
                                    $setqry = "select enablepower from extraoption";
                                    $set = $this->db->query($setqry)->row_array();
                                    
                                    if($set['enablepower'] == 1) {
                                      $optqry = "select * from room_status where Roomid = '".$row['Room_Id']."'";
                                      $opt = $this->db->query($optqry)->row_array();
                                      if($opt['Pwvisiting'] == 1 || $opt['Pwcleaning'] == 1 || $opt['Pwmaintenance'] == 1 ) {
                                  ?>
                                        <div class="room-option" onclick="errclean('<?php echo $row['Room_Id'] ?>')">
                                          <i class="fa fa-broom"></i> Cleaning
                                        </div>
                                        <div class="room-option" onclick="errmaintainance('<?php echo $row['Room_Id'] ?>')">
                                          <i class="fa fa-wrench"></i> Maintainance
                                        </div>
                                  <?php } else { ?>
                                        <div class="room-option" onclick="clean('<?php echo $row['Room_Id'] ?>')">
                                          <i class="fa fa-broom"></i> Cleaning
                                        </div>
                                        <div class="room-option" onclick="maintainance('<?php echo $row['Room_Id'] ?>')">
                                          <i class="fa fa-wrench"></i> Maintainance
                                        </div>
                                  <?php } ?>
                                <?php } ?>
                                <?php } ?>
                                
                              <?php } else if ($row['Status'] == 'Y' && $row['billsettle'] == 1) { ?>
                                <!-- Bill Settle Room Options -->
                                <?php if (@$sview == 1 || @$sedit == 1 || @$sadd == 1 || @$sdelete == 1) { ?>
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
                                  <?php if($groupcheckout == 1) { ?>		
                                    <div class="room-option" onclick="group_settlement('<?php echo $checkoutid; ?>')">
                                      <i class="fa fa-money"></i> Group Settlement
                                    </div>
                                  <?php } else { ?>			
                                    <div class="room-option" onclick="settlement('<?php echo $checkoutid; ?>')">
                                      <i class="fa fa-money"></i> Settlement
                                    </div>
                                  <?php } ?>											
                                <?php } ?>
                              <?php } ?>
                            </div>
                          </div>
                          
                          <?php } ?>
                        </div>
                      </div>
              <?php
                    }
                }
              }
              ?>
            </div>
            <!-- END SIMPLE ROOM CHART -->
            
            <!-- Dialog Boxes -->
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
            
          </fieldset>
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
// Enhanced Real-time Search Functionality
let searchTimer;
const searchInput = document.getElementById('searchInput');
const clearSearchBtn = document.getElementById('clearSearchBtn');

// Auto-focus search input on page load
document.addEventListener('DOMContentLoaded', function() {
    searchInput.focus();
    
    // Initialize filter tabs
    const filterTabs = document.getElementById('filterTabs');
    if (filterTabs) {
        const tabs = filterTabs.querySelectorAll('.filter-tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                performSearch(); // Re-filter with the selected filter
            });
        });
    }
});




function performSearch() {
    clearTimeout(searchTimer);
    
    // Show clear button if there's text
    if (searchInput.value.trim() !== '') {
        clearSearchBtn.style.display = 'flex';
    } else {
        clearSearchBtn.style.display = 'none';
        // If search is empty, show all rooms
        resetSearch();
        return;
    }
    
    // Show loading indicator
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'block';
    }
    
    searchTimer = setTimeout(() => {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        // Get active filter
        let activeFilter = 'all';
        const activeTab = document.querySelector('.filter-tab.active');
        if (activeTab) {
            activeFilter = activeTab.dataset.filter || 'all';
        }
        
        // Count visible rooms
        let visibleRoomCount = 0;
        
        // Filter rooms on client side
        const allRooms = document.querySelectorAll('.room-box');
        
        allRooms.forEach(room => {
            const roomNumber = room.dataset.number ? room.dataset.number.toLowerCase() : '';
            const roomType = room.dataset.type ? room.dataset.type.toLowerCase() : '';
            const guestName = room.dataset.guest ? room.dataset.guest.toLowerCase() : '';
            const roomId = room.dataset.roomid || '';
            const roomStatus = room.dataset.status ? room.dataset.status.toLowerCase() : '';
            
            let matches = false;
            
            switch(activeFilter) {
                case 'room':
                    matches = roomNumber.includes(searchTerm);
                    break;
                case 'guest':
                    matches = guestName.includes(searchTerm);
                    break;
                case 'type':
                    matches = roomType.includes(searchTerm);
                    break;
                case 'status':
                    matches = roomStatus.includes(searchTerm);
                    break;
                default: // 'all'
                    matches = roomNumber.includes(searchTerm) || 
                              roomType.includes(searchTerm) || 
                              guestName.includes(searchTerm) ||
                              roomId.includes(searchTerm) ||
                              roomStatus.includes(searchTerm);
                    break;
            }
            
            if (matches) {
                room.style.display = 'flex';
                visibleRoomCount++;
                
                // Show the parent floor container
                const floorContainer = room.closest('.floor-container');
                if (floorContainer) {
                    floorContainer.style.display = 'block';
                }
            } else {
                room.style.display = 'none';
            }
        });
        
        // Hide floors with no visible rooms
        document.querySelectorAll('.floor-container').forEach(floor => {
            const visibleRooms = floor.querySelectorAll('.room-box[style*="display: flex"]').length;
            
            if (visibleRooms === 0) {
                floor.style.display = 'none';
            }
        });
        
        // Check if we have results
        if (visibleRoomCount === 0 && searchTerm !== '') {
            showNoResults(searchTerm);
        } else {
            // Remove any existing no results message
            const container = document.getElementById('roomChartContainer');
            const existingNoResults = container.querySelector('.no-results');
            if (existingNoResults) {
                existingNoResults.remove();
            }
        }
        
        // Hide loading indicator
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }
    }, 300); // Debounce delay
}





function clearSearch() {
    searchInput.value = '';
    clearSearchBtn.style.display = 'none';
    resetSearch();
    searchInput.focus();
}



function resetSearch() {

    document.querySelectorAll('.room-box').forEach(room => {
        room.style.display = 'flex';
    });
    document.querySelectorAll('.floor-container').forEach(floor => {
        floor.style.display = 'block';
    });
    
  
    const loadingIndicator = document.getElementById('loadingIndicator');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'none';
    }
    

    const container = document.getElementById('roomChartContainer');
    const noResults = container.querySelector('.no-results');
    if (noResults) {
        noResults.remove();
    }
}




function showNoResults(searchTerm) {
    const container = document.getElementById('roomChartContainer');
    
    let hasVisibleRooms = false;
 
    document.querySelectorAll('.room-box').forEach(room => {

        const style = window.getComputedStyle(room);
        if (style.display !== 'none') {
            hasVisibleRooms = true;
        }
    });

    document.querySelectorAll('.floor-container').forEach(floor => {
        const style = window.getComputedStyle(floor);
        if (style.display !== 'none') {
            hasVisibleRooms = true;
        }
    });
    

    if (hasVisibleRooms) {

        const existingNoResults = container.querySelector('.no-results');
        if (existingNoResults) {
            existingNoResults.remove();
        }
        return; 
    }
    
  
    const noResultsDiv = document.createElement('div');
    noResultsDiv.className = 'no-results';
    noResultsDiv.innerHTML = `
        <div class="no-results-icon">🔍</div>
        <div class="no-results-text">No rooms found for "${searchTerm}"</div>
        <div class="no-results-subtext">Try a different search term or filter</div>
        <button onclick="clearSearch()" style="margin-top: 15px; padding: 8px 16px; background: #0057B7; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Clear Search
        </button>
    `;
    
  
    const existingNoResults = container.querySelector('.no-results');
    if (existingNoResults) {
        existingNoResults.remove();
    }
    
   
    container.appendChild(noResultsDiv);
}


document.addEventListener('DOMContentLoaded', function() {

    searchInput.addEventListener('input', function() {
        clearSearchBtn.style.display = this.value.trim() !== '' ? 'flex' : 'none';
        if (this.value.trim() === '') {
            resetSearch();
        }
    });
    

    document.addEventListener('keydown', function(e) {
    
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
        }
      
        if (e.key === 'Escape') {
            if (searchInput.value.trim() !== '') {
                clearSearch();
                searchInput.focus();
            }
        }
    });
    

    const roomBoxes = document.querySelectorAll('.room-box');
    
    roomBoxes.forEach(box => {
        box.addEventListener('mouseenter', function(e) {

            this.style.zIndex = '1000';
            
            const options = this.querySelector('.room-options');
            if (options) {
                options.style.opacity = '1';
                options.style.visibility = 'visible';
                options.style.transform = 'translateX(-50%) translateY(5px)';
                
          
                const rect = this.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                
                if (rect.right + 160 > viewportWidth) {
        
                    options.style.left = 'auto';
                    options.style.right = '0';
                    options.style.transform = 'translateY(5px)';
                } else {
                
                    options.style.left = '50%';
                    options.style.right = 'auto';
                    options.style.transform = 'translateX(-50%) translateY(5px)';
                }
            }
        });
        
        box.addEventListener('mouseleave', function(e) {
      
            const relatedTarget = e.relatedTarget;
            const options = this.querySelector('.room-options');
            
            if (options && options.contains(relatedTarget)) {
                return;
            }
            
            this.style.zIndex = '';
            
            if (options) {
                options.style.opacity = '0';
                options.style.visibility = 'hidden';
                options.style.transform = 'translateX(-50%) translateY(5px)';
            }
        });
    });
    

    const roomOptions = document.querySelectorAll('.room-options');
    roomOptions.forEach(options => {
        options.addEventListener('mouseleave', function(e) {
            const parentRoom = this.closest('.room-box');
            if (parentRoom) {
                parentRoom.style.zIndex = '';
                this.style.opacity = '0';
                this.style.visibility = 'hidden';
                this.style.transform = 'translateX(-50%) translateY(5px)';
            }
        });
    });
});


var today = new Date().getFullYear() + '/' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '/' + ("0" + new Date().getDate()).slice(-2);

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

function group_settlement(a) {
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