<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// require_once '../../extlib/PHPExcel/PHPExcel.php';

class REP_o2b extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('REP_o2b_model');
        // $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $this->template->load('template','REP_o2b/index');
    } 

    // public function index2()
    // {
    //     $this->template->load('template','REP_o2b/index2');
    // } 

    public function cleanEnter($text) {
        return str_replace(["\r", "\n"], ' ', trim($text));
    }
    
    public function json() {
        $rep=$this->input->get('rep');
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');
        // var_dump($date2);
        header('Content-Type: application/json');
        echo $this->REP_o2b_model->json($date1,$date2,$rep);
    }


    public function excel()
    {
        $rep=$this->input->get('rep');
        $date1=$this->input->get('date1');
        $date2=$this->input->get('date2');

        $spreadsheet = new Spreadsheet();    
        $sheet = $spreadsheet->getActiveSheet();

        if ($rep == '6' || $rep == '6x') {
            $sheet->setCellValue('A1', "reception_date_arrival");
            $sheet->setCellValue('B1', "reception_time_arrival");
            $sheet->setCellValue('C1', "barcode_sample");
            $sheet->setCellValue('D1', "reception_sampletype");
            $sheet->setCellValue('E1', "reception_barcode_tinytag");
            $sheet->setCellValue('F1', "reception_comment");
            $sheet->setCellValue('G1', "chemistry_barcode_sample");
            $sheet->setCellValue('H1', "chemistry_sampletype2bwat");

        if ($this->session->userdata('lab') == 1) {
            $sheet->setCellValue('I1', "chems_BTKL_barcode");
            $sheet->setCellValue('J1', "chems_BTKL_deliver");
            $sheet->setCellValue('K1', "chems_BBLK_barcode");
            $sheet->setCellValue('L1', "chems_BBLK_deliver");
            $sheet->setCellValue('M1', "micro_BTKL_barcode");
            $sheet->setCellValue('N1', "micro_BTKL_deliver");
            $sheet->setCellValue('O1', "micro_BBLK_barcode");
            $sheet->setCellValue('P1', "micro_BBLK_deliver");
        }
        else {
            $sheet->setCellValue('I1', "chems_WAF_barcode");
            $sheet->setCellValue('J1', "chems_WAF_deliver");
            $sheet->setCellValue('K1', "chems_Other_barcode");
            $sheet->setCellValue('L1', "chems_Other_deliver");
            $sheet->setCellValue('M1', "micro_WAF_barcode");
            $sheet->setCellValue('N1', "micro_WAF_deliver");
            $sheet->setCellValue('O1', "micro_Other_barcode");
            $sheet->setCellValue('P1', "micro_Other_deliver");
        }
            $sheet->setCellValue('Q1', "chemistry_comment");
            $sheet->setCellValue('R1', "endetec_in_barcode_sample");
            $sheet->setCellValue('S1', "endetec_in_date_conduct");
            $sheet->setCellValue('T1', "endetec_in_time_incubation");
            $sheet->setCellValue('U1', "endetec_in_barcode_endetec");
            $sheet->setCellValue('V1', "endetec_in_volume");
            $sheet->setCellValue('W1', "endetec_in_dilution");
            $sheet->setCellValue('X1', "endetec_in_comment");
            $sheet->setCellValue('Y1', "endetec_out_date_conduct");
            $sheet->setCellValue('Z1', "endetec_out_barcode_endetec");
            $sheet->setCellValue('AA1', "endetec_out_time_ecoli");
            $sheet->setCellValue('AB1', "endetec_out_volume_ecoli");
            $sheet->setCellValue('AC1', "endetec_out_ecoli_cfu");
            $sheet->setCellValue('AD1', "endetec_out_total_coliforms");
            $sheet->setCellValue('AE1', "endetec_out_total_coli_cfu");
            $sheet->setCellValue('AF1', "endetec_out_comments");
            $sheet->setCellValue('AG1', "idexx_in_barcode_sample");
            $sheet->setCellValue('AH1', "idexx_in_date_conduct");
            $sheet->setCellValue('AI1', "idexx_in_time_incubation");
            $sheet->setCellValue('AJ1', "idexx_in_barcode_colilert");
            $sheet->setCellValue('AK1', "idexx_in_volume");
            $sheet->setCellValue('AL1', "idexx_in_dilution");
            $sheet->setCellValue('AM1', "idexx_in_comments");
            $sheet->setCellValue('AN1', "idexx_in_barcode_colilert2");
            $sheet->setCellValue('AO1', "idexx_in_volume2");
            $sheet->setCellValue('AP1', "idexx_in_dilution2");
            $sheet->setCellValue('AQ1', "idexx_in_comments2");
            $sheet->setCellValue('AR1', "idexx_out_date_conduct");
            $sheet->setCellValue('AS1', "idexx_out_barcode_colilert");
            $sheet->setCellValue('AT1', "idexx_out_timeout_incubation");
            $sheet->setCellValue('AU1', "idexx_out_time_minutes");
            $sheet->setCellValue('AV1', "idexx_out_ecoli_largewells");
            $sheet->setCellValue('AW1', "idexx_out_ecoli_smallwells");
            $sheet->setCellValue('AX1', "idexx_out_ecoli_mpn");
            $sheet->setCellValue('AY1', "idexx_out_coliforms_largewells");
            $sheet->setCellValue('AZ1', "idexx_out_coliforms_smallwells");
            $sheet->setCellValue('BA1', "idexx_out_coliforms_mpn");
            $sheet->setCellValue('BB1', "idexx_out_comments");
            $sheet->setCellValue('BC1', "idexx_out_date_conduct2");
            $sheet->setCellValue('BD1', "idexx_out_barcode_colilert2");
            $sheet->setCellValue('BE1', "idexx_out_timeout_incubation2");
            $sheet->setCellValue('BF1', "idexx_out_time_minutes2");
            $sheet->setCellValue('BG1', "idexx_out_ecoli_largewells2");
            $sheet->setCellValue('BH1', "idexx_out_ecoli_smallwells2");
            $sheet->setCellValue('BI1', "idexx_out_ecoli_mpn2");
            $sheet->setCellValue('BJ1', "idexx_out_coliforms_largewells2");
            $sheet->setCellValue('BK1', "idexx_out_coliforms_smallwells2");
            $sheet->setCellValue('BL1', "idexx_out_coliforms_mpn2");
            $sheet->setCellValue('BM1', "idexx_out_comments2");
            $sheet->setCellValue('BN1', "metagenomics_date_conduct");
            $sheet->setCellValue('BO1', "metagenomics_barcode_sample");
            $sheet->setCellValue('BP1', "metagenomics_volume_filtered");
            $sheet->setCellValue('BQ1', "metagenomics_time_started");
            $sheet->setCellValue('BR1', "metagenomics_time_finished");
            $sheet->setCellValue('BS1', "metagenomics_time_minutes");
            $sheet->setCellValue('BT1', "metagenomics_barcode_dna_bag");
            $sheet->setCellValue('BU1', "metagenomics_barcode_storage");
            $sheet->setCellValue('BV1', "metagenomics_location");
            $sheet->setCellValue('BW1', "metagenomics_comments");
            $sheet->setCellValue('BX1', "mac1_barcode_macconkey");
            $sheet->setCellValue('BY1', "mac1_date_process");
            $sheet->setCellValue('BZ1', "mac1_time_process");
            $sheet->setCellValue('CA1', "mac1_volume");
            $sheet->setCellValue('CB1', "mac1_comments");
            $sheet->setCellValue('CC1', "mac2_date_process");
            $sheet->setCellValue('CD1', "mac2_time_process");
            $sheet->setCellValue('CE1', "mac2_bar_macsweep1");
            $sheet->setCellValue('CF1', "mac2_cryobox1");
            $sheet->setCellValue('CG1', "mac2_bar_macsweep2");
            $sheet->setCellValue('CH1', "mac2_cryobox2");
            $sheet->setCellValue('CI1', "mac2_comments");

            $rdeliver = $this->REP_o2b_model->get_water($date1, $date2, $rep);
        
            $numrow = 2; 
            foreach($rdeliver as $data){ 
                $sheet->setCellValue('A'.$numrow, $this->cleanEnter($data->reception_date_arrival));
                $sheet->setCellValue('B'.$numrow, $this->cleanEnter($data->reception_time_arrival));
                $sheet->setCellValue('C'.$numrow, $this->cleanEnter($data->barcode_sample));
                $sheet->setCellValue('D'.$numrow, $this->cleanEnter($data->reception_sampletype));
                $sheet->setCellValue('E'.$numrow, $this->cleanEnter($data->reception_barcode_tinytag));
                $sheet->setCellValue('F'.$numrow, $this->cleanEnter($data->reception_comment));
                $sheet->setCellValue('G'.$numrow, $this->cleanEnter($data->chemistry_barcode_sample));
                $sheet->setCellValue('H'.$numrow, $this->cleanEnter($data->chemistry_sampletype2bwat));
                $sheet->setCellValue('I'.$numrow, $this->cleanEnter($data->chemistry_barcode_nitro));
                $sheet->setCellValue('J'.$numrow, $this->cleanEnter($data->chemistry_3rdparty_lab));
                $sheet->setCellValue('K'.$numrow, $this->cleanEnter($data->chemistry_barcode_nitro_2nd));
                $sheet->setCellValue('L'.$numrow, $this->cleanEnter($data->chemistry_3rdparty_lab_2nd));
                $sheet->setCellValue('M'.$numrow, $this->cleanEnter($data->chemistry_barcode_microbiology));
                $sheet->setCellValue('N'.$numrow, $this->cleanEnter($data->chemistry_3rdparty_lab3));
                $sheet->setCellValue('O'.$numrow, $this->cleanEnter($data->chemistry_barcode_microbiology2));
                $sheet->setCellValue('P'.$numrow, $this->cleanEnter($data->chemistry_3rdparty_lab4));
                $sheet->setCellValue('Q'.$numrow, $this->cleanEnter($data->chemistry_comment));
                $sheet->setCellValue('R'.$numrow, $this->cleanEnter($data->endetec_in_barcode_sample));
                $sheet->setCellValue('S'.$numrow, $this->cleanEnter($data->endetec_in_date_conduct));
                $sheet->setCellValue('T'.$numrow, $this->cleanEnter($data->endetec_in_time_incubation));
                $sheet->setCellValue('U'.$numrow, $this->cleanEnter($data->endetec_in_barcode_endetec));
                $sheet->setCellValue('V'.$numrow, $this->cleanEnter($data->endetec_in_volume));
                $sheet->setCellValue('W'.$numrow, $this->cleanEnter($data->endetec_in_dilution));
                $sheet->setCellValue('X'.$numrow, $this->cleanEnter($data->endetec_in_comment));
                $sheet->setCellValue('Y'.$numrow, $this->cleanEnter($data->endetec_out_date_conduct));
                $sheet->setCellValue('Z'.$numrow, $this->cleanEnter($data->endetec_out_barcode_endetec));
                $sheet->setCellValue('AA'.$numrow, $this->cleanEnter($data->endetec_out_time_ecoli));
                $sheet->setCellValue('AB'.$numrow, $this->cleanEnter($data->endetec_out_volume_ecoli));
                $sheet->setCellValue('AC'.$numrow, $this->cleanEnter($data->endetec_out_ecoli_cfu));
                $sheet->setCellValue('AD'.$numrow, $this->cleanEnter($data->endetec_out_total_coliforms));
                $sheet->setCellValue('AE'.$numrow, $this->cleanEnter($data->endetec_out_total_coli_cfu));
                $sheet->setCellValue('AF'.$numrow, $this->cleanEnter($data->endetec_out_comments));
                $sheet->setCellValue('AG'.$numrow, $this->cleanEnter($data->idexx_in_barcode_sample));
                $sheet->setCellValue('AH'.$numrow, $this->cleanEnter($data->idexx_in_date_conduct));
                $sheet->setCellValue('AI'.$numrow, $this->cleanEnter($data->idexx_in_time_incubation));
                $sheet->setCellValue('AJ'.$numrow, $this->cleanEnter($data->idexx_in_barcode_colilert));
                $sheet->setCellValue('AK'.$numrow, $this->cleanEnter($data->idexx_in_volume));
                $sheet->setCellValue('AL'.$numrow, $this->cleanEnter($data->idexx_in_dilution));
                $sheet->setCellValue('AM'.$numrow, $this->cleanEnter($data->idexx_in_comments));
                $sheet->setCellValue('AN'.$numrow, $this->cleanEnter($data->idexx_in_barcode_colilert2));
                $sheet->setCellValue('AO'.$numrow, $this->cleanEnter($data->idexx_in_volume2));
                $sheet->setCellValue('AP'.$numrow, $this->cleanEnter($data->idexx_in_dilution2));
                $sheet->setCellValue('AQ'.$numrow, $this->cleanEnter($data->idexx_in_comments2));
                $sheet->setCellValue('AR'.$numrow, $this->cleanEnter($data->idexx_out_date_conduct));
                $sheet->setCellValue('AS'.$numrow, $this->cleanEnter($data->idexx_out_barcode_colilert));
                $sheet->setCellValue('AT'.$numrow, $this->cleanEnter($data->idexx_out_timeout_incubation));
                $sheet->setCellValue('AU'.$numrow, $this->cleanEnter($data->idexx_out_time_minutes));
                $sheet->setCellValue('AV'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_largewells));
                $sheet->setCellValue('AW'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_smallwells));
                $sheet->setCellValue('AX'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_mpn));
                $sheet->setCellValue('AY'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_largewells));
                $sheet->setCellValue('AZ'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_smallwells));
                $sheet->setCellValue('BA'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_mpn));
                $sheet->setCellValue('BB'.$numrow, $this->cleanEnter($data->idexx_out_comments));
                $sheet->setCellValue('BC'.$numrow, $this->cleanEnter($data->idexx_out_date_conduct2));
                $sheet->setCellValue('BD'.$numrow, $this->cleanEnter($data->idexx_out_barcode_colilert2));
                $sheet->setCellValue('BE'.$numrow, $this->cleanEnter($data->idexx_out_timeout_incubation2));
                $sheet->setCellValue('BF'.$numrow, $this->cleanEnter($data->idexx_out_time_minutes2));
                $sheet->setCellValue('BG'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_largewells2));
                $sheet->setCellValue('BH'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_smallwells2));
                $sheet->setCellValue('BI'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_mpn2));
                $sheet->setCellValue('BJ'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_largewells2));
                $sheet->setCellValue('BK'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_smallwells2));
                $sheet->setCellValue('BL'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_mpn2));
                $sheet->setCellValue('BM'.$numrow, $this->cleanEnter($data->idexx_out_comments2));
                $sheet->setCellValue('BN'.$numrow, $this->cleanEnter($data->metagenomics_date_conduct));
                $sheet->setCellValue('BO'.$numrow, $this->cleanEnter($data->metagenomics_barcode_sample));
                $sheet->setCellValue('BP'.$numrow, $this->cleanEnter($data->metagenomics_volume_filtered));
                $sheet->setCellValue('BQ'.$numrow, $this->cleanEnter($data->metagenomics_time_started));
                $sheet->setCellValue('BR'.$numrow, $this->cleanEnter($data->metagenomics_time_finished));
                $sheet->setCellValue('BS'.$numrow, $this->cleanEnter($data->metagenomics_time_minutes));
                $sheet->setCellValue('BT'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna_bag));
                $sheet->setCellValue('BU'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage));
                $sheet->setCellValue('BV'.$numrow, $this->cleanEnter($data->metagenomics_location));
                $sheet->setCellValue('BW'.$numrow, $this->cleanEnter($data->metagenomics_comments));
                $sheet->setCellValue('BX'.$numrow, $this->cleanEnter($data->mac1_barcode_macconkey));
                $sheet->setCellValue('BY'.$numrow, $this->cleanEnter($data->mac1_date_process));
                $sheet->setCellValue('BZ'.$numrow, $this->cleanEnter($data->mac1_time_process));
                $sheet->setCellValue('CA'.$numrow, $this->cleanEnter($data->mac1_volume));
                $sheet->setCellValue('CB'.$numrow, $this->cleanEnter($data->mac1_comments));
                $sheet->setCellValue('CC'.$numrow, $this->cleanEnter($data->mac2_date_process));
                $sheet->setCellValue('CD'.$numrow, $this->cleanEnter($data->mac2_time_process));
                $sheet->setCellValue('CE'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep1));
                $sheet->setCellValue('CF'.$numrow, $this->cleanEnter($data->mac2_cryobox1));
                $sheet->setCellValue('CG'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep2));
                $sheet->setCellValue('CH'.$numrow, $this->cleanEnter($data->mac2_cryobox2));
                $sheet->setCellValue('CI'.$numrow, $this->cleanEnter($data->mac2_comments));
                //   $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $datenow=date("Ymd");
            if ($rep == '6') {
                $fileName = 'O2B_water_report_'.$datenow.'.csv';
            }
            else {
                $fileName = 'O2B_water_site0_report_'.$datenow.'.csv';
            }
        }
        else if ($rep == 9) {
            $sheet->setCellValue('A1', "reception_date_arrival");
            $sheet->setCellValue('B1', "reception_time_arrival");
            $sheet->setCellValue('C1', "barcode_sample");
            $sheet->setCellValue('D1', "reception_sampletype");
            $sheet->setCellValue('E1', "reception_barcode_tinytag");
            $sheet->setCellValue('F1', "reception_comment");
            $sheet->setCellValue('G1', "bs_before_date_weighed_micro");
            $sheet->setCellValue('H1', "bs_before_barcode_bootsocks_micro");
            $sheet->setCellValue('I1', "bs_before_bootsock_weight_dry_micro");
            $sheet->setCellValue('J1', "bs_before_comment_micro");
            $sheet->setCellValue('K1', "bs_before_date_weighed_moisture");
            $sheet->setCellValue('L1', "bs_before_barcode_bootsocks_moisture");
            $sheet->setCellValue('M1', "bs_before_bootsock_weight_dry_moisture");
            $sheet->setCellValue('N1', "bs_before_comment_moisture");
            $sheet->setCellValue('O1', "bs_after_date_weighed_micro");
            $sheet->setCellValue('P1', "bs_after_barcode_bootsocks_micro");
            $sheet->setCellValue('Q1', "bs_after_bootsock_weight_wet_micro");
            $sheet->setCellValue('R1', "bs_after_comment_micro");
            $sheet->setCellValue('S1', "bs_after_date_weighed_moisture");
            $sheet->setCellValue('T1', "bs_after_barcode_bootsocks_moisture");
            $sheet->setCellValue('U1', "bs_after_bootsock_weight_wet_moisture");
            $sheet->setCellValue('V1', "bs_after_comment_moisture");
            $sheet->setCellValue('W1', "old_mois_initial_date_moisture");
            $sheet->setCellValue('X1', "old_mois_initial_barcode_bootsocks");
            $sheet->setCellValue('Y1', "old_mois_initial_barcode_foil");
            $sheet->setCellValue('Z1', "old_mois_initial_foil_weight");
            $sheet->setCellValue('AA1', "old_mois_initial_wet_weight");
            $sheet->setCellValue('AB1', "old_mois_initial_time_incubator");
            $sheet->setCellValue('AC1', "old_mois_initial_comments");
            $sheet->setCellValue('AD1', "mois_initial_date_moisture");
            $sheet->setCellValue('AE1', "mois_initial_barcode_foil_tray");
            $sheet->setCellValue('AF1', "mois_initial_foil_tray_weight");
            $sheet->setCellValue('AG1', "mois_initial_time_filter_start");
            $sheet->setCellValue('AH1', "mois_initial_time_filter_finish");
            $sheet->setCellValue('AI1', "mois_initial_wet_weight");
            $sheet->setCellValue('AJ1', "mois_initial_time_incubator");
            $sheet->setCellValue('AK1', "mois_initial_comments");
            $sheet->setCellValue('AL1', "mois24_date_moisture");
            $sheet->setCellValue('AM1', "mois24_barcode_foil");
            $sheet->setCellValue('AN1', "mois24_dry_weight24");
            $sheet->setCellValue('AO1', "mois24_comments");
            $sheet->setCellValue('AP1', "mois48_date_moisture");
            $sheet->setCellValue('AQ1', "mois48_barcode_foil");
            $sheet->setCellValue('AR1', "mois48_dry_weight48");
            $sheet->setCellValue('AS1', "mois48_difference");
            $sheet->setCellValue('AT1', "mois48_comments");
            $sheet->setCellValue('AU1', "stomacher_date_conduct");
            $sheet->setCellValue('AV1', "stomacher_barcode_bootsocks1");
            $sheet->setCellValue('AW1', "stomacher_elution_number_Micro1");
            $sheet->setCellValue('AX1', "stomacher_elution_Micro1");
            $sheet->setCellValue('AY1', "stomacher_barcode_falcon_Micro1");
            $sheet->setCellValue('AZ1', "stomacher_volume_Micro1");
            $sheet->setCellValue('BA1', "stomacher_elution_number_Micro2");
            $sheet->setCellValue('BB1', "stomacher_elution_Micro2");
            $sheet->setCellValue('BC1', "stomacher_barcode_falcon_Micro2");
            $sheet->setCellValue('BD1', "stomacher_volume_Micro2");
            $sheet->setCellValue('BE1', "stomacher_barcode_bootsocks2");
            $sheet->setCellValue('BF1', "stomacher_elution_number_Moisture1");
            $sheet->setCellValue('BG1', "stomacher_elution_Moisture1");
            $sheet->setCellValue('BH1', "stomacher_barcode_falcon_Moisture1");
            $sheet->setCellValue('BI1', "stomacher_volume_Moisture1");
            $sheet->setCellValue('BJ1', "stomacher_elution_number_Moisture2");
            $sheet->setCellValue('BK1', "stomacher_elution_Moisture2");
            $sheet->setCellValue('BL1', "stomacher_barcode_falcon_Moisture2");
            $sheet->setCellValue('BM1', "stomacher_volume_Moisture2");
            $sheet->setCellValue('BN1', "old_stom_endet_barcode_endetec");
            $sheet->setCellValue('BO1', "old_stom_endet_barcode_falcon1");
            $sheet->setCellValue('BP1', "old_stom_endet_volume_falcon1");
            $sheet->setCellValue('BQ1', "old_stom_endet_barcode_falcon2");
            $sheet->setCellValue('BR1', "old_stom_endet_volume_falcon2");
            $sheet->setCellValue('BS1', "old_stom_endet_dilution");
            $sheet->setCellValue('BT1', "old_stom_endet_time_incu_start");
            $sheet->setCellValue('BU1', "old_stom_endet_comments");
            $sheet->setCellValue('BV1', "old_stom_idexx_barcode_colilert");
            $sheet->setCellValue('BW1', "old_stom_idexx_barcode_falcon1");
            $sheet->setCellValue('BX1', "old_stom_idexx_volume_falcon1");
            $sheet->setCellValue('BY1', "old_stom_idexx_barcode_falcon2");
            $sheet->setCellValue('BZ1', "old_stom_idexx_volume_falcon2");
            $sheet->setCellValue('CA1', "old_stom_idexx_dilution");
            $sheet->setCellValue('CB1', "old_stom_idexx_time_incu_start");
            $sheet->setCellValue('CC1', "old_stom_idexx_comments");
            $sheet->setCellValue('CD1', "stom_endet_barcode_endetec");
            $sheet->setCellValue('CE1', "stom_endet_barcode_falcon1");
            $sheet->setCellValue('CF1', "stom_endet_volume_falcon1");
            $sheet->setCellValue('CG1', "stom_endet_barcode_falcon2");
            $sheet->setCellValue('CH1', "stom_endet_volume_falcon2");
            $sheet->setCellValue('CI1', "stom_endet_dilution");
            $sheet->setCellValue('CJ1', "stom_endet_time_incu_start");
            $sheet->setCellValue('CK1', "stom_endet_comments");
            $sheet->setCellValue('CL1', "stom_idexx_barcode_colilert");
            $sheet->setCellValue('CM1', "stom_idexx_barcode_falcon1");
            $sheet->setCellValue('CN1', "stom_idexx_volume_falcon1");
            $sheet->setCellValue('CO1', "stom_idexx_barcode_falcon2");
            $sheet->setCellValue('CP1', "stom_idexx_volume_falcon2");
            $sheet->setCellValue('CQ1', "stom_idexx_dilution");
            $sheet->setCellValue('CR1', "stom_idexx_time_incu_start");
            $sheet->setCellValue('CS1', "stom_idexx_comments");
            $sheet->setCellValue('CT1', "endet_out(b)_date_conduct");
            $sheet->setCellValue('CU1', "endet_out(b)_barcode_endetec");
            $sheet->setCellValue('CV1', "endet_out(b)_time_ecoli");
            $sheet->setCellValue('CW1', "endet_out(b)_volume_ecoli");
            $sheet->setCellValue('CX1', "endet_out(b)_total_coliforms");
            $sheet->setCellValue('CY1', "endet_out(b)_comments");
            $sheet->setCellValue('CZ1', "idexx_out_date_conduct");
            $sheet->setCellValue('DA1', "idexx_out_barcode_colilert");
            $sheet->setCellValue('DB1', "idexx_out_timeout_incubation");
            $sheet->setCellValue('DC1', "idexx_out_time_minutes");
            $sheet->setCellValue('DD1', "idexx_out_ecoli_largewells");
            $sheet->setCellValue('DE1', "idexx_out_ecoli_smallwells");
            $sheet->setCellValue('DF1', "idexx_out_ecoli_mpn");
            $sheet->setCellValue('DG1', "idexx_out_coliforms_largewells");
            $sheet->setCellValue('DH1', "idexx_out_coliforms_smallwells");
            $sheet->setCellValue('DI1', "idexx_out_coliforms_mpn");
            $sheet->setCellValue('DJ1', "idexx_out_comments");
            $sheet->setCellValue('DK1', "metagenomics_date_conduct");
            $sheet->setCellValue('DL1', "metagenomics_barcode_falcon1");
            $sheet->setCellValue('DM1', "metagenomics_barcode_falcon2");
            $sheet->setCellValue('DN1', "metagenomics_volume_filtered");
            $sheet->setCellValue('DO1', "metagenomics_time_started");
            $sheet->setCellValue('DP1', "metagenomics_time_finished");
            $sheet->setCellValue('DQ1', "metagenomics_time_minutes");
            $sheet->setCellValue('DR1', "metagenomics_barcode_dna_bag");
            $sheet->setCellValue('DS1', "metagenomics_barcode_storage");
            $sheet->setCellValue('DT1', "metagenomics_location");
            $sheet->setCellValue('DU1', "metagenomics_comments");
            $sheet->setCellValue('DV1', "mac1_barcode_macconkey");
            $sheet->setCellValue('DW1', "mac1_date_process");
            $sheet->setCellValue('DX1', "mac1_time_process");
            $sheet->setCellValue('DY1', "mac1_volume");
            $sheet->setCellValue('DZ1', "mac1_comments");
            $sheet->setCellValue('EA1', "mac2_date_process");
            $sheet->setCellValue('EB1', "mac2_time_process");
            $sheet->setCellValue('EC1', "mac2_bar_macsweep1");
            $sheet->setCellValue('ED1', "mac2_cryobox1");
            $sheet->setCellValue('EE1', "mac2_bar_macsweep2");
            $sheet->setCellValue('EF1', "mac2_cryobox2");
            $sheet->setCellValue('EG1', "mac2_comments");

            $rdeliver = $this->REP_o2b_model->get_bootsock($date1, $date2, $rep);
        
            $numrow = 2; 
            foreach($rdeliver as $data){ 
                $sheet->setCellValue('A'.$numrow, $this->cleanEnter($data->reception_date_arrival));
                $sheet->setCellValue('B'.$numrow, $this->cleanEnter($data->reception_time_arrival));
                $sheet->setCellValue('C'.$numrow, $this->cleanEnter($data->barcode_sample));
                $sheet->setCellValue('D'.$numrow, $this->cleanEnter($data->reception_sampletype));
                $sheet->setCellValue('E'.$numrow, $this->cleanEnter($data->reception_barcode_tinytag));
                $sheet->setCellValue('F'.$numrow, $this->cleanEnter($data->reception_comment));
                $sheet->setCellValue('G'.$numrow, $this->cleanEnter($data->bs_before_date_weighed_micro));
                $sheet->setCellValue('H'.$numrow, $this->cleanEnter($data->bs_before_barcode_bootsocks_micro));
                $sheet->setCellValue('I'.$numrow, $this->cleanEnter($data->bs_before_bootsock_weight_dry_micro));
                $sheet->setCellValue('J'.$numrow, $this->cleanEnter($data->bs_before_comment_micro));
                $sheet->setCellValue('K'.$numrow, $this->cleanEnter($data->bs_before_date_weighed_moisture));
                $sheet->setCellValue('L'.$numrow, $this->cleanEnter($data->bs_before_barcode_bootsocks_moisture));
                $sheet->setCellValue('M'.$numrow, $this->cleanEnter($data->bs_before_bootsock_weight_dry_moisture));
                $sheet->setCellValue('N'.$numrow, $this->cleanEnter($data->bs_before_comment_moisture));
                $sheet->setCellValue('O'.$numrow, $this->cleanEnter($data->bs_after_date_weighed_micro));
                $sheet->setCellValue('P'.$numrow, $this->cleanEnter($data->bs_after_barcode_bootsocks_micro));
                $sheet->setCellValue('Q'.$numrow, $this->cleanEnter($data->bs_after_bootsock_weight_wet_micro));
                $sheet->setCellValue('R'.$numrow, $this->cleanEnter($data->bs_after_comment_micro));
                $sheet->setCellValue('S'.$numrow, $this->cleanEnter($data->bs_after_date_weighed_moisture));
                $sheet->setCellValue('T'.$numrow, $this->cleanEnter($data->bs_after_barcode_bootsocks_moisture));
                $sheet->setCellValue('U'.$numrow, $this->cleanEnter($data->bs_after_bootsock_weight_wet_moisture));
                $sheet->setCellValue('V'.$numrow, $this->cleanEnter($data->bs_after_comment_moisture));
                $sheet->setCellValue('W'.$numrow, $this->cleanEnter($data->old_mois_initial_date_moisture));
                $sheet->setCellValue('X'.$numrow, $this->cleanEnter($data->old_mois_initial_barcode_bootsocks));
                $sheet->setCellValue('Y'.$numrow, $this->cleanEnter($data->old_mois_initial_barcode_foil));
                $sheet->setCellValue('Z'.$numrow, $this->cleanEnter($data->old_mois_initial_foil_weight));
                $sheet->setCellValue('AA'.$numrow, $this->cleanEnter($data->old_mois_initial_wet_weight));
                $sheet->setCellValue('AB'.$numrow, $this->cleanEnter($data->old_mois_initial_time_incubator));
                $sheet->setCellValue('AC'.$numrow, $this->cleanEnter($data->old_mois_initial_comments));
                $sheet->setCellValue('AD'.$numrow, $this->cleanEnter($data->mois_initial_date_moisture));
                $sheet->setCellValue('AE'.$numrow, $this->cleanEnter($data->mois_initial_barcode_foil_tray));
                $sheet->setCellValue('AF'.$numrow, $this->cleanEnter($data->mois_initial_foil_tray_weight));
                $sheet->setCellValue('AG'.$numrow, $this->cleanEnter($data->mois_initial_time_filter_start));
                $sheet->setCellValue('AH'.$numrow, $this->cleanEnter($data->mois_initial_time_filter_finish));
                $sheet->setCellValue('AI'.$numrow, $this->cleanEnter($data->mois_initial_wet_weight));
                $sheet->setCellValue('AJ'.$numrow, $this->cleanEnter($data->mois_initial_time_incubator));
                $sheet->setCellValue('AK'.$numrow, $this->cleanEnter($data->mois_initial_comments));
                $sheet->setCellValue('AL'.$numrow, $this->cleanEnter($data->mois24_date_moisture));
                $sheet->setCellValue('AM'.$numrow, $this->cleanEnter($data->mois24_barcode_foil));
                $sheet->setCellValue('AN'.$numrow, $this->cleanEnter($data->mois24_dry_weight24));
                $sheet->setCellValue('AO'.$numrow, $this->cleanEnter($data->mois24_comments));
                $sheet->setCellValue('AP'.$numrow, $this->cleanEnter($data->mois48_date_moisture));
                $sheet->setCellValue('AQ'.$numrow, $this->cleanEnter($data->mois48_barcode_foil));
                $sheet->setCellValue('AR'.$numrow, $this->cleanEnter($data->mois48_dry_weight48));
                $sheet->setCellValue('AS'.$numrow, $this->cleanEnter($data->mois48_difference));
                $sheet->setCellValue('AT'.$numrow, $this->cleanEnter($data->mois48_comments));
                $sheet->setCellValue('AU'.$numrow, $this->cleanEnter($data->stomacher_date_conduct));
                $sheet->setCellValue('AV'.$numrow, $this->cleanEnter($data->stomacher_barcode_bootsocks1));
                $sheet->setCellValue('AW'.$numrow, $this->cleanEnter($data->stomacher_elution_number_Micro1));
                $sheet->setCellValue('AX'.$numrow, $this->cleanEnter($data->stomacher_elution_Micro1));
                $sheet->setCellValue('AY'.$numrow, $this->cleanEnter($data->stomacher_barcode_falcon_Micro1));
                $sheet->setCellValue('AZ'.$numrow, $this->cleanEnter($data->stomacher_volume_Micro1));
                $sheet->setCellValue('BA'.$numrow, $this->cleanEnter($data->stomacher_elution_number_Micro2));
                $sheet->setCellValue('BB'.$numrow, $this->cleanEnter($data->stomacher_elution_Micro2));
                $sheet->setCellValue('BC'.$numrow, $this->cleanEnter($data->stomacher_barcode_falcon_Micro2));
                $sheet->setCellValue('BD'.$numrow, $this->cleanEnter($data->stomacher_volume_Micro2));        
                $sheet->setCellValue('BE'.$numrow, $this->cleanEnter($data->stomacher_barcode_bootsocks2));
                $sheet->setCellValue('BF'.$numrow, $this->cleanEnter($data->stomacher_elution_number_Moisture1));
                $sheet->setCellValue('BG'.$numrow, $this->cleanEnter($data->stomacher_elution_Moisture1));
                $sheet->setCellValue('BH'.$numrow, $this->cleanEnter($data->stomacher_barcode_falcon_Moisture1));
                $sheet->setCellValue('BI'.$numrow, $this->cleanEnter($data->stomacher_volume_Moisture1));
                $sheet->setCellValue('BJ'.$numrow, $this->cleanEnter($data->stomacher_elution_number_Moisture2));
                $sheet->setCellValue('BK'.$numrow, $this->cleanEnter($data->stomacher_elution_Moisture2));
                $sheet->setCellValue('BL'.$numrow, $this->cleanEnter($data->stomacher_barcode_falcon_Moisture2));
                $sheet->setCellValue('BM'.$numrow, $this->cleanEnter($data->stomacher_volume_Moisture2));     
                $sheet->setCellValue('BN'.$numrow, $this->cleanEnter($data->old_stom_endet_barcode_endetec));
                $sheet->setCellValue('BO'.$numrow, $this->cleanEnter($data->old_stom_endet_barcode_falcon1));
                $sheet->setCellValue('BP'.$numrow, $this->cleanEnter($data->old_stom_endet_volume_falcon1));
                $sheet->setCellValue('BQ'.$numrow, $this->cleanEnter($data->old_stom_endet_barcode_falcon2));
                $sheet->setCellValue('BR'.$numrow, $this->cleanEnter($data->old_stom_endet_volume_falcon2));
                $sheet->setCellValue('BS'.$numrow, $this->cleanEnter($data->old_stom_endet_dilution));
                $sheet->setCellValue('BT'.$numrow, $this->cleanEnter($data->old_stom_endet_time_incu_start));
                $sheet->setCellValue('BU'.$numrow, $this->cleanEnter($data->old_stom_endet_comments));
                $sheet->setCellValue('BV'.$numrow, $this->cleanEnter($data->old_stom_idexx_barcode_colilert));
                $sheet->setCellValue('BW'.$numrow, $this->cleanEnter($data->old_stom_idexx_barcode_falcon1));
                $sheet->setCellValue('BX'.$numrow, $this->cleanEnter($data->old_stom_idexx_volume_falcon1));
                $sheet->setCellValue('BY'.$numrow, $this->cleanEnter($data->old_stom_idexx_barcode_falcon2));
                $sheet->setCellValue('BZ'.$numrow, $this->cleanEnter($data->old_stom_idexx_volume_falcon2));
                $sheet->setCellValue('CA'.$numrow, $this->cleanEnter($data->old_stom_idexx_dilution));
                $sheet->setCellValue('CB'.$numrow, $this->cleanEnter($data->old_stom_idexx_time_incu_start));
                $sheet->setCellValue('CC'.$numrow, $this->cleanEnter($data->old_stom_idexx_comments));
                $sheet->setCellValue('CD'.$numrow, $this->cleanEnter($data->stom_endet_barcode_endetec));
                $sheet->setCellValue('CE'.$numrow, $this->cleanEnter($data->stom_endet_barcode_falcon1));
                $sheet->setCellValue('CF'.$numrow, $this->cleanEnter($data->stom_endet_volume_falcon1));
                $sheet->setCellValue('CG'.$numrow, $this->cleanEnter($data->stom_endet_barcode_falcon2));
                $sheet->setCellValue('CH'.$numrow, $this->cleanEnter($data->stom_endet_volume_falcon2));
                $sheet->setCellValue('CI'.$numrow, $this->cleanEnter($data->stom_endet_dilution));
                $sheet->setCellValue('CJ'.$numrow, $this->cleanEnter($data->stom_endet_time_incu_start));
                $sheet->setCellValue('CK'.$numrow, $this->cleanEnter($data->stom_endet_comments));
                $sheet->setCellValue('CL'.$numrow, $this->cleanEnter($data->stom_idexx_barcode_colilert));
                $sheet->setCellValue('CM'.$numrow, $this->cleanEnter($data->stom_idexx_barcode_falcon1));
                $sheet->setCellValue('CN'.$numrow, $this->cleanEnter($data->stom_idexx_volume_falcon1));
                $sheet->setCellValue('CO'.$numrow, $this->cleanEnter($data->stom_idexx_barcode_falcon2));
                $sheet->setCellValue('CP'.$numrow, $this->cleanEnter($data->stom_idexx_volume_falcon2));
                $sheet->setCellValue('CQ'.$numrow, $this->cleanEnter($data->stom_idexx_dilution));
                $sheet->setCellValue('CR'.$numrow, $this->cleanEnter($data->stom_idexx_time_incu_start));
                $sheet->setCellValue('CS'.$numrow, $this->cleanEnter($data->stom_idexx_comments));
                $sheet->setCellValue('CT'.$numrow, $this->cleanEnter($data->endet_out_b_date_conduct));
                $sheet->setCellValue('CU'.$numrow, $this->cleanEnter($data->endet_out_b_barcode_endetec));
                $sheet->setCellValue('CV'.$numrow, $this->cleanEnter($data->endet_out_b_time_ecoli));
                $sheet->setCellValue('CW'.$numrow, $this->cleanEnter($data->endet_out_b_volume_ecoli));
                $sheet->setCellValue('CX'.$numrow, $this->cleanEnter($data->endet_out_b_total_coliforms));
                $sheet->setCellValue('CY'.$numrow, $this->cleanEnter($data->endet_out_b_comments));
                $sheet->setCellValue('CZ'.$numrow, $this->cleanEnter($data->idexx_out_date_conduct));
                $sheet->setCellValue('DA'.$numrow, $this->cleanEnter($data->idexx_out_barcode_colilert));
                $sheet->setCellValue('DB'.$numrow, $this->cleanEnter($data->idexx_out_timeout_incubation));
                $sheet->setCellValue('DC'.$numrow, $this->cleanEnter($data->idexx_out_time_minutes));
                $sheet->setCellValue('DD'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_largewells));
                $sheet->setCellValue('DE'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_smallwells));
                $sheet->setCellValue('DF'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_mpn));
                $sheet->setCellValue('DG'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_largewells));
                $sheet->setCellValue('DH'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_smallwells));
                $sheet->setCellValue('DI'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_mpn));
                $sheet->setCellValue('DJ'.$numrow, $this->cleanEnter($data->idexx_out_comments));
                $sheet->setCellValue('DK'.$numrow, $this->cleanEnter($data->metagenomics_date_conduct));
                $sheet->setCellValue('DL'.$numrow, $this->cleanEnter($data->metagenomics_barcode_falcon1));
                $sheet->setCellValue('DM'.$numrow, $this->cleanEnter($data->metagenomics_barcode_falcon2));
                $sheet->setCellValue('DN'.$numrow, $this->cleanEnter($data->metagenomics_volume_filtered));
                $sheet->setCellValue('DO'.$numrow, $this->cleanEnter($data->metagenomics_time_started));
                $sheet->setCellValue('DP'.$numrow, $this->cleanEnter($data->metagenomics_time_finished));
                $sheet->setCellValue('DQ'.$numrow, $this->cleanEnter($data->metagenomics_time_minutes));
                $sheet->setCellValue('DR'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna_bag));
                $sheet->setCellValue('DS'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage));
                $sheet->setCellValue('DT'.$numrow, $this->cleanEnter($data->metagenomics_location));
                $sheet->setCellValue('DU'.$numrow, $this->cleanEnter($data->metagenomics_comments));
                $sheet->setCellValue('DV'.$numrow, $this->cleanEnter($data->mac1_barcode_macconkey));
                $sheet->setCellValue('DW'.$numrow, $this->cleanEnter($data->mac1_date_process));
                $sheet->setCellValue('DX'.$numrow, $this->cleanEnter($data->mac1_time_process));
                $sheet->setCellValue('DY'.$numrow, $this->cleanEnter($data->mac1_volume));
                $sheet->setCellValue('DZ'.$numrow, $this->cleanEnter($data->mac1_comments));
                $sheet->setCellValue('EA'.$numrow, $this->cleanEnter($data->mac2_date_process));
                $sheet->setCellValue('EB'.$numrow, $this->cleanEnter($data->mac2_time_process));
                $sheet->setCellValue('EC'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep1));
                $sheet->setCellValue('ED'.$numrow, $this->cleanEnter($data->mac2_cryobox1));
                $sheet->setCellValue('EE'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep2));
                $sheet->setCellValue('EF'.$numrow, $this->cleanEnter($data->mac2_cryobox2));
                $sheet->setCellValue('EG'.$numrow, $this->cleanEnter($data->mac2_comments));
                //   $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $datenow=date("Ymd");
        $fileName = 'O2B_bootsock_report_'.$datenow.'.csv';        
        }
        else if ($rep == 7) {
            $sheet->setCellValue('A1', "reception_date_arrival");
            $sheet->setCellValue('B1', "reception_time_arrival");
            $sheet->setCellValue('C1', "barcode_sample");
            $sheet->setCellValue('D1', "reception_sampletype");
            $sheet->setCellValue('E1', "reception_barcode_tinytag");
            $sheet->setCellValue('F1', "reception_comment");
            $sheet->setCellValue('G1', "sedi_prep_date_conduct");
            $sheet->setCellValue('H1', "sedi_prep_barcode_sample");
            $sheet->setCellValue('I1', "sedi_prep_barcode_tube");
            $sheet->setCellValue('J1', "sedi_prep_subsample_wet");
            $sheet->setCellValue('K1', "sedi_prep_elution");
            $sheet->setCellValue('L1', "mois_initial_date_moisture");
            $sheet->setCellValue('M1', "mois_initial_barcode_sample");
            $sheet->setCellValue('N1', "mois_initial_barcode_foil");
            $sheet->setCellValue('O1', "mois_initial_foil_weight");
            $sheet->setCellValue('P1', "mois_initial_wet_weight");
            $sheet->setCellValue('Q1', "mois_initial_time_incubator");
            $sheet->setCellValue('R1', "mois_initial_comments");
            $sheet->setCellValue('S1', "mois24_date_moisture");
            $sheet->setCellValue('T1', "mois24_barcode_foil");
            $sheet->setCellValue('U1', "mois24_dry_weight24");
            $sheet->setCellValue('V1', "mois24_comments");
            $sheet->setCellValue('W1', "mois48_date_moisture");
            $sheet->setCellValue('X1', "mois48_barcode_foil");
            $sheet->setCellValue('Y1', "mois48_dry_weight48");
            $sheet->setCellValue('Z1', "mois48_difference");
            $sheet->setCellValue('AA1', "mois48_comments");
            $sheet->setCellValue('AB1', "sedi_endet_barcode_endetec");
            $sheet->setCellValue('AC1', "sedi_endet_volume_falcon");
            $sheet->setCellValue('AD1', "sedi_endet_dilution");
            $sheet->setCellValue('AE1', "sedi_endet_time_incu_start");
            $sheet->setCellValue('AF1', "sedi_endet_comments");
            $sheet->setCellValue('AG1', "endet_out(s)_date_conduct");
            $sheet->setCellValue('AH1', "endet_out(s)_barcode_endetec");
            $sheet->setCellValue('AI1', "endet_out(s)_time_ecoli");
            $sheet->setCellValue('AJ1', "endet_out(s)_volume_ecoli");
            $sheet->setCellValue('AK1', "endet_out(s)_total_coliforms");
            $sheet->setCellValue('AL1', "endet_out(s)_comments");
            $sheet->setCellValue('AM1', "sedi_idexx_barcode_colilert");
            $sheet->setCellValue('AN1', "sedi_idexx_volume");
            $sheet->setCellValue('AO1', "sedi_idexx_dilution");
            $sheet->setCellValue('AP1', "sedi_idexx_time_incubation");
            $sheet->setCellValue('AQ1', "sedi_idexx_comments");
            $sheet->setCellValue('AR1', "sedi_idexx_barcode_colilert2");
            $sheet->setCellValue('AS1', "sedi_idexx_volume2");
            $sheet->setCellValue('AT1', "sedi_idexx_dilution2");
            $sheet->setCellValue('AU1', "sedi_idexx_time_incubation2");
            $sheet->setCellValue('AV1', "sedi_idexx_comments2");
            $sheet->setCellValue('AW1', "idexx_out_date_conduct");
            $sheet->setCellValue('AX1', "idexx_out_timeout_incubation");
            $sheet->setCellValue('AY1', "idexx_out_time_minutes");
            $sheet->setCellValue('AZ1', "idexx_out_ecoli_largewells");
            $sheet->setCellValue('BA1', "idexx_out_ecoli_smallwells");
            $sheet->setCellValue('BB1', "idexx_out_ecoli_mpn");
            $sheet->setCellValue('BC1', "idexx_out_coliforms_largewells");
            $sheet->setCellValue('BD1', "idexx_out_coliforms_smallwells");
            $sheet->setCellValue('BE1', "idexx_out_coliforms_mpn");
            $sheet->setCellValue('BF1', "idexx_out_comments");
            $sheet->setCellValue('BG1', "idexx_out_date_conduct2");
            $sheet->setCellValue('BH1', "idexx_out_timeout_incubation2");
            $sheet->setCellValue('BI1', "idexx_out_time_minutes2");
            $sheet->setCellValue('BJ1', "idexx_out_ecoli_largewells2");
            $sheet->setCellValue('BK1', "idexx_out_ecoli_smallwells2");
            $sheet->setCellValue('BL1', "idexx_out_ecoli_mpn2");
            $sheet->setCellValue('BM1', "idexx_out_coliforms_largewells2");
            $sheet->setCellValue('BN1', "idexx_out_coliforms_smallwells2");
            $sheet->setCellValue('BO1', "idexx_out_coliforms_mpn2");
            $sheet->setCellValue('BP1', "idexx_out_comments2");
            $sheet->setCellValue('BQ1', "metagenomics_date_conduct");
            $sheet->setCellValue('BR1', "metagenomics_barcode_sample");
            $sheet->setCellValue('BS1', "metagenomics_barcode_dna1");
            $sheet->setCellValue('BT1', "metagenomics_weight_sub1");
            $sheet->setCellValue('BU1', "metagenomics_barcode_storage1");
            $sheet->setCellValue('BV1', "metagenomics_position_tube1");
            $sheet->setCellValue('BW1', "metagenomics_location1");
            $sheet->setCellValue('BX1', "metagenomics_barcode_dna2");
            $sheet->setCellValue('BY1', "metagenomics_weight_sub2");
            $sheet->setCellValue('BZ1', "metagenomics_barcode_storage2");
            $sheet->setCellValue('CA1', "metagenomics_position_tube2");
            $sheet->setCellValue('CB1', "metagenomics_location2");
            $sheet->setCellValue('CC1', "metagenomics_comments");
            $sheet->setCellValue('CD1', "mac1_barcode_macconkey");
            $sheet->setCellValue('CE1', "mac1_date_process");
            $sheet->setCellValue('CF1', "mac1_time_process");
            $sheet->setCellValue('CG1', "mac1_volume");
            $sheet->setCellValue('CH1', "mac1_comments");
            $sheet->setCellValue('CI1', "mac2_date_process");
            $sheet->setCellValue('CJ1', "mac2_time_process");
            $sheet->setCellValue('CK1', "mac2_bar_macsweep1");
            $sheet->setCellValue('CL1', "mac2_cryobox1");
            $sheet->setCellValue('CM1', "mac2_bar_macsweep2");
            $sheet->setCellValue('CN1', "mac2_cryobox2");
            $sheet->setCellValue('CO1', "mac2_comments");

            $rdeliver = $this->REP_o2b_model->get_sediment($date1, $date2, $rep);
        
            $numrow = 2; 
            foreach($rdeliver as $data){ 
                $sheet->setCellValue('A'.$numrow, $this->cleanEnter($data->reception_date_arrival));
                $sheet->setCellValue('B'.$numrow, $this->cleanEnter($data->reception_time_arrival));
                $sheet->setCellValue('C'.$numrow, $this->cleanEnter($data->barcode_sample));
                $sheet->setCellValue('D'.$numrow, $this->cleanEnter($data->reception_sampletype));
                $sheet->setCellValue('E'.$numrow, $this->cleanEnter($data->reception_barcode_tinytag));
                $sheet->setCellValue('F'.$numrow, $this->cleanEnter($data->reception_comment));
                $sheet->setCellValue('G'.$numrow, $this->cleanEnter($data->sedi_prep_date_conduct));
                $sheet->setCellValue('H'.$numrow, $this->cleanEnter($data->sedi_prep_barcode_sample));
                $sheet->setCellValue('I'.$numrow, $this->cleanEnter($data->sedi_prep_barcode_tube));
                $sheet->setCellValue('J'.$numrow, $this->cleanEnter($data->sedi_prep_subsample_wet));
                $sheet->setCellValue('K'.$numrow, $this->cleanEnter($data->sedi_prep_elution));
                $sheet->setCellValue('L'.$numrow, $this->cleanEnter($data->mois_initial_date_moisture));
                $sheet->setCellValue('M'.$numrow, $this->cleanEnter($data->mois_initial_barcode_sample));
                $sheet->setCellValue('N'.$numrow, $this->cleanEnter($data->mois_initial_barcode_foil));
                $sheet->setCellValue('O'.$numrow, $this->cleanEnter($data->mois_initial_foil_weight));
                $sheet->setCellValue('P'.$numrow, $this->cleanEnter($data->mois_initial_wet_weight));
                $sheet->setCellValue('Q'.$numrow, $this->cleanEnter($data->mois_initial_time_incubator));
                $sheet->setCellValue('R'.$numrow, $this->cleanEnter($data->mois_initial_comments));
                $sheet->setCellValue('S'.$numrow, $this->cleanEnter($data->mois24_date_moisture));
                $sheet->setCellValue('T'.$numrow, $this->cleanEnter($data->mois24_barcode_foil));
                $sheet->setCellValue('U'.$numrow, $this->cleanEnter($data->mois24_dry_weight24));
                $sheet->setCellValue('V'.$numrow, $this->cleanEnter($data->mois24_comments));
                $sheet->setCellValue('W'.$numrow, $this->cleanEnter($data->mois48_date_moisture));
                $sheet->setCellValue('X'.$numrow, $this->cleanEnter($data->mois48_barcode_foil));
                $sheet->setCellValue('Y'.$numrow, $this->cleanEnter($data->mois48_dry_weight48));
                $sheet->setCellValue('Z'.$numrow, $this->cleanEnter($data->mois48_difference));
                $sheet->setCellValue('AA'.$numrow, $this->cleanEnter($data->mois48_comments));
                $sheet->setCellValue('AB'.$numrow, $this->cleanEnter($data->sedi_endet_barcode_endetec));
                $sheet->setCellValue('AC'.$numrow, $this->cleanEnter($data->sedi_endet_volume_falcon));
                $sheet->setCellValue('AD'.$numrow, $this->cleanEnter($data->sedi_endet_dilution));
                $sheet->setCellValue('AE'.$numrow, $this->cleanEnter($data->sedi_endet_time_incu_start));
                $sheet->setCellValue('AF'.$numrow, $this->cleanEnter($data->sedi_endet_comments));
                $sheet->setCellValue('AG'.$numrow, $this->cleanEnter($data->endet_out_s_date_conduct));
                $sheet->setCellValue('AH'.$numrow, $this->cleanEnter($data->endet_out_s_barcode_endetec));
                $sheet->setCellValue('AI'.$numrow, $this->cleanEnter($data->endet_out_s_time_ecoli));
                $sheet->setCellValue('AJ'.$numrow, $this->cleanEnter($data->endet_out_s_volume_ecoli));
                $sheet->setCellValue('AK'.$numrow, $this->cleanEnter($data->endet_out_s_total_coliforms));
                $sheet->setCellValue('AL'.$numrow, $this->cleanEnter($data->endet_out_s_comments));
                $sheet->setCellValue('AM'.$numrow, $this->cleanEnter($data->sedi_idexx_barcode_colilert));
                $sheet->setCellValue('AN'.$numrow, $this->cleanEnter($data->sedi_idexx_volume));
                $sheet->setCellValue('AO'.$numrow, $this->cleanEnter($data->sedi_idexx_dilution));
                $sheet->setCellValue('AP'.$numrow, $this->cleanEnter($data->sedi_idexx_time_incubation));
                $sheet->setCellValue('AQ'.$numrow, $this->cleanEnter($data->sedi_idexx_comments));
                $sheet->setCellValue('AR'.$numrow, $this->cleanEnter($data->sedi_idexx_barcode_colilert2));
                $sheet->setCellValue('AS'.$numrow, $this->cleanEnter($data->sedi_idexx_volume2));
                $sheet->setCellValue('AT'.$numrow, $this->cleanEnter($data->sedi_idexx_dilution2));
                $sheet->setCellValue('AU'.$numrow, $this->cleanEnter($data->sedi_idexx_time_incubation2));
                $sheet->setCellValue('AV'.$numrow, $this->cleanEnter($data->sedi_idexx_comments2));
                $sheet->setCellValue('AW'.$numrow, $this->cleanEnter($data->idexx_out_date_conduct));
                $sheet->setCellValue('AX'.$numrow, $this->cleanEnter($data->idexx_out_timeout_incubation));
                $sheet->setCellValue('AY'.$numrow, $this->cleanEnter($data->idexx_out_time_minutes));
                $sheet->setCellValue('AZ'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_largewells));
                $sheet->setCellValue('BA'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_smallwells));
                $sheet->setCellValue('BB'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_mpn));
                $sheet->setCellValue('BC'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_largewells));
                $sheet->setCellValue('BD'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_smallwells));
                $sheet->setCellValue('BE'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_mpn));
                $sheet->setCellValue('BF'.$numrow, $this->cleanEnter($data->idexx_out_comments));
                $sheet->setCellValue('BG'.$numrow, $this->cleanEnter($data->idexx_out_date_conduct2));
                $sheet->setCellValue('BH'.$numrow, $this->cleanEnter($data->idexx_out_timeout_incubation2));
                $sheet->setCellValue('BI'.$numrow, $this->cleanEnter($data->idexx_out_time_minutes2));
                $sheet->setCellValue('BJ'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_largewells2));
                $sheet->setCellValue('BK'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_smallwells2));
                $sheet->setCellValue('BL'.$numrow, $this->cleanEnter($data->idexx_out_ecoli_mpn2));
                $sheet->setCellValue('BM'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_largewells2));
                $sheet->setCellValue('BN'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_smallwells2));
                $sheet->setCellValue('BO'.$numrow, $this->cleanEnter($data->idexx_out_coliforms_mpn2));
                $sheet->setCellValue('BP'.$numrow, $this->cleanEnter($data->idexx_out_comments2));
                $sheet->setCellValue('BQ'.$numrow, $this->cleanEnter($data->metagenomics_date_conduct));
                $sheet->setCellValue('BR'.$numrow, $this->cleanEnter($data->metagenomics_barcode_sample));
                $sheet->setCellValue('BS'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna1));
                $sheet->setCellValue('BT'.$numrow, $this->cleanEnter($data->metagenomics_weight_sub1));
                $sheet->setCellValue('BU'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage1));
                $sheet->setCellValue('BV'.$numrow, $this->cleanEnter($data->metagenomics_position_tube1));
                $sheet->setCellValue('BW'.$numrow, $this->cleanEnter($data->metagenomics_location1));
                $sheet->setCellValue('BX'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna2));
                $sheet->setCellValue('BY'.$numrow, $this->cleanEnter($data->metagenomics_weight_sub2));
                $sheet->setCellValue('BZ'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage2));
                $sheet->setCellValue('CA'.$numrow, $this->cleanEnter($data->metagenomics_position_tube2));
                $sheet->setCellValue('CB'.$numrow, $this->cleanEnter($data->metagenomics_location2));
                $sheet->setCellValue('CC'.$numrow, $this->cleanEnter($data->metagenomics_comments));
                $sheet->setCellValue('CD'.$numrow, $this->cleanEnter($data->mac1_barcode_macconkey));
                $sheet->setCellValue('CE'.$numrow, $this->cleanEnter($data->mac1_date_process));
                $sheet->setCellValue('CF'.$numrow, $this->cleanEnter($data->mac1_time_process));
                $sheet->setCellValue('CG'.$numrow, $this->cleanEnter($data->mac1_volume));
                $sheet->setCellValue('CH'.$numrow, $this->cleanEnter($data->mac1_comments));
                $sheet->setCellValue('CI'.$numrow, $this->cleanEnter($data->mac2_date_process));
                $sheet->setCellValue('CJ'.$numrow, $this->cleanEnter($data->mac2_time_process));
                $sheet->setCellValue('CK'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep1));
                $sheet->setCellValue('CL'.$numrow, $this->cleanEnter($data->mac2_cryobox1));
                $sheet->setCellValue('CM'.$numrow, $this->cleanEnter($data->mac2_bar_macsweep2));
                $sheet->setCellValue('CN'.$numrow, $this->cleanEnter($data->mac2_cryobox2));
                $sheet->setCellValue('CO'.$numrow, $this->cleanEnter($data->mac2_comments)); 
                
                //   $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $datenow=date("Ymd");
        $fileName = 'O2B_sediment_report_'.$datenow.'.csv';            
        }
        else if ($rep == 8) {
            $sheet->setCellValue('A1', "reception_date_arrival");
            $sheet->setCellValue('B1', "reception_time_arrival");
            $sheet->setCellValue('C1', "barcode_sample");
            $sheet->setCellValue('D1', "reception_sampletype");
            $sheet->setCellValue('E1', "reception_barcode_tinytag");
            $sheet->setCellValue('F1', "reception_comment");
            $sheet->setCellValue('G1', "metagenomics_date_conduct");
            $sheet->setCellValue('H1', "metagenomics_barcode_sample");
            $sheet->setCellValue('I1', "metagenomics_barcode_dna1");
            $sheet->setCellValue('J1', "metagenomics_weight_sub1");
            $sheet->setCellValue('K1', "metagenomics_barcode_storage1");
            $sheet->setCellValue('L1', "metagenomics_position_tube1");
            $sheet->setCellValue('M1', "metagenomics_location1");
            $sheet->setCellValue('N1', "metagenomics_barcode_dna2");
            $sheet->setCellValue('O1', "metagenomics_weight_sub2");
            $sheet->setCellValue('P1', "metagenomics_barcode_storage2");
            $sheet->setCellValue('Q1', "metagenomics_position_tube2");
            $sheet->setCellValue('R1', "metagenomics_location2");
            $sheet->setCellValue('S1', "metagenomics_comments");
            
            $rdeliver = $this->REP_o2b_model->get_feces($date1, $date2, $rep);
        
            $numrow = 2; 
            foreach($rdeliver as $data){ 
                $sheet->setCellValue('A'.$numrow, $this->cleanEnter($data->reception_date_arrival));
                $sheet->setCellValue('B'.$numrow, $this->cleanEnter($data->reception_time_arrival));
                $sheet->setCellValue('C'.$numrow, $this->cleanEnter($data->barcode_sample));
                $sheet->setCellValue('D'.$numrow, $this->cleanEnter($data->reception_sampletype));
                $sheet->setCellValue('E'.$numrow, $this->cleanEnter($data->reception_barcode_tinytag));
                $sheet->setCellValue('F'.$numrow, $this->cleanEnter($data->reception_comment));
                $sheet->setCellValue('G'.$numrow, $this->cleanEnter($data->metagenomics_date_conduct));
                $sheet->setCellValue('H'.$numrow, $this->cleanEnter($data->metagenomics_barcode_sample));
                $sheet->setCellValue('I'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna1));
                $sheet->setCellValue('J'.$numrow, $this->cleanEnter($data->metagenomics_weight_sub1));
                $sheet->setCellValue('K'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage1));
                $sheet->setCellValue('L'.$numrow, $this->cleanEnter($data->metagenomics_position_tube1));
                $sheet->setCellValue('M'.$numrow, $this->cleanEnter($data->metagenomics_location1));
                $sheet->setCellValue('N'.$numrow, $this->cleanEnter($data->metagenomics_barcode_dna2));
                $sheet->setCellValue('O'.$numrow, $this->cleanEnter($data->metagenomics_weight_sub2));
                $sheet->setCellValue('P'.$numrow, $this->cleanEnter($data->metagenomics_barcode_storage2));
                $sheet->setCellValue('Q'.$numrow, $this->cleanEnter($data->metagenomics_position_tube2));
                $sheet->setCellValue('R'.$numrow, $this->cleanEnter($data->metagenomics_location2));
                $sheet->setCellValue('S'.$numrow, $this->cleanEnter($data->metagenomics_comments));
                                
                //   $no++; // Tambah 1 setiap kali looping
              $numrow++; // Tambah 1 setiap kali looping
            }
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
        $datenow=date("Ymd");
        $fileName = 'O2B_animalfeces_report_'.$datenow.'.csv';            
        }
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=$fileName"); // Set nama file excel nya
    header('Cache-Control: max-age=0');
    $writer->save('php://output');           
    }

}


/* End of file Tbl_customer.php */
/* Location: ./application/controllers/Tbl_customer.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */