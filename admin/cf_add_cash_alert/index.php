<?php 
    $menu_active =115;
    $left_active =0;
    $layout_title = "Welcome...";
    include_once '../../config/database.php';
    include_once '../../config/athonication.php';
    include_once '../layout/header.php';
?>


<div class="portlet light bordered">
    <div class="row">
        <div class="col-xs-12">
            <h2><i class="fa fa-fw fa-map-marker"></i> Add Cash Alert</h2>
        </div>
    </div>
    <br>
    <div class="">
        <div class="caption font-dark">
            <a href="add.php" id="sample_editable_1_new" class="btn green"> Add New
                <i class="fa fa-plus"></i>
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
                        <th>Description</th>
                        <th>Date Alert</th>
                        <th>Note</th>
                        <th style="min-width: 100px;" class="text-center">Action <i class="fa fa-cog fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        $count = 0;
                        $v_current_year_month = date('Y-m');
                        $get_data = $connect->query("SELECT 
                               *
                            FROM tbl_cf_cash_flow_alert AS A
                            LEFT JOIN tbl_cf_cash_record AS CFA ON A.cfcfa_description=CFA.cfcr_id
                            ORDER BY cfcfa_id DESC");
                        while ($row = mysqli_fetch_object($get_data)) {
                            $count+= 1; 
                            echo '<tr>';
                                echo '<td>'.(++$i).'</td>';
                                echo '<td>'.$row->cfcr_description.'</td>';
                                echo '<td>'.$row->cfcfa_date_alert.'</td>';
                                echo '<td>'.$row->cfcfa_note.'</td>';
                                echo '<td class="text-center">';
                                //    echo '<a href="edit.php?edit_id='.$row->cfcfa_id.'" class="btn btn-xs btn-warning" title="edit"><i class="fa fa-edit"></i></a> ';
                                   echo '<a href="delete.php?del_id='.$row->cfcfa_id.'" onclick="return confirm(\'Are you sure to delete this?\')" class="btn btn-xs btn-danger" title="delete"><i class="fa fa-trash"></i></a> ';

                                echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Count:
                            <?php
                                echo "$count";
                            ?>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>






<?php include_once '../layout/footer.php' ?>
