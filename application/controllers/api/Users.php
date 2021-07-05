<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
use chriskacerguis\RestServer\RestController;

class Users extends RestController {

	public function __construct() {
		parent::__construct();
		$this->table_name = 'users';
	}

	public function index_get() {
		$response = array(
			'status' => 'success',
			'controller' => $this->router->class,
		);
		$this->response( $response );
	}

	public function auth_post() {
		$username = $this->post( 'username', true );
		$password = $this->post( 'password', true );
		$table = $this->table_name;
		$select = 'ID,username,password,user_role,full_name';
		if ( ! empty( $username ) && ! empty( $password ) ) {
			$response = $this->crud->get_by_id( $table, $username, 'username', $select );
		} else {
			$response['status'] = 'error';
		}
		if ( isset( $response['status'] ) && $response['status'] == 'success' && isset( $response['data'] ) && isset( $response['data']->ID ) && isset( $response['data']->password ) ) {
			if ( $response['data']->password == md5( $password ) ) {
				unset( $response['data']->password );
				$this->session->user_last_activity = time();
				$this->session->user = $response['data'];
				$response['message'] = 'User Authenticated Successfully';
			} else {
				unset( $response['data'] );
				$response['status'] = 'error';
				$response['message'] = 'Invalid Uername or Password';
			}
		} else {
			$response['message'] = 'Invalid Uername or Password';
		}
		$this->response( $response, 200 );
	}
}
