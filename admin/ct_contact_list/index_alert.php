<?php 
    $menu_active =111;
    $left_active =0;
    $layout_title = "Welcome to Setting Page";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>
<?php 
    $contact_list_id = @$_GET['ct_id'];



    // delete alert
    if(@$_GET['del_id'] != ""){
        $del_id = @$_GET['del_id'];
        $connect->query("DELETE FROM tbl_ct_contact_alert WHERE ctca_id='$del_id'");
    }


?>

<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Alert List</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add_alert.php" id="sample_editable_1_new" class="btn blue"> 
                <i class="fa fa-plus"></i>
            </a>
            <a href="index.php" id="sample_editable_1_new" class="btn red"> 
                <i class="fa fa-undo"></i>
            </a>
        </div>
    </div>
    <br>
    <div class="portlet-body">
        <div id="sample_1_wrapper" class="dataTables_wrapper">
            <table class="table table-striped table-bordered table-hover dataTable dtr-inline collapsed" id="sample_1" role="grid" aria-describedby="sample_1_info" style="width: 1180px;">
                <thead>
                    <tr role="row" class="text-center">
                        <th>N&deg;</th>
                        <th>Name</th>
                        <th>Date Alert</th>
                        <th>Note</th>
                        <th>  </th>
                        <th>  </th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $get_data = $connect->query("SELECT 
                               *
                            FROM  tbl_ct_contact_alert AS A
                            LEFT JOIN tbl_ct_contact_list AS B ON A.ctca_contact=B.ctco_id
                            WHERE A.ctca_contact = '$contact_list_id'
                            ORDER BY ctca_contact DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->ctco_full_name.'</td>';
                                echo '<td>'.$row->ctca_date_alert.'</td>';
                                echo '<td>'.$row->ctca_note.'</td>';
                                echo '<td>'."  ".'</td>';
                                echo '<td>'."  ".'</td>';
                                echo '<td class="text-center">';
                                   echo '<a href="index_alert.php?del_id='.$row->ctca_id.'&ct_id='.$contact_list_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

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
