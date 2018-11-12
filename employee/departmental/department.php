<?php
session_start();

if(!isset($_SESSION['employee']))
{
    header("Location: ../index.php");
}
require_once '../../admin/master_engine/database_io.php';

$dbIO = new DatabaseIO();

$items =  $dbIO->get_entries_with_id(TBL_ITEMS , "Name");
$serials = $dbIO->get_entries_with_id(TBL_ITEMS , "Serial");
$prices = $dbIO->get_entries_with_id(TBL_ITEMS , "Price");

$dbIO = new DatabaseIO();
$departments = $dbIO->get_entries_with_id(TBL_DEPARTMENT , "Name");


$dbIO = new DatabaseIO();
$vat =  $dbIO->get_entry(TBL_VAT , "VAT" , "1" ,"1");

$dbIO = new DatabaseIO();

$last = $dbIO->get_last_id(TBL_DEPT_BILLS);
$last++;
$z = "";
$zeroes = 6 - strlen($last);
for($i = 0 ; $i < $zeroes ; $i++)
{
    $z .= "0";
}

$last = $z.$last;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Welcome Username</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="../../img/favicon.png">
    <link href="../../css/font-awesome.css" rel="stylesheet">
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="../main.css" rel="stylesheet">
    <link rel="stylesheet" media="print" href="../print.css">
</head>
<body>

<?php include_once("header.php"); ?>

<div class="sidebar dontprint">

    <div class="sidebar-container">

        <ul>
            <a href="../index.php">
                <li class="active"><span class="fa fa-dollar"></span> Departmental Billing</li>
            </a>
            <a href="pay_bills.php">
                <li class="btn-primary"><span class="fa fa-money"></span> Generate Receipt</li>
            </a>
        </ul>

        <div class="col-lg-12 dontprint" style="padding-top: 20px">
            <input type="hidden" value="<?php echo $last;?>" class="form-control" disabled><br>
            <label>Department</label>
            <select name="department" id="department" class="form-control">
                <?php

                foreach($departments as $k => $n)
                {
                    echo "<option value='$k'>";
                    echo    $n;
                    echo "</option>";
                }

                ?>
            </select><br>
            <label>Item Serial</label>
            <input type="number" class="form-control" id="item_id"><br>
            <label>Quantity</label>
            <input type="number" min="1" value="1"  id="prod_qnty" class="form-control"><br>
            <input type="button" class="btn btn-success" id="add_btn" value="Add Item">
        </div>

    </div>

</div>

<div class="content">

    <div class="container-fluid" style="padding-top: 50px">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading dontprint"><span class="fa fa-spoon"></span> Current Order</div>
                    <div class="panel-body">

                        <div class="col-lg-12"  style="padding-bottom: 10px;border-bottom: thin #f3f2f4 solid">

                            <h6 class="show_print">TIN NO. : 01832121747</h6>
                            <img src="../../img/logo_print.png" style="width: 80px;padding: 10px 0px 10px 0px" class="show_print center-block">

                            <h6 class="show_print"><div style="width: 50%;display: inline-block;"><?php echo date('D')." , ".date('d M, Y');  ?></div>
                                <div style="width: 50%;display: inline;text-align: right !important;" class="tbl_no_prnt"></div> </h6>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr style="font-weight: bold !important;">
                                        <td>Item</td>
                                        <td>Qnty</td>
                                        <td>Price</td>
                                        <td>Total</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td id="gdtxt" colspan="3" style="text-align: right;"><b>GRAND TOTAL</b></td>
                                        <td style="font-weight: bold;font-size: 12px !important;" id="grand_ttl"></td>
                                        <td></td>
                                    </tr>

                                    </tfoot>
                                </table>

                            </div>

                            <h4 style="text-align: center;margin: 0 0 6px 0 !important;padding-bottom: 10px;border-bottom: thin #000 solid" class="show_print">Thank you for your visit !</h4>

                            <h6 style="text-align: center;margin: 0 !important;padding-bottom: 10px;border-bottom: thin #000 solid" class="show_print">Don't throw the bill before payment.</h6>

                            <h6 class="show_print" style="text-align: center;color: #848484 !important;">Powered By : Elance Technologies</h6>



                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>





</div>




<!-- script references -->
<script src="../../js/jquery.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>

<script>

    var item_name = <?php $count = 1; print "[";foreach($items as  $n){ if($count==1){ print "'$n'";++$count;}else{echo ",'$n'";}}print "];"; ?>
    var serials = <?php $count = 1; print "[";foreach($serials as $n){ if($count==1){ print "'$n'";++$count;}else{echo ",'$n'";}}print "];"; ?>
    var price = <?php $count = 1; print "[";foreach($prices as $n){ if($count==1){ print "'$n'";++$count;}else{echo ",'$n'";}}print "];"; ?>;

    var price_p,id,prod,index,getid,check,detect_item,val,gdttl=0;
    var prods_arr = [];
    var prods_qnty = [];
    var prods_total = [];
    check = 0;

    $(document).ready(function(){

        $("#department").focus();

        $("#add_btn").on('keydown', function(e) {
            var keyCode = e.keyCode || e.which;

            if (keyCode == 9) {
                e.preventDefault();
                $("#department").focus();
            }
        });



        $("tbody").on('click','.delbtn',function(){
            $(this).closest('tr').remove();

            gdttl=0;
            $('.ttl').each(function(){
                gdttl=gdttl+parseInt($(this).text());
            });

            $("#grand_ttl").text(gdttl);

            if($('table tr').length < 4){
                $("table").fadeOut(500);
            }

        });


        $("#add_btn").click(function(){

            if($("#item_id").val()=="" || $("#prod_qnty").val()==""){
                alert("No fields can be left empty");
            }
            else{


                getid = $("#item_id").val();

                if($.inArray(getid,serials) !== -1)
                {

                    id=$("#item_id").val();
                    index=serials.indexOf(id);
                    prod=item_name[serials.indexOf(id)];
                    price_p=price[serials.indexOf(id)];

                    $("tbody td").each(function(){
                        if($(this).text()==prod){
                            console.log($(this).text());
                            detect_item=$(this);
                            check = 1;
                        }
                    });

                    if(check==1){
                        detect_item.next().children('input').val(parseInt(detect_item.next().children('input').val())+parseInt($("#prod_qnty").val()));
                        detect_item.next().next().next().html(price_p*detect_item.next().children('input').val());
                        check=0;
                    }
                    else{
                        $('table tbody').append("<tr><td>"+prod+"</td><td><input class='form-control added_qnty' type='number' value='"+$("#prod_qnty").val()+"'></td><td>"+price_p+"</td><td class='ttl'>"+($("#prod_qnty").val()*price_p)+"</td><td><input style='border-radius: 30px' type='button' class='delbtn btn btn-danger btn-sm' value='x'> </td></tr>");

                    }

                    gdttl=0;
                    $('.ttl').each(function(){
                        gdttl=gdttl+parseInt($(this).text());
                    });

                    $("#grand_ttl").text(gdttl);

                    $("#item_id").val("");
                    $("#prod_qnty").val(1);

                    $("table").fadeIn(500);
                }
                else{
                    alert("Item ID doesn't exist");
                }

            }


        });



        $("table tbody").on('change keyup','.added_qnty',function(){

            gdttl=0;

            var ch_val = (parseInt($(this).parent().next('td').text())*$(this).val());

            $(this).parent().next().next().html(ch_val);


            $('.ttl').each(function(){
                gdttl=gdttl+parseInt($(this).text());
            });

            $("#grand_ttl").text(gdttl);

        });



        $(document).bind("keydown", function(e){
            if(e.ctrlKey && e.keyCode == 80) {
                e.preventDefault();

                var count = $("tbody tr").length;
                var i = j = k = 0;

                $('tr td:first-child').not(':first').each(function () {
                    if (i < count) {
                        prods_arr[i] = $(this).text();
                        i++;
                    }
                });

                $('tr').not(':first').each(function () {
                    if (j < count) {
                        prods_qnty[j] = $(this).find('.added_qnty').val();
                        j++;
                    }
                });

                $('tr').not(':first').each(function () {
                    if (k < count) {
                        prods_total[k] = $(this).find('.ttl').text();
                        k++;
                    }
                });


                var total = Number($("#grand_ttl").text());
                var deptID = $("#department").val();
                var deptName = $("#department").find(":selected").text();
                var vat = Number(<?php echo $vat;?>);


                if(prods_arr.length > 0 && deptName != "" && total != "") {


                    $.ajax(
                        {
                            type: "POST",
                            url: "billing.php",
                            data: {
                                items: prods_arr,
                                quantities: prods_qnty,
                                total: total,
                                deptID: deptID,
                                deptName: deptName
                            },
                            success: function (result) {
                                if (result == "SUCCESS") {
                                    alert("Billing Saved Successfully");
                                }
                                else {
                                    alert(result);
                                }

                                window.location = "department.php";
                            }
                        }
                    );
                }
                else
                {
                    alert("Fields Cannot be Left Empty");
                }
            }
        });

    });

</script>

</body>
</html>