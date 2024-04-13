<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class budget_request_rem_model extends CI_Model
{

    public $table = 'budget_req_remaining';
    public $id = 'id_reqrem';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('a.po_number, a.date_po, d.objective, b.title, 
        FORMAT(b.budget_req - c.expenses, 0, "de_DE") AS budget_rem, e.new_title, e.comments,
        e.date_req, IFNULL(e.id_reqrem ,0) AS id_reqrem, b.id_req, e.id_person,
        FORMAT(budget_rem_req, 0, "de_DE") AS budget_rem_req');
        $this->datatables->from('approved_po a');
        $this->datatables->join('budget_request b', 'a.id_req=b.id_req', 'left');
        $this->datatables->join('ref_objective d', 'b.id_objective=d.id_objective', 'left');
        $this->datatables->join('v_tot_expenses c', 'a.po_number=c.po_number', 'left');
        $this->datatables->join('budget_req_remaining e', 'a.po_number=e.po_number', 'left');
        $this->datatables->join('v_req_rem_detail f', 'e.id_reqrem=f.id_reqrem', 'left');
        // $this->datatables->where('b.id_country', $this->session->userdata('lab'));
        $this->datatables->where('b.flag', '0');
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', '', 'id_reqrem');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', 
                '<button type="button" class="btn_edit btn btn-success btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url("budget_request_rem/read/$1"),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_reqrem');
        }
        else {
            $this->datatables->add_column('action', 
                '<button type="button" class="btn_edit btn btn-success btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url("budget_request_rem/read/$1"),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')) ."
                ".anchor(site_url("budget_request_rem/delete/$1"),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this request?\')"'), 'id_reqrem');
        }
        return $this->datatables->generate();
    }

    function subjson($id) {
      $this->datatables->select('budget_req_rem_det.id_reqrem_det, budget_req_rem_det.items, budget_req_rem_det.qty, 
      ref_unit.unit, FORMAT(budget_req_rem_det.estimate_price, 0, "de_DE") AS estimate_price, 
      FORMAT(budget_req_rem_det.estimate_price * budget_req_rem_det.qty, 0, "de_DE") AS tot_estimate, 
      budget_req_rem_det.comments, budget_req_rem_det.id_reqrem, budget_req_rem_det.id_unit, budget_req_rem_det.flag');
      $this->datatables->from('budget_req_rem_det');
      $this->datatables->join('ref_unit', 'budget_req_rem_det.id_unit = ref_unit.id_unit', 'left');
      //   $this->datatables->where('lab', $this->session->userdata('lab'));
      $this->datatables->where('budget_req_rem_det.flag', '0');
      $this->datatables->where('budget_req_rem_det.id_reqrem', $id);
      $lvl = $this->session->userdata('id_user_level');
      if ($lvl == 7){
          $this->datatables->add_column('action', '', 'id_reqrem_det');
      }
      else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'id_reqrem_det');
      }
      else {
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('budget_request_rem/delete_detail/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this item?\')"'), 'id_reqrem_det');
        }
      return $this->datatables->generate();
  }

    // function get_all()
    // {
    //     $q = $this->db->query('SELECT a.id_spec, a.date_spec, c.initial, a.chem_parameter, a.mixture_name, a.sample_no, 
    //     a.lot_no, a.date_expired, a.cert_value, a.uncertainty, a.notes, a.tot_result, a.tot_trueness,
    //     a.tot_bias, a.avg_result, a.avg_trueness, a.avg_bias, a.sd, a.rsd, a.cv_horwits, a.cv,
    //     a.prec, a.accuracy, a.bias, b.id_reqdetail, b.duplication, b.result, b.trueness, b.bias_method, b.result2 
    //     FROM obj2b_spectro_crm a
    //     LEFT JOIN budget_request_detail b ON a.id_spec=b.id_spec
    //     LEFT JOIN ref_person c ON a.id_person = c.id_person    
    //     WHERE a.lab="'.$this->session->userdata('lab').'"
    //     AND a.flag = 0 
    //     ');        
    //     $response = $q->result();
    //     return $response;

    //     // $this->db->order_by($this->id, $this->order);
    //     // $this->db->where('lab', $this->session->userdata('lab'));
    //     // $this->db->where('flag', '0');
    //     // return $this->db->get('budget_request_detail')->result();
    // }

    // function get_all_with_detail_excel()
    // {
    //     return $this->db->select('a.date_req, a.title, c.realname , d.objective, a.budget_req, a.comments, 
    //     b.id_reqdetail, b.items, b.qty, e.unit, 
    //     FORMAT(b.estimate_price, 0, "de_DE") AS estimate_price,
    //     (b.estimate_price * b.qty) AS total, b.remarks')
    //         ->from("budget_request a")
    //         ->join('budget_request_detail b', 'a.id_req = b.id_req', 'left')
    //         ->join('ref_person c', 'a.id_person = c.id_person', 'left')
    //         ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
    //         ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
    //         ->where('a.flag', 0)
    //         ->where('b.flag', 0)
    //         // ->where('l.id', $this->session->userdata('location_id'))
    //         ->get()->result();
    // }

    // DATE_FORMAT(a.date_req, "%M %Y") AS periode, 
    // FORMAT(d.budget_req - h.expenses, 0, "de_DE") AS budget_rem, a.comments, 

    function get_all_with_detail_excel()
    {
        $data = $this->db->select('a.id_reqrem, a.date_req, a.new_title, f.realname, e.objective, 
        DATE_FORMAT(a.date_req, "%M %Y") AS periode, 
        (d.budget_req - h.expenses) AS budget_rem, a.comments, 
        b.id_reqrem_det, b.items, b.qty, i.unit, b.estimate_price,
        (b.estimate_price * b.qty) AS total, b.comments AS remarks, sum_tot,
        a.flag, e.reviewed, e.approved')
            ->from("budget_req_remaining a")
            ->join('budget_req_rem_det b', 'a.id_reqrem=b.id_reqrem', 'left')
            ->join('approved_po c', 'a.po_number=c.po_number', 'left')
            ->join('budget_request d', 'c.id_req=d.id_req', 'left')
            ->join('ref_objective e', 'd.id_objective=e.id_objective', 'left')
            ->join('ref_person f', 'a.id_person=f.id_person', 'left')
            ->join('v_tot_expenses h', 'c.po_number=h.po_number', 'left')
            ->join('ref_unit i', 'b.id_unit=i.id_unit', 'left')
            ->join('v_reqrem_sum j', 'a.id_reqrem=j.id_reqrem', 'left')
            ->where('a.flag', 0)
            ->where('b.flag', 0)
            // ->where('l.id', $this->session->userdata('location_id'))
            ->get()->result();
            // foreach ($data as $row) {
            //     // Format estimate_price to show as money value
            //     $row->estimate_price = number_format($row->estimate_price, 0, '.', ',');
            //     // Format total_price to show as money value
            //     $row->total = number_format($row->total, 0, '.', ',');
            // }            
            return $data;
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        // $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get($this->table)->row();
    }

    function get_detail_by_id($id)
    {
        // $this->db->select('approved_po.id_req, budget_req_remaining.po_number, budget_req_remaining.id_reqrem, budget_req_rem_det.id_reqrem_det');
        // $this->db->join('budget_req_remaining', 'budget_req_rem_det.id_reqrem=budget_req_remaining.id_reqrem', 'left');
        // $this->db->join('approved_po', 'budget_req_remaining.po_number=approved_po.po_number', 'left');
        $this->db->where('id_reqrem_det', $id);
        // $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get('budget_req_rem_det')->row();
    }

    function get_detail($id)
    {
      $response = array();
      $this->db->select('*');
      $this->db->where('id_reqrem', $id);
      // $this->db->where('lab', $this->session->userdata('lab'));
    //   $this->db->where('flag', '0');
      $q = $this->db->get('v_req_bud_rem');
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
        $query = $this->db->get('budget_request_detail');
        return $query->row()->estimate_price;
    }

    function get_rep($id)
    {
        $q = $this->db->query('SELECT a.id_reqrem, a.date_req, f.realname, e.objective, a.new_title, 
        DATE_FORMAT(a.date_req, "%M %Y") AS periode, 
        FORMAT(d.budget_req - h.expenses, 0, "de_DE") AS budget_rem,
        FORMAT(i.sum_tot, 0, "de_DE") AS sum_tot,
        a.comments, a.flag, e.reviewed, e.approved
        FROM budget_req_remaining a
        LEFT JOIN approved_po c ON a.po_number=c.po_number
        LEFT JOIN budget_request d ON c.id_req=d.id_req
        LEFT JOIN ref_objective e ON d.id_objective=e.id_objective
        LEFT JOIN ref_person f ON a.id_person=f.id_person
        LEFT JOIN v_tot_expenses h ON c.po_number=h.po_number
        LEFT JOIN v_reqrem_sum i ON a.id_reqrem=i.id_reqrem
        WHERE a.id_reqrem="'.$id.'"
        AND a.flag = 0 
        ');        
        $response = $q->row();
        return $response;
      }


    //   function get_repdet($id)
    //   {
    //       $q = $this->db->query('SELECT * FROM budget_request_detail
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

    function insert_det($data)
    {
        $this->db->insert('budget_req_rem_det', $data);
    }
    
    // update data
    function update($id, $data)
    {
        $this->db->where('id_reqrem', $id);
        $this->db->update($this->table, $data);
    }

    function update_det($id, $data)
    {
        $this->db->where('id_reqrem_det', $id);
        $this->db->update('budget_req_rem_det', $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function delete_all_detail($id)
    {
        $this->db->where('id_reqrem', $id);
        $this->db->delete('budget_req_rem_det');
    }

    function delete_detail($id)
    {
        $this->db->where('id_reqrem_det', $id);
        $this->db->delete('budget_req_rem_det');
    }

    function getLabtech(){
        $response = array();
        $this->db->select('*');
        // $this->db->where('position', 'Lab Tech');
        $this->db->where('flag', '0');
        $this->db->order_by('realname');
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

      function validate1($id, $type){
        if($type == 1) {
            $this->db->where('barcode_sample', $id);
        }
        $this->db->where('flag', '0');
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