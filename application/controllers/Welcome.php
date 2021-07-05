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

	public function dashboard( $page = '' ) {
		$result = logged_in_user_status();
		if ( $result['status'] == 'success' && isset( $result['user'] ) && isset( $result['user']->user_role ) ) {
			$this->app_view_config['page_title'] = 'Dashboard';
			$nav_link_offset = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
			if ( $nav_link_offset > 0 ) {
				$new_url = explode( '/' . $nav_link_offset, current_url() );
			}
			if ( ! empty( $page ) ) {
				foreach ( $this->app_view_config['nav_menu'] as $mk => $menu ) {
					if ( $nav_link_offset > 0 && isset( $new_url ) && ! empty( $new_url ) && count( $new_url ) == 2 ) {
						$nav_menu[ $mk ]['is_current_page'] = ( $new_url[0] == $menu['baselink'] );
					} else {
						$nav_menu[ $mk ]['is_current_page'] = ( current_url() == $menu['baselink'] );
					}
					if ( $nav_menu[ $mk ]['is_current_page'] ) {
						$this->app_view_config['page_title'] = $menu['title'];
					}
				}
			}
			$this->app_view_config['user'] = $result['user'];
			$this->app_view_config['user_role'] = $result['user']->user_role;
			if ( $this->app_view_config['user_role'] == 'manager' ) {
				$allowed_pages = array(
					'dashboard',
					'tasks',
					'task',
				);
			} elseif ( $this->app_view_config['user_role'] == 'employee' ) {
				$allowed_pages = array(
					'dashboard',
					'tasks',
					'task',
				);
			}
			if ( in_array( $page, $allowed_pages ) && $page == 'task' ) {
				$task_id = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
				$task_query = $this->crud->get( 'tasks', '*', 0, 1, array( 'ID' => $task_id ) );
				if ( isset( $task_query ) && isset( $task_query['data'] ) && isset( $task_query['data'][0] ) ) {
					if ( $result['user']->user_role == 'employee' && $task_query['data'][0]['assigned_to'] != $result['user']->ID ) {
						redirect( base_url( 'dashboard/tasks' ) );
						exit();
					}
					$this->app_view_config['page_title'] = $task_query['data'][0]['task_title'];
				} else {
					redirect( base_url( 'dashboard/tasks' ) );
					exit();
				}
			}
			if ( ! empty( $page ) && ! in_array( $page, $allowed_pages ) ) {
				$this->app_view_config['page_title'] = 'Error 404 - Page not found !';
			}
			$this->load->view( 'app_header', $this->app_view_config );
			if ( empty( $page ) ) {
				$this->load->view( 'app_dashboard', $this->app_view_config );
			} else {
				if ( in_array( $page, $allowed_pages ) ) {
					if ( is_file( APPPATH . 'views/' . 'templates/dashboard_' . $page . '.php' ) ) {
						if ( $page == 'tasks' || $page == 'users' ) {
							$this->app_view_config['data_query'] = array();
							$limit = $this->app_view_config['pagination_config']['per_page'];
							$offset = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
							$table_name = '';
							$where = array();
							if ( $page == 'tasks' ) {
								$table_name = 'tasks';
								$task_progress = $this->input->get( 'task_progress' );
								$this->app_view_config['task_progress'] = $task_progress;
								if ( $this->app_view_config['user_role'] == 'employee' ) {
									$where = array(
										'assigned_to' => $result['user']->ID,
									);
								}
								if ( isset( $task_progress ) ) {
									$where['task_status'] = $task_progress;
								}
							} elseif ( $page == 'users' ) {
								$table_name = 'users';
								if ( $this->app_view_config['user_role'] == 'manager' ) {
									$where['user_role'] = 'employee';
								}
							}
							$data_count_query = $this->crud->get( $table_name, '*', 0, -1, $where, 'AND', true );
							if ( isset( $data_count_query['total_rows'] ) ) {
								$this->app_view_config['pagination_config']['total_rows'] = $data_count_query['total_rows'];
								if ( $this->app_view_config['pagination_config']['total_rows'] > 0 ) {
									$data_query = $this->crud->get( $table_name, '*', $offset, $limit, $where, 'AND', false );
									if ( isset( $data_query['data'] ) ) {
										foreach ( $data_query['data'] as $row_key => $row_data ) {
											if ( $table_name == 'users' ) {
												unset( $data_query['data'][ $row_key ]['password'] );
												$data_query['data'][ $row_key ]['metadata'] = get_all_usermeta( $row_data['ID'] );
											}
										}
										$this->app_view_config['data_query'] = $data_query['data'];
									}
								}
							}
							$this->app_view_config['pagination_config']['base_url'] = base_url( 'dashboard/' . $page );
						}
						if ( $page == 'task' ) {
							$task_id = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
						}
						$this->load->view( 'templates/dashboard_' . $page, $this->app_view_config );
					}
				} else {
					$this->load->view( 'app_404', $this->app_view_config );
				}
			}
			$this->load->view( 'app_footer', $this->app_view_config );
			// Dashboard page here
		} else {
			redirect( base_url() );
			exit();
		}
	}

	public function four_o_four() {
		$result = logged_in_user_status();
		if ( $result['status'] == 'success' ) {
			$this->app_view_config['page_title'] = 'Error 404 - Page not found !';
			$this->app_view_config['user_role'] = '';
			$this->load->view( 'app_header', $this->app_view_config );
			$this->load->view( 'app_404', $this->app_view_config );
			$this->load->view( 'app_footer', $this->app_view_config );
		} else {
			redirect( base_url( '/login' ) );
			exit();
		}
	}
}
