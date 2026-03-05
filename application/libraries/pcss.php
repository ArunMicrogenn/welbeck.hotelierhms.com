<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pcss {

        public function lcss()
        {
			$str = file_get_contents(spath.'app/link/lcss.json');
			$json = json_decode($str, true);
			 
			foreach($json['css'] as $row)
			{
				 echo '<link rel="stylesheet" href="'.scs_url.$row.'">';
			}
        }
		public function wcss()
        {
			$str = file_get_contents(spath.'app/link/css.json');
			$json = json_decode($str, true);
			 
			foreach($json['css'] as $row)
			{
				 echo '<link rel="stylesheet" href="'.scs_url.$row.'">
				 ';
			}
        }
		public function loginwjs()
		{
			$str = file_get_contents(spath.'app/link/wjs.json');
			$json = json_decode($str, true);
			 echo '
			 ';
			foreach($json['js'] as $row)
			{
				 echo '<script src="'.scs_url.$row.'"></script>
				 ';
			}	
		}
		public function wjs($F_Ctrl)
        {
			$str = file_get_contents(spath.'app/link/wjs.json');
			$json = json_decode($str, true);
			 echo '
			 ';
			foreach($json['js'] as $row)
			{
				 echo '<script src="'.scs_url.$row.'"></script>
				 ';
			}
			
			?>
            <script>
$(document).ready(function(e) {
    $(".<?php echo ActMenu; ?>").addClass('menu-open');
	$(".D_<?php echo ActMenu; ?>").css('display','block');
	$(".<?php echo ActMenu; ?> >a").addClass('menuact');
	$(".S_<?php echo $F_Ctrl; ?> >a").addClass('menuact');
	
});
</script>
            
            <?php
        }
}