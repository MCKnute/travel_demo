<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accesses extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Access');
	}

	public function register(){

	    $post = $this->input->post();
	    if($post['password'] == $post['confirmpassword'])
	    {
	        $this->Access->register_user($post);
	        $this->session->set_flashdata("alert", "<div class='alert-success' role='alert'>
	            <strong>Well done!</strong> You successfully registered for Travel Buddy! Please log in now!
	            </div>");
	        redirect("/main");
	    } else {
	        $this->session->set_flashdata("alert", "<div class='alert-danger' role='alert'>
	            <strong>Ooops!</strong> Your registration passwords don't match!
	            </div>");
	       redirect("/main");
	    }
	}

	public function login(){
    $username = $this->input->post('username');
	$password = $this->input->post('password');
	$user = $this->Access->check_user_login($username);

		if($user && $user['password'] == $password)
		{
		    $user = array(
		       'user_id' => $user['id'],
		       'realname' => $user['name'],
		       'username' => $user['username'],
		       'loginstatus' => true
		    );
		    $this->session->set_userdata($user);
		    redirect("/travels");
		}
		else
		{
	        $this->session->set_flashdata("alert", "<div class='alert-danger' role='alert'>
	            <strong>Ooops!</strong> We don't have a username and password like that!
	            </div>");
	       redirect("/main");
		}
	}

	public function logout()
	{
	    $this->session->sess_destroy();
	    redirect("/main");
	}
}
