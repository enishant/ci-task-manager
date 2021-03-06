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

	public function get( $table = '', $select = '*', $offset = 0, $limit = 10, $where = array(), $where_condition = 'OR', $count = false, $debug = false ) {
		if ( empty( $table ) ) {
			$data['total_rows'] = 0;
			$data['data'] = array();
			return $data;
		}
		if ( ! empty( $where ) ) {
			$where_count = 0;
			foreach ( $where as $k => $w ) {
				if ( $where_count == 0 ) {
					$this->db->where( $k, $w );
				} elseif ( $where_count > 0 && $where_condition == 'OR' ) {
					$this->db->or_where( $k, $w );
				} else {
					$this->db->where( $k, $w );
				}
				$where_count++;
			}
		}
		if ( $count ) {
			$count_query = $this->db->get( $table );
			$data['total_rows'] = $count_query->num_rows();
			if ( $debug ) {
				$data['debug']['count_query'] = $this->db->last_query();
			}
			return $data;
		}
		$this->db->select( $select );
		$this->db->order_by( 'ID', 'DESC' );
		if ( $limit == -1 ) {
			$query = $this->db->get( $table );
		} else {
			$query = $this->db->get( $table, $limit, $offset );
		}
		if ( $query->num_rows() > 0 ) {
			$data['data'] = $query->result_array();
		} else {
			$data['data'] = array();
		}
		if ( $debug ) {
			$data['debug']['result_query'] = $this->db->last_query();
		}
		return $data;
	}

	public function get_by_id( $table = '', $id = '', $id_for = '', $select = '*' ) {
		if ( ! empty( $table ) && ! empty( $id ) && ! empty( $id_for ) ) {
			$this->db->select( $select );
			$this->db->where( $id_for, $id );
			$query = $this->db->get( $table );
			if ( $query->num_rows() > 0 ) {
				return array(
					'status' => 'success',
					'message' => 'Data retrieved successfully',
					'data' => $query->row(),
				);
			} else {
				return array(
					'status' => 'error',
					'message' => 'Data not found',
				);
			}
		} else {
			return array(
				'status' => 'error',
				'message' => 'Incomplete data',
			);
		}
	}

	public function update( $table = '', $id = '', $id_for = '', $data = array() ) {
		if ( ! empty( $table ) && ! empty( $id ) && ! empty( $id_for ) && ! empty( $data ) ) {
			$this->db->where( $id_for, $id );
			$this->db->update( $table, $data );
			if ( $this->db->affected_rows() > 0 ) {
				return array(
					'status' => 'success',
					'message' => 'Data updated successfully',
				);
			} else {
				return array(
					'status' => 'success',
					'message' => 'No changes at existing data',
				);
			}
		} else {
			return array(
				'status' => 'error',
				'message' => 'Incomplete data',
			);
		}
	}

	public function delete( $table = '', $id = '', $id_for = '' ) {
		if ( ! empty( $table ) && ! empty( $id ) && ! empty( $id_for ) ) {
			$this->db->delete( $table, array( $id_for => $id ) );
			if ( $this->db->affected_rows() > 0 ) {
				return array(
					'status' => 'success',
					'message' => 'Data deleted successfully',
				);
			} else {
				return array(
					'status' => 'success',
					'message' => 'No changes at existing data',
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
