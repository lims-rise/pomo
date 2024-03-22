<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class REP_o2a_model extends CI_Model
{

    public $table = 'v_obj2arecept';
    public $id = 'id_receipt';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($date1, $date2) {
        $this->datatables->select('a.id_receipt, a.date_receipt, b.initial AS delivered, c.initial AS received, 
        a.sample_type, a.id_delivered, a.id_received, a.lab, a.flag');
        $this->datatables->from('obj2a_receipt a');
        $this->datatables->join('ref_person b', 'a.id_delivered = b.id_person', 'left');
        $this->datatables->join('ref_person c', 'a.id_received = c.id_person', 'left');
        $this->datatables->where('a.lab', $this->session->userdata('lab'));
        $this->datatables->where('a.flag', '0');
        $this->datatables->where("(date_receipt >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1'))", NULL);
        $this->datatables->where("(date_receipt <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2'))", NULL);
        // $this->datatables->limit('50');
        return $this->datatables->generate();
    }


}

/* End of file Tbl_customer_model.php */
/* Location: ./application/models/Tbl_customer_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */