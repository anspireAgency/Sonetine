<?php

class Facebook extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		//die('here');
		$this->load->helper(array('form','url'));
		$this->load->library(array('session', 'form_validation', 'email'));
		$this->load->database();
		$this->load->model('user_model');
	}
	function index()
	{
		$this->load->view('facebook/index.php');
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
		  exit;

		} catch(Facebook\Exceptions\FacebookSDKException $e) {

		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;

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
		echo $this->user_model->insert_user_page($user_id,$page_id,$page_category,$page_name,$foreverPageAccessToken);
		//$foreverPageAccessToken
	}

}
