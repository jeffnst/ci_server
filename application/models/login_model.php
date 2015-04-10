<?php
	class login_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function check_login($username=null , $password=null){
			$this->db->where('email',$username);
			$this->db->where('hashedPw',$password);
			
			$query = $this->db->get('users');
			if ($query->num_rows()>0){
				
				return true;
			}
			else {
				return false;
			}
		}
	}