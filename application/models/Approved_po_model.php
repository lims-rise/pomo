<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approved_po_model extends CI_Model
{

    public $table = 'approved_po';
    public $id = 'id_req';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('approved_po.po_number, approved_po.date_po, approved_po.comments, budged_request.date_req, 
        ref_person.realname, ref_objective.objective, budged_request.title, 
        FORMAT(budged_request.budged_req, 0, "de_DE") AS budged_req, budged_request.id_country, 
        budged_request.id_person, budged_request.id_objective, budged_request.id_req, budged_request.flag');
        $this->datatables->from('budged_request');
        $this->datatables->join('approved_po', 'approved_po.id_req = budged_request.id_req', 'left');
        $this->datatables->join('ref_person', 'budged_request.id_person = ref_person.id_person', 'left');
        $this->datatables->join('ref_objective', 'budged_request.id_objective = ref_objective.id_objective', 'left');
        $this->datatables->where('budged_request.id_country', $this->session->userdata('lab'));
        $this->datatables->where('budged_request.flag', '0');
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', '', 'id_req');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-success btn-sm" aria-hidden="true"><i class="fa fa-check" aria-hidden="true"></i></button>'."
            ".anchor(site_url('Approved_po/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
        }
        else {
            $this->datatables->add_column('action', '<button type="button" class="btn_edit btn btn-success btn-sm" aria-hidden="true"><i class="fa fa-check" aria-hidden="true"></i></button>'."
            ".anchor(site_url('Approved_po/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
        }
        return $this->datatables->generate();
    }

    // function json() {
    //     $this->datatables->select('approved_po.po_number, approved_po.date_po, approved_po.comments, budged_request.date_req, 
    //     ref_person.realname, ref_objective.objective, budged_request.title, 
    //     FORMAT(budged_request.budged_req, 0, "de_DE") AS budged_req, budged_request.id_country, 
    //     budged_request.id_person, budged_request.id_objective, budged_request.id_req, budged_request.flag');
    //     $this->datatables->from('budged_request');
    //     $this->datatables->join('approved_po', 'approved_po.id_req = budged_request.id_req', 'left');
    //     $this->datatables->join('ref_person', 'budged_request.id_person = ref_person.id_person', 'left');
    //     $this->datatables->join('ref_objective', 'budged_request.id_objective = ref_objective.id_objective', 'left');
    //     $this->datatables->where('budged_request.id_country', $this->session->userdata('lab'));
    //     $this->datatables->where('budged_request.flag', '0');
    
    //     // Generate DataTables data
    //     $data = $this->datatables->generate();
    
    //     // Define array to store buttons for each row
    //     $buttons = array();
    
    //     // Loop through each row to determine the button for each row
    //     foreach ($data as $row) {
    //         // Check if po_number exists for this row
    //         if (!empty($row['po_number'])) {
    //             // Change button HTML here if po_number exists
    //             $button_html = '<button type="button" class="new_button_class btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
    //         } else {
    //             // Default button HTML
    //             $button_html = '<button type="button" class="btn_edit btn btn-success btn-sm" aria-hidden="true"><i class="fa fa-check" aria-hidden="true"></i></button>';
    //         }
    
    //         // Add button HTML to buttons array
    //         $buttons[] = $button_html;
    //     }
    
    //     $lvl = $this->session->userdata('id_user_level');
    //     if ($lvl == 7){
    //         $this->datatables->add_column('action', '', 'id_req');
    //     }
    //     else if (($lvl == 2) | ($lvl == 3)){
    //         $this->datatables->add_column('action', '$1' . anchor(site_url('Approved_po/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
    //     }
    //     else {
    //         $this->datatables->add_column('action', '$1' . anchor(site_url('Approved_po/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
    //     }
    
    //     // Merge buttons array with DataTables data
    //     $result = array();
    //     foreach ($data as $key => $row) {
    //         $result[] = array_merge($row, array($buttons[$key]));
    //     }
    
    //     return $result;
    // }
    
    function subjson($id) {
      $this->datatables->select('budged_request_detail.id_reqdetail, budged_request_detail.items, budged_request_detail.qty, 
      ref_unit.unit, FORMAT(budged_request_detail.estimate_price, 0, "de_DE") AS estimate_price, 
      FORMAT(budged_request_detail.estimate_price * budged_request_detail.qty, 0, "de_DE") AS tot_estimate, 
      budged_request_detail.remarks, budged_request_detail.id_req, budged_request_detail.id_unit, budged_request_detail.flag');
      $this->datatables->from('budged_request_detail');
      $this->datatables->join('ref_unit', 'budged_request_detail.id_unit = ref_unit.id_unit', 'left');
      //   $this->datatables->where('lab', $this->session->userdata('lab'));
      $this->datatables->where('budged_request_detail.flag', '0');
      $this->datatables->where('budged_request_detail.id_req', $id);
    //   $lvl = $this->session->userdata('id_user_level');
    //   if ($lvl == 7){
    //       $this->datatables->add_column('action', '', 'id_reqdetail');
    //   }
    //   else if (($lvl == 2) | ($lvl == 3)){
    //         $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'id_reqdetail');
    //   }
    //   else {
    //         $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
    //             ".anchor(site_url('Approved_po/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting sample : $1 ?\')"'), 'id_reqdetail');
    //     }
      return $this->datatables->generate();
  }

    // function get_all()
    // {
    //     $q = $this->db->query('SELECT a.id_spec, a.date_spec, c.initial, a.chem_parameter, a.mixture_name, a.sample_no, 
    //     a.lot_no, a.date_expired, a.cert_value, a.uncertainty, a.notes, a.tot_result, a.tot_trueness,
    //     a.tot_bias, a.avg_result, a.avg_trueness, a.avg_bias, a.sd, a.rsd, a.cv_horwits, a.cv,
    //     a.prec, a.accuracy, a.bias, b.id_reqdetail, b.duplication, b.result, b.trueness, b.bias_method, b.result2 
    //     FROM obj2b_spectro_crm a
    //     LEFT JOIN budged_request_detail b ON a.id_spec=b.id_spec
    //     LEFT JOIN ref_person c ON a.id_person = c.id_person    
    //     WHERE a.lab="'.$this->session->userdata('lab').'"
    //     AND a.flag = 0 
    //     ');        
    //     $response = $q->result();
    //     return $response;

    //     // $this->db->order_by($this->id, $this->order);
    //     // $this->db->where('lab', $this->session->userdata('lab'));
    //     // $this->db->where('flag', '0');
    //     // return $this->db->get('budged_request_detail')->result();
    // }

    // function get_all_with_detail_excel()
    // {
    //     return $this->db->select('a.date_req, a.title, c.realname , d.objective, a.budged_req, a.comments, 
    //     b.id_reqdetail, b.items, b.qty, e.unit, 
    //     FORMAT(b.estimate_price, 0, "de_DE") AS estimate_price,
    //     (b.estimate_price * b.qty) AS total, b.remarks')
    //         ->from("budged_request a")
    //         ->join('budged_request_detail b', 'a.id_req = b.id_req', 'left')
    //         ->join('ref_person c', 'a.id_person = c.id_person', 'left')
    //         ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
    //         ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
    //         ->where('a.flag', 0)
    //         ->where('b.flag', 0)
    //         // ->where('l.id', $this->session->userdata('location_id'))
    //         ->get()->result();
    // }

    function get_all_with_detail_excel()
    {
        $data = $this->db->select('a.date_req, a.title, c.realname , d.objective, a.budged_req, a.comments, 
        b.id_reqdetail, b.items, b.qty, e.unit, b.estimate_price,
        (b.estimate_price * b.qty) AS total, b.remarks, f.reviewed, f.approved')
            ->from("budged_request a")
            ->join('budged_request_detail b', 'a.id_req = b.id_req', 'left')
            ->join('ref_person c', 'a.id_person = c.id_person', 'left')
            ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
            ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
            ->join('ref_approves f', 'a.id_objective = f.id_objective ', 'left')
            ->where('a.flag', 0)
            ->where('b.flag', 0)
            // ->where('l.id', $this->session->userdata('location_id'))
            ->get()->result();
            foreach ($data as $row) {
                // Format estimate_price to show as money value
                $row->estimate_price = number_format($row->estimate_price, 0, '.', ',');
                // Format total_price to show as money value
                $row->total = number_format($row->total, 0, '.', ',');
            }            
            return $data;
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get($this->table)->row();
    }

    function get_detail($id)
    {
      $response = array();
      $this->db->select('*');
      $this->db->where('id_req', $id);
      // $this->db->where('lab', $this->session->userdata('lab'));
      $this->db->where('flag', '0');
      $q = $this->db->get('v_req_budged');
      $response = $q->row();
      return $response;
        // $this->db->where('id_spec', $id_spec);
        // $this->db->where('flag', '0');
        // // $this->db->where('lab', $this->session->userdata('lab'));
        // return $this->db->get('obj2b_spectro_crm')->row();
    }

    function getSumEstimatePrice($id_req) {
        $this->db->select_sum('estimate_price');
        $this->db->where('id_req', $id_req);
        $query = $this->db->get('budged_request_detail');
        return $query->row()->estimate_price;
    }

    function get_rep($id)
    {
        $q = $this->db->query('SELECT a.id_req, a.date_req, b.realname, c.objective, a.title, 
        DATE_FORMAT(a.date_req, "%M %Y") AS periode, FORMAT(a.budged_req, 0, "de_DE") AS budged_req,
        a.comments, a.flag, d.reviewed, d.approved
        FROM budged_request a
        LEFT JOIN ref_person b ON a.id_person=b.id_person 
        LEFT JOIN ref_objective c ON a.id_objective=c.id_objective
        LEFT JOIN ref_approves d ON a.id_objective=d.id_objective
        WHERE a.id_req="'.$id.'"
        AND a.flag = 0 
        ');        
        $response = $q->row();
        return $response;
      }


    //   function get_repdet($id)
    //   {
    //       $q = $this->db->query('SELECT * FROM budged_request_detail
    //       WHERE flag = 0
    //       AND id_spec="'.$id.'"');        
    //       $response = $q->row();
    //       return $response;
    //     }

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
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function getLabtech(){
        $response = array();
        $this->db->select('*');
        // $this->db->where('position', 'Lab Tech');
        $this->db->where('flag', '0');
        $q = $this->db->get('ref_person');
        $response = $q->result_array();
        return $response;
      }

      function getObjective(){
        $response = array();
        $this->db->select('*');
        // $this->db->where('position', 'Lab Tech');
        $this->db->where('flag', '0');
        $q = $this->db->get('ref_objective');
        $response = $q->result_array();
        return $response;
      }

      function getUnits(){
        $response = array();
        $this->db->select('*');
        // $this->db->where('position', 'Lab Tech');
        $this->db->where('flag', '0');
        $q = $this->db->get('ref_unit');
        $response = $q->result_array();
        return $response;
      }

      function validate1($id){
        $this->db->where('po_number', $id);
        $this->db->where('flag', '0');
        $q = $this->db->get($this->table);
        $response = $q->result_array();
        return $response;
      }
      
}

/* End of file Tbl_delivery_model.php */
/* Location: ./application/models/Tbl_delivery_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */