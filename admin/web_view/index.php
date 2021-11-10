<?php 
    $menu_active =2;
    $layout_title = "Welcome to Home Profile Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-image fa-fw"></i> Web View Administrator</h2>
        </div>
    </div>
    <br>
    <br>
    <div class="portlet-title">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Contract No</th>
                        <th>Urgent Status</th>
                        <th>Title</th>
                        <!-- <th>Sub Title</th> -->
                        <th>Image</th>
                        <th>View</th>
                        <th>Price Show</th>
                        <!-- <th>Description</th> -->
                        <!-- <th>Note</th> -->
                        <th>User</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>                                 
                    <?php 
                        $i = 0;
                        $v_user_id = @$_SESSION['user']->user_id;
                        $get_data = $connect->query("SELECT * FROM tbl_view_info AS A 
                            LEFT JOIN tbl_user AS B ON B.user_id=A.vinfo_user_id
                            LEFT JOIN tbl_egc001_type AS EGCT ON EGCT.et_id=A.vinfo_contact_no
                            LEFT JOIN tbl_view_info_type AS T ON T.vit_id=A.vinfo_type_id
                            WHERE A.vinfo_user_id='$v_user_id'
                        ORDER BY vinfo_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->et_name.'</td>';
                                echo '<td>'.$row->vit_name.'</td>';
                                echo '<td>'.$row->vinfo_title.'</td>';
                                // echo '<td>'.$row->vinfo_sub_title.'</td>';
                                echo '<td><img src="../../img/img_web_view/'.$row->vinfo_image.'" class="img-responsive"/></td>';
                                echo '<td>'.$row->vinfo_view.'</td>';
                                echo '<td>'.$row->vinfo_price_show.'</td>';
                                // echo '<td>'.$row->vinfo_description.'</td>';
                                // echo '<td>'.$row->vinfo_note.'</td>';
                                echo '<td>'.$row->user_name.'</td>';
                                echo '<td>'.$row->vinfo_created_at.'</td>';
                                echo '<td>'.$row->vinfo_updated_at.'</td>';
                                echo '<td class="text-center">';
                                   echo '<a href="edit.php?edit_id='.$row->vinfo_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->vinfo_id.'&del_img='.$row->vinfo_image.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';
                                   echo '<a href="../web_view_image/index.php?wv_id='.$row->vinfo_id.'" class="btn btn-xs btn-info" title="copy"><i class="fa fa-image fa-fw"></i></a> ';
                                    
                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                    
                    
                </tbody>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
