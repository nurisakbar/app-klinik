<?php

class MY_Controller extends CI_Controller {
	
	// Data to pass into views
	protected 	$data = array();		// data array sent to view on render
	protected 	$mBodyClass = NULL; 	// adminlte theme
	public 		$mSettings = NULL;		// basic app settings (done by admin) sqlite db - table -> of_settings
	protected 	$mPageTitle = '';		// page title
	protected 	$mActiveAccountID;		// active account ID from sqlite db - table -> of_accounts
	protected 	$mCtrler = 'home';		// current controller
	protected 	$mAction = 'index';		// controller function being called
	protected 	$mMenu = array();		// sidebar menu array 'children' , 'icons' and 'url'
	protected	$mUri = '';				// current complete URL 'controller/method'
	public		$mDateArray = array();	// Date format array
	protected	$mViewLog = false;		// view log boolean

	// Logged in user data
	protected 	$mPageAuth = array();	// user permission array for every URI under "Accounts" section
	protected 	$mUser = NULL;			// Current logged in user from sqlite db - table -> of_users
	protected	$mGroupPerms = NULL;	// user's group permissions from sqlite db - table -> of_permissions
	
	// MySQL DB
	public 	  	$DB1; 					// mysql db which will be created on every new account
	
	// Constructor
	public function __construct()
	{
		parent::__construct();
		$this->_setup();

	}

	protected function _setup(){

		// load settings_model
		$this->load->model('settings_model');

		// get basic app settings from sqlite db - table -> of_settings
		$this->mSettings = $this->settings_model->getSettings();

		// load language file
		$this->lang->load('main_lang', $this->mSettings->language);

		// set main body class (adminlte theme)
		$this->mBodyClass = 'hold-transition skin-green sidebar-mini fixed';

		// fetch current controller
		$this->mCtrler = $this->router->fetch_class();

		// fetch current method
		$this->mAction = $this->router->fetch_method();

		// current URL
		$this->mUri = $this->mCtrler.'/'.$this->mAction;

		
		// pass basic app settings to view
		$this->data['settings'] = $this->mSettings;				

		// Set active account ID
		$this->mActiveAccountID = ($this->session->userdata('active_account_id')) ? $this->session->userdata('active_account_id') : 0;

		// set page title
		$this->mPageTitle = $this->getPageTitle();

		// if user is logged in (Ion Auth Library)
		if ($this->ion_auth->logged_in()){

			// Check if user is admin
			if (!$this->ion_auth->is_admin())
			{
				if ($this->mCtrler == 'admin' && $this->mAction !== 'updateuserimage') {
					// set flash data
					$this->session->set_flashdata('warning', lang('must_be_an_administrator'));
					if ($this->verify_active_account()) {
						// redirect to accounts dashboard if account is active
						redirect('dashboard');
					}else{
						// redirect to account activation page if account is not active (Inactive)
						redirect('user/activate');
					}
				}
			}

			// get current user from sqlite db - table -> of_users
			$this->mUser = $this->ion_auth->user()->row();

			//fetch and store currently active user(in session)
			$this->session->set_userdata('user', $this->mUser);

			// fetch logged in users group to get the group's permissions and pass to view
			$this->data['user_group'] = $this->ion_auth->get_users_groups()->row();

			// get current user's group permission
			$this->mGroupPerms = $this->settings_model->getGroupPermissions($this->data['user_group']->id);

			//array for page authentication using group permissions ($this->mPageAuth)
			foreach ($this->mGroupPerms as $perm => $value)
			{
				// replace "-" with "/" to check against current URL's
				if (strpos($perm, '-') !== false)
				{
					$perm = str_replace("-", "/", $perm);
					$this->mPageAuth[$perm] = $value;
				}
			}

			if ($this->mActiveAccountID && $this->mSettings->enable_logging) {
				$this->mViewLog = true;
			}
			
			// restrict pages
			$this->verify_auth($this->mPageAuth);

			// initilize mMenu array (all )
			$this->mMenu = array();

			// check if current user is an admin for sidebar 
			if ($this->ion_auth->is_admin()) {
				// set sidebar "Admin" label
				$this->mMenu['label1'] = array(
					'url'		=> '',
					'name'		=> lang('admin'),
				);
				// Admin - Dashboard = sidebar-menu item
				$this->mMenu['admin-home']  = array(
					'name'		=> lang('home'),
					'url'		=> 'admin',
					'icon'		=> 'fa fa-home',
				);
				// Admin - Accounts = sidebar-menu item
				$this->mMenu['admin-accounts']  = array(
					'name'		=> lang('companies'),
					'url'		=> 'admin',
					'icon'		=> 'fa fa-address-book',
					'children'  => array(
						lang('manage')	=> 'accounts',
						lang('create')	=> 'create_account',
					)
				);
				// Admin - Users = sidebar-menu item
				$this->mMenu['admin-users']  = array(
					'name'		=> lang('users'),
					'url'		=> 'admin',
					'icon'		=> 'fa fa-users',
					'children'  => array(
						lang('manage')				=> 'users',
						lang('create')				=> 'create_user',
						lang('groups_permissions')	=> 'groups',
					)
				);
				// Admin - Settings = sidebar-menu item
				$this->mMenu['admin-settings']  = array(
					'name'		=> lang('admin_settings'),
					'url'		=> 'admin/settings',
					'icon'		=> 'fa fa-cogs',
				);
			}
			// set sidebar "Accounts" label
			$this->mMenu['label'] = array(
				'url'		=> '',
				'name'		=> lang('accounts'),
			);
			// Accounts Dashboard = sidebar-menu item
			$this->mMenu['home'] = array(
				'name'		=> lang('home'),
				'url'		=> 'dashboard/index',
				'icon'		=> 'fa fa-home',
			);
			// Chart of Account = sidebar-menu item
			$this->mMenu['accounts'] = array(
				'name'		=> lang('chart_of_accounts'),
				'url'		=> 'accounts/index',
				'icon'		=> 'fa fa-sitemap',
			);
			// Accounts - Entries = sidebar-menu item
			$this->mMenu['entries'] = array(
				'name'		=> lang('entries'),
				'url'		=> 'entries/index',
				'icon'		=> 'fa fa-plus-square-o',
			);
			// Accounts Advance Search = sidebar-menu item
			$this->mMenu['search'] = array(
				'name'		=> lang('search'),
				'url'		=> 'search/index',
				'icon'		=> 'fa fa-search',
			);
			// Accounts Reports = sidebar-menu item
			$this->mMenu['reports'] = array(
				'name'		=> lang('reports'),
				'url'		=> 'reports/index',
				'icon'		=> 'fa fa-bar-chart',
				'children'  => array(
					lang('balancesheet')	=> 'balancesheet',
					lang('profitloss')		=> 'profitloss',
					lang('trialbalance')	=> 'trialbalance',
					lang('ledgerstatement')	=> 'ledgerstatement',
					lang('ledgerentries')	=> 'ledgerentries',
					lang('reconciliation')	=> 'reconciliation',
				)
			);
			// Account Settings = sidebar-menu item
			$this->mMenu['account_settings'] = array(
				'name'		=> lang('account_settings'),
				'url'		=> 'account_settings/index',
				'icon'		=> 'fa fa-cog',
				'children'  => array(
					lang('main_settings')	=> 'main',
					lang('cf')				=> 'cf',
					lang('email')			=> 'email',
					lang('printer')			=> 'printer',
					lang('entrytypes')		=> 'entrytypes',
					lang('tags')			=> 'tags',
					lang('lock_account')	=> 'lock',
				)
			);
		}
	}

	/**
	* User Login Verification Method
	*
	* @return bool or string
	**/
	protected function verify_login($redirect_url = 'login') {
		/* if not logged in set redirect url to "login" controller */
		if (!$this->ion_auth->logged_in()) {
			/* if user not logged in and '$redirect_url' is not equal to "login" */
			if ($redirect_url !== 'login') {
				/* set redirect_url to "login" */
				$redirect_url = 'login';
			}
			/* return '$redirect_url' */
			return $redirect_url;
		}
		/* else return true */
		return true;
	}

	/**
	* Active Account Verification Method
	*
	* @return bool
	**/
	protected function verify_active_account() {
		/* check if active account session is set */
		if ($this->session->userdata('active_account_config') || $this->session->userdata('active_account')) {
			/* if session data set for active account return "true" */
			return true;
		} else { 
			/* else return false */
			return false;
		}
	}

	/**
	* Set Page Title Method
	*
	* @return string
	**/
	public function getPageTitle() {
		return lang('page_title_'.$this->mCtrler.'_'.$this->mAction);
	}

	/**
	* Verify page Authentication Method
	* 
	* Parameters:	 
	* [$perms] - must be an array of user's group permissions[i.e. $this->mPageAuth]
	*
	* @return bool or flash data
	**/
	protected function verify_auth($perms) {	
		/* check if [$perms] is empty */
		if (empty($perms) || !$perms) {
			if (isset($this->mPageAuth) && !empty($this->mPageAuth)) {
				/* save [$this->mPageAuth] to [$perms] */
				$perms = $this->mPageAuth;
			} else {
				/* Set 'error' flash data */
				$this->session->set_flashdata('error', lang('group_permissions_not_found'));
			}
		}

		/* Authenticate Page */
		if (array_key_exists($this->mUri, $perms) && !$perms[$this->mUri] == 1) {
			/* set flash data if logged in user does not have permissions to view the requested page */
			$this->session->set_flashdata('warning', sprintf(lang('page_access_permission_denied'), $this->mPageTitle));
		} else {
			return true;
		}

		if (!$this->verify_active_account()) {
			redirect('user/activate');
		} else {
			if ($this->ion_auth->is_admin()) {
				redirect('admin');
			} else {
				redirect('dashboard');
			}
		}
	}

	/**
	* Render template Method
	* Parameters:	 
	* [$view_file] - String of a View file's path for the requested page,
	*
	* [$layout] - must be a string from below options
	* "default"	=> default view file if no layout argument is passed
	* "empty"	=> used for login page
	*
	* @return void
	**/
	protected function render($view_file, $layout = 'default') {
		/* pass page title to view */
		$this->data['page_title'] = $this->mPageTitle;
		/* pass active account ID to view */
		$this->data['active_account_id'] = $this->mActiveAccountID;
		/* pass current URL to view */
		$this->data['uri'] = $this->mUri;
		/* pass current controller to view */
		$this->data['ctrler'] = $this->mCtrler;
		/* pass current method to view */
		$this->data['action'] = $this->mAction;
		/* pass user to view */
		$this->data['current_user'] = $this->mUser;
		/* pass date format array to view */
		$this->data['date_format'] = $this->mDateArray;
		/* pass menu to view */
		$this->data['menu'] = $this->mMenu;
		/* pass page auth to view */
		$this->data['page_auth'] = $this->mPageAuth;
		/* pass body class to view */
		$this->data['body_class'] = $this->mBodyClass;
		/* pass view file path to view */
		$this->data['inner_view'] = $view_file;
		/* pass view log boolean to view */
		$this->data['view_log'] = $this->mViewLog;
		/* load header view file */
		$this->load->view('_base/head', $this->data);
		/* load layout view file ("default" or "empty") */
		$this->load->view('_layouts/'.$layout, $this->data);
		/* load footer view file */
		$this->load->view('_base/foot', $this->data);
	}

	/* Verify mysql db (DB1) connection */
	public function check_database($config) {
	    /*  Check if using mysqli driver */
	    if($config['dbdriver'] === 'mysqli') {
	    	/* initilize mysqli connection */
	        @$mysqli = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
	        /* Check database connection */
	        if(!$mysqli->connect_error) {
	        	/* if no connection errors are found close connection and return true */
	            @$mysqli->close();
	            return true;
	        }
	    }
	    /* else return false */
	    return false;
	}
}

require APPPATH."core/Admin_Controller.php";
