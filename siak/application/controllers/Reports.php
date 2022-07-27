<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller {
	public $row = 3;

	public function __construct() {
        parent::__construct();
        $this->mBodyClass .= ' sidebar-collapse';
    }   

	public function index() {
		redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	* 	Balancesheet report function
	* 	
	*  	@param	string	$download	Optional parameter to download report i.e.
	*	download or NULL
	*   @param	string	$format		Optional parameter to select download format i.e
	*	pdf or xls
	* 	@return void
	**/
	public function balancesheet($download = NULL, $format = NULL, $startdate = NULL, $enddate = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_balancesheet');
		$this->data['title'] = lang('page_title_reports_balancesheet');

		$only_opening = false;
		// $startdate = null;
		// $enddate = null;

		if ($download === 'download') {
			if ($startdate && $enddate) {
				$startdate = $this->functionscore->dateToSql($startdate);
				$this->data['startdate'] = $startdate;
				$enddate = $this->functionscore->dateToSql($enddate);
				$this->data['enddate'] = $enddate;
			} else if ($startdate) {
				$startdate = $this->functionscore->dateToSql($startdate);
				$this->data['startdate'] = $startdate;
			} else if ($enddate) {
				$enddate = $this->functionscore->dateToSql($enddate);
				$this->data['enddate'] = $enddate;
			}	
		} else {
			$this->data['startdate'] = NULL;
			$this->data['enddate'] = NULL;
		}

		if ($this->input->method() == 'post') {
			$this->data['options'] = true;
			
			if (!empty($this->input->post('opening'))) {
				$only_opening = true;
				$this->data['only_opening'] = $only_opening;
				/* Sub-title*/
				$this->data['subtitle'] = sprintf(lang('opening_balance_sheet_as_on'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start));

			} else {
				if ($this->input->post('startdate')) {
					$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
					$this->data['start_date'] = $startdate;
					$this->data['startdate'] = $this->input->post('startdate');
				}

				if ($this->input->post('enddate')) {
					$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
					$this->data['end_date'] = $enddate;
					$this->data['enddate'] = $this->input->post('enddate');
				}

				if ( $this->input->post('startdate') && $this->input->post('enddate')) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate'))));

				} else if ( $this->input->post('startdate')) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))));

				} else if ($this->input->post('enddate')) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate'))));

				} else {
					$this->data['options'] = false;
			
					/* Sub-title*/
					$this->data['subtitle'] = sprintf(lang('closing_balance_sheet_as_on'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
				}
			}
		} else {
			$this->data['options'] = false;
			if ($download === 'download') {
				if ($startdate && $enddate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($startdate)), $this->functionscore->dateFromSql($this->functionscore->dateToSql($enddate)));
				} else if ($startdate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($startdate)));
				} else if ($enddate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->functionscore->dateToSql($enddate)));
				} else {
					/* Sub-title*/
					$this->data['subtitle'] = sprintf(lang('closing_balance_sheet_as_on'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
				}
			} else {
				/* Sub-title*/
				$this->data['subtitle'] = sprintf(lang('closing_balance_sheet_as_on'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
			}
		}

		/**********************************************************************/
		/*********************** BALANCESHEET CALCULATIONS ********************/
		/**********************************************************************/
		$this->load->library('AccountList');
		/* Liabilities */
		$liabilities = new AccountList();
		$liabilities->Group = &$this->Group;
		$liabilities->Ledger = &$this->Ledger;
		$liabilities->only_opening = $only_opening;
		$liabilities->start_date = $startdate;
		$liabilities->end_date = $enddate;
		$liabilities->affects_gross = -1;
		$liabilities->start(2);

		$bsheet['liabilities'] = $liabilities;

		$bsheet['liabilities_total'] = 0;
		if ($liabilities->cl_total_dc == 'C') {
			$bsheet['liabilities_total'] = $liabilities->cl_total;
		} else {
			$bsheet['liabilities_total'] = $this->functionscore->calculate($liabilities->cl_total, 0, 'n');
		}

		/* Assets */
		$assets = new AccountList();
		$assets->Group = &$this->Group;
		$assets->Ledger = &$this->Ledger;
		$assets->only_opening = $only_opening;
		$assets->start_date = $startdate;
		$assets->end_date = $enddate;
		$assets->affects_gross = -1;
		$assets->start(1);

		$bsheet['assets'] = $assets;

		$bsheet['assets_total'] = 0;
		if ($assets->cl_total_dc == 'D') {
			$bsheet['assets_total'] = $assets->cl_total;
		} else {
			$bsheet['assets_total'] = $this->functionscore->calculate($assets->cl_total, 0, 'n');
		}

		/* Profit and loss calculations */
		$income = new AccountList();
		$income->Group = &$this->Group;
		$income->Ledger = &$this->Ledger;
		$income->only_opening = $only_opening;
		$income->start_date = $startdate;
		$income->end_date = $enddate;
		$income->affects_gross = -1;
		$income->start(3);

		$expense = new AccountList();
		$expense->Group = &$this->Group;
		$expense->Ledger = &$this->Ledger;
		$expense->only_opening = $only_opening;
		$expense->start_date = $startdate;
		$expense->end_date = $enddate;
		$expense->affects_gross = -1;
		$expense->start(4);

		if ($income->cl_total_dc == 'C') {
			$income_total = $income->cl_total;
		} else {
			$income_total = $this->functionscore->calculate($income->cl_total, 0, 'n');
		}
		if ($expense->cl_total_dc == 'D') {
			$expense_total = $expense->cl_total;
		} else {
			$expense_total = $this->functionscore->calculate($expense->cl_total, 0, 'n');
		}

		$bsheet['pandl'] = $this->functionscore->calculate($income_total, $expense_total, '-');

		/* Difference in opening balance */
		$bsheet['opdiff'] = $this->ledger_model->getOpeningDiff();
		if ($this->functionscore->calculate($bsheet['opdiff']['opdiff_balance'], 0, '==')) {
			$bsheet['is_opdiff'] = false;
		} else {
			$bsheet['is_opdiff'] = true;
		}

		/**** Final balancesheet total ****/
		$bsheet['final_liabilities_total'] = $bsheet['liabilities_total'];
		$bsheet['final_assets_total'] = $bsheet['assets_total'];

		/* If net profit add to liabilities, if net loss add to assets */
		if ($this->functionscore->calculate($bsheet['pandl'], 0, '>=')) {
			$bsheet['final_liabilities_total'] = $this->functionscore->calculate(
				$bsheet['final_liabilities_total'],
				$bsheet['pandl'], '+');
		} else {
			$positive_pandl = $this->functionscore->calculate($bsheet['pandl'], 0, 'n');
			$bsheet['final_assets_total'] = $this->functionscore->calculate(
				$bsheet['final_assets_total'],
				$positive_pandl, '+');
		}

		/**
		 * If difference in opening balance is Dr then subtract from
		 * assets else subtract from liabilities
		 */
		if ($bsheet['is_opdiff']) {
			if ($bsheet['opdiff']['opdiff_balance_dc'] == 'D') {
				$bsheet['final_assets_total'] = $this->functionscore->calculate(
					$bsheet['final_assets_total'],
					$bsheet['opdiff']['opdiff_balance'], '+');
			} else {
				$bsheet['final_liabilities_total'] = $this->functionscore->calculate(
					$bsheet['final_liabilities_total'],
					$bsheet['opdiff']['opdiff_balance'], '+');
			}
		}

		$this->data['bsheet'] = $bsheet;

		if (!$download) {
			// render page
			$this->render('reports/balancesheet');
		}

		if ($download === 'download') {
			if ($format === 'csv') {
				$name = 'Balancesheet.csv';
	            $html = $this->load->view('reports/downloadcsv/balancesheet', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            header('Content-Type: application/csv');
            	header('Content-Disposition: attachement; filename="' . $name . '"');
            	echo $html;
			}

			if ($format=='pdf') {
				$name = 'Balancesheet.pdf';
				// $this->load->view('reports/pdf/balancesheet', $this->data);

	            $html = $this->load->view('reports/pdf/balancesheet', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            $this->functionscore->generate_pdf($html, $name);
            }
		}
	}

	/**
	*	profitloss method
	*
	*	@return void
	**/
	public function profitloss($download = NULL, $format = NULL, $startdate = NULL, $enddate = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_profitloss');
		$this->data['title'] = lang('profit_loss_title');
		$this->data['subtitle'] = lang('profit_loss_subtitle');

		$only_opening = false;
		// $startdate = null;
		// $enddate = null;

		if ($download === 'download') {
			if ($startdate && $enddate) {
				$startdate = $this->functionscore->dateToSql($startdate);
				$this->data['startdate'] = $startdate;
				$enddate = $this->functionscore->dateToSql($enddate);
				$this->data['enddate'] = $enddate;
			} else if ($startdate) {
				$startdate = $this->functionscore->dateToSql($startdate);
				$this->data['startdate'] = $startdate;
			} else if ($enddate) {
				$enddate = $this->functionscore->dateToSql($enddate);
				$this->data['enddate'] = $enddate;
			}	
		} else {
			$this->data['startdate'] = NULL;
			$this->data['enddate'] = NULL;
		}

		if ($this->input->method() == 'post') {
			$this->data['options'] = true;
			if (!empty($this->input->post('opening'))) {
				$only_opening = true;
				/* Sub-title*/
				$this->data['subtitle'] = sprintf(lang('opening_profit_loss_as_on'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start));
			} else {
				if ($this->input->post('startdate')) {
					$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
					$this->data['start_date'] = $startdate;
					$this->data['startdate'] = $this->input->post('startdate');
					// $startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
				}
				if ($this->input->post('enddate')) {
					$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
					$this->data['end_date'] = $enddate;
					$this->data['enddate'] = $this->input->post('enddate');
					// $enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
				}
				if ( $this->input->post('startdate') && $this->input->post('enddate')) {
					$this->data['subtitle'] = sprintf(lang('profit_loss_from_to'),  $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate'))));
				} else if ( $this->input->post('startdate')) {
					$this->data['subtitle'] = sprintf(lang('profit_loss_from'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))));

				} else if ($this->input->post('enddate')) {
					$this->data['subtitle'] = sprintf(lang('profit_loss_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate'))));
				}
			}
		}else{
			$this->data['options'] = false;
			if ($download === 'download') {
				if ($startdate && $enddate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($startdate)), $this->functionscore->dateFromSql($this->functionscore->dateToSql($enddate)));
				} else if ($startdate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from'), $this->functionscore->dateFromSql($this->functionscore->dateToSql($startdate)));
				} else if ($enddate) {
					$this->data['subtitle'] = sprintf(lang('balance_sheet_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->functionscore->dateToSql($enddate)));
				} else {
					/* Sub-title*/
					$this->data['subtitle'] = sprintf(lang('profit_loss_from'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
				}
			} else {
				/* Sub-title*/
				$this->data['subtitle'] = sprintf(lang('profit_loss_from'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
			}
		}


		/**********************************************************************/
		/*********************** GROSS CALCULATIONS ***************************/
		/**********************************************************************/
		$this->load->library('AccountList');
		/* Gross P/L : Expenses */
		$gross_expenses = new AccountList();
		$gross_expenses->Group = &$this->Group;
		$gross_expenses->Ledger = &$this->Ledger;
		$gross_expenses->only_opening = $only_opening;
		$gross_expenses->start_date = $startdate;
		$gross_expenses->end_date = $enddate;
		$gross_expenses->affects_gross = 1;
		$gross_expenses->start(4);

		$pandl['gross_expenses'] = $gross_expenses;

		$pandl['gross_expense_total'] = 0;
		if ($gross_expenses->cl_total_dc == 'D') {
			$pandl['gross_expense_total'] = $gross_expenses->cl_total;
		} else {
			$pandl['gross_expense_total'] = $this->functionscore->calculate($gross_expenses->cl_total, 0, 'n');
		}

		/* Gross P/L : Incomes */
		$gross_incomes = new AccountList();
		$gross_incomes->Group = &$this->Group;
		$gross_incomes->Ledger = &$this->Ledger;
		$gross_incomes->only_opening = $only_opening;
		$gross_incomes->start_date = $startdate;
		$gross_incomes->end_date = $enddate;
		$gross_incomes->affects_gross = 1;
		$gross_incomes->start(3);

		$pandl['gross_incomes'] = $gross_incomes;

		$pandl['gross_income_total'] = 0;
		if ($gross_incomes->cl_total_dc == 'C') {
			$pandl['gross_income_total'] = $gross_incomes->cl_total;
		} else {
			$pandl['gross_income_total'] = $this->functionscore->calculate($gross_incomes->cl_total, 0, 'n');
		}

		/* Calculating Gross P/L */
		$pandl['gross_pl'] = $this->functionscore->calculate($pandl['gross_income_total'], $pandl['gross_expense_total'], '-');

		/**********************************************************************/
		/************************* NET CALCULATIONS ***************************/
		/**********************************************************************/

		/* Net P/L : Expenses */
		$net_expenses = new AccountList();
		$net_expenses->Group = &$this->Group;
		$net_expenses->Ledger = &$this->Ledger;
		$net_expenses->only_opening = $only_opening;
		$net_expenses->start_date = $startdate;
		$net_expenses->end_date = $enddate;
		$net_expenses->affects_gross = 0;
		$net_expenses->start(4);

		$pandl['net_expenses'] = $net_expenses;

		$pandl['net_expense_total'] = 0;
		if ($net_expenses->cl_total_dc == 'D') {
			$pandl['net_expense_total'] = $net_expenses->cl_total;
		} else {
			$pandl['net_expense_total'] = $this->functionscore->calculate($net_expenses->cl_total, 0, 'n');
		}

		/* Net P/L : Incomes */
		$net_incomes = new AccountList();
		$net_incomes->Group = &$this->Group;
		$net_incomes->Ledger = &$this->Ledger;
		$net_incomes->only_opening = $only_opening;
		$net_incomes->start_date = $startdate;
		$net_incomes->end_date = $enddate;
		$net_incomes->affects_gross = 0;
		$net_incomes->start(3);

		$pandl['net_incomes'] = $net_incomes;

		$pandl['net_income_total'] = 0;
		if ($net_incomes->cl_total_dc == 'C') {
			$pandl['net_income_total'] = $net_incomes->cl_total;
		} else {
			$pandl['net_income_total'] = $this->functionscore->calculate($net_incomes->cl_total, 0, 'n');
		}

		/* Calculating Net P/L */
		$pandl['net_pl'] = $this->functionscore->calculate($pandl['net_income_total'], $pandl['net_expense_total'], '-');
		$pandl['net_pl'] = $this->functionscore->calculate($pandl['net_pl'], $pandl['gross_pl'], '+');

		$this->data['pandl'] = $pandl;

		if (!$download) {
			// render page
			$this->render('reports/profitloss');
		}

		if ($download === 'download') {
			if ($format === 'pdf') {
				$name = 'Profit&Loss.pdf';

				// $this->load->view('reports/pdf/profitloss', $this->data);
				
	            $html = $this->load->view('reports/pdf/profitloss', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            $this->functionscore->generate_pdf($html, $name);
			}

			if ($format === 'csv') {
				$name = 'Profit&Loss.csv';
	            $html = $this->load->view('reports/downloadcsv/profitloss', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            header('Content-Type: application/csv');
            	header('Content-Disposition: attachement; filename="' . $name . '"');
            	echo $html;
			}			
		}
		return;
	}

	/**
	*	trialbalance method
	*
	*	@return void
	**/
	public function trialbalance($download = NULL, $format = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_trialbalance');

		$this->data['title'] = lang('page_title_reports_trialbalance');
		$this->data['subtitle'] = sprintf(lang('trial_balance_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));

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

		if (!$download) {
			// render page
			$this->render('reports/trialbalance');
		}

		if ($download === 'download') {
			if ($format === 'pdf') {
				$name = 'trialbalance.pdf';

				// $this->load->view('reports/pdf/trialbalance', $this->data);

	            $html = $this->load->view('reports/pdf/trialbalance', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            $this->functionscore->generate_pdf($html, $name);
			}	
			if ($format === 'csv') {
				$name = 'trialbalance.csv';
	            $html = $this->load->view('reports/downloadcsv/trialbalance', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            header('Content-Type: application/csv');
            	header('Content-Disposition: attachement; filename="' . $name . '"');
            	echo $html;
			}			
		}
	}
	public function alltrialbalance($download = NULL, $format = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_trialbalance');

		$this->data['title'] = lang('page_title_reports_trialbalance');
		$this->data['subtitle'] = sprintf(lang('all_trial_balance_from_to'), $this->functionscore->dateFromSql($this->mAccountSettings->fy_start), $this->functionscore->dateFromSql($this->mAccountSettings->fy_end));

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

		if (!$download) {
			// render page
			$this->render('reports/alltrialbalance');
		}

		if ($download === 'download') {
			if ($format === 'pdf') {
				$name = 'trialbalance.pdf';

				// $this->load->view('reports/pdf/trialbalance', $this->data);

	            $html = $this->load->view('reports/pdf/trialbalance', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            $this->functionscore->generate_pdf($html, $name);
			}	
			if ($format === 'csv') {
				$name = 'trialbalance.csv';
	            $html = $this->load->view('reports/downloadcsv/trialbalance', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            header('Content-Type: application/csv');
            	header('Content-Disposition: attachement; filename="' . $name . '"');
            	echo $html;
			}			
		}
	}
	public function pagination($page, $op_balance = NULL) {
		$this->load->model("reports_model");
		$this->load->library("pagination");
		
		if ($this->input->method() == 'post') {
			if (empty($this->input->post('ledger_id'))) {
				$this->session->set_flashdata('error', lang('invalid_ledger'));
				redirect('reports/ledgerstatement');
			}

			$startdate = null;
			$enddate = null;

			$ledgerId = $this->input->post('ledger_id');

			if (!empty($this->input->post('startdate'))) {
				$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
			}

			if (!empty($this->input->post('enddate'))) {
				$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
			}

			$config = array();
			$config["base_url"] = "#";
			$config["total_rows"] = $this->reports_model->count_all($ledgerId, $startdate, $enddate);
			$config["per_page"] = $this->mSettings->row_count;
			$config["uri_segment"] = 3;
			$config["use_page_numbers"] = TRUE;
			$config["full_tag_open"] = '<ul class="pagination">';
			$config["full_tag_close"] = '</ul>';
			$config["first_tag_open"] = '<li>';
			$config["first_tag_close"] = '</li>';
			$config["last_tag_open"] = '<li>';
			$config["last_tag_close"] = '</li>';
			$config['next_link'] = '&gt;';
			$config["next_tag_open"] = '<li>';
			$config["next_tag_close"] = '</li>';
			$config["prev_link"] = "&lt;";
			$config["prev_tag_open"] = "<li>";
			$config["prev_tag_close"] = "</li>";
			$config["cur_tag_open"] = "<li class='active'><a href='#'>";
			$config["cur_tag_close"] = "</a></li>";
			$config["num_tag_open"] = "<li>";
			$config["num_tag_close"] = "</li>";
			$config["num_links"] = 1;

			$this->pagination->initialize($config);
			$page = $this->uri->segment(3);
			$start = ($page - 1) * $config["per_page"];

			$output = array(
				'pagination_link'  => $this->pagination->create_links(),
				'entry_table'   => $this->fetch_details($config["per_page"], $start, $ledgerId, $startdate, $enddate, $page, $op_balance),
			);

			return $this->functionscore->send_json($output);
		}
	}

	function fetch_details($limit, $start, $ledgerId, $startDate = NULL, $endDate = NULL, $page = NULL, $op_balance = NULL) {

		$data = $this->ledgerstatement('ajax', $ledgerId, $startDate, $endDate, $limit, $start);
		
		if ($data['id'] == 0) {
			return $data;
		}

		$output = array();

		$html = '';

		$html .= '<table class="stripped" id="ledgerstatement_table" style="width: 100%;">
			<thead>
				<tr>
					<th>' . lang('date') . '</th>
					<th>' . lang('number') . '</th>
					<th>' . lang('description') . '</th>
					<th>' . lang('type') . '</th>
					<th>' . lang('tag') . '</th>
					<th>' . lang('dr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
					<th>' . lang('cr_amount') . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
					<th>' . lang('balance') . '' . ' (' . $this->mAccountSettings->currency_symbol . ')</th>
					<th>' . lang('actions') . '</th>
				</tr>
			</thead>
			<tbody>';

		/* Current opening balance */
		$entry_balance['amount'] = $data['current_op']['amount'];
		$entry_balance['dc'] = $data['current_op']['dc'];

		$html .=  '<tr class="tr-highlight">';
		$html .=  '<td colspan="7">';
		$html .=  lang('curr_opening_balance');
		$html .=  '</td>';
		if ($page > 1 && !is_null($op_balance)) {
			$op_balance = explode('_', $op_balance);
			$html .=  '<td colspan="2">' . $this->functionscore->toCurrency($op_balance[0], $op_balance[1]) . '</td>';
		} else {
			$html .=  '<td colspan="2">' . $this->functionscore->toCurrency($data['op']['dc'], $data['op']['amount']) . '</td>';
		}
		$html .=  '</tr>';

		foreach($data['entries'] as $row) {
			/* Calculate current entry balance */
			$entry_balance = $this->functionscore->calculate_withdc($entry_balance['amount'], $entry_balance['dc'], $row['amount'], $row['dc']);

			/* Negative balance if its a cash or bank account and balance is Cr */
			if ($data['ledger_data']['type'] == 1) {
				if ($entry_balance['dc'] == 'C' && $entry_balance['amount'] != '0.00') {
					$html .= '<tr class="error-text">';
				} else {
					$html .= '<tr>';
				}
			} else {
				$html .= '<tr>';
			}

			$html .= '<td>' . $this->functionscore->dateFromSql($row['date']) . '</td>';
			$html .= '<td>' . $this->functionscore->toEntryNumber($row['number'], $row['entrytype_id']) . '</td>';
			$html .= '<td>' . $row['narration'] . '</td>';
			$html .= '<td>' . $row['entryTypeName'] . '</td>';
			$html .= '<td>' . $this->functionscore->showTag($row['tag_id']) . '</td>';
			if ($row['dc'] == 'D') {
				$html .= '<td>' . $this->functionscore->toCurrency('D', $row['amount']) . '</td>';
				$html .=  '<td>-</td>';
			} else if ($row['dc'] == 'C') {
				$html .= '<td>-</td>';
				$html .= '<td>' . $this->functionscore->toCurrency('C', $row['amount']) . '</td>';
			} else {
				$html .= '<td>' . lang('search_views_amounts_td_error') . '</td>';
				$html .= '<td>' . lang('search_views_amounts_td_error') . '</td>';
			}

			$html .= '<td>' . $this->functionscore->toCurrency($entry_balance['dc'], $entry_balance['amount']) . '</td>';

			$html .= '<td><a href="' . base_url('entries/view/' . $row['entryTypeLabel'] . '/' . $row['id']) . '" style="padding-right: 5px;" title="' . lang('view') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-log-in"></i>
				</a>';

			$html .= '<a href="' . base_url('entries/edit/' . $row['entryTypeLabel'] . '/' . $row['id']) . '" style="padding-right: 1px;" title="' . lang('edit') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i>
				</a>';

		 	$html .= '<a href="' . base_url('entries/delete/' . $row['entryTypeLabel'] . '/' . $row['id']) . '" title="' . lang('delete') . '" data-toggle="tooltip"><i class="glyphicon glyphicon-trash"></i>
				</a></td>';

			$html .= '</tr>';
		}

		/* Current closing balance */
		$html .=  '<tr class="tr-highlight">';
		$html .=  '<td colspan="7">';
		$html .=  lang('curr_closing_balance');
		$html .=  '</td>';
		$html .=  '<td id="cl_td" colspan="2" data-op-balance="' . $entry_balance['dc'] . "_" . $entry_balance['amount'] . '">' . $this->functionscore->toCurrency($entry_balance['dc'], $entry_balance['amount']) . '</td>';
		$html .=  '</tr>';

		$html .= '</tbody></table>';

		$output['entry_table_html'] = $html;
		$output['data'] = $data;

		return $output;
	}

	/**
	*	ledgerstatement method
	*
	*	@return void
	**/
	public function ledgerstatement($show = true, $ledgerId = NULL, $startDate = NULL, $endDate = NULL, $limit = NULL, $offset = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_ledgerstatement');
		$this->data['title'] = lang('page_title_reports_ledgerstatement');

		/* Create list of ledgers to pass to view */
		$ledgers = new LedgerTree();
		$ledgers->Group = &$this->Group;
		$ledgers->Ledger = &$this->Ledger;
		$ledgers->current_id = -1;
		$ledgers->restriction_bankcash = 1;
		$ledgers->build(0);
		$ledgers->toList($ledgers, -1);
		
		$this->data['ledgers'] = $ledgers->ledgerList;
		
		$this->data['showEntries'] = false;
		$this->data['options'] = false;

		if ($this->input->method() == 'post' && $show !== 'ajax') {
			if (empty($this->input->post('ledger_id'))) {
				$this->session->set_flashdata('error', lang('invalid_ledger'));
				redirect('reports/ledgerstatement');
			}
			$ledgerId = $this->input->post('ledger_id');
		}

		if ($ledgerId) {
			/* Check if ledger exists */
			$this->DB1->where('id', $ledgerId);
			$ledger = $this->DB1->get('ledgers')->row_array();

			if (!$ledger) {
				$this->session->set_flashdata('error', lang('ledger_not_found'));
				redirect('reports/ledgerstatement');
			}

			$this->data['ledger_data'] = $ledger;

			/* Set the approprite search conditions */
			$conditions = array();
			$conditions['entryitems.ledger_id'] = $ledgerId;

			/* Set the approprite search conditions if custom date is selected */
			$startdate = null;
			$enddate = null;

			$sDate = null;
			$eDate = null;

			$this->data['options'] = true;

			if (!empty($this->input->post('startdate'))) {
				$sDate = $this->input->post('startdate');
				$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
			} else if ($startDate != NULL) {
				$sDate = $startDate;
				$startdate = $this->functionscore->dateToSql($startDate);
			}

			if (!empty($this->input->post('enddate'))) {
				$eDate = $this->input->post('enddate');
				$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
			} else if ($endDate != NULL) {
				$eDate = $endDate;
				$enddate = $this->functionscore->dateToSql($endDate);
			}
			
			/* Sub-title*/
			if (!empty($startdate) && !empty($enddate)) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($startdate),
					$this->functionscore->dateFromSql($enddate));
				$this->data['startdate'] = $sDate;
				$this->data['enddate'] = $eDate;

			} else if (!empty($startdate)) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($startdate),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
				$this->data['startdate'] = $sDate;
			} else if (!empty($enddate)) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($enddate)
				);
				$this->data['enddate'] = $this->input->post('enddate');
			} else {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}

			/* Opening and closing titles */
			if (is_null($startdate) || empty($startdate)) {
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
				$this->functionscore->dateFromSql($this->mAccountSettings->fy_start));
			} else {
				$conditions['entries.date >='] = $startdate;
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
				$this->functionscore->dateFromSql($startdate));
			}

			if (is_null($enddate) || empty($enddate)) {
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
				$this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
			} else {
				$conditions['entries.date <='] = $enddate;
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
				$this->functionscore->dateFromSql($enddate));
			}

			/* Calculating opening balance */
			$op = $this->ledger_model->openingBalance($ledgerId, $startdate);
			$this->data['op'] = $op;

			/* Calculating closing balance */
			$cl = $this->ledger_model->closingBalance($ledgerId, null, $enddate);
			$this->data['cl'] = $cl;

			/* Calculate current page opening balance */
			$current_op = $op;
			
			$this->DB1->where($conditions)
			->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total, entries.cr_total, entryitems.amount, entryitems.narration as narration, entryitems.dc as dc, entries.entrytype_id as entrytype_id, entrytypes.label as entryTypeLabel, entryitems.entry_id')
			->join('entryitems', 'entries.id = entryitems.entry_id', 'left')
			->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
			->order_by('entries.id', 'asc');
			if (!is_null($limit) && !is_null($offset)) {
				$this->DB1->limit($limit, $offset);
			}
			$this->data['entries'] = $this->DB1->get('entries')->result_array();

			/* Buat PDF Report */
			$kondisi = array();
			$kondisi['entryitems.ledger_id'] = $ledgerId;
			if (!empty($this->input->get('startdate'))) {
				$awal = $this->functionscore->dateToSql($this->input->get('startdate'));
				$kondisi['entries.date >='] = $awal;
			}
			if (!empty($this->input->get('enddate'))) {
				$akhir = $this->functionscore->dateToSql($this->input->get('enddate'));
				$kondisi['entries.date <='] = $akhir;
			}
			$this->DB1->where($kondisi)
			->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total, entries.cr_total, entryitems.amount, entryitems.narration as narration, entryitems.dc as dc, entries.entrytype_id as entrytype_id, entrytypes.label as entryTypeLabel, entryitems.entry_id')
			->join('entryitems', 'entries.id = entryitems.entry_id', 'left')
			->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
			->order_by('entries.id', 'asc');
			if (!is_null($limit) && !is_null($offset)) {
				$this->DB1->limit($limit, $offset);
			}
			$this->data['entri'] = $this->DB1->get('entries')->result_array();
			/* Set the current page opening balance */
			
			$this->data['current_op'] = $current_op;

			/* Pass varaibles to view which are used in Helpers */
			$this->data['allTags'] = $this->DB1->get('tags')->result_array();
			$this->data['showEntries'] = true;
		}

        if ($show === 'false') {
        	/* Sub-title*/
			if (!empty($this->input->get('startdate')) && !empty($this->input->get('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('startdate'))),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('enddate')))
				);
				$this->data['startdate'] = $this->input->get('startdate');
				$this->data['enddate'] = $this->input->get('enddate');
			} else if (!empty($this->input->get('startdate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('startdate'))),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
				$this->data['startdate'] = $this->input->get('startdate');
				
			} else if (!empty($this->input->get('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->input->get('enddate'))
				);
				$this->data['enddate'] = $this->input->get('enddate');
			}else{
				$this->data['subtitle'] = sprintf(lang('ledger_statement_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}

        	$name = 'Ledger Statement.pdf';

        	// $this->load->view('reports/pdf/ledgerstatement', $this->data);

            $html = $this->load->view('reports/pdf/ledgerstatement', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
            $this->functionscore->generate_pdf($html, $name);
		}

		if ($show === true || $show === 'true' || $show === 'ledgerid') {
			$this->render('reports/ledgerstatement');
		} else if ($show === 'ajax') {
			if ($ledgerId == NULL) {
				if (empty($this->input->post('ledger_id')) || $this->input->post('ledger_id') == null || $this->input->post('ledger_id') == 0 || !$this->input->post('ledger_id')) {
					return array('id' => 0, 'status' => 'error', 'msg' => lang('invalid_ledger'));
				}
			}

			$opening_balance = $this->functionscore->toCurrency($this->data['op']['dc'], $this->data['op']['amount']);
			$closing_balance = $this->functionscore->toCurrency($this->data['cl']['dc'], $this->data['cl']['amount']);

			$startDate = (isset($this->data['startdate']) ? $this->data['startdate'] : $startDate);
			$endDate = (isset($this->data['enddate']) ? $this->data['enddate'] : $endDate);

			
			
			$ajax_data = array(
				'id' 				=> 1,
				'entries'			=> $this->data['entries'],
				'entri'			    => $this->data['entri'],
				'showEntries' 		=> $this->data['showEntries'],
				'ledger_data' 		=> $this->data['ledger_data'],
				'subtitle' 			=> $this->data['subtitle'],
				'opening_title' 	=> $this->data['opening_title'],
				'closing_title' 	=> $this->data['closing_title'],
				'op' 				=> $this->data['op'],
				'cl' 				=> $this->data['cl'],
				'opening_balance'	=> $opening_balance,
				'current_op' 		=> $this->data['current_op'],
				'closing_balance' 	=> $closing_balance,
				'startDate' 		=> $startDate,
				'endDate' 			=> $endDate,
			);

			// return $this->functionscore->send_json($ajax_data);
			return $ajax_data;
		} else {
			return array(
				'ledgers' 	=> $this->data['ledgers'],
				'showEntries' => $this->data['showEntries'],
				'ledger_data' => $this->data['ledger_data'],
				'subtitle' 	=> $this->data['subtitle'],
				'opening_title' => $this->data['opening_title'],
				'closing_title' => $this->data['closing_title'],
				'op' 			=> $this->data['op'],
				'cl' 			=> $this->data['cl'],
				'entries'		=> $this->data['entries'],
				'entri'		    => $this->data['entri'],
				'current_op' 	=> $this->data['current_op'],
				'allTags' 	=> $this->data['allTags'],
			);
		}
	}

	// Export Functions for Ledger Statement
	public function export_ledgerstatement($type = 'xls', $id) {
		
		$data = $this->ledgerstatement(false, $id);
		extract($data);

        if ($showEntries) {
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
			
            $this->excel->getActiveSheet()->setTitle(lang('ledgerstatement'));

            $this->excel->getActiveSheet()->SetCellValue('A1', $subtitle);
            $this->excel->getActiveSheet()->mergeCells('A1:H1');


           $this->excel->getActiveSheet()->SetCellValue('A2', lang('ledgers_views_add_label_bank_cash_account'));
            $this->excel->getActiveSheet()->mergeCells('A2:B2');
			$this->excel->getActiveSheet()->SetCellValue('A3', lang('ledgers_views_add_label_notes'));

            $this->excel->getActiveSheet()->SetCellValue('C2', ($ledger_data['type'] == 1) ? lang('yes') : lang('no'));
            $this->excel->getActiveSheet()->SetCellValue('C3', $ledger_data['notes']);


            $this->excel->getActiveSheet()->SetCellValue('E2', $opening_title);
            $this->excel->getActiveSheet()->mergeCells('E2:G2');

            $this->excel->getActiveSheet()->SetCellValue('H2', $this->functionscore->toCurrency($op['dc'], $op['amount']));
            $this->excel->getActiveSheet()->SetCellValue('E3', $closing_title);
            $this->excel->getActiveSheet()->mergeCells('E3:G3');

            $this->excel->getActiveSheet()->SetCellValue('H3', $this->functionscore->toCurrency($cl['dc'], $cl['amount']));


            $this->excel->getActiveSheet()->SetCellValue('A5', lang('date'));
            $this->excel->getActiveSheet()->SetCellValue('B5', lang('number'));
            $this->excel->getActiveSheet()->SetCellValue('C5', lang('description'));
            $this->excel->getActiveSheet()->SetCellValue('D5', lang('type'));
            $this->excel->getActiveSheet()->SetCellValue('E5', lang('tag') );
            $this->excel->getActiveSheet()->SetCellValue('F5', lang('dr_amount') );
            $this->excel->getActiveSheet()->SetCellValue('G5', lang('cr_amount') );
            $this->excel->getActiveSheet()->SetCellValue('H5', lang('balance') );

            $entry_balance['amount'] = $current_op['amount'];
			$entry_balance['dc'] = $current_op['dc'];

		 	$this->excel->getActiveSheet()->SetCellValue('A6', lang('curr_opening_balance'));
            $this->excel->getActiveSheet()->mergeCells('A6:G6');
            $this->excel->getActiveSheet()->SetCellValue('H6', $this->functionscore->toCurrency($current_op['dc'], $current_op['amount']));
			
            $row = 7;
            foreach ($entri as $entry) {
                $ir = $row + 1;
                if ($ir % 2 == 0) {
                    $style_header = array(                  
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb'=>'CCCCCC'),
                        ),
                    );
                    $this->excel->getActiveSheet()->getStyle("A$row:H$row")->applyFromArray( $style_header );
                }
				/* Calculate current entry balance */
				$entry_balance = $this->functionscore->calculate_withdc(
					$entry_balance['amount'], $entry_balance['dc'],
					$entry['amount'], $entry['dc']
				);

				$et = $this->DB1->where('id', $entry['entrytype_id'])->get('entrytypes')->row_array();
				$entryTypeName = $et['name'];
				$entryTypeLabel = $et['label'];


                $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->functionscore->dateFromSql($entry['date']));
                $this->excel->getActiveSheet()->SetCellValue('B' . $row, $this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id']));
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $entry['narration']);
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $entryTypeName);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->settings_model->getTagNameByID($entry['tag_id']));
                
                if ($entry['dc'] == 'D') {
                	$this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->functionscore->toCurrency('D', $entry['amount']));
				} else if ($entry['dc'] == 'C') {
                	$this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->functionscore->toCurrency('C', $entry['amount']));
				} else {
                	$this->excel->getActiveSheet()->SetCellValue('F' . $row, lang('error'));
                	$this->excel->getActiveSheet()->SetCellValue('G' . $row, lang('error'));
				}

                $this->excel->getActiveSheet()->SetCellValue('H' . $row, $this->functionscore->toCurrency($entry_balance['dc'], $entry_balance['amount']));
                $row++;
            }
            $style_header = array(                  
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb'=>'fdbf2d'),
                ),
            );


            $this->excel->getActiveSheet()->getStyle("A$row:H$row")->applyFromArray( $style_header );
            $this->excel->getActiveSheet()->getStyle("A6:H6")->applyFromArray( $style_header );


		 	$this->excel->getActiveSheet()->SetCellValue("A$row", lang('curr_closing_balance'));
            $this->excel->getActiveSheet()->mergeCells("A$row:G$row");
            $this->excel->getActiveSheet()->SetCellValue("H$row", $this->functionscore->toCurrency($cl['dc'], $cl['amount']));


            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
           
            $filename = 'ledgerstatement';
            $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
            $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            $header = 'A1:H1';
            $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
            
            $titles = 'A5:H5';
            $this->excel->getActiveSheet()->getStyle($titles)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($titles)->applyFromArray($style);
            

            $header = 'A2:H3';
            $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('fdbf2d');
            $style = array(
                'font' => array('bold' => true,),
            );
            $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);


            if ($type=='pdf') {

            	$name = 'Ledger Statement.pdf';

				$this->load->view('reports/pdf/ledgerstatement', $this->data);
				
	            // $html = $this->load->view('reports/pdf/ledgerstatement', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
	            // $this->functionscore->generate_pdf($html, $name);


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

	/**
	*	ledgerentries method
	*
	*	@return void
	**/
	public function ledgerentries($show = true, $ledgerId = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_ledgerentries');
		$this->data['title'] = lang('page_title_reports_ledgerentries');


		/* Create list of ledgers to pass to view */
		$ledgers = new LedgerTree();
		$ledgers->Group = &$this->Group;
		$ledgers->Ledger = &$this->Ledger;
		$ledgers->current_id = -1;
		$ledgers->restriction_bankcash = 1;
		$ledgers->build(0);
		$ledgers->toList($ledgers, -1);
		
		$this->data['ledgers'] = $ledgers->ledgerList;

		if ($this->input->method() == 'post') {
			if ($show === 'ajax' && empty($this->input->post('ledger_id'))) {
				return $this->functionscore->send_json(array('id' => $ledgerId, 'status' => 'error', 'msg' => lang('invalid_ledger')));
			}

			if (empty($this->input->post('ledger_id'))) {
				$this->session->set_flashdata('error', lang('invalid_ledger'));
				redirect('reports/ledgerentries');
			}
			$ledgerId = $this->input->post('ledger_id');

			
		}
		$this->data['showEntries'] = false;
		// $this->data['options'] = false;

		
		if ($ledgerId) {
			/* Check if ledger exists */
			$this->DB1->where('id', $ledgerId);
			$ledger = $this->DB1->get('ledgers')->row_array();

			if (!$ledger) {
				$this->session->set_flashdata('error', lang('ledger_not_found'));
				redirect('reports/ledgerentries');
			}

			$this->data['ledger_data'] = $ledger;

			/* Set the approprite search conditions */
			$conditions = array();
			

			/* Set the approprite search conditions if custom date is selected */
			$startdate = null;
			$enddate = null;

			// $this->data['options'] = true;

			if (!empty($this->input->post('startdate'))) {
				/* TODO : Validate date */
				$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
				$conditions['entries.date >='] = $startdate;
			}

			if (!empty($this->input->post('enddate'))) {
				/* TODO : Validate date */
				$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
				$conditions['entries.date <='] = $enddate;
			}

			/* Sub-title*/
			if (!empty($this->input->post('startdate')) && !empty($this->input->post('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate')))
				);
				$this->data['startdate'] = $this->input->post('startdate');
				$this->data['enddate'] = $this->input->post('enddate');
			} else if (!empty($this->input->post('startdate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
				$this->data['startdate'] = $this->input->post('startdate');
				
			} else if (!empty($this->input->post('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->input->post('enddate'))
				);
				$this->data['enddate'] = $this->input->post('enddate');
			} else {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}

			/* Opening and closing titles */
			if (is_null($startdate)) {
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start));
			} else {
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
					$this->functionscore->dateFromSql($startdate));
			}
			if (is_null($enddate)) {
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end));
			} else {
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
					$this->functionscore->dateFromSql($enddate));
			}

			/* Calculating opening balance */
			$op = $this->ledger_model->openingBalance($ledgerId, $startdate);
			$this->data['op'] = $op;

			/* Calculating closing balance */
			$cl = $this->ledger_model->closingBalance($ledgerId, null, $enddate);
			$this->data['cl'] = $cl;

			/* Calculate current page opening balance */
			$current_op = $op;
			$kondisi = array();

			if (!empty($this->input->get('startdate'))) {
				$awal = $this->functionscore->dateToSql($this->input->get('startdate'));
				$kondisi['entries.date >='] = $awal;
			}
			if (!empty($this->input->get('enddate'))) {
				$akhir = $this->functionscore->dateToSql($this->input->get('enddate'));
				$kondisi['entries.date <='] = $akhir;
			}
			$this->DB1->select('entries.date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total as dr_total, entries.cr_total as cr_total, entrytypes.label as entryTypeLabel, entries.entrytype_id as entrytype_id')->where($kondisi)->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left');
			
			$this->data['entries'] = $this->DB1->get('entries')->result_array();

			/* Set the current page opening balance */
			$this->data['current_op'] = $current_op;

			/* Pass varaibles to view which are used in Helpers */
			$this->data['allTags'] = $this->DB1->get('tags')->result_array();
			$this->data['showEntries'] = true;
		}

		if ($show === 'false') {
			/* Sub-title*/
			if (!empty($this->input->get('startdate')) && !empty($this->input->get('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('startdate'))),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('enddate')))
				);
				$this->data['startdate'] = $this->input->get('startdate');
				$this->data['enddate'] = $this->input->get('enddate');
			} else if (!empty($this->input->get('startdate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->get('startdate'))),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
				$this->data['startdate'] = $this->input->get('startdate');
				
			} else if (!empty($this->input->get('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->input->get('enddate'))
				);
				$this->data['enddate'] = $this->input->get('enddate');
			}else{
				$this->data['subtitle'] = sprintf(lang('ledger_entries_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}
        	$name = 'Ledger Entries.pdf';

			// $this->load->view('reports/pdf/ledgerentries', $this->data);
			
            $html = $this->load->view('reports/pdf/ledgerentries', $this->data, TRUE, NULL, NULL, NULL, NULL, 'L');
            $this->functionscore->generate_pdf($html, $name);
		}

		if ($show === true) {
			// render page
			$this->render('reports/ledgerentries');
		} else if ($show === 'ajax') {
			$opening_balance = $this->functionscore->toCurrency($this->data['op']['dc'], $this->data['op']['amount']);
			$closing_balance = $this->functionscore->toCurrency($this->data['cl']['dc'], $this->data['cl']['amount']);

			$startDate = (isset($this->data['startdate']) ? $this->data['startdate'] : null);
			$endDate = (isset($this->data['enddate']) ? $this->data['enddate'] : null);

			$ajax_data = array(
				'id' 				=> 1,
				'showEntries' 		=> $this->data['showEntries'],
				'ledger_data' 		=> $this->data['ledger_data'],
				'subtitle' 			=> $this->data['subtitle'],
				'opening_title' 	=> $this->data['opening_title'],
				'closing_title' 	=> $this->data['closing_title'],
				'op' 				=> $this->data['op'],
				'cl' 				=> $this->data['cl'],
				'opening_balance'	=> $opening_balance,
				'current_op' 		=> $this->data['current_op'],
				'closing_balance' 	=> $closing_balance,
				'startDate' 		=> $startDate,
				'endDate' 			=> $endDate,
			);
			return $this->functionscore->send_json($ajax_data);
		} else {
			return array(
				'ledgers' 	=> $this->data['ledgers'],
				'showEntries' => $this->data['showEntries'],
				'ledger_data' => $this->data['ledger_data'],
				'subtitle' 	=> $this->data['subtitle'],
				'opening_title' => $this->data['opening_title'],
				'closing_title' => $this->data['closing_title'],
				'op' 			=> $this->data['op'],
				'cl' 			=> $this->data['cl'],
				'entries'		=> $this->data['entries'],
				'current_op' 	=> $this->data['current_op'],
				'allTags' 	=> $this->data['allTags'],
			);
		}
	}

	// Export Functions for Ledger Entries
	public function export_ledgerentries($type = 'xls', $id) {
		$data = $this->ledgerentries(false, $id);
		extract($data);
        if ($showEntries) {
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
			
            $this->excel->getActiveSheet()->setTitle(lang('ledgerentries'));

            $this->excel->getActiveSheet()->SetCellValue('A2', $subtitle);
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->SetCellValue('A4', lang('date'));
            $this->excel->getActiveSheet()->SetCellValue('B4', lang('number'));
            $this->excel->getActiveSheet()->SetCellValue('C4', lang('ledger'));
            $this->excel->getActiveSheet()->SetCellValue('D4', lang('type'));
            $this->excel->getActiveSheet()->SetCellValue('E4', lang('tag') );
            $this->excel->getActiveSheet()->SetCellValue('F4', lang('dr_amount') );
            $this->excel->getActiveSheet()->SetCellValue('G4', lang('cr_amount') );

		 
            $row = 5;
            foreach ($entries as $entry) {
                $ir = $row + 1;
                if ($ir % 2 == 0) {
                    $style_header = array(                  
                        'fill' => array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb'=>'CCCCCC'),
                        ),
                    );
                    $this->excel->getActiveSheet()->getStyle("A$row:G$row")->applyFromArray( $style_header );
                }
				
				$et = $this->DB1->where('id', $entry['entrytype_id'])->get('entrytypes')->row_array();
				$entryTypeName = $et['name'];
				$entryTypeLabel = $et['label'];
                $this->excel->getActiveSheet()->SetCellValue('A' . $row, $this->functionscore->dateFromSql($entry['date']));
                $this->excel->getActiveSheet()->SetCellValue('B' . $row, $this->functionscore->toEntryNumber($entry['number'], $entry['entrytype_id']));
                $this->excel->getActiveSheet()->SetCellValue('C' . $row, $this->functionscore->namaAkun($entry['id']));
                $this->excel->getActiveSheet()->SetCellValue('D' . $row, $entryTypeName);
                $this->excel->getActiveSheet()->SetCellValue('E' . $row, $this->settings_model->getTagNameByID($entry['tag_id']));
                $this->excel->getActiveSheet()->SetCellValue('F' . $row, $this->functionscore->toCurrency('', $entry['dr_total']));
				$this->excel->getActiveSheet()->SetCellValue('G' . $row, $this->functionscore->toCurrency('', $entry['cr_total']));
                $row++;
            }
            $style_header = array(                  
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb'=>'fdbf2d'),
                ),
            );


            $this->excel->getActiveSheet()->getStyle("A$row:G$row")->applyFromArray( $style_header );
       
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
           
            $filename = 'ledgerentries';
            $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
            $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            $header = 'A1:G1';
            $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
            
            $titles = 'A4:G4';
            $this->excel->getActiveSheet()->getStyle($titles)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('94ce58');
            $style = array(
                'font' => array('bold' => true,),
                'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            );
            $this->excel->getActiveSheet()->getStyle($titles)->applyFromArray($style);
            

            $header = 'A2:G3';
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

	/**
	*	reconciliation method
	*
	*	@return void
	**/
	public function reconciliation($show = true, $ledgerId = NULL) {
		// set page title
		$this->mPageTitle = lang('page_title_reports_reconciliation');
		$this->data['title'] = lang('page_title_reports_reconciliation');
		
		/* Create list of ledgers to pass to view */
		$this->DB1->where('ledgers.reconciliation', 1);
		$this->DB1->order_by('ledgers.name', 'asc');
		$this->DB1->select('ledgers.id, ledgers.name, ledgers.code');
		$ledgers_q = $this->DB1->get('ledgers')->result_array();

		if($ledgers_q) {
			$ledgers = array(0 => lang('please_select_ledger'));
			foreach ($ledgers_q as $row) {
				$ledgers[$row['id']] = $this->functionscore->toCodeWithName(
					$row['code'], $row['name']
				);
			}
		} else {
			$ledgers = array(0 => lang('no_reconciled_ledgers_found'));
		}

		$this->data['ledgers'] = $ledgers;

		if ($this->input->method() == 'post' && $show !== 'ajax') {
			/* Ledger selection form submitted */
			if (!empty($this->input->post('submit_ledger'))) {
				if (empty($this->input->post('ledger_id'))) {
					$this->session->set_flashdata('error', lang('invalid_ledger'));
					redirect('reports/reconciliation');
				}
			} else if (!empty($this->input->post('submitrec'))) {
				/* Check if acccount is locked */
				if ($this->mAccountSettings->account_locked == 1) {
					$this->session->set_flashdata('error', lang('groups_cntrler_edit_account_locked_error'));
					redirect('reports/reconciliation');
				}

				/* Reconciliation form submitted */
				foreach ($this->input->post('ReportRec[]') as $row => $recitem) {
					if (empty($recitem['id'])) {
						continue;
					}
					if (!empty($recitem['recdate'])) {
						$recdate = $this->functionscore->dateToSql($recitem['recdate']);
						if (!$recdate) {
							$this->session->set_flashdata('error', lang('invalid_reconciliation_date'));
							continue;
						}
					} else {
						$recdate = NULL;
					}
					$this->DB1->where('id', $recitem['id']);
					$this->DB1->update('entryitems', array('reconciliation_date'=>$recdate));
				}

				$this->session->set_flashdata('message', lang('reconciliation_successs'));
				redirect('reports/reconciliation');
			} else {
				redirect('reports/reconciliation');
			}
		}

		$this->data['showEntries'] = false;
		// $this->data['options'] = false;

		/* Set the approprite search conditions if custom date is selected */
		$startdate = null;
		$enddate = null;

		if ($this->input->method() == 'post') {
			$ledgerId = $this->input->post('ledger_id');

			if ($show === 'ajax' && $ledgerId == 0) {
				return $this->functionscore->send_json(array('id' => $ledgerId, 'status' => 'error', 'msg' => lang('invalid_ledger')));
			}

			/* Check if ledger exists */
			$this->DB1->where('id', $ledgerId);
			$ledger = $this->DB1->from('ledgers')->get()->row_array();

			if (!$ledger) {
				$this->session->set_flashdata('error', lang('ledger_not_found'));
				redirect('reports/reconciliation');
			}

			$this->data['ledger_data'] = $ledger;

			/* Set the approprite search conditions */
			// $conditions = array();
			// $conditions['entryitems.ledger_id'] = $ledgerId;
			// $this->data['options'] = true;
			
			if (!empty($this->input->post('startdate'))) {
				/* TODO : Validate date */
				$startdate = $this->functionscore->dateToSql($this->input->post('startdate'));
				// $conditions['entries.date >='] = $startdate;
			}

			if (!empty($this->input->post('enddate'))) {
				/* TODO : Validate date */
				$enddate = $this->functionscore->dateToSql($this->input->post('enddate'));
				// $conditions['entries.date <='] = $enddate;
			}

			/* Sub-title*/
			if (!empty($this->input->post('startdate')) && !empty($this->input->post('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('reconciliation_for_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate')))
				);
				$this->data['startdate'] = $this->input->post('startdate');
				$this->data['enddate'] = $this->input->post('enddate');
			} else if (!empty($this->input->post('startdate'))) {
				$this->data['subtitle'] = sprintf(lang('reconciliation_for_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
				$this->data['startdate'] = $this->input->post('startdate');
			} else if (!empty($this->input->post('enddate'))) {
				$this->data['subtitle'] = sprintf(lang('reconciliation_for_from_to'),
					($ledger['name']),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->input->post('enddate'))
				);
				$this->data['enddate'] = $this->input->post('enddate');
			} else {
				$this->data['subtitle'] = sprintf(lang('reconciliation_for_from_to'),
					($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}

			// if (empty($this->input->post('showall')) || $this->input->post('showall') == '0') {
			// 	$conditions['entryitems.reconciliation_date'] = NULL;
			// 	$this->data['showall'] = null;
			// } else {
			// 	$this->data['showall'] = $this->input->post('showall');
			// }

			/* Opening and closing titles */
			if (is_null($startdate)) {
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
				$this->functionscore->dateFromSql($this->mAccountSettings->fy_start));
			} else {
				$this->data['opening_title'] = sprintf(lang('opening_balance_as_on'),
				$this->functionscore->dateFromSql($startdate));
			}

			if (is_null($enddate)) {
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
				$this->functionscore->dateFromSql($this->mAccountSettings->fy_end));

			} else {
				$this->data['closing_title'] = sprintf(lang('closing_balance_as_on'),
				$this->functionscore->dateFromSql($enddate));
			}

			/* Reconciliation pending title */
			$this->data['recpending_title'] = '';

			/* Sub-title*/
			if (!is_null($startdate) && !is_null($enddate)) {
				$this->data['recpending_title'] = sprintf(lang('reconciliation_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('enddate')))
				);
			} else if (!is_null($this->input->post('startdate'))) {
				$this->data['recpending_title'] = sprintf(lang('reconciliation_from_to'),
					$this->functionscore->dateFromSql($this->functionscore->dateToSql($this->input->post('startdate'))),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			} else if (!is_null($this->input->post('enddate'))) {
				$this->data['recpending_title'] = sprintf(lang('reconciliation_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->input->post('enddate'))
				);
			}else{
				$this->data['recpending_title'] = sprintf(lang('reconciliation_from_to'),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_start),
					$this->functionscore->dateFromSql($this->mAccountSettings->fy_end)
				);
			}
			
			/* Calculating opening balance */
			$op = $this->ledger_model->openingBalance($ledgerId, $startdate);
			$this->data['op'] = $op;

			/* Calculating closing balance */
			$cl = $this->ledger_model->closingBalance($ledgerId, null, $enddate);
			$this->data['cl'] = $cl;

			/* Calculating reconciliation pending balance */
			$rp = $this->ledger_model->reconciliationPending($ledgerId, $startdate, $enddate);
			$this->data['rp'] = $rp;

			// $this->DB1->where($conditions)->select('entryitems.id as eiid, entries.id , entries.tag_id, entries.entrytype_id, entries.number, entries.date, entries.dr_total, entries.cr_total, entryitems.narration, entryitems.entry_id, entryitems.ledger_id, entryitems.amount, entryitems.dc, entryitems.reconciliation_date')->join('entryitems', 'entries.id = entryitems.entry_id', 'left')->order_by('entries.date', 'asc');
			// $this->data['entries'] = $this->DB1->get('entries')->result_array();

			/* Pass varaibles to view which are used in Helpers */
			$this->data['allTags'] = $this->DB1->get('tags')->result_array();
			$this->data['showEntries'] = true;
		}

		if ($show === true) {
			// render page
			$this->render('reports/reconciliation');
		} else if ($show === 'ajax') {
			$recpending_balance_d = $this->functionscore->toCurrency('D', $this->data['rp']['dr_total']);
			$recpending_balance_c = $this->functionscore->toCurrency('C', $this->data['rp']['cr_total']);

			$opening_balance = $this->functionscore->toCurrency($this->data['op']['dc'], $this->data['op']['amount']);
			$closing_balance = $this->functionscore->toCurrency($this->data['cl']['dc'], $this->data['cl']['amount']);

			$startDate = (isset($this->data['startdate']) ? $this->data['startdate'] : null);
			$endDate = (isset($this->data['enddate']) ? $this->data['enddate'] : null);

			$ajax_data = array(
				'id' 					=> 1,
				'showEntries' 			=> $this->data['showEntries'],
				'ledger_data' 			=> $this->data['ledger_data'],
				'subtitle' 				=> $this->data['subtitle'],
				'opening_title' 		=> $this->data['opening_title'],
				'closing_title' 		=> $this->data['closing_title'],
				'op' 					=> $this->data['op'],
				'cl' 					=> $this->data['cl'],
				'rp' 					=> $this->data['rp'],
				'recpending_title'		=> $this->data['recpending_title'],
				// 'showall' 				=> $this->data['showall'],
				'recpending_balance_d'	=> $recpending_balance_d,
				'recpending_balance_c' 	=> $recpending_balance_c,
				'opening_balance'		=> $opening_balance,
				'closing_balance' 		=> $closing_balance,
				'startDate' 			=> $startDate,
				'endDate' 				=> $endDate,
			);
			return $this->functionscore->send_json($ajax_data);
		} else {
			return false;
			// return array(
			// 	'ledgers' 	=> $this->data['ledgers'],
			// 	'showEntries' => $this->data['showEntries'],
			// 	'ledger_data' => $this->data['ledger_data'],
			// 	'subtitle' 	=> $this->data['subtitle'],
			// 	'opening_title' => $this->data['opening_title'],
			// 	'closing_title' => $this->data['closing_title'],
			// 	'op' 			=> $this->data['op'],
			// 	'cl' 			=> $this->data['cl'],
			// 	'entries'		=> $this->data['entries'],
			// 	'current_op' 	=> $this->data['current_op'],
			// 	'allTags' 	=> $this->data['allTags'],
			// );
		}
	}

	// Search Entries Functions for Datatables
	public function getSearchedEntries($type) {
		if ($type === 'ledgerentries') {
			$ledgerId = $_POST['form_data']['id'];
			$startDate = $_POST['form_data']['startDate'];
			$endDate = $_POST['form_data']['endDate'];
		
			if ($ledgerId) {
				$this->load->helper('general');
				$this->load->library('datatables');

				/* Set the approprite search conditions */
				$conditions = array();
				

				/* Set the approprite search conditions if custom date is selected */
				$startdate = null;
				$enddate = null;

				if (!empty($startDate)) {
					/* TODO : Validate date */
					$startdate = $this->functionscore->dateToSql($startDate);
					$conditions['entries.date >='] = $startdate;
				}

				if (!empty($endDate)) {
					/* TODO : Validate date */
					$enddate = $this->functionscore->dateToSql($endDate);
					$conditions['entries.date <='] = $enddate;
				}

				$this->datatables->where($conditions)
				->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total as dr_total, entries.cr_total as cr_total, entrytypes.label as entryTypeLabel, entries.entrytype_id as entrytype_id')
				
				->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
				->from('entries')
				->edit_column("date", "$1", "getDateFromSql(date)")
				->edit_column("number", "$1", "getToEntryNumber(number, entrytype_id)")
				->edit_column("id", "$1", "getEntryLedgers(id)")
				->edit_column("tag_id", "$1", "getShowTag(tag_id)")
				->edit_column("dr_total", "$1", "getToCurrencyForEntries('', dr_total)")
				->edit_column("cr_total", "$1", "getToCurrencyForEntries('', cr_total)")
				->add_column("Actions", '
					<a href="'.base_url().'entries/view/$2/$1" style="padding-right: 5px;" title="'.lang('view').'" data-toggle="tooltip">
						<i class="glyphicon glyphicon-log-in"></i>
					</a>
					<a href="'.base_url().'entries/edit/$2/$1" style="padding-right: 1px;" title="'.lang('edit').'" data-toggle="tooltip">
						<i class="glyphicon glyphicon-edit"></i>
					</a>
					<a href="'.base_url().'entries/delete/$2/$1" title="'.lang('delete').'" data-toggle="tooltip">
					<i class="glyphicon glyphicon-trash"></i>
					</a>'
					, "id, entryTypeLabel");

				$this->datatables->unset_column('entrytype_id');
				$this->datatables->unset_column('amount');
				$this->datatables->unset_column('dc');
				$this->datatables->unset_column('entryTypeLabel');

		        echo $this->datatables->generate();
			}
		}

		if ($type === 'reconciliation') {
			$ledgerId = $_POST['form_data']['id'];
			$startDate = $_POST['form_data']['startDate'];
			$endDate = $_POST['form_data']['endDate'];
			$showall = $_POST['form_data']['showall'];

			if ($ledgerId) {
				$this->load->helper('general');
				$this->load->library('datatables');

				/* Set the approprite search conditions */
				$conditions = array();
				$conditions['entryitems.ledger_id'] = $ledgerId;

				/* Set the approprite search conditions if custom date is selected */
				$startdate = null;
				$enddate = null;

				if (!empty($startDate)) {
					/* TODO : Validate date */
					$startdate = $this->functionscore->dateToSql($startDate);
					$conditions['entries.date >='] = $startdate;
				}

				if (!empty($endDate)) {
					/* TODO : Validate date */
					$enddate = $this->functionscore->dateToSql($endDate);
					$conditions['entries.date <='] = $enddate;
				}

				if ($showall != '1') {
					$conditions['entryitems.reconciliation_date'] = NULL;
				}

				$this->datatables->where($conditions)
				->select('entries.date as date, entries.number as number, entries.id as id, entrytypes.name as entryTypeName, entries.tag_id as tag_id, entries.dr_total, entries.cr_total, entryitems.amount, entryitems.id as eiid, entries.entrytype_id as entrytype_id, entrytypes.label as entryTypeLabel, entryitems.reconciliation_date as reconciliation_date')
				->join('entryitems', 'entries.id = entryitems.entry_id', 'left')
				->join('entrytypes', 'entries.entrytype_id = entrytypes.id', 'left')
				->from('entries')
				->edit_column("date", "$1", "getDateFromSql(date)")
				->edit_column("number", "$1", "getToEntryNumber(number, entrytype_id)")
				->edit_column("id", "$1", "getEntryLedgers(id)")
				->edit_column("tag_id", "$1", "getShowTag(tag_id)")
				->edit_column("dr_total", "$1", "getToCurrency('D', amount)")
				->edit_column("cr_total", "$1", "getToCurrency('C', amount)")
				->add_column("RecDate", '$1__$2__$3', "id, eiid, reconciliation_date");
				// ->add_column("RecDate", '<input type="hidden" name="ReportRec[$1][id]" value="$2"><input type="text" name="ReportRec[$1][recdate]" value="$3" class="recdate">', "id, eiid, reconciliation_date");

				$this->datatables->unset_column('entrytype_id');
				$this->datatables->unset_column('amount');
				$this->datatables->unset_column('eiid');
				$this->datatables->unset_column('entryTypeLabel');
				$this->datatables->unset_column('reconciliation_date');

		        echo $this->datatables->generate();
		    }
		}
	}

	function account_st_short($account, $c = 0, $THIS, $dc_type) {
		$counter = $c;
		if ($account->id > 4) {
			if ($dc_type == 'D' && $account->cl_total_dc == 'C' && $this->functionscore->calculate($account->cl_total, 0, '!=')) {
				$header = 'A'.$this->row.':B'.$this->row;
			    $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff3300');
			    $style = array(
			        'font' => array('bold' => true,),
			    );
			    $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
			} else if ($dc_type == 'C' && $account->cl_total_dc == 'D' && $this->functionscore->calculate($account->cl_total, 0, '!=')) {
				$header = 'A'.$this->row.':B'.$this->row;
			    $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff3300');
			    $style = array(
			        'font' => array('bold' => true,),
			    );
			    $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
			} else {
				
			}

			// Name of Account
    		$this->excel->getActiveSheet()->SetCellValue('A'.$this->row, $this->print_space($counter) . $this->functionscore->toCodeWithName($account->code, $account->name));

			// Amount in Account
    		$this->excel->getActiveSheet()->SetCellValue('B'.$this->row, $this->functionscore->toCurrency($account->cl_total_dc, $account->cl_total));
    		$this->row++;
		}

		foreach ($account->children_groups as $id => $data) {
			$counter++;
			$this->account_st_short($data, $counter, $THIS, $dc_type);
			$counter--;
		}

		if (count($account->children_ledgers) > 0) {
			$counter++;
			foreach ($account->children_ledgers as $id => $data) {
				
				if ($dc_type == 'D' && $data['cl_total_dc'] == 'C' && $this->functionscore->calculate($data['cl_total'], 0, '!=')) {
					$header = 'A'.$this->row.':B'.$this->row;
				    $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff3300');
				    $style = array(
				        'font' => array('bold' => true,),
				    );
				    $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
				} else if ($dc_type == 'C' && $data['cl_total_dc'] == 'D' && $this->functionscore->calculate($data['cl_total'], 0, '!=')) {
					$header = 'A'.$this->row.':B'.$this->row;
				    $this->excel->getActiveSheet()->getStyle($header)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ff3300');
				    $style = array(
				        'font' => array('bold' => true,),
				    );
				    $this->excel->getActiveSheet()->getStyle($header)->applyFromArray($style);
				} else {
					
				}

				// Name of Account
	    		$this->excel->getActiveSheet()->SetCellValue('A'.$this->row, $this->print_space($counter) . $this->functionscore->toCodeWithName($data['code'], $data['name']));

				// Amount in Account
	    		$this->excel->getActiveSheet()->SetCellValue('B'.$this->row, $this->functionscore->toCurrency($data['cl_total_dc'], $data['cl_total']));
				$this->row++;
			}
			$counter--;
		}
	}

	function print_space($count) {
		$html = '';
		for ($i = 1; $i <= $count; $i++) {
			$html .= '      ';
		}
		return $html;
	}

	// public function statement_cashflow() {
	// 	// set page title
	// 	$this->mPageTitle = 'Statement of Cashflow';
	// 	$this->data['title'] = 'Statement of Cashflow';

	// }
}
