<?php

class Facebook extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();

		if (!$this->ion_auth->logged_in()) {
				redirect('auth/login', 'refresh');
		}

		$this->load->helper(array('form','url'));
		$this->load->library(array('session', 'form_validation', 'email'));
		$this->load->database();
		$this->load->model('user_model');
	}
	function index()
	{
		$query=$this->user_model->get_notifications($this->ion_auth->user()->row()->id,0);
		$data['notifications']=$query->result();
		$data['notifications_num']=$this->user_model->get_notifications($this->ion_auth->user()->row()->id)->num_rows();
		$this->user_model->update_notifications($this->ion_auth->user()->row()->id);
		$this->load->view('facebook/index.php',$data);
	}
	function edit_request(){
		$request_id=$_POST['request_id'];
		$caption=$_POST['caption'];
		$time=$_POST['time'];
		$notes=$_POST['notes'];
		//echo $request_id.' '.$caption.''.$time.' '.$notes;


		if($this->user_model->edit_request($request_id,$caption,$time,$notes)>0){
			$this->session->set_flashdata('error', 'Edit request sent succesffully to administrator');
		}else
		$this->session->set_flashdata('error', 'Please edit again there has been problems with your query');
		redirect('Facebook/');



	}
	function reject(){

		$this->session->set_flashdata('error',$this->user_model->reject_design($_POST['rej_req_id'])?'Design rejected!':'Design not rejected');
		redirect('Facebook/','refresh');
	}
	public function download_design(){
		$path=$this->uri->uri_string();
		$link=get_download_link($path);
		$this->load->helper('download');
    $data = file_get_contents($link);//"http://localhost/sonetine/uploads/Test%20for%20sonetine/incoming/bg.png"); // Read the file's contents
    $name = get_image_name($link);//"http://localhost/sonetine/uploads/Test%20for%20sonetine/incoming/bg.png");
    force_download($name, $data);
	}
	public function post3($message="Testing Sonetine FB app"){
		include('C:\xampp\htdocs\sonetine\application\views\facebook\init.php');
		try {
			$arr = array('message' => $message);
		  // Returns a `Facebook\FacebookResponse` object
			$res = $fb->post('1806229853002835/feed?published=false&scheduled_publish_time=1514471433', $arr,	'EAAMZBpmriLogBAHW7PZBh0MnyUAFTGNwZBIEy3RJdRYrdTX3JeZCaH4lRlZCmEZBNbeq4VJNumXfnHq0K2kZBFgh1lFsBpzSmh4zyvugSw8oqMbr19k1AlHlFcI3pEEkvxgynRvGKLKHn8Ae6wPzdE3nzVpGbUzW94DDexNXhMClwZDZD');
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		/* handle the result */
	}

	public function schedule_post($reqid){
		//pageid,$caption,$time,$token

		$page=$this->user_model->get_page_by_req_id($reqid);

		include('C:\xampp\htdocs\sonetine\application\views\facebook\init.php');
		$arr = array('message' => $page-> caption,
									'url'=>"http://remadays.com/wp-content/uploads/2016/11/Picture_online-2015.jpg",
									//'url'=>"$page-> design_path",
								'published'=>'false',
								'scheduled_publish_time'=>strtotime($page -> time_of_post.' GMT+2'));
//die($page->time_of_post.'            '.strtotime($page -> time_of_post.' GMT+2'));
		$page_id=$page-> page_id;

		try {

			$res = $fb->post("$page_id/photos/", $arr,	$page-> access_token);
		//$res = $fb->post('1806229853002835/feed/', $arr,	'EAAMZBpmriLogBAHW7PZBh0MnyUAFTGNwZBIEy3RJdRYrdTX3JeZCaH4lRlZCmEZBNbeq4VJNumXfnHq0K2kZBFgh1lFsBpzSmh4zyvugSw8oqMbr19k1AlHlFcI3pEEkvxgynRvGKLKHn8Ae6wPzdE3nzVpGbUzW94DDexNXhMClwZDZD');
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			echo 'Graph returned an error: ' . $e->getMessage();
			exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;

		}

		// add code to redirect
	}

	function approve_request(){
		if (isset($_POST['auto_post'])){
			$this->schedule_post($_POST['req']);
			$this->user_model->approve_request($_POST['req'],1);
			$this->session->set_flashdata('error', 'Design is scheduled!');
		}
	else
	{
		$this->user_model->approve_request($_POST['req']);
		$this->session->set_flashdata('error', 'Design approved successfully');

	}
	redirect('Facebook/','refresh');

	}

	function request(){
		$pageid=$_POST['page_id'];
		$pagename=$_POST['page_name'];
		$caption=$_POST['caption'];
		$time=$_POST['time'];
		$notes=$_POST['notes'];
		$type=$_POST['type'];

		$this->form_validation->set_rules('caption', 'Caption', 'required');
		$this->form_validation->set_rules('time', 'Time Of Posting', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$data['pageid']=$pageid;
			$data['pagename']=$pagename;
			$this->load->view('designs/index',$data);
		}
		$this->user_model->insert_request($notes,$caption,$type,'2017-12-12 00:00:00',get_page($pageid)->row()->id);
		$this->session->set_flashdata('error',$this->user_model->insert_request($notes,$caption,$type,'2017-12-12 00:00:00',get_page($pageid)->row()->id)?'request sent successfully':'request was not sent');
		redirect('Facebook');
	}
	function upload(){
		$pageid=$_POST['page_id'];
		$pagename=$_POST['page_name'];
		//echo $pagename;

		$this->make_dir($pagename);
		$config = array(
			'upload_path' => "./uploads/".$pagename."/outgoing",
			'allowed_types' => "jpg|png|jpeg",
			'overwrite' => TRUE,
			'max_size' => "2048000" // Byte -> MB, Can be set to particular file size , here it is 2 MB(2048 Kb)
			//'max_height' => "768",
			//'max_width' => "1024"
		);
		$this->load->library('upload', $config);
		$F = array();

		$count_uploaded_files = count( $_FILES['images']['name'] );

		$files = $_FILES;
		$logo_path='';
		$font_path='';
		for( $i = 0; $i < $count_uploaded_files; $i++ )
		{

				$_FILES['userfile'] = [
						'name'     => $files['images']['name'][$i],
						'type'     => $files['images']['type'][$i],
						'tmp_name' => $files['images']['tmp_name'][$i],
						'error'    => $files['images']['error'][$i],
						'size'     => $files['images']['size'][$i]
				];

				$F[] = $_FILES['userfile'];
				if($this->upload->do_upload())
				{
					$data = array('upload_data' => $this->upload->data());
					if($i==0){
						$logo_path=get_image_path($data['upload_data']['full_path']);
						echo $logo_path;
					}
					else {
						$font_path=get_image_path($data['upload_data']['full_path']);
					}
					//print($this->upload->data()['file_name']);
					//echo "<br>";
				}
				else
				{
					$data['error']= $this->upload->display_errors();
					$data['pageid']=$pageid;
					$data['pagename']=$pagename;
					$this->load->view('facebook/add', $data);
				}
				// Here is where you do your CodeIgniter upload ...
		}
		$data['pageid']=$pageid;
		$data['pagename']=$pagename;

		echo $logo_path.' '.$font_path.' '.$_POST['color_code'].' '.get_page($pageid)->row()->id;
		$this->user_model->insert_designs_preferences($_POST['color_code'],$logo_path,$font_path,get_page($pageid)->row()->id);
		$this->load->view('designs/index',$data);
		//echo json_encode($F);
		//$this->load->view('facebook/upload_success',$data);
	}

	public function make_dir($page_name){
		if (!is_dir('./uploads/'.$page_name.'/outgoing'))
		{
			echo mkdir('./uploads/'.$page_name.'/outgoing', 0777, TRUE);
		}
	}
	public function callback(){
		include('C:\xampp\htdocs\sonetine\application\views\facebook\init.php');
		$data['user']=$this->user_model->get_by_email($this->session->userdata('email'));

		$helper = $fb->getRedirectLoginHelper();
		$_SESSION['FBRLH_state']=$_GET['state'];
		try {
		  $accessToken = $helper->getAccessToken();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {

		  echo 'Graph returned an error: ' . $e->getMessage();
			redirect('Facebook');
		  //exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			redirect('Facebook');
		  //exit;

		}

		if (! isset($accessToken)) {
		  echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
		  exit;
		}

		try {

		  $response = $fb->get('me/accounts', $accessToken->getValue());
		  $response = $response->getDecodedBody();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {

		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;

		}
		/*
		echo "<pre>";
		print_r($response['data']);
		print("\n");
		print_r($response['data'][0]['access_token']."\n");
		print("\n");
		print_r($response['data'][0]['id']);
		echo "</pre>";*/
		$pages=$response['data'];
		$pageId=$response['data'][0]['id'];
		$token=$response['data'][0]['access_token'];
		$longLivedToken = $fb->getOAuth2Client()->getLongLivedAccessToken($token);
		$fb->setDefaultAccessToken($longLivedToken);
		$response = $fb->sendRequest('GET', $pageId, ['fields' => 'access_token'])->getDecodedBody();
		$foreverPageAccessToken = $response['access_token'];
		$data['pages']=$pages;
		$this->load->view('facebook/fb-callback.php',$data);
	}
	public function add_page(){


		include('C:\xampp\htdocs\sonetine\application\views\facebook\init.php');
		$user_id=$_POST['user_id'];
		$page_id=$_POST['page_id'];
		$page_category=$_POST['page_category'];
		$page_name=$_POST['page_name'];
		$access_token=$_POST['access_token'];

		$longLivedToken = $fb->getOAuth2Client()->getLongLivedAccessToken($access_token);
		$fb->setDefaultAccessToken($longLivedToken);
		$response = $fb->sendRequest('GET', $page_id, ['fields' => 'access_token'])->getDecodedBody();
		$foreverPageAccessToken = $response['access_token'];
		$data['pageid'] = $page_id;
		$data['pagename']=$page_name;
		if(get_page($page_id)->num_rows()<=0){
			echo $this->user_model->insert_user_page($user_id,$page_id,$page_category,$page_name,$foreverPageAccessToken);
		}

		//$foreverPageAccessToken
				$this->load->view('facebook/add',$data);
	}

	public function add(){
				$this->load->view('facebook/add');
	}


	public function post($pageid,$token,$message="Testing Sonetine FB app"){
		include('C:\xampp\htdocs\sonetine\application\views\facebook\init.php');
		$arr = array('message' => $message);

		try {
		$res = $fb->post($pageid.'//feed/', $arr,	$token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {

			echo 'Graph returned an error: ' . $e->getMessage();
			exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;

		}

		echo 'A message has been posted to your FB page';
	}



// this function posts a scheduled post

}
