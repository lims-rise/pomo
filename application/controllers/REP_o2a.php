<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once '../../extlib/PHPExcel/PHPExcel.php';

class REP_o2a extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('REP_o2a_model');
        // $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','REP_o2a/index');
    } 

    // public function index2()
    // {
    //     $this->template->load('template','REP_o2a/index2');
    // } 

    
    public function json() {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');
        // var_dump($date2);
        header('Content-Type: application/json');
        echo $this->REP_o2a_model->json($date1,$date2);
    }


    public function excel()
    {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');

        $this->load->database();

        // Database connection settings
        // $host = 'localhost';
        // $user = 'root';
        // $password = '';

        // // Create a database connection
        // $mysqli = new mysqli($host, $user, $password, $database);

        // // Check for connection errors
        // if ($mysqli->connect_error) {
        //     die('Connection failed: ' . $mysqli->connect_error);
        // }        
        $spreadsheet = new Spreadsheet();

        $sheets = array(
            array(
                'Sample_reception',
                'SELECT b.barcode_sample AS Barcode_storagebag, a.date_receipt AS Date_receipt, 
                c.initial AS Delivered_by, d.initial AS Received_by, a.sample_type AS Sample_type
                from obj2a_receipt a 
                LEFT JOIN obj2a_receipt_det b ON a.id_receipt = b.id_receipt
                LEFT JOIN ref_person c ON a.id_delivered = c.id_person
                LEFT JOIN ref_person d ON a.id_received = d.id_person
                WHERE  (a.date_receipt >= "'.$date1.'"
                AND a.date_receipt <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_receipt, A.id_receipt
                ',
                array('Barcode_storagebag', 'Date_receipt', 'Delivered_by', 'Received_by', 'Sample_type'), // Columns for Sheet1
            ),
            array(
                'Sample_logging',
                'SELECT a.id_samplelog AS ID, a.date_collection AS Date_collection, 
                b.initial AS Lab_tech, a.bar_samplebag AS Barcode_samplebag, 
                a.bar_eclosion AS Barcode_eclosion, a.id_person,
                a.lab, a.flag
                from obj2a_samplelog a
                left join ref_person b on a.id_person = b.id_person 
                WHERE (a.date_collection >= "'.$date1.'"
                AND a.date_collection <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_collection, a.id_samplelog ASC
                ', // Different columns for Sheet2
                array('ID', 'Date_collection', 'Lab_tech', 'Barcode_samplebag', 'Barcode_eclosion'), // Columns for Sheet2
            ),
            array(
                'Mosquito_Identification',
                'SELECT a.bar_storagebag AS Barcode_storagebag,
                b.initial AS Initial_Person,
                a.date_ident AS Date_identification,
                a.catch_met AS Catch_methode,
                a.no_mosquito AS SumMosquito,
                a.aedes_aegypt_male AS Aedes_aegypt_male,
                a.aedes_aegypt_female AS Aedes_aegypt_female,
                a.aedes_albopictus_male AS Aedes_albopictus_male,
                a.aedes_albopictus_female AS Aedes_albopictus_female,
                a.aedes_polynesiensis_male AS Aedes_polynesiensis_male,
                a.aedes_polynesiensis_female AS Aedes_polynesiensis_female,
                a.aedes_other_male AS Aedes_other_male,
                a.aedes_other_female AS Aedes_other_female,
                a.culex_male AS Culex_male,
                a.culex_female AS Culex_female,
                a.culex_sitiens_male AS Culex_sitiens_male,
                a.culex_sitiens_female AS Culex_sitiens_female,
                a.culexann_male AS Culexann_male,
                a.culexann_female AS Culexann_female,
                a.culex_other_male AS Culex_other_male,
                a.culex_other_female AS Culex_other_female,
                a.anopheles_male AS Anopheles_male,
                a.anopheles_female AS Anopheles_female,
                a.uranotaenia_male AS Uranotaenia_male,
                a.uranotaenia_female AS Uranotaenia_female,
                a.mansonia_male AS Mansonia_male,
                a.mansonia_female AS Mansonia_female,
                a.other_male AS Other_male,
                a.other_female AS Other_female,
                IFNULL(a.culex_larvae,0) AS Culex_larvae,
                IFNULL(a.aedes_larvae,0) AS Aedes_larvae,
                IFNULL(a.unidentify,0) AS Unidentify,
                TRIM(a.notes) AS Notes,
                a.id_person AS id_person,
                a.lab AS lab,
                a.flag AS flag
            FROM
                obj2a_identification a 
                LEFT JOIN ref_person b ON a.id_person = b.id_person  
                WHERE (a.date_ident >= "'.$date1.'"
                AND a.date_ident <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_ident ASC
                ',
                array('Barcode_storagebag', 'Initial_Person', 'Date_identification', 'Catch_methode',
                'SumMosquito', 'Aedes_aegypt_male', 'Aedes_aegypt_female', 'Aedes_albopictus_male', 
                'Aedes_albopictus_female', 'Aedes_polynesiensis_male', 'Aedes_polynesiensis_female',
                'Aedes_other_male', 'Aedes_other_female', 'Culex_male', 'Culex_female', 'Culex_sitiens_male',
                'Culex_sitiens_female', 'Culexann_male', 'Culexann_female', 'Culex_other_male',
                'Culex_other_female','Anopheles_male','Anopheles_female','Uranotaenia_male',
                'Uranotaenia_female','Mansonia_male','Mansonia_female','Other_male','Other_female',
                'Culex_larvae', 'Aedes_larvae', 'Unidentify', 'Notes'),
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
        $filename = 'ALL_O2A_reports_'.$datenow.'.xlsx';
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
        // $rdeliver = $this->REP_o2a_model->get_all($date1, $date2);
    
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
        // header('Content-Disposition: attachment; filename="REP_o2as.xlsx"'); // Set nama file excel nya
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