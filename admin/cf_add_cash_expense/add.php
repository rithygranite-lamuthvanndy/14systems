<?php 
    $menu_active =115;
    $left_active =0;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<?php 
    if(isset($_POST['btn_submit'])){
        $v_date_record = @$_POST['txt_date_record'];
        $v_description = @$_POST['txt_description'];
        $v_category = @$_POST['txt_category'];
        $v_type = 2;
        $v_month_year = @$_POST['txt_month_year'];
        $v_amount_out = @$_POST['txt_amount_out'];
        $v_note = @$_POST['txt_note'];
        $v_user_id = @$_SESSION['user']->user_id;

        $query_add = "INSERT INTO tbl_cf_cash_record (
                cfcr_date_record,
                cfcr_description,
                cfcr_category,
                cfcr_type,
                cfcr_month_year,
                cfcr_amount_out,
                cfcr_note,
                user_id
                ) 
            VALUES(
                '$v_date_record',
                '$v_description',
                '$v_category',
                '$v_type',
                '$v_month_year',
                '$v_amount_out',
                '$v_note',
                '$v_user_id')";
        if($connect->query($query_add)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>'; 
        }else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> Query error ...
            </div>';   
        }
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-plus-circle fa-fw"></i>Create Record</h2>
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
                    <div class="form-body">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="date" class="form-control" name="txt_date_record"  autocomplete="off">
                                    <label>Date Record :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_description"  autocomplete="off">
                                    <label>Description :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_category" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_cf_category_list ORDER BY cfcl_name ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->cfcl_id.'">'.$row_data->cfcl_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Category :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <select class="form-control" name="txt_month_year" required="required">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_cf_monthyear_list ORDER BY cfmy_name ASC ");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->cfmy_id.'">'.$row_data->cfmy_name.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Month Year :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_amount_out"  autocomplete="off">
                                    <label>Amount Out :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_note"  autocomplete="off">
                                    <label>Note :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
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
