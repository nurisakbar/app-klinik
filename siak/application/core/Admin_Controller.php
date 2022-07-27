<?php
/*
 * Base Controller for Admin module
 */
class Admin_Controller extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		/* check if user is logged in */
		if ($this->verify_login($this->mUri) !== true) {
			/* set flash data warning */
			$this->session->set_flashdata('warning', lang('login_to_continue'));
			redirect($this->verify_login($this->mUri));
		}

		/* Check if an account is active or not */
		if (!$this->verify_active_account()) {
			/* set flash data error */
			if ($this->mCtrler !== 'admin' && $this->mCtrler !== 'user') {
				$this->session->set_flashdata('error', lang('activate_account_to_continue'));
				redirect('user/activate');
			}
		}
		
		/* If account/year is active */
		if ($this->verify_active_account()) {
			/* Load active account database [i.e. "DB1"] */
			$this->DB1 = $this->load->database($_SESSION['active_account_config'], TRUE);

			/* Get active account settings from DB1 - [settings] table */
			$this->mAccountSettings = $this->DB1->get('settings')->row();
			$this->mAccountSettings->decimals_sep = '.';
			$this->mAccountSettings->thousands_sep = ',';
			$this->data['account_settings'] = $this->mAccountSettings;

			/* Active account date format from DB1 - [settings] table */
			$this->mDateArray = explode('|', $this->mAccountSettings->date_format);
			/* get active account log if logging enabled and uri is "accounts/log" or dashboard/index */
			$this->data['logs'] = array();

			if ($this->mViewLog && ($this->mUri === 'accounts/log' || $this->mUri === 'dashboard/index')) {
				if ($this->mUri === 'dashboard/index') {
					$this->DB1->limit(25);
				}
				/* fetch activity log of active account from DB1 - [logs] table in desending order and pass to view */
				$this->DB1->order_by('date', 'desc');
				$logs = $this->DB1->get('logs')->result_array();
				$this->data['logs'] = $logs;
			}

		}
	}
}

