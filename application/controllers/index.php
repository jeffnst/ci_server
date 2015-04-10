<?php
class index extends CI_Controller{
	
	function __construct(){
		
		parent::__construct();
		$this->load->helper('array');
	}
	
	function index(){
		
		$this->load->view('index');
	}
	
	function login(){
		header("Content-Type:application/json");
		$this->load->model('login_model');
		
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));
		$ip = $this->input->post('ip');
		
		/* echo $username;
		echo "<br>";
		echo $password;
		echo "<br>";
		echo $ip; */
$objConnect = mysql_connect("localhost","design2hou_api","roman015");
		
	if ($objConnect){		
		if (!empty($username) & !empty($password))
		{
			if ($this->login_model->check_login($username , $password) != null)
			{		 	
		 		$query = $this->db->get('users');
		 		foreach ($query->result() as $row)
		 			{
		 				$response = array(
		 					'status' => $row->status,
		 					'fullname' => $row->fullName,
		 					'nickname' => $row->nickName
		 					//'ip' => $ip
		 				);		 		
		 			}
				$json_response = json_encode($response);		
				echo $json_response;
			}
			else 
			{			
				$this->loginF_response(401, "login request fails");			
			}
		}
		else 
		{
			$this->loginF_response(401, "login request fails");
		} 
	}
	else 
	{		
		$this->database_response(503, "Unable to connect with database.");
	}
		
mysql_close($objConnect);
	
	}
	
	function deliver_response($status, $status_message, $data){
		header("HTTP/1.1 $status $status_message");
	
		$response['Status']=$status;
		$response['Fullname']=$status_message;
		$response['Nickname']=$data;
	
		$json_response=json_encode($response);
		echo $json_response;
	}
	
	function loginF_response($status, $status_message){
		header("HTTP/1.1 $status $status_message");
	
		$response['Status']=$status;
		$response['Message']=$status_message;
	
		$json_response=json_encode($response);	
		echo $json_response;
	}
	
	function database_response($status, $status_message){
		header("HTTP/1.1 $status $status_message");
	
		$response['Status']=$status;
		$response['Message']=$status_message;
			
		$json_response=json_encode($response);	
		echo $json_response;
	}
}
