<?php
defined('BASEPATH') or exit('No direct script access allowed');
$qry = "exec Get_UserGroup_Rights " . $UGID;
$Res = $this->db->query($qry);

?>

<div class="row">
  <div class="p-2">
    <fieldset style="border:1px solid #DBD5D5;padding:10px">
      <ul id="tree" style="list-style:none">
        <?php
        $qry = " SELECT * FROM menu ORDER BY Ord ";
        $Res = $this->db->query($qry);
        $i = 1;
        $j=1;
        foreach ($Res->result() as $row) {
          ?>
          <li><a href="#" onclick="selectMainmenu('<?php echo $i;?>')" style="color:#0057b7"><i class="<?php echo $row->Icon; ?>  "></i>
              <?php echo $row->Menu; ?>
            </a>
            <ul style="display:none"; id="main<?php echo $i;?>" class="mainmenus">
              <?php
              $qry1 = " SELECT * FROM MainMenu WHERE Menu_id= " . $row->Menu_Id;
              $ARes1 = $this->db->query($qry1);
             
              foreach ($ARes1->result() as $As) {
                ?>
                <li><a href="#" onclick="selectInnerMenu('<?php echo $j; ?>')" style="color:#0057b7" ><?php echo $As->Mainmenu ?></a>
                <ul style="display:none"; id="inner<?php echo $j;?>" class="innerul">
                  <?php
                  $qry2 = " SELECT * FROM SubMenu WHERE Mainmenu_id= " . $As->Mainmenu_id;
                  $ARes2 = $this->db->query($qry2);
                  foreach ($ARes2->result() as $As1) { ?>
                    <li><a onClick="UmenuRights_(<?php echo $As1->SubMenu_Id ?>,'<?php echo $As1->Smenu ?>')" href="#"
                        style="color:#333"><?php echo $As1->Smenu ?> </a> </li>
                  <?php } ?>
                </ul>
            </li>
            <?php
             $j++; }

              ?>
        </ul>
        </li>
      <?php $i = $i+1; } ?>
      </ul>
    </fieldset>
  </div>
</div>

<script>
  const selectMainmenu = (id) =>{
    const boxes = document.querySelectorAll('.mainmenus');

    boxes.forEach(box => {
      box.style.display="none";
    });
    document.getElementById('main'+id).style.display="block";
  }

  const selectInnerMenu = (idd) =>{
    const boxes = document.querySelectorAll('.innerul');

    boxes.forEach(box => {
      box.style.display="none";
    });
    document.getElementById('inner'+idd).style.display="block";
  }
</script>

