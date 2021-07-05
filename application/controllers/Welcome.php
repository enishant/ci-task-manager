<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->app_view_config = $this->config->item( 'app_view_config' );
		$this->session_expiry = $this->config->item( 'csrf_expire' );
		$this->last_activity = $this->session->user_last_activity;
		if ( isset( $this->last_activity ) && ( time() - $this->last_activity > $this->session_expiry ) ) {
			$this->session->sess_destroy();
		}
		$this->session->user_last_activity = time();

		if ( $this->app_view_config['appearance'] == 'dark' ) {
			$this->app_view_config['site_settings']['appearance'] = 'white-text';
		} elseif ( $this->app_view_config['appearance'] == 'light' ) {
			$this->app_view_config['site_settings']['appearance'] = 'black-text';
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *      http://example.com/index.php/welcome
	 *  - or -
	 *      http://example.com/index.php/welcome/index
	 *  - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$result = logged_in_user_status();
		if ( $result['status'] == 'success' ) {
			redirect( base_url( 'dashboard' ) );
		} else {
			redirect( base_url( '/login' ) );
			exit();
		}
	}

	public function login() {
		$result = logged_in_user_status();
		if ( $result['status'] == 'success' ) {
			redirect( base_url( 'dashboard' ) );
			exit();
		}
		$this->app_view_config['page_title'] = $this->app_view_config['app_title'];
		$this->load->view( 'login_header', $this->app_view_config );
		$this->load->view( 'login_page', $this->app_view_config );
		$this->load->view( 'login_footer', $this->app_view_config );
	}

	public function logout() {
		log_out_user();
		redirect( base_url() );
		exit();
	}

	}
}
