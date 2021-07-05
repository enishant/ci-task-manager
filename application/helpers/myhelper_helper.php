<?php if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'logged_in_user_status' ) ) {
	function logged_in_user_status() {
		$CI =& get_instance();
		$CI->load->library( 'session' );
		$user = $CI->session->user;
		if ( isset( $user ) && isset( $user->ID ) && $user->ID > 0 ) {
			$logged_in_user = $CI->crud->get_by_id( 'users', $user->ID, 'ID' );
			if ( isset( $logged_in_user ) && isset( $logged_in_user['status'] ) && $logged_in_user['status'] == 'success' && isset( $logged_in_user['data'] ) && isset( $logged_in_user['data']->ID ) ) {
				return array(
					'status' => 'success',
					'user' => $user,
				);
			} else {
				log_out_user();
				return array( 'status' => 'error' );
			}
		} else {
			log_out_user();
			return array( 'status' => 'error' );
		}
	}
}

if ( ! function_exists( 'log_out_user' ) ) {
	function log_out_user() {
		$CI =& get_instance();
		$CI->load->library( 'session' );
		$CI->session->sess_destroy();
	}
}

if ( ! function_exists( 'get_users_by_role' ) ) {
	function get_users_by_role( $user_role = 'employee' ) {
		$CI =& get_instance();
		$users = array();
		if ( ! empty( $user_role ) ) {
			$users_query = $CI->crud->get(
				'users',
				'*',
				0,
				-1,
				array(
					'user_role' => $user_role,
				),
				'AND'
			);
			if ( isset( $users_query ) && isset( $users_query['data'] ) && ! empty( $users_query['data'] ) ) {
				$users = $users_query['data'];
			}
		}
		return $users;
	}
}
