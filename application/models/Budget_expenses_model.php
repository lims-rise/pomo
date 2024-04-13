<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class budget_expenses_model extends CI_Model
{

    public $table = 'budget_expenses_detail';
    public $id = 'id_exp';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('a.po_number, a.date_po, d.objective, b.title, 
        FORMAT(b.budget_req, 0, "de_DE") AS budget_req, 
        FORMAT(c.expenses, 0, "de_DE") AS expenses, 
        FORMAT(b.budget_req - c.expenses, 0, "de_DE") AS budget_rem, 
        b.id_req');
        $this->datatables->from('approved_po a');
        $this->datatables->join('budget_request b', 'a.id_req=b.id_req', 'left');
        $this->datatables->join('ref_objective d', 'b.id_objective=d.id_objective', 'left');
        $this->datatables->join('v_tot_expenses c', 'a.po_number=c.po_number', 'left');
        // $this->datatables->where('b.id_country', $this->session->userdata('lab'));
        $this->datatables->where('b.flag', '0');
        $lvl = $this->session->userdata('id_user_level');
        if ($lvl == 7){
            $this->datatables->add_column('action', anchor(site_url('budget_expenses/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
        }
        else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', anchor(site_url('budget_expenses/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
        }
        else {
            $this->datatables->add_column('action', anchor(site_url('budget_expenses/read/$1'),'<i class="fa fa-th-list" aria-hidden="true"></i>', array('class' => 'btn btn-info btn-sm')), 'id_req');
        }
        return $this->datatables->generate();
    }

    function subjson($id) {
      $this->datatables->select('budget_expenses_detail.id_exp, budget_expenses_detail.date_expenses, budget_expenses_detail.items, budget_expenses_detail.qty, 
      ref_unit.unit, FORMAT(budget_expenses_detail.expenses, 0, "de_DE") AS expenses, 
      FORMAT(budget_expenses_detail.expenses * budget_expenses_detail.qty, 0, "de_DE") AS tot_expenses, 
      budget_expenses_detail.remarks, budget_expenses_detail.id_exp, budget_expenses_detail.id_unit, budget_expenses_detail.flag, budget_expenses_detail.po_number');
      $this->datatables->from('budget_expenses_detail');
    //   $this->datatables->join('budget_expenses', 'budget_expenses_detail.id_exp = budget_expenses.id_exp', 'left');
      $this->datatables->join('ref_unit', 'budget_expenses_detail.id_unit = ref_unit.id_unit', 'left');
      //   $this->datatables->where('lab', $this->session->userdata('lab'));
      $this->datatables->where('budget_expenses_detail.flag', '0');
      $this->datatables->where('budget_expenses_detail.po_number', $id);

      $lvl = $this->session->userdata('id_user_level');
      if ($lvl == 7){
          $this->datatables->add_column('action', '', 'id_exp');
      }
      else if (($lvl == 2) | ($lvl == 3)){
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Update</button>', 'id_exp');
      }
      else {
            $this->datatables->add_column('action', '<button type="button" class="btn_edit_det btn btn-info btn-sm" aria-hidden="true"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>'." 
                ".anchor(site_url('budget_expenses/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Confirm deleting this item?\')"'), 'id_exp');
        }
      return $this->datatables->generate();
  }

    function get_all_with_detail_excel()
    {
        $data = $this->db->select('g.po_number, b.date_expenses, a.title, c.realname , d.objective, 
        a.budget_req, a.comments, b.id_exp, b.items, b.qty, e.unit, b.expenses,
        (b.expenses * b.qty) AS total, h.sum_exp, b.remarks, d.reviewed, d.approved')
            ->from("budget_request a")
            ->join('approved_po g', 'a.id_req=g.id_req', 'left')
            ->join('budget_expenses_detail b', 'g.po_number = b.po_number', 'left')
            ->join('ref_person c', 'a.id_person = c.id_person', 'left')
            ->join('ref_objective d', 'a.id_objective = d.id_objective ', 'left')
            ->join('ref_unit e', 'b.id_unit = e.id_unit ', 'left')
            ->join('v_budexp_sum h', 'g.po_number = h.po_number ', 'left')
            ->where('a.flag', 0)
            ->where('b.flag', 0)
            // ->where('l.id', $this->session->userdata('location_id'))
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
        $this->db->select('budget_expenses_detail.id_exp, budget_expenses_detail.po_number, approved_po.id_req');
        $this->db->join('approved_po', 'budget_expenses_detail.po_number=approved_po.po_number', 'left');
        $this->db->where($this->id, $id);
        // $this->db->where('flag', '0');
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
      $q = $this->db->get('v_budget_exp');
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
        $query = $this->db->get('budget_expenses_detail');
        return $query->row()->estimate_price;
    }

    function get_rep($id)
    {
        $q = $this->db->query('SELECT a.id_req, a.date_req, b.realname, c.objective, a.title, 
        DATE_FORMAT(a.date_req, "%M %Y") AS periode, FORMAT(a.budget_req, 0, "de_DE") AS budget_req,
        a.comments, a.flag, c.reviewed, c.approved
        FROM budget_expenses a
        LEFT JOIN ref_person b ON a.id_person=b.id_person 
        LEFT JOIN ref_objective c ON a.id_objective=c.id_objective
        WHERE a.id_req="'.$id.'"
        AND a.flag = 0 
        ');        
        $response = $q->row();
        return $response;
      }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function insert_det($data)
    {
        $this->db->insert('budget_expenses_detail', $data);
    }
    
    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function update_det($id, $data)
    {
        $this->db->where('id_exp', $id);
        $this->db->update('budget_expenses_detail', $data);
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