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
    
class budget_request extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('budget_request_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	    $this->load->library('uuid');
    }

    public function index()
    {
        // $this->load->model('budget_request_model');
        $data['person'] = $this->budget_request_model->getLabtech();
        $data['objective'] = $this->budget_request_model->getObjective();
        // $data['freezer'] = $this->budget_request_model->getFreezer();
        // $data['shelf'] = $this->budget_request_model->getShelf();
        // $data['rack'] = $this->budget_request_model->getRack();
        // $data['rack_level'] = $this->budget_request_model->getDrawer();
        $this->template->load('template','budget_request/index', $data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->budget_request_model->json();
    }

    public function subjson() {
        $id = $this->input->get('id',TRUE);
        header('Content-Type: application/json');
        echo $this->budget_request_model->subjson($id);
    }

    public function getSumEstimatePrice($id_req) {
        // Load the model
        // $this->load->model('budget_request_model');
        // Call the method to get the sum of Estimate Price
        $sumEstimatePrice = $this->budget_request_model->getSumEstimatePrice($id_req);
    
        // Return the sum of Estimate Price
        echo $sumEstimatePrice;
    }
    public function read($id)
    {
        // $this->template->load('template','budget_request/index_det', $data);
        // $id_spec = $this->input->post('id_spec',TRUE);
        // $data['unit'] = $this->budget_request_model->getUnits();
        $row = $this->budget_request_model->get_detail($id);
        if ($row) {
            // $inv = $this->budget_request_model->getInv();            
            $data = array(
                'id_req' => $row->id_req,
                'date_req' => $row->date_req,
                'realname' => $row->realname,
                'objective' => $row->objective,
                'title' => $row->title,
                'budget_req' => $row->budget_req,
                'budget_rem' => $row->budget_rem,
                'comments' => $row->comments,
                'unit' => $this->budget_request_model->getUnits(),
                );
                $this->template->load('template','budget_request/index_det', $data);
        }
        else {
            // $this->template->load('template','budget_request/index_det');
        }
    } 

    public function save() 
    {
        $mode = $this->input->post('mode',TRUE);
        $id = $this->input->post('id_req',TRUE);
        // $f = $this->input->post('freezer',TRUE);
        // $s = $this->input->post('shelf',TRUE);
        // $r = $this->input->post('rack',TRUE);
        // $rl = $this->input->post('rack_level',TRUE);

        // $freezerloc = $this->budget_request_model->getFreezLoc($f,$s,$r,$rl);
        $dt = new DateTime();

        if ($mode=="insert"){
            $data = array(
                'date_req' => $this->input->post('date_req',TRUE),
                'id_person' => $this->input->post('id_person',TRUE),
                'id_objective' => $this->input->post('id_objective',TRUE),
                'title' => $this->input->post('title',TRUE),
                'budget_req' => str_replace('.', '', $this->input->post('budget_req')),
                'comments' => trim($this->input->post('comments',TRUE)),
                'uuid' => $this->uuid->v4(),
                'id_country' => $this->session->userdata('lab'),
                'user_created' => $this->session->userdata('id_users'),
                'date_created' => $dt->format('Y-m-d H:i:s'),
                );

            $this->budget_request_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');    
      
        }
        else if ($mode=="edit"){
            $data = array(
                'date_req' => $this->input->post('date_req',TRUE),
                'id_person' => $this->input->post('id_person',TRUE),
                'id_objective' => $this->input->post('id_objective',TRUE),
                'title' => $this->input->post('title',TRUE),
                'budget_req' => str_replace('.', '', $this->input->post('budget_req')),
                'comments' => trim($this->input->post('comments',TRUE)),
                // 'uuid' => $this->uuid->v4(),
                'id_country' => $this->session->userdata('lab'),
                'user_updated' => $this->session->userdata('id_users'),
                'date_updated' => $dt->format('Y-m-d H:i:s'),
                );
    
            $this->budget_request_model->update($id, $data);
            $this->session->set_flashdata('message', 'Create Record Success');    
        }

        redirect(site_url("budget_request"));
    }


    public function savedetail() 
    {
        $mode = $this->input->post('mode_det',TRUE);
        $id_reqdetail = $this->input->post('id_reqdetail',TRUE);
        $id_req = $this->input->post('id_req2',TRUE);
        $dt = new DateTime();

        if ($mode=="insert"){
            $data = array(
                'id_reqdetail' => $this->input->post('id_reqdetail',TRUE),
                'id_req' => $this->input->post('id_req2',TRUE),
                'items' => $this->input->post('items',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'id_unit' => $this->input->post('id_unit',TRUE),
                'estimate_price' => str_replace('.', '', $this->input->post('estimate_price')),
                'remarks' => $this->input->post('remarks',TRUE),
                'uuid' => $this->uuid->v4(),
                // 'lab' => $this->session->userdata('lab'),
                'user_created' => $this->session->userdata('id_users'),
                'date_created' => $dt->format('Y-m-d H:i:s'),
                );

            $this->budget_request_model->insert_det($data);
            $this->session->set_flashdata('message', 'Create Record Success');    
      
        }
        else if ($mode=="edit"){
            $data = array(
                'id_reqdetail' => $this->input->post('id_reqdetail',TRUE),
                'id_req' => $this->input->post('id_req2',TRUE),
                'items' => $this->input->post('items',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'id_unit' => $this->input->post('id_unit',TRUE),
                'estimate_price' => str_replace('.', '', $this->input->post('estimate_price')),
                'remarks' => $this->input->post('remarks',TRUE),
                // 'uuid' => $this->uuid->v4(),
                // 'lab' => $this->session->userdata('lab'),
                'user_updated' => $this->session->userdata('id_users'),
                'date_updated' => $dt->format('Y-m-d H:i:s'),
                );
    
            $this->budget_request_model->update_det($id_reqdetail, $data);
            $this->session->set_flashdata('message', 'Create Record Success');    
        }

        redirect(site_url("budget_request/read/".$id_req));
    }

    public function budreq_print($id) 
    {
        $row = $this->budget_request_model->get_rep($id);
        if ($row) {
            $data = array(
            'id_req' => $row->id_req,
            'date_req' => $row->date_req,
            'realname' => $row->realname,
            'objective' => $row->objective,
            'title' => $row->title,
            'periode' => $row->periode,
            'budget_req' => $row->budget_req,
            'reviewed' => $row->reviewed,
            'approved' => $row->approved,
            'comments' => $row->comments,
            );
        // $data['items'] = $this->Tbl_receive_old_model->getItems();
            $this->template->load('template','budget_request/index_rep', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url("budget_request/read/".$id));
        }
    }

    // public function spec_printdet() 
    // {
    //     $id = $this->input->post('id',TRUE);
    //     header('Content-Type: application/json');
    //     echo $this->budget_request_model->get_repdet($id);
    // }    

    public function delete($id) 
    {
        $row = $this->budget_request_model->get_by_id($id);
        $data = array(
            'flag' => 1,
            );

        if ($row) {
            $this->budget_request_model->update($id, $data);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('budget_request'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('budget_request'));
        }
    }

    public function valid_bs()
    {
        $id = $this->input->get('id1');
        $type = $this->input->get('id2');
        $data = $this->budget_request_model->validate1($id, $type);
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
        $this->load->database();

        $spreadsheet = new Spreadsheet();

        $sheets = array(
            array(
                'Budget_request',
                'SELECT a.id_req AS ID_Request, a.date_req AS Date_Request, c.objective AS Objective, 
                a.title AS Title, b.realname AS Requested, a.budget_req AS Budget_req, a.comments AS Comments
                FROM budget_request a
                LEFT JOIN ref_person b ON a.id_person=b.id_person
                LEFT JOIN ref_objective c ON a.id_objective=c.id_objective                
                WHERE a.id_country = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_req, a.id_req
                ',
                array('ID_Request', 'Date_Request', 'Objective', 'Title', 'Requested', 
                'Budget_req', 'Comments'), // Columns for Sheet1
            ),
            array(
                'Budget_request_detail',
                'SELECT a.id_req AS ID_Request, a.id_reqdetail AS ID_Request_Det, a.items AS Descriptions, 
                a.qty AS Qty, b.unit AS Unit, a.estimate_price AS Estimate_price, a.remarks AS Remarks 
                FROM budget_request_detail a
                LEFT JOIN budget_request c ON a.id_req=c.id_req
                LEFT JOIN ref_unit b ON a.id_unit=b.id_unit
                WHERE 
                c.id_country = "'.$this->session->userdata('lab').'" 
                AND b.flag = 0 
                ORDER BY a.id_reqdetail ASC
                ', // Different columns for Sheet2
                array('ID_Request', 'ID_Request_Det', 'Descriptions', 'Qty', 'Unit', 'Estimate_price', 'Remarks'), // Columns for Sheet2
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
            
            // var_dump($result); 
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
        $filename = 'Budget_Request_'.$datenow.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
    }

    public function excel_print($id)
	{
        /* Data */
        $data = $this->budget_request_model->get_all_with_detail_excel($id);

        /* Spreadsheet Init */
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $hcolumn = 'A';
        $hrow = 1;

        $sheet->getColumnDimension('A')->setWidth(5); // Set width for column A
        $sheet->getColumnDimension('B')->setWidth(30); // Set width for column B
        $sheet->getColumnDimension('C')->setWidth(5); // Set width for column B
        $sheet->getColumnDimension('D')->setWidth(7); // Set width for column B
        $sheet->getColumnDimension('E')->setWidth(15); // Set width for column B
        $sheet->getColumnDimension('F')->setWidth(17); // Set width for column B
        $sheet->getColumnDimension('G')->setWidth(30); // Set width for column B

        //logo
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Monash');
        $drawing->setDescription('Monash');
        $drawing->setPath('img/rise_logo_x.jpg'); // put your path and image here
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(10);
        // $drawing->setRotation(25);
        // $drawing->getShadow()->setVisible(true);
        // $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Monash2');
        $drawing->setDescription('Monash2');
        $drawing->setPath('img/monash.png'); // put your path and image here
        $drawing->setCoordinates('G1');
        $drawing->setOffsetX(70);
        $drawing->setOffsetY(0); // Adjust the vertical offset

        // $drawing->setRotation(25);
        // $drawing->getShadow()->setVisible(true);
        // $drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        
        // $sheet->setCellValue('C2', "RISE Makassar | Budget Request ");
        // $sheet->setCellValue('C3', $data->objective);
        // $sheet->setCellValue('C4', $data->title);
        // $sheet->setCellValue('F6', "RISE - " . date('Y-m-d'));

        /* Excel Header */
        $start = 8;
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "No");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Description");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Qty");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Unit");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Unit Price IDR");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Total Price IDR");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Remark");
        
        /* Excel Data */
        $row_number = $start+1;

        foreach($data as $key => $row)
        {
            $sheet->getStyle('C2')->getFont()->setBold(true);        
            $sheet->setCellValue('C2', "RISE Makassar | Budget Request");
            $sheet->getStyle('C3')->getFont()->setBold(true);        
            $sheet->setCellValue('C3', $row->objective);
            $sheet->getStyle('C4')->getFont()->setBold(true);        
            $sheet->setCellValue('C4', $row->title);
            $sheet->setCellValue('G6', "Date : " . $row->date_req);

            $column = 'A';
            $sheet->setCellValue($column++ .$row_number, $key+1);
            $sheet->setCellValue($column++ .$row_number, $row->items);
            $sheet->setCellValue($column++ .$row_number, $row->qty);
            $sheet->setCellValue($column++ .$row_number, $row->unit);
            $sheet->getStyle($column.$row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue($column++ .$row_number, $row->estimate_price);
            $sheet->getStyle($column.$row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue($column++ .$row_number, $row->total);
            $sheet->setCellValue($column++ .$row_number, $row->remarks);
            $row_number++;
        }
        $sheet->getStyle('F' .$row_number)->getFont()->setBold(true);        
        $sheet->setCellValue('F' .$row_number, $row->sum_tot);
        $row_number++;

        $row_ex = $row_number+1;
        $sheet->getStyle('A' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('A' .$row_ex, "Prepared,");
        $sheet->getStyle('D' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('D' .$row_ex, "Reviewed,");
        $sheet->getStyle('G' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('G' .$row_ex, "Approved,");

        $row_ex2 = $row_ex+4;
        $sheet->setCellValue('A' .$row_ex2, $row->realname);
        $sheet->setCellValue('D' .$row_ex2, $row->reviewed);
        $sheet->setCellValue('G' .$row_ex2, $row->approved);

        $row_number--;
        $sheet->getStyle("A8:G".$row_number)->applyFromArray(
            array(
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => ['argb' => '000000'],
                    ],
                ],
            )
        );

        /* Excel File Format */
        $writer = new Xlsx($spreadsheet);
        ob_clean();
        $filename = 'Budget_Request_' . date('Ymd');
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }


    // public function excel()
    // {
    //     $spreadsheet = new Spreadsheet();    
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', "ID_spectro"); 
    //     $sheet->setCellValue('B1', "Date_spectro"); 
    //     $sheet->setCellValue('C1', "Lab_tech");
    //     $sheet->setCellValue('D1', "Chemistry_parameter");
    //     $sheet->setCellValue('E1', "Mixture_name");
    //     $sheet->setCellValue('F1', "Sample_number");
    //     $sheet->setCellValue('G1', "Lot_number");
    //     $sheet->setCellValue('G1', "Date_expired");
    //     $sheet->setCellValue('G1', "Certified_value");
    //     $sheet->setCellValue('G1', "Uncertainty");
    //     $sheet->setCellValue('G1', "Comments");

    //     // $sheet->getStyle('A1:H1')->getFont()->setBold(true); // Set bold kolom A1

    //     // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
    //     $rdeliver = $this->budget_request_model->get_all();
    
    //     // $no = 1; // Untuk penomoran tabel, di awal set dengan 1
    //     $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
    //     foreach($rdeliver as $data){ // Lakukan looping pada variabel siswa
    //       $sheet->setCellValue('A'.$numrow, $data->barcode_sample);
    //       $sheet->setCellValue('B'.$numrow, $data->date_process);
    //       $sheet->setCellValue('C'.$numrow, $data->time_process);
    //       $sheet->setCellValue('D'.$numrow, $data->initial);
    //       $sheet->setCellValue('E'.$numrow, $data->freezer_bag);
    //       $sheet->setCellValue('F'.$numrow, $data->location);
    //       $sheet->setCellValue('G'.$numrow, $data->comments);
    //       $numrow++; // Tambah 1 setiap kali looping
    //     }
    // $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
    // $datenow=date("Ymd");
    // $fileName = 'budget_request_'.$datenow.'.csv';

    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header("Content-Disposition: attachment; filename=$fileName"); // Set nama file excel nya
    // header('Cache-Control: max-age=0');

    // $writer->save('php://output');
    // }
}

/* End of file budget_request.php */
/* Location: ./application/controllers/budget_request.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */