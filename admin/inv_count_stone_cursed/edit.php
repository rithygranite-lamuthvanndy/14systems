<?php 
    $menu_active =145;
    $dropdown=false;
    $left_menu_active=3;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
    include_once '../inv_operation/PHP/operation.php';
?>
<?php 
// get old data 
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_inv_block_to_cursed WHERE id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);
if(isset($_POST['btn_submit'])){
    //Update Main Item
    $v_parent_id= @$connect->real_escape_string($_POST['txt_parent_id']);
    $v_date_record = @$connect->real_escape_string($_POST['txt_date_record']);
    $v_counter_id = @$connect->real_escape_string($_POST['cbo_counter']);
    $v_note = @$connect->real_escape_string($_POST['txt_note']);

    $sql_update_parent="UPDATE `tbl_inv_block_to_cursed` SET 
    date_record='$v_date_record',
    counter_id='$v_counter_id',
    note='$v_note',
    user_id='$user_id'
    WHERE id='$v_parent_id'";
    if($connect->query($sql_update_parent))
        $flag_add_1=1;
    //Uodate Sub Item Or Add Morw
    $v_child_id= @$_POST['txt_child_id'];
    $v_block_code_id= @$_POST['cbo_block_code_id'];
    $v_lenght= @$_POST['txt_lenght'];
    $v_width= @$_POST['txt_width'];
    $v_height= @$_POST['txt_height'];

    foreach ($v_block_code_id as $key => $value) {
            if($v_child_id[$key]!='0'&&$value){
                $new_child_id=$v_child_id[$key];
                $new_block_code_id=$v_block_code_id[$key];
                $new_lenght=$v_lenght[$key];
                $new_width=$v_width[$key];
                $new_height=$v_height[$key];
                 //Add Sub Item
                $query_add_2="UPDATE `tbl_inv_block_to_cursed_detail` SET
                    `bfm_detail_id`='$new_block_code_id', 
                    `length`='$new_lenght', 
                    `width`='$new_width', 
                    `height`='$new_height'
                    WHERE id='$new_child_id'";
                $flag_add_2=$connect->query($query_add_2);

            }
            else if($v_child_id[$key]=='0'&&$value){//Add Sub Item
                // echo $v_child_id[$key].'='.$value.'='.$v_block_code[$key].'<br>';

                // echo '<script>alert("fff");</script>';
                $new_child_id=$v_child_id[$key];
                $new_block_code_id=$v_block_code_id[$key];
                $new_lenght=$v_lenght[$key];
                $new_width=$v_width[$key];
                $new_height=$v_height[$key];
                $query_add_2="INSERT INTO `tbl_inv_block_to_cursed_detail`(
                    `parent_id`,  
                    `bfm_detail_id`, 
                    `length`, 
                    `width`, 
                    `height`)
                    VALUES
                    (
                    '$v_parent_id',
                    '$new_block_code_id',
                    '$new_lenght',
                    '$new_width',
                    '$new_height'
                    )";
                if(!$connect->query($query_add_2))
                    die(mysqli_error($connect));
            }
        }
        if($flag_add_1==1){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data updated ...
            </div>'; 
        }else{  
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> '.mysqli_error($connect).'
            </div>'; 
        }
}
 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2 class="voucher_code">
                <i class="fa fa-plus-circle fa-fw"></i>Edit Record
            </h2>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <h3 class="panel-title">Update Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="txt_parent_id" value="<?= $edit_id ?>">
                    <div class="row">
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>ថ្ងៃទី / Date Record:</label>
                                <input type="text" data-provide="datepicker" data-date-format="yyyy-mm-dd" class="form-control" required name="txt_date_record" value="<?= $row_old_data->date_record ?>">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>អ្នករាប់ / Counter:</label>
                                <a class="btn btn-primary btn-xs" data-toggle="modal" href='#add_modal' onclick="set_iframe_counter()"><i class="fa fa-plus"></i></a>
                                <div class="btn btn-success btn-xs" id="refresh_cbo_counter"><i class="fa fa-refresh"></i></div>
                                <select name="cbo_counter" id="input" class="form-control myselect2" required="required">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_inv_counter_list ORDER BY name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            if($row_old_data->counter_id==$row->id)
                                                echo '<option selected value="'.$row->id.'">'.$row->name.'</option>';
                                            else
                                                echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Note : </label>
                                <textarea class="form-control" rows="1" autocomplete="off" name="txt_note"><?= $row_old_data->note ?></textarea>
                            </div>
                         </div>
                    </div>
                    <hr>
                    <table id="myTable" class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%;">តំបន់ <br> Khu<br></th>
                                <th class="text-center" style="width: 10%;">ជាន់ <br> Tầng<br></th>
                                <th class="text-center" style="width: 15%;">កូដថ្មដុំ <br> Block Code *</th>
                                <th class="text-center">បណ្ដោយ <br> Dài</th>
                                <th class="text-center">ទទឹង <br> Rộng</th>
                                <th class="text-center">កម្រាស់ <br> PRICE</th>
                                <th class="text-center">ម៉ែតគូបs  <br> M3</th>
                                <th class="text-center" style="width: 8%;">ប្រភេទថ្ម </th>
                                <th class="text-center" style="width: 8%;">ពណ៌ </th>
                                <th class="text-center" style="width: 8%;">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $sql_child=$connect->query("SELECT A.*,
                                    C.name AS location_name,
                                    D.name AS floor_name,
                                    E.name AS grade_type_name,
                                    F.name AS color_name,
                                    B.block_code
                                    FROM tbl_inv_block_to_cursed_detail AS A 
                                    LEFT JOIN tbl_inv_block_from_mine_detail AS B ON A.bfm_detail_id=B.id
                                    LEFT JOIN tbl_inv_location_list AS C ON B.location_id=C.id
                                    LEFT JOIN tbl_inv_floor_list AS D ON B.floor_id=D.id
                                    LEFT JOIN  tbl_inv_grade_type_list AS E ON B.grade_type_id=E.id 
                                    LEFT JOIN tbl_inv_color_list AS F ON B.color_id=F.id
                                    WHERE A.parent_id='$edit_id'");
                                while ($row_old_child=mysqli_fetch_object($sql_child)) {
                                    echo '<input value='.$row_old_child->id.' type="hidden" name="txt_child_id[]">';
                                    echo '<tr>';
                                        echo '<td>
                                                <input type="text" value="'.$row_old_child->location_name.'" name="txt_location_id[]" class="form-control" readonly="">
                                            </td>';
                                        echo '<td>
                                                <input type="text" value="'.$row_old_child->floor_name.'" name="txt_floor_id[]" class="form-control" readonly="">
                                            </td>';
                                        echo '<td>
                                                <select class="form-control myselect2" onchange="change_block_code(this);" name="cbo_block_code_id[]">
                                                    <option value="">=== select ===</option>';
                                                        $v_select = $connect->query("SELECT * FROM 
                                                            tbl_inv_block_from_mine_detail 
                                                            -- WHERE id NOT IN (SELECT bfm_detail_id FROM tbl_inv_block_to_cursed_detail) 
                                                            ORDER BY block_code");
                                                        while ($row_data = mysqli_fetch_object($v_select)) {
                                                            if($row_data->id==$row_old_child->bfm_detail_id)
                                                                echo '<option selected value="'.$row_data->id.'">'.$row_data->block_code.'</option>';
                                                            // else
                                                            //     echo '<option value="'.$row_data->id.'">'.$row_data->block_code.'</option>';
                                                        }
                                                echo '</select>
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->length.' type="number" onchange="changeLenght(this);" onkeyup="changeLenght(this);" step="0.01" name="txt_lenght[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->width.' type="number" onchange="changeWidth(this);" onkeyup="changeWidth(this);" step="0.01" name="txt_width[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.$row_old_child->height.' type="number" onchange="changeHeight(this);" onkeyup="changeHeight(this);" step="0.01" name="txt_height[]" class="form-control"value="0.01">
                                            </td>';
                                        echo '<td>
                                                <input value='.cal_mater_cub($row_old_child->length,$row_old_child->width,$row_old_child->height).' type="number" step="0.01" name="txt_mater_kub[]" class="form-control" readonly="" value="0">
                                            </td>';
                                        echo '<td>
                                                <input value="'.$row_old_child->grade_type_name.'" type="text" name="txt_grade_type[]" class="form-control" readonly="">
                                            </td>';
                                        echo '<td>
                                                <input value="'.$row_old_child->color_name.'" type="text" name="txt_color_id[]" class="form-control" readonly="">
                                            </td>';
                                        // echo '<td class="text-center">
                                        //             <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                        //         </td>';
                                    echo '</tr>';
                                }
                             ?>
                            
                                

                            <tr class="my_form_base" style="background: red; display: none;">
                                 <td>
                                    <input type="text" name="txt_location_id[]" class="form-control" readonly="">
                                </td>
                                <td>
                                    <input type="text" name="txt_floor_id[]" class="form-control" readonly="">
                                </td>
                                <td>
                                    <select class="form-control" onchange="change_block_code(this);" name="cbo_block_code_id[]">
                                        <option value="">=== select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM 
                                                tbl_inv_block_from_mine_detail 
                                                WHERE id NOT IN (SELECT bfm_detail_id FROM tbl_inv_block_to_cursed_detail) 
                                                ORDER BY block_code");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->id.'">'.$row_data->block_code.'</option>';
                                            }
                                         ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" onchange="changeLenght(this);" onkeyup="changeLenght(this);" step="0.01" name="txt_lenght[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" onchange="changeWidth(this);" onkeyup="changeWidth(this);" step="0.01" name="txt_width[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" onchange="changeHeight(this);" onkeyup="changeHeight(this);" step="0.01" name="txt_height[]" class="form-control"value="0.01">
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="txt_mater_kub[]" class="form-control" readonly="" value="0">
                                </td>
                                <td>
                                    <input type="text" name="txt_grade_type[]" class="form-control" readonly="">
                                </td>
                                <td>
                                    <input type="text" name="txt_color_id[]" class="form-control" readonly="">
                                </td>
                                <td class="text-center">
                                    <button class="btnDelete btn btn-info"><i class="fa fa-trash"></i></button>
                                </td>
                                <input value="0" type="hidden" name="txt_child_id[]">
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                                <th class="text-right">សរុប <br>​ TOTAL Mater</th>
                                <th ><input type="text" name="txt_total_amo" readonly="" id="inputTxt_total_amo" class="form-control" value="0" required="required" pattern="" title=""></th>
                                <th style="visibility: hidden;"></th>
                                <th style="visibility: hidden;"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <br>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Save</button>
                                <div id="add_more" class="btn btn-default yellow btn-md" title="Click on this button to add more record !">[<i class="fa fa-plus"></i>]</div>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../assets/global/plugins/jquery.min.js"></script>
<script>
    //Refresh Cmbobox
    $('div#refresh_cbo_counter').click(function(){
        $.ajax({url: "ajax_get_content_select.php?d=cbo_counter", success: function(result){
            if($('select[name="cbo_counter"]').html().trim() != result.trim()){
                $('select[name="cbo_counter"]').html(result);
                myAlertInfo("Your refresh item successfully !");
            }
        }});
    });
    $(document).ready(function(){
        //Press Button Add More
        var index_row = 1;
        $('#add_more').click(function(){ 
            $('#myTable').append('<tr data-row-id="'+(++index_row)+'">'+$('.my_form_base').html()+'</tr>');
            $('tr[data-row-id='+index_row+']').find('select').select2();
            // checkDuplicateBlockCode
            let v_arr_block_code=new Array();
            $('tbody tr').each(function(index, el) {
                let v_tmp=$(this).find('td:nth-child(3) >select').val();
                v_arr_block_code.push(v_tmp);
            });
            $.ajax({
                url:'ajax_get_content_select.php',
                type: 'POST',
                data: 'data='+v_arr_block_code,
                success: function (data) {
                    $('tr[data-row-id='+index_row+']').find('select').html(data);
                }
            });
        });
        setTimeout(function(){
            // $('#add_more').click();    
            totalAmount();
        },1000);

        //Delete Row By Row
        $("tbody").on('click', '.btnDelete', function () {
            var rowCount = $('tbody>tr').length;
            if(rowCount<=2){
                alert("You can not delete this record.");
                return false;
            }
            $(this).parents('tr').remove();
            let v_block_code=$(this).parents('tr').find('td:nth-child(3) >input').val();
            //Clear Session
            $.ajax({
                url: 'ajax_get_block_code.php?clear_block_code='+v_block_code,
                success:function (result) {
                    // alert(result);
                }
            });
            totalAmount();
            myAlertInfo("Your deleted record !");
        });


        // $('').prop("disabled", true);
    });
    function change_block_code(args){
        let v_block_code_id=$(args).val();
        $.ajax({
            url: 'ajax_get_block_code_info.php?block_code_id='+v_block_code_id,
            success: function(data){
                var myObj=JSON.parse(data);
                $(args).parents('tbody >tr').find('td:nth-child(1) >input').val(myObj['location_name']);
                $(args).parents('tbody >tr').find('td:nth-child(2) >input').val(myObj['floor_name']);
                $(args).parents('tbody >tr').find('td:nth-child(8) >input').val(myObj['grade_type_name']);
                $(args).parents('tbody >tr').find('td:nth-child(9) >input').val(myObj['color_name']);
            }
        });
    }
    function changeLenght (args) {
        let v_length=$(args).val();
        let v_width=$(args).parents('tbody >tr').find('td:nth-child(5) >input').val();
        let v_height=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(7) >input').val(v_mater_cub);
        totalAmount();
    }
    function changeWidth(args) {
        let v_length=$(args).parents('tbody >tr').find('td:nth-child(4) >input').val();
        let v_width=$(args).val();
        let v_height=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(7) >input').val(v_mater_cub);
        totalAmount();
    }

    function changeHeight(args) {
        let v_length=$(args).parents('tbody >tr').find('td:nth-child(4) >input').val();
        let v_width=$(args).parents('tbody >tr').find('td:nth-child(6) >input').val();
        let v_height=$(args).val();
        let v_mater_cub=cal_mater_cub(v_length,v_width,v_height);
        $(args).parents('tbody >tr').find('td:nth-child(7) >input').val(v_mater_cub);
        totalAmount();
    }
    function totalAmount () {
        var t_amo=0;
        $('input[name^="txt_mater_kub"]').each(function () {
            t_amo+= parseFloat($(this).val());
        });
        $('tfoot >tr:first-child').find('th:nth-last-child(3) >input[name=txt_total_amo]').val(t_amo.toFixed(2));
    }
    function set_iframe_counter(){
        document.getElementById('result_modal').src = '../inv_counter_list/index.php?view=iframe';
    }
</script>
<?php include_once '../layout/footer.php' ?>
<div class="modal fade" id="add_modal">
    <div class="modal-dialog modal-lg" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="result_modal" src="" width="100%" style="min-height: 600px; resize: vertical;" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>