<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dictionary_model extends CI_Model
{

    public $table = 'dictionary';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }


    // datatables
    function json() {
        // $this->datatables->select('id, module, subheadings, col_name,
        // var_label, var_type, description, start_date,
        // end_date, detail, comments, dictionary_id');  
        // $this->datatables->from('v_dictionary'); 

        $this->datatables->select('id, module, subheadings, col_name, var_label, var_type, 
        description, start_date, end_date, if((dictionary_id is not null),"Yes","No") AS detail, 
        comments, dictionary_id');
        $this->datatables->from('dictionary');

        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', anchor(site_url('dictionary/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"> Detail</i>', array('class' => 'btn btn-info btn-sm')), 'id');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', anchor(site_url('dictionary/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"> Detail</i>', array('class' => 'btn btn-info btn-sm')), 'id');
        }
        else {
            $this->datatables->add_column('action', anchor(site_url('dictionary/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"> Detail</i>', array('class' => 'btn btn-info btn-sm'))." 
               ".anchor(site_url('Dictionary/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting sample : $1 ?\')"'), 'id');
        }
        return $this->datatables->generate();
    }

    function jsondetail($id) {
    // function jsondetail() {
        $this->datatables->select('id, factor_value, factor_label, start_date, end_date, comments, dictionary_id');
        $this->datatables->from('dictionary_det');
        $this->datatables->where('dictionary_id', $id);
        // $this->datatables->where('lab', $this->session->userdata('lab'));
        // $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-primary btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'barcode_sample');
        // $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>'." 
        //         ".anchor(site_url('Dictionary/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting sample : $1 ?\')"'), 'id');
        return $this->datatables->generate();
    }

    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        // $this->db->where('lab', $this->session->userdata('lab'));
        // $this->db->where('flag', '0');
        return $this->db->get('dictionary')->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        // $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get($this->table)->row();
    }

    // function get_by_id_detail($id)
    // {
    //     $this->db->where('id_delivery_det', $id);
    //     return $this->db->get('tbl_delivery_det')->row();
    // }

    // get total rows
    // function total_rows($q = NULL) {
    //     $this->db->like('id_delivery', $q);
	// $this->db->or_like('date_delivery', $q);
	// $this->db->or_like('delivery_number', $q);
	// $this->db->or_like('customer_name', $q);
	// $this->db->or_like('city', $q);
	// $this->db->or_like('phone', $q);
	// $this->db->or_like('notes', $q);
	// $this->db->from($this->table);
    //     return $this->db->count_all_results();
    // }

    // get data with limit and search
    // function get_limit_data($limit, $start = 0, $q = NULL) {
    //     $this->db->order_by($this->id, $this->order);
    //     $this->db->like('id_delivery', $q);
	// $this->db->or_like('date_delivery', $q);
	// $this->db->or_like('delivery_number', $q);
	// $this->db->or_like('customer_name', $q);
	// $this->db->or_like('city', $q);
	// $this->db->or_like('phone', $q);
	// $this->db->or_like('notes', $q);
	// $this->db->limit($limit, $start);
    //     return $this->db->get($this->table)->result();
    // }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
    
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    // function delete($id_user, $data)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->update($this->table, $data);
    // }

    // function delete($id)
    // {
        // $this->db->where($this->id, $id);
        // $this->db->delete($this->table);
    // }

    // function getLabtech(){
    //     $response = array();
    //     $this->db->select('*');
    //     $this->db->where('position', 'Lab Tech');
    //     $q = $this->db->get('Dictionary');
    //     $response = $q->result_array();
    
    //     return $response;
    //   }

    //   function getSampleType(){

    //     $response = array();
    //     // Select record
    //     $this->db->select('*');
    //     $this->db->where('obj', 'O3');
    //     $q = $this->db->get('Dictionary');
    //     $response = $q->result_array();
    
    //     return $response;
    //   }

      function validate1($id){
        $this->db->where('barcode_sample', $id);
        // $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        $q = $this->db->get($this->table);
        $response = $q->result_array();
        return $response;
        // return $this->db->get('ref_location_80')->row();
      }

}

/* End of file Tbl_delivery_model.php */
/* Location: ./application/models/Tbl_delivery_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */