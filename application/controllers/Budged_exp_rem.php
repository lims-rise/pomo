<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Reader\Csv;
    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    use Google\Client as google_client;
    use Google\Service\Drive as google_drive;


// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
class Budged_exp_rem extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Budged_exp_rem_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	    $this->load->library('uuid');
    }

    public function index()
    {
        // $this->load->model('Budged_exp_rem_model');
        // $data['person'] = $this->Budged_exp_rem_model->getLabtech();
        // $data['objective'] = $this->Budged_exp_rem_model->getObjective();
        // $data['freezer'] = $this->Budged_exp_rem_model->getFreezer();
        // $data['shelf'] = $this->Budged_exp_rem_model->getShelf();
        // $data['rack'] = $this->Budged_exp_rem_model->getRack();
        // $data['rack_level'] = $this->Budged_exp_rem_model->getDrawer();
        $this->template->load('template','Budged_exp_rem/index');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Budged_exp_rem_model->json();
    }

    public function subjson() {
        $id = $this->input->get('id',TRUE);
        header('Content-Type: application/json');
        echo $this->Budged_exp_rem_model->subjson($id);
    }

    public function getSumEstimatePrice($id_req) {
        // Load the model
        // $this->load->model('Budged_exp_rem_model');
        // Call the method to get the sum of Estimate Price
        $sumEstimatePrice = $this->Budged_exp_rem_model->getSumEstimatePrice($id_req);
    
        // Return the sum of Estimate Price
        echo $sumEstimatePrice;
    }
    
    public function read($id)
    {
        // $this->template->load('template','Budged_exp_rem/index_det', $data);
        // $id_spec = $this->input->post('id_spec',TRUE);
        // $data['unit'] = $this->Budged_exp_rem_model->getUnits();
        $row = $this->Budged_exp_rem_model->get_detail($id);
        if ($row) {
            // $inv = $this->Budged_exp_rem_model->getInv();            
            $data = array(
                'po_number' => $row->po_number,
                'date_req' => $row->date_req,
                'new_title' => $row->new_title,
                'sum_tot' => $row->sum_tot,
                'budged_tot' => $row->budged_tot,
                'rem_rem' => $row->rem_rem,
                'id_reqrem' => $row->id_reqrem,
                'unit' => $this->Budged_exp_rem_model->getUnits(),
                );
                $this->template->load('template','Budged_exp_rem/index_det', $data);
        }
        else {
            // $this->template->load('template','Budged_exp_rem/index_det');
        }
    } 

    // public function save() 
    // {
    //     $mode = $this->input->post('mode',TRUE);
    //     $id = $this->input->post('id_req',TRUE);
    //     // $f = $this->input->post('freezer',TRUE);
    //     // $s = $this->input->post('shelf',TRUE);
    //     // $r = $this->input->post('rack',TRUE);
    //     // $rl = $this->input->post('rack_level',TRUE);

    //     // $freezerloc = $this->Budged_exp_rem_model->getFreezLoc($f,$s,$r,$rl);
    //     $dt = new DateTime();

    //     if ($mode=="insert"){
    //         $data = array(
    //             'date_req' => $this->input->post('date_req',TRUE),
    //             'id_person' => $this->input->post('id_person',TRUE),
    //             'id_objective' => $this->input->post('id_objective',TRUE),
    //             'title' => $this->input->post('title',TRUE),
    //             'budged_req' => str_replace('.', '', $this->input->post('budged_req')),
    //             'comments' => trim($this->input->post('comments',TRUE)),
    //             'uuid' => $this->uuid->v4(),
    //             'id_country' => $this->session->userdata('lab'),
    //             'user_created' => $this->session->userdata('id_users'),
    //             'date_created' => $dt->format('Y-m-d H:i:s'),
    //             );

    //         $this->Budged_exp_rem_model->insert($data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
      
    //     }
    //     else if ($mode=="edit"){
    //         $data = array(
    //             'date_req' => $this->input->post('date_req',TRUE),
    //             'id_person' => $this->input->post('id_person',TRUE),
    //             'id_objective' => $this->input->post('id_objective',TRUE),
    //             'title' => $this->input->post('title',TRUE),
    //             'budged_req' => str_replace('.', '', $this->input->post('budged_req')),
    //             'comments' => trim($this->input->post('comments',TRUE)),
    //             // 'uuid' => $this->uuid->v4(),
    //             'id_country' => $this->session->userdata('lab'),
    //             'user_updated' => $this->session->userdata('id_users'),
    //             'date_updated' => $dt->format('Y-m-d H:i:s'),
    //             );
    
    //         $this->Budged_exp_rem_model->update($id, $data);
    //         $this->session->set_flashdata('message', 'Create Record Success');    
    //     }

    //     redirect(site_url("Budged_exp_rem"));
    // }


    public function savedetail() 
    {
        $mode = $this->input->post('mode_det',TRUE);
        $po_number = $this->input->post('po_number',TRUE);
        $id_reqrem = $this->input->post('id_reqrem',TRUE);
        $id_exprem = $this->input->post('id_exprem',TRUE);
        $dt = new DateTime();

        if ($mode=="insert"){
            $data = array(
                'po_number' => $this->input->post('po_number',TRUE),
                'date_expenses' => $this->input->post('date_expenses',TRUE),
                'items' => $this->input->post('items',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'id_unit' => $this->input->post('id_unit',TRUE),
                'expenses' => str_replace('.', '', $this->input->post('expenses')),
                'remarks' => $this->input->post('remarks',TRUE),
                'uuid' => $this->uuid->v4(),
                // 'lab' => $this->session->userdata('lab'),
                'user_created' => $this->session->userdata('id_users'),
                'date_created' => $dt->format('Y-m-d H:i:s'),
                );

            $this->Budged_exp_rem_model->insert_det($data);
            $this->session->set_flashdata('message', 'Create Record Success');    
      
        }
        else if ($mode=="edit"){
            $data = array(
                'po_number' => $this->input->post('po_number',TRUE),
                'date_expenses' => $this->input->post('date_expenses',TRUE),
                'items' => $this->input->post('items',TRUE),
                'qty' => $this->input->post('qty',TRUE),
                'id_unit' => $this->input->post('id_unit',TRUE),
                'expenses' => str_replace('.', '', $this->input->post('expenses')),
                'remarks' => $this->input->post('remarks',TRUE),
                // 'uuid' => $this->uuid->v4(),
                // 'lab' => $this->session->userdata('lab'),
                'user_updated' => $this->session->userdata('id_users'),
                'date_updated' => $dt->format('Y-m-d H:i:s'),
                );
    
            $this->Budged_exp_rem_model->update_det($id_exprem, $data);
            $this->session->set_flashdata('message', 'Create Record Success');    
        }

        redirect(site_url("Budged_exp_rem/read/".$id_reqrem));
    }

    public function budreq_print($id) 
    {
        $row = $this->Budged_exp_rem_model->get_rep($id);
        if ($row) {
            $data = array(
            'id_req' => $row->id_req,
            'date_req' => $row->date_req,
            'realname' => $row->realname,
            'objective' => $row->objective,
            'title' => $row->title,
            'periode' => $row->periode,
            'budged_req' => $row->budged_req,
            'reviewed' => $row->reviewed,
            'approved' => $row->approved,
            'comments' => $row->comments,
            );
        // $data['items'] = $this->Tbl_receive_old_model->getItems();
            $this->template->load('template','Budged_exp_rem/index_rep', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url("Budged_exp_rem/read/".$id));
        }
    }

    // public function spec_printdet() 
    // {
    //     $id = $this->input->post('id',TRUE);
    //     header('Content-Type: application/json');
    //     echo $this->Budged_exp_rem_model->get_repdet($id);
    // }    

    public function delete($id) 
    {
        $row = $this->Budged_exp_rem_model->get_by_id($id);
        $data = array(
            'flag' => 1,
            );

        if ($row) {
            $this->Budged_exp_rem_model->update($id, $data);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('Budged_exp_rem'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Budged_exp_rem'));
        }
    }

    public function valid_bs()
    {
        $id = $this->input->get('id1');
        $type = $this->input->get('id2');
        $data = $this->Budged_exp_rem_model->validate1($id, $type);
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
                'Water_Spectro',
                'SELECT a.id_spec AS ID_spectro, a.date_spec AS Date_spectro, c.initial AS Lab_tech, a.chem_parameter AS Chemistry_parameter, a.mixture_name AS Mixture_name, a.sample_no AS Sample_number, 
                a.lot_no AS Lot_number, a.date_expired AS Date_expired, a.cert_value AS Certified_value, a.uncertainty AS Uncertainty, TRIM(a.notes) AS Comments, a.tot_result AS Total_result, a.tot_trueness AS Total_trueness,
                a.tot_bias AS Total_bias, a.avg_result AS AVG_result, a.avg_trueness AS AVG_trueness, a.avg_bias AS AVG_bias, a.sd AS SD, a.rsd AS `%RSD`, a.cv_horwits AS `%CV_horwits`, a.cv AS `0.67x%CV`,
                a.prec AS Test_Precision, a.accuracy AS Test_Accuracy, a.bias AS `Test_Bias`
                FROM obj2b_spectro_crm a
                LEFT JOIN ref_person c ON a.id_person = c.id_person
                WHERE
                a.lab = "'.$this->session->userdata('lab').'" 
                AND a.flag = 0 
                ORDER BY a.date_spec, a.id_spec
                ',
                array('ID_spectro', 'Date_spectro', 'Lab_tech', 'Chemistry_parameter', 'Mixture_name', 
                'Sample_number', 'Lot_number', 'Date_expired', 'Certified_value', 'Uncertainty', 
                'Comments', 'Total_result', 'Total_trueness', 'Total_bias', 'AVG_result', 'AVG_trueness',
                'AVG_bias', 'SD', '%RSD', '%CV_horwits', '0.67x%CV', 'Test_Precision', 'Test_Accuracy', 'Test_Bias'), // Columns for Sheet1
            ),
            array(
                'Water_spectro_QC_detail',
                'SELECT b.id_dspec AS ID_detail_spectro, b.id_spec AS ID_parent_spectro, b.duplication AS Duplication, 
                b.result AS Result, b.trueness AS Trueness, b.bias_method AS Bias_method, b.result2 AS `Result^2`
                FROM obj2b_spectro_crm_det b
                WHERE b.lab = "'.$this->session->userdata('lab').'" 
                AND b.flag = 0 
                ORDER BY b.id_spec, b.id_dspec ASC
                ', // Different columns for Sheet2
                array('ID_detail_spectro', 'ID_parent_spectro', 'Duplication', 'Result', 'Trueness', 'Bias_method', 'Result^2'), // Columns for Sheet2
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

        // Create a new Xlsx writer
        $writer = new Xlsx($spreadsheet);
        
        // Set the HTTP headers to download the Excel file
        $datenow=date("Ymd");
        $filename = 'Water_Spectro_QC_'.$datenow.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
    }

    public function excel_print()
	{
        /* Data */
        $data = $this->Budged_exp_rem_model->get_all_with_detail_excel();

        /* Spreadsheet Init */
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $hcolumn = 'A';
        $hrow = 1;

        $sheet->getColumnDimension('A')->setWidth(5); // Set width for column A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width for column B
        $sheet->getColumnDimension('C')->setWidth(30); // Set width for column B
        $sheet->getColumnDimension('D')->setWidth(5); // Set width for column B
        $sheet->getColumnDimension('E')->setWidth(7); // Set width for column B
        $sheet->getColumnDimension('F')->setWidth(15); // Set width for column B
        $sheet->getColumnDimension('G')->setWidth(17); // Set width for column B
        $sheet->getColumnDimension('H')->setWidth(30); // Set width for column B

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
        $sheet->setCellValue($hcolumn++ . $start, "No.");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Date Expenses");
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
            $sheet->setCellValue('C2', "RISE Makassar | Budget Expenses Remaining");
            $sheet->getStyle('C3')->getFont()->setBold(true);        
            $sheet->setCellValue('C3', "PO Number : " . $row->po_number . "(R)");
            $sheet->getStyle('C4')->getFont()->setBold(true);        
            $sheet->setCellValue('C4', $row->objective);
            $sheet->getStyle('C5')->getFont()->setBold(true);        
            $sheet->setCellValue('C5', $row->new_title);
            $sheet->getStyle('C6')->getFont()->setBold(true);        
            $sheet->setCellValue('C6', "Budged Request : " . $row->budged_req);
            $sheet->setCellValue('G6', "Date : " . date('Y-m-d'));

            $column = 'A';
            $sheet->setCellValue($column++ .$row_number, $key+1);
            $sheet->setCellValue($column++ .$row_number, $row->date_expenses);
            $sheet->setCellValue($column++ .$row_number, $row->items);
            $sheet->setCellValue($column++ .$row_number, $row->qty);
            $sheet->setCellValue($column++ .$row_number, $row->unit);
            $sheet->getStyle($column.$row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue($column++ .$row_number, $row->expenses);
            $sheet->getStyle($column.$row_number)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue($column++ .$row_number, $row->total);
            $sheet->setCellValue($column++ .$row_number, $row->remarks);
            $row_number++;

        }

        $sheet->getStyle('G' .$row_number)->getFont()->setBold(true);        
        $sheet->setCellValue('G' .$row_number, $row->sum_exp);
        $row_number++;

        $row_ex = $row_number+1;
        $sheet->getStyle('A' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('A' .$row_ex, "Prepared,");
        $sheet->getStyle('D' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('D' .$row_ex, "Reviewed,");
        $sheet->getStyle('H' .$row_ex)->getFont()->setBold(true);        
        $sheet->setCellValue('H' .$row_ex, "Approved,");

        $row_ex2 = $row_ex+4;
        $sheet->setCellValue('A' .$row_ex2, $row->realname);
        $sheet->setCellValue('D' .$row_ex2, $row->reviewed);
        $sheet->setCellValue('H' .$row_ex2, $row->approved);

        $row_number--;
        $sheet->getStyle("A8:H".$row_number)->applyFromArray(
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
        $filename = 'Budged_expenses_remaining_' . date('Ymd');
        
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
    //     $rdeliver = $this->Budged_exp_rem_model->get_all();
    
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
    // $fileName = 'Budged_exp_rem_'.$datenow.'.csv';

    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header("Content-Disposition: attachment; filename=$fileName"); // Set nama file excel nya
    // header('Cache-Control: max-age=0');

    // $writer->save('php://output');
    // }
}

/* End of file Budged_exp_rem.php */
/* Location: ./application/controllers/Budged_exp_rem.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */