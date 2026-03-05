<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auto_c extends CI_Controller {

function __construct() {
        parent::__construct();
		$this->load->library('session');

		if (empty($this->session->userdata('POS'))) {
			echo '
			<!DOCTYPE html>
			<html>
			<head>
				<!-- Load SweetAlert v1 -->
				<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			</head>
			<body>
				<script>
					swal("Session Expired", "Your session has ended. You will be logged out.", "warning")
					.then(() => {
						window.location.href = "' . scs_index . 'login/logout";
					});
				</script>
			</body>
			</html>';
			exit;
		}
         define('ActMenu','Entry');
		$ci =& get_instance();
		$ci->router->class;  
		$ci->router->method; 
    }

	 public function Pop_city()
	{  $query = $this->db->query("exec Get_City"); ?>
	 <input type="text" />
       <table style="width:100%"class="sertable" >
	     <thead>
		  <tr style="background-color:#949191 !important">
		  <td>#S.No</td>
		  <td>City</td>
		  </tr>
		 </thead>
		 <?php $i=1;  foreach($query->result_array() as $row)
		        {              ?>
		 <tbody>
		 <tr>
		  <td><?php echo $i; ?></td>
		  <td onclick="Get_City(this.id)" id="<?php echo $row['Cityid']; ?>" name="<?php  echo $row['Cityid']; ?>"><?php echo $row['City']; ?><input id="city<?php echo $row['Cityid']; ?>" value="<?php echo $row['City']; ?>" type="hidden"/></td>
		  
		  </tr>
		 </tbody>
		<?php	$i++;	}  ?>
		</table>
		<?php
			
	}
	public function Pop_Designation()
	{  $query = $this->db->query("exec Get_Designation 0"); ?>
       <table style="width:100%"class="sertable" >
	     <thead>
		  <tr style="background-color:#949191 !important">
		  <td>#S.No</td>
		  <td>Designation</td>
		  </tr>
		 </thead>
		 <?php $i=1;  foreach($query->result_array() as $row)
		        {              ?>
		 <tbody>
		 <tr>
		  <td><?php echo $i; ?></td>
		  <td onclick="Get_Designation(this.id)" id="<?php echo $row['Desgid']; ?>" name="<?php  echo $row['Desgid']; ?>"><?php echo $row['Designation']; ?><input id="city<?php echo $row['Desgid']; ?>" value="<?php echo $row['Designation']; ?>" type="hidden"/></td>
		  
		  </tr>
		 </tbody>
		<?php	$i++;	}  ?>
		</table>
		<?php
			
	}
	 
	Public function Gst_State()
	{
	   
	  $query = $this->db->query("exec Get_StateCountry '".$_REQUEST['Cityid']."'");
	  foreach($query->result() as $row)
		{
		  $cityid=$row->Cityid;
		  $State_id=$row->State_id;
		  $State=$row->State;
		  $Country_Id=$row->Country_Id;
		  $Country=$row->Country;
		 
		}
	  echo json_encode($cityid."-".$State_id."-".$Country."-".$Country_Id."-".$State);
	}
	
	public function Customer()
	{   $row_set=[];	
		$query = $this->db->query("exec Search_Customer  '".$_REQUEST['term']."'");
		foreach($query->result() as $row)
		{				
			$data['value']=htmlentities(stripslashes($row->Firstname.' '.$row->Lastname)).'  '.htmlentities(stripslashes($row->Mobile)).'  '.htmlentities(stripslashes($row->Email_ID));
			$data['Firstname']=$row->Firstname;
			$data['Lastname']=$row->Lastname;
			$data['Title']=$row->Titelid;
			$data['Middlename']=$row->Middlename;
			$data['Mobile']=$row->Mobile;
			$data['Email_ID']=$row->Email_ID;
			$data['Cityid']=$row->Cityid;
			$data['Stateid']=$row->Stateid;
			$data['Countryid']=$row->Countryid;
			$data['HomeAddress1']=$row->HomeAddress1;
			$data['HomeAddress2']=$row->HomeAddress2;
			$data['HomeAddress3']=$row->HomeAddress3;
			$data['Homepincode']=$row->Homepincode;
			$data['ResidentialPhone']=$row->ResidentialPhone;
			$data['WorkAddress1']=$row->WorkAddress1;
			$data['WorkAddress2']=$row->WorkAddress2;
			$data['WorkAddress3']=$row->WorkAddress3;
			$data['Workpincode']=$row->Workpincode;
			$data['WorPhone']=$row->WorPhone;
			$data['Profession']=$row->Profession;
			$data['Birthdate']=$row->Birthdate;
			$data['Weddingdate']=$row->Weddingdate;
			$data['Likes']=$row->Likes;
			$data['Dislikes']=$row->Dislikes;
			$data['Preffered_Room']=$row->Preffered_Room;
			$data['Hotel_Commends']=$row->Hotel_Commends;
			$data['passportno']=$row->passportno;
			$data['Passport_issuedate']=$row->Passport_issuedate;
			$data['Passport_issueplace']=$row->Passport_issueplace;
			$data['Passport_Expirydate']=$row->Passport_Expirydate;
			$data['VISA_No']=$row->VISA_No;
			$data['VISA_Issuedate']=$row->VISA_Issuedate;
			$data['VISA_Issueplace']=$row->VISA_Issueplace;
			$data['VISA_Expirydate']=$row->VISA_Expirydate;
			$data['Id_Documenttype']=$row->Id_Documenttype;				
			$data['Id_Documentno']=$row->Id_Documentno;				
			$data['City']=$row->GCity;
			$data['Nationality']=$row->Nationality;
			$data['Company_Id']=$row->Company_Id;
			$data['Company']=$row->Company;
			$data['age']=$row->age;
			$data['Customerid']=$row->Customer_Id;
			
			$row_set[] = $data; 
		}
		echo json_encode($row_set); 
	}
	public function CustomerName()
	{
		 $query = $this->db->query("exec Search_Customer_Name  '".$_REQUEST['term']."'");
			foreach($query->result() as $row)
			{
				 
				$data['value']=htmlentities(stripslashes($row->Firstname.' '.$row->Lastname)).'  '.htmlentities(stripslashes($row->Mobile)).'  '.htmlentities(stripslashes($row->Email_ID));
				$data['Firstname']=$row->Firstname;
				$data['Lastname']=$row->Lastname;
				$data['Middlename']=$row->Middlename;
				$data['Mobile']=$row->Mobile;
				$data['Email_ID']=$row->Email_ID;
				$data['Cityid']=$row->Cityid;
				$data['Stateid']=$row->Stateid;
				$data['Countryid']=$row->Countryid;
				$data['HomeAddress1']=$row->HomeAddress1;
				$data['HomeAddress2']=$row->HomeAddress2;
				$data['HomeAddress3']=$row->HomeAddress3;
				$data['Homepincode']=$row->Homepincode;
				$data['ResidentialPhone']=$row->ResidentialPhone;
				$data['WorkAddress1']=$row->WorkAddress1;
				$data['WorkAddress2']=$row->WorkAddress2;
				$data['WorkAddress3']=$row->WorkAddress3;
				$data['Workpincode']=$row->Workpincode;
				$data['WorPhone']=$row->WorPhone;
				$data['Profession']=$row->Profession;
				$data['Birthdate']=$row->Birthdate;
				$data['Weddingdate']=$row->Weddingdate;
				$data['Likes']=$row->Likes;
				$data['Dislikes']=$row->Dislikes;
				$data['Preffered_Room']=$row->Preffered_Room;
				$data['Hotel_Commends']=$row->Hotel_Commends;
				$data['passportno']=$row->passportno;
				$data['Passport_issuedate']=$row->Passport_issuedate;
				$data['Passport_issueplace']=$row->Passport_issueplace;
				$data['Passport_Expirydate']=$row->Passport_Expirydate;
				$data['VISA_No']=$row->VISA_No;
				$data['VISA_Issuedate']=$row->VISA_Issuedate;
				$data['VISA_Issueplace']=$row->VISA_Issueplace;
				$data['VISA_Expirydate']=$row->VISA_Expirydate;
				$data['Id_Documenttype']=$row->Id_Documenttype;				
				$data['Id_Documentno']=$row->Id_Documentno;				
				$data['City']=$row->GCity;				
				$data['Nationality']=$row->Nationality;
				$data['Company_Id']=$row->Company_Id;
				$data['Company']=$row->Company;
				$data['age']=$row->age;
				$data['Title']=$row->Titelid;
				$data['Customerid']=$row->Customer_Id;
				$row_set[] = $data; 

			}
			echo json_encode($row_set);
	}
	// public function city()
	// {
	// 	 $query = $this->db->query("exec Search_City  '".$_REQUEST['term']."'");

    //      if($query->num_rows() <= 1){ 

       
	// 		foreach($query->result() as $row)
	// 		{
				 
	// 			$data['value']=htmlentities(stripslashes($row->City));
	// 			$data['City']=$row->City;
	// 			$data['State_id']=$row->State_id;
	// 			$data['State']=$row->State;
	// 			$data['Cityid']=$row->Cityid;
	// 			$data['Country_Id']=$row->Country_Id;
	// 			$data['Country']=$row->Country;
	// 			$row_set[] = $data; 
	// 		}

    //         echo json_encode($row_set);

    //     } else{
    //         $data['City'] =  "City Not found";
    //         $row_set[] = $data; 

    //     }

    //         // if($data == ''){
    //         //     $row_set[] =  "no city found";
    //         // } 

            

           
	// }




    public function city()
{
    $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';

	$exe = "EXEC Search_City '".$term."'";
    $query = $this->db->query($exe);

    $row_set = [];

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $row_set[] = [
                'City' => $row->City,
                'Cityid' => $row->Cityid,
                'State_id' => $row->State_id,
                'State' => $row->State,
                'Country_Id' => $row->Country_Id,
                'Country' => $row->Country
            ];
        }
    } else {
        
        $row_set[] = [
            'City' => '',
            'Cityid' => '',
            'State_id' => '',
            'State' => '',
            'Country_Id' => '',
            'Country' => ''
        ];
    }

    echo json_encode($row_set);
}



	public function Nationality()
	{
		 $query = $this->db->query("select * from [Mas_Nationality]");
			foreach($query->result() as $row)
			{
				 
				$data['value']=htmlentities(stripslashes($row->Nationality));
				$data['Nationality']=$row->Nationality;
				$data['Nationid']=$row->Nationid;
				$row_set[] = $data; 
			}
			echo json_encode($row_set);
	}
	
	public function ResNo()
	{
		 $query = $this->db->query("exec Search_ResNo  '".$_REQUEST['term']."'");
			foreach($query->result() as $row)
			{
				 
				$data['value']=htmlentities(stripslashes($row->ResNo));
				$data['ResNo']=$row->ResNo;
				$row_set[] = $data; 
			}
			echo json_encode($row_set);
	}
	public function Company()
	{
		 $query = $this->db->query("exec Search_Company  '".$_REQUEST['term']."'");
			foreach($query->result() as $row)
			{
				 
				$data['value']=htmlentities(stripslashes($row->Company));
				$data['Company']=$row->Company;
				$data['Company_Id']=$row->Company_Id;
				$row_set[] = $data; 
			}
			echo json_encode($row_set);
	}
	public function Travel_Agent()
	{
		 $query = $this->db->query("exec Search_Travel_Agent '".$_REQUEST['term']."'");
			foreach($query->result() as $row)
			{
				 
				$data['value']=htmlentities(stripslashes($row->Company));
				$data['Company']=$row->Company;
				$data['Company_Id']=$row->Company_Id;
				$row_set[] = $data; 
			}
			echo json_encode($row_set);
	}


	public function getcity() {
		$term = $this->input->post('term');
		
		$exe = "SELECT mc.Cityid, ms.State_id, mco.Country_Id 
				FROM mas_city mc 
				INNER JOIN mas_state ms ON ms.state_id = mc.State_id
				INNER JOIN mas_country mco ON mco.Country_id = ms.Country_id
				WHERE mc.Cityid = '".$term."'"; 
		
		$query = $this->db->query($exe);
		
		$row_set = [];
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array(); // Use row_array() instead of row()
			
			$row_set[] = [
				'Cityid' => $result['Cityid'],
				'State_id' => $result['State_id'],
				'Country_Id' => $result['Country_Id'],
			];
		} else {
			$row_set[] = [
				'Cityid' => '',
				'State_id' => '',
				'Country_Id' => '',
			];
		}
		
		echo json_encode($row_set);
	}

	public function getallcitydet() {
		$term = $this->input->post('term');
		
		$exe = "SELECT mc.Cityid, ms.State_id, mco.Country_Id,City,State,Country 
				FROM mas_city mc 
				INNER JOIN mas_state ms ON ms.state_id = mc.State_id
				INNER JOIN mas_country mco ON mco.Country_id = ms.Country_id
				WHERE mc.Cityid = '".$term."'"; 
		
		$query = $this->db->query($exe);
		
		$row_set = [];
		
		if ($query->num_rows() > 0) {
			$result = $query->row_array(); // Use row_array() instead of row()
			
			$row_set[] = [
				'Cityid' => $result['Cityid'],
				'State_id' => $result['State_id'],
				'Country_Id' => $result['Country_Id'],
				'Country' => $result['Country'],
				'State' => $result['State'],
				'City' => $result['City']
			];
		} else {
			$row_set[] = [
				'Cityid' => '',
				'State_id' => '',
				'Country_Id' => '',
				'Country' => '',
				'State' => '',
				'City' => ''
			];
		}
		
		echo json_encode($row_set);
	}
	
}
