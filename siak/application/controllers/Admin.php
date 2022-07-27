<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {
	public function __construct()
    {
        parent::__construct();
    }   

	public function index() {

		// get all accounts from sqlite db
		$this->data['accounts'] = $this->settings_model->getAccounts();
		// $this->data['accounts'] = $this->settings_model->getAccounts();

		// get date array from sqlite db - table of_settings
		$this->mDateArray = explode('|', $this->mSettings->date_format);

		// render admin/dashboard page
		$this->render('admin/dashboard');
	}

	public function settings()
	{
		
		// set form validation rules
		$this->form_validation->set_rules('sitename', lang('admin_settings_sitename_label'), 'required');
		$this->form_validation->set_rules('date_format' , lang('admin_settings_date_format_label'), 'required');

		// check if form is validated
		if ($this->form_validation->run() == true) {
			// data array for sqlite db - [settings] table
			$data = array(
            	'language'          => $this->input->post('language'),
				'sitename' 			=> $this->input->post('sitename'),
			    'drcr_toby' 		=> $this->input->post('in_entries_use'),
			    'row_count'			=> $this->input->post('rows_per_table'),
			    'email_protocol' 	=> $this->input->post('email_protocol') ? $this->input->post('email_protocol') : 1,
			    'smtp_host' 		=> $this->input->post('smtp_host'),
			    'smtp_port' 		=> $this->input->post('smtp_port'),
			    'smtp_username' 	=> $this->input->post('smtp_username'),
			    'smtp_password' 	=> $this->input->post('smtp_password'),
			    'email_from' 		=> $this->input->post('email_from'),
			    'enable_logging' 	=> 0,
			    'email_verification'=> 0,
			    'smtp_tls' 			=> 0,
			    'date_format' 		=> $this->input->post('date_format'),
			    'entry_form'		=> (int)$this->input->post('entry_form')
	    	);
	    	if ($this->input->post('enable_logging')) {
			   	$data['enable_logging'] = 1;
	    	}
	    	if ($this->input->post('email_verification')) {
			   	$data['email_verification'] = 1;
	    	}
	    	if ($this->input->post('smtp_tls')) {
			   	$data['smtp_tls'] = 1;
	    	}
	    	if ($this->settings_model->updateSettings($data)) {
	    		$this->session->set_flashdata('message', lang('admin_cntrler_update_settings_success'));
	    		redirect('admin/settings');
	    	}else{
	    		$this->session->set_flashdata('error', lang('admin_cntrler_update_settings_error'));
	    		redirect('admin/settings');
	    	}
		} else {
			// render admin/settings page
			$this->render('admin/settings');
		}
	}

	// redirect if needed, otherwise display the user list
	public function users()
	{
		// list of all users and pass to view
		$this->data['users'] = $this->ion_auth->users()->result();

		// check if users exist [i.e. sqlite db - of_users {NOT} empty]
		if ($this->data['users']) {
			// fetch group of each user respectively
			foreach ($this->data['users'] as $k => $user)
			{	
				// set group against each user
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			// render admin/users page
			$this->render('admin/users');
		}else{
			$this->session->set_flashdata('error', lang('admin_controller_no_users_found_error'));
	    	redirect('admin');
		}
		
	}


	public function delete_user($id) {
		if ($id == $_SESSION['user_id']) {
			$this->session->set_flashdata('warning', lang('this_user_is_currently_logged_in'));
	    	redirect('admin/users');
		}

		if ($this->ion_auth->delete_user($id)) {
	    		$this->session->set_flashdata('message', lang('admin_cntrler_delete_user_success'));
	    		redirect('admin/users');
	    	}else{
	    		$this->session->set_flashdata('error', lang('admin_cntrler_delete_user_error'));
	    		redirect('admin/users');
	    	}
	}

	// create a new user
	public function create_user()
    {		
		// list of all groups
		$groups = $this->ion_auth->groups()->result_array();

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column !== 'email')
        {
        	$this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'required|is_unique['.$tables['users'].'.'.$identity_column.']');
        	$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }else{
        	$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.'.$identity_column.']');
        	$this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'required|is_unique['.$tables['users'].'.username]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        if (empty($_FILES['uploadprofilepicture']['name']))
		{
		    $this->form_validation->set_rules('uploadprofilepicture', lang('admin_cntrler_uploadprofilepicture_validation'), 'required');
		}

        if ($this->form_validation->run() == true)
        {
        	$additional_data = array();

            $email    = strtolower($this->input->post('email'));
            $username = strtolower($this->input->post('username'));
            $password = $this->input->post('password');
        	$accounts = ($this->input->post('accounts'));
        	$accounts_json = json_encode($this->input->post('accounts'));
			
			if ($identity_column === 'email') {
	            $identity = $email;
			}
			if($identity_column === 'username'){
				$identity = $username;
			}

			// upload user profile picture
			if (!empty($_FILES['uploadprofilepicture']['name'])) {
				
				$uploadData = '';
				$uploadPath = 'assets/uploads/users/';
			    
			    $extension = substr($_FILES['uploadprofilepicture']['name'], strrpos($_FILES['uploadprofilepicture']['name'], "."));

	            $config['upload_path'] = $uploadPath;
	            $config['allowed_types'] = 'jpg|png';
	            $config['file_name'] = $identity.''.$extension;
	            $config['overwrite'] = TRUE;
	            $this->load->library('upload', $config);
	            $this->upload->initialize($config);

	            if($this->upload->do_upload('uploadprofilepicture')){
	                $fileData = $this->upload->data();
	                $uploadData = $fileData['file_name'];
	            }else{
	            	if ($this->upload->display_errors()) {
	            		$this->session->set_flashdata('error', $this->upload->display_errors());
	            	}else{
		            	$this->session->set_flashdata('error', lang('admin_cntrler_uploadprofilepicture_error'));
	            	}
	            }
			}

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
                'accounts'	 => $accounts_json,
                'all_accounts' => (array_search('all', $accounts) !== FALSE) ? 1 : 0,
				'image' => (empty($uploadData) ? '' : $uploadData)
            );

            if ($identity !== $username) {
            	$additional_data['username'] = $username;
            }
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data,is_numeric($this->input->post('groups')) ? array($this->input->post('groups')) : NULL))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("admin/users", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
			$this->data['groups'] = $groups;
        	$this->data['accounts'] = $this->settings_model->getAccounts();
			
			$this->data['username'] = array(
                'name'  => 'username',
                'id'    => 'username',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
                'class' => 'form-control',
            );
            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
                'class' => 'form-control',
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
                'class' => 'form-control',
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
                'class' => 'form-control',
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
                'class' => 'form-control',
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
                'class' => 'form-control',
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
                'class' => 'form-control',
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
                'class' => 'form-control',
            );

            // render page
			$this->render('admin/create_user');
        }
    }

    public function updateuserimage($userid)
	{
		$data = array('status' => '', 'msg' => '');
		if (empty($_FILES['userimageupdate']['name'])) {
			$data['status'] = 'error';
			$data['msg'] = lang('admin_cntrler_edit_user_update_image_empty');
    		echo(json_encode($data));
		}else {
			$uploadPath = 'assets/uploads/users/';
		    $uploadData = '';
		    $extension = substr($_FILES['userimageupdate']['name'], strrpos($_FILES['userimageupdate']['name'], "."));

            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|png';
            $config['file_name'] = $_SESSION['identity'].''.$extension;
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('userimageupdate')){
                $fileData = $this->upload->data();
                $uploadData = $fileData['file_name'];
                if ($this->db->where('id', $userid)->update('users', array('image' => $uploadData))) {
                	$data['status'] = 'success';
                	$data['msg'] = lang('admin_cntrler_edit_user_update_image_success');
        			echo(json_encode($data));
                }else{
                	$data['status'] = 'error';
                	$data['msg'] = lang('admin_cntrler_edit_user_update_image_error');
        			echo(json_encode($data));
                }
            }else{
            	$data['status'] = 'error';
            	$data['msg'] = $this->upload->display_errors();
        		echo(json_encode($data));
        	}
		}
	}

	// edit a user
	public function edit_user($id)
	{	
		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		$accessibleAccounts = json_decode($user->accounts);

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$accounts = ($this->input->post('accounts'));
        		$accounts_json = json_encode($this->input->post('accounts'));

				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
					'accounts'	 => $accounts_json,
                	'all_accounts' => (array_search('all', $accounts) !== FALSE) ? 1 : 0
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				
				//Update the groups user belongs to
				$groupData = $this->input->post('groups');
				
				if (isset($groupData) && !empty($groupData)) {

					$this->ion_auth->remove_from_group('', $id);

					foreach ($groupData as $grp) {
						$this->ion_auth->add_to_group($grp, $id);
					}

				}

				// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
					redirect('admin/users', 'refresh');
			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('error', $this->ion_auth->errors() );
					redirect('admin/users', 'refresh');

			    }

			}
		}
			
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;
       	$this->data['accounts'] = $this->settings_model->getAccounts();
       	$this->data['accessibleAccounts'] = $accessibleAccounts;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'form-control',

		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'form-control',

		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
            'class' => 'form-control',

		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
            'class' => 'form-control',

		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
            'class' => 'form-control',

		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
            'class' => 'form-control',

		);

		// render page
		$this->render('admin/edit_user');
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		$id = (int) $id;
		if ($this->ion_auth->deactivate($id)) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
		}else{
			$this->session->set_flashdata('error', $this->ion_auth->errors());
		}
		// redirect them back to the users page
		redirect('admin/users', 'refresh');
	}
	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("admin/users", 'refresh');
		} else {
			// redirect them to the login page
			$this->session->set_flashdata('error', $this->ion_auth->errors());
			redirect("login", 'refresh');
		}
	}


	public function accounts()
	{
		$this->data['accounts'] = $this->settings_model->getAccounts();
		// render page
		$this->render('admin/accounts');		
	}

	public function create_account()
	{
		$this->form_validation->set_rules('label', lang('admin_cntrler_create_account_validation_label') , 'required|is_unique[accounts.label]|alpha_numeric|max_length[255]');
		$this->form_validation->set_rules('name', lang('admin_cntrler_create_account_validation_name') , 'required');
		$this->form_validation->set_rules('address', lang('admin_cntrler_create_account_validation_address') , 'required');
		$this->form_validation->set_rules('email', lang('admin_cntrler_create_account_validation_email') , 'required');
		$this->form_validation->set_rules('currency', lang('admin_cntrler_create_account_validation_currency') , 'required');
		$this->form_validation->set_rules('currency_format', lang('admin_cntrler_create_account_validation_currency_format') , 'required');
		$this->form_validation->set_rules('decimal_place', lang('admin_cntrler_create_account_validation_decimal_place') , 'required');
		$this->form_validation->set_rules('date_format', lang('admin_cntrler_create_account_validation_date_format') , 'required');
		$this->form_validation->set_rules('fiscal_start', lang('admin_cntrler_create_account_validation_fiscal_start') , 'required');
		$this->form_validation->set_rules('fiscal_end', lang('admin_cntrler_create_account_validation_fiscal_end') , 'required');
		$this->form_validation->set_rules('db_type', lang('admin_cntrler_create_account_validation_db_type') , 'required|in_list[mysqli]');
		$this->form_validation->set_rules('db_name', lang('admin_cntrler_create_account_validation_db_name') , 'required|max_length[255]');
		$this->form_validation->set_rules('db_host', lang('admin_cntrler_create_account_validation_db_host') , 'required|max_length[255]');
		$this->form_validation->set_rules('db_port', lang('admin_cntrler_create_account_validation_db_port') , 'required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('db_username', lang('admin_cntrler_create_account_validation_db_username') , 'required|max_length[255]');
		$this->form_validation->set_rules('db_password', lang('admin_cntrler_create_account_validation_db_password') , 'max_length[255]');

		if ($this->form_validation->run() == TRUE) {

			/* Check financial year start is before end */
			// $fy_start = strtotime($this->input->post('fiscal_start') . ' 00:00:00');
			// $fy_end = strtotime($this->input->post('fiscal_end') . ' 00:00:00');
			// if ($fy_start >= $fy_end) {
			// 	$this->form_validation->set_rules('fiscal_start', 'Financial year start date cannot be after end date.', 'required');
			// 	return;
			// }
			// /* Check email */
			// if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			// 	$this->form_validation->set_rules('email', 'Email address is invalid.', 'required');
			// 	return;
			// }
			// /* Check for valid decimal places */
			// if (!($this->input->post('decimal_place') == 2 || $this->input->post('decimal_place') == 3)) {
			// 	$this->form_validation->set_rules('decimal_place', 'Decimal places can only be 2 or 3.', 'required');
			// }
			

			$new_config['hostname'] = $this->input->post('db_host');
			$new_config['username'] = $this->input->post('db_username');
			$new_config['password'] = $this->input->post('db_password');
			$new_config['database'] = $this->input->post('db_name');
			$new_config['dbdriver'] = $this->input->post('db_type');
			$new_config['dbprefix'] = strtolower($this->input->post('db_prefix'));
			$new_config['db_debug'] = TRUE;
			$new_config['cache_on'] = FALSE;
			$new_config['cachedir'] = "";
			$new_config['schema'] 	= $this->input->post('db_schema');
			$new_config['port'] 	= $this->input->post('db_port');
			$new_config['char_set'] = "utf8";
			$new_config['dbcollat'] = "utf8_general_ci";
			if ($this->input->post('persistent')) {
				$new_config['pconnect'] = TRUE;
			} else {
				$new_config['pconnect'] = FALSE;
			}
			if (!$this->check_database($new_config)) {
				$this->session->set_userdata('post_data', $_POST);
				$this->session->set_flashdata('warning', lang('admin_cntrler_check_db_warning'));
				redirect('admin/create_account');
			}
			$DB1 = $this->load->database($new_config, TRUE);
			$existing_tables = $DB1->list_tables();
			$new_tables = array(
				$new_config['dbprefix'] . 'entries',
				$new_config['dbprefix'] . 'entryitems',
				$new_config['dbprefix'] . 'entrytypes',
				$new_config['dbprefix'] . 'groups',
				$new_config['dbprefix'] . 'ledgers',
				$new_config['dbprefix'] . 'logs',
				$new_config['dbprefix'] . 'settings',
				$new_config['dbprefix'] . 'tags',
			);
			/* Check if any table from $new_table already exists */
			$table_exisits = false;
			foreach ($existing_tables as $row => $table) {
				if (in_array(strtolower($table), $new_tables)) {
					$table_exisits = TRUE;
				}
			}
			if ($table_exisits == TRUE) {
				$this->session->set_userdata('post_data', $_POST);
				$this->session->set_flashdata('warning', sprintf(lang('admin_cntrler_database_already_exist_warning'), $table, $new_config['database']));
				redirect('admin/create_account');
			}
 			

 		// 	$schema = file_get_contents(APPPATH.'config/Functions.Mysql.sql');
			// $schema = str_replace('%_PREFIX_%', $new_config['dbprefix'], $schema);
			// write_file(APPPATH.'config/Function_.Mysql.sql', $schema);
			// $path = APPPATH.'config/Function_.Mysql.sql';
	        
	        // proceed to execute SQL queries
	        if ( !empty($path) && file_exists($path) ) {
	        	$username = $new_config['username'];
	        	$password = $new_config['password'];
	        	$database = $new_config['database'];
	            exec("mysql -u $username -p$password --default-character-set=utf8 --database $database < $path");
	        }

			$schema = file_get_contents(APPPATH.'config/Schema.Mysql.sql');
			/* Add prefix to the table names in the schema */
			$prefix_schema = str_replace('%_PREFIX_%', $new_config['dbprefix'], $schema);

			/* Add decimal places */
			$final_schema = str_replace('%_DECIMAL_%', $this->input->post('decimal_place'), $prefix_schema);
			$sqls = explode(';', $final_schema);
			array_pop($sqls);

			foreach($sqls as $statement){
				$statment = $statement . ";";
				$DB1->query($statement);	
			}
			
			$schema = file_get_contents(APPPATH.'config/InitialData.Mysql.sql');
			$schema = str_replace('%_PREFIX_%', $new_config['dbprefix'], $schema);
			$sqls = explode(';', $schema);
			array_pop($sqls);

			foreach($sqls as $statement){
				$statment = $statement . ";";
				$DB1->query($statement);	
			}


			$uploadData = '';
            $uploadPath = 'assets/uploads/companies/';
		    
		    $extension = substr($_FILES['companylogoUpload']['name'], strrpos($_FILES['companylogoUpload']['name'], "."));

            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|png';
            $config['file_name'] = $this->input->post('label').$extension;
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('companylogoUpload')){
                $fileData = $this->upload->data();
                $uploadData = $fileData['file_name'];
            }else{
            	$this->session->set_flashdata('error', lang('admin_controller_create_account_image_not_uploaded_error'));
            }
			$account_setting = array(
				'id' => '1',
				'name' => $this->input->post('name'),
				'address' => $this->input->post('address'),
				'email' => $this->input->post('email'),
				'fy_start' => date('Y-m-d', strtotime($this->input->post('fiscal_start'))),
				'fy_end' => date('Y-m-d', strtotime($this->input->post('fiscal_end'))),
				'currency_symbol' => $this->input->post('currency'),
				'currency_format' => $this->input->post('currency_format'),
				'decimal_places' => $this->input->post('decimal_place'),
				'date_format' => $this->input->post('date_format'),
				'timezone' => 'UTC',
				'manage_inventory' => 0,
				'account_locked' => 0,
				'email_use_default' => 1,
				'email_protocol' => 'smtp',
				'email_host' => '',
				'email_port' => 0,
				'email_tls' => 0,
				'email_username' => '',
				'email_password' => '',
				'email_from' => '',
				'print_paper_height' => 0.0,
				'print_paper_width' => 0.0,
				'print_margin_top' => 0.0,
				'print_margin_bottom' => 0.0,
				'print_margin_left' => 0.0,
				'print_margin_right' => 0.0,
				'print_orientation' => 'P',
				'print_page_format' => 'H',
				'settings' => NULL,
				'logo' => $uploadData
			);
			$DB1->insert('settings', $account_setting);
			
			/* Only check for valid input data, save later */
			$insert_data = array(
				'label' 			=> $this->input->post('label'),
				'name' 				=> $this->input->post('name'),
				'fy_start' 			=> date('Y-m-d', strtotime($this->input->post('fiscal_start'))),
				'fy_end' 			=> date('Y-m-d', strtotime($this->input->post('fiscal_end'))),
				'db_datasource' 	=> $this->input->post('db_type'),
				'db_database'		=> $this->input->post('db_name'),
				'db_host' 			=> $this->input->post('db_host'),
				'db_port' 			=> $this->input->post('db_port'),
				'db_login' 			=> $this->input->post('db_username'),
				'db_password' 		=> $this->input->post('db_password'),
				'db_prefix' 		=> strtolower($this->input->post('db_prefix')),
				'db_schema' 		=> $this->input->post('db_schema'),
				'db_unixsocket' 	=> '',
				'account_locked' 	=> 0
			);
			if ($this->input->post('persistent')) {
				$insert_data['db_persistent'] = 1;
			} else {
				$insert_data['db_persistent'] = 0;
			}

			$this->db->insert('accounts', $insert_data);
 			$this->session->unset_userdata('post_data');

			$this->session->set_flashdata('message' , lang('admin_cntrler_account_created_successfully'));
			redirect('admin/accounts');

		} else {
			$this->data['label'] = array(
				'name'  => 'label',
				'id'    => 'label',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('label', $this->session->userdata('post_data')['label']),
				'class' => 'form-control',
			);
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('name', $this->session->userdata('post_data')['name']),
				'class' => 'form-control',
			);
			$this->data['address'] = array(
				'name'  => 'address',
				'id'    => 'address',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('address', $this->session->userdata('post_data')['address']),
				'class' => 'form-control',
			);
			$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'value' => $this->form_validation->set_value('email', $this->session->userdata('post_data')['email']),
				'class' => 'form-control',
			);
			$this->data['currency'] = array(
				'name'  => 'currency',
				'id'    => 'currency',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('currency', $this->session->userdata('post_data')['currency']),
				'class' => 'form-control',
			);
			$this->data['decimal_place'] = array(
				'name'  => 'decimal_place',
				'id'    => 'decimal_place',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('decimal_place', $this->session->userdata('post_data')['decimal_place']),
				'class' => 'form-control',
			);
			$this->data['fiscal_start'] = array(
				'name'  => 'fiscal_start',
				'id'    => 'fiscal_start',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('fiscal_start', $this->session->userdata('post_data')['fiscal_start']),
				'class' => 'form-control',
			);
			$this->data['fiscal_end'] = array(
				'name'  => 'fiscal_end',
				'id'    => 'fiscal_end',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('fiscal_end', $this->session->userdata('post_data')['fiscal_end']),
				'class' => 'form-control',
			);
			$this->data['db_name'] = array(
				'name'  => 'db_name',
				'id'    => 'db_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_name', $this->session->userdata('post_data')['db_name']),
				'class' => 'form-control',
			);
			// $this->data['db_schema'] = array(
			// 	'name'  => 'db_schema',
			// 	'id'    => 'db_schema',
			// 	'type'  => 'text',
			// 	'value' => $this->form_validation->set_value('db_schema', $this->session->userdata('post_data')['db_schema']),
			// 	'class' => 'form-control',
			// );
			$this->data['db_host'] = array(
				'name'  => 'db_host',
				'id'    => 'db_host',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_host', $this->session->userdata('post_data')['db_host']),
				'class' => 'form-control',
			);
			$this->data['db_port'] = array(
				'name'  => 'db_port',
				'id'    => 'db_port',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_port', $this->session->userdata('post_data')['db_port']),
				'class' => 'form-control',
				'placeholder' => '3306'
			);
			$this->data['db_username'] = array(
				'name'  => 'db_username',
				'id'    => 'db_username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_username', $this->session->userdata('post_data')['db_username']),
				'class' => 'form-control',
			);
			$this->data['db_password'] = array(
				'name'  => 'db_password',
				'id'    => 'db_password',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_password', $this->session->userdata('post_data')['db_password']),
				'class' => 'form-control',
			);
			$this->data['db_prefix'] = array(
				'name'  => 'db_prefix',
				'id'    => 'db_prefix',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_prefix', $this->session->userdata('post_data')['db_prefix']),
				'class' => 'form-control',
			);
			// render page
		$this->render('admin/create_account');
		}
	}

	public function edit_permission($id)
	{
		// set page title
		// $this->mPageTitle = lang('page_title_admin_edit_group_permission');

		$this->form_validation->set_rules('group_id', lang('admin_cntrler_edit_permission_validation_group_id'), 'required');
		$this->form_validation->set_rules('accounts-index', lang('admin_cntrler_edit_permission_validation_account_index'), 'required');
		$this->form_validation->set_rules('admin-log', lang('admin_cntrler_edit_permission_validation_admin_log'), 'required');
		$this->form_validation->set_rules('dashboard-index', lang('admin_cntrler_edit_permission_validation_dashboard_index'), 'required');
		$this->form_validation->set_rules('entries-index', lang('admin_cntrler_edit_permission_validation_entries_view'), 'required');
		$this->form_validation->set_rules('entries-add', lang('admin_cntrler_edit_permission_validation_entries_add'), 'required');
		$this->form_validation->set_rules('entries-edit', lang('admin_cntrler_edit_permission_validation_entries_edit'), 'required');
		$this->form_validation->set_rules('entries-delete', lang('admin_cntrler_edit_permission_validation_entries_delete'), 'required');
		$this->form_validation->set_rules('entries-view', lang('admin_cntrler_edit_permission_validation_entries_view_single'), 'required');
		$this->form_validation->set_rules('search-index', lang('admin_cntrler_edit_permission_validation_search_index'), 'required');
		$this->form_validation->set_rules('groups-add', lang('admin_cntrler_edit_permission_validation_groups_add'), 'required');
		$this->form_validation->set_rules('groups-edit', lang('admin_cntrler_edit_permission_validation_groups_edit'), 'required');
		$this->form_validation->set_rules('groups-delete', lang('admin_cntrler_edit_permission_validation_groups_delete'), 'required');
		$this->form_validation->set_rules('ledgers-add', lang('admin_cntrler_edit_permission_validation_ledgers_add'), 'required');
		$this->form_validation->set_rules('ledgers-edit', lang('admin_cntrler_edit_permission_validation_ledgers_edit'), 'required');
		$this->form_validation->set_rules('ledgers-delete', lang('admin_cntrler_edit_permission_validation_ledgers_delete'), 'required');
		$this->form_validation->set_rules('account_settings-index', lang('admin_cntrler_edit_permission_validation_account_settings_index'), 'required');
		$this->form_validation->set_rules('account_settings-main', lang('admin_cntrler_edit_permission_validation_account_settings_'), 'required');
		$this->form_validation->set_rules('account_settings-cf', lang('admin_cntrler_edit_permission_validation_account_settings_cf'), 'required');
		$this->form_validation->set_rules('account_settings-email', lang('admin_cntrler_edit_permission_validation_account_settings_email'), 'required');
		$this->form_validation->set_rules('account_settings-printer', lang('admin_cntrler_edit_permission_validation_account_settings_printer'), 'required');
		$this->form_validation->set_rules('account_settings-tags', lang('admin_cntrler_edit_permission_validation_account_settings_tags'), 'required');
		$this->form_validation->set_rules('account_settings-entrytypes', lang('admin_cntrler_edit_permission_validation_account_settings_entrytypes'), 'required');
		$this->form_validation->set_rules('account_settings-lock', lang('admin_cntrler_edit_permission_validation_account_settings_lock_account'), 'required');
		$this->form_validation->set_rules('reports-index', lang('admin_cntrler_edit_permission_validation_reports_index'), 'required');
		$this->form_validation->set_rules('reports-balancesheet', lang('admin_cntrler_edit_permission_validation_reports_balancesheet'), 'required');
		$this->form_validation->set_rules('reports-profitloss', lang('admin_cntrler_edit_permission_validation_reports_profit_loss'), 'required');
		$this->form_validation->set_rules('reports-trialbalance', lang('admin_cntrler_edit_permission_validation_reports_trialbalance'), 'required');
		$this->form_validation->set_rules('reports-ledgerstatement', lang('admin_cntrler_edit_permission_validation_reports_ledgerstatement'), 'required');
		$this->form_validation->set_rules('reports-ledgerentries', lang('admin_cntrler_edit_permission_validation_reports_ledgerentries'), 'required');
		$this->form_validation->set_rules('reports-reconciliation', lang('admin_cntrler_edit_permission_validation_reports_reconciliation'), 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->data['group_id'] = $id;
			$this->data['permission'] = $this->db->get_where('permissions', array('group_id' => $id), 1)->row_array();
			// render page
			$this->render('admin/edit_permission');
		}else{
			$data = array(
				'accounts-index' => $this->input->post('accounts-index'),
				'dashboard-index' => $this->input->post('dashboard-index'),
				'entries-index' => $this->input->post('entries-index'),
				'entries-add' => $this->input->post('entries-add'),
				'entries-edit' => $this->input->post('entries-edit'),
				'entries-delete' => $this->input->post('entries-delete'),
				'entries-view' => $this->input->post('entries-view'),
				'search-index' => $this->input->post('search-index'),
				'groups-add' => $this->input->post('groups-add'),
				'groups-edit' => $this->input->post('groups-edit'),
				'groups-delete' => $this->input->post('groups-delete'),
				'ledgers-add' => $this->input->post('ledgers-add'),
				'ledgers-edit' => $this->input->post('ledgers-edit'),
				'ledgers-delete' => $this->input->post('ledgers-delete'),
				'account_settings-index' => $this->input->post('account_settings-index'),
				'account_settings-main' => $this->input->post('account_settings-main'),
				'account_settings-cf' => $this->input->post('account_settings-cf'),
				'account_settings-email' => $this->input->post('account_settings-email'),
				'account_settings-printer' => $this->input->post('account_settings-printer'),
				'account_settings-tags' => $this->input->post('account_settings-tags'),
				'account_settings-entrytypes' => $this->input->post('account_settings-entrytypes'),
				'account_settings-lock' => $this->input->post('account_settings-lock'),
				'reports-index' => $this->input->post('reports-index'),
				'reports-balancesheet' => $this->input->post('reports-balancesheet'),
				'reports-profitloss' => $this->input->post('reports-profitloss'),
				'reports-trialbalance' => $this->input->post('reports-trialbalance'),
				'reports-ledgerstatement' => $this->input->post('reports-ledgerstatement'),
				'reports-ledgerentries' => $this->input->post('reports-ledgerentries'),
				'reports-reconciliation' => $this->input->post('reports-reconciliation'),
				'admin-log' => $this->input->post('admin-log')
			);
			
			$this->db->where('group_id', $this->input->post('group_id'));
			$this->db->update('permissions', $data);
			$this->session->set_flashdata('message' , lang('admin_cntrler_permission_updated_successfully'));
			redirect('admin/groups');
		}
		
	}

	public function groups()
	{

		$this->data['permissions'] = $this->db->select('permissions.id, groups.description, groups.id as gp_id')->from('permissions')->join('groups', 'groups.id = permissions.group_id', 'left')->get()->result();

		// render page
		$this->render('admin/user_permissions');
	}
	
	// create a new group
	public function create_group()
	{

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->db->insert('permissions', array('group_id' => $new_group_id));
				$this->session->set_flashdata('message', $this->ion_auth->messages().sprintf(lang('admin_cntrler_create_group_success'), $this->input->post('description')));
				redirect("admin/edit_permission/$new_group_id", 'refresh');
			}else{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
				redirect("admin/groups", 'refresh');
			}
		}
		else
		{
			// display the create group form
			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
				'class' => 'form-control',
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
				'class' => 'form-control',
			);

			// render page
		$this->render('admin/create_group');
		}
	}

	// edit a group
	public function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			$this->session->set_flashdata('error', lang('admin_cntrler_edit_group_id_empty_error'));
			redirect('admin/groups');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() === TRUE)
		{
			$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

			if($group_update)
			{
				$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
			}
			else
			{
				$this->session->set_flashdata('error', $this->ion_auth->errors());
			}
			redirect("admin/groups");
		}else{
			// pass the user to the view
			$this->data['group'] = $group;

			$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

			$this->data['group_name'] = array(
				'name'    => 'group_name',
				'id'      => 'group_name',
				'type'    => 'text',
				'value'   => $this->form_validation->set_value('group_name', $group->name),
				$readonly => $readonly,
				'class' => 'form-control'
			);
			$this->data['group_description'] = array(
				'name'  => 'group_description',
				'id'    => 'group_description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_description', $group->description),
				'class' => 'form-control'
			);

			// render page
		$this->render('admin/edit_group');
		}
	}

	public function delete_group($id)
	{

		if ($this->ion_auth->delete_group($id)) {
    		$this->session->set_flashdata('message', $this->ion_auth->messages());
    		redirect('admin/groups');
    	}else{
    		$this->session->set_flashdata('error', $this->ion_auth->errors());
    		redirect('admin/groups');
    	}
	}

}
