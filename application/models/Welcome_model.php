<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome_model extends CI_Model
{

    public $table = 'obj3_sam_rec';
    public $id = '';
    public $order = '';

    function __construct()
    {
        parent::__construct();
    }

    function get_by_id()
    {
        $this->db->select('*');
        return $this->db->get($this->table)->row();
                
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