<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use Google\Client as google_client;
    use Google\Service\Drive as google_drive;


// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
class Approved_po extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Approved_po_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	    $this->load->library('uuid');
    }

    public function index()
    {
        // $this->load->model('Approved_po_model');
        $data['person'] = $this->Approved_po_model->getLabtech();
        $data['objective'] = $this->Approved_po_model->getObjective();
        // $data['freezer'] = $this->Approved_po_model->getFreezer();
        // $data['shelf'] = $this->Approved_po_model->getShelf();
        // $data['rack'] = $this->Approved_po_model->getRack();
        // $data['rack_level'] = $this->Approved_po_model->getDrawer();
        $this->template->load('template','approved_po/index', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Approved_po_model->json();
    }

    public function subjson() {
        $id = $this->input->get('id',TRUE);
        header('Content-Type: application/json');
        echo $this->Approved_po_model->subjson($id);
    }

    public function getSumEstimatePrice($id_req) {
        // Load the model
        // $this->load->model('Approved_po_model');
        // Call the method to get the sum of Estimate Price
        $sumEstimatePrice = $this->Approved_po_model->getSumEstimatePrice($id_req);
    
        // Return the sum of Estimate Price
        echo $sumEstimatePrice;
    }
    public function read($id)
    {
        // $this->template->load('template','Approved_po/index_det', $data);
        // $id_spec = $this->input->post('id_spec',TRUE);
        // $data['unit'] = $this->Approved_po_model->getUnits();
        $row = $this->Approved_po_model->get_detail($id);
        if ($row) {
            // $inv = $this->Approved_po_model->getInv();            
            $data = array(
                'id_req' => $row->id_req,
                'date_req' => $row->date_req,
                'realname' => $row->realname,
                'objective' => $row->objective,
                'title' => $row->title,
                'budget_req' => $row->budget_req,
                'budget_rem' => $row->budget_rem,
                'comments' => $row->comments,
                // 'photo' => $row->photo,
                'unit' => $this->Approved_po_model->getUnits(),
                );
                $this->template->load('template','approved_po/index_det', $data);
        }
        else {
            // $this->template->load('template','Approved_po/index_det');
        }
    } 

    public function save() 
    {
        $mode = $this->input->post('mode',TRUE);
        $id = $this->input->post('id_req',TRUE);
        $foto = $this->upload_foto();
        // $f = $this->input->post('freezer',TRUE);
        // $s = $this->input->post('shelf',TRUE);
        // $r = $this->input->post('rack',TRUE);
        // $rl = $this->input->post('rack_level',TRUE);

        // $freezerloc = $this->Approved_po_model->getFreezLoc($f,$s,$r,$rl);
        $dt = new DateTime();

        if ($mode=="insert"){
            $data = array(
                'po_number' => $this->input->post('po_number',TRUE),
                'date_po' => $this->input->post('date_po',TRUE),
                'id_req' => $this->input->post('id_req',TRUE),
                'comments' => trim($this->input->post('comments',TRUE)),
                'photo' => $foto['file_name'],
                'uuid' => $this->uuid->v4(),
                'user_created' => $this->session->userdata('id_users'),
                'date_created' => $dt->format('Y-m-d H:i:s'),
                );

            $this->Approved_po_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');    
      
        }
        else if ($mode=="edit"){
            $data = array(
                'po_number' => $this->input->post('po_number',TRUE),
                'date_po' => $this->input->post('date_po',TRUE),
                'id_req' => $this->input->post('id_req',TRUE),
                'comments' => trim($this->input->post('comments',TRUE)),
                // 'uuid' => $this->uuid->v4(),
                // 'id_country' => $this->session->userdata('lab'),
                'user_updated' => $this->session->userdata('id_users'),
                'date_updated' => $dt->format('Y-m-d H:i:s'),
                );
                if (!empty($foto['file_name'])) {
                    $data['photo'] = $foto['file_name'];
                }
                
            $this->Approved_po_model->update($id, $data);
            $this->session->set_flashdata('message', 'Create Record Success');    
        }

        $this->session->set_userdata('images',$foto['file_name']);
        redirect(site_url("approved_po"));
    }


    function upload_foto(){
        $config['upload_path']          = './assets/receipt';
        $config['allowed_types']        = 'gif|jpg|png';
        //$config['max_size']             = 100;
        //$config['max_width']            = 1024;
        //$config['max_height']           = 768;
        $this->load->library('upload', $config);
        $this->upload->do_upload('images');
        return $this->upload->data();
    }

    // public function savedetail() 
    // {
    //     $mode = $this->input->post('mode_det',TRUE);
    //     $id_reqdetail = $this->input->post('id_reqdetail',TRUE);
    //     $id_req = $this->input->post('id_req2',TRUE);
    //     $dt = new DateTime();

    //     if ($mode=="insert"){
    //         $data = array(
    //             'id_reqdetail' => $this->input->post('id_reqdetail',TRUE),
    //             'id_req' => $this->input->post('id_req2',TRUE),
    //             'items' => $this->input->post('items',TRUE),
    //             'qty' => $this->input->post('qty',TRUE),
    //             'id_unit' => $this->input->post('id_unit',TRUE),
    //             'estimate_price' => str_replace('.', '', $this->input->post('estimate_price')),
    //             'remarks' => $this->input->post('remarks',TRUE),
    //             'uuid' => $this->uuid->v4(),
    //             // 'lab' => $this->session->userdata('lab'),
    //             'user_created' => $this->session->userdata('id_users'),
    //             'date_created' => $dt->format('Y-m-d H:i:s'),
    //             );

    //         $this->Approved_po_model->insert_det($data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
      
    //     }
    //     else if ($mode=="edit"){
    //         $data = array(
    //             'id_reqdetail' => $this->input->post('id_reqdetail',TRUE),
    //             'id_req' => $this->input->post('id_req2',TRUE),
    //             'items' => $this->input->post('items',TRUE),
    //             'qty' => $this->input->post('qty',TRUE),
    //             'id_unit' => $this->input->post('id_unit',TRUE),
    //             'estimate_price' => str_replace('.', '', $this->input->post('estimate_price')),
    //             'remarks' => $this->input->post('remarks',TRUE),
    //             // 'uuid' => $this->uuid->v4(),
    //             // 'lab' => $this->session->userdata('lab'),
    //             'user_updated' => $this->session->userdata('id_users'),
    //             'date_updated' => $dt->format('Y-m-d H:i:s'),
    //             );
    
    //         $this->Approved_po_model->update_det($id_reqdetail, $data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
    //     }

    //     redirect(site_url("approved_po/read/".$id_req));
    // }
    public function upload()
    {
        $config['upload_path']          = './assets/receipt/';
            $config['allowed_types']='gif|jpg|png|jpeg';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);
            $data = array('error' => false);
            if(!$this->upload->do_upload("image"))
                $data['error'] = $this->upload->display_errors();
            else {
                $upload = $this->upload->data();
                $image = $upload['file_name'];
                $data['data'] =  '<div class="image-area" style="margin-right:25px;">
                <a href="../assets/receipt/'.$image.'" target="_blank"><img src="../assets/receipt/'.$image.'"  alt="Preview"></a>
                                    <a class="remove-image" href="javascript:void(0)" style="display: inline;">&#215;</a>
                                    <input type="hidden" name="image_upload[]" value="'.$image.'">
                                </div>';
            }
            echo json_encode($data);
    }

    public function delete($id) 
    {
        $row = $this->Approved_po_model->get_by_id($id);
        if ($row) {
            $file_name = $row->photo; // Assuming the column name in your database is "file_name"

            // Delete the physical file
            $file_path = './assets/receipt/' . $file_name;
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            $this->Approved_po_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('approved_po'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('approved_po'));
        }
    }

    public function valid_bs()
    {
        $id = $this->input->get('id1');
        $data = $this->Approved_po_model->validate1($id);
        header('Content-Type: application/json');
        echo json_encode($data);
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
        // $date1=$this->input->get('date1');
        // $date2=$this->input->get('date2');

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
                'Approved_PO',
                'SELECT b.po_number AS PO_Number, b.date_po AS Date_PO, b.comments AS Comments, 
                a.date_req AS Date_req, c.realname AS Requested, d.objective AS Objective, a.title AS Title, 
                a.budget_req AS Budget_Request, a.id_country, 
                a.id_person, a.id_objective, a.id_req AS ID_Request, a.flag
                FROM budget_request a
                LEFT JOIN approved_po b ON b.id_req = a.id_req
                LEFT JOIN ref_person c ON a.id_person = c.id_person
                LEFT JOIN ref_objective d ON a.id_objective = d.id_objective
                WHERE a.id_country = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY b.date_po, a.id_req
                ',
                array('ID_Request', 'Date_req', 'PO_Number', 'Date_PO', 'Comments', 'Requested', 
                'Objective', 'Title', 'Budget_Request'), // Columns for Sheet1
            ),
            // array(
            //     'Water_spectro_QC_detail',
            //     'SELECT b.id_dspec AS ID_detail_spectro, b.id_spec AS ID_parent_spectro, b.duplication AS Duplication, 
            //     b.result AS Result, b.trueness AS Trueness, b.bias_method AS Bias_method, b.result2 AS `Result^2`
            //     FROM obj2b_spectro_crm_det b
            //     WHERE b.lab = "'.$this->session->userdata('lab').'" 
            //     AND b.flag = 0 
            //     ORDER BY b.id_spec, b.id_dspec ASC
            //     ', // Different columns for Sheet2
            //     array('ID_detail_spectro', 'ID_parent_spectro', 'Duplication', 'Result', 'Trueness', 'Bias_method', 'Result^2'), // Columns for Sheet2
            // ),
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

        // Create a new Xlsx writer
        $writer = new Xlsx($spreadsheet);
        
        // Set the HTTP headers to download the Excel file
        $datenow=date("Ymd");
        $filename = 'Budget_Approved(PO)_'.$datenow.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
    }


}

/* End of file Approved_po.php */
/* Location: ./application/controllers/Approved_po.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */