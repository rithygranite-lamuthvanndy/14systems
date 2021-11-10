<?php 
    $menu_active =140;
    $left_active =0;
    $layout_title = "Create Stock In";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_date_record = mysqli_escape_string($connect,@$_POST['txt_date_record']);
        $v_supplier = mysqli_escape_string($connect,@$_POST['cbo_supplier']);
        $v_letter_no = mysqli_escape_string($connect,@$_POST['txt_letter_no']);
        $v_req_no = mysqli_escape_string($connect,@$_POST['txt_req_no']);
        $v_note = mysqli_escape_string($connect,@$_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        

        $query_update ="UPDATE tbl_st_stock_in SET
                stsin_date_in='$v_date_record',
                stsin_letter_no='$v_letter_no',
                stsin_req_no='$v_req_no',
                stsin_supp_id='$v_supplier',
                stsin_note='$v_note',
                user_id='$v_user_id'  
                WHERE stsin_id='$v_id'             
                ";
        if($connect->query($query_update)){
            $last_id=$v_id;
        }
        else{
            die($connect->error);
        }

        $sql_insert="INSERT INTO tbl_st_stock_in_detail
                (
                stsin_id,
                pro_id,
                in_qty,
                in_price
                )VALUES
            ";

        $v_row_detail_id=$_POST['txt_row_detail_id'];
        $v_pro_code=$_POST['cbo_pro_code'];
        $v_qty=$_POST['txt_qty'];
        $v_price=$_POST['txt_price'];
        $flag=0;
        $status=0;
        foreach ($v_pro_code as $key=>$value) {
            $v_new_row_detail_id=mysqli_real_escape_string($connect,$v_row_detail_id[$key]);
            $v_new_pro_code=mysqli_real_escape_string($connect,$v_pro_code[$key]);
            $v_new_qty=mysqli_real_escape_string($connect,$v_qty[$key]);
            $v_new_price=mysqli_real_escape_string($connect,$v_price[$key]);
            if($v_new_pro_code&&$v_new_qty&&$v_new_price&&$v_new_row_detail_id){
                $sql_update="UPDATE tbl_st_stock_in_detail SET 
                                pro_id='$v_new_pro_code',
                                in_qty='$v_new_qty',
                                in_price='$v_new_price'
                            WHERE std_id='$v_new_row_detail_id'
                            ";
                $connect->query($sql_update);
                $status=1;
            }
            elseif($v_new_pro_code&&$v_new_qty&&$v_new_price&&$v_new_row_detail_id==0){
                $sql_insert.="(
                        '$last_id',
                        '$v_new_pro_code',
                        '$v_new_qty',
                        '$v_new_price'
                        ),";
                ++$flag;

            }
        }
        if($flag!=0 OR $status==1){
            $sql = rtrim($sql_insert,",");
            if($connect->query($sql) OR $status==1){
                $sms='<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Success !</strong> Updating record
                    </div>';
            }
            else{
                $sms='<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error !</strong> '.$connect->error.'
                </div>';
            }
        }
    }


// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_st_stock_in WHERE stsin_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <?= @$sms ?>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-truck fa-flip-horizontal"></i> Edit Stock In</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->stsin_id ?>">
                    <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Date Stock In *:
                                    </label>
                                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control" value="<?= $row_old_data->stsin_date_in ?>" name="txt_date_record" placeholder="Choose Date" required="" aufocomplete="off">
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Supplier *: </label>
                                    <select type="text" class="form-control myselect2" name="cbo_supplier" required="" autocomplete="off">
                                        <option value="">=== Select and choose===</option>
                                        <?php 
                                            $get_select=$connect->query("SELECT * FROM tbl_sup_supplier_info ORDER BY supsi_name ASC");
                                            while($row_data = mysqli_fetch_object($get_select)){
                                                if($row_old_data->stsin_supp_id==$row_data->supsi_id)
                                                    echo '<option selected value="'.$row_data->supsi_id.'">'.$row_data->supsi_name.'</option>';
                                                else
                                                    echo '<option value="'.$row_data->supsi_id.'">'.$row_data->supsi_name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Letter Number *: </label>
                                    <input type="text" value="<?= $row_old_data->stsin_letter_no ?>" class="form-control" name="txt_letter_no" required=""  autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Request N&deg; *: </label>
                                    <input type="text" value="<?= $row_old_data->stsin_req_no ?>" class="form-control" name="txt_req_no" required=""  autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" rows="1" autocomplete="off"><?= $row_old_data->stsin_note ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <table id="myTable" class="table table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 25%; word-wrap: nowrap;">Product Code</th>
                                            <th class="text-center" style="width: 30%;">Product Name
                                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#modal' onclick="view_iframe_product_name();"><i class="fa fa-plus"></i></a>
                                                <div class="btn btn-success btn-xs" id="re_pro_name"><i class="fa fa-refresh"></i></div>
                                            </th>
                                            <th class="text-center" style="width: 7%;">QUANTITY</th>
                                            <th class="text-center" style="width: 10%;">PRICE</th>
                                            <th class="text-center" style="width: 15%;">AMOUNT</th>
                                            <th class="text-center" style="width: 3%;"> <i class="fa fa-cog fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $sql="SELECT *,(in_price*in_qty) AS amo,B.stpron_code
                                            FROM tbl_st_stock_in_detail AS A 
                                            LEFT JOIN tbl_st_product_name AS B ON A.pro_id=B.stpron_id
                                            WHERE stsin_id='$edit_id'";
                                            $result_detail=$connect->query($sql);
                                            $v_total_amo=0;
                                            while ($row_old_detail=mysqli_fetch_object($result_detail)) {
                                                echo '<tr>';
                                                    echo '<td>
                                                                <input type="text" name="txt_pro_code[]" value="'.$row_old_detail->stpron_code.'" id="inputTxt_acc_no" class="form-control" readonly="">
                                                            </td>
                                                            <td>
                                                                <select class="form-control myselect2" name="cbo_pro_code[]">
                                                                    <option value="">=== Please Choose and Select ===</option>';
                                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
                                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                                            if($row_old_detail->pro_id==$row_data->stpron_id)
                                                                                echo '<option selected value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_name_vn.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                                            else
                                                                                echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_name_vn.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                                        }
                                                                echo '</select>
                                                            </td>
                                                            <td>
                                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="'.$row_old_detail->in_qty.'">
                                                            </td>
                                                            <td>
                                                                <input type="number" step="0.001" name="txt_price[]" class="form-control" value="'.$row_old_detail->in_price.'">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="txt_amo[]" value="'.$row_old_detail->amo.'" readonly="" id="inputTxt_acc_no" class="form-control">
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                                                <input type="hidden" name="txt_row_detail_id[]" value="'.$row_old_detail->std_id.'" readonly="" id="inputTxt_acc_no" class="form-control">
                                                            </td>';
                                                echo '</tr>';
                                                $v_total_amo+=$row_old_detail->amo;
                                            }
                                         ?>
                                        <tr class="my_form_base" style="background: red; display: none;">
                                            <td>
                                                <input type="text" name="txt_pro_code[]" id="inputTxt_acc_no" class="form-control" readonly="">
                                            </td>
                                            <td>
                                                <select class="form-control" name="cbo_pro_code[]">
                                                    <option value="">=== Please Choose and Select ===</option>
                                                    <?php 
                                                        $v_select = $connect->query("SELECT stpron_id,stpron_code,stpron_name_vn,stpron_name_kh FROM tbl_st_product_name ORDER BY stpron_code DESC");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            echo '<option value="'.$row_data->stpron_id.'" data_pro_code='.$row_data->stpron_code.'>['.$row_data->stpron_name_vn.'] '.$row_data->stpron_name_vn.' == '.$row_data->stpron_name_kh.'</option>';
                                                        }
                                                     ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" step="1" name="txt_qty[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="number" step="0.001" name="txt_price[]" class="form-control" value="0">
                                            </td>
                                            <td>
                                                <input type="text" name="txt_amo[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <div class="btnDelete btn btn-danger btn-xs"><i class="fa fa-trash"></i></div>
                                                <input type="hidden" name="txt_row_detail_id[]" value="0" readonly="" id="inputTxt_acc_no" class="form-control">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th style="visibility: hidden;"></th>
                                            <th class="text-right">ទឹកប្រាក់សរុប <br>​ TOTAL AMOUNT</th>
                                            <th colspan="2"><?= $v_total_amo ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <label>&nbsp;</label>
                                    <br>
                                    <div id="add_more" class="btn btn-default yellow btn-md"><i class="fa fa-plus-circle"></i> Add More</div>
                                    <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i> Update</button>
                                    <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>

                </form><br>
            </div>
        </div>
    </div>
</div>
<?php include_once '../layout/footer.php' ?>
<script type="text/javascript">
    //Press Button Add More
    var index_row = 1;
    $('#add_more').click(function(){ 
        $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
        $('tr[data-row-id='+index_row+']').find('select').select2();
    });
    setTimeout(function(){
        $('#add_more').click();      
    },1000);
    //Delete Row By Row
    $("tbody").on('click', 'div.btnDelete', function () {
        var rowCount = $('tbody >tr').length;
        if(rowCount<=2){
            alert("You can not delete this record.");
            return;
        }
        v_row_detail_id=$(this).parents('tr').find('input[name^=txt_row_detail_id]').val();
        let v_btn_delte=$(this);
        if(v_row_detail_id){
            $.get('delete.php?del_detail_id='+v_row_detail_id, function(data) {
                v_btn_delte.parents('tr').remove();
            });
        }
    });
    $('tbody').on('keyup', 'tr td:nth-child(3) >input,tr td:nth-child(4) >input', function(event) {
        let v_qty=$(this).parents('tr').find('td:nth-child(3) input').val();
        let v_amo=$(this).parents('tr').find('td:nth-child(4) input').val();
        $(this).parents('tr').find('td:nth-child(5) input').val(v_qty*v_amo);
        totalAmount();
    });
    totalAmount();
    function totalAmount(){
        let v_total_amo=0;
        $('tbody >tr').each(function(index, el) {
            v_amo=parseFloat($(this).find('td:nth-last-child(2) >input').val());
            v_total_amo+=v_amo;
        });
        $('tfoot tr th:last-child').html(v_total_amo);
    }

    $('#re_pro_name').click(function () {
        $.ajax({url: 'ajx_get_content_select.php?status=re_pro_name',success:function (result) {
            if($('select[name="cbo_pro_code[]"]').html().trim()!=result.trim())
                $('select[name="cbo_pro_code[]"]').html(result);
        }});
        myAlertInfo("Refresh Product Name");
    });
    $("tbody").on('change', 'tr td:nth-child(2) select', function () {
        // checkItem($(this));
        v_pro_code=$(this).find('option:selected').attr('data_pro_code');
        $(this).parents('tr').find('td:first-child input').val(v_pro_code);
    });
    function view_iframe_product_name(){
        document.getElementById('result_modal').src = '../st_product_name/index.php?view=iframe';
    }
    var flag=0;
    function checkItem(obj) {
        $('tbody >tr').find('td:nth-child(2)').each(function() {
            v_pro_id=$(this).find('select').val();
            if(v_pro_id===$(obj).val()){
                ++flag;
                if(flag>2){
                    myAlertError("Sorry, you choose this item ready !");
                    $(obj).parents('tr').remove(); 
                    flag-=2;
                    return false;
                }
            }
        });
    }
</script>
<div class="modal fade" id="modal">
    <div class="modal-dialog" style="border: 1px solid darkred; width: 70%;">
        <iframe id="result_modal" frameborder="0" style="height: 600px; max-width: 100%; width: 100%;" align="top" scrolling="0"></iframe>
    </div>
</div>