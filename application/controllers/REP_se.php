<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once '../../extlib/PHPExcel/PHPExcel.php';

class REP_se extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('REP_se_model');
        // $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','REP_se/index');
    } 

    // public function index2()
    // {
    //     $this->template->load('template','REP_se/index2');
    // } 

    
    public function json() {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');
        // var_dump($date2);
        header('Content-Type: application/json');
        echo $this->REP_se_model->json($date1,$date2);
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
        // $database = '';

        // // Create a database connection
        // $mysqli = new mysqli($host, $user, $password, $database);

        // // Check for connection errors
        // if ($mysqli->connect_error) {
        //     die('Connection failed: ' . $mysqli->connect_error);
        // }        
        $spreadsheet = new Spreadsheet();

        $sheets = array(
            array(
                'Sample_Reception',
                'SELECT barcode_sample AS Barcode_sample, new_barcode AS New_barcode, 
                date_received AS Date_received, lab_received AS Lab_received, person AS Person, 
                sample_type AS Sample_type, obtained AS Obtained, conditions AS Conditions, 
                quarantine AS Quarantine, permit_number AS Permit_number,
                name_email_custodian AS Name_email_custodian, desc_storage AS Desc_storage, 
                loc_storage AS Loc_storage, TRIM(comments) AS Comments
                FROM se_sample_receipt
                WHERE  (date_received >= "'.$date1.'"
                AND date_received <= "'.$date2.'")
                AND lab = "'.$this->session->userdata('lab').'" 
                AND flag = 0 
                ORDER BY date_received, barcode_sample ASC
                ',
                array('Barcode_sample', 'New_barcode', 'Date_received', 'Lab_received', 'Person', 
                'Sample_type', 'Obtained', 'Conditions', 'Quarantine', 'Permit_number', 
                'Name_email_custodian', 'Desc_storage', 'Loc_storage', 'Comments'), // Columns for Sheet1
            ),
            array(
                'Sample_Analysis_Summary',
                'SELECT barcode_sample AS Barcode_sample, date_analysis AS Date_analysis, 
                analysis AS Analysis, person AS Person, TRIM(comments) AS Comments
                FROM se_analysis
                WHERE (date_analysis >= "'.$date1.'"
                AND date_analysis <= "'.$date2.'")
                AND lab = "'.$this->session->userdata('lab').'" 
                AND flag = 0 
                ORDER BY date_analysis, barcode_sample ASC
                ', // Different columns for Sheet2
                array('Barcode_sample', 'Date_analysis', 'Analysis', 'Person', 'Comments'), // Columns for Sheet2
            ),
            array(
                'Sample_Result',
                'SELECT barcode_sample AS Barcode_sample, date_analysis AS Date_analysis, 
                analyte AS Analyte, result AS Result, units AS Units, person AS Person, TRIM(comments) AS Comments
                FROM se_result
                WHERE (date_analysis >= "'.$date1.'"
                AND date_analysis <= "'.$date2.'")
                AND lab = "'.$this->session->userdata('lab').'" 
                AND flag = 0 
                ORDER BY date_analysis, barcode_sample ASC
                ', // Different columns for Sheet2
                array('Barcode_sample', 'Date_analysis', 'Analyte', 'Result', 'Units', 'Person', 'Comments'), // Columns for Sheet2
            ),
            array(
                'Sample_Ended',
                'SELECT barcode_sample AS Barcode_sample, date_ended AS Date_ended, 
                lab_sample_end AS Lab_sample_end, TRIM(comments) AS Comments
                FROM se_sample_ended
                WHERE (date_ended >= "'.$date1.'"
                AND date_ended <= "'.$date2.'")
                AND lab = "'.$this->session->userdata('lab').'" 
                AND flag = 0 
                ORDER BY date_ended, barcode_sample ASC
                ', // Different columns for Sheet2
                array('Barcode_sample', 'Date_ended', 'Lab_sample_end', 'Comments'), // Columns for Sheet2
            ),
            array(
                'Sample_Sent_to_Other_Lab',
                'SELECT barcode_sample AS Barcode_sample, date_shipped AS Date_shipped, 
                volume AS Volume, destination AS Destination, custodian AS Custodian, TRIM(comments) AS Comments
                FROM se_sample_sent
                WHERE (date_shipped >= "'.$date1.'"
                AND date_shipped <= "'.$date2.'")
                AND lab = "'.$this->session->userdata('lab').'" 
                AND flag = 0 
                ORDER BY date_shipped, barcode_sample ASC
                ', // Different columns for Sheet2
                array('Barcode_sample', 'Date_shipped', 'Volume', 'Destination', 'Custodian', 'Comments'), // Columns for Sheet2
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
        // $rdeliver = $this->REP_se_model->get_all($date1, $date2);
    
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
        // header('Content-Disposition: attachment; filename="REP_ses.xlsx"'); // Set nama file excel nya
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