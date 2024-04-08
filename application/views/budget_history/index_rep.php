<style>
@media print{
    .noprint{
        display:none;
    }

    .print-bg {
            background-color: #b7d5f7 !important;
        }

    @page { margin: 2cm; }
    body { margin: 1.6cm; }
    .page-break {
        page-break-before: always;
    }    
 }

.tab1 { tab-size: 2; }

h3 {
    text-align: center;
}

</style>


<div class="content-wrapper">

<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">            
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <img src="../../../img/rise_logo_x.jpg" width="80px" class="icon" style="padding: 0px; float: left;">
                <div style="text-align: center;">            
                    <h3 class="text-center">RISE MAKASSAR - Budget History</h3>
                </div>
                <img src="../../../img/monash.png" width="160px" class="icon" style="padding: 0px; float: right;">
            </div>

            <div class="noprint">
                <div class="modal-footer clearfix">
                    <button id='print' class="btn btn-primary no-print" onclick="document.title = '<?php echo 'Print_Budget_History_PO_'.$po_number . '_' . date('Ymd')?>'; window.print();"><i class="fa fa-print"></i> Print</button>
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
<?php

$q2 = $this->db->query('SELECT b.po_number, b.date_expenses, b.id_exp, b.items, b.qty, e.unit, 
FORMAT(b.expenses, 0, "de_DE") AS expenses,
FORMAT((b.expenses * b.qty), 0, "de_DE") AS total,
FORMAT(h.sum_exp, 0, "de_DE") AS sum_exp, b.remarks
FROM budget_expenses_detail b
LEFT JOIN ref_unit e ON b.id_unit=e.id_unit
LEFT JOIN v_budexp_sum h ON b.po_number = h.po_number
WHERE b.po_number="'.$po_number.'"
ORDER BY b.id_exp');        

$response2 = $q2->result();

?>
<?php

$q3 = $this->db->query('SELECT c.po_number, a.id_reqrem, a.items, a.qty, b.unit, 
FORMAT(a.estimate_price, 0, "de_DE") AS estimate_price, 
FORMAT(a.qty*a.estimate_price, 0, "de_DE") AS total, 
FORMAT(d.sum_tot, 0, "de_DE") AS sum_total, a.comments 
FROM budget_req_rem_det a
LEFT JOIN ref_unit b ON a.id_unit=b.id_unit 
LEFT JOIN budget_req_remaining c ON a.id_reqrem=c.id_reqrem
LEFT JOIN (SELECT id_reqrem, SUM(a.qty*a.estimate_price) AS sum_tot
FROM budget_req_rem_det a
GROUP BY id_reqrem) d ON a.id_reqrem=d.id_reqrem
WHERE a.flag = 0
AND c.po_number="'.$po_number.'"
ORDER BY a.id_reqrem_det');        

$response3 = $q3->result();

?>
<?php

$q4 = $this->db->query('SELECT a.po_number, b.date_expenses, b.id_exprem, b.items, b.qty, e.unit, 
FORMAT(b.expenses, 0, "de_DE") AS expenses, 
FORMAT((b.expenses * b.qty), 0, "de_DE") AS total_expenses, 
FORMAT(h.sum_exp, 0, "de_DE") AS sum_exp, b.remarks
FROM v_reqrem_sum a
LEFT JOIN budget_exp_rem_detail b ON a.po_number=b.po_number
LEFT JOIN ref_unit e ON b.id_unit=e.id_unit
LEFT JOIN v_budexprem_sum h ON a.po_number=h.po_number
WHERE a.po_number="'.$po_number.'"
ORDER BY b.id_exprem');        

$response4 = $q4->result();

?>


<div class="box">
<input type='hidden' id='id_req' value='<?php echo $id_req; ?>'>


<table id="tabletop" width=100%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
<tr>
    </br>
    <table id="mytablex2" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
        <thead>
        <tr>
            <td>    
            <div style="text-align: left;">            
                <h5 class="text-left">Date request : <?php echo $date_req; ?></h5>
                <h5 class="text-left">Objective : <?php echo $objective; ?></h5>
                <h5 class="text-left">Title : <?php echo $title; ?></h5>
                <h5 class="text-left">Period : <?php echo $periode; ?></h5>
                <h5 class="text-left">PO Number : <?php echo $po_number; ?></h5>
                <hr>
                <h5 class="text-left"><b>List of items planning : </b></h5>
            </div>
            </td>    
        </tr>    
    </thead>
    </table>
    <table id="mytable2" width=95%; style="border:1px solid black; margin-left:auto;margin-right:auto;">
    <!-- <thead> -->
            <tr>
                <td width=5%; class="print-bg" style="border:1px solid black; padding: 5px;" align="center"><b>No.</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Description</b></td>
                <td width=5%; class="print-bg" style="border:1px solid black;" align="center"><b>Qty</b></td>
                <td width=10%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit Estimate IDR</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Total Estimate IDR</b></td>
                <td width=25%; class="print-bg" style="border:0px solid black;" align="center"><b>Remarks</b></td>
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
                <td style="border:0px solid black;" align="center"></td>
            </tr>
            
        </thead>
        <!-- <thead> -->
    </table>
    </tr>
    <tr>
    <!-- </br> -->
    <table id="mytable3" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
        <thead>
            </br>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left"><b>Approve PO by Email : <?php echo $photo; ?>
                </b></td>
            </tr>

            <tr>
                <td width=80px; style="border:1px solid black; padding: 5px; " align="left">
                <?php if($photo) {
                    echo '<img src="../../../assets/receipt/'.$photo.'" width="70%" class="img-thumbnail" alt="No Image Approval" style="padding: 0px; float: left;">';
                }             
                ?>

                <!-- <img src="../../../assets/receipt/<?php //echo $photo; ?>" width="70%" class="icon" style="padding: 0px; float: left;">                     -->
                </td>
            </tr>
            <tr><td></br></td></tr>
        </thead>
    </table>
    <table id="mytable4" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;" class="page-break">
        <thead>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left" colspan="7"><b>Budget Expenses : </b></td>
            </tr>
            <tr>
                <td width=11%; class="print-bg" style="border:1px solid black; padding: 5px;" align="center"><b>Date Expenses</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Description</b></td>
                <td width=5%; class="print-bg" style="border:1px solid black;" align="center"><b>Qty</b></td>
                <td width=10%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Actual Price IDR</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Total Actual Price IDR</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Remarks</b></td>
            </tr>

            <?php $i=1;
             foreach ($response2 as $row2):?>
            <tr>
                <td style="border:1px solid black;" align="center"><?php echo $row2->date_expenses; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row2->items; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row2->qty; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row2->unit; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row2->expenses; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row2->total; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row2->remarks; ?></td>
            </tr>
            <?php $i++; endforeach; ?>
            <tr>
                <?php
                    $sum_exp_total = isset($response2[0]->sum_exp) ? $response2[0]->sum_exp : 0;
                ?>                
                <td style="border:1px solid black;" align="center" colspan="2"><b>Grand Total</b></td>
                <td style="border:1px solid black; padding: 5px;" align="right" colspan="4"><b><?php echo $sum_exp_total; ?></b></td>
                <td style="border:1px solid black;" align="center"></td>
                <!-- <td style="border:0px solid black;" align="center"></td> -->
            </tr>
            <tr><td></br></td></tr>
            
        </thead>
        <thead>
    </table>    

    <table id="mytable5" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
        <thead>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left" colspan="7"><b>Budget Remaining Request : </b></td>
            </tr>
            <tr>
                <td width=5%; class="print-bg" style="border:1px solid black; padding: 5px;" align="center"><b>No.</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Description</b></td>
                <td width=5%; class="print-bg" style="border:1px solid black;" align="center"><b>Qty</b></td>
                <td width=10%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit Estimate IDR</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Total Estimate IDR</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Remarks</b></td>
            </tr>

            <?php $i=1;
             foreach ($response3 as $row3):?>
            <tr>
                <td style="border:1px solid black;" align="center"><?php echo $i; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row3->items; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row3->qty; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row3->unit; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row3->estimate_price; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row3->total; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row3->comments; ?></td>
            </tr>
            <?php $i++; endforeach; ?>
            <tr>
                <?php
                    $sum_total_total = isset($response3[0]->sum_total) ? $response3[0]->sum_total : 0;
                ?>                
                <td style="border:1px solid black;" align="center" colspan="2"><b>Grand Total</b></td>
                <td style="border:1px solid black; padding: 5px;" align="right" colspan="4"><b><?php echo $sum_total_total; ?></b></td>
                <td style="border:1px solid black;" align="center"></td>
                <!-- <td style="border:0px solid black;" align="center"></td> -->
            </tr>
            <tr><td></br></td></tr>
            
        </thead>
        <thead>
    </table>        

    <table id="mytable6" width=95%; style="border:0px solid black; margin-left:auto;margin-right:auto;">
        <thead>
            <tr>
                <td width=100px; style="border:0px solid black; padding: 5px; " align="left" colspan="7"><b>Budget Remaining Expenses : </b></td>
            </tr>
            <tr>
                <td width=11%; class="print-bg" style="border:1px solid black; padding: 5px;" align="center"><b>Date Expenses</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Description</b></td>
                <td width=5%; class="print-bg" style="border:1px solid black;" align="center"><b>Qty</b></td>
                <td width=10%; class="print-bg" style="border:1px solid black;" align="center"><b>Unit</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Actual Price IDR</b></td>
                <td width=15%; class="print-bg" style="border:1px solid black;" align="center"><b>Total Actual Price IDR</b></td>
                <td width=25%; class="print-bg" style="border:1px solid black;" align="center"><b>Remarks</b></td>
            </tr>

            <?php $i=1;
             foreach ($response4 as $row4):?>
            <tr>
                <td style="border:1px solid black;" align="center"><?php echo $row4->date_expenses; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row4->items; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row4->qty; ?></td>
                <td style="border:1px solid black;" align="center"><?php echo $row4->unit; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row4->expenses; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="right"><?php echo $row4->total_expenses; ?></td>
                <td style="border:1px solid black; padding: 5px;" align="left"><?php echo $row4->remarks; ?></td>
            </tr>
            <?php $i++; endforeach; ?>
            <tr>
                <?php
                    $sum_exp_total = isset($response4[0]->sum_exp) ? $response4[0]->sum_exp : 0;
                ?>                
                <td style="border:1px solid black;" align="center" colspan="2"><b>Grand Total</b></td>
                <td style="border:1px solid black; padding: 5px;" align="right" colspan="4"><b><?php echo $sum_exp_total; ?></b></td>
                <td style="border:1px solid black;" align="center"></td>
                <!-- <td style="border:0px solid black;" align="center"></td> -->
            </tr>
            <tr><td></br></td></tr>
            
        </thead>
        <thead>
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