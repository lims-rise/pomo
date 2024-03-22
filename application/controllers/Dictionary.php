<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
class Dictionary extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Dictionary_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	    $this->load->library('uuid');
    }

    public function index()
    {
        // $this->load->model('Dictionary_model');
        // $data['person'] = $this->Dictionary_model->getLabtech();
        // $data['type'] = $this->Dictionary_model->getSampleType();
        // $this->template->load('template','Dictionary/index', $data);  
        $this->template->load('template','Dictionary/index');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Dictionary_model->json();
    }

    public function jsondet() {
        $id = $this->input->get('id1',TRUE);
        // console.log($id); 
        header('Content-Type: application/json');
        echo $this->Dictionary_model->jsondetail($id);
        // echo $this->Dictionary_model->jsondetail();
    }

    public function read($id) 
    {
        $row = $this->Dictionary_model->get_by_id($id);
        if ($row) {
            $data = array(
            'dictionary_id' => $row->dictionary_id,
            'module' => $row->module,
            'subheadings' => $row->subheadings,
            'var_label' => $row->var_label,
	    );
            $this->template->load('template','Dictionary/index_det', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Dictionary'));
        }
    }

    // public function save() 
    // {
    //     $mode = $this->input->post('mode',TRUE);
    //     $id = $this->input->post('id_sample',TRUE);
    //     $dt = new DateTime();

    //     if ($mode=="insert"){
    //         $data = array(
    //         'id_sample' => $this->input->post('id_sample',TRUE),
    //         'sample' => $this->input->post('sample',TRUE),
    //         'uuid' => $this->uuid->v4(),
    //         'lab' => $this->session->userdata('lab'),
    //         'user_created' => $this->session->userdata('id_users'),
    //         'date_created' => $dt->format('Y-m-d H:i:s'),
    //         );
 
    //         $this->Dictionary_model->insert($data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
    //     }
    //     else if ($mode=="edit"){
    //         $data = array(
    //         'id_sample' => $this->input->post('id_sample',TRUE),
    //         'sample' => $this->input->post('sample',TRUE),
    //         'uuid' => $this->uuid->v4(),
    //         'lab' => $this->session->userdata('lab'),
    //         'user_updated' => $this->session->userdata('id_users'),
    //         'date_updated' => $dt->format('Y-m-d H:i:s'),
    //         );

    //         $this->Dictionary_model->update($id, $data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
    //     }

    //     redirect(site_url("Dictionary"));
    // }

    public function delete($id) 
    {
        $row = $this->Dictionary_model->get_by_id($id);
        // $id_user = $this->input->get('id', TRUE);
        // $lab = $this->input->post('id_lab');
        $data = array(
            'flag' => 1,
            );

        if ($row) {
            // $this->Dictionary_model->delete($id);
            $this->Dictionary_model->update($id, $data);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('Dictionary'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Dictionary'));
        }
    }

    public function valid_bs() 
    {
        $id = $this->input->get('id1');
        // echo $id;
        $data = $this->Dictionary_model->validate1($id);

        header('Content-Type: application/json');
        echo json_encode($data);
        // return $this->response->setJSON($data);
        // $data['location'] = $this->O3_filter_paper_model->find_loc($id);
    }


    // public function _rules() 
    // {
	// $this->form_validation->set_rules('delivery_number', 'delivery number', 'trim|required');
	// $this->form_validation->set_rules('date_delivery', 'date delivery', 'trim|required');
	// $this->form_validation->set_rules('id_customer', 'id customer', 'trim|required');
	// $this->form_validation->set_rules('expedisi', 'expedisi', 'trim');
	// $this->form_validation->set_rules('receipt', 'receipt', 'trim');
	// // $this->form_validation->set_rules('sj', 'sj', 'trim|required');
	// $this->form_validation->set_rules('notes', 'notes', 'trim');

	// $this->form_validation->set_rules('id_delivery', 'id_delivery', 'trim');
	// $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    // }


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
                'Dictionary',
                'SELECT 
                id            AS ID,
                module        AS Module,
                subheadings   AS Subheadings,
                `col_name`    AS Column_name,
                var_label     AS Variable_label,
                var_report    AS Variable_report,
                var_type      AS Variable_type,
                `format`      AS `Format`,
                `description` AS `Description`,
                dictionary_id AS Sub_dictionary_id,
                `start_date`  AS `Start_date`,
                end_date      AS End_date,
                comments      AS Comments
                from dictionary 
                ORDER BY module ASC
                ',
                array('ID', 'Module', 'Subheadings', 'Column_name', 'Variable_label', 'Variable_report', 
                'Variable_type', 'Format', 'Description', 'Sub_dictionary_id', 'Start_date', 'End_date', 'Comments'), // Columns for Sheet1
            ),
            array(
                'Sub_Dictionary',
                'SELECT dictionary_id AS Sub_dictionary_id, factor_value AS Factor_value, 
                factor_label AS Factor_label, `start_date` AS `Start_date`, 
                end_date AS End_date, comments AS Comments
                from dictionary_det
                ORDER BY dictionary_id ASC
                ', // Different columns for Sheet2
                array('Sub_dictionary_id', 'Factor_value', 'Factor_label', 'Start_date', 'End_date', 'Comments'), // Columns for Sheet2
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
        $filename = 'Dictionary_reports_'.$datenow.'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
           
    }
}

/* End of file Dictionary.php */
/* Location: ./application/controllers/Dictionary.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */