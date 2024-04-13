<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome_model extends CI_Model
{

    public $table = 'approved_po';
    public $id = '';
    public $order = '';

    function __construct()
    {
        parent::__construct();
    }

    function get_budget_req()
    {
        $query = $this->db->query('SELECT COUNT(DISTINCT a.id_req) AS budget_request,
        COUNT(DISTINCT b.id_reqdetail) AS budget_detail,
        COUNT(DISTINCT c.po_number) AS po_aprv,
        COUNT(DISTINCT a.id_req) - COUNT(DISTINCT c.po_number) AS po_left,
        FORMAT(SUM(DISTINCT a.budget_req), 0, "de_DE") AS total_request,
        FORMAT(SUM(DISTINCT e.budget_req), 0, "de_DE") AS total_approved,
        FORMAT(SUM(DISTINCT d.expenses), 0, "de_DE") AS total_expenses,
        FORMAT(SUM(DISTINCT e.budget_req)-SUM(DISTINCT d.expenses), 0, "de_DE") AS total_remaining
        FROM budget_request a
        LEFT JOIN budget_request_detail b ON a.id_req=b.id_req
        LEFT JOIN approved_po c ON a.id_req=c.id_req
        LEFT JOIN (SELECT z.budget_req, x.po_number
        FROM budget_request z
        JOIN approved_po x ON z.id_req=x.id_req
        ) e ON c.po_number = e.po_number
        LEFT JOIN v_tot_all_expenses d ON c.po_number=d.po_number
        WHERE a.flag = 0
        ');
        $result = $query->row_array();
        return $result;        
        // $this->db->select('COUNT(DISTINCT a.id_req) AS budget_request,
        // COUNT(DISTINCT b.id_reqdetail) AS budget_detail');
        // return $this->db->get('budget_request')->row();                
    }

    // datatables
    // function get_sum() {
    //     $query = $this->db->query('SELECT "Objective 3" AS item, COUNT(*) AS val
    //     FROM obj3_sam_rec
    //     WHERE lab = "'.$this->session->userdata('lab').'" 
    //             AND flag = 0 
    //     UNION ALL
    //     SELECT "Objective 2A" AS item, COUNT(*) AS val
    //     FROM obj2a_receipt
    //     WHERE lab = "'.$this->session->userdata('lab').'" 
    //             AND flag = 0 
    //     UNION ALL
    //     SELECT "Objective 2B" AS item, COUNT(*) AS val
    //     FROM obj2b_receipt
    //     WHERE lab = "'.$this->session->userdata('lab').'" 
    //             AND flag = 0 
    //     ');
    //     $result = $query->result();
        
    //     return $result;
    // }

    // function get_subsum() {
    //     $query = $this->db->query('SELECT "O3", 
    //     CASE
    //         WHEN a.id_type IN (1,2,3,5) THEN "Human Blood"
    //         WHEN a.id_type = 4 THEN "Human Feces"
    //         ELSE "Unidentify"
    //     END AS "type",
    //     COUNT(*) AS val
    //     FROM obj3_sam_rec a
    //     LEFT JOIN ref_sampletype b ON a.id_type=b.id_sampletype
    //     WHERE a.lab = "'.$this->session->userdata('lab').'" 
    //             AND a.flag = 0 
    //     GROUP BY type
    //     UNION ALL
    //     SELECT "O2A", a.sample_type AS "type", COUNT(*) AS val
    //     FROM obj2a_receipt a
    //     WHERE a.lab = "'.$this->session->userdata('lab').'" 
    //             AND a.flag = 0 
    //     GROUP BY a.sample_type
    //     UNION ALL
    //     SELECT "O2B", b.sampletype AS "type", COUNT(*) AS val
    //     FROM obj2b_receipt a
    //     LEFT JOIN ref_sampletype b ON a.id_type2b=b.id_sampletype
    //     WHERE a.lab = "'.$this->session->userdata('lab').'" 
    //             AND a.flag = 0 
    //     GROUP BY a.id_type2b             
    //     ');
    //     $result = $query->result();
        
    //     return $result;
    // }
    


}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-04 06:32:22 */
/* http://harviacode.com */