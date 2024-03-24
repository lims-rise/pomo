<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model(['Welcome_model']);
    }


    public function index() {
        $this->template->load('template', 'welcome');
        // $row = "";
        //$this->load->view('table');
        // $row = $this->Welcome_model->get_by_id();
        // // $this->template->load('template', 'welcome', $row);
        // if ($row) {
        //     $row->item = $this->Welcome_model->get_sum();
        //     $row->obj = $this->Welcome_model->get_subsum();
        //     $this->template->load('template', 'welcome', $row);
        // }
        // else {
        //     $this->session->set_flashdata('message', 'Record Not Found');
        //     // $this->template->load('template', 'welcome', $row);
        //     // redirect(base_url('staff'));
        // }
    }

    public function form() {
        //$this->load->view('table');
        $this->template->load('template', 'form');
    }
    
    function autocomplate(){
        autocomplate_json('tbl_user', 'full_name');
    }

    function __autocomplate() {
        $this->db->like('nama_lengkap', $_GET['term']);
        $this->db->select('nama_lengkap');
        $products = $this->db->get('pegawai')->result();
        foreach ($products as $product) {
            $return_arr[] = $product->nama_lengkap;
        }

        echo json_encode($return_arr);
    }

    function pdf() {
        $this->load->library('pdf');
        $pdf = new FPDF('l', 'mm', 'A5');
        // membuat halaman baru
        $pdf->AddPage();
        // setting jenis font yang akan digunakan
        $pdf->SetFont('Arial', 'B', 16);
        // mencetak string 
        $pdf->Cell(190, 7, 'POMO RISE', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(190, 7, 'POMO RISE', 0, 1, 'C');
        $pdf->Output();
    }

}
