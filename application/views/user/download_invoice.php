<link href="http://54.187.223.58/carrier_lookup/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
      type="text/css"/>
<style type="text/css">

    .wrapper {
        margin: 0 auto;
        width: 1000px;
    }

    #container {
        position: relative;
        width: 100%;
        float: left;
        background: #fff;
        font-size: 120%;
        font-weight: bold;
    }

    .conatiner_wrapper, .conatiner_wrapper_2 {
        position: relative;
        width: 100%;
        float: left;
    }

    .conatiner_wrapper {
        margin: 30px 0;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, .5);
    }

    .conatiner_wrapper_2 {
        margin-bottom: 50px;
    }

    .f2, b {
        font-size: 140%;
    }

    .table th {
        font-size: 120%;
        font-weight: bold;
    }

    .table td {
        font-size: 100%;
        font-weight: bold;
    }

    .row-even {
        background: #F8F7F7;
    }

    .row-odd {
        background: #eee;
    }
</style>
<?php
/*
echo '
<div class="container" id="conatiner">
<div class="row">

                                                                                        <div class="col-xs-12" style="padding-top:50px;">
                                                                                            <img class="" style="position:absolute;float:right;right:0;top:0;width:150px;height:auto" src="'.base_url().'assets/user/images/paid_tag.png">
                                                                                             <div class="col-xs-6">
                                                                                                <img class="" style="width:150px;" src="'.base_url().'assets/user/images/logo_big.png">
                                                                                             </div> 
                                                                                             <div class="col-xs-6 text-right" style="padding-right:60px;">
                                                                                                <b>'.$invoice['invoice_from'].'</b><br>
                                                                                                '.nl2br($invoice['invoice_from_address']).'
                                                                                             </div> 

                                                                                        </div>
                                                                                    </div>
                                                                                    </div>

                                                                                    <a class="downalod_as_image" href="" data-container="#container">pdf</a>
                                                                                    <img id="download_preview_image" src="">
';
*/
?>
<span id="widget" class="widget" field="AGE" roundby="20" description="Patient age, in years">
    
    <?php

    $date = "";
    $type = "";
    $date_array = array();
    if ($invoice['datetime'] != "") {
        $date_array = explode(" ", $invoice['datetime']);
        $date = date('F j, Y, g:i a', $date_array[1]);
    }
    $card = $invoice['card'];
    $card = substr($card, 12);
    $card = "**** **** **** " . $card;

    echo '
<div class="wrapper" >
<div class="conatiner_wrapper_2" id="" >
<div class="conatiner_wrapper" id="" >
<div class="" id="container" >

                                                                                        <div class="col-xs-12" style="padding:0 30px;">
                                                                                        <img class="" style="position:absolute;float:right;right:0;top:0;width:150px;height:auto" src="' . base_url() . 'assets/user/images/paid_tag.png">
                                                                                                 
                                                                                            <div class="col-xs-12" style="padding-top:100px;">
                                                                                                <div class="col-xs-6">
                                                                                                    <img class="" style="width:200px;margin-top:20px;" src="' . base_url() . 'assets/user/images/verify_rocket_logo_small.png">
                                                                                                 </div> 
                                                                                                 <div class="col-xs-6 text-right" style="padding-right:60px;">
                                                                                                    <b>' . $invoice['invoice_from'] . '</b><br>
                                                                                                    ' . nl2br($invoice['invoice_from_address']) . '
                                                                                                 </div> 

                                                                                            </div>
                                                                                            <div class="col-xs-12" style="margin:40px 0 30px 0;background:#eee;padding:15px;">
                                                                                                Invoice ID : #' . $invoice['invoice_id'] . '<br>
                                                                                                Invoice Date : ' . $date . '
                                                                                            </div>
                                                                                            <div class="col-xs-12" style="margin:40px 0 30px 0;">
                                                                                                Invoiced To :
                                                                                                <br>
                                                                                                Name : ' . $invoice['name'] . '
                                                                                                <br>
                                                                                                Contact : ' . $invoice['contact'] . '
                                                                                                <br>
                                                                                                ' . nl2br($invoice['address']) . '
                                                                                            </div>
                                                                                            <table class="table" style="margin:50px 0 50px 0;"">
                                                                                                <tr class="row-odd">
                                                                                                    <th>Description</th>
                                                                                                    <th>Card</th>
                                                                                                    <th>Validity</th>
                                                                                                    <th>Credit</th>
                                                                                                    <th>Total</th>
                                                                                                </tr>
                                                                                                <tr  class="row-even">
                                                                                                    <td>' . $invoice['description'] . '</td>
                                                                                                    <td>' . $card . '</td>
                                                                                                    <td>' . $invoice['validity'] . '</td>
                                                                                                    <td>' . $invoice['credit'] . '</td>
                                                                                                    <th>' . $invoice['price'] . ' USD</td>
                                                                                                </tr>
                                                                                                <tr  class="row-odd">
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <td></td>
                                                                                                    <th>Total</th>
                                                                                                    <th>' . $invoice['price'] . ' USD</th>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>


                                                                                    </div>
                                                                                    <input class="btn btn-success pull-right" style="margin:30px 30px 30px 0;border-radius:0 !important;" type="button" id="btnSave" value="Download as PDF"/>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>

';

    ?>

    <!-- ngRepeat: field in getChildren(field) -->
</span>
<br/>


<img id="img-out" src=""></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/user/js/jspdf.min.js"></script>

<script type="text/javascript"
        src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>


<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/base64.js"></script>


<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>


<script type='text/javascript'>
    $(window).load(function () {

        function makePdf() {
            html2canvas($("#container"), {
                useCORS: true,
                allowTaint: true,

                onrendered: function (canvas) {
                    theCanvas = canvas;

                    img_link = canvas.toDataURL("image/jpeg", 1.0);

                    // Convert and download as image
                    //Canvas2Image.saveAsPNG(canvas);
                    //$("#img-out").attr('src',img_link);
                    // Clean up
                    //document.body.removeChild(canvas);

                    width = $("#container").outerWidth();
                    height = $("#container").outerHeight();
                    pdf_height = (210 * height) / width;
                    console.log(width);
                    console.log(height);
                    var sometext = "horses r awesome";
                    var doc = new jsPDF();
                    doc.addImage(img_link, 'jpeg', 0, 0, 210, pdf_height);
                    doc.save('<?php echo 'Email_cleanup_invoice_'.$invoice['invoice_id']; ?>.pdf');
                }
            });
        }

        makePdf();


        $(function () {
            $("#btnSave").click(function () {
                makePdf();
            });
        });

    });
    /*

     */

</script>