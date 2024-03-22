<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class REP_o3_model extends CI_Model
{

    public $table = 'v_obj3sample';
    public $id = 'barcode_sample';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($date1, $date2) {
        $this->datatables->select('obj3_sam_rec.barcode_sample, obj3_sam_rec.date_receipt, obj3_sam_rec.time_receipt,
        ref_person.initial, ref_sampletype.sampletype AS sample_type, obj3_sam_rec.png_control, obj3_sam_rec.cold_chain,
         obj3_sam_rec.cont_intact, obj3_sam_rec.comments, obj3_sam_rec.id_person, obj3_sam_rec.lab, obj3_sam_rec.flag');
        $this->datatables->from('obj3_sam_rec');
        $this->datatables->join('ref_person', 'obj3_sam_rec.id_person = ref_person.id_person', 'left');
        $this->datatables->join('ref_sampletype', 'obj3_sam_rec.id_type = ref_sampletype.id_sampletype', 'left');
        $this->datatables->where('obj3_sam_rec.lab', $this->session->userdata('lab'));
        $this->datatables->where('obj3_sam_rec.flag', '0');
        $this->datatables->where("(obj3_sam_rec.date_receipt >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1'))", NULL);
        $this->datatables->where("(obj3_sam_rec.date_receipt <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2'))", NULL);
        // $this->datatables->limit('50');
        return $this->datatables->generate();
    }

    // get all
    // function get_all($date1, $date2)
    // {
    //     // $this->db->select('id_delivery, delivery_number, date_delivery, customer_name, city, id_items, items, qty');
    //     // $this->db->where("date_delivery >= '$date1'", NULL);
    //     // $this->db->where("date_delivery <= '$date2'", NULL);
    //     $this->db->where("date_delivery >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1')", NULL);
    //     $this->db->where("date_delivery <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2')", NULL);
    //     // $this->db->order_by($this->id, $this->order);
    //     return $this->db->get('vrep_delivery')->result();
    // }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    // function total_rows($q = NULL) {
    //     $this->db->like('id_customer', $q);
	// $this->db->or_like('customer_name', $q);
	// $this->db->or_like('addresses', $q);
	// $this->db->or_like('city', $q);
	// $this->db->or_like('phone', $q);
	// $this->db->or_like('email', $q);
	// $this->db->from($this->table);
    //     return $this->db->count_all_results();
    // }

    // // get data with limit and search
    // function get_limit_data($limit, $start = 0, $q = NULL) {
    //     $this->db->order_by($this->id, $this->order);
    //     $this->db->like('id_customer', $q);
	// $this->db->or_like('customer_name', $q);
	// $this->db->or_like('addresses', $q);
	// $this->db->or_like('city', $q);
	// $this->db->or_like('phone', $q);
	// $this->db->or_like('email', $q);
	// $this->db->limit($limit, $start);
    //     return $this->db->get($this->table)->result();
    // }

    // // insert data
    // function insert($data)
    // {
    //     $this->db->insert($this->table, $data);
    // }

    // // update data
    // function update($id, $data)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->update($this->table, $data);
    // }

    // // delete data
    // function delete($id)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->delete($this->table);
    // }

}

/* End of file Tbl_customer_model.php */
/* Location: ./application/models/Tbl_customer_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */