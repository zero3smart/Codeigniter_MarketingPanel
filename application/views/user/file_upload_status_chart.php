<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
      rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components"
      type="text/css"/>

<link href="<?php echo base_url(); ?>assets/global/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <p>&nbsp;</p>
            <h4 class="text-center">Demograph of <span style="color:#27a4b0"
                                                       id="chart_file_name"><?php echo $file_status_value_value['file_name']; ?></span>
            </h4>

            <p>&nbsp;</p>
        </div>
        <div class="col-xs-12" id="file_upload_status_all_chart" style="padding:0;">
            <div class="col-xs-12">

                <div id="contact_chart_container" class="col-xs-12" style="min-height:400px;">

                </div>
            </div>

            <div class="col-xs-12 col-md-6">

                <div id="carrier_chart_container" class="col-xs-12" style="min-height:400px;">

                </div>
            </div>

            <div class="col-xs-12 col-md-6">

                <div id="carrier_type_chart_container" class="col-xs-12" style="min-height:400px;">

                </div>
            </div>
            <div class="col-xs-12 col-md-6">

                <div id="state_chart_container" class="col-xs-12" style="min-height:400px;">

                </div>
            </div>
            <div class="col-xs-12 col-md-6">

                <div id="city_chart_container" class="col-xs-12" style="min-height:400px;">

                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="col-xs-6 col-md-3 nopadding">
                <div class="btn  purple col-xs-12">Total Contacts : <span
                        id="chart_total"><?php echo $file_status_value_value['total_contacts']; ?></span></div>
            </div>
            <div class="col-xs-6 col-md-3 nopadding">
                <div class="btn  blue col-xs-12">Successful : <span
                        id="chart_successful"><?php echo $file_status_value_value['total_successful']; ?></span></div>
            </div>
            <div class="col-xs-6 col-md-3 nopadding">
                <div class="btn  dark col-xs-12">Failed : <span
                        id="chart_failed"><?php echo $file_status_value_value['total_failed']; ?></span></div>
            </div>
            <div class="col-xs-6 col-md-3 nopadding">
                <div class="btn  green col-xs-12">Invalid : <span
                        id="chart_invalid"><?php echo $file_status_value_value['total_invalid']; ?></span></div>
            </div>

        </div>


    </div>
</div>
<?php
$carrier_json = json_encode($file_status_value_value['carrier']);
$carrier_json = str_replace('"name":', 'name:', $carrier_json);
$carrier_json = str_replace('"value":', 'y:', $carrier_json);

$carrier_type_json = json_encode($file_status_value_value['carrier_type']);
$carrier_type_json = str_replace('"name":', 'name:', $carrier_type_json);
$carrier_type_json = str_replace('"value":', 'y:', $carrier_type_json);

$state_json = json_encode($file_status_value_value['state']);
$state_json = str_replace('"name":', 'name:', $state_json);
$state_json = str_replace('"value":', 'y:', $state_json);


$city_json = json_encode($file_status_value_value['city']);
$city_json = str_replace('"name":', 'name:', $city_json);
$city_json = str_replace('"value":', 'y:', $city_json);


$country_json = json_encode($file_status_value_value['country']);
$country_json = str_replace('"name":', 'name:', $country_json);
$country_json = str_replace('"value":', 'y:', $country_json);


echo '
                                                        <script>
                                                          var carrier_json = [];
                                                          var  carrier_json_' . $file_status_value_value['_id'] . ' = ' . $carrier_json . ';
                                                          var  carrier_type_json_' . $file_status_value_value['_id'] . ' = ' . $carrier_type_json . ';
                                                          var  state_json_' . $file_status_value_value['_id'] . ' = ' . $state_json . ';
                                                          var  city_json_' . $file_status_value_value['_id'] . ' = ' . $city_json . ';
                                                          var  country_json_' . $file_status_value_value['_id'] . ' = ' . $country_json . ';
                                                        </script>
                                                        ';
?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js"
        type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pages/scripts/highchart/highchart.js"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/highchart/exporting.js"></script>


<script type="text/javascript">
$(function () {
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {
                cx: 0.5,
                cy: 0.3,
                r: 0.7
            },
            stops: [
                [0, color],
                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
            ]
        };
    });
});

$('#contact_chart_container').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Contacts Validation Chart'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Brands',
        data: [
            {
                name: 'Successful',
                y: <?php echo $file_status_value_value['total_successful'];?>
            },
            {
                name: 'Failed',
                y: <?php echo $file_status_value_value['total_failed'];?>
            },
            {
                name: 'Invalid',
                y: <?php echo $file_status_value_value['total_invalid'];?>
            }
        ]


    }]
});


$('#carrier_chart_container').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Carrier Chart'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Brands',
        data: <?php echo $carrier_json;?>


    }]
});


$('#carrier_type_chart_container').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Carrier Type Chart'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Brands',
        data: <?php echo $carrier_type_json;?>


    }]
});


$('#state_chart_container').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'State Chart'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Brands',
        data: <?php echo $state_json;?>


    }]
});


$('#city_chart_container').highcharts({
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'City Chart'
    },
    tooltip: {
        pointFormat: '<b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                },
                connectorColor: 'silver'
            }
        }
    },
    series: [{
        name: 'Brands',
        data: <?php echo $city_json;?>


    }]
});


</script>

