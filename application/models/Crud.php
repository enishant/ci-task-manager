<?php
/**
 * @author  Nishant Vaity
 * @version v1.0
 */
if ( ! defined( 'BASEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Crud extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function insert( $table = '', $data = array() ) {
		if ( ! empty( $table ) && ! empty( $data ) ) {
			$this->db->insert( $table, $data );
			if ( $this->db->insert_id() > 0 ) {
				return array(
					'status' => 'success',
					'message' => 'Data inserted successfully',
					'id' => $this->db->insert_id(),
				);
			} else {
				return array(
					'status' => 'error',
					'message' => 'Unable to insert data',
				);
			}
		} else {
			return array(
				'status' => 'error',
				'message' => 'Incomplete data',
			);
		}
	}
}
