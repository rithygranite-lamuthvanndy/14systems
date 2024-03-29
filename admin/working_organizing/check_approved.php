<?php 
    $menu_active =122;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_name = @$connect->real_escape_string($_POST['txt_name']);
        $v_note = @$connect->real_escape_string($_POST['txt_note']);
        $v_user_id = @$_SESSION['user']->user_id;
        
       
        $query_update = "UPDATE `tbl_working_organizing` 
            SET 
                `wfor_approved`='$v_name',
                `wfor_note`='$v_note',
                `user_id`='$v_user_id'
            WHERE `wfor_id`='$v_id'";
            
       
        if($connect->query($query_update)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data update ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }


// get old data 
    $edit_id = @$_GET['sent_id'];
    $old_data = $connect->query("SELECT * FROM tbl_working_organizing WHERE wfor_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Record</h2>
        </div>
    </div>
    
    <br>
    <br>

    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Input Information</h3>
            </div>
            <div class="panel-body">
                <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->wfor_id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <label>Approved by :
                                    <span class="required text-danger" aria-required="true">*</span>
                                </label>
                                    <select class="form-control" name="txt_name" required="required">
                                        <option value="">=== Please Choose ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_employee ORDER BY emp_id ASC");
                                            while ($row_select = mysqli_fetch_object($v_select)) {
                                                if($row_select->emp_id==$row_old_data->wfor_approved){
                                                    echo '<option SELECTED="SELECTED" value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>'; 
                                                }else{
                                                    echo '<option value="'.$row_select->emp_id.'">'.$row_select->emp_name.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                <br>

                                <label>Note :
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="6" class="form-control"><?= $row_old_data->wfor_note ?></textarea>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn green"><i class="fa fa-save fa-fw"></i>Update</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="../../plugin/ckeditor_4.7.0_full/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace( 'detail', {
        language: 'en',
      height: '700'
        // uiColor: '#9AB8F3'
    });
</script>


<?php include_once '../layout/footer.php' ?>
