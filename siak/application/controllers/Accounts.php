<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends Admin_Controller {
	public function __construct() {
        parent::__construct(); 
    }   
    
	public function index() {

        $this->mBodyClass .= ' sidebar-collapse';
		
		$this->load->library('AccountList');
		
		$accountlist = new AccountList();
		$accountlist->Group = &$this->Group;
		$accountlist->Ledger = &$this->Ledger;
		$accountlist->only_opening = false;
		$accountlist->start_date = null;
		$accountlist->end_date = null;
		$accountlist->affects_gross = -1;
		$accountlist->start(0);

		$this->data['accountlist'] = $accountlist;
		$opdiff = $this->ledger_model->getOpeningDiff();
		$this->data['opdiff'] = $opdiff;

		// render page
		$this->render('accounts/index');
	}

	public function log()
	{
		// render log page
		$this->render('accounts/log');
	}

	public function mapper()
	{
		$this->load->library('reader');
		if ($this->input->method() == 'post') {
			$keys = array();
			for($i = 0;$i < $_POST['number_of_keys'];$i++){
				$keys[$_POST['default'.$i]] = $_POST['current'.$i];
			}
			$result = $this->reader->parse_file($_POST['file_path']);
			$this->import($result, $keys);
		}		
	}

	public function uploader()
	{
        if (isset($_FILES['accountcsv'])) {
        	if ($_FILES['accountcsv']['size'] > 0) {
			    $this->load->library('reader');

				$uploadPath = 'assets/uploads/tmp/';

	            $config['upload_path'] = $uploadPath;
	            $config['allowed_types'] = 'text|csv';
	            $config['file_name'] = $_FILES['accountcsv']['name'];
	            $config['overwrite'] = TRUE;
	            $this->load->library('upload', $config);
	            $this->upload->initialize($config);
	            if($this->upload->do_upload('accountcsv')){
	                $fileData = $this->upload->data();
					if ($keys = $this->check_keys($fileData['full_path'])) {
						$result = $this->reader->parse_file($fileData['full_path']);
						$this->import($result, $keys);
					}
	            }else{
	            	if ($this->upload->display_errors()) {
	            		$this->session->set_flashdata('error', $this->upload->display_errors());
	            	}else{
		            	$this->session->set_flashdata('error', lang('admin_cntrler_uploadprofilepicture_error'));
	            	}
	            }
			}
		}else{
			$this->render('accounts/uploader');
		}
	}

	public function check_keys($file_path)
	{

		$default_keys = $this->reader->parse_file(base_url('assets/uploads/import.csv'), true);
		$current_keys = $this->reader->parse_file($file_path, true);
    	if ($default_keys != $current_keys) {
    		$this->data['default_keys'] = $default_keys;
			$this->data['current_keys'] = $current_keys;
			$this->data['file_path'] = $file_path;
    		$this->render('accounts/mapper');
    	}else{
    		$keys = array();
    		foreach ($default_keys as $key => $value) {
    			$keys[$key] = $key;
    		}
    		return $keys;
    	}
	}
	public function import($result, $keys)
	{
		if (count($result) > 1) {
	    	$g_counter = 0;
	    	$l_counter = 0;
	    	$parent_code = NULL;
	    	$parent_id = NULL;
	    	
	    	foreach ($result as $data) {
	    		$code = explode('-', $data[$keys['code']]);
				$group_count = count($code);

				if ($group_count > 1) {
					for ($i = 0; $i < $group_count-1; $i++) {
						if ($i == 0) {
							$parent_code = $code[$i];
						}else{
							$parent_code .= '-'.$code[$i];
						}
					}
				}

				if ($parent_code) {
					$this->DB1->where('code', $parent_code);
					$query = $this->DB1->get('groups', 1);
					if ($query->num_rows() == 1) {
						$parent_group = $query->row_array();
						$parent_id = $parent_group['id'];
					}
				}

	    		if(strtolower($data[$keys['account_type']]) == 'group'){
					$insertdata = array(
						'parent_id' => $parent_id,
						'name' => $data[$keys['name']],
						'code' => $data[$keys['code']],
						'affects_gross' => $data[$keys['affects_gross']]
					);
					// /* Save group */
					if ($this->DB1->insert('groups', $insertdata)) {
						$g_counter++;
						$this->settings_model->add_log(lang('groups_cntrler_add_label_add_log') . $data[$keys['name']], 1);
					}
				}
				if (strtolower($data[$keys['account_type']]) == 'ledger') {
					$insertdata = array(
						'code' => $data[$keys['code']],
						'op_balance' => $data[$keys['opening_balance']],
						'name' => $data[$keys['name']],
						'group_id' => $parent_id,
						'op_balance_dc' => $data[$keys['debit_credit']],
						'notes' => $data[$keys['notes']],
						'reconciliation' => $data[$keys['reconciliation']],
						'type' => $data[$keys['bank_cash']],
					);
					/* Count number of decimal places */
					if($this->DB1->insert('ledgers', $insertdata)){
						$this->settings_model->add_log(lang('ledgers_cntrler_add_label_add_log') . $data[$keys['name']], 1);
						$l_counter++;
					}
				}
	    	}
	    	$this->session->set_flashdata('message', sprintf(lang('accounts_exporter_exported_successfully'), $g_counter, $l_counter));
	    	redirect('accounts');
		}
	}

	public function download($file_path=null)
	{
		if ($file_path == null) {
			$file_path = 'import.csv';
		}

		$this->load->helper('download'); //load helper
        $download_path = $file_path;

        if(!empty($download_path)){
		    $data = file_get_contents(base_url() ."assets/uploads/".$download_path); // Read the file's contents
		    $name = $download_path;
		 
		    force_download($name, $data);
		}
	}
}


