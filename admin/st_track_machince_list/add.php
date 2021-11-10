<?php
$menu_active = 140;
$left_active = 0;
$layout_title = "Add Page";
include_once '../../config/database.php';
include_once '../../config/athonication.php';
if (@$_GET['view'] == 'iframe')
    include_once '../layout/header_frame.php';
else
    include_once '../layout/header.php';
?>


<?php
if (isset($_POST['btn_submit'])) {
    $v_date_buy = mysqli_real_escape_string($connect, @$_POST['txt_date_buy']);
    $v_code = mysqli_real_escape_string($connect, @$_POST['txt_code']);
    $v_name_kh = mysqli_real_escape_string($connect, @$_POST['txt_name_kh']);
    $v_name_vn = mysqli_real_escape_string($connect, @$_POST['txt_name_vn']);
    $v_price = mysqli_real_escape_string($connect, @$_POST['txt_price']);
    $v_positon = mysqli_real_escape_string($connect, @$_POST['txt_positon']);
    $v_note = mysqli_real_escape_string($connect, @$_POST['txt_note']);
    $txt_material_type_id= mysqli_real_escape_string($connect, @$_POST['txt_material_type_id']);
    $v_user_id = @$_SESSION['user']->user_id;


    $query_add = "INSERT INTO  tbl_st_track_machine_list(
                date_buy,
                code,
                name_vn,
                name_kh,
                track_price,
                track_position,
                note,
                user_id,
                material_type_id               
                ) 
            VALUES(
                '$v_date_buy',
                '$v_code',
                '$v_name_vn',
                '$v_name_kh',
                '$v_price',
                '$v_positon',
                '$v_note',
                '$v_user_id',
                '$txt_material_type_id'
                )";
    if ($connect->query($query_add)) {
        $last_id=$connect->insert_id;
    } else {
        
    }


    
         $sql="INSERT INTO tbl_st_track_machine_list_mores
                (
                tr_id,
                roman_id
                )VALUES";

        $v_track_id=$_POST['txt_track_id'];
        $flag=0;
        foreach ($v_track_id as $key=>$value) {
            $v_new_v_track_id=mysqli_real_escape_string($connect,$v_track_id[$key]);
            if($v_new_v_track_id){
                $sql.="(
                        '$last_id',
                        '$v_new_v_track_id'
                        ),";
                ++$flag;
            }
        }

        $sql = rtrim($sql,",");
        if($connect->query($sql)){
            $sms = '<div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Successfull!</strong> Data inserted ...
            </div>';
        }
        else{
            $sms = '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error!</strong> ' . $connect->error . '
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
                                <label>Date Buy: </label>
                                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                    <input autocomplete="off" readonly name="txt_date_buy" type="text" class="form-control" placeholder="Date Buy .....">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Code *: </label>
                                    <input type="text" class="form-control" name="txt_code" required="" autocomplete="off">
                                </div>
                            </div>

                             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Material Type *: </label><br>
            <input  type="hidden" name="txt_material_type_id" value="1">
                                   
                                   <!--  <select class="form-control myselect2" name="txt_material_type_id" required="">
                                         <option value="">=== Select and choose===</option> -->
                                       <!--  <?php
                                       // $get_select = $connect->query("SELECT * //FROMtbl_st_material_type_list ORDER BY sttyp_name ASC");
                                       // while ($row_data = mysqli_fetch_object($get_select)) {
                                           // echo '<option value="' . $row_data->sttyp_id . '">' . //$row_data->sttyp_name . '</option>';
                                        //}
                                        ?> -->
                                    <!-- </select> -->

                                    <?php
                                        $get_select = $connect->query("SELECT * FROM tbl_st_material_type_list ORDER BY sttyp_name DESC");
                                        while ($row_data = mysqli_fetch_object($get_select)) {
                                            
                                        
                                        ?>
                        <input  type="checkbox" name="txt_track_id[]" value="<?php echo $row_data->sttyp_id; ?>">
                                        <?php echo $row_data->sttyp_name; ?><br>
                                        <?php
                                          }
                                        ?>
                                    
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name KH *: </label>
                                    <input type="text" class="form-control" name="txt_name_kh" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Name VN *: </label>
                                    <input type="text" class="form-control" name="txt_name_vn" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Truck Position: </label>
                                    <input type="text" class="form-control" name="txt_positon">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Truck Price : </label>
                                    <input type="text" class="form-control" name="txt_price">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Note : </label>
                                    <textarea type="text" class="form-control" name="txt_note" style="height: 80px;" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="btn_submit" class="btn blue"><i class="fa fa-save fa-fw"></i>Save</button>
                                    <a href="index.php?view=<?= @$_GET['view'] ?>" class="btn red"><i class="fa fa-undo fa-fw"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                </form><br>
            </div>
        </div>
    </div>
</div>
<?php
if (@$_GET['view'] == 'iframe')
    include_once '../layout/footer_frame.php';
else
    include_once '../layout/footer.php';
?>