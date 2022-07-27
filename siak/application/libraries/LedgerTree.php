<?php

/**
 * Class to store the entire group tree
 */
class LedgerTree
{
	var $id = 0;
	var $name = '';
	var $code = '';

	var $children_groups = array();
	var $children_ledgers = array();

	var $counter = 0;

	var $current_id = -1;

	var $restriction_bankcash = 1;

	var $default_text = '';

	var $Group = null;
	var $Ledger = null;
	var $for = null;
	var $searchTerm = null;
	
	public function __construct()
  	{
      	$this->_ci =& get_instance();
      	$this->_ci->load->model('ledger_model');
      	$this->_ci->load->language('main');
      	$this->default_text = $this->_ci->lang->line('please_select_ledger');
  	}
/**
 * Initializer
 */
	function LedgerTree()
	{
		return;
	}

/**
 * Setup which group id to start from
 */
	function build($id)
	{
		if ($id == 0)
		{
			$this->id = NULL;
			$this->name = 'none';
		} else {
			$group = $this->_ci->DB1->where('groups.id', $id)->get('groups')->row_array();
			$this->id = $group['id'];
			$this->name = $group['name'];
			$this->code = $group['code'];
		}

		$this->add_sub_ledgers();
		$this->add_sub_groups();
    	// unset($this->_ci);
	}

/**
 * Find and add subgroups as objects
 */
	function add_sub_groups() {
		if ($this->for == 'select2' && $this->searchTerm) {
			$this->_ci->DB1->like('groups.code', $this->searchTerm);
			$this->_ci->DB1->or_like('groups.name', $this->searchTerm);
		} else {
			$this->_ci->DB1->where('groups.parent_id', $this->id);

			/* If primary group sort by id else sort by name */
			if ($this->id == NULL) {
				// $this->_ci->DB1->order_by('groups.id', 'asc');
				// $this->_ci->DB1->order_by('groups.code', 'asc');
				// $child_group_q = $this->_ci->DB1->get('groups')->result_array();
			} else {
				// $this->_ci->DB1->order_by('groups.name', 'asc');
				// $this->_ci->DB1->order_by('groups.code', 'asc');
				// $child_group_q = $this->_ci->DB1->get('groups')->result_array();
			}
		}

		$this->_ci->DB1->order_by('groups.code', 'asc');
		$child_group_q = $this->_ci->DB1->get('groups')->result_array();
		
		$counter = 0;
		foreach ($child_group_q as $row)
		{
			/* Create new AccountList object */
			$this->children_groups[$counter] = new LedgerTree();
			/* Initial setup */
			$this->children_groups[$counter]->Group = &$this->Group;
			$this->children_groups[$counter]->Ledger = &$this->Ledger;
			$this->children_groups[$counter]->current_id = $this->current_id;
			$this->children_groups[$counter]->build($row['id']);
			$counter++;
		}
	}

/**
 * Find and add subledgers as array items
 */
	function add_sub_ledgers() {

		if ($this->for == 'select2' && $this->searchTerm) {
			$this->_ci->DB1->like('groups.code', $this->searchTerm);
			$this->_ci->DB1->or_like('groups.name', $this->searchTerm);
			$child_group_l = $this->_ci->DB1->get('groups')->num_rows();			
		} else {
			$child_group_l = 1;
		}

		if ($child_group_l == 0) {
			$this->_ci->DB1->reset_query();
			$this->_ci->DB1->like('ledgers.code', $this->searchTerm);
			$this->_ci->DB1->or_like('ledgers.name', $this->searchTerm);
		} else {
			$this->_ci->DB1->where('ledgers.group_id', $this->id);

			if ($this->for == 'select2' && $this->searchTerm && $this->id == null) {
				$this->_ci->DB1->like('ledgers.code', $this->searchTerm);
				$this->_ci->DB1->or_like('ledgers.name', $this->searchTerm);
			}
		}
		
		$this->_ci->DB1->order_by('ledgers.code', 'asc');
		// $this->_ci->DB1->order_by('ledgers.name', 'asc');
		$child_ledger_q = $this->_ci->DB1->get('ledgers')->result_array();
		
		$counter = 0;
		foreach ($child_ledger_q as $row)
		{
			$this->children_ledgers[$counter]['id'] = $row['id'];
			$this->children_ledgers[$counter]['name'] = $row['name'];
			$this->children_ledgers[$counter]['code'] = $row['code'];
			$this->children_ledgers[$counter]['type'] = $row['type'];
			$counter++;
		}
	}

	var $ledgerList = array();

	/* Convert ledger tree to a list */
	public function toList($tree, $c = 0)
	{
		if ($this->for == 'select2') {
			// echo '<pre>';
			// print_r($tree);
			
		}
		/* Add group name to list */
		if ($tree->id != 0) {
			/* Set the group id to negative value since we want to disable it */
			$this->ledgerList[-$tree->id] = $this->space($c).($this->_ci->functionscore->toCodeWithName($tree->code, $tree->name));
		} else {
			$this->ledgerList[0] = $this->default_text;
		}

		/* Add child ledgers */
		if (count($tree->children_ledgers) > 0) {
			$c++;
			foreach ($tree->children_ledgers as $id => $data) {
				$ledger_name = ($this->_ci->functionscore->toCodeWithName($data['code'], $data['name']));
				/* Add ledgers as per restrictions */
				if ($this->restriction_bankcash == 1 ||
					$this->restriction_bankcash == 2 ||
					$this->restriction_bankcash == 3) {
					/* All ledgers */
					$this->ledgerList[$data['id']] = $this->space($c) . $ledger_name;
				} else if ($this->restriction_bankcash == 4) {
					/* Only bank or cash ledgers */
					if ($data['type'] == 1) {
						$this->ledgerList[$data['id']] = $this->space($c) . $ledger_name;
					}

				} else if ($this->restriction_bankcash == 5) {
					/* Only NON bank or cash ledgers */
					if ($data['type'] == 0) {
						$this->ledgerList[$data['id']] = $this->space($c) . $ledger_name;
					}
				}
			}
			$c--;
		}

		/* Process child groups recursively */
		foreach ($tree->children_groups as $id => $data) {
			$c++;
			$this->toList($data, $c);
			$c--;
		}
	}

	function space($count)
	{
		$str = '';
		for ($i = 1; $i <= $count; $i++) {
			if ($this->for == 'select2') {
				$str .= html_entity_decode('&nbsp;&nbsp;&nbsp;');
			} else {
				$str .= '&nbsp;&nbsp;&nbsp;';
			}
			
		}
		return $str;
	}
}
