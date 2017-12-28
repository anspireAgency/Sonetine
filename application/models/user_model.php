<?php
class user_model extends CI_Model
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
		function reject_design($request_id){
			$data = array(
				'is_notify' => 0,
				'is_edit' => 0,
				'is_rejected' => 1,
				'is_approved'=>0,
				'auto_post'=> 0
			);
			$this->db->where('id', $request_id);
			return $this->db->update('requests', $data);
		}
		function get_page_by_req_id($reqid){
			return $this->db->query("SELECT *
							FROM requests r join user_pages up on r.user_pages_id = up.id
							where r.id=$reqid
							")->row();
		}
		function approve_request($request_id,$auto_post=0){
			$data = array(
				'is_notify' => 0,
				'is_edit' => 0,
				'is_rejected' => 0,
				'is_approved'=>1,
				'auto_post'=> $auto_post
			);
			$this->db->where('id', $request_id);
			return $this->db->update('requests', $data);
		}
		public function edit_request($request_id,$caption,$time,$notes){

			$data = array(
				'caption' => $caption,
				'notes' => $notes,
				'time_of_post' => $time,
				'is_notify' => 0,
				'is_edit' => 1
			);
			$this->db->where('id', $request_id);
			return $this->db->update('requests', $data);

		}
		public function update_notifications($user_id){
				return $this->db->query("update
								users u join user_pages up on u.id=up.user_id
								join requests r on r.user_pages_id = up.id
								SET r.is_notify=0
								where u.id=$user_id
								");
		}
		public function get_notifications($user_id,$is_read=1){
			if($is_read){
				return $this->db->query("SELECT *
								FROM users u join user_pages up on u.id=up.user_id
								join requests r on r.user_pages_id = up.id
								where u.id=$user_id AND r.is_notify=$is_read
								ORDER BY r.is_notify DESC
								");
			}
			else{
				return $this->db->query("SELECT *
							FROM users u join user_pages up on u.id=up.user_id
							join requests r on r.user_pages_id = up.id
							where u.id=$user_id
							ORDER BY r.is_notify DESC
							");
			}
		}
		public function insert_notification($request_id,$file_path){

			$data = array(
				'is_notify' => 1,
				'is_edit'=>0,
				'design_path' => $file_path
			);

			$this->db->where('id', $request_id);
			return $this->db->update('requests', $data);
			 //$this->db->insert('notifications', array('request_id' => $request_id,'file_path'=>$file_path));

		}
		public function requests(){
			return $this->db->query('SELECT r.id,r.notes,r.caption,r.type,r.time_of_post,up.page_name,up.page_id,u.first_name from requests r join user_pages up on r.user_pages_id=up.id join users u on u.id =up.user_id ');
		}
		public function insert_request($notes,$caption,$type,$time,$user_pages_id){
			return $this->db->insert("requests", array(
				'notes'=>$notes,
				'caption'=>$caption,
				'type'=>$type,
				'time_of_post'=>$time,
				'user_pages_id'=> $user_pages_id));
		}
		public function insert_designs_preferences($color_code,$logo_path,$font_path,$user_pages_id){
			return $this->db->insert("designs_preferences", array(
				'color_code'=>$color_code,
				'logo_path'=>$logo_path,
				'font_path'=>$font_path,
				'user_pages_id'=>$user_pages_id));
		}
		public function insert_user_page($user_id,$page_id,$page_category,$page_name,$access_token)
		{

			return $this->db->insert('user_pages', array('user_id' => $user_id,
			'access_token' => $access_token,
			'page_id' =>$page_id,
			'page_name' => $page_name,
			'page_category' => $page_category
			));
		}
		public function get_by_email($email){
			$this->db->from('users');
			$this->db->where('email', $email);
			return $this->db->get()->row();;
		}

	//insert into user table
	function insertUser($data)
    {
		return $this->db->insert('user', $data);
	}
	//send verification email to user's email id
	function sendEmail($to_email)
	{
		$from_email = 'team@mydomain.com';
		$subject = 'Verify Your Email Address';
		$message = 'Dear User,<br /><br />Please click on the below activation link to verify your email address.<br /><br /> http://www.mydomain.com/user/verify/' . md5($to_email) . '<br /><br /><br />Thanks<br />Mydomain Team';

		//configure email settings
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.mydomain.com'; //smtp host name
		$config['smtp_port'] = '465'; //smtp port number
		$config['smtp_user'] = $from_email;
		$config['smtp_pass'] = '********'; //$from_email password
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n"; //use double quotes
		$this->email->initialize($config);

		//send mail
		$this->email->from($from_email, 'Mydomain');
		$this->email->to($to_email);
		$this->email->subject($subject);
		$this->email->message($message);
		return $this->email->send();
	}

	//activate user account
	function verifyEmailID($key)
	{
		$data = array('status' => 1);
		$this->db->where('md5(email)', $key);
		return $this->db->update('user', $data);
	}
}
