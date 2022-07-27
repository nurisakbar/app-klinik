<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_settings extends Admin_Controller {
	public function __construct() {
        parent::__construct();
    }   

	public function main() {
		$this->form_validation->set_rules('name', lang('account_settings_cntrler_main_form_validation_label_name'), 'required');
		$this->form_validation->set_rules('address', lang('account_settings_cntrler_main_form_validation_label_address'), 'required');
		$this->form_validation->set_rules('email', lang('account_settings_cntrler_main_form_validation_label_email'), 'required');
		$this->form_validation->set_rules('currency_symbol', lang('account_settings_cntrler_main_form_validation_label_cur_symbol'), 'required');
		$this->form_validation->set_rules('currency_format', lang('account_settings_cntrler_main_form_validation_label_cur_format'), 'required');
		$this->form_validation->set_rules('fy_start', lang('account_settings_cntrler_main_form_validation_label_fy_start'), 'required');
		$this->form_validation->set_rules('fy_end', lang('account_settings_cntrler_main_form_validation_label_fy_end'), 'required');
		$this->form_validation->set_rules('date_format', lang('account_settings_cntrler_main_form_validation_label_date_format'), 'required');


		if ($this->input->method() == 'post'){
			// 8 May 2016
			$this->DB1->where('entries.date <', $this->functionscore->dateToSql($this->input->post('fy_start'))); // 9 May 2016
			$this->DB1->or_where('entries.date >', $this->functionscore->dateToSql($this->input->post('fy_end')));
		
			$q = $this->DB1->get('entries');
			if ($q->num_rows() != 0) {
				$this->session->set_flashdata('error', sprintf(lang('account_settings_cntrler_main_failed_update_entries_beyond_fy_dates_error'), $q->num_rows()));
				redirect('account_settings/main');
			}
			/* Periksa apakah akhir tahun keuangan setelah tahun keuangan dimulai */
			$start_date = strtotime($this->input->post('fy_start') . ' 00:00:00');
			$end_date = strtotime($this->input->post('fy_end') . ' 00:00:00');
			if ($start_date >= $end_date) {
				$this->session->set_flashdata('error', 'Failed to update account setting since financial year end should be after financial year start.');
				redirect('account_settings/main');
			}
		}


		if ($this->form_validation->run() == FALSE) {
			// render page
			$this->render('settings/main');
		}else{
			/* Periksa apakah akun terkunci */
			if ($this->mAccountSettings->account_locked == 1) {
				$this->session->set_flashdata('warning', lang('account_settings_cntrler_main_account_locked_warning'));
				redirect('account_settings/main');
			}

			$data = array(
				'name' 				=> $this->input->post('name'),
				'address' 			=> $this->input->post('address'),
				'email' 			=> $this->input->post('email'),
				'currency_symbol' 	=> $this->input->post('currency_symbol'),
				'currency_format' 	=> $this->input->post('currency_format'),
				'fy_start' 			=> $this->functionscore->dateToSql($this->input->post('fy_start')),
				'fy_end' 			=> $this->functionscore->dateToSql($this->input->post('fy_end')),
				'date_format' 		=> $this->input->post('date_format'),
			);
			$this->DB1->update('settings', $data);
			$this->session->set_flashdata('message', lang('account_settings_cntrler_main_update_success'));
			redirect('account_settings/main');
		}
		
	}

	public function updateLogo($label) {
		$data = array('status' => '', 'msg' => '');
		if (empty($_FILES['companylogoupdate']['name'])) {
			$data['status'] = 'error';
			$data['msg'] = lang('account_settings_cntrler_updateLogo_file_not_selected_warning');
    		echo(json_encode($data));
		}else {
			$uploadPath = 'assets/uploads/companies/';
		    $uploadData = '';
		    $extension = substr($_FILES['companylogoupdate']['name'], strrpos($_FILES['companylogoupdate']['name'], "."));

            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|png';
            $config['file_name'] = $label.$extension;
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if($this->upload->do_upload('companylogoupdate')){
                $fileData = $this->upload->data();
                $uploadData = $fileData['file_name'];
                $updatedata = array(
					'logo' => (!empty($uploadData) ? $uploadData : '')
				);
                if ($this->DB1->update('settings', $updatedata)) {
                	$data['status'] = 'success';
                	$data['msg'] = lang('account_settings_cntrler_updateLogo_update_success');
        			echo(json_encode($data));
                }else{
                	$data['status'] = 'error';
                	$data['msg'] = lang('account_settings_cntrler_updateLogo_update_error');
        			echo(json_encode($data));
                }
            }else{
            	$data['status'] = 'error';
            	$data['msg'] = $this->upload->display_errors();
        		echo(json_encode($data));
        	}
		}
	}

	/**
	* carry forward to next financial year method
	*
	* @return void
	*/
	public function cf() {

		$this->form_validation->set_rules('label', lang('account_settings_cntrler_cf_form_validation_label_label'), 'required|is_unique[accounts.label]|alpha_numeric|max_length[255]');
		$this->form_validation->set_rules('name', lang('account_settings_cntrler_cf_form_validation_label_name'), 'required');
		$this->form_validation->set_rules('date_format', lang('account_settings_cntrler_cf_form_validation_label_date_format'), 'required');
		$this->form_validation->set_rules('fiscal_start', lang('account_settings_cntrler_cf_form_validation_label_fiscal_start'), 'required');
		$this->form_validation->set_rules('fiscal_end', lang('account_settings_cntrler_cf_form_validation_label_fiscal_end'), 'required');
		$this->form_validation->set_rules('db_type', lang('account_settings_cntrler_cf_form_validation_label_db_type'), 'required|in_list[mysqli]');
		$this->form_validation->set_rules('db_name', lang('account_settings_cntrler_cf_form_validation_label_db_name'), 'required|max_length[255]');
		$this->form_validation->set_rules('db_host', lang('account_settings_cntrler_cf_form_validation_label_db_host'), 'required|max_length[255]');
		$this->form_validation->set_rules('db_port', lang('account_settings_cntrler_cf_form_validation_label_db_port'), 'required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('db_username', lang('account_settings_cntrler_cf_form_validation_label_db_username'), 'required|max_length[255]');

		/* Check financial year start is before end 
		$fy_start 	= strtotime($this->input->post('fy_start') . ' 00:00:00');
		$fy_end 	= strtotime($this->input->post('fy_end') . ' 00:00:00');
		if ($fy_start >= $fy_end) {
			$this->form_validation->set_rules('custom', '', 'required', array('required' => lang('account_settings_cntrler_cf_form_validation_error_custom')));
		}*/
		if($this->input->method() == 'post'){
			$new_config['hostname'] = $this->input->post('db_host');
			$new_config['username'] = $this->input->post('db_username');
			$new_config['password'] = $this->input->post('db_password');
			$new_config['database'] = $this->input->post('db_name');
			$new_config['dbdriver'] = $this->input->post('db_type');
			$new_config['dbprefix'] = strtolower($this->input->post('db_prefix'));
			$new_config['db_debug'] = TRUE;
			$new_config['cache_on'] = FALSE;
			$new_config['cachedir'] = "";
			$new_config['schema'] 	 = $this->input->post('db_schema');
			$new_config['port'] 	 = $this->input->post('db_port');
			$new_config['char_set'] = "utf8";
			$new_config['dbcollat'] = "utf8_general_ci";
			if ($this->input->post('persistent')) {
				$new_config['pconnect'] = TRUE;
			} else {
				$new_config['pconnect'] = FALSE;
			}
			if (!$this->check_database($new_config)) {
				$this->form_validation->set_rules('custom1', '', 'required', array('required' => lang('account_settings_cntrler_cf_form_validation_error_custom1')));
			}

			$DB2 = $this->load->database($new_config, TRUE);
			$existing_tables = $DB2->list_tables();
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
					$this->form_validation->set_rules('custom'.$row, '', 'required', array('required' => sprintf(lang('account_settings_cntrler_cf_form_validation_error_custom2'), $table, $new_config['database'])));
				}
			}
		}

		if ($this->form_validation->run() == FALSE) {
			$this->data['label'] = array(
				'name'  => 'label',
				'id'    => 'label',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('label'),
				'class' => 'form-control',
			);
			$this->data['name'] = array(
				'name'  => 'name',
				'id'    => 'name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('name'),
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
				'value' => $this->form_validation->set_value('db_name'),
				'class' => 'form-control',
			);
			$this->data['db_schema'] = array(
				'name'  => 'db_schema',
				'id'    => 'db_schema',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_schema'),
				'class' => 'form-control',
			);
			$this->data['db_host'] = array(
				'name'  => 'db_host',
				'id'    => 'db_host',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_host'),
				'class' => 'form-control',
			);
			$this->data['db_port'] = array(
				'name'  => 'db_port',
				'id'    => 'db_port',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_port'),
				'class' => 'form-control',
			);
			$this->data['db_username'] = array(
				'name'  => 'db_username',
				'id'    => 'db_username',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_username'),
				'class' => 'form-control',
			);
			$this->data['db_password'] = array(
				'name'  => 'db_password',
				'id'    => 'db_password',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('db_password'),
				'class' => 'form-control',
			);
			$this->data['db_prefix'] = array(
				'name'  => 'db_prefix',
				'id'    => 'db_prefix',
				'type'  => 'text',
				'value' => set_value('db_prefix'),
				'class' => 'form-control',
			);
			// render page
			$this->render('settings/cf');
		}else{
			
			/* Read old settings */
			$old_account_setting = json_decode(json_encode($this->mAccountSettings), true);

			$schema = file_get_contents(APPPATH.'config/Schema.Mysql.sql');
			/* Add prefix to the table names in the schema */
			$prefix_schema = str_replace('%_PREFIX_%', $new_config['dbprefix'], $schema);

			/* Add decimal places */
			$final_schema = str_replace('%_DECIMAL_%', $old_account_setting['decimal_places'], $prefix_schema);
			$sqls = explode(';', $final_schema);
			array_pop($sqls);

			foreach($sqls as $statement){
				$statment = $statement . ";";
				$DB2->query($statement);	
			}

			/******* Add initial data ********/

			$this->load->library('AccountList');
			/* CF groups and ledgers */
			$assetsList = new AccountList();
			$assetsList->Group = &$this->Group;
			$assetsList->Ledger = &$this->Ledger;
			$assetsList->only_opening = false;
			$assetsList->start_date = null;
			$assetsList->end_date = null;
			$assetsList->affects_gross = -1;
			$assetsList->start(1);

			$this->_extract_groups_ledgers($assetsList, true);

			$liabilitiesList = new AccountList();
			$liabilitiesList->Group = &$this->Group;
			$liabilitiesList->Ledger = &$this->Ledger;
			$liabilitiesList->only_opening = false;
			$liabilitiesList->start_date = null;
			$liabilitiesList->end_date = null;
			$liabilitiesList->affects_gross = -1;
			$liabilitiesList->start(2);

			$this->_extract_groups_ledgers($liabilitiesList, true);

			$incomesList = new AccountList();
			$incomesList->Group = &$this->Group;
			$incomesList->Ledger = &$this->Ledger;
			$incomesList->only_opening = false;
			$incomesList->start_date = null;
			$incomesList->end_date = null;
			$incomesList->affects_gross = -1;
			$incomesList->start(3);

			$this->_extract_groups_ledgers($incomesList, false);

			$expenseList = new AccountList();
			$expenseList->Group = &$this->Group;
			$expenseList->Ledger = &$this->Ledger;
			$expenseList->only_opening = false;
			$expenseList->start_date = null;
			$expenseList->end_date = null;
			$expenseList->affects_gross = -1;
			$expenseList->start(4);

			$this->_extract_groups_ledgers($expenseList, false);

			foreach ($this->groups_list as $row => $group) {
				$DB2->insert('groups', $group);
			}
			foreach ($this->ledgers_list as $row => $ledger) {
				$DB2->insert('ledgers', $ledger);
			}

			/* CF Entrytypes */
			$q = $this->DB1->get('entrytypes')->result_array();
			foreach ($q as $row => $ledger) {
				$DB2->insert('entrytypes', $ledger);
			}

			/* CF Tags */
			$q = $this->DB1->get('tags')->result_array();
			foreach ($q as $row => $ledger) {
				$DB2->insert('tags', $ledger);
			}

			$new_account_setting = array(
				'id' => '1',
				'name' => $this->input->post('name'),
				'address' => $old_account_setting['address'],
				'email' => $old_account_setting['email'],
				'fy_start' => date('Y-m-d', strtotime($this->input->post('fiscal_start'))),
				'fy_end' => date('Y-m-d', strtotime($this->input->post('fiscal_end'))),
				'currency_symbol' => $old_account_setting['currency_symbol'],
				'currency_format' => $old_account_setting['currency_format'],
				'decimal_places' => $old_account_setting['decimal_places'],
				'date_format' => $this->input->post('date_format'),
				'timezone' => 'UTC',
				'manage_inventory' => 0,
				'account_locked' => 0,
				'email_use_default' => $old_account_setting['email_use_default'],
				'email_protocol' => $old_account_setting['email_protocol'],
				'email_host' => $old_account_setting['email_host'],
				'email_port' => $old_account_setting['email_port'],
				'email_tls' => $old_account_setting['email_tls'],
				'email_username' => $old_account_setting['email_username'],
				'email_password' => $old_account_setting['email_password'],
				'email_from' => $old_account_setting['email_from'],
				'print_paper_height' => $old_account_setting['print_paper_height'],
				'print_paper_width' => $old_account_setting['print_paper_width'],
				'print_margin_top' => $old_account_setting['print_margin_top'],
				'print_margin_bottom' => $old_account_setting['print_margin_bottom'],
				'print_margin_left' => $old_account_setting['print_margin_left'],
				'print_margin_right' => $old_account_setting['print_margin_right'],
				'print_orientation' => $old_account_setting['print_orientation'],
				'print_page_format' => $old_account_setting['print_page_format'],
				'database_version' => $old_account_setting['database_version'],
				'settings' => $old_account_setting['settings'],
				'logo' => $old_account_setting['logo']
			);

			$DB2->insert('settings', $new_account_setting);

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

			$this->session->set_flashdata('message', lang('account_settings_cntrler_cf_success'));
			redirect('admin/accounts');

		}
	}

	var $groups_list = array();
	var $ledgers_list = array();

	/**
	 * Extract the list of groups and ledgers from AccountList object
	 * and update the global variables $group_list and $ledger_list
	 */
	public function _extract_groups_ledgers($accountlist, $calculate_closing)
	{
		if ($accountlist->id != NULL) {
			$group_item = array(
				'id' => $accountlist->id,
				'parent_id' => $accountlist->g_parent_id,
				'name' => $accountlist->name,
				'code' => $accountlist->code,
				'affects_gross' => $accountlist->g_affects_gross,
			);
			array_push($this->groups_list, $group_item);
		}
		foreach ($accountlist->children_ledgers as $row => $data)
		{
			$ledger_item = array(
				'id' => $data['id'],
				'group_id' => $data['l_group_id'],
				'name' => $data['name'],
				'code' => $data['code'],
				'type' => $data['l_type'],
				'reconciliation' => $data['l_reconciliation'],
				'notes' => $data['l_notes'],
			);
			if ($calculate_closing) {
				$ledger_item['op_balance'] = $data['cl_total'];
				$ledger_item['op_balance_dc'] = $data['cl_total_dc'];
			} else {
				$ledger_item['op_balance'] = '0.00';
				$ledger_item['op_balance_dc'] = 'D';
			}
			array_push($this->ledgers_list, $ledger_item);
		}
		foreach ($accountlist->children_groups as $row => $data)
		{
			$this->_extract_groups_ledgers($data, $calculate_closing);
		}
	}
	public function email() {

		if (!$this->input->post('email_use_default')) {
			$this->form_validation->set_rules('email_protocol', lang('account_settings_cntrler_email_form_validation_label_email_protocol'), 'required');
			$this->form_validation->set_rules('smtp_host', lang('account_settings_cntrler_email_form_validation_label_smtp_host'), 'required');
			$this->form_validation->set_rules('smtp_port', lang('account_settings_cntrler_email_form_validation_label_smtp_port'), 'required');
			$this->form_validation->set_rules('smtp_username', lang('account_settings_cntrler_email_form_validation_label_smtp_username'), 'required');
			$this->form_validation->set_rules('smtp_password', lang('account_settings_cntrler_email_form_validation_label_smtp_password'), 'required');
			$this->form_validation->set_rules('email_from', lang('account_settings_cntrler_email_form_validation_label_email_from'), 'required');
		}else{
			$this->form_validation->set_rules('email_use_default', lang('account_settings_cntrler_email_form_validation_label_use_default'), 'required');
		}
		if ($this->form_validation->run() == FALSE) {
			// render page
			$this->render('settings/email');
		}else{
			$data = array();
			if ($this->input->post('email_use_default')) {
				$data['email_use_default'] = 1;
			} else {
				$data = array(
					'email_protocol'	=> $this->input->post('email_protocol'),
					'email_host' 		=> $this->input->post('smtp_host'),
					'email_port' 		=> $this->input->post('smtp_port'),
					'email_username' 	=> $this->input->post('smtp_username'),
					'email_password' 	=> $this->input->post('smtp_password'),
					'email_from' 		=> $this->input->post('email_from'),
					'email_use_default'	=> 0,
				);
				if ($this->input->post('smtp_tls')) {
					$data['email_tls'] = 1;
				} else {
					$data['email_tls'] = 0;
				}
			}
			$this->DB1->update('settings', $data);
			$this->session->set_flashdata('message', lang('account_settings_cntrler_email_success'));
			redirect('account_settings/email');
		}
	}
	public function printer() {
		$this->form_validation->set_rules('height', lang('account_settings_cntrler_printer_form_validation_label_height'), 'required');
		$this->form_validation->set_rules('width', lang('account_settings_cntrler_printer_form_validation_label_width'), 'required');
		$this->form_validation->set_rules('top', lang('account_settings_cntrler_printer_form_validation_label_top'), 'required');
		$this->form_validation->set_rules('bottom', lang('account_settings_cntrler_printer_form_validation_label_bottom'), 'required');
		$this->form_validation->set_rules('left', lang('account_settings_cntrler_printer_form_validation_label_left'), 'required');
		$this->form_validation->set_rules('right', lang('account_settings_cntrler_printer_form_validation_label_right'), 'required');
		$this->form_validation->set_rules('orientation', lang('account_settings_cntrler_printer_form_validation_label_orientation'), 'required');
		$this->form_validation->set_rules('output', lang('account_settings_cntrler_printer_form_validation_label_output'), 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->data['account_settings'] = $this->mAccountSettings;
			// render page
			$this->render('settings/printer');
		} else {
			$data = array(
				'print_paper_height' => $this->input->post('height'),
			    'print_paper_width' => $this->input->post('width'),
			    'print_margin_top' => $this->input->post('top'),
			    'print_margin_bottom' => $this->input->post('bottom'),
			    'print_margin_left' => $this->input->post('left'),
			    'print_margin_right' => $this->input->post('right'),
			    'print_orientation' => $this->input->post('orientation'),
			    'print_page_format' => $this->input->post('output'),
			);
			$this->DB1->update('settings', $data);
			$this->session->set_flashdata('message', lang('account_settings_cntrler_printer_success'));
			redirect('account_settings/printer');
		}
	}

	public function tags($action = NULL) {
		if(!$action){
			// render page
			$this->render('settings/tags');
		}elseif ($action == 'delete') {
			$id = $this->security->xss_clean($this->input->post('id', true));
			$q = $this->DB1->get_where('entries' , array('tag_id'=> $id));
			if ($q->num_rows() > 0) {
	        	echo json_encode('false');
			}else{
				$this->DB1->where('id', $id);
				$this->DB1->delete('tags');
	        	echo json_encode('true');
			}
		}elseif ($action == 'add'){
			$q = $this->DB1->get_where('tags', array('title'=>$this->input->post('tag_name')));
			if($q->num_rows() > 0){
				echo "false";
			}else{
				$data = array(
		            'title' => $this->input->post('tag_name'),
		            'color' => substr($this->input->post('tag_color'), 1),
		            'background' => substr($this->input->post('tag_bg'), 1),
		        );
		        $this->DB1->insert('tags', $data);
		        echo 'true';
			}
		}elseif ($action == 'getByID'){
			$q = $this->DB1->get_where('tags', array('id'=>$this->input->post('id')));
			if($q->num_rows() > 0){
				echo json_encode($q->row());
			}else{
		        echo 'false';
			}
		}elseif ($action == 'edit'){
			$this->DB1->where('id', $this->input->post('id'));
			$data = array(
	            'title' => $this->input->post('tag_name'),
	            'color' => substr($this->input->post('tag_color'), 1),
	            'background' => substr($this->input->post('tag_bg'), 1),
	        );
	        $this->DB1->update('tags', $data);
	        echo 'true';
		}
	}

	public function entrytypes($action = NULL) {
		if(!$action) {
			// render page
			$this->render('settings/entrytypes');

		} elseif ($action == 'delete') {
			$id = $this->security->xss_clean($this->input->post('id', true));
			$q = $this->DB1->get_where('entries' , array('entrytype_id'=> $id));

			if ($q->num_rows() > 0) {
	        	echo json_encode('false');
			} else {
				$this->DB1->where('id', $id);
				$this->DB1->delete('entrytypes');
	        	echo json_encode('true');
			}
			
		} elseif ($action == 'add') {
			$q = $this->DB1->get_where('entrytypes', array('label'=>$this->input->post('et_label')));
			
			if($q->num_rows() > 0) {
				echo "false";
			} else {
				$data = array(
		            'label' => $this->input->post('et_label'),
		            'name' => $this->input->post('et_name'),
		            'description' => $this->input->post('description'),
		            'numbering' => $this->input->post('numbering'),
		            'prefix' => $this->input->post('prefix'),
		            'suffix' => $this->input->post('suffix'),
		            'zero_padding' => $this->input->post('zero_padding'),
		            'restriction_bankcash' => $this->input->post('restriction_bankcash'),
		            'base_type' => 1,
		        );
		        $this->DB1->insert('entrytypes', $data);
		        echo 'true';
			}

		} elseif ($action == 'getByID') {
			$q = $this->DB1->get_where('entrytypes', array('id'=>$this->input->post('id')));

			if($q->num_rows() > 0) {
				echo json_encode($q->row());
			} else {
		        echo 'false';
			}

		} elseif ($action == 'edit') {
			$q = $this->DB1->get_where('entrytypes', array('label'=>$this->input->post('et_label')));

			if($q->num_rows() == 0) {
				echo "false";
			} else {
				$this->DB1->where('id', $this->input->post('id'));
				$data = array(
		            'label' => $this->input->post('et_label'),
		            'name' => $this->input->post('et_name'),
		            'description' => $this->input->post('description'),
		            'numbering' => $this->input->post('numbering'),
		            'prefix' => $this->input->post('prefix'),
		            'suffix' => $this->input->post('suffix'),
		            'zero_padding' => $this->input->post('zero_padding'),
		            'restriction_bankcash' => $this->input->post('restriction_bankcash'),
		            'base_type' => 1,
		        );
		        $this->DB1->update('entrytypes', $data);
		        echo 'true';
		    }
		}
	}

	public function lock() {
		/* on POST */
		if ($this->input->method() == 'post') {
			$this->DB1->update('settings', array('account_locked' => $this->input->post('locked')));
			$this->db->where('id', $this->mActiveAccountID)->update('accounts', array('account_locked' => $this->input->post('locked')));
			if ($this->input->post('locked') == 1) {
				$this->settings_model->add_log(lang('account_settings_cntrler_lock_add_log_locked'), 1);
				$this->session->set_flashdata('message', lang('account_settings_cntrler_lock_success_locked'));
				redirect('account_settings/main');
			} else {
				$this->settings_model->add_log(lang('account_settings_cntrler_lock_add_log_unlocked'), 1);
				$this->session->set_flashdata('message' ,lang('account_settings_cntrler_lock_success_unlocked'));
				redirect('account_settings/main');
			}
		} else {
			$this->data['locked'] = $this->mAccountSettings->account_locked;
			// render page
			$this->render('settings/lock');
		}
	}

	// GENERATE THE AJAX TABLE CONTENT //
    public function getAllTags()
    {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, title, color, background')
            ->from('tags')
        	->add_column('actions', "<a href='#clientmodal' id='modify' data-toggle='tooltip' data-num='$1' style='padding-right: 1px;' title='".lang('edit')."'><i class='glyphicon glyphicon-edit'></i></a><a href='#' id='delete' data-num='$1' data-toggle='tooltip' title='".lang('delete')."'><i class='glyphicon glyphicon-trash'></i></a>", 'id');

        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

    // GENERATE THE AJAX TABLE CONTENT //
    public function getAllET() {
        $this->load->library('datatables');
        $this->datatables
            ->select('id, label, name, description, prefix, suffix, zero_padding')
            ->from('entrytypes')
            ->add_column('actions', "<a href='#clientmodal' id='modify' data-toggle='tooltip' data-num='$1' style='padding-right: 1px;' title='".lang('edit')."'><i class='glyphicon glyphicon-edit'></i></a><a href='#' id='delete' data-num='$1' data-toggle='tooltip' title='".lang('delete')."'><i class='glyphicon glyphicon-trash'></i></a>", 'id');
        
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
}


