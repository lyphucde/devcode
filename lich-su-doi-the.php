<?php include('head.php');?>

<title>LỊCH SỬ ĐỔI THẺ | <?=$site_tenweb;?></title>

<?php
if(!isset($_SESSION['username']))
{
    echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
    setTimeout(function(){ location.href = "/" },1000);</script>';
    die;
}
?>

<div class="container">
    <div class="row">


        <div class="col-sm-12">
            <div class="boxbody_tbl">
                <div class="boxbody_top">
                    <h2><span>LỊCH SỬ ĐỔI THẺ</span></h2>
                </div>
                <div class="boxbody_body">
                    <div class="table-responsive" style="margin-top:10px">
                        <table id="example"
                            class="table table-hover table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 119px;">
                                        <b>Số serial</b>
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 119px;">
                                        <b>Mã thẻ</b>
                                    </th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 128px;"><b>Mệnh
                                            giá</b></th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 128px;"><b>Thực
                                            nhận</b></th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 114px;"><b>Nhà
                                            mạng</b></th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 178px;"><b>Thời
                                            gian</b></th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 121px;"><b>Trạng
                                            Thái</b></th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 78px;">Ghi chú
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `doithe_auto` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 1000");
while($row = mysqli_fetch_assoc($result))
{
?>
                                <tr>
                                    <td class="text-center"><?=$row['seri'];?></td>
                                    <td><?=$row['pin'];?></td>
                                    <td><?=format_cash($row['menhgia']);?>đ</td>
                                    <td><?=format_cash($row['thucnhan']);?>đ</td>
                                    <td class="text-center">

                                        <span class="text-success" style="font-weight:bold"><?=$row['type'];?></span>

                                    </td>
                                    <td>
                                        <?=$row['createdate'];?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 'xuly'){ ?>
                                        <label class="label label-warning">Chờ xử lý</label>
                                        <?php }?>
                                        <?php if($row['status'] == 'hoantat'){ ?>
                                        <label class="label label-success">Hoàn tất</label>
                                        <?php }?>
                                        <?php if($row['status'] == 'thatbai'){ ?>
                                        <label class="label label-danger">Thất bại</label>
                                        <?php }?>
                                    </td>
                                    <td><?=$row['note'];?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include('foot.php');?>