<?php 
    $menu_active =101;
    $layout_title = "Add Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>

<?php 
    if(isset($_POST['btn_add'])){
        $v_meeting_no = @$_POST['cbo_meeting_no'];
        $v_mee_fee= @$_POST['txt_mee_fee'];
        $v_mee_con= @$_POST['txt_mee_con'];
        $v_mee_iss= @$_POST['txt_mee_iss'];
        $v_mee_imp= @$_POST['txt_mee_imp'];
        $v_next_mee= @$_POST['txt_next_mee'];

        $date_audit = date("Y-m-d H:i:s");
        $v_user_id = @$_SESSION['user']->user_id;
        
            $query_add = "INSERT INTO tbl_meeting_result(
                                                mre_meeting_topic
                                                ,mre_meeting_feedback   
                                                ,mre_conclusion
                                                ,mre_issue
                                                ,mre_improvement
                                                ,mre_next_meeting
                                                ,user_id
                                                ,date_audit
                                                ) 

                                        VALUES('$v_meeting_no'
                                                ,'$v_mee_fee'
                                                ,'$v_mee_con'
                                                ,'$v_mee_iss'
                                                ,'$v_mee_imp'
                                                ,'$v_next_mee'
                                                ,'$v_user_id'
                                                ,'$date_audit'
                                                )";
            
            if($connect->query($query_add)){
                $sms = '<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Successfull!</strong> Data inserted ...
                </div>';
                // header("Refresh:2; url=index.php");   
            }else{
                $sms = '<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Error!</strong> Query error ...
                </div>';
                // header("Refresh:0; url=add.php");    
            }
        
    }

 ?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <?= @$sms ?>
            <h2><i class="fa fa-user fa-fw"></i>Add New</h2>
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
                                   <select class="form-control" name="cbo_meeting_no">
                                        <option value="">=== Please Choose and Select ===</option>
                                        <?php 
                                            $v_select = $connect->query("SELECT * FROM tbl_meeting_plan ORDER BY meetp_meting_no ASC");
                                            while ($row_data = mysqli_fetch_object($v_select)) {
                                                echo '<option value="'.$row_data->meetp_id.'">'.$row_data->meetp_meting_no.'</option>';
                                            }
                                         ?>
                                    </select>
                                    <label>Meeting N&deg; :
                                        <span class="required" aria-required="true"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_mee_fee" required="required" autocomplete="off">
                                    <label>Meeting FeedBack :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_mee_con" required="required" autocomplete="off">
                                    <label>Meeting Conclusion :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_mee_iss" required="required" autocomplete="off">
                                    <label>Meeting Issue :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_mee_imp" required="required" autocomplete="off">
                                    <label>Meeting Improvement :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group form-md-line-input">
                                    <input type="text" class="form-control" name="txt_next_mee" required="required" autocomplete="off">
                                    <label>Next Meeting :
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                </div>
                            </div>
                        
                        </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12 col-sm-6 col-md-6 col-lg-6 text-center">
                                <button type="submit" name="btn_add" class="btn blue"><i class="fa fa-save fa-fw"></i> Save</button>
                                <a href="index.php" class="btn red"><i class="fa fa-undo fa-fw"></i> Cancel</a>
                            </div>
                        </div>
                    </div>
                </form><br>
            </div>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
