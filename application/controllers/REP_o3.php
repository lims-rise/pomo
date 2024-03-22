<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once '../../extlib/PHPExcel/PHPExcel.php';

class REP_o3 extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('REP_o3_model');
        // $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','REP_o3/index');
    } 

    // public function index2()
    // {
    //     $this->template->load('template','REP_o3/index2');
    // } 

    
    public function json() {
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');

        // var_dump($date2);
        header('Content-Type: application/json');
        echo $this->REP_o3_model->json($date1,$date2);
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
                'SELECT a.barcode_sample AS Barcode_sample, a.date_receipt AS Date_receipt, a.time_receipt AS Time_receipt, 
                b.initial AS Lab_tech, c.sampletype AS Sample_type, a.png_control AS PnG_control, a.cold_chain AS Cold_chain, 
                a.cont_intact AS Cont_intact, TRIM(a.comments) AS Comments 
                FROM obj3_sam_rec a
                left join ref_person b on a.id_person = b.id_person
                left join ref_sampletype c on a.id_type = c.id_sampletype
                WHERE  (a.date_receipt >= "'.$date1.'"
                AND a.date_receipt <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_receipt, a.time_receipt ASC
                ',
                array('Barcode_sample', 'Date_receipt', 'Time_receipt', 'Lab_tech', 'Sample_type', 'PnG_control',
                    'Cold_chain', 'Cont_intact', 'Comments'), // Columns for Sheet1
            ),
            array(
                'Blood_centrifuge',
                'SELECT a.ID AS ID, a.date_process AS Date_process, c.initial AS Lab_tech, 
                a.centrifuge_time AS Centrifuge_time, TRIM(a.comments) AS Comments, b.barcode_sample AS Barcode_sample, b.comments AS Comments_sample
                FROM obj3_blood_centrifuge a
                LEFT JOIN obj3_blood_centrifuge_det b ON a.id = b.id_bc
                LEFT JOIN ref_person c ON a.id_person = c.id_person
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process ASC
                ', // Different columns for Sheet2
                array('ID', 'Date_process', 'Lab_tech', 'Centrifuge_time', 'Comments', 'Barcode_sample', 'Comments_sample'), // Columns for Sheet2
            ),
            array(
                'EDTA_Aliquots',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, b.initial AS Lab_tech, 
                a.hemolysis AS Hemolysis, a.barcode_wb AS Barcode_Wholeblood, a.vol_aliquotwb AS Volume_wholeblood, 
                a.cryoboxwb AS Cryobox_wholeblood, a.barcode_p1a AS Barcode_plasma1, a.vol_aliquot1 AS Volume_aliquot1, 
                a.cryobox1 AS Cryobox1, a.barcode_p2a AS Barcode_plasma2, a.vol_aliquot2 AS Volume_aliquot2, 
                a.cryobox2 AS Cryobox2, a.barcode_p3a AS Barcode_plasma3, a.vol_aliquot3 AS Volume_aliquot3, 
                a.cryobox3 AS Cryobox3, a.packed_cells AS Packed_cells, a.cryobox_pc AS Cryobox_packed_cells, 
                TRIM(a.comments) AS Comments
                from obj3_edta_aliquots a 
                left join ref_person b on a.id_person = b.id_person
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Lab_tech', 'Hemolysis', 'Barcode_Wholeblood',
                'Volume_wholeblood', 'Cryobox_wholeblood', 'Barcode_plasma1', 'Volume_aliquot1', 'Cryobox1',
                'Barcode_plasma2', 'Volume_aliquot2', 'Cryobox2', 'Barcode_plasma3', 'Volume_aliquot3', 'Cryobox3',
                'Packed_cells', 'Cryobox_packed_cells', 'Comments'),
            ),
            array(
                'SST_Aliquots',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, b.initial AS Lab_tech, 
                a.barcode_sst1 AS Barcode_SST1, a.vol_aliquot1 AS Vol_aliquot1, a.cryobox1 AS Cryobox1,
                a.barcode_sst2 AS Barcode_SST2, a.vol_aliquot2 AS Vol_aliquot2, a.cryobox2 AS Cryobox2, 
                TRIM(a.comments) AS Comments
                from obj3_sst_aliquots a 
                left join ref_person b on a.id_person = b.id_person
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Lab_tech', 'Barcode_SST1', 'Vol_aliquot1',
                'Cryobox1', 'Barcode_SST2', 'Vol_aliquot2', 'Cryobox2', 'Comments'),
            ),
            array(
                'Filter_Paper',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, 
                a.time_process AS Time_process, b.initial AS Lab_tech, a.freezer_bag AS Freezer_bag,
                concat("F",c.freezer,"-","S",c.shelf,"-","R",c.rack,"-","DRW",c.rack_level) AS Freezer_location, 
                TRIM(a.comments) AS Comments 
                from obj3_bfilterpaper a 
                left join ref_person b on a.id_person = b.id_person 
                left join ref_location_80 c on a.id_location_80 = c.id_location_80 AND c.lab = "'.$this->session->userdata('lab').'" 
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process, a.time_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Time_process', 'Lab_tech', 'Freezer_bag', 
                'Freezer_location', 'Comments'),
            ),
            array(
                'Feces_KK1',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, 
                a.time_process AS Time_process, b.initial AS Lab_tech, a.bar_kkslide AS Barcode_kkslide, TRIM(a.comments) AS Comments
                from obj3_fkk1 a 
                left join ref_person b on a.id_person = b.id_person                    
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process, a.time_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Time_process', 'Lab_tech', 'Barcode_kkslide', 'Comments'),
            ),
            array(
                'Feces_Aliquots',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, 
                a.time_process AS Time_process, b.initial AS Lab_tech, a.cons_stool AS Cons_stool, 
                a.color_stool AS Color_stool, a.abnormal AS Abnormal, a.ab_other AS Abnormal_note, 
                a.aliquot1 AS Aliquot1, a.volume1 AS Volume1, a.cryobox1 AS Cryobox1, 
                a.aliquot2 AS Aliquot2, a.volume2 AS Volume2, a.cryobox2 AS Cryobox2,
                a.aliquot3 AS Aliquot3, a.volume3 AS Volume3, a.cryobox3 AS Cryobox3, 
                a.aliquot_zymo AS Aliquot_zymo, a.volume_zymo AS Volume_zymo, 
                a.batch_zymo AS Batch_zymo, a.cryobox_zymo AS Cryobox_zymo, TRIM(a.comments) AS Comments
                from (obj3_faliquot a left join ref_person b on((a.id_person = b.id_person)))                              
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process, a.time_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Time_process', 'Lab_tech', 'Cons_stool', 
                'Color_stool', 'Abnormal', 'Abnormal_note', 'Aliquot1', 'Volume1', 
                'Cryobox1', 'Aliquot2', 'Volume2', 'Cryobox2', 'Aliquot3',                                 
                'Volume3', 'Cryobox3', 'Aliquot_zymo', 'Volume_zymo', 'Batch_zymo',                                 
                'Cryobox_zymo', 'Comments'),
            ),
            array(
                'Feces_Macconkey1',
                'SELECT a.barcode_sample AS Barcode_sample, a.date_process AS Date_process, 
                a.time_process AS Time_process, b.initial AS Lab_tech, a.bar_macconkey AS Barcode_macconkey, 
                TRIM(a.comments) AS Comments
                from obj3_fmac1 a 
                left join ref_person b on a.id_person = b.id_person 
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process, a.time_process ASC
                ',
                array('Barcode_sample', 'Date_process', 'Time_process', 'Lab_tech', 'Barcode_macconkey', 'Comments'),
            ),
            array(
                'Feces_Macconkey2',
                'SELECT a.bar_macconkey AS Barcode_macconkey, a.date_process AS Date_process, 
                a.time_process AS Time_process, b.initial AS Lab_tech, 
                a.bar_macsweep1 AS Barcode_macsweep1, a.cryobox1 AS Cryobox1,
                a.bar_macsweep2 AS Barcode_macsweep2, a.cryobox2 AS Cryobox2, TRIM(a.comments) AS Comments
                from obj3_fmac2 a 
                left join ref_person b on a.id_person = b.id_person            
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process, a.time_process ASC
                ',
                array('Barcode_macconkey', 'Date_process', 'Time_process', 'Lab_tech', 'Barcode_macsweep1',
                'Cryobox1', 'Barcode_macsweep2', 'Cryobox2', 'Comments'),
            ),
            array(
                'Feces_KK2',
                'SELECT a.bar_kkslide AS Barcode_kkslide, a.date_process AS Date_process, 
                b.initial AS Person_Read, c.initial AS Person_Write, a.duration AS Duration, 
                a.start_time AS Start_time, a.end_time AS End_time, 
                a.ascaris AS AscarisLumbricoides, a.ascaris_com AS AscarisLumbricoides_comment, 
                a.hookworm AS Hookworm, a.hookworm_com AS Hookworm_comment, 
                a.trichuris AS TrichurisTrichura, a.trichuris_com AS TrichurisTrichura_comment, 
                a.strongyloides AS StrongyloidesStercoralis, a.strongyloides_com AS StrongyloidesStercoralis_comment,
                a.taenia AS TaeniaSpss, a.taenia_com AS TaeniaSpss_comment, 
                a.other AS Other, a.other_com AS Other_comment, TRIM(a.comments) AS GeneralComments,
                a.finalized AS Finalized
                from obj3_fkk2 a 
                left join ref_person b on a.id_person = b.id_person
                left join ref_person c on a.id_person2 = c.id_person           
                WHERE (a.date_process >= "'.$date1.'"
                AND a.date_process <= "'.$date2.'")
                AND a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_process ASC
                ',
                array('Barcode_kkslide', 'Date_process', 'Person_Read', 'Person_Write', 'Duration',
                'Start_time', 'End_time', 'AscarisLumbricoides', 'AscarisLumbricoides_comment', 
                'Hookworm', 'Hookworm_comment', 'TrichurisTrichura', 'TrichurisTrichura_comment', 
                'StrongyloidesStercoralis', 'StrongyloidesStercoralis_comment', 'TaeniaSpss', 
                'TaeniaSpss_comment', 'Other', 'Other_comment', 'GeneralComments', 'Finalized'),
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
        $filename = 'ALL_O3_reports_'.$datenow.'.xlsx';
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
        // $rdeliver = $this->REP_o3_model->get_all($date1, $date2);
    
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
        // header('Content-Disposition: attachment; filename="REP_o3s.xlsx"'); // Set nama file excel nya
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