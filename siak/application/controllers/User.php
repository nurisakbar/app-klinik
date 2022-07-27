<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller {
	public function __construct() {
        parent::__construct();
    }   
    
	public function activate($id = 0) {
		if ($id !== 0) {
			$account = $this->settings_model->getAccountByID($id);
			if ($account) {
				$this->activator($account);
			}else{
				$this->session->set_flashdata('error', lang('user_cntrler_activate_account_not_found_error'));
				redirect('user/activate');
			}
		}
		if ($this->settings_model->getAccounts(true)) {
			$this->mDateArray = explode('|', $this->mSettings->date_format);
       		$this->data['accounts'] = $this->settings_model->getAccountsOfLoggedInUser();
			// render page
			$this->render('user/activate');
		}else{
			$this->session->set_flashdata('warning', lang('user_cntrler_activate_no_accounts_found_warning'));
			redirect('admin/create_account');
		}
	}

	public function activator($data)
	{
		$new_config['hostname'] = $data->db_host;
		$new_config['username'] = $data->db_login;
		$new_config['password'] = $data->db_password;
		$new_config['database'] = $data->db_database;
		$new_config['dbdriver'] = $data->db_datasource;
		$new_config['dbprefix'] = strtolower($data->db_prefix);
		$new_config['db_debug'] = TRUE;
		$new_config['cache_on'] = FALSE;
		$new_config['cachedir'] = "";
		$new_config['schema'] 	= $data->db_schema;
		$new_config['port'] 	= $data->db_port;
		$new_config['char_set'] = "utf8";
		$new_config['dbcollat'] = "utf8_general_ci";
		if ($data->db_persistent) {
			$new_config['pconnect'] = TRUE;
		} else {
			$new_config['pconnect'] = FALSE;
		}
		$this->load->database($new_config);
		if (!$this->check_database($new_config)) {
			$this->session->set_flashdata('warning', lang('user_cntrler_activator_db_con_warning'));
			redirect('user/activate');
		}else{
			$this->session->set_userdata('active_account', $data);
			$this->session->set_userdata('active_account_config', $new_config);
			$this->session->set_userdata('active_account_id', $data->id);
			$this->session->set_flashdata('message', lang('user_cntrler_activator_activate_success'));
			redirect('dashboard');
		}

	}

	public function deactivate($id)
	{
		if ($id == $this->mActiveAccountID) {
			$this->session->unset_userdata('active_account');
			$this->session->unset_userdata('active_account_config');
			if ($this->session->userdata('active_account') || $this->session->userdata('active_account_config')) {
				$this->session->set_flashdata('error', lang('user_cntrler_dectivate_error'));
				redirect('user/activate');
			}else{
				$this->session->unset_userdata('active_account_id');
				$this->session->set_flashdata('message', lang('user_cntrler_dectivate_successful'));
				if ($this->ion_auth->is_admin()) {
					redirect('admin');
				}else{
					redirect('user/activate');
				}
			}	
		}
	}
}
