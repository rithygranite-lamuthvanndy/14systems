<?php
$menu_active = 13;
$left_active = 63;
$layout_title = "Edit Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
include_once '../layout/header.php';
?>


<?php
if (@$_GET['edit_id']) {
    $id = @$_GET['edit_id'];
    $sql = $connect->query("SELECT * FROM tbl_op_acc_history_purchase_list 
            WHERE id=$id
            ");
    $row_old = mysqli_fetch_object($sql);
}


if (isset($_POST['btn_submit'])) {

    $v_id = @$_POST['txt_id'];
    $txt_item_name_kh = @$_POST['txt_item_name_kh'];
    $txt_item_name_vn = @$_POST['txt_item_name_vn'];
    $txt_date = @$_POST['txt_date'];
    $txt_qty = @$_POST['txt_qty'];
    $txt_price = @$_POST['txt_price'];
    $v_unit = @$_POST['cbo_unit'];
    $txt_amount = @$_POST['txt_amount'];


    $query_update = "UPDATE `tbl_op_acc_history_purchase_list` 
            SET 
                pro_name_kh='$txt_item_name_kh',
                pro_name_vn='$txt_item_name_vn',
                buy_date='$txt_date',
                qty='$txt_qty',
                price='$txt_price',
                unit_id='$v_unit',
                amount='$txt_amount'
            WHERE `id`='$v_id'"; 
    if ($connect->query($query_update)) {
        $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>';
    }
    else {
        $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';
    }

    

    
}


// // get old data 
//     $edit_id = @$_GET['edit_id'];
//     $old_data = $connect->query("SELECT * FROM tbl_acc_request_form WHERE req_id='$edit_id'");
//     $row_old_data = mysqli_fetch_object($old_data);


?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red">
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <form action="#" method="post" accept-charset="utf-8">
        <input type="hidden" name="txt_id" value="<?php echo $_GET['edit_id']; ?>">
        <br>
        <div class="portlet-body">
            <div class="bs-example" data-example-id="bordered-table">
                <table id="myTable" class="table table-bordered myFormDetail_ns">
                    <thead>
                        <tr>
                            <th>
                                <label>Item Name KH
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Item Name VN
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th>
                                <label>Date
                                  
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                           
                          
                            <th style="width: 100px;">
                                <label>Qty
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                             <th>
                                <label>Unit
                            </th>
                            <th>
                                <label>Price
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="width: 200px;">
                                <label>Amount
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            <th style="display: none;">
                                <label>
                                    <span class="required" aria-required="true"></span>
                                </label>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="my_form_base" style="background: red; display: none;">
                            <td>
                                <input value="<?php echo $row_old->pro_name_kh; ?>" type="text"" class=" form-control" name="txt_item_name_kh">
                            </td>
                            <td>
                                <input type="text" value="<?php echo $row_old->pro_name_vn; ?>" class=" form-control" name="txt_item_name_vn">
                            </td>

                            <td>
                                <input type="text" value="<?php echo $row_old->buy_date; ?>" class=" form-control" name="txt_date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            </td>
                            
                        
                            <td>
                                <input type="number" onkeyup="get_qty(this)" onchange="get_qty(this)" step="1" class="form-control" autocomplete="off" name="txt_qty" value="<?php echo $row_old->qty; ?>">
                            </td>
                            <td>
                                <select class="form-control" id="unit_name" name="cbo_unit">
                                    <option value="">==Please Choose and Select==</option>
                                    <?php
                                    $v_select = $connect->query("SELECT * FROM tbl_acc_unit_list ORDER BY uni_id ASC");
                                    while ($row_data = mysqli_fetch_object($v_select)) {
                                        if($row_old->unit_id==$row_data->uni_id) {
                                            echo '<option selected value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                        }
                                        else {
                                            echo '<option value="' . $row_data->uni_id . '">' . $row_data->uni_name . '</option>';
                                        }
                                        
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" onkeyup="get_price(this)" step="0.01" class="form-control" autocomplete="off" name="txt_price" value="<?php echo $row_old->price; ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control" value="<?php echo $row_old->amount; ?>" autocomplete="off" readonly="" name="txt_amount">
                            </td>
                             <td class="text-center" style="display: none;">
                                <button class="btnDelete"></button>
                            </td>
                            
                        </tr>
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>
                <div class="form-group text-center">
                    <div id="add_more"></div>
                </div>

            </div>
            <br>
            <div class="clearfix"></div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                        <a onclick="return confirm('Are you sure to Cancel this?')" href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>


<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var index_row = 1;
    $('#add_more').click(function() {
        $('#myTable').append('<tr data-row-id="' + (++index_row) + '">' + $('.my_form_base').html() + '</tr>');
        $('tr[data-row-id=' + index_row + ']').find('select').select2({
            width: 'auto'
        });
    });

    setTimeout(function() {
        $('#add_more').click();
    }, 2000);

    $("tbody").on('click', '.btnDelete', function() {
        var rowCount = $('tbody>tr').length;
        if (rowCount < 3) {
            alert("You can not delete this record.");
            return;
        }
        $(this).parents('tr').remove();
    });

    function get_price(obj) {
        var price = $(obj).val();
        var qty = $(obj).parents('tr').find('td:nth-last-child(5) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
    cal_total_amount();

    function cal_total_amount() {
        var v_total_amount =0;
        $('tbody >tr').find('td:nth-last-child(2)').each(function() {
            v_total_amount += parseFloat($(this).find('input').val());
        });
        $('tfoot >tr').find('th:last-child').html(v_total_amount.toFixed(2));
    }

    function get_qty(obj) {
        var qty = $(obj).val();
        var price = $(obj).parents('tr').find('td:nth-last-child(3) > input').val();
        var amo = price * qty;
        $(obj).parents('tr').find('td:nth-last-child(2) > input').val(amo.toFixed(2));
        cal_total_amount();
    }
</script>
<script type="text/javascript">
    $('select[name=cbo_re_name]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_re_name",
            success: function(result) {
                if ($('select[name=cbo_re_name]').html().trim() != result.trim()) {
                    $('select[name=cbo_re_name]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_pos]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pos",
            success: function(result) {
                if ($('select[name=cbo_pos]').html().trim() != result.trim()) {
                    $('select[name=cbo_pos]').html(result);
                }
            }
        });
    });
    $('select#id_item_name').parents('div.form-group').change(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=p_item_name",
            success: function(result) {
                if ($('select#id_item_name').html().trim() != result.trim()) {
                    $('select#id_item_name').html(result);
                }
            }
        });
    });
    $('select#unit_name').parents('div.form-group').mouseover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=unit_name",
            success: function(result) {
                if ($('select#unit_name').html().trim() != result.trim()) {
                    $('select#unit_name').html(result);
                }
            }
        });
    });
    $('select[name=cbo_check_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_check_by",
            success: function(result) {
                if ($('select[name=cbo_check_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_check_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_appro_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_appro_by",
            success: function(result) {
                if ($('select[name=cbo_appro_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_appro_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_pre_by]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_pre_by",
            success: function(result) {
                if ($('select[name=cbo_pre_by]').html().trim() != result.trim()) {
                    $('select[name=cbo_pre_by]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_dep]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_dep",
            success: function(result) {
                if ($('select[name=cbo_dep]').html().trim() != result.trim()) {
                    $('select[name=cbo_dep]').html(result);
                }
            }
        });
    });
    $('select[name=cbo_type_of_req]').parents('div.form-group').hover(function() {
        $.ajax({
            url: "ajx_get_content_select.php?d=cbo_type_of_req",
            success: function(result) {
                if ($('select[name=cbo_type_of_req]').html().trim() != result.trim()) {
                    $('select[name=cbo_type_of_req]').html(result);
                }
            }
        });
    });

   
    $('#re_pro_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_unit',success:function (result) {
            if($('select[name="cbo_unit[]"]').html().trim()!=result.trim())
                $('select[name="cbo_unit[]"]').html(result);
        }});
        myAlertInfo("Refresh Unit Name");
    });

     $('#re_track_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?d=cbo_track',success:function (result) {
            if($('select[name="cbo_track[]"]').html().trim()!=result.trim())
                $('select[name="cbo_track[]"]').html(result);
        }});
        myAlertInfo("Refresh Truck Name");
    });



    $('button[name=add_dep]').click(function() {
        $('div#add_dep').modal('show');
    });
    $('button[name=add_type]').click(function() {
        $('div#add_type_of_req').modal('show');
    });

    $('.re_fresh_name').click(function () {
       
        myAlertInfo("Refreshed");
    });

    
 function view_iframe_track_name(){
        document.getElementById('result_modal').src = '../st_track_machince_list/add.php?view=iframe';
    }
</script>
<?php include_once '../layout/footer.php' ?>

<div class="modal fade" id="request_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_request_name.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="pos_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_pos.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="item_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_item_name.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="modal_unit_name">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_unit.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="pre_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_prepare_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="check_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_check_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="app_by">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_approved_by.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="add_dep">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_depment.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
<div class="modal fade" id="add_type_of_req">
    <div class="modal-dialog" style="border: 1px solid darkred;">
        <iframe src="iframe_add_type_of_req.php" frameborder="0" style="height: 400px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>
