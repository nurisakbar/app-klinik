<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autologin extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
    }   
	
	public function index()
	{
        $credential = $_GET['credential'];
        if($credential =='d392824ebd9b88f9ef36fd63a3a47ad2')
        {
            $email      = "akuntan@gmail.com";
            $password   = "Password123";
            if ($this->ion_auth->login($email, $password))
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				if ($this->ion_auth->is_admin()) {
					redirect('admin');
				}else{
					redirect('user/activate');
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
        }else{
            $this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
        }
    }

    public function test(){
    }
}
