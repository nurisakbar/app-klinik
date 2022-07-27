<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends Admin_Controller {
	public function __construct() {
        parent::__construct();
    }   

	
/**
 * add method
 *
 * @return void
 */
	public function add() {

		$this->form_validation->set_rules('parent_id', lang('groups_cntrler_add_form_validation_label_parent_group'), 'required');
		$this->form_validation->set_rules('name', lang('groups_cntrler_add_form_validation_label_name'), 'required');
		$this->form_validation->set_rules('code', lang('groups_cntrler_add_form_validation_label_code'), 'is_db1_unique[groups.code]');
		$this->form_validation->set_rules('affects_gross', lang('groups_cntrler_add_form_validation_label_affects_gross'), 'required');

		if ($this->form_validation->run() == FALSE) {
            
            $this->load->library('GroupTree');

			/* Create list of parent groups */
			$parentGroups = new GroupTree();
			$parentGroups->Group = &$this->Group;
			$parentGroups->current_id = -1;
			$parentGroups->build(0);
			$parentGroups->toList($parentGroups, -1);
			$this->data['parents'] = $parentGroups->groupList;
			
			// render page
			$this->render('groups/add');

        } else {
        	$data = array(
				'parent_id' => $this->input->post('parent_id'),
				'name' => $this->input->post('name'),
				'code' => NULL,
				'affects_gross' => $this->input->post('affects_gross'),
			);
			/* If code is empty set it as NULL */
			if (!empty($this->input->post('code'))) {
				$data['code'] = $this->input->post('code');
			}
			
			/* Save group */
			$this->DB1->insert('groups', $data);
			$this->settings_model->add_log(lang('groups_cntrler_add_label_add_log') . $this->input->post('name'), 1);
			$this->session->set_flashdata('message', sprintf(lang('groups_cntrler_add_group_created_successfully'), $this->input->post('name')));
			redirect('accounts');
        }
		
	}


	/**
 * edit method
 *
 * @throws NotFoundException
 * @throws ForbiddenException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {


	    $original_value = $this->DB1->where('id', $id)->from('groups')->get()->row()->code ;
	    if($this->input->post('code') != $original_value) {
	       $is_unique =  'is_db1_unique[groups.code]';
	    } else {
	       $is_unique =  '';
	    }

		/* Check for valid group */
		if (empty($id)) {
			$this->session->set_flashdata('error', lang('groups_cntrler_edit_group_not_specified_error'));
			redirect('accounts');
		}
		$group = $this->DB1->where('id',$id)->get('groups')->row_array();
		if (!$group) {
			$this->session->set_flashdata('error', lang('groups_cntrler_edit_group_not_found_error'));
			redirect('accounts');
		}
		if ($id <= 4) {
			$this->session->set_flashdata('error', lang('groups_cntrler_edit_basic_account_permission_denied_error'));
			redirect('accounts');
		}


		$this->form_validation->set_rules('parent_id', lang('groups_cntrler_edit_form_validation_label_parent_group'), 'required');
		$this->form_validation->set_rules('name', lang('groups_cntrler_edit_form_validation_label_name'), 'required');
		$this->form_validation->set_rules('code', lang('groups_cntrler_edit_form_validation_label_code'), $is_unique);
		$this->form_validation->set_rules('affects_gross', lang('groups_cntrler_edit_form_validation_label_affects_gross'), 'required');

		if ($this->form_validation->run() == FALSE) {
            $this->load->library('GroupTree');
			/* Create list of parent groups */
			$parentGroups = new GroupTree();
			$parentGroups->Group = &$this->Group;
			$parentGroups->current_id = $id;
			$parentGroups->build(0);
			$parentGroups->toList($parentGroups, -1);
			$this->data['parents'] = $parentGroups->groupList;
			$this->data['group'] = $group;
			// render page
		$this->render('groups/edit');
        } else {
        	/* Check if acccount is locked */
			if ($this->mAccountSettings->account_locked == 1) {
				$this->session->set_flashdata('error', lang('groups_cntrler_edit_account_locked_error'));
				redirect('accounts');
			}

			/* Check if group and parent group are not same */
			if ($id == $this->input->post('parent_id')) {
				$this->session->set_flashdata('error', lang('groups_cntrler_edit_account_parent_group_same_error'));
				redirect('accounts');
			}
			$data = array(
				'parent_id' => $this->input->post('parent_id'),
				'name' => $this->input->post('name'),
				'code' => NULL,
				'affects_gross' => $this->input->post('affects_gross'),
			);

			/* If code is empty set it as NULL */
			if (!empty($this->input->post('code'))) {
				$data['code'] = $this->input->post('code');
			}

			$this->DB1->where('id', $id);
			$this->DB1->update('groups', $data);
			$this->settings_model->add_log(lang('groups_cntrler_edit_label_add_log') . $this->input->post('name'), 1);
			$this->session->set_flashdata('message', sprintf(lang('groups_cntrler_edit_group_updated_successfully'), $this->input->post('name')));
			redirect('accounts');
        }

	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @throws MethodNotAllowedException
	 * @param string $id
	 * @return void
	 */
		public function delete($id = null) {

			/* Check if valid id */
			if (empty($id)) {
				$this->session->set_flashdata('error', lang('groups_cntrler_delete_group_not_specified_error'));
				redirect('accounts');
			}

			/* Check if group exists */
			$group = $this->DB1->where('id',$id)->get('groups')->row_array();
			if (!$group) {
				$this->session->set_flashdata('error', lang('groups_cntrler_delete_group_not_found_error'));
				redirect('accounts');
			}

			/* Check if group can be deleted */
			if ($id <= 4) {
				$this->session->set_flashdata('error', lang('groups_cntrler_delete_basic_account_permission_denied_error'));
				redirect('accounts');
			}

			/* Check if any child groups exists */
			$this->DB1->where('groups.parent_id', $id);
			$q = $this->DB1->get('groups');
			if ($q->num_rows() > 0) {
				$this->session->set_flashdata('error', lang('groups_cntrler_delete_child_group_exists_error'));
				redirect('accounts');
			}

			/* Check if any child ledgers exists */
			$this->DB1->where('ledgers.group_id', $id);
			$q = $this->DB1->get('ledgers');
			if ($q->num_rows() > 0) {
				$this->session->set_flashdata('error', lang('groups_cntrler_delete_child_ledger_exists_error'));
				redirect('accounts');
			}

			/* Delete group */
			$this->DB1->delete('groups', array('id' => $id));
			$this->settings_model->add_log(lang('groups_cntrler_delete_label_add_log') . $group['name'], 1);
			$this->session->set_flashdata('message', sprintf(lang('groups_cntrler_delete_group_deleted_successfully'), $group['name']));
			redirect('accounts');

		}

	public function getNextCode() {
		$id = $_POST['id'];
		$this->DB1->where('id', $id);
		$p_group_code = $this->DB1->get('groups')->row()->code;
		// print_r($p_group_code);
		$this->DB1->where('id !=', $id);
		$this->DB1->where('parent_id', $id);
		$this->DB1->like('code', $p_group_code);
		$q = $this->DB1->get('groups')->result();
		// print_r($q);
		if ($q) {
			$last = end($q);
			$last = $last->code;
			$l_array = explode('-', $last);
			$new_index = end($l_array);
			$new_index += 1;
			$new_index = sprintf("%02d", $new_index);
			echo $p_group_code."-".$new_index;
		}else{
			echo $p_group_code."-01";
		}

	}

}



