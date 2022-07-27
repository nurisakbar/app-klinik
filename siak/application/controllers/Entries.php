<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends Admin_Controller {
	public function __construct() {
        parent::__construct();
    }   
    
	public function index() {

		// $conditions = array(); // conditions if any
		// if ($conditions)
		// {
		// 	// if any conditions apply where clause
		// 	$this->DB1->where($conditions);
		// }

		// // select all entries
		// $query = $this->DB1->get('entries');

		// // pass an array of all entries to view
		// $this->data['entries'] = $query->result_array();
		
		// render page
		$this->render('entries/index');
	}

	public function getEntries() {
		$this->load->helper('general');
		$this->load->library('datatables');
		
		$this->datatables->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total as dr_total, entries.cr_total as cr_total, entrytypes.label as entryTypeLabel, entries.entrytype_id as entrytype_id')
		->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
		->from('entries')
		->edit_column("date", "$1", "getDateFromSql(date)")
		->edit_column("number", "$1", "getToEntryNumber(number, entrytype_id)")
		->edit_column("kode", "$1", "getKodeAkun(id)")
		->edit_column("id", "$1", "getEntryLedgers(id)")
		->edit_column("tag_id", "$1", "getShowTag(tag_id)")
		->edit_column("dr_total", "$1", "getToCurrencyForEntries('', dr_total)")
		->edit_column("cr_total", "$1", "getToCurrencyForEntries('', cr_total)")
		->add_column("Actions", '<a href="'.base_url().'entries/view/$2/$1" class="no-hover" style="padding-right: 5px;" escape="false" title="View"><i class="glyphicon glyphicon-log-in"></i></a><a href="'.base_url().'entries/edit/$2/$1" style="padding-right: 1px;" class="no-hover" escape="false" title="Edit"><i class="glyphicon glyphicon-edit"></i></a><a href="'.base_url().'entries/delete/$2/$1" class="no-hover" escape="false" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>', "id, entryTypeLabel");

		$this->datatables->unset_column('entryTypeLabel');
		$this->datatables->unset_column('entrytype_id');

        echo $this->datatables->generate();
	}

	public function ledgerList($entrytypeLabel, $searchTerm = null, $selectedLedgers = array()) {

		if ($this->input->post('searchTerm')) {
			$searchTerm = $this->input->post('searchTerm');
		}

		if ($this->input->post('selectedLedgers')) {
			$selectedLedgers = $this->input->post('selectedLedgers');
		}

		if (!is_array($selectedLedgers)) {
			return false;
		}

		echo $this->functionscore->ledgerList($entrytypeLabel, $searchTerm, $selectedLedgers);
	}

	/**
	* add method
	*
	* @param string $entrytypeLabel
	* @return void
	*/
	public function add($entrytypeLabel = null) {

		// collapse sidebar on page render
        $this->mBodyClass .= ' sidebar-collapse';
		
		/* Check for valid entry type */
		if (!$entrytypeLabel) {
			// show 404 error page
			show_404();
		}

		// load entry model
		$this->load->model('entry_model');

		$this->data['entrytypeLabel'] = $entrytypeLabel;
		
		// Select from entrytypes table in DB1 where label = $entrytypeLabel
		$entrytype = $this->DB1->query("SELECT * FROM ".$this->DB1->dbprefix('entrytypes')." WHERE label='$entrytypeLabel'");
		// create array of select data from DB1 - [entrytypes] table
		$entrytype = $entrytype->row_array();
		
		// check if entry type exists
		if (!$entrytype) {
			// set error message if entry type do not exist
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// get allowed decimal place from account settings
		$allowed = $this->mAccountSettings->decimal_places;

		// form validation rules 
		$this->form_validation->set_rules('number', lang('entries_cntrler_add_form_validation_number_label'), 'is_numeric');
		$this->form_validation->set_rules('date', lang('entries_cntrler_add_form_validation_date_label'), 'required');
		$this->form_validation->set_rules('tag_id', lang('entries_cntrler_add_form_validation_tag_label'), 'required');

		$q = $this->DB1->get_where('entries', array('number' => $this->input->post('number')));
		if ($q->num_rows() > 0) {
			$this->form_validation->set_rules('number', lang('entries_cntrler_add_form_validation_number_label'), 'is_numeric|is_db1_unique[entries.number]');
			$this->form_validation->set_message('is_db1_unique', lang('form_validation_is_db1_unique'));
		}
		
		$dc_valid = false; 	// valid debit or credit ledger
		$dr_total = 0;		// total dr amount initially 0
		$cr_total = 0;		// total cr amount initially 0

		// check if $_POST['Entryitem'] is set and is an array
		if (isset($_POST['Entryitem']) && is_array($_POST['Entryitem'])) 
		{
			// loop for all $_POST['Entryitem']
		    foreach ($_POST['Entryitem'] as $key => $value)
		    {
		    	// check if $value['ledger_id'] exists
		   //  	if (!isset($value['ledger_id'])) {
		   //  		// set success alert message
					// $this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
					// // redirect to index page
					// redirect('entries/add/'.$entrytypeLabel);
		   //  	}

		    	// check if $value['ledger_id'] less then or equal to 0
		    	if ($value['ledger_id'] <= 0)
		    	{
		    		// continue to next Entryitem
					continue;
				}
				
				// array of selected ledger
		    	$ledger = $this->DB1->get_where('ledgers', array('id' => $value['ledger_id']))->row_array();

		    	// check if $ledger is Empty
				if (!$ledger)
				{
					// set form validation for Entryitem to be required with error alert
    				$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_invalid_ledger_form_validation_alert')));
				}
				// check if Only Bank or Cash account is present on both Debit and Credit side
				if ($entrytype['restriction_bankcash'] == 4)
				{
					// check if ledger is [NOT] a Bank or Cash Account
					if ($ledger['type'] != 1) {
    					$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_4_form_validation_alert')));
					}
				}
				// check if Only NON Bank or Cash account is present on both Debit and Credit side
				if ($entrytype['restriction_bankcash'] == 5)
				{
					// check if ledger is a Bank or Cash Account
					if ($ledger['type'] == 1) {
    					$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_5_form_validation_alert')));
					}
				}

				// check if ledger is Debit
				if ($value['dc'] == 'D')
				{
					// check if Atleast one Bank or Cash account must be present on Debit side
					if ($entrytype['restriction_bankcash'] == 2)
					{
						// check if ledger is a Bank or Cash Account
						if ($ledger['type'] == 1)
						{
							// set dc_valid = true
							$dc_valid = true;
						}
					}
				} else if ($value['dc'] == 'C') // check if ledger is Credit 
				{
					// check if Atleast 1 Bank or Cash account is present on Credit side
					if ($entrytype['restriction_bankcash'] == 3)
					{
						// check if ledger is Bank or Cash Account
						if ($ledger['type'] == 1)
						{
							// set dc_valid = true
							$dc_valid = true;
						}
					}
				}

				// some more form validation rules
		        $this->form_validation->set_rules('Entryitem['.$key.'][dc]', lang('entries_cntrler_add_form_validation_entryitem_dc_label'), 'required'); // Any validation you need
		        $this->form_validation->set_rules('Entryitem['.$key.'][ledger_id]', lang('entries_cntrler_add_form_validation_entryitem_ledger_id_label'), 'required'); // Any validation you need

		        // if Debit selected
		        if ($value['dc'] == 'D')
		        {
		        	// if dr_amount not empty
		        	if (!empty($value['dr_amount']))
		        	{
		        		// set form validation rules form dr_amount
		        		$this->form_validation->set_rules('Entryitem['.$key.'][dr_amount]', '', "greater_than[0]|amount_okay[$allowed]");

		        		// calculate total debit amount
						$dr_total = $this->functionscore->calculate($dr_total, $value['dr_amount'], '+');
		        	}
		        }else // if credit selected
		        {
		        	// if cr_amount if not empty
		        	if (!empty($value['cr_amount']))
		        	{
		        		// set form validation rules form cr_amount
			        	$this->form_validation->set_rules('Entryitem['.$key.'][cr_amount]', '', "greater_than[0]|amount_okay[$allowed]");

			        	// calculate total credit amount
						$cr_total = $this->functionscore->calculate($cr_total, $value['cr_amount'], '+');
		        	}
		        }
		    }

		    // check if total dr or cr amount is not equal
		    if ($this->functionscore->calculate($dr_total, $cr_total, '!='))
		    {
		    	// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_dr_cr_total_not_equal_form_validation_alert')));
			}
		}

		// check if restriction_bankcash = 2
		if ($entrytype['restriction_bankcash'] == 2)
		{
			// check if Atleast one Bank or Cash account is present on Debit side
			if (!$dc_valid)
			{
				// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_2_not_valid_dc_form_validation_alert')));
			}
		}
		
		// check if Atleast one Bank or Cash account is present on Credit side
		if ($entrytype['restriction_bankcash'] == 3)
		{
			// check if no Bank or Cash account is present on Credit side
			if (!$dc_valid) {
				// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_3_not_valid_dc_form_validation_alert')));
			}
		}

		/***** Check if entry type numbering is auto ******/
		if ($entrytype['numbering'] == 1)
		{
			/* check if $_POST['number'] is empty */
			if (empty($this->input->post('number')))
			{
				// set entry number to next entry number
				$number = $this->entry_model->nextNumber($entrytype['id']);
			}else // if not empty
			{
				// set entry number to $_POST['number']
				$number = $this->input->post('number');
			}
		}else if ($entrytype['numbering'] == 2) // Check if entry type numbering is manual and required
		{
			/* Manual + Required - Check if $_POST['number'] is empty */
			if (empty($this->input->post('number')))
			{
				//  set form validation rule
        		$this->form_validation->set_rules('number', '', 'required', array('required' => lang('entries_cntrler_entry_number_required_form_validation_alert')));
			} else // if not empty
			{
				// set entry number to $_POST['number']
				$number = $this->input->post('number');
			}
		} else // if entry type numbering is manual and not required
		{
			/* Manual + Optional - set entry number to $_POST['number'] */
			$number = $this->input->post('number');
		}

		// check if form is NOT Validated
		if ($this->form_validation->run() == FALSE) {

			$this->data['entrytype'] = $entrytype; // pass entrytype array to view
			// pass page title to view

			$this->data['title'] = sprintf(lang('entries_cntrler_add_title'), $entrytype['name']);
			// pass tag_options array to view
			$this->data['tag_options'] = $this->DB1->select('id, title')->get('tags')->result_array();
			
			/* Ledger selection */
			$ledgers = new LedgerTree(); // initilize ledgers array - LedgerTree Lib
			$ledgers->Group = &$this->Group; // initilize selected ledger groups in ledgers array
			$ledgers->Ledger = &$this->Ledger; // initilize selected ledgers in ledgers array
			$ledgers->current_id = -1; // initilize current group id
			// set restriction_bankcash from entrytype
			$ledgers->restriction_bankcash = $entrytype['restriction_bankcash'];
			$ledgers->build(0); // set ledger id to [NULL] and ledger name to [None] 
			$ledgers->toList($ledgers, -1); // create a list of ledgers array
			$this->data['ledger_options'] = $ledgers->ledgerList; // pass ledger list to view
			
			/*  Check if input method is post */
			if ($this->input->method() == 'post') {
				// initilize current entry items array
				$curEntryitems = array();

				if (isset($_POST['Entryitem']) && !empty($_POST['Entryitem'])) {
					// loop to save post data to current entry items array
					foreach ($_POST['Entryitem'] as $row => $entryitem)
					{
						// check if $value['ledger_id'] exists
				   //  	if (!isset($entryitem['ledger_id'])) {
				   //  		// set success alert message
							// $this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
							// // redirect to index page
							// redirect('entries/add/'.$entrytypeLabel);
				   //  	}

						if (isset($entryitem['ledger_balance'])) {
							$curEntryitems[$row] = array
							(
								'dc' => $entryitem['dc'],
								'ledger_id' => $entryitem['ledger_id'],
								// if dr_amount isset save it else save empty string
								'dr_amount' => isset($entryitem['dr_amount']) ? $entryitem['dr_amount'] : '',
								 // if cr_amount isset save it else save empty string
								'cr_amount' => isset($entryitem['cr_amount']) ? $entryitem['cr_amount'] : '',
								'narration' => $entryitem['narration'],
								'ledger_balance' => $entryitem['ledger_balance'],
								'ledgername' => $this->ledger_model->getName($entryitem['ledger_id'])
							);
						}else{
							$curEntryitems[$row] = array
							(
								'dc' => $entryitem['dc'],
								'ledger_id' => $entryitem['ledger_id'],
								// if dr_amount isset save it else save empty string
								'dr_amount' => isset($entryitem['dr_amount']) ? $entryitem['dr_amount'] : '',
								 // if cr_amount isset save it else save empty string
								'cr_amount' => isset($entryitem['cr_amount']) ? $entryitem['cr_amount'] : '',
								'narration' => $entryitem['narration']
							);
						}
					}
				}
				
				// pass current entry items array to view
				$this->data['curEntryitems'] = $curEntryitems;
			} else { // if method is NOT post
				$curEntryitems = array(); // initilize current entry items array 

				/* Special case if atleast one Bank or Cash on credit side (3) then 1st item is Credit */
				if ($entrytype['restriction_bankcash'] == 3){
					$curEntryitems[0] = array('dc' => 'C');
					$curEntryitems[1] = array('dc' => 'D');
				} else { /* else 1st item is Debit */
					$curEntryitems[0] = array('dc' => 'D');
					$curEntryitems[1] = array('dc' => 'C');
				}

				// pass current entry items array to view
				$this->data['curEntryitems'] = $curEntryitems;
			}
			
			// render page
			if ($this->mSettings->entry_form) {
				$this->render('entries/add2');
			}else{
				$this->render('entries/add');
			}
			
		} else { // if form is Validated
		
			/***************************************************************************/
			/*********************************** ENTRY *********************************/
			/***************************************************************************/
			$entrydata = null; // create entry data array to insert in [entries] table - DB1
			$entrydata['Entry']['number'] = $number; // set entry number in entry data array
			$entrydata['Entry']['entrytype_id'] = $entrytype['id']; // set entrytype_id in entry data array
			
			// check if $_POST['tag_id'] is empty
			if (empty($this->input->post('tag_id')))
			{
				// set entry tag id in entry data array to [NULL]
				$entrydata['Entry']['tag_id'] = null;

			}else // if $_POST['tag_id'] is NOT empty
			{
				// set entry tag id in entry data array to $_POST['tag_id']
				$entrydata['Entry']['tag_id'] = $this->input->post('tag_id');
			}

			/***** Check if $_POST['notes'] is empty *****/
			if (empty($this->input->post('notes')))
			{
				// set entry note in entry data array to [NULL]
				$entrydata['Entry']['notes'] = '';
			}else // if NOT empty
			{
				// set entry note in entry data array to $_POST['notes']
				$entrydata['Entry']['notes'] = $this->input->post('notes');
			}

			/***** Set entry date to $_POST['date'] after converting to sql format(dateToSql function) *****/
			$entrydata['Entry']['date'] = $this->functionscore->dateToSql($this->input->post('date'));

			
			/***************************************************************************/
			/***************************** ENTRY ITEMS *********************************/
			/***************************************************************************/
			/* Check ledger restriction */

			$entrydata['Entry']['dr_total'] = $dr_total; // set entry dr_total in entry data array as $dr_total
			$entrydata['Entry']['cr_total'] = $cr_total; // set entry cr_total in entry data array as $cr_total
			
			/* Add item to entry item data array if everything is ok */
			$entryitemdata = array(); // create entry items data array to insert in [entryitems] table - DB1

			// loop for all Entryitems from post data
			foreach ($this->input->post('Entryitem') as $row => $entryitem)
			{
				// check if $value['ledger_id'] exists
		   //  	if (!isset($entryitem['ledger_id'])) {
		   //  		// set success alert message
					// $this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
					// // redirect to index page
					// redirect('entries/add/'.$entrytypeLabel);
		   //  	}

				// check if $entryitem['ledger_id'] less then or equal to 0
				if ($entryitem['ledger_id'] <= 0)
				{
					// continue to next entryitem
					continue;
				}

				// if entryitem is debit
				if ($entryitem['dc'] == 'D')
				{
					// save entry item data array with dr_amount
					$entryitemdata[] = array(
						'Entryitem' => array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							'amount' => $entryitem['dr_amount'],
							'narration' => $entryitem['narration']
						)
					);
				}else // if entrytype is credit
				{
					// save entry item data array with cr_amount
					$entryitemdata[] = array(
						'Entryitem' => array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							'amount' => $entryitem['cr_amount'],
							'narration' => $entryitem['narration']

						)
					);
				}
			}

			/* insert entry data array to entries table - DB1 */
			$add  = $this->DB1->insert('entries', $entrydata['Entry']);

			// if entry data is inserted
			if ($add)
			{
			   	$insert_id = $this->DB1->insert_id(); // get inserted entry id

			   	// loop for inserting entry item data array to [entryitems] table - DB1
				foreach ($entryitemdata as $row => $itemdata)
				{
					// entry_id for each entry item as id of last entry
					$itemdata['Entryitem']['entry_id'] = $insert_id;

					// insert item data to entryitems table - DB1
					$this->DB1->insert('entryitems' ,$itemdata['Entryitem']);
				}

				// set entry number as per prefix, suffix and zero padding for that entry type for logging
				$entryNumber = $this->functionscore->toEntryNumber($entrydata['Entry']['number'], $entrytype['id']);

				// insert log if logging is enabled
				$this->settings_model->add_log(sprintf(lang('entries_cntrler_add_log'),$entrytype['name'], $entryNumber), 1);

				// set success alert message
				$this->session->set_flashdata('message', sprintf(lang('entries_cntrler_add_entry_created_successfully'),$entrytype['name'], $entryNumber));
				// redirect to index page
				redirect('entries/index');
			}else
			{
				// set error alert message
				$this->session->set_flashdata('error', lang('entries_cntrler_add_entry_not_created_error'));
				// redirect to index page
				redirect('entries/index');
			}
		}
	}


	/**
	* edit method
	*
	* @param string $entrytypeLabel
	* @param string $id
	* @return void
	*/
	public function edit($entrytypeLabel = null, $id = null)
	{
		// load model - entry_model
		$this->load->model('entry_model');

		/* Check for valid entry type */
		if (!$entrytypeLabel)
		{
			// show 404 error page
			show_404();
		}

		$this->data['entrytypeLabel'] = $entrytypeLabel;

		// create entry type array where label = [$entrytypeLabel]
		$entrytype = $this->DB1->query("SELECT * FROM ".$this->DB1->dbprefix('entrytypes')." WHERE label='$entrytypeLabel'")->row_array();

		// if no entry type found
		if (!$entrytype) {
			// set error message
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// get allowed decimal place from account settings
		$allowed = $this->mAccountSettings->decimal_places;

		// form validation rules
		$this->form_validation->set_rules('number', lang('entries_cntrler_edit_form_validarion_number'), 'is_numeric');
		$this->form_validation->set_rules('date', lang('entries_cntrler_edit_form_validarion_date'), 'required');
		$this->form_validation->set_rules('tag_id', lang('entries_cntrler_edit_form_validarion_tag'), 'required');

		$q = $this->DB1->get_where('entries', array('id' => $id))->row();
		if ($this->input->post('number') != $q->number) {
			$this->form_validation->set_rules('number', lang('entries_cntrler_add_form_validation_number_label'), 'is_db1_unique[entries.number]');
			$this->form_validation->set_message('is_db1_unique', lang('form_validation_is_db1_unique'));
        }

		$dc_valid = false; 	// valid Debit or Credit
		$dr_total = 0;		// total Debit amount
		$cr_total = 0;		// total credit amount

		// if Entryitem present in post data and is an array
		if (isset($_POST['Entryitem']) && is_array($_POST['Entryitem']))
		{
			// loop for all entry items
		    foreach ($_POST['Entryitem'] as $key => $value)
		    {
		    	// check if $value['ledger_id'] exists
		    	if (!isset($value['ledger_id'])) {
		    		// set success alert message
					$this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
					// redirect to index page
					redirect('entries/add/'.$entrytypeLabel);
		    	}

		    	// check if $value['ledger_id'] less then or equal to 0
		    	if ($value['ledger_id'] <= 0)
		    	{
		    		// continue to next Entry item
					continue;
				}

				// ledgers array where id = selected entry items ledger id
		    	$ledger = $this->DB1->get_where('ledgers', array('id' => $value['ledger_id']))->row_array();

		    	// if ledger not found
				if (!$ledger)
				{
					// set form validation for Entryitem to be required with error alert
    				$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_invalid_ledger_form_validation_alert')));
				}
				// check if Only Bank or Cash account is present on both Debit and Credit side
				if ($entrytype['restriction_bankcash'] == 4)
				{
					// check if ledger is [NOT] a Bank or Cash Account
					if ($ledger['type'] != 1)
					{
						// set form validation for Entryitem to be required with error alert
    					$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_4_form_validation_alert')));
					}
				}
				
				// check if Only NON Bank or Cash account is present on both Debit and Credit side
				if ($entrytype['restriction_bankcash'] == 5)
				{
					if ($ledger['type'] == 1)
					{
						// set form validation for Entryitem to be required with error alert
    					$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_5_form_validation_alert')));
					}
				}

				// check if ledger is Debit
				if ($value['dc'] == 'D') {
					// check if Atleast one Bank or Cash account must be present on Debit side
					if ($entrytype['restriction_bankcash'] == 2)
					{
						// check if ledger is a Bank or Cash Account
						if ($ledger['type'] == 1)
						{
							// set dc_valid = true
							$dc_valid = true;
						}
					}
				} else if ($value['dc'] == 'C') // check if ledger is Credit 
				{
					// check if Atleast 1 Bank or Cash account is present on Credit side
					if ($entrytype['restriction_bankcash'] == 3)
					{
						// check if ledger is Bank or Cash Account
						if ($ledger['type'] == 1)
						{
							// set dc_valid = true
							$dc_valid = true;
						}
					}
				}

				// some more form validation rules
		        $this->form_validation->set_rules('Entryitem['.$key.'][dc]', lang('entries_cntrler_edit_form_validation_entryitem_dc_label'), 'required'); // Any validation you need
		        $this->form_validation->set_rules('Entryitem['.$key.'][ledger_id]', lang('entries_cntrler_edit_form_validation_entryitem_ledger_id_label'), 'required'); // Any validation you need

		        // if Debit selected
		        if ($value['dc'] == 'D')
		        {
		        	// if dr_amount if not empty
		        	if (!empty($value['dr_amount']))
		        	{
						// set form validation rules form dr_amount
		        		$this->form_validation->set_rules('Entryitem['.$key.'][dr_amount]', '', "greater_than[0]|amount_okay[$allowed]"); // Any validation you need

		        		// calculate total debit amount
						$dr_total = $this->functionscore->calculate($dr_total, $value['dr_amount'], '+');
		        	}
		        }else // if credit selected
		        {
		        	// if cr_amount if not empty
		        	if (!empty($value['cr_amount']))
		        	{
						// set form validation rules form cr_amount
			        	$this->form_validation->set_rules('Entryitem['.$key.'][cr_amount]', '', "greater_than[0]|amount_okay[$allowed]"); // Any validation you need

			        	// calculate total credit amount
						$cr_total = $this->functionscore->calculate($cr_total, $value['cr_amount'], '+');
		        	}
		        }
		    }

		   	// check if total dr or cr amount is not equal
		    if ($this->functionscore->calculate($dr_total, $cr_total, '!='))
		    {
		    	// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_dr_cr_total_not_equal_form_validation_alert')));
			}

		}

		// check if one Bank or Cash account is present on Debit side
		if ($entrytype['restriction_bankcash'] == 2)
		{
			// check if dc_valid is [NOT] true
			if (!$dc_valid)
			{
				// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_2_not_valid_dc_form_validation_alert')));
			}
		}

		// check if Atleast one Bank or Cash account is present on Credit side
		if ($entrytype['restriction_bankcash'] == 3)
		{
			// check if dc_valid is [NOT] true
			if (!$dc_valid)
			{
				// set form validation error
        		$this->form_validation->set_rules('Entryitem', '', 'required', array('required' => lang('entries_cntrler_restriction_bankcash_3_not_valid_dc_form_validation_alert')));
			}
		}

		/***** Check if entry type numbering is auto ******/
		if ($entrytype['numbering'] == 1)
		{
			/* check if $_POST['number'] is empty */
			if (empty($this->input->post('number')))
			{
				// set entry number to next entry number
				$number = $this->entry_model->nextNumber($entrytype['id']);
			}else // if not empty
			{
				// set entry number to $_POST['number']
				$number = $this->input->post('number');
			}
		}else if ($entrytype['numbering'] == 2) // Check if entry type numbering is manual and required
		{
			/* Manual + Required - Check if $_POST['number'] is empty */
			if (empty($this->request->data['Entry']['number']))
			{
				// set form validation rule with error
        		$this->form_validation->set_rules('number', '', 'required', array('required' => lang('entries_cntrler_entry_number_required_form_validation_alert')));
			}else // if not empty
			{
				// set entry number to $_POST['number']
				$number = $this->input->post('number');
			}
		}else// if entry type numbering is manual and not required
		{
			/* Manual + Optional - set entry number to $_POST['number'] */
			$number = $this->input->post('number');
		}

		// check if form is NOT Validated
		if ($this->form_validation->run() == FALSE)
		{
			// pass page title to view
			$this->data['title'] = sprintf(lang('entries_cntrler_edit_title'), $entrytype['name']); 
			$this->data['entrytype'] = $entrytype; // pass entrytype array to view
			// pass tag_options array to view
			$this->data['tag_options'] = $this->DB1->select('id, title')->get('tags')->result_array();

			/* Ledger selection */
			$ledgers = new LedgerTree(); // initilize ledgers array - LedgerTree Lib
			$ledgers->Group = &$this->Group; // initilize selected ledger groups in ledgers array
			$ledgers->Ledger = &$this->Ledger; // initilize selected ledgers in ledgers array
			$ledgers->current_id = -1; // initilize current group id
			// set restriction_bankcash from entrytype
			$ledgers->restriction_bankcash = $entrytype['restriction_bankcash'];
			$ledgers->build(0); // set ledger id to [NULL] and ledger name to [None]
			$ledgers->toList($ledgers, -1);	// create a list of ledgers array
			$this->data['ledger_options'] = $ledgers->ledgerList; // pass ledger list to view

			// if ($this->mSettings->entry_form) {
			// 	$this->DB1->where('id', $id);
			// 	$this->data['ledger'] = $this->DB1->get('ledgers')->row_array();
			// }
			
			/* Check for valid entry id */
			if (!$entrytypeLabel)
			{
				// set error alert
				$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_specified_error'));
				// redirect to index page
				redirect('entries/index');
			}

			// select data from entries table where id equals $id(passed id to edit function) and create array
			$entry = $this->DB1->where('id', $id)->get('entries')->row_array();

			// if no entries found
			if (!$entry)
			{
				// set error alert
				$this->session->set_flashdata('error', lang('entries_cntrler_entry_not_found_error'));
				// redirect to index page
				redirect('entries/index');
			}

			/* Check if input method is post */
			if ($this->input->method() == 'post') {
				// initilize current entry items array
				$curEntryitems = array(); 
				$EntryItems = $this->input->post('Entryitem');

				// loop to save post data to current entry items array
				foreach ($EntryItems as $row => $entryitem) {
					
					// check if $value['ledger_id'] exists
			    	if (!isset($entryitem['ledger_id'])) {
			    		// set success alert message
						$this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
						// redirect to index page
						redirect('entries/add/'.$entrytypeLabel);
			    	}

					if($this->mSettings->entry_form){
						$curEntryitems[$row] = array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							// if dr_amount isset save it else save empty string
							'dr_amount' => isset($entryitem['dr_amount']) ? $entryitem['dr_amount'] : '',
							 // if cr_amount isset save it else save empty string
							'cr_amount' => isset($entryitem['cr_amount']) ? $entryitem['cr_amount'] : '',
							'narration' => $entryitem['narration'],
							'ledger_balance' => $entryitem['ledger_balance'],
							'ledgername' => $this->ledger_model->getName($entryitem['ledger_id'])
						);
					} else {
						$curEntryitems[$row] = array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							// if dr_amount isset save it else save empty string
							'dr_amount' => isset($entryitem['dr_amount']) ? $entryitem['dr_amount'] : '',
							// if cr_amount isset save it else save empty string
							'cr_amount' => isset($entryitem['cr_amount']) ? $entryitem['cr_amount'] : '',
							'narration' => $entryitem['narration']
						);
					}
				}
				// pass current entry items array to view
				$this->data['curEntryitems'] = $curEntryitems;
			
			} else { // if method is [NOT] post
				
				$curEntryitems = array(); // initilize current entry items array 
				$selectedLedgers = array(); // initilize current entry items array 

				// get entry items where entry_id equals $id(passed id to edit function) and store to [curEntryitemsData] array
				$curEntryitemsData = $this->DB1->where('entry_id', $id)->get('entryitems')->result_array();
				// loop for storing current entry items in current entry items array 
				foreach ($curEntryitemsData as $row => $data)
				{
					// check if $value['ledger_id'] exists
			    	if (!isset($data['ledger_id'])) {
			    		// set success alert message
						$this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
						// redirect to index page
						redirect('entries/add/'.$entrytypeLabel);
			    	}

					if($this->mSettings->entry_form) {
						$ledger_balance = $this->curLedgerBalance($data['ledger_id']);

						// if entry item is debit
						if ($data['dc'] == 'D')
						{
							$curEntryitems[$row] = array
							(
								'dc' => $data['dc'],
								'ledger_id' => $data['ledger_id'],
								'dr_amount' => $data['amount'],
								'cr_amount' => '',
								'narration' => $data['narration'],
								'ledgername' => $this->ledger_model->getName($data['ledger_id']),
								'ledger_balance' => $ledger_balance

							);
						} else {// if entry item is credit
							$curEntryitems[$row] = array
							(
								'dc' => $data['dc'],
								'ledger_id' => $data['ledger_id'],
								'dr_amount' => '',
								'cr_amount' => $data['amount'],
								'narration' => $data['narration'],
								'ledgername' => $this->ledger_model->getName($data['ledger_id']),
								'ledger_balance' => $ledger_balance
							);
						}
					} else {
						$selectedLedgers[$row] = $data['ledger_id'];
						// if entry item is debit
						if ($data['dc'] == 'D')
						{
							$curEntryitems[$row] = array
							(
								'dc' => $data['dc'],
								'ledger_id' => $data['ledger_id'],
								'dr_amount' => $data['amount'],
								'cr_amount' => '',
								'narration' => $data['narration'],
							);
						}else // if entry item is credit
						{
							$curEntryitems[$row] = array
							(
								'dc' => $data['dc'],
								'ledger_id' => $data['ledger_id'],
								'dr_amount' => '',
								'cr_amount' => $data['amount'],
								'narration' => $data['narration'],
							);
						}
					}
				}

				// pass current entry items array to view
				$this->data['curEntryitems'] = $curEntryitems;
				$this->data['selectedLedgers'] = $selectedLedgers;
			}

			/***** store entry date after converting from sql format(dateFromSql function) *****/
			$entry['date'] = $this->functionscore->dateFromSql($entry['date']);
			// pass entry array to view
			$this->data['entry'] = $entry;

			// render page
			if ($this->mSettings->entry_form) {
				$this->render('entries/edit2');
			}else{
				$this->render('entries/edit');
			}
		} else { // if form is Validated
			/* Check if acccount is locked */
			if ($this->mAccountSettings->account_locked == 1)
			{
				// set error alert
				$this->session->set_flashdata('error', lang('entries_cntrler_edit_account_locked_error'));
				// redirect to index page
				redirect('entries');
			}

			/***************************************************************************/
			/*********************************** ENTRY *********************************/
			/***************************************************************************/

			$entrydata = null; // entry data array to insert into entries table - DB1

			/***** Entry number ******/
			$entrydata['Entry']['number'] = $number;

			/***** Entry id ******/
			$entrydata['Entry']['id'] = $id;

			/****** Entrytype remains the same *****/
			$entrydata['Entry']['entrytype_id'] = $entrytype['id'];

			/****** Check tag ******/
			if (empty($this->input->post('tag_id'))) {
				// null if empty
				$entrydata['Entry']['tag_id'] = null;
			} else {
				// else $_POST['tag_id']
				$entrydata['Entry']['tag_id'] = $this->input->post('tag_id');
			}

			/***** Notes *****/
			$entrydata['Entry']['notes'] = $this->input->post('notes');

			/***** Date after converting to sql format *****/
			$entrydata['Entry']['date'] = $this->functionscore->dateToSql($this->input->post('date'));

			
			/***************************************************************************/
			/***************************** ENTRY ITEMS *********************************/
			/***************************************************************************/


			$entrydata['Entry']['dr_total'] = $dr_total; // total debit amount
			$entrydata['Entry']['cr_total'] = $cr_total; // total credit amount

			/* Add item to entryitemdata array if everything is ok */
			$entryitemdata = array();

			// loop for entry items array according to debit or credit
			foreach ($this->input->post('Entryitem') as $row => $entryitem)
			{

				// check if $value['ledger_id'] exists
		    	if (!isset($entryitem['ledger_id'])) {
		    		// set success alert message
					$this->session->set_flashdata('warning', lang('entries_cntrler_invalid_ledger_form_validation_alert'));
					// redirect to index page
					redirect('entries/add/'.$entrytypeLabel);
		    	}
		    	
				// check if $entryitem['ledger_id'] less then or equal to 0
				if ($entryitem['ledger_id'] <= 0)
				{
					// continue to next entryitem
					continue;
				}

				// if entry item is debit
				if ($entryitem['dc'] == 'D')
				{
					$entryitemdata[] = array
					(
						'Entryitem' => array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							'amount' => $entryitem['dr_amount'],
							'narration' => $entryitem['narration']

						)
					);
				} else // if entry item is credit
				{
					$entryitemdata[] = array
					(
						'Entryitem' => array(
							'dc' => $entryitem['dc'],
							'ledger_id' => $entryitem['ledger_id'],
							'amount' => $entryitem['cr_amount'],
							'narration' => $entryitem['narration']
						)
					);
				}
			}

			// select where id from [entries] table equals passed id
			$this->DB1->where('id', $id);
			// update entries table
			$update = $this->DB1->update('entries', $entrydata['Entry']);
			
			// if update successfull
			if ($update)
			{
			   	/* Delete all original entryitems */
				$this->DB1->where('entry_id', $id); // select all entry items where entry_id equals passed id
				$this->DB1->delete('entryitems'); // delete selected entry items

				// loop to insert entry item data to entryitems table
				foreach ($entryitemdata as $row => $itemdata)
				{
					$itemdata['Entryitem']['entry_id'] = $id; // entry_id equals passed id
					$this->DB1->insert('entryitems' ,$itemdata['Entryitem']); // insert data to entryitems table
				}

				// set entry number as per prefix, suffix and zero padding for that entry type for logging
				$entryNumber = ($this->functionscore->toEntryNumber($entrydata['Entry']['number'], $entrytype['Entrytype']['id']));

				// insert log if logging is enabled
				$this->settings_model->add_log(sprintf(lang('entries_cntrler_edit_log'),$entrytype['name'], $entryNumber), 1);

				// set success alert message
				$this->session->set_flashdata('message', sprintf(lang('entries_cntrler_edit_entry_updated_successfully'), $entrytype['name'], $entryNumber));
				// redirect to index page
				redirect('entries/index');
			} else {
				// set error alert message
				$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_updated_error'));
				// redirect to index page
				redirect('entries/index');
			}
		}
	}

	private function curLedgerBalance($id)
	{
		$this->DB1->where('id', $id);
		$this->data['curledger'] = $this->DB1->get('ledgers')->row_array();
		$cl = $this->ledger_model->closingBalance($id);
		$status = 'ok';
		$ledger_balance = '';
		if ($this->data['curledger']['type'] == 1) {
			if ($cl['dc'] == 'C') {
				$status = 'neg';
			}
		}

		/* Return closing balance */
		$cl = array('cl' => 
				array(
					'dc' => $cl['dc'],
					'amount' => $cl['amount'],
					'status' => $status,
				)
		);

		$ledger_bal = $cl['cl']['amount'];
		$prefix = '';
		$suffix = '';
		if ($cl['cl']['status'] == 'neg') {
			$this->data['prefix'] = '<span class="error-text">';
			$this->data['suffix'] = '</span>';
		}
		if ($cl['cl']['dc'] == 'D') {
			$ledger_balance = " " . $ledger_bal;
		} else if ($cl['cl']['dc'] == 'C') {
			$ledger_balance = " " . $ledger_bal;
		} else {
			$ledger_balance = '-';
		}
		return $ledger_balance;
	}


	/**
	* delete method
	*
	* @throws MethodNotAllowedException
	* @param string $entrytypeLabel
	* @param string $id
	* @return void
	*/
	public function delete($entrytypeLabel = null, $id = null)
	{
		/* Check for valid entry type */
		if (empty($entrytypeLabel))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_specified_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// select entry type where label equals $entrytypeLabel and store to array
		$entrytype = $this->DB1->where('label',$entrytypeLabel)->get('entrytypes')->row_array();

		// if entry type [NOT] found
		if (!$entrytype)
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		/* Check if valid id */
		if (empty($id))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries');
		}
		
		// select entry where id equals $id and store to array
		$entry = $this->DB1->where('id',$id)->get('entries')->row_array();

		/* if entry [NOT] found */
		if (!$entry)
		{	
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries');
		}

		/* Delete entry items */
		$this->DB1->delete('entryitems', array('entry_id' => $id));
		/* Delete entry */
		$this->DB1->delete('entries', array('id' => $id));

		// set entry number as per prefix, suffix and zero padding for that entry type for logging
		$entryNumber = ($this->functionscore->toEntryNumber($entry['number'], $entrytype['id']));

		// set success alert
		$this->session->set_flashdata('message', sprintf(lang('entries_cntrler_delete_entry_deleted_successfully'), $entrytype['name'], $entryNumber));

		// insert log if logging is enabled
		$this->settings_model->add_log(sprintf(lang('entries_cntrler_delete_log'),$entrytype['name'], $entryNumber), 1);

		// redirect to index page
		redirect('entries/index');

	}
	/**
	* view method
	*
	* @param string $entrytypeLabel
	* @param string $id
	* @return void
	*/
	public function view($entrytypeLabel = null, $id = null, $download = NULL) {
		
		/* Check for valid entry type */
		if (empty($entrytypeLabel))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_specified_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// select entry type where label equals $entrytypeLabel and store to array
		$entrytype = $this->DB1->where('label',$entrytypeLabel)->get('entrytypes')->row_array();
		
		// if entry type [NOT] found
		if (!$entrytype)
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// pass entrytype to view
		$this->data['entrytype'] = $entrytype;

		/* Check if valid id */
		if (empty($id))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// select entry where id equals $id and store to array
		$entry = $this->DB1->where('id',$id)->get('entries')->row_array();

		/* if entry [NOT] found */
		if (!$entry)
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		
		/* Initial data */
		$curEntryitems = array(); // initilize current entry items array
		$this->DB1->where('entry_id', $id); // select where entry_id equals $id

		// store selected data to $curEntryitemsData
		$curEntryitemsData = $this->DB1->get('entryitems')->result_array();

		// loop to store selected entry items to current entry items array
		foreach ($curEntryitemsData as $row => $data)
		{
			// if debit entry
			if ($data['dc'] == 'D')
			{
				$curEntryitems[$row] = array
				(
					'dc' => $data['dc'],
					'ledger_id' => $data['ledger_id'],
					'ledger_name' => $this->ledger_model->getName($data['ledger_id']),
					'dr_amount' => $data['amount'],
					'cr_amount' => '',
					'narration' => $data['narration']
				);
			}else // if credit entry
			{
				$curEntryitems[$row] = array
				(
					'dc' => $data['dc'],
					'ledger_id' => $data['ledger_id'],
					'ledger_name' => $this->ledger_model->getName($data['ledger_id']),
					'dr_amount' => '',
					'cr_amount' => $data['amount'],
					'narration' => $data['narration']

				);
			}
		}

		$this->data['curEntryitems'] = $curEntryitems; // pass current entry items to view
		$this->data['allTags'] = $this->DB1->get('tags')->result_array(); // fetch all tags and pass to view
		$this->data['entry'] = $entry; // pass entry to view
		$this->data['entrytypeLabel'] = $entrytypeLabel;
		if ($download === 'pdf') {
			$name = 'entry_print.pdf';

				// $this->load->view('reports/pdf/balancesheet', $this->data);

	            $html = $this->load->view('entries/export_pdf', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            $this->functionscore->generate_pdf($html, $name);
		} else {
			// render page
			$this->render('entries/view');
		}
		
	}

	/**
	 * Add a row in the entry via ajax
	 *
	 * @param string $addType
	 * @return void
	 */
	function addrow($restriction_bankcash) {

		// $this->layout = null; 

		/* Ledger selection */
		// $ledgers = new LedgerTree(); // initilize ledgers array - LedgerTree Lib
		// $ledgers->Group = &$this->Group; // initilize selected ledger groups in ledgers array
		// $ledgers->Ledger = &$this->Ledger; // initilize selected ledgers in ledgers array
		// $ledgers->current_id = -1; // initilize current group id
		// // set restriction_bankcash from entrytype
		// $ledgers->restriction_bankcash = $restriction_bankcash;
		// $ledgers->build(0); // set ledger id to [NULL] and ledger name to [None] 
		// $ledgers->toList($ledgers, -1); // create a list of ledgers array
		// $data['ledger_options'] = $ledgers->ledgerList; // pass ledger list to view
		// $this->load->view('entries/addrow', $data); // load view

		$this->load->view('entries/addrow'); // load view
	}

	/**
	 * Add a row in the entry via ajax
	 *
	 * @param string $addType
	 * @return void
	 */
	function addentry() {
		if (isset($_POST) && !empty($_POST)) {
			$data['entryitem'] = $_POST;
			$this->load->view('entries/addentry', $data); // load view
		}else{
			return FALSE;
		}
	}

	public function export($entrytypeLabel, $id, $type='xls')
	{
		/* Check for valid entry type */
		if (empty($entrytypeLabel))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_specified_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// select entry type where label equals $entrytypeLabel and store to array
		$entrytype = $this->DB1->where('label',$entrytypeLabel)->get('entrytypes')->row_array();
		
		// if entry type [NOT] found
		if (!$entrytype)
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_entrytype_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// pass entrytype to view
		$this->data['entrytype'] = $entrytype;

		/* Check if valid id */
		if (empty($id))
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		// select entry where id equals $id and store to array
		$entry = $this->DB1->where('id',$id)->get('entries')->row_array();

		/* if entry [NOT] found */
		if (!$entry)
		{
			// set error alert
			$this->session->set_flashdata('error', lang('entries_cntrler_edit_entry_not_found_error'));
			// redirect to index page
			redirect('entries/index');
		}

		
		/* Initial data */
		$curEntryitems = array(); // initilize current entry items array
		$this->DB1->where('entry_id', $id); // select where entry_id equals $id

		// store selected data to $curEntryitemsData
		$curEntryitemsData = $this->DB1->get('entryitems')->result_array();

		// loop to store selected entry items to current entry items array
		foreach ($curEntryitemsData as $row => $data)
		{
			// if debit entry
			if ($data['dc'] == 'D')
			{
				$curEntryitems[$row] = array
				(
					'dc' => $data['dc'],
					'ledger_id' => $data['ledger_id'],
					'ledger_name' => $this->ledger_model->getName($data['ledger_id']),
					'dr_amount' => $data['amount'],
					'cr_amount' => '',
					'narration' => $data['narration']
				);
			}else // if credit entry
			{
				$curEntryitems[$row] = array
				(
					'dc' => $data['dc'],
					'ledger_id' => $data['ledger_id'],
					'ledger_name' => $this->ledger_model->getName($data['ledger_id']),
					'dr_amount' => '',
					'cr_amount' => $data['amount'],
					'narration' => $data['narration']

				);
			}
		}


        if (!empty($data)) {

            $this->load->library('excel');
            $this->excel->setActiveSheetIndex(0);
            if ($type=='pdf') {
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $this->excel->getDefaultStyle()->applyFromArray($styleArray);
            }
			if ($this->mSettings->drcr_toby == 'toby') {
				$drcr_toby = lang('entries_views_views_th_to_by');
			} else {
				$drcr_toby = lang('entries_views_views_th_dr_cr');
			}
            $this->excel->getActiveSheet()->setTitle(ucfirst($entrytypeLabel).lang('entry_title')."  #".$entry['number']);

            $this->excel->getActiveSheet()->SetCellValue('A1', ucfirst($entrytypeLabel).lang('entry_title')."  #".$entry['number']);
            $this->excel->getActiveSheet()->mergeCells('A1:E1');

            $this->excel->getActiveSheet()->SetCellValue('A2', lang('date').": ".$entry['date']);
            $this->excel->getActiveSheet()->mergeCells('A2:E2');


            $this->excel->getActiveSheet()->SetCellValue('A3', $drcr_toby);
            $this->excel->getActiveSheet()->SetCellValue('B3', lang('entries_views_views_th_ledger'));
            $this->excel->getActiveSheet()->SetCellValue('C3', lang('entries_views_views_th_dr_amount'));
            $this->excel->getActiveSheet()->SetCellValue('D3', lang('entries_views_views_th_cr_amount'));
            $this->excel->getActiveSheet()->SetCellValue('E3', lang('entries_views_views_th_narration') );

            $row = 4;
            $ttotal = 0;
            $ttotal_tax = 0;
            $tgrand_total = 0;
            foreach ($curEntryitems as $entryitem) {
                $ir = $row + 1;
                if ($ir % 2 == 0) {
                    $style_header = array(                  
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb'=>'CCCCCC'),
                        ),
                    );
                    $this->excel->getActiveSheet()->getStyle("A$row:E$row")->applyFromArray( $style_header );
                }

                if ($this->mSettings->drcr_toby == 'toby') {
					if ($entryitem['dc'] == 'D') {
						$dr_cr_rows = lang('entries_views_views_toby_D');
					} else {
						$dr_cr_rows = lang('entries_views_views_toby_C');
					}
				} else {
					if ($entryitem['dc'] == 'D') {
						$dr_cr_rows = lang('entries_views_views_drcr_D');
					} else {
						$dr_cr_rows = lang('entries_views_views_drcr_C');
					}
				}


            
                $this->excel->getActiveSheet()->SetCellValue('A' . $row, $dr_cr_rows);
                $this->excel->getActiveSheet()->SetCellValue('B' . $row, $entryitem['ledger_name']);
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $entryitem['dc'] == 'D' ? $entryitem['dr_amount'] : '');
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $entryitem['dc'] == 'C' ? $entryitem['cr_amount'] : '');
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $entryitem['narration']);
                $row++;
            }
            $style_header = array(                  
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb'=>'fdbf2d'),
                ),
            );


            $this->excel->getActiveSheet()->getStyle("A$row:E$row")->applyFromArray( $style_header );

            $this->excel->getActiveSheet()->SetCellValue("A$row", lang('entries_views_views_td_total'));
            $this->excel->getActiveSheet()->mergeCells("A$row:B$row");
            $this->excel->getActiveSheet()->SetCellValue("C$row", $this->functionscore->toCurrency('D', $entry['dr_total']));
            $this->excel->getActiveSheet()->SetCellValue("D$row", $this->functionscore->toCurrency('C', $entry['cr_total']));


            if ($this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '==')) {
				/* Do nothing */
			} else {
				if ($this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '>')) {
					$this->excel->getActiveSheet()->SetCellValue("A$row", lang('entries_views_views_td_diff'));
		            $this->excel->getActiveSheet()->mergeCells("A$row:B$row");
		            $this->excel->getActiveSheet()->SetCellValue("C$row",  $this->functionscore->toCurrency('D', $this->functionscore->calculate($entry['dr_total'], $entry['cr_total'], '-')));
				} else {
					$this->excel->getActiveSheet()->SetCellValue("A$row", lang('entries_views_views_td_diff'));
		            $this->excel->getActiveSheet()->mergeCells("A$row:C$row");
		            $this->excel->getActiveSheet()->SetCellValue("D$row", $this->functionscore->toCurrency('C', $this->functionscore->calculate($entry['cr_total'], $entry['dr_total'], '-')));
				}
			}

            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
           
            $filename = 'entry_print';
            $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        
            $this->excel->getActiveSheet()->getStyle('C2:C' . ($row))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $this->excel->getActiveSheet()->getStyle('D2:D' . ($row))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

            $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            $header = 'A1:E1';
            $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
            
            $header = 'A2:E2';
            $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fdbf2d');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);

            if ($type=='pdf') {
                // require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDFF" . DIRECTORY_SEPARATOR . "mpdf.php");
                // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                // $rendererLibrary = 'MPDFF';
                // $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                // if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                //     die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                //         PHP_EOL . ' as appropriate for your directory structure');
                // }

                // header('Content-Type: application/pdf');
                // header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                // header('Cache-Control: max-age=0');

                // $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                // $objWriter->save('php://output');
                // exit();
            }
            
            if ($type=='xls') {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                $objWriter->save('php://output');
                exit();
            }
        }
	}
	
}