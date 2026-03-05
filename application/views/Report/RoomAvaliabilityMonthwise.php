<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->pweb->phead();
$this->pcss->wcss();
$this->pweb->wtop();
$this->pweb->timezone();
$this->pweb->sidebar_style();
$this->pweb->wheader($this->Menu,$this->session);
$this->pweb->menu($this->Menu,$this->session);
$this->pweb->Cheader('Report','RoomAvaliability');
$this->pfrm->FrmHead3('Report / Room Avaliability Monthwise Chart',$F_Class."/".$F_Ctrl,$F_Class."/".$F_Ctrl."_View");
 ?>



<?php  	date_default_timezone_set('Asia/Kolkata');  ?>

<div class="col-sm-12">
  <div class="the-box F_ram">

        <form action="" method="POST">
            <table class="FrmTable T-6" >
                <tr>
                    <td align="right" class="F_val">From Date</td>
                    
                    <td align="left"><input type="text" id="Fdate"  name="CurDate"  value="<?php if(isset($_POST['CurDate'])){ echo $_POST['CurDate'];}else{echo date('d-m-Y');} ?>"   class="scs-ctrl Dat" /></td>

                    <td align="right" class="F_val">To Date</td>
                    <td align="left"><input type="text" id="Fdate"  name="ToDate"  value="<?php if(isset($_POST['ToDate'])){ echo $_POST['ToDate'];}else{echo date('d-m-Y', strtotime('+10 Day'));} ?>"   class="scs-ctrl Dat" /></td>       
                    <td align="left"><input type="submit" name="submit"  class="btn btn-success btn-block" value="Get"></td>
                </tr>
            </table> 
        </form>

  </div>

</div>

	
      <table class="table table-bordered table-hover"  >         
		   <tbody>
		    <?php 

			 
             $date=date('Y-m-d');
             $tdate = date('Y-m-d');
             if(isset($_POST['CurDate'])){
              $date= date('Y-m-d', strtotime($_POST['CurDate']));
              $tdate= date('Y-m-d', strtotime($_POST['ToDate']));
              
             }
             else{
               $tdate = date("Y-m-d",strtotime ('+10 day'));
             }

              $a_date = $date;
              $b_date = $tdate;
             
              $aa_date =date_create($date); // convert the date to string
              $l_date=date_create($tdate);
              $diff=date_diff($aa_date ,$l_date );
              $difference = $diff->format("%a");
             
             
             echo '<tr>';
             echo '<td  style="text-align: start;background-color: #A9A9A9;"></td>';	
             for($i=0; $i<=$difference ; $i++){	 
             echo '<td  style="text-align: center;background-color: #A9A9A9;">'.substr($a_date,8,9).'</td>';
             $a_date = date("Y-m-d",strtotime ('+1 day' , strtotime ($a_date)));  
              }
             echo '</tr>';	
             echo '<tr>';
                $a_date = $date;
                echo '<td  style="text-align: start;background-color: #A9A9A9;">Day</td>';          
                for($i=0; $i<=$difference ; $i++){
                    
                echo '<td  style="text-align: center;">'.substr(date('D', strtotime($a_date)),0,3).'</td>';
                $a_date = date("Y-m-d",strtotime ('+1 day' , strtotime ($a_date )));
                }
                echo '</tr>';
           
                echo '<tr>';
                echo '<td  style="text-align: start;background-color: #A9A9A9;">Rooms</td>';	
                $for = date('Y-m-d');
                 $F_date = $date;
                
                for($i=0; $i<=$difference ; $i++){   
                    $view = "exec Room_availability_monthwise '".$F_date."' ";
                    $exec = $this->db->query($view);
                    $Troom = 0;
                    $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
                     $no = $exec->num_rows();
                    if($no != 0){
                      foreach($exec->result_array() as $data){
                        $Troom = $Troom+$data['Totalrooms'];
                      }
                       if(strtotime($F_date)<= strtotime($for)){
                        echo '<td style="text-align: center;"></td>';
                       }
                       else{
                        echo '<td class="text-center">'.@$Troom.'</td>';   
                       }
                    
                    }
                    else{
                         if(strtotime($F_date) <= strtotime($for)){
                      
                        echo '<td style="text-align: center;"></td>';
                   
                         }
                         else{
                          
                           echo '<td class="text-center"></td>'; 
                         }
                    }
                }  
               
            echo '</tr>';
        
            echo '<tr>';
            echo '<td  style="text-align: start; background-color: #A9A9A9;">Reserved</td>';	
            $for = date('Y-m-d');
             $F_date = $date;

            for($i=0; $i<=$difference ; $i++){   
                $view = "exec Room_availability_monthwise '".$F_date."' ";
                $exec = $this->db->query($view);
                $booked = 0;
                $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
                 $no = $exec->num_rows();
                if($no != 0){
                    foreach($exec->result_array() as $data){
                     $booked = $booked +$data['Booking'];}
                   if(strtotime($F_date)<= strtotime($for)){
                    echo '<td style="text-align: center; background-color:#E5E4E2"></td>';
                   }
                   else{
                    echo '<td class="text-center">'.@$booked.'</td>';   
                   }
                }
                else{
                     if(strtotime($F_date) <= strtotime($for)){
                  
                    echo '<td style="text-align: center; background-color:#E5E4E2"></td>';
               
                     }
                     else{
                      
                       echo '<td class="text-center"></td>'; 
                     }
                }
            }  
           
        echo '</tr>';


        
        echo '<tr>';
        echo '<td  style="text-align: start;background-color: #A9A9A9;">Check-In</td>';	
        $for = date('Y-m-d');
         $F_date = $date;

        for($i=0; $i<=$difference ; $i++){   
            $view = "exec Room_availability_monthwise '".$F_date."' ";
            $exec = $this->db->query($view);
            $checkin = 0;
            $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
             $no = $exec->num_rows();
            if($no != 0){
                foreach($exec->result_array() as $data){
                 $checkin = $checkin + $data['Checkins'];
                }
               if(strtotime($F_date)<= strtotime($for)){
                echo '<td style="text-align: center;"></td>';
               }
               else{
                echo '<td class="text-center">'.@$checkin.'</td>';   
               }
            
            }
            else{
                 if(strtotime($F_date) <= strtotime($for)){
              
                echo '<td style="text-align: center;"></td>';
           
                 }
                 else{
                  
                   echo '<td class="text-center"></td>'; 
                 }
            }
        }  
       
    echo '</tr>';

    echo '<tr>';
    echo '<td  style="text-align: start;background-color: #A9A9A9;">Stay on(In house)</td>';	
    $for = date('Y-m-d');
     $F_date = $date;

    for($i=0; $i<=$difference ; $i++){   
        $view = "exec room_availability_monthwise '".$F_date."' ";
        $exec = $this->db->query($view);
        $stayin = 0;
        $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
         $no = $exec->num_rows();
        if($no != 0){
            foreach($exec->result_array() as $data){
             $stayin = $stayin + $data['Checkins'];}
           if(strtotime($F_date)<= strtotime($for)){
            echo '<td style="text-align: center;"></td>';
           }
           else{
            echo '<td class="text-center">'.@$stayin.'</td>';   
           }
        
        }
        else{
             if(strtotime($F_date) <= strtotime($for)){
          
            echo '<td style="text-align: center;"></td>';
       
             }
             else{
              
               echo '<td class="text-center"></td>'; 
             }
        }
    }  
   
echo '</tr>';


echo '<tr>';
        echo '<td  style="text-align: start;background-color: #A9A9A9;">Blocked Rooms</td>';	
        $for = date('Y-m-d');
         $F_date = $date;

        for($i=0; $i<=$difference ; $i++){   
        $view = "exec room_availability_monthwise'".$F_date."' ";
            $exec = $this->db->query($view);
            $blocked = 0;
            $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
             $no = $exec->num_rows();
            if($no != 0){
                foreach($exec->result_array() as $data){
                 $blocked = $blocked + $data['blockedrooms'];}
               if(strtotime($F_date)<= strtotime($for)){
                echo '<td style="text-align: center;"></td>';
               }
               else{
                echo '<td class="text-center">'.$blocked.'</td>';   
               }
            
            }
            else{
                 if(strtotime($F_date) <= strtotime($for)){
              
                echo '<td style="text-align: center;"></td>';
           
                 }
                 else{
                  
                   echo '<td class="text-center"></td>'; 
                 }
            }
        }  
    echo '</tr>';

    
echo '<tr>';
echo '<td  style="text-align: start;background-color: #A9A9A9;">ExpCheck out</td>';	
$for = date('Y-m-d');
 $F_date = $date;

for($i=0; $i<=$difference ; $i++){   
$view = "exec room_availability_monthwise '".$F_date."' ";
    $exec = $this->db->query($view);
    $exp = 0;
    $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
     $no = $exec->num_rows();
    if($no != 0){
        foreach($exec->result_array() as $data){
         $exp = $exp + $data['Expcheckout'];
        }
       if(strtotime($F_date)<= strtotime($for)){
        echo '<td style="text-align: center;"></td>';
       }
       else{
        echo '<td class="text-center">'.$exp.'</td>';   
       }
    
    }
    else{
         if(strtotime($F_date) <= strtotime($for)){
      
        echo '<td style="text-align: center;"></td>';
   
         }
         else{
          
           echo '<td class="text-center"></td>'; 
         }
    }
}  
echo '</tr>';


echo '<tr>';
echo '<td  style="text-align: start;background-color: #A9A9A9;">Position</td>';	
$for = date('Y-m-d');
 $F_date = $date;

for($i=0; $i<=$difference ; $i++){   
$view = "exec room_availability_monthwise '".$F_date."' ";
    $exec = $this->db->query($view);
    $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
    $avail= 0;
     $no = $exec->num_rows();
    if($no != 0){
        foreach($exec->result_array() as $data){
          $avail = $avail + $data['Availablerooms'];
        }
       if(strtotime($F_date)<= strtotime($for)){
        echo '<td style="text-align: center;"></td>';
       }
       else{
        echo '<td class="text-center">'.$avail.'</td>';   
       }
    
    }
    else{
         if(strtotime($F_date) <= strtotime($for)){
      
        echo '<td style="text-align: center;"></td>';
   
         }
         else{
          
           echo '<td class="text-center"></td>'; 
         }
    }
}  
echo '</tr>';
    
	
echo '<tr>';
echo '<td  style="text-align: start;background-color: #A9A9A9;">Occupancy %</td>';	
$for = date('Y-m-d');
 $F_date = $date;

for($i=0; $i<=$difference ; $i++){   
$view = "exec room_availability_monthwise'".$F_date."' ";
    $exec = $this->db->query($view);
    // $Trooms = 0;
    $avail = 0;
    $F_date = date("Y-m-d",strtotime ('+1 day' , strtotime ( $F_date )));
     $no = $exec->num_rows();
    if($no != 0){
      $Torooms = 0;
        foreach($exec->result_array() as $data){
           $Torooms +=  $data['Totalrooms'];

          $avail = $avail + $data['Availablerooms'];

           
        }
        if(strtotime($F_date)<= strtotime($for)){
          echo '<td style="text-align: center; background-color:#E5E4E2"></td>';
        }
        elseif($Torooms !=0 && $avail !=0){
          // echo '<td class="text-center">'.number_format((($avail/$Torooms)*100),2).'%'.'</td>';   
          echo '<td class="text-center">'.round(($avail/$Torooms)*100).'%'.'</td>';
        }
        else{
          echo '<td class="text-center">'.'0'.'%'.'</td>';
        }
    }
    else{
         if(strtotime($F_date) <= strtotime($for)){
      
        echo '<td style="text-align: center; background-color:#E5E4E2"></td>';
   
         }
         else{
          
           echo '<td class="text-center"></td>'; 
         }
    }
}  
echo '</tr>';

		   ?>		   
		   </tbody>
		 </table>	
	</div>

<?php 
$this->pfrm->FrmFoot();
$this->pweb->wfoot();
$this->pcss->wjs($F_Ctrl);
$this->licscript->LicenPopUp($this->Myclass);
$this->licscript->LicFooter();
?>