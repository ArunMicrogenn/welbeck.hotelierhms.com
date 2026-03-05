<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class licscript {
    public function LicFooter()
        {
 ?>
    <script>
         var btnSubscription = document.getElementById("Subscription") ?? null;
        // onclick btnSubscription function to block the page
        if(btnSubscription != null){
        btnSubscription.onclick = function() {
            SubscriptionPopup.style.display = "block";
        }    
    }

         var SubscriptionPopup = document.getElementById("SubscriptionPopup");
         var SubscriptionPopupClose = document.getElementById("SubscriptionPopupClose");
            SubscriptionPopupClose.onclick = function() {
             SubscriptionPopup.style.display = "none";
            }
    </script>
 <?php
        } 
    public function LicenPopUp($Hotel)
    {        //    $Hotel->HotelDetails();  		
        ?>
        <div id="SubscriptionPopup" class="modal">
	        <div class="modal-content" style="width:60%">
	            <div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle" style="background-color:white !important;">
	 	            <!----span class="ui-dialog-title "style="color:#04c;">Your Subscription will expire soon</span-->
		            <span id="SubscriptionPopupClose" style="color:#04c;" class="close">&times;</span>		
	            </div>	
                <div> 
                <?php
                 $Res= $Hotel->HotelDetails();    
                 foreach($Res as $row)
                 {  $Company=$row['Company'];
                    $EndDate=$row['EndDate'];
                 }
                  ?>
                    <div>
                       <b>Your <?php echo $Company; ?> subscription period is approaching!</b>
                       <p>Hai ... </p>   
                       <p>This is a reminder that your subscription with <?php echo $Company; ?> will expire on <?php echo substr($EndDate,0,10); ?>.</p>                       
                       <p><a href="<?php echo scs_index; ?>Subscription/PayNow" class="btn btn-warning btn-sm">RENEW NOW</a></p>
                       <p>If you have any questions regarding the renewal process or need help, please don’t hesitate to contact us at customersupport@micrognn.com / +91-9790090010 / +91-9566411119.</p>
                        <p>With Regards,</p>
                        <p>Microgenn Teams</p>
                    </div>
                </div>
	        </div>
	    </div> 
    <?php
    }
}
?>