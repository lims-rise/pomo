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
    
class budget_expenses extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('budget_expenses_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
	    $this->load->library('uuid');
    }

    public function index()
    {
        // $this->load->model('budget_expenses_model');
        // $data['person'] = $this->budget_expenses_model->getLabtech();
        // $data['objective'] = $this->budget_expenses_model->getObjective();
        // $data['freezer'] = $this->budget_expenses_model->getFreezer();
        // $data['shelf'] = $this->budget_expenses_model->getShelf();
        // $data['rack'] = $this->budget_expenses_model->getRack();
        // $data['rack_level'] = $this->budget_expenses_model->getDrawer();
        $this->template->load('template','budget_expenses/index');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->budget_expenses_model->json();
    }

    public function subjson() {
        $id = $this->input->get('id',TRUE);
        header('Content-Type: application/json');
        echo $this->budget_expenses_model->subjson($id);
    }

    public function getSumEstimatePrice($id_req) {
        // Load the model
        // $this->load->model('budget_expenses_model');
        // Call the method to get the sum of Estimate Price
        $sumEstimatePrice = $this->budget_expenses_model->getSumEstimatePrice($id_req);
    
        // Return the sum of Estimate Price
        echo $sumEstimatePrice;
    }
    
    public function read($id)
    {
        // $this->template->load('template','budget_expenses/index_det', $data);
        // $id_spec = $this->input->post('id_spec',TRUE);
        // $data['unit'] = $this->budget_expenses_model->getUnits();
        $row = $this->budget_expenses_model->get_detail($id);
        if ($row) {
            // $inv = $this->budget_expenses_model->getInv();            
            $data = array(
                'po_number' => $row->po_number,
                'date_po' => $row->date_po,
                'objective' => $row->objective,
                'title' => $row->title,
                'budget_req' => $row->budget_req,
                'budget_tot' => $row->budget_tot,
                'budget_rem' => $row->budget_rem,
                'id_req' => $row->id_req,
                'unit' => $this->budget_expenses_model->getUnits(),
                );
                $this->template->load('template','budget_expenses/index_det', $data);
        }
        else {
            // $this->template->load('template','budget_expenses/index_det');
        }
    } 

    public function savedetail() 
    {
        $mode = $this->input->post('mode_det',TRUE);
        $po_number = $this->input->post('po_number',TRUE);
        $id_req = $this->input->post('id_req',TRUE);
        $id_exp = $this->input->post('id_exp',TRUE);
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

            $this->budget_expenses_model->insert_det($data);
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
    
            $this->budget_expenses_model->update_det($id_exp, $data);
            $this->session->set_flashdata('message', 'Create Record Success');    
        }

        redirect(site_url("budget_expenses/read/".$id_req));
    }

    public function budreq_print($id) 
    {
        $row = $this->budget_expenses_model->get_rep($id);
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
            $this->template->load('template','budget_expenses/index_rep', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url("budget_expenses/read/".$id));
        }
    }

    // public function spec_printdet() 
    // {
    //     $id = $this->input->post('id',TRUE);
    //     header('Content-Type: application/json');
    //     echo $this->budget_expenses_model->get_repdet($id);
    // }    

    public function delete($id) 
    {
        $row = $this->budget_expenses_model->get_by_id($id);
        if ($row) {
            $id_parent = $row->id_req;
            $this->budget_expenses_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('budget_expenses/read/'.$id_parent));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('budget_expenses/read/'.$id_parent));
        }
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
                'Budget_Expenses',
                'SELECT a.po_number AS PO_Number, a.date_po AS Date_PO, d.objective AS Objective, b.title AS Title, 
                b.budget_req AS Budget_Request, 
                c.expenses AS Budget_Expenses, 
                (b.budget_req - c.expenses) AS Budget_Remaining, 
                b.id_req
                FROM approved_po a
                LEFT JOIN budget_request b ON a.id_req=b.id_req
                LEFT JOIN ref_objective d	ON b.id_objective=d.id_objective
                LEFT JOIN v_tot_expenses c ON a.po_number=c.po_number
                WHERE b.id_country = "'.$this->session->userdata('lab').'" 
                AND b.flag = 0 
                ORDER BY a.date_po
                ',
                array('PO_Number', 'Date_PO', 'Objective', 'Title', 'Budget_Request', 
                'Budget_Expenses', 'Budget_Remaining'), // Columns for Sheet1
            ),
            array(
                'Budget_Expenses_detail',
                'SELECT a.po_number AS PO_Number, a.id_exp, a.date_expenses AS Date_Expenses, a.items AS Descriptions, 
                a.qty AS Qty, b.unit AS Unit, a.expenses AS Expenses, (a.expenses * a.qty) AS Total_Expenses, 
                a.remarks AS Remarks, a.id_exp, a.id_unit, a.flag
                FROM budget_expenses_detail a
                LEFT JOIN ref_unit b ON a.id_unit=b.id_unit                
                LEFT JOIN approved_po c ON a.po_number=c.po_number
                LEFT JOIN budget_request d ON c.id_req=d.id_req
                WHERE d.id_country = '. $this->session->userdata("lab") .' 
                AND a.flag = 0 
                ORDER BY a.po_number, a.date_expenses ASC
                ', // Different columns for Sheet2
                array('PO_Number', 'Date_Expenses', 'Descriptions', 'Qty', 'Unit', 'Expenses', 'Total_Expenses', 'Remarks'), // Columns for Sheet2
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
        $filename = 'Budget_Expenses_'.$datenow.'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Save the Excel file to the output stream
        $writer->save('php://output');
    }

    public function excel_print($id)
	{
        /* Data */
        $data = $this->budget_expenses_model->get_all_with_detail_excel($id);

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
        $sheet->getColumnDimension('F')->setWidth(16); // Set width for column B
        $sheet->getColumnDimension('G')->setWidth(20); // Set width for column B
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
        $sheet->setCellValue($hcolumn++ . $start, "Actual Price IDR");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Total Actual Price IDR");
        $sheet->getStyle($hcolumn.$start)->getFont()->setBold(true);        
        $sheet->getStyle($hcolumn.$start)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);        
        $sheet->setCellValue($hcolumn++ . $start, "Remark");
        
        /* Excel Data */
        $row_number = $start+1;

        foreach($data as $key => $row)
        {
            $sheet->getStyle('C2')->getFont()->setBold(true);        
            $sheet->setCellValue('C2', "RISE Makassar | Budget Expenses");
            $sheet->getStyle('C3')->getFont()->setBold(true);        
            $sheet->setCellValue('C3', "PO Number : " . $row->po_number);
            $sheet->getStyle('C4')->getFont()->setBold(true);        
            $sheet->setCellValue('C4', $row->objective);
            $sheet->getStyle('C5')->getFont()->setBold(true);        
            $sheet->setCellValue('C5', $row->title);
            $sheet->getStyle('C6')->getFont()->setBold(true);        
            $sheet->setCellValue('C6', "budget Request : " . $row->budget_req);
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
        $filename = 'budget_expenses_' . date('Ymd');
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

}

/* End of file budget_expenses.php */
/* Location: ./application/controllers/budget_expenses.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:38:42 */
/* http://harviacode.com */