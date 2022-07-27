<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends Admin_Controller {
	public function __construct() {
        parent::__construct();
    }   
	
	function getSearchedEntries() {

		$data = json_encode($_POST['form_data']);
		$data = json_decode($data);

		foreach ($data as $key => $value) {
			if ($value->name == 'ledger_ids[]') {
				$ledger_ids[] = ($value->value);
			}

			if ($value->name == 'entrytype_ids[]') {
				$entrytype_ids[] = ($value->value);
			}

			if ($value->name == 'tag_ids[]') {
				$tag_ids[] = ($value->value);
			}

			if ($value->name == 'entrynumber_restriction') {
				$entrynumber_restriction = ($value->value);
			}

			if ($value->name == 'entrynumber1') {
				$entrynumber1 = ($value->value);
			}

			if ($value->name == 'entrynumber2') {
				$entrynumber2 = ($value->value);
			}

			if ($value->name == 'amount_dc') {
				$amount_dc = ($value->value);
			}

			if ($value->name == 'amount_restriction') {
				$amount_restriction = ($value->value);
			}

			if ($value->name == 'amount1') {
				$amount1 = ($value->value);
			}

			if ($value->name == 'amount2') {
				$amount2 = ($value->value);
			}

			if ($value->name == 'fromdate') {
				$fromdate = ($value->value);
			}

			if ($value->name == 'todate') {
				$todate = ($value->value);
			}

			if ($value->name == 'narration') {
				$narration = ($value->value);
			}
		}
		
		$search_data = array(
			'ledger_ids' => (isset($ledger_ids)&&!empty($ledger_ids) ? $ledger_ids : NULL),
			'entrytype_ids' => (isset($entrytype_ids)&&!empty($entrytype_ids) ? $entrytype_ids : NULL),
			'tag_ids' => (isset($tag_ids)&&!empty($tag_ids) ? $tag_ids : NULL),
			'entrynumber_restriction' => $entrynumber_restriction,
			'entrynumber1' => $entrynumber1,
			'entrynumber2' => $entrynumber2,
			'amount_dc' => $amount_dc,
			'amount_restriction' => $amount_restriction,
			'amount1' => $amount1,
			'amount2' => $amount2,
			'fromdate' => $fromdate,
			'todate' => $todate,
			'narration' => $narration,
		);

		$this->load->helper('general');
		$this->load->library('datatables');
		
        $ledger_ids = '';
		if (empty($search_data['ledger_ids'])) {
			$ledger_ids = '0';
		} else {
			if (in_array('0', $search_data['ledger_ids'])) {
				$ledger_ids = '0';
			} else {
				$ledger_ids = implode(',', $search_data['ledger_ids']);
			}
		}

		$entrytype_ids = '';
		if (empty($search_data['entrytype_ids'])) {
			$entrytype_ids = '0';
		} else {
			if (in_array('0', $search_data['entrytype_ids'])) {
				$entrytype_ids = '0';
			} else {
				$entrytype_ids = implode(',', $search_data['entrytype_ids']);
			}
		}

		$tag_ids = '';
		if (empty($search_data['tag_ids'])) {
			$tag_ids = '0';
		} else {
			if (in_array('0', $search_data['tag_ids'])) {
				$tag_ids = '0';
			} else {
				$tag_ids = implode(',', $search_data['tag_ids']);
			}
		}


		/* Setup search conditions */
		$conditions = array();

		if (!empty($search_data['ledger_ids'])) {
			if (!in_array('0', $search_data['ledger_ids'])) {
				// foreach($search_data['ledger_ids'] as $w) {
				//     $this->datatables->or_where('entryitems.ledger_id', $w);
				// }

				$this->datatables->where_in('entryitems.ledger_id', $search_data['ledger_ids']);
			}
		}

		if (!empty($search_data['entrytype_ids'])) {
			if (!in_array('0', $search_data['entrytype_ids'])) {
				// foreach($search_data['entrytype_ids'] as $w) {
				//     $this->datatables->or_where('entries.entrytype_id', $w);
				// }
				
				$this->datatables->where_in('entries.entrytype_id', $search_data['entrytype_ids']);
			}
		}

		if (!empty($search_data['entrynumber1'])) {
			if ($search_data['entrynumber_restriction'] == 1) {
				/* Equal to */
				$conditions['entries.number'] = $search_data['entrynumber1'];
			} else if ($search_data['entrynumber_restriction'] == 2) {
				/* Less than or equal to */
				$conditions['entries.number <='] =  $search_data['entrynumber1'];
			} else if ($search_data['entrynumber_restriction'] == 3) {
				/* Greater than or equal to */
				$conditions['entries.number >='] = $search_data['entrynumber1'];
			} else if ($search_data['entrynumber_restriction'] == 4) {
				/* In between */
				if (!empty($search_data['entrynumber2'])) {
					$conditions['entries.number >='] = $search_data['entrynumber1'];
					$conditions['entries.number <='] = $search_data['entrynumber2'];
				} else {
					$conditions['entries.number >='] = $search_data['entrynumber1'];
				}
			}
		}

		if ($search_data['amount_dc'] == 'D') {
			/* Dr */
			$conditions['entryitems.dc'] = 'D';
		} else if ($search_data['amount_dc'] == 'C') {
			/* Cr */
			$conditions['entryitems.dc'] = 'C';
		}

		if (!empty($search_data['amount1'])) {
			if ($search_data['amount_restriction'] == 1) {
				/* Equal to */
				$conditions['entryitems.amount'] = $search_data['amount1'];
			} else if ($search_data['amount_restriction'] == 2) {
				/* Less than or equal to */
				$conditions['entryitems.amount <='] =  $search_data['amount1'];
			} else if ($search_data['amount_restriction'] == 3) {
				/* Greater than or equal to */
				$conditions['entryitems.amount >='] = $search_data['amount1'];
			} else if ($search_data['amount_restriction'] == 4) {
				/* In between */
				if (!empty($search_data['amount2'])) {
					$conditions['entryitems.amount >='] = $search_data['amount1'];
					$conditions['entryitems.amount <='] = $search_data['amount2'];
				} else {
					$conditions['entryitems.amount >='] = $search_data['amount1'];
				}
			}
		}

		if (!empty($search_data['fromdate'])) {
			/* TODO : Validate date */
			$fromdate = $this->functionscore->dateToSql($search_data['fromdate']);
			$conditions['entries.date >='] = $fromdate;
		}

		if (!empty($search_data['todate'])) {
			/* TODO : Validate date */
			$todate = $this->functionscore->dateToSql($search_data['todate']);
			$conditions['entries.date <='] = $todate;
		}

		
		if (!empty($search_data['tag_ids'])) {
			if (!in_array('0', $search_data['tag_ids'])) {
				
				// foreach($search_data['tag_ids'] as $w) {
				//     $this->datatables->or_where('entries.tag_id', $w);
				// }

				$this->datatables->where_in('entries.tag_id', $search_data['tag_ids']);
			}
		}

		if (!empty($search_data['narration'])) {
			$conditions['entryitems.narration LIKE'] = '%' . $search_data['narration'] . '%';
		}
		
		$this->datatables->where($conditions)
		->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total as dr_total, entries.cr_total as cr_total, entries.entrytype_id as entrytype_id, entryitems.narration as narration, entryitems.ledger_id as ledger_ida, entryitems.amount as amount, entryitems.reconciliation_date as reconciliation_date, entrytypes.label as entryTypeLabel, entryitems.dc as dc')
		->join('entryitems', 'entries.id = entryitems.entry_id', 'left')
		->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
		->from('entries')
		->edit_column("date", "$1", "getDateFromSql(date)")
		->edit_column("number", "$1", "getToEntryNumber(number, entrytype_id)")
		->edit_column("id", "$1", "getEntryLedgers(id)")
		->edit_column("tag_id", "$1", "getShowTag(tag_id)")
		->edit_column("dr_total", "$1", "getToCurrency(dc, dr_total)")
		->edit_column("cr_total", "$1", "getToCurrency(dc, cr_total)")
		->add_column("Actions", '<a href="'.base_url().'entries/view/$2/$1" style="padding-right: 5px;" title="View"><i class="glyphicon glyphicon-log-in"></i></a><a href="'.base_url().'entries/edit/$2/$1" style="padding-right: 1px;" title="Edit"><i class="glyphicon glyphicon-edit"></i></a><a href="'.base_url().'entries/delete/$2/$1" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>', "id, entryTypeLabel");

		$this->datatables->unset_column('entrytype_id');
		$this->datatables->unset_column('narrationwhere_in');
		$this->datatables->unset_column('ledger_ida');
		$this->datatables->unset_column('amount');
		$this->datatables->unset_column('dc');
		$this->datatables->unset_column('reconciliation_date');
		$this->datatables->unset_column('entryTypeLabel');

        echo $this->datatables->generate();
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
				
		$this->data['showEntries'] = false;

		/* Ledger selection */
		$ledgers = new LedgerTree();
		$ledgers->Group = &$this->Group;
		$ledgers->Ledger = &$this->Ledger;
		$ledgers->current_id = -1;
		$ledgers->restriction_bankcash = 1;
		$ledgers->default_text = '(ALL)';
		$ledgers->build(0);
		$ledgers->toList($ledgers, -1);
		
		$this->data['ledger_options'] = $ledgers->ledgerList;

		/* Entrytypes */
		$entrytype_options = array();
		$entrytype_options[0] = '(ALL)';

		$rawentrytypes = $this->DB1->order_by('id', 'asc')->get('entrytypes')->result_array();
		foreach ($rawentrytypes as $row => $rawentrytype) {
			$entrytype_options[$rawentrytype['id']] = ($rawentrytype['name']);
		}
		$this->data['entrytype_options'] = $entrytype_options;


		/* Tags */
		$tag_options = array();
		$tag_options[0] = '(ALL)';
		$rawtags = $this->DB1->order_by('title', 'asc')->get('tags')->result_array();

		foreach ($rawtags as $row => $rawtag) {
			$tag_options[$rawtag['id']] = ($rawtag['title']);
		}
		$this->data['tag_options'] = $tag_options;

		// render page
		$this->render('search');
	}

}
