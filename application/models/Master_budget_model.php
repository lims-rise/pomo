<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_budget_model extends CI_Model
{

    public $table = 'v_obj2arecept';
    public $id = 'id_receipt';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($date1, $date2, $obj) {
        $this->datatables->select('a.id_req, a.date_req, b.po_number, c.objective, a.title, a.budget_req, a.id_country, a.flag');
        $this->datatables->from('budget_request a');
        $this->datatables->join('approved_po b', 'a.id_req=b.id_req', 'left');
        $this->datatables->join('ref_objective c', 'a.id_objective=c.id_objective', 'left');
        $this->datatables->where('a.id_country', $this->session->userdata('lab'));
        $this->datatables->where('a.flag', '0');
        if (strlen($date1) > 0) {
            $this->datatables->where("(a.date_req >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1'))", NULL);
        }
        if (strlen($date2) > 0) {
            $this->datatables->where("(a.date_req <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2'))", NULL);
        }

        // $this->datatables->where("(a.date_req >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1'))", NULL);
        // $this->datatables->where("(a.date_req <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2'))", NULL);
        if (strlen($obj) > 0) {
            $this->datatables->where("(a.id_objective = '$obj')", NULL);
        }
        // $this->datatables->limit('50');
        return $this->datatables->generate();
    }


}

/* End of file Tbl_customer_model.php */
/* Location: ./application/models/Tbl_customer_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */