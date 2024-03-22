<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once '../../extlib/PHPExcel/PHPExcel.php';

class REP_dna extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('REP_dna_model');
        // $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','REP_dna/index');
    } 

    // public function index2()
    // {
    //     $this->template->load('template','REP_dna/index2');
    // } 

    
    public function json() {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');
        // var_dump($date2);
        header('Content-Type: application/json');
        echo $this->REP_dna_model->json($date1,$date2);
    }


    public function excel()
    {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');

        $this->load->database();
        // include('application/config/database.php');
        // include(APPPATH.'config/database.php');

        // Database connection settings
        // $host = 'localhost';
        // $user = 'root';
        // $password = '';

        // Create a database connection
        // $mysqli = new mysqli($host, $user, $password, $database);

        // // Check for connection errors
        // if ($mysqli->connect_error) {
        //     die('Connection failed: ' . $mysqli->connect_error);
        // }        
        $spreadsheet = new Spreadsheet();

        $sheets = array(
            array(
                'DNA_Extraction',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_extraction AS Date_extraction, 
                b.initial AS Lab_tech, a.kit_lot AS Kit_lot, a.sampletype AS Sample_type, 
                a.barcode_dna AS Barcode_DNA, a.weights AS Weights, a.tube_number AS Tube_number, a.cryobox AS Cryobox, 
                a.barcode_metagenomics AS Barcode_metagenomics, a.meta_box AS Meta_box,
                CONCAT("F",d.freezer,"-S",d.shelf,"-R",d.rack,"-DRW",d.rack_level) AS Freezer_Location,
                TRIM(a.comments) AS Comments
                FROM dna_extraction a
                LEFT JOIN ref_person b ON a.id_person=b.id_person 
                LEFT JOIN ref_location_80 d ON a.id_location=d.id_location_80 AND d.lab = "'.$this->session->userdata('lab').'" 
                WHERE  (a.date_extraction >= "'.$date1.'"
                AND a.date_extraction <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_extraction, a.barcode_dna ASC
                ',
                array('Barcode_sample', 'Date_extraction', 'Lab_tech', 'Kit_lot', 'Sample_type', 'Barcode_DNA', 'Weights', 'Tube_number', 'Cryobox',
                        'Barcode_metagenomics', 'Meta_box', 'Freezer_Location', 'Comments'), // Columns for Sheet1
            ),
            array(
                'DNA_Concentration',
                'SELECT a.barcode_dna AS Barcode_DNA, a.date_concentration AS Date_concentration, 
                c.initial AS Lab_tech, b.sampletype AS Sample_type, a.dna_concentration AS DNA_concentration, 
                TRIM(a.comments) AS Comments
                FROM dna_concentration a
                LEFT JOIN dna_extraction b ON a.barcode_dna=b.barcode_dna
                LEFT JOIN ref_person c ON a.id_person=c.id_person 
                WHERE (a.date_concentration >= "'.$date1.'"
                AND a.date_concentration <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_concentration, a.barcode_dna ASC
                ', // Different columns for Sheet2
                array('Barcode_DNA', 'Date_concentration', 'Lab_tech', 'Sample_type', 'DNA_concentration', 'Comments'), // Columns for Sheet2
            ),
            array(
                'DNA_Aliquotting',
                'SELECT c.barcode_dna AS Barcode_DNA, a.date_aliquot AS Date_aliquot, b.initial AS Lab_tech,
                a.barcode_monash AS Barcode_Monash, a.barcode_cambridge AS Barcode_Cambridge, 
                c.row_id AS Row_ID, c.column_id AS Column_ID, TRIM(a.comments) AS Comments
                FROM dna_aliquot a
                LEFT JOIN dna_aliquot_det c ON a. id_dna = c.id_dna
                LEFT JOIN ref_person b ON a.id_person=b.id_person  
                WHERE (a.date_aliquot >= "'.$date1.'"
                AND a.date_aliquot <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_aliquot ASC
                ',
                array('Barcode_DNA', 'Date_aliquot', 'Lab_tech', 'Barcode_Monash',
                'Barcode_Cambridge', 'Row_ID', 'Column_ID', 'Comments'),
            ),
            array(
                'DNA_Sample_Analysis',
                'SELECT a.barcode_dna AS Barcode_DNA, a.date_analysis AS Date_analysis, b.initial AS Lab_tech,
                a.analysis_type AS Analysis_type, a.run_number AS Run_number, 
                a.barcode_array AS Barcode_array, TRIM(a.comments) AS Comments
                FROM dna_sample_analysis a
                LEFT JOIN ref_person b ON a.id_person = b.id_person         
                WHERE (a.date_analysis >= "'.$date1.'"
                AND a.date_analysis <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_analysis ASC
                ',
                array('Barcode_DNA', 'Date_analysis', 'Lab_tech', 'Analysis_type',
                'Run_number', 'Barcode_array', 'Comments'),
            ),
            array(
                'DNA_Nanopore_Analysis',
                'SELECT a.barcode_dna AS Barcode_DNA, a.date_analysis AS Date_analysis, b.initial AS Lab_tech,
                a.barcode_ID AS Barcode_ID, TRIM(a.alias) AS Alias
                FROM dna_nanopore_analysis a
                LEFT JOIN ref_person b ON a.id_person = b.id_person         
                WHERE (a.date_analysis >= "'.$date1.'"
                AND a.date_analysis <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_analysis ASC
                ',
                array('Barcode_DNA', 'Date_analysis', 'Lab_tech', 'Barcode_ID', 'Alias'),
            ),
            // Add more sheets as needed
        );
        
        $spreadsheet->removeSheetByIndex(0);
        foreach ($sheets as $sheetInfo) {
            // Create a new worksheet for each sheet
            $worksheet = $spreadsheet->createSheet();
            $worksheet->setTitle($sheetInfo[0]);
    
            // SQL query to fetch data for this sheet
            $sql = $sheetInfo[1];
            
            // Use the query builder to fetch data
            $query = $this->db->query($sql);
            $result = $query->result_array();
            
            // Column headers for this sheet
            $columns = $sheetInfo[2];
    
            // Add column headers
            $col = 1;
            foreach ($columns as $column) {
                $worksheet->setCellValueByColumnAndRow($col, 1, $column);
                $col++;
            }
    
            // Add data rows
            $row = 2;
            foreach ($result as $row_data) {
                $col = 1;
                foreach ($columns as $column) {
                    $worksheet->setCellValueByColumnAndRow($col, $row, $row_data[$column]);
                    $col++;
                }
                $row++;
            }
        }

        // foreach ($sheets as $sheetInfo) {
        //     // Create a new worksheet for each sheet
        //     $worksheet = $spreadsheet->createSheet();
        //     $worksheet->setTitle($sheetInfo[0]);
        
        //     // SQL query to fetch data for this sheet
        //     $sql = $sheetInfo[1];
        //     $result = $mysqli->query($sql);
        
        //     // Column headers for this sheet
        //     $columns = $sheetInfo[2];
        
        //     // Add column headers
        //     $col = 1;
        //     foreach ($columns as $column) {
        //         $worksheet->setCellValueByColumnAndRow($col, 1, $column);
        //         $col++;
        //     }
        
        //     // Add data rows
        //     $row = 2;
        //     while ($row_data = $result->fetch_assoc()) {
        //         $col = 1;
        //         foreach ($columns as $column) {
        //             $worksheet->setCellValueByColumnAndRow($col, $row, $row_data[$column]);
        //             $col++;
        //         }
        //         $row++;
        //     }
        // }
        
        // Create a new Xlsx writer
        $writer = new Xlsx($spreadsheet);
        
        // Set the HTTP headers to download the Excel file
        $datenow=date("Ymd");
        $filename = 'ALL_DNA_reports_'.$datenow.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
        






        // $date1 =  $this->uri->segment(3);
        // $date2 =  $this->uri->segment(4);

        // $spreadsheet = new Spreadsheet();    
        // $sheet = $spreadsheet->getActiveSheet();
        // // Buat header tabel nya pada baris ke 1
        // $sheet->setCellValue('A1', "ID Delivery"); // Set kolom A3 dengan tulisan "NO"
        // $sheet->setCellValue('B1', "Delivery Number"); // Set kolom B3 dengan tulisan "NIS"
        // $sheet->setCellValue('C1', "Date Delivery"); // Set kolom C3 dengan tulisan "NAMA"
        // $sheet->setCellValue('D1', "Distributor"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        // $sheet->setCellValue('E1', "City"); // Set kolom E3 dengan tulisan "ALAMAT"
        // $sheet->setCellValue('F1', "ID Items");
        // $sheet->setCellValue('G1', "Items Description");
        // $sheet->setCellValue('H1', "Qty");
        // $sheet->getStyle('A1:H1')->getFont()->setBold(true); // Set bold kolom A1
    
        // // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        // $rdeliver = $this->REP_dna_model->get_all($date1, $date2);
    
        // $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        // $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
        // foreach($rdeliver as $data){ // Lakukan looping pada variabel siswa
        //   $sheet->setCellValue('A'.$numrow, $data->id_delivery);
        //   $sheet->setCellValue('B'.$numrow, $data->delivery_number);
        //   $sheet->setCellValue('C'.$numrow, $data->date_delivery);
        //   $sheet->setCellValue('D'.$numrow, $data->customer_name);
        //   $sheet->setCellValue('E'.$numrow, $data->city);
        //   $sheet->setCellValue('F'.$numrow, $data->id_items);
        //   $sheet->setCellValue('G'.$numrow, $data->items);
        //   $sheet->setCellValue('H'.$numrow, $data->qty);
          
        //   $no++; // Tambah 1 setiap kali looping
        //   $numrow++; // Tambah 1 setiap kali looping
        // }
        
        // // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        // $sheet->getDefaultRowDimension()->setRowHeight(-1);
    
        // // Set orientasi kertas jadi LANDSCAPE
        // $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    
        // // Set judul file excel nya
        // $sheet->setTitle("Delivery Reports");
    
        // // Proses file excel
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="REP_dnas.xlsx"'); // Set nama file excel nya
        // header('Cache-Control: max-age=0');
    
        // $writer = new Xlsx($spreadsheet);
        // $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        // $fileName = $fileName.'.csv';
        // $writer->save('php://output');
           
    }

}


/* End of file Tbl_customer.php */
/* Location: ./application/controllers/Tbl_customer.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */