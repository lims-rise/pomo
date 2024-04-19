<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class budget_exp_rem_model extends CI_Model
{

    public $table = 'budget_exp_rem_detail';
    public $id = 'id_exprem';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('a.id_reqrem, a.po_number, a.date_req, a.new_title, 
        FORMAT(b.sum_tot, 0, "de_DE") AS sum_tot, 
        FORMAT(CAST(COALESCE(c.expenses, 0) AS UNSIGNED), 0, "de_DE") AS expenses, 
        FORMAT((b.sum_tot - CAST(COALESCE(c.expenses, 0) AS UNSIGNED)), 0, "de_DE") AS rem_rem');
        $this->datatables->from('budget_req_remaining a');
        $this->datatables->join('v_reqrem_sum b', 'a.id_reqrem=b.id_reqrem', 'left');
        $this->datatables->join('v_tot_exprem c', 'a.po_number=c.po_number', 'left');
        $this->datatables->where('b.id_country', $this->session->userdata('lab'));
        $this->datatables->where('a.flag', '0');
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', anchor(site_url('budget_exp_rem/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_reqrem');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', anchor(site_url('budget_exp_rem/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_reqrem');
        }
        else {
            $this->datatables->add_column('action', anchor(site_url('budget_exp_rem/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_reqrem');
        }
        return $this->datatables->generate();
    }

    function subjson($id) {
      $this->datatables->select('budget_exp_rem_detail.id_exprem, budget_exp_rem_detail.date_expenses, budget_exp_rem_detail.items, budget_exp_rem_detail.qty, 
      ref_unit.unit, FORMAT(budget_exp_rem_detail.expenses, 0, "de_DE") AS expenses, 
      FORMAT(budget_exp_rem_detail.expenses * budget_exp_rem_detail.qty, 0, "de_DE") AS tot_expenses, 
      budget_exp_rem_detail.remarks, budget_exp_rem_detail.id_unit, budget_exp_rem_detail.flag, budget_exp_rem_detail.po_number');
      $this->datatables->from('budget_exp_rem_detail');
    //   $this->datatables->join('budget_exp_rem', 'budget_exp_rem_detail.id_exp = budget_exp_rem.id_exp', 'left');
      $this->datatables->join('ref_unit', 'budget_exp_rem_detail.id_unit = ref_unit.id_unit', 'left');
      //   $this->datatables->where('lab', $this->session->userdata('lab'));
      $this->datatables->where('budget_exp_rem_detail.flag', '0');
      $this->datatables->where('budget_exp_rem_detail.po_number', $id);

      $lvl = $this->session->userdata('id_user_level');
      if ($lvl == 7){
          $this->datatables->add_column('action', '', 'id_exp');
      }
      else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'id_exprem');
      }
      else {
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('budget_exp_rem/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this item?\')"'), 'id_exprem');
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
    //     LEFT JOIN budget_exp_rem_detail b ON a.id_spec=b.id_spec
    //     LEFT JOIN ref_person c ON a.id_person = c.id_person    
    //     WHERE a.lab="'.$this->session->userdata('lab').'"
    //     AND a.flag = 0 
    //     ');        
    //     $response = $q->result();
    //     return $response;

    //     // $this->db->order_by($this->id, $this->order);
    //     // $this->db->where('lab', $this->session->userdata('lab'));
    //     // $this->db->where('flag', '0');
    //     // return $this->db->get('budget_exp_rem_detail')->result();
    // }

    // function get_all_with_detail_excel()
    // {
    //     return $this->db->select('a.date_req, a.title, c.realname , d.objective, a.budget_req, a.comments, 
    //     b.id_reqdetail, b.items, b.qty, e.unit, 
    //     FORMAT(b.estimate_price, 0, "de_DE") AS estimate_price,
    //     (b.estimate_price * b.qty) AS total, b.remarks')
    //         ->from("budget_exp_rem a")
    //         ->join('budget_exp_rem_detail b', 'a.id_req = b.id_req', 'left')
    //         ->join('ref_person c', 'a.id_person = c.id_person', 'left')
    //         ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
    //         ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
    //         ->where('a.flag', 0)
    //         ->where('b.flag', 0)
    //         // ->where('l.id', $this->session->userdata('location_id'))
    //         ->get()->result();
    // }

    function get_all_with_detail_excel($id)
    {
        $data = $this->db->select('a.po_number, b.date_expenses, a.new_title, c.realname , a.objective, 
        a.sum_tot AS budget_req, b.id_exprem, b.items, b.qty, e.unit, b.expenses,
        (b.expenses * b.qty) AS total, h.sum_exp, b.remarks, f.reviewed, f.approved')
            ->from("v_reqrem_sum a")
            ->join('budget_exp_rem_detail b', 'a.po_number = b.po_number', 'left')
            ->join('ref_person c', 'a.id_person = c.id_person', 'left')
            ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
            ->join('ref_objective f', 'a.id_objective = f.id_objective ', 'left')
            ->join('v_budexprem_sum h', 'a.po_number = h.po_number', 'left')
            ->where('a.po_number', $id)
            ->where('b.flag', 0)
            ->where('a.id_country', $this->session->userdata('lab'))
            ->get()->result();
            foreach ($data as $row) {
                // Format estimate_price to show as money value
                // $row->estimate_price = number_format($row->estimate_price, 0, '.', ',');
                // Format total_price to show as money value
                $row->budget_req = number_format($row->budget_req, 0, ',', '.');
            }            
            return $data;
    }

    function get_by_id($id)
    {
        $this->db->select('*');
        $this->db->join('budget_req_remaining', 'budget_exp_rem_detail.po_number=budget_req_remaining.po_number', 'left');
        $this->db->where($this->id, $id);
        // $this->db->where('flag', '0');
        // $this->db->where('lab', $this->session->userdata('lab'));
        return $this->db->get($this->table)->row();
    }

    function get_detail($id)
    {
      $response = array();
      $this->db->select('*');
      $this->db->where('id_reqrem', $id);
      // $this->db->where('lab', $this->session->userdata('lab'));
    //   $this->db->where('flag', '0');
      $q = $this->db->get('v_budget_exp_rem');
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
        $query = $this->db->get('budget_exp_rem_detail');
        return $query->row()->estimate_price;
    }

    function get_rep($id)
    {
        $q = $this->db->query('SELECT a.id_req, a.date_req, b.realname, c.objective, a.title, 
        DATE_FORMAT(a.date_req, "%M %Y") AS periode, FORMAT(a.budget_req, 0, "de_DE") AS budget_req,
        a.comments, a.flag, c.reviewed, c.approved
        FROM budget_exp_rem a
        LEFT JOIN ref_person b ON a.id_person=b.id_person 
        LEFT JOIN ref_objective c ON a.id_objective=c.id_objective
        WHERE a.id_req="'.$id.'"
        AND a.flag = 0 
        ');        
        $response = $q->row();
        return $response;
      }


    //   function get_repdet($id)
    //   {
    //       $q = $this->db->query('SELECT * FROM budget_exp_rem_detail
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
        $this->db->insert('budget_exp_rem_detail', $data);
    }
    
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function update_det($id, $data)
    {
        $this->db->where('id_exprem', $id);
        $this->db->update('budget_exp_rem_detail', $data);
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