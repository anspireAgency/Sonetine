<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require __DIR__  . '\..\vendor\autoload.php';
require __DIR__ . '\..\bootstrap.php';
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;

use PayPal\Api\ShippingAddress;
class Calculators extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct()
	 {
			 parent::__construct();

			 $this->load->database();
			 $this->load->library(array('ion_auth', 'form_validation'));
			 $this->load->helper(array('url', 'language'));

			 $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

			 $this->lang->load('auth');
	 }

	public function index()
	{
		$this->load->view('calculator');
	}
	public function verify()
	{
		$email =  split('&hash=',$this->uri->segment(3))[0];
  	$hash =   split('&hash=',$this->uri->segment(3))[1];
					 $this->load->library(array('ion_auth', 'form_validation'));
		$original_hash=$this->ion_auth->get_hash($email);
		if($original_hash==$hash)
		{
			$this->ion_auth->verify_user($email);
			$this->load->view('calculator');
			echo 'Your mail has been verified';
		}
	}
	public function send_email($hash)
	{


		$config = Array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://mail.sonetine.com',
		'smtp_port' => 465,
		'smtp_user' => 'dont-reply@sonetine.com',
		'smtp_pass' => 'Dontpassword18',
		);
		 $this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		$this->email->from('dont-reply@sonetine.com', 'Sonetine - DO NOT REPLY');
		$this->email->to($this->input->post('email'));
		$this->email->subject(' Congratulations! You just created an account ');
		$data = array(
			'first_name' =>$this->input->post('first_name'),
      'email'=> $this->input->post('email'),
			'password' =>$this->input->post('password'),
			'hash'=>$hash

          );

		/*$message='Thanks for signing up, '.$this->input->post('first_name').'!

        Your account has been created.
        Here are your login details.
        -------------------------------------------------
        Email   : ' . $this->input->post('email') . '
        Password: ' . $this->input->post('password') . '
        -------------------------------------------------

        Please click this link to activate your account:

        ' . base_url() . 'Calculators/verify/' .
        'email=' .  $this->input->post('email') . '&hash=' . $hash ;*/

				$body=$this->load->view('emails/verification',$data);
		$this->email->message($body);
		if (!$this->email->send())
		{
			show_error($this->email->print_debugger());
		}
		else {
			echo 'Your e-mail has been sent!';
		}
	}
	public function create_user()
	{

		$this->data['title'] = $this->lang->line('create_user_heading');
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		if ($identity_column !== 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
		$this->form_validation->set_rules('industry', $this->lang->line('create_user_validation_industry_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
			$password = $this->input->post('password');
			$hash=md5(rand(0, 1000));
			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company' => $this->input->post('company'),
				'industry' => $this->input->post('industry'),
				'phone' => $this->input->post('phone'),
				'activation_code'=>$hash
			);
		}
		if ($this->form_validation->run() === TRUE && $this->ion_auth->register($identity, $password, $email, $additional_data))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
//$this->send_email($hash);
			$this->session->set_flashdata('message','Profile created successfully');
			echo '<meta http-equiv="refresh" content="2;url=' . site_url("auth/login") . '">';


		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one

			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['first_name'] = array(
				'name' => 'first_name',
				'id' => 'first_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
				'name' => 'last_name',
				'id' => 'last_name',
				'type' => 'text',
				'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['email'] = array(
				'name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
				'name' => 'company',
				'id' => 'company',
				'type' => 'text',
				'value' => $this->form_validation->set_value('company'),
			);

			$this->data['industry'] = array(
				'name' => 'industry',
				'id' => 'industry',
				'type' => 'text',
				'value' => $this->form_validation->set_value('industry'),
			);
			$this->data['phone'] = array(
				'name' => 'phone',
				'id' => 'phone',
				'type' => 'text',
				'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id' => 'password_confirm',
				'type' => 'password',
				'value' => $this->form_validation->set_value('password_confirm'),
			);

			$this->_render_page('user/create_user', $this->data);
		}
	}
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}
	public function create_plan()
	{
		$apiContext = new \PayPal\Rest\ApiContext(
		    new \PayPal\Auth\OAuthTokenCredential(
					'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS',     // ClientID
	        'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL'      // ClientSecret
		    )
		);



		$date = new DateTime('now');
		$nowTimestamp = $date->getTimestamp();
		$date->modify('first day of next month');
		$firstDayOfNextMonthTimestamp = $date->getTimestamp();
		//$remaining_days=($firstDayOfNextMonthTimestamp - $nowTimestamp) / 86400;

		/**********************
		$startDate= new DateTime();
		//$startDate=$startDate -> modify('+10 Minute');
		$startDate=$startDate ->setTimeZone(new DateTimeZone('UTC'));
		$startDate=$startDate->format(DateTime::ATOM);
		echo $startDate;
		exit(1);
		************************/

		$plan = new Plan();
		// # Basic Information
		// Fill up the basic information that is required for the plan
		$posts= $_POST['post'];
		$pages= $_POST['page'];
		$gifs= $_POST['gif'];
		$total=$_POST['total_price'];
		$agree=$_POST['agreement'];
		$remaining_days=$_POST['remaining_days'];
		$total_this_month=$_POST['total_this_month'];
		$desc_format=$posts." posts + ".$pages."pages + ".$gifs." gifs for a total of ". $total." $" ;
		$daily_rate=$total/30;

		$plan = new Plan();
		$plan->setName('Startup')
		    ->setDescription($desc_format)
		    ->setType('infinite');
		// # Payment definitions for this billing plan.
		$paymentDefinition = new PaymentDefinition();
		// The possible values for such setters are mentioned in the setter method documentation.
		// Just open the class file. e.g. lib/PayPal/Api/PaymentDefinition.php and look for setFrequency method.
		// You should be able to see the acceptable values in the comments.
		$paymentDefinition->setName('Regular Payments')
		    ->setType('REGULAR')
		    ->setFrequency('Month')
		    ->setFrequencyInterval("1")
		    //->setCycles("12")
		    ->setAmount(new Currency(array('value' =>  $total, 'currency' => 'USD')));
		// Charge Models
		$chargeModel = new ChargeModel();
		$chargeModel->setType('SHIPPING')
		    ->setAmount(new Currency(array('value' =>0, 'currency' => 'USD')));
		$paymentDefinition->setChargeModels(array($chargeModel));
		$merchantPreferences = new MerchantPreferences();
		$baseUrl = getBaseUrl();

		// ReturnURL and CancelURL are not required and used when creating billing agreement with payment_method as "credit_card".
		// However, it is generally a good idea to set these values, in case you plan to create billing agreements which accepts "paypal" as payment_method.
		// This will keep your plan compatible with both the possible scenarios on how it is being used in agreement.

		$merchantPreferences->setReturnUrl("$baseUrl/create_user?success=true")
		    ->setCancelUrl("$baseUrl/create_user?success=false")
		    ->setAutoBillAmount("yes")
		    ->setInitialFailAmountAction("CONTINUE")
		    ->setMaxFailAttempts("0")
		    ->setSetupFee(new Currency(array('value' => $total_this_month, 'currency' => 'USD')));
		$plan->setPaymentDefinitions(array($paymentDefinition));
		$plan->setMerchantPreferences($merchantPreferences);
		// For Sample Purposes Only.
		$request = clone $plan;
		// ### Create Plan
		try {
		    $output = $plan->create($apiContext);
		} catch (Exception $ex) {
		    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		    ResultPrinter::printError("Created Plan", "Plan", null, $request, $ex);
		    exit(1);
		}
		// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		 //ResultPrinter::printResult("Created Plan", "Plan", $output->getId(), $request, $output);
		 $createdPlan = $plan;//require 'UpdatePlan.php';


		 try {
		     $patch = new Patch();
		     $value = new PayPalModel('{
		 	       "state":"ACTIVE"
		 	     }');
		     $patch->setOp('replace')
		         ->setPath('/')
		         ->setValue($value);
		     $patchRequest = new PatchRequest();
		     $patchRequest->addPatch($patch);
		     $createdPlan->update($patchRequest, $apiContext);
		     $plan = Plan::get($createdPlan->getId(), $apiContext);
		 } catch (Exception $ex) {
		     // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		     ResultPrinter::printError("Updated the Plan to Active State", "Plan", null, $patchRequest, $ex);
		 }



		/* Create a new instance of Agreement object
		{
		    "name": "Base Agreement",
		    "description": "Basic agreement",
		    "start_date": "2015-06-17T9:45:04Z",
		    "plan": {
		      "id": "P-1WJ68935LL406420PUTENA2I"
		    },
		    "payer": {
		      "payment_method": "paypal"
		    },
		    "shipping_address": {
		        "line1": "111 First Street",
		        "city": "Saratoga",
		        "state": "CA",
		        "postal_code": "95070",
		        "country_code": "US"
		    }
		}*/
		//$startDate= new DateTime();
		//$startDate=$startDate -> modify('+3 Second');
		//$startDate=$startDate ->setTimeZone(new DateTimeZone('UTC'));
		$date=$date->setTimeZone(new DateTimeZone('UTC'));
		$date=$date->format(DateTime::ATOM);
		//$startDate=$startDate->format(DateTime::ATOM);
		$agreement = new Agreement();
		$agreement->setName($agree)
		    ->setDescription($desc_format)
		    ->setStartDate($date);

		    // date('c')  returns date in iso-8601 format
		// Add Plan ID
		// Please note that the plan Id should be only set in this case.
		$plan = new Plan();
		$plan->setId($createdPlan->getId());
		$agreement->setPlan($plan);
		// Add Payer
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		$agreement->setPayer($payer);
		// Add Shipping Address
		$shippingAddress = new ShippingAddress();
		$shippingAddress->setLine1('Ahmed Fakhry St.')
		    ->setCity('Cairo')
		    ->setPostalCode('11736')
		    ->setCountryCode('EG');
		$agreement->setShippingAddress($shippingAddress);
		// For Sample Purposes Only.
		$request = clone $agreement;
		// ### Create Agreement
		try {
		    // Please note that as the agreement has not yet activated, we wont be receiving the ID just yet.
		    $agreement = $agreement->create($apiContext);
		    // ### Get redirect url
		    // The API response provides the url that you must redirect
		    // the buyer to. Retrieve the url from the $agreement->getApprovalLink()
		    // method
		    $approvalUrl = $agreement->getApprovalLink();
		    echo "<script>location='".$approvalUrl."'</script>";
		    header("Location:".$approvalUrl);
		} catch (Exception $ex) {
		    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		    ResultPrinter::printError("Created Billing Agreement.", "Agreement", null, $request, $ex);
		    exit(1);
		}
	}

}
