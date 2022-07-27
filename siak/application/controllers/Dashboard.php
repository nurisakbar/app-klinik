<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('reports_model');
    }   
    
	public function index() {
		/* Cash and bank sumary */
		$ledgers = $this->DB1->where('type', 1)->get('ledgers')->result_array();
		$ledgersCB = array();
		foreach ($ledgers as $ledger) {
			$ledgersCB[] = array(
				// 'name' => ($this->functionscore->toCodeWithName($ledger['code'], $ledger['name'])),
				'name' => $ledger['name'],
				'code' => $ledger['code'],
				'balance' => $this->ledger_model->closingBalance($ledger['id']),
			);
		}
		$this->data['ledgers'] = $ledgersCB;
		$this->load->library('AccountList');
		/* Account summary */
		$assets = new AccountList();
		$assets->Group = &$this->Group;
		$assets->Ledger = &$this->Ledger;
		$assets->only_opening = false;
		$assets->start_date = null;
		$assets->end_date = null;
		$assets->affects_gross = -1;
		$assets->start(1);

		$liabilities = new AccountList();
		$liabilities->Group = &$this->Group;
		$liabilities->Ledger = &$this->Ledger;
		$liabilities->only_opening = false;
		$liabilities->start_date = null;
		$liabilities->end_date = null;
		$liabilities->affects_gross = -1;
		$liabilities->start(2);

		$income = new AccountList();
		$income->Group = &$this->Group;
		$income->Ledger = &$this->Ledger;
		$income->only_opening = false;
		$income->start_date = null;
		$income->end_date = null;
		$income->affects_gross = -1;
		$income->start(3);

		$expense = new AccountList();
		$expense->Group = &$this->Group;
		$expense->Ledger = &$this->Ledger;
		$expense->only_opening = false;
		$expense->start_date = null;
		$expense->end_date = null;
		$expense->affects_gross = -1;
		$expense->start(4);



		$accsummary = array(
			'assets_total_dc' => $assets->cl_total_dc,
			'assets_total' => $assets->cl_total,
			'liabilities_total_dc' => $liabilities->cl_total_dc,
			'liabilities_total' => $liabilities->cl_total,
			'income_total_dc' => $income->cl_total_dc,
			'income_total' => $income->cl_total,
			'expense_total_dc' => $expense->cl_total_dc,
			'expense_total' => $expense->cl_total,
		);
		$this->data['accsummary'] = $accsummary;

		// render page
		$this->render('user/dashboard');
	}

		public function getIncomeExpenseMonthlyChart() {

		$income = $this->reports_model->getTotalMonthly(3);
		$expense = $this->reports_model->getTotalMonthly(4);
		
		$total_income = 0;
		$total_expense = 0;

		if ($income) {
			foreach ($income as $in) {
				$total_income += $in; 
			}
		} else {
			$income = array(
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
			);
		}
		
		if ($expense) {
			foreach ($expense as $ex) {
				$total_expense += $ex; 
			}
		} else {
			$expense = array(
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
				0,
			);
		}

		$net_worth = $this->functionscore->calculate($total_income, $total_expense, '-');

		$today_income = $this->reports_model->getTotalofToday(3);
		$today_expense = $this->reports_model->getTotalofToday(4);

		$month_income = $this->reports_model->getTotalofThisMonth(3);
		$month_expense = $this->reports_model->getTotalofThisMonth(4);

		$json_ie_stats = array(
			'Income'		=> $income,
			'Expense'		=> $expense,
			'xAxis'			=> $this->reports_model->getTotalMonthly(0),
			'net_worth'		=> $net_worth,
			'today_income'	=> $today_income,
			'today_expense'	=> $today_expense,
			'month_income'	=> $month_income,
			'month_expense'	=> $month_expense
		);				
		$this->functionscore->send_json($json_ie_stats);
	}

	public function getIncomeExpenseChart() {
		$json_ie_stats = array(
			'Income'	=> $this->reports_model->getTotalPeriodical(3),
			'Expense'	=> $this->reports_model->getTotalPeriodical(4),
		);			
		$this->functionscore->send_json($json_ie_stats);
	}
}
