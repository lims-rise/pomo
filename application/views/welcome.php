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
        "<i class='fa fa-hand-o-left' aria-hidden='true'></i>" . ' To switch accounting data between country labs, please select countries on the left side panel.');
        
        ?>

    <div class="row">
    <div class="content" style="color: #252525;">
        <div class="col-md-12 col-sm-12">
            <div id="chart_container"></div>
            <div id="space"><br /></div>
            <div id="sub_container"></div>
        </div>
        <!-- <div class="col-md-12 col-sm-12"> -->
        <!-- <div class="box-body no-padding"> -->
        <!-- </div>         -->
    </div>
    </div>

    </section>
</div>

<script src="<?php echo base_url('assets/js/highcharts.js') ?>"></script>
<script src="<?php echo base_url('assets/js/exporting.js') ?>"></script>
<script src="<?php echo base_url('assets/js/export-data.js') ?>"></script>
<script src="<?php echo base_url('assets/js/accessibility.js') ?>"></script>

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
        <script type="text/javascript">
            let t
            $(document).ready(function() {
/*
            Highcharts.chart('chart_container', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    height: "350px"
                },
                
                title: {
                    text: 'Total samples per-objectives',
                    align: 'left'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                    valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    },
                    showInLegend: true,
                    point: {
                            events: {
                                legendItemClick: function (e) {
                                    console.log(e.target.name)
                                }
                            }
                        }
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    itemMarginTop: 10,
                    itemMarginBottom: 10,
                    itemMarginRight: 100,

                    },
                series: [{
                    name: 'Samples',
                    colorByPoint: true,
                    data: 
                    [<?php foreach ($item as $rows) {
                        echo ' {
                            name: "'.$rows->item.'",
                            y: '.$rows->val.'
                          },';
                    } ?>]
                }]
                });

            Highcharts.chart('sub_container', {
                        chart: {
                            type: 'column',
                            height: '300px'
                        },
                        title: {
                            text: 'Total samples per-type all objectives',
                            align: 'left'

                        },
                        
                        xAxis: {
                            categories: 
                            // ['sub1', 'sub2', 'sub3'],
                            [
                                <?php foreach ($obj as $row) {
                                    echo "'$row->type'" . ',';      
                                } ?>
                            ],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Sample type from all Objectives'
                            }
                        },
                        legend:{ enabled:false },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{point.key}: </td>' +
                                '<td style="padding:0"><b>{point.y}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0,
                                colorByPoint: true,
                                dataLabels: {
                                    enabled: true,
                                    crop: false,
                                    overflow: 'none'
                                }
                            },
                            colors: [
                                '#ff0000',
                                '#00ff00',
                                '#0000ff'
                            ]
                        },
                        series: [
                            {
                                data : 
                                // [{name: 'sub1', y: 100},{name: 'sub2', y: 70},{name: 'sub3', y: 30},]

                                [
                                    <?php foreach ($obj as $row) {
                                        echo "{name: '$row->type',y: $row->val},";
                                    }?>
                                ]
                            }]
                    });          */      
            });
</script>