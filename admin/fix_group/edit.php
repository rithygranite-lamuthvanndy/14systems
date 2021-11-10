<?php 
    $menu_active =141;
    $left_active =0;
    $layout_title = "Edit Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        
        $v_id = @$_POST['txt_id'];
        $v_locat = @$_POST['cbo_locat'];
        $v_name = @$_POST['txt_name'];
        $v_note = @$_POST['txt_note'];
       
        $query_update = "UPDATE `tbl_fix_group` 
            SET 
                `gr_locat`='$v_locat',
                `gr_name`='$v_name',
                `gr_note`='$v_note'
            WHERE `gr_id`='$v_id'";
            
       
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
    $edit_id = @$_GET['edit_id'];
    $old_data = $connect->query("SELECT * FROM tbl_fix_group WHERE gr_id='$edit_id'");
    $row_old_data = mysqli_fetch_object($old_data);


 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Edit Location</h2>
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
                    <input type="hidden" name="txt_id" value="<?= $row_old_data->dep_id ?>">
                    <div class="form-body">
                         <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Location:</label>                                
                                <select name="cbo_locat" id="input" class="form-control myselect2" required="required">
                                    <option>=== Select and Choose here ===</option>
                                    <?php 
                                        $sql=$connect->query("SELECT * FROM tbl_fix_locat ORDER BY locat_name ASC");
                                        while ($row=mysqli_fetch_object($sql)) {
                                            if($row_old_data->gr_locat==$row->locat_id)
                                                echo '<option selected value="'.$row->locat_id.'">'.$row->locat_name.'</option>';
                                            else
                                                echo '<option value="'.$row->locat_id.'">'.$row->locat_name.'</option>';
                                        }
                                     ?>
                                </select>
                            </div>

                                <label>Location Name:
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <input value="<?= $row_old_data->gr_name ?>" type="text" name="txt_name" class="form-control" required="">
                                <br>

                                <label>Note:
                                    <span class="required" aria-required="true">*</span>
                                </label>
                                <textarea name="txt_note" rows="10" class="form-control"><?= $row_old_data->gr_note ?></textarea>
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
