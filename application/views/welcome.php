<style>
::-webkit-scrollbar {
  width: 10px;
  height: 10px;
}

::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-track {
  background: rgba(0, 0, 0, 0);
}
</style>


<div class="content-wrapper">
    <section class="content">
        <?php 
        $lab = $this->session->userdata('lab');
        if ($lab == 1) {
            $labname = "Indonesia";
        }
        else {
            $labname = "Fiji";
        }
        echo alert('alert-error', 'Welcome '.$this->session->userdata('full_name') . ' to the '. $labname .' Accounting data', 
        "<i class='fa fa-hand-o-left' aria-hidden='true'></i>" . ' To switch accounting data between country, please select countries on the left side panel.');
        
        $data = $this->Welcome_model->get_budged_req(); 

        $budged_request = $data['budged_request'];
        $budged_detail = $data['budged_detail'];
        $po_aprv = $data['po_aprv'];
        $po_left = $data['po_left'];
        $total_request = $data['total_request'];
        $total_approved = $data['total_approved'];
        $total_expenses = $data['total_expenses'];
        $total_remaining = $data['total_remaining'];
        ?>

    <div class="row">
    <div class="content" style="color: #252525;">
        <div class="col-md-12 col-sm-12">
        <div class="col-lg-6 col-xs-6"> 
            <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>
                            <?php echo $budged_request;?> <p>Number of Budget Request</p>
                        </h3>
                        <p>
                            Detail item request : <?php echo $budged_detail;?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-paper-airplane"></i>
                    </div>
                    <a href="budged_request" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>
                            <?php echo $po_aprv;?> <p>Number of Budget Approved</p>
                        </h3>
                        <p>
                            Need approval : <?php echo $po_left;?>
                        </p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-checkmark-circle"></i>
                    </div>
                    <a href="approved_po" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-purple">
                    <div class="inner">
                        <p>
                            Total Budget Request
                        </p>
                        <h3>
                            <?php echo $total_request?>
                        </h3>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>

            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-fuchsia">
                    <div class="inner">
                        <p>
                            Total Budget Approved
                        </p>
                        <h3>
                            <?php echo $total_approved?>
                        </h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-ribbon-b"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>

            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <p>
                            Total Budget Expenses
                        </p>
                        <h3>
                            <?php echo $total_expenses?>
                        </h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-android-cart"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>            

            <div class="col-lg-6 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <p>
                            Total Budget Remaining
                        </p>
                        <h3>
                            <?php echo $total_remaining?>
                        </h3>

                    </div>
                    <div class="icon">
                        <i class="ion ion-archive"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>           

        </div>
    </div>
    </div>

    </section>
</div>

<!-- <script src="<?php //echo base_url('assets/js/highcharts.js') ?>"></script> -->
<!-- <script src="<?php //echo base_url('assets/js/exporting.js') ?>"></script>
<script src="<?php //echo base_url('assets/js/export-data.js') ?>"></script>
<script src="<?php //echo base_url('assets/js/accessibility.js') ?>"></script> -->

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>