<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library(array('ion_auth', 'form_validation'));
    $this->load->helper(array('url', 'language'));

    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    $this->lang->load('auth');
  }

  // redirect if needed, otherwise display the user list
  function index()
  {
    if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
    {
      // redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    } else {
      // set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      //list the requests
      $this->data['requests'] = $this->user_model->requests()->result();

      $this->_render_page('dashboard', $this->data);
    }
  }
  public function make_dir($page_name){
    if (!is_dir('./uploads/'.$page_name.'/incoming'))
    {
      mkdir('./uploads/'.$page_name.'/incoming', 0777, TRUE);
    }
  }
  function manage_request(){
    if (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
    {
      // redirect them to the home page because they must be an administrator to view this
      return show_error('You must be an administrator to view this page.');
    }else{
      $this->make_dir($_POST['page_name']);
      $config = array(
        'upload_path' => "./uploads/".$_POST['page_name'].'/incoming',
        'allowed_types' => "jpg|png|jpeg|txt",
        'overwrite' => TRUE,
        'max_size' => "2048000" // Can be set to particular file size , here it is 2 MB(2048 Kb)

      );
      $this->load->library('upload', $config);
      if($this->upload->do_upload())
      {
        $this->user_model->insert_notification($_POST['request_id'],
        get_image_path($this->upload->data()['full_path']));
        $this->session->set_flashdata('error', 'Design sent successfully to client');

      }
      else
      {
        $this->session->set_flashdata('error', $this->upload->display_errors());
      }

      redirect('dashboard');

    }
  }
  // log the user in
  function login()
  {
    $this->data['title'] = "Login";

    //validate form input
    $this->form_validation->set_rules('identity', 'Identity', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == true) {
      // check to see if the user is logging in
      // check for "remember me"
      $remember = (bool)$this->input->post('remember');

      if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
        //if the login is successful
        //redirect them back to the home page
        $this->session->set_flashdata('message', $this->ion_auth->messages());


        redirect('users/profile', 'refresh');


      } else {
        // if the login was un-successful
        // redirect them back to the login page
        $this->session->set_flashdata('message', $this->ion_auth->errors());
        redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
      }
    } else {
      // the user is not logging in so display the login page
      // set the flash data error message if there is one
      $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $this->data['identity'] = array('name' => 'identity',
      'id' => 'identity',
      'type' => 'text',
      'value' => $this->form_validation->set_value('identity'),
    );
    $this->data['password'] = array('name' => 'password',
    'id' => 'password',
    'type' => 'password',
  );

  $this->_render_page('auth/login', $this->data);
}
}

// log the user out
function logout()
{
  $this->data['title'] = "Logout";

  // log the user out
  $logout = $this->ion_auth->logout();

  // redirect them to the login page
  $this->session->set_flashdata('message', $this->ion_auth->messages());
  redirect('auth/login', 'refresh');
}


function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
{

  $this->viewdata = (empty($data)) ? $this->data : $data;

  $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

  if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
}

}
