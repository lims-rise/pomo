<style>
@media print{
    .noprint{
        display:none;
    }

    .print-bg {
            background-color: #b7d5f7 !important;
        }

    @page { margin: 0; }
    body { margin: 1.6cm; }
 }

.tab1 { tab-size: 2; }

h3 {
    text-align: center;
}

</style>


<div class="content-wrapper">

<section class="content">
<?php
    if(!empty($this->session->userdata('lab'))) {
        if ($this->session->userdata('lab')==1) {
            $country = 'ID';
            $office = 'RISE MAKASSAR';
        }
        else {
            $country = 'FJ';
            $office = 'RISE SUVA';
        }
    }                            
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">            
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <img src="../../../img/rise_logo_x.jpg" width="80px" class="icon" style="padding: 0px; float: left;">
                <div style="text-align: center;">            
                    <h3 class="text-center"><?php echo $office; ?> - BUDGET REQUEST</h3>
                    <h4 class="text-center"><?php echo $objective; ?></h2>
                    <h4 class="text-center">Title : <?php echo $title; ?></h2>
                    <h4 class="text-center">Period : <?php echo $periode; ?></h4>
                </div>
                <img src="../../../img/monash.png" width="160px" class="icon" style="padding: 0px; float: right;">
            </div>
            <div class="noprint">
                <div class="modal-footer clearfix">
                    <button id='print' class="btn btn-primary no-print" onclick="document.title = '<?php echo $country .'_'. date('Ymd') . '_BR_' . $title ?>'; window.print();"><i class="fa fa-print"></i> Print</button>
                    <button id='close' class="btn btn-warning" onclick="javascript:history.go(-1);"><i class="fa fa-times"></i> Close</button> 
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php

$q = $this->db->query('SELECT a.items, a.qty, b.unit, 
FORMAT(a.estimate_price, 0, "de_DE") AS estimate_price, 
FORMAT(a.qty * a.estimate_price, 0, "de_DE") AS total, a.remarks 
FROM budget_request_detail a
LEFT JOIN ref_unit b ON a.id_unit=b.id_unit   
WHERE a.flag = 0
AND a.id_req="'.$id_req.'"
ORDER BY a.id_reqdetail');        

$response = $q->result();

?>


<div class="box">
<input type='hidden' id='id_req' value='<?php echo $id_req; ?>'>

<table id="tabletop" width=100%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
    <tr>
    <table id="mytable2" width=95%; style="border:1px solid black; margin-left:auto;margin-right:auto;">
        <thead>
            <tr>
                <td width=5%; class="print-bg" style="border:1px solid black; padding: 5px;" align="center"><b>No.</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Description</b></td>
                <td width=5%; class="print-bg" style="border:1px solid black;" align="center"><b>Qty</b></td>
                <td width=10%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit Price IDR</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Total Price IDR</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Remarks</b></td>
            </tr>

            <?php $i=1;
             foreach ($response as $row):?>
            <tr>
                <td style="border:1px solid black;" align="center"><?php echo $i; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row->items; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row->qty; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row->unit; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row->estimate_price; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row->total; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row->remarks; ?></td>
            </tr>
            <?php $i++; endforeach; ?>
            <tr>
                <td style="border:1px solid black;" align="center" colspan="2"><b>Grand Total</b></td>
                <td style="border:1px solid black; padding: 5px;" align="right" colspan="4"><b><?php echo $budget_req; ?></b></td>
                <td style="border:1px solid black;" align="center"></td>
                <td style="border:1px solid black;" align="center"></td>
            </tr>
            
        </thead>
        </br>
        </br>
        <thead>
    </table>
    </tr>
    <tr>
    <!-- </br> -->
    <table id="mytable3" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
        <thead>
            </br>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left"><b>Makassar, <?php echo $date_req; ?></b></td>
                <td style="border:0px" align="center"></td>
                <td style="border:0px" align="center"></td>
            </tr>
            <tr>
                <td width=100px; style="border:0px solid black;padding: 5px; " align="left"><b>Prepared,</b></td>
                <td width=100px; style="border:0px solid black;" align="center"><b>Reviewed,</b></td>
                <td width=100px; style="border:0px solid black;" align="center"><b>Approved,</b></td>
            </tr>
            <tr>
                <td style="border:0px" align="center"></br></td>
                <td style="border:0px" align="center"></td>
                <td style="border:0px" align="center"></td>
            </tr>
            <tr>
                <td style="border:0px" align="center"></br></td>
                <td style="border:0px" align="center"></td>
                <td style="border:0px" align="center"></td>
            </tr>
            <tr>
                <td style="border:0px" align="center"></br></td>
                <td style="border:0px" align="center"></td>
                <td style="border:0px" align="center"></td>
            </tr>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left"><?php echo $realname; ?></td>
                <td style="border:0px" align="center"><?php echo $reviewed; ?></td>
                <td style="border:0px" align="center"><?php echo $approved; ?></td>
            </tr>
        </thead>
    </table>
    </tr>
<!-- 
    <tfoot>
        <tr>
        <td>Copyright © 2022-2023 LIMS-RISE | RISE Data Team. All rights reserved.</td>
        </tr>
    </tfoot> -->
</table>
</div>
</section>    
</div>