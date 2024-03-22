<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class REP_o2b_model extends CI_Model
{

    public $table = 'obj2b_receipt';
    public $id = 'barcode_sample';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json($date1, $date2, $rep) {
        $this->datatables->select('a.barcode_sample, a.date_arrival, a.time_arrival, b.sampletype, a.png_control, a.barcode_tinytag');
        $this->datatables->from('obj2b_receipt a');
        $this->datatables->join('ref_sampletype b', 'a.id_type2b = b.id_sampletype', 'left');
        if ($rep == '6x') {
            $this->datatables->where('a.id_type2b', '6');
            $this->datatables->where("(LEFT(a.barcode_sample, 2) = 'N0' OR LEFT(a.barcode_sample, 2) = 'F0')");
        }
        else if ($rep == '6') {
            $this->datatables->where('a.id_type2b', '6');
            $this->datatables->where("(LEFT(a.barcode_sample, 2) <> 'N0' AND LEFT(a.barcode_sample, 2) <> 'F0')");
        }
        else {
            $this->datatables->where('a.id_type2b', $rep);
        } 
        $this->datatables->where('a.lab', $this->session->userdata('lab'));
        $this->datatables->where('a.flag', '0');
        $this->datatables->where("(a.date_arrival >= IF('$date1' IS NULL or '$date1' = '', '0000-00-00', '$date1'))", NULL);
        $this->datatables->where("(a.date_arrival <= IF('$date2' IS NULL or '$date2' = '', NOW(), '$date2'))", NULL);
        // $this->datatables->limit('50');
        return $this->datatables->generate();
    }

    function get_water($date1, $date2, $rep)
    {
        $q = $this->db->query('
        SELECT 
        a.date_arrival AS reception_date_arrival, 
        a.time_arrival AS reception_time_arrival, 
        a.barcode_sample AS barcode_sample, 
        h.sampletype AS reception_sampletype, 
        a.barcode_tinytag AS reception_barcode_tinytag, 
        a.comments AS reception_comment,
        b.barcode_sample AS chemistry_barcode_sample, 
        i.sampletype AS chemistry_sampletype2bwat, 
        b.barcode_nitro AS chemistry_barcode_nitro, 
        b.3rdparty_lab AS chemistry_3rdparty_lab,
        b.barcode_nitro2 AS chemistry_barcode_nitro_2nd, 
        b.3rdparty_lab2 AS chemistry_3rdparty_lab_2nd,
        b.barcode_microbiology AS chemistry_barcode_microbiology, 
        b.3rdparty_lab3 AS chemistry_3rdparty_lab3,
        b.barcode_microbiology2 AS chemistry_barcode_microbiology2, 
        b.3rdparty_lab4 AS chemistry_3rdparty_lab4,
        b.comments AS chemistry_comment,
        c.barcode_sample AS endetec_in_barcode_sample,
        c.date_conduct AS endetec_in_date_conduct, 
        c.time_incubation AS endetec_in_time_incubation, 
        c.barcode_endetec AS endetec_in_barcode_endetec,
        c.volume AS endetec_in_volume,
        c.dilution AS endetec_in_dilution, 
        c.comments AS endetec_in_comment,
        d.date_conduct AS endetec_out_date_conduct,
        d.barcode_endetec AS endetec_out_barcode_endetec,
        d.time_ecoli AS endetec_out_time_ecoli,
        d.volume_ecoli AS endetec_out_volume_ecoli,
        d.ecoli_cfu AS endetec_out_ecoli_cfu,
        d.total_coliforms AS endetec_out_total_coliforms,
        d.total_coli_cfu AS endetec_out_total_coli_cfu,
        d.comments AS endetec_out_comments,
        e.barcode_sample AS idexx_in_barcode_sample,
        e.date_conduct AS idexx_in_date_conduct,
        e.time_incubation AS idexx_in_time_incubation,
        e.barcode_colilert AS idexx_in_barcode_colilert,
        e.volume AS idexx_in_volume,
        e.dilution AS idexx_in_dilution,
        e.comments AS idexx_in_comments,
        e.barcode_colilert2 AS idexx_in_barcode_colilert2,
        e.volume2 AS idexx_in_volume2,
        e.dilution2 AS idexx_in_dilution2,
        e.comments2 AS idexx_in_comments2,
        f.date_conduct AS idexx_out_date_conduct,
        f.barcode_colilert AS idexx_out_barcode_colilert,
        f.timeout_incubation AS idexx_out_timeout_incubation,
        f.time_minutes AS idexx_out_time_minutes,
        f.ecoli_largewells AS idexx_out_ecoli_largewells,
        f.ecoli_smallwells AS idexx_out_ecoli_smallwells,
        f.ecoli_mpn AS idexx_out_ecoli_mpn,
        f.coliforms_largewells AS idexx_out_coliforms_largewells,
        f.coliforms_smallwells AS idexx_out_coliforms_smallwells,
        f.coliforms_mpn AS idexx_out_coliforms_mpn,
        f.comments AS idexx_out_comments,
        m.date_conduct AS idexx_out_date_conduct2,
        m.barcode_colilert AS idexx_out_barcode_colilert2,
        m.timeout_incubation AS idexx_out_timeout_incubation2,
        m.time_minutes AS idexx_out_time_minutes2,
        m.ecoli_largewells AS idexx_out_ecoli_largewells2,
        m.ecoli_smallwells AS idexx_out_ecoli_smallwells2,
        m.ecoli_mpn AS idexx_out_ecoli_mpn2,
        m.coliforms_largewells AS idexx_out_coliforms_largewells2,
        m.coliforms_smallwells AS idexx_out_coliforms_smallwells2,
        m.coliforms_mpn AS idexx_out_coliforms_mpn2,
        m.comments AS idexx_out_comments2,
        g.date_conduct AS metagenomics_date_conduct,
        g.barcode_sample AS metagenomics_barcode_sample,
        g.volume_filtered AS metagenomics_volume_filtered,
        g.time_started AS metagenomics_time_started,
        g.time_finished AS metagenomics_time_finished,
        g.time_minutes AS metagenomics_time_minutes,
        g.barcode_dna_bag AS metagenomics_barcode_dna_bag,
        g.barcode_storage AS metagenomics_barcode_storage,
        concat("F",j.freezer,"-","S",j.shelf,"-","R",j.rack,"-","DRW",j.rack_level) AS metagenomics_location,
        g.comments AS metagenomics_comments,
        k.bar_macconkey AS mac1_barcode_macconkey,
        k.date_process AS mac1_date_process,
        k.time_process AS mac1_time_process,
        k.volume AS mac1_volume,
        k.comments AS mac1_comments,
        l.date_process AS mac2_date_process,
        l.time_process AS mac2_time_process,
        l.bar_macsweep1 AS mac2_bar_macsweep1,
        l.cryobox1 AS mac2_cryobox1,
        l.bar_macsweep2 AS mac2_bar_macsweep2,
        l.cryobox2 AS mac2_cryobox2,
        l.comments AS mac2_comments    
        FROM obj2b_receipt a
        LEFT JOIN obj2b_chemistry b ON a.barcode_sample=b.barcode_sample
        LEFT JOIN obj2b_endetec1 c ON a.barcode_sample=c.barcode_sample
        LEFT JOIN obj2b_endetec2 d ON c.barcode_endetec=d.barcode_endetec
        LEFT JOIN obj2b_idexx1 e ON a.barcode_sample=e.barcode_sample
        LEFT JOIN obj2b_idexx2 f ON e.barcode_colilert=f.barcode_colilert
        LEFT JOIN obj2b_idexx2 m ON e.barcode_colilert2=m.barcode_colilert
        LEFT JOIN obj2b_metagenomics g ON a.barcode_sample=g.barcode_sample
        LEFT JOIN ref_sampletype h ON a.id_type2b=h.id_sampletype
        LEFT JOIN ref_sampletype i ON b.id_type2bwat=i.id_sampletype
        LEFT JOIN ref_location_80 j ON g.id_location_80=j.id_location_80 AND j.lab = "'.$this->session->userdata('lab').'" 
        LEFT JOIN obj2b_mac1 k ON k.barcode_sample=a.barcode_sample
        LEFT JOIN obj2b_mac2 l ON l.bar_macconkey=k.bar_macconkey
        WHERE a.id_type2b = 6 AND '.
        (($rep == '6x') ? '(left(a.barcode_sample, 2) = "N0" OR left(a.barcode_sample, 2) = "F0")' : '(left(a.barcode_sample, 2) <> "N0" AND left(a.barcode_sample, 2) <> "F0")')
        .'AND (a.date_arrival >= "'.$date1.'"
            AND a.date_arrival <= "'.$date2.'")
        AND a.lab = "'.$this->session->userdata('lab').'" 
        AND a.flag = 0 
        ORDER BY a.date_arrival DESC, a.time_arrival ASC 
        ');        
        $response = $q->result();
        return $response;
    }    

    function get_bootsock($date1, $date2, $rep)
    {
        $q = $this->db->query('
        SELECT 
        a.date_arrival AS reception_date_arrival, 
        a.time_arrival AS reception_time_arrival, 
        a.barcode_sample AS barcode_sample, 
        m.sampletype AS reception_sampletype, 
        a.barcode_tinytag AS reception_barcode_tinytag, 
        a.comments AS reception_comment,
        b.date_weighed AS bs_before_date_weighed_micro, 
        b.barcode_bootsocks AS bs_before_barcode_bootsocks_micro,
        b.bootsock_weight_dry AS bs_before_bootsock_weight_dry_micro,
        b.comments AS bs_before_comment_micro,
        u.date_weighed AS bs_before_date_weighed_moisture, 
        u.barcode_bootsocks AS bs_before_barcode_bootsocks_moisture,
        u.bootsock_weight_dry AS bs_before_bootsock_weight_dry_moisture,
        u.comments AS bs_before_comment_moisture,
        c.date_weighed AS bs_after_date_weighed_micro, 
        c.barcode_bootsocks AS bs_after_barcode_bootsocks_micro, 
        c.bootsock_weight_wet AS bs_after_bootsock_weight_wet_micro,
        c.comments AS bs_after_comment_micro,
        v.date_weighed AS bs_after_date_weighed_moisture, 
        v.barcode_bootsocks AS bs_after_barcode_bootsocks_moisture, 
        v.bootsock_weight_wet AS bs_after_bootsock_weight_wet_moisture,
        v.comments AS bs_after_comment_moisture,
        d.date_moisture AS old_mois_initial_date_moisture,
        d.barcode_bootsock AS old_mois_initial_barcode_bootsocks,
        d.barcode_foil AS old_mois_initial_barcode_foil,
        d.foil_weight AS old_mois_initial_foil_weight,
        d.wet_weight AS old_mois_initial_wet_weight,
        d.time_incubator AS old_mois_initial_time_incubator,
        d.comments AS old_mois_initial_comments,
        r.date_moisture AS mois_initial_date_moisture,
        r.barcode_foil AS mois_initial_barcode_foil_tray,
        r.foil_weight AS mois_initial_foil_tray_weight,
        r.time_filter_start AS mois_initial_time_filter_start,
        r.time_filter_finish AS mois_initial_time_filter_finish,
        r.wet_weight AS mois_initial_wet_weight,
        r.time_incubator AS mois_initial_time_incubator,
        r.comments AS mois_initial_comments,
        e.date_moisture AS mois24_date_moisture,
        e.barcode_foil AS mois24_barcode_foil,
        e.dry_weight24 AS mois24_dry_weight24,
        e.comments AS mois24_comments,
        f.date_moisture AS mois48_date_moisture,
        f.barcode_foil AS mois48_barcode_foil,
        f.dry_weight48 AS mois48_dry_weight48,
        f.difference AS mois48_difference,
        f.comments AS mois48_comments,
        g.date_conduct AS stomacher_date_conduct,
        g.barcode_bootsock AS stomacher_barcode_bootsocks1,
        g.elution_no AS stomacher_elution_number_Micro1,
        g.elution AS stomacher_elution_Micro1,
        g.barcode_falcon AS stomacher_barcode_falcon_Micro1,
        g.volume_stomacher AS stomacher_volume_Micro1,
        o.elution_no AS stomacher_elution_number_Micro2,
        o.elution AS stomacher_elution_Micro2,
        o.barcode_falcon AS stomacher_barcode_falcon_Micro2,
        o.volume_stomacher AS stomacher_volume_Micro2,
        s.barcode_bootsock AS stomacher_barcode_bootsocks2,
        s.elution_no AS stomacher_elution_number_Moisture1,
        s.elution AS stomacher_elution_Moisture1,
        s.barcode_falcon AS stomacher_barcode_falcon_Moisture1,
        s.volume_stomacher AS stomacher_volume_Moisture1,
        t.elution_no AS stomacher_elution_number_Moisture2,
        t.elution AS stomacher_elution_Moisture2,
        t.barcode_falcon AS stomacher_barcode_falcon_Moisture2,
        t.volume_stomacher AS stomacher_volume_Moisture2,
        h.barcode_endetec AS old_stom_endet_barcode_endetec,
        h.barcode_falcon1 AS old_stom_endet_barcode_falcon1,
        h.volume_falcon1 AS old_stom_endet_volume_falcon1,
        h.barcode_falcon2 AS old_stom_endet_barcode_falcon2,
        h.volume_falcon2 AS old_stom_endet_volume_falcon2,
        h.dilution AS old_stom_endet_dilution,
        h.time_incubation AS old_stom_endet_time_incu_start,
        h.comments AS old_stom_endet_comments,
        j.barcode_colilert AS old_stom_idexx_barcode_colilert,
        j.barcode_falcon1 AS old_stom_idexx_barcode_falcon1,
        j.volume_falcon1 AS old_stom_idexx_volume_falcon1,
        j.barcode_falcon2 AS old_stom_idexx_barcode_falcon2,
        j.volume_falcon2 AS old_stom_idexx_volume_falcon2,
        j.dilution AS old_stom_idexx_dilution,
        j.time_incubation AS old_stom_idexx_time_incu_start,
        j.comments AS old_stom_idexx_comments,
        w.barcode_endetec AS stom_endet_barcode_endetec,
        w.barcode_falcon1 AS stom_endet_barcode_falcon1,
        w.volume_falcon1 AS stom_endet_volume_falcon1,
        w.barcode_falcon2 AS stom_endet_barcode_falcon2,
        w.volume_falcon2 AS stom_endet_volume_falcon2,
        w.dilution AS stom_endet_dilution,
        w.time_incubation AS stom_endet_time_incu_start,
        w.comments AS stom_endet_comments,
        x.barcode_colilert AS stom_idexx_barcode_colilert,
        x.barcode_falcon1 AS stom_idexx_barcode_falcon1,
        x.volume_falcon1 AS stom_idexx_volume_falcon1,
        x.barcode_falcon2 AS stom_idexx_barcode_falcon2,
        x.volume_falcon2 AS stom_idexx_volume_falcon2,
        x.dilution AS stom_idexx_dilution,
        x.time_incubation AS stom_idexx_time_incu_start,
        x.comments AS stom_idexx_comments,
        i.date_conduct AS endet_out_b_date_conduct,
        i.barcode_endetec AS endet_out_b_barcode_endetec,
        i.time_ecoli AS endet_out_b_time_ecoli,
        i.volume_ecoli AS endet_out_b_volume_ecoli,
        i.total_coliforms AS endet_out_b_total_coliforms,
        i.comments AS endet_out_b_comments,
        k.date_conduct AS idexx_out_date_conduct,
        k.barcode_colilert AS idexx_out_barcode_colilert,
        k.timeout_incubation AS idexx_out_timeout_incubation,
        k.time_minutes AS idexx_out_time_minutes,
        k.ecoli_largewells AS idexx_out_ecoli_largewells,
        k.ecoli_smallwells AS idexx_out_ecoli_smallwells,
        k.ecoli_mpn AS idexx_out_ecoli_mpn,
        k.coliforms_largewells AS idexx_out_coliforms_largewells,
        k.coliforms_smallwells AS idexx_out_coliforms_smallwells,
        k.coliforms_mpn AS idexx_out_coliforms_mpn,
        k.comments AS idexx_out_comments,
        l.date_conduct AS metagenomics_date_conduct,
        l.barcode_sample AS metagenomics_barcode_falcon1,
        l.barcode_falcon2 AS metagenomics_barcode_falcon2,
        l.volume_filtered AS metagenomics_volume_filtered,
        l.time_started AS metagenomics_time_started,
        l.time_finished AS metagenomics_time_finished,
        l.time_minutes AS metagenomics_time_minutes,
        l.barcode_dna_bag AS metagenomics_barcode_dna_bag,
        l.barcode_storage AS metagenomics_barcode_storage,
        concat("F",n.freezer,"-","S",n.shelf,"-","R",n.rack,"-","DRW",n.rack_level) AS metagenomics_location,
        l.comments AS metagenomics_comments,
        p.bar_macconkey AS mac1_barcode_macconkey,
        p.date_process AS mac1_date_process,
        p.time_process AS mac1_time_process,
        p.volume AS mac1_volume,
        p.comments AS mac1_comments,
        q.date_process AS mac2_date_process,
        q.time_process AS mac2_time_process,
        q.bar_macsweep1 AS mac2_bar_macsweep1,
        q.cryobox1 AS mac2_cryobox1,
        q.bar_macsweep2 AS mac2_bar_macsweep2,
        q.cryobox2 AS mac2_cryobox2,
        q.comments AS mac2_comments
        FROM obj2b_receipt a
        LEFT JOIN obj2b_bs_stomacher g ON a.barcode_sample=g.barcode_sample AND g.elution_no="Micro1"
        LEFT JOIN obj2b_bs_stomacher o ON a.barcode_sample=o.barcode_sample AND o.elution_no="Micro2"
        LEFT JOIN obj2b_bs_stomacher s ON a.barcode_sample=s.barcode_sample AND s.elution_no="Moisture1"
        LEFT JOIN obj2b_bs_stomacher t ON a.barcode_sample=t.barcode_sample AND t.elution_no="Moisture2"
        LEFT JOIN obj2b_moisture1 d ON a.barcode_sample=d.barcode_sample
        LEFT JOIN obj2b_moisture1 r ON s.barcode_falcon=r.barcode_sample AND s.elution_no="Moisture1"
        LEFT JOIN obj2b_moisture2 e ON r.barcode_foil=e.barcode_foil
        LEFT JOIN obj2b_moisture3 f ON r.barcode_foil=f.barcode_foil
        LEFT JOIN obj2b_bootsocks_before b ON b.barcode_bootsocks=g.barcode_bootsock AND g.elution_no="Micro1"
        LEFT JOIN obj2b_bootsocks_after c ON c.barcode_bootsocks=g.barcode_bootsock AND g.elution_no="Micro1"
        LEFT JOIN obj2b_bootsocks_before u ON u.barcode_bootsocks=s.barcode_bootsock AND s.elution_no="Moisture1"
        LEFT JOIN obj2b_bootsocks_after v ON v.barcode_bootsocks=s.barcode_bootsock AND s.elution_no="Moisture1"
        LEFT JOIN obj2b_subbs_endetec h ON a.barcode_sample=h.barcode_sample
        LEFT JOIN obj2b_subbs_idexx j ON a.barcode_sample=j.barcode_sample
        LEFT JOIN obj2b_subbs_endetec w ON g.barcode_bootsock=w.barcode_sample
        LEFT JOIN obj2b_subbs_idexx x ON g.barcode_bootsock=x.barcode_sample
        LEFT JOIN obj2b_endetec3 i ON w.barcode_endetec=i.barcode_endetec
        LEFT JOIN obj2b_idexx2 k ON x.barcode_colilert=k.barcode_colilert
        LEFT JOIN obj2b_metagenomics l ON l.barcode_sample=g.barcode_falcon AND g.elution_no="Micro1"
        LEFT JOIN obj2b_mac1 p ON p.barcode_sample=g.barcode_falcon AND g.elution_no="Micro1"
        LEFT JOIN obj2b_mac2 q ON q.bar_macconkey=p.bar_macconkey
        LEFT JOIN ref_sampletype m ON a.id_type2b=m.id_sampletype
        LEFT JOIN ref_location_80 n ON l.id_location_80=n.id_location_80 AND n.lab = "'.$this->session->userdata('lab').'" 
        WHERE a.id_type2b = "'.$rep.'"
        AND (a.date_arrival >= "'.$date1.'"
            AND a.date_arrival <= "'.$date2.'")
        AND a.lab = "'.$this->session->userdata('lab').'" 
        AND a.flag = 0 
        ORDER BY a.date_arrival DESC, a.time_arrival ASC
        ');        
        $response = $q->result();
        return $response;
    }        

    function get_sediment($date1, $date2, $rep)
    {
        $q = $this->db->query('

        SELECT 
        a.date_arrival AS reception_date_arrival, 
        a.time_arrival AS reception_time_arrival, 
        a.barcode_sample AS barcode_sample, 
        k.sampletype AS reception_sampletype, 
        a.barcode_tinytag AS reception_barcode_tinytag, 
        a.comments AS reception_comment,
        b.date_conduct AS sedi_prep_date_conduct, 
        b.barcode_sample AS sedi_prep_barcode_sample, 
        b.barcode_tube AS sedi_prep_barcode_tube,
        b.subsample_wet AS sedi_prep_subsample_wet,
        b.elution AS sedi_prep_elution,
        c.date_moisture AS mois_initial_date_moisture,
        c.barcode_sample AS mois_initial_barcode_sample,
        c.barcode_foil AS mois_initial_barcode_foil,
        c.foil_weight AS mois_initial_foil_weight,
        c.wet_weight AS mois_initial_wet_weight,
        c.time_incubator AS mois_initial_time_incubator,
        c.comments AS mois_initial_comments,
        d.date_moisture AS mois24_date_moisture,
        d.barcode_foil AS mois24_barcode_foil,
        d.dry_weight24 AS mois24_dry_weight24,
        d.comments AS mois24_comments,
        e.date_moisture AS mois48_date_moisture,
        e.barcode_foil AS mois48_barcode_foil,
        e.dry_weight48 AS mois48_dry_weight48,
        e.difference AS mois48_difference,
        e.comments AS mois48_comments,
        f.barcode_endetec AS sedi_endet_barcode_endetec,
        f.volume_falcon AS sedi_endet_volume_falcon,
        f.dilution AS sedi_endet_dilution,
        f.time_incubation AS sedi_endet_time_incu_start,
        f.volume_falcon AS sedi_endet_volume_falcon,
        f.comments AS sedi_endet_comments,
        g.date_conduct AS endet_out_s_date_conduct,
        g.barcode_endetec AS endet_out_s_barcode_endetec,
        g.time_ecoli AS endet_out_s_time_ecoli,
        g.volume_ecoli AS endet_out_s_volume_ecoli,
        g.total_coliforms AS endet_out_s_total_coliforms,
        g.comments AS endet_out_s_comments,
        h.barcode_colilert AS sedi_idexx_barcode_colilert,
        h.volume AS sedi_idexx_volume,
        h.dilution AS sedi_idexx_dilution,
        h.time_incubation AS sedi_idexx_time_incubation,
        h.comments AS sedi_idexx_comments,
        q.barcode_colilert AS sedi_idexx_barcode_colilert2,
        q.volume AS sedi_idexx_volume2,
        q.dilution AS sedi_idexx_dilution2,
        q.time_incubation AS sedi_idexx_time_incubation2,
        q.comments AS sedi_idexx_comments2,
        i.date_conduct AS idexx_out_date_conduct,
        i.timeout_incubation AS idexx_out_timeout_incubation,
        i.time_minutes AS idexx_out_time_minutes,
        i.ecoli_largewells AS idexx_out_ecoli_largewells,
        i.ecoli_smallwells AS idexx_out_ecoli_smallwells,
        i.ecoli_mpn AS idexx_out_ecoli_mpn,
        i.coliforms_largewells AS idexx_out_coliforms_largewells,
        i.coliforms_smallwells AS idexx_out_coliforms_smallwells,
        i.coliforms_mpn AS idexx_out_coliforms_mpn,
        i.comments AS idexx_out_comments,
        r.date_conduct AS idexx_out_date_conduct2,
        r.timeout_incubation AS idexx_out_timeout_incubation2,
        r.time_minutes AS idexx_out_time_minutes2,
        r.ecoli_largewells AS idexx_out_ecoli_largewells2,
        r.ecoli_smallwells AS idexx_out_ecoli_smallwells2,
        r.ecoli_mpn AS idexx_out_ecoli_mpn2,
        r.coliforms_largewells AS idexx_out_coliforms_largewells2,
        r.coliforms_smallwells AS idexx_out_coliforms_smallwells2,
        r.coliforms_mpn AS idexx_out_coliforms_mpn2,
        r.comments AS idexx_out_comments2,
        j.date_conduct AS metagenomics_date_conduct,
        j.barcode_sample AS metagenomics_barcode_sample,
        j.barcode_dna1 AS metagenomics_barcode_dna1,
        j.weight_sub1 AS metagenomics_weight_sub1,
        j.barcode_storage1 AS metagenomics_barcode_storage1,
        j.position_tube1 AS metagenomics_position_tube1,
        CONCAT("F",l.freezer,"-","S",l.shelf,"-","R",l.rack,"-","DRW",l.rack_level) AS metagenomics_location1,
        j.barcode_dna2 AS metagenomics_barcode_dna2,
        j.weight_sub2 AS metagenomics_weight_sub2,
        j.barcode_storage2 AS metagenomics_barcode_storage2,
        j.position_tube2 AS metagenomics_position_tube2,
        CONCAT("F",m.freezer,"-","S",m.shelf,"-","R",m.rack,"-","DRW",m.rack_level) AS metagenomics_location2,
        j.comments AS metagenomics_comments,
        o.bar_macconkey AS mac1_barcode_macconkey,
        o.date_process AS mac1_date_process,
        o.time_process AS mac1_time_process,
        o.volume AS mac1_volume,
        o.comments AS mac1_comments,
        p.date_process AS mac2_date_process,
        p.time_process AS mac2_time_process,
        p.bar_macsweep1 AS mac2_bar_macsweep1,
        p.cryobox1 AS mac2_cryobox1,
        p.bar_macsweep2 AS mac2_bar_macsweep2,
        p.cryobox2 AS mac2_cryobox2,
        p.comments AS mac2_comments
        FROM obj2b_receipt a
        LEFT JOIN obj2b_sediment_prep b ON a.barcode_sample=b.barcode_sample
        LEFT JOIN obj2b_moisture1 c ON a.barcode_sample=c.barcode_sample
        LEFT JOIN obj2b_moisture2 d ON c.barcode_foil=d.barcode_foil
        LEFT JOIN obj2b_moisture3 e ON c.barcode_foil=e.barcode_foil
        LEFT JOIN obj2b_subsd_endetec f ON b.barcode_sample=f.barcode_sample
        LEFT JOIN obj2b_endetec3 g ON f.barcode_endetec=g.barcode_endetec
        LEFT JOIN obj2b_subsd_idexx h ON b.barcode_sample=h.barcode_sample
        LEFT JOIN obj2b_subsd_idexx q ON b.barcode_sample=q.barcode_sample AND h.barcode_colilert <> q.barcode_colilert
        LEFT JOIN obj2b_idexx2 i ON h.barcode_colilert=i.barcode_colilert
        LEFT JOIN obj2b_idexx2 r ON q.barcode_colilert=r.barcode_colilert
        LEFT JOIN obj2b_meta_sediment j ON a.barcode_sample=j.barcode_sample
        LEFT JOIN ref_sampletype k ON a.id_type2b=k.id_sampletype
        LEFT JOIN ref_location_80 l ON j.id_location_801=l.id_location_80 AND l.lab = "'.$this->session->userdata('lab').'" 
        LEFT JOIN ref_location_80 m ON j.id_location_802=m.id_location_80 AND m.lab = "'.$this->session->userdata('lab').'" 
        LEFT JOIN obj2b_mac1 o ON b.barcode_tube=o.barcode_sample
        LEFT JOIN obj2b_mac2 p ON p.bar_macconkey=o.bar_macconkey
        WHERE a.id_type2b = "'.$rep.'"
        AND (a.date_arrival >= "'.$date1.'"
            AND a.date_arrival <= "'.$date2.'")
        AND a.lab = "'.$this->session->userdata('lab').'" 
        AND a.flag = 0 
        ORDER BY a.date_arrival DESC, a.time_arrival ASC
        ');        
        $response = $q->result();
        return $response;
    }    


    function get_feces($date1, $date2, $rep)
    {
        $q = $this->db->query('
        SELECT 
        a.date_arrival AS reception_date_arrival, 
        a.time_arrival AS reception_time_arrival, 
        a.barcode_sample AS barcode_sample, 
        k.sampletype AS reception_sampletype, 
        a.barcode_tinytag AS reception_barcode_tinytag, 
        a.comments AS reception_comment,
        j.date_conduct AS metagenomics_date_conduct,
        j.barcode_sample AS metagenomics_barcode_sample,
        j.barcode_dna1 AS metagenomics_barcode_dna1,
        j.weight_sub1 AS metagenomics_weight_sub1,
        j.barcode_storage1 AS metagenomics_barcode_storage1,
        j.position_tube1 AS metagenomics_position_tube1,
        concat("F",l.freezer,"-","S",l.shelf,"-","R",l.rack,"-","DRW",l.rack_level) AS metagenomics_location1,
        j.barcode_dna2 AS metagenomics_barcode_dna2,
        j.weight_sub2 AS metagenomics_weight_sub2,
        j.barcode_storage2 AS metagenomics_barcode_storage2,
        j.position_tube2 AS metagenomics_position_tube2,
        concat("F",m.freezer,"-","S",m.shelf,"-","R",m.rack,"-","DRW",m.rack_level) AS metagenomics_location2,
        j.comments AS metagenomics_comments
        FROM obj2b_receipt a
        LEFT JOIN obj2b_meta_sediment j ON a.barcode_sample=j.barcode_sample
        LEFT JOIN ref_sampletype k ON a.id_type2b=k.id_sampletype
        LEFT JOIN ref_location_80 l ON j.id_location_801=l.id_location_80 AND l.lab = "'.$this->session->userdata('lab').'" 
        LEFT JOIN ref_location_80 m ON j.id_location_802=m.id_location_80 AND m.lab = "'.$this->session->userdata('lab').'" 
        WHERE a.id_type2b = "'.$rep.'"
        AND (a.date_arrival >= "'.$date1.'"
            AND a.date_arrival <= "'.$date2.'")
        AND a.lab = "'.$this->session->userdata('lab').'" 
        AND a.flag = 0 
        ORDER BY a.date_arrival DESC, a.time_arrival ASC
        ');        
        $response = $q->result();
        return $response;
    }        
    
}

/* End of file Tbl_customer_model.php */
/* Location: ./application/models/Tbl_customer_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-14 03:29:29 */
/* http://harviacode.com */