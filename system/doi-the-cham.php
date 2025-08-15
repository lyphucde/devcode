<div class="home-title">
    <span class="color3">ĐỔI THẺ THỦ CÔNG</span>
</div>
<?php
if (isset($_POST["submit_doithe"])) 
{
    $menhgia = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['menhgia']))));
    $type = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['type']))));
    $pin = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['pin']))));
    $seri = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['seri']))));
    $check_ck = mysqli_fetch_assoc(mysqli_query($ketnoi, "SELECT `ck` FROM `setting_card` WHERE `type` = '$type'  ")) ['ck'];

    $s_length = strlen($seri);
    $p_length = strlen($pin);

    $thucnhan = $menhgia - $menhgia * $check_ck / 100;

    $sql = "SELECT * FROM  doithe WHERE seri = '$seri' AND pin = '$pin' ";
    $kt = mysqli_query($ketnoi, $sql);
    

    if($type == 'Viettel')
    {
        if($s_length != 11 && $s_length != 14)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài seri không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
        else if($p_length != 13 && $p_length != 15)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài mã thẻ không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
    }
    if($type == 'Mobifone')
    {
        if($s_length != 15)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài seri không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
        else if($p_length != 12)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài mã thẻ không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
    }
    if($type == 'Vinaphone')
    {
        if($s_length != 14)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài seri không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
        else if($p_length != 14)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài mã thẻ không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
    }
    $query = $ketnoi->query("SELECT * FROM `doithe` WHERE `username` = '".$my_username."' AND `status` = 'xuly' ");
    $check_spam = mysqli_num_rows($query);
    if(!isset($_SESSION['username']))
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
        setTimeout(function(){ location.href = "" },1000);</script>';
        die;
    }
    else if ($check_spam >= 15) 
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Liên kết không tồn tại!", "error");</script>';
    }
    else if ($status_cham == 'OFF')
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Chức năng đang được bảo trì, vui lòng đợi!", "warning");</script>';
    }
    else if(mysqli_num_rows($kt)  > 0)
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Thẻ này đã có trên hệ thống!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
    }
    else 
    {
        $permitted_chars = 'QWERTYUIOPASDFGHJKLZXCVBNM';        
        $code = substr(str_shuffle($permitted_chars), 0, 10);
        $create = mysqli_query($ketnoi,"INSERT INTO `doithe` SET 
        `username` = '".$my_username."',
        `type` = '".$type."',
        `code` = '".$code."',
        `seri` = '".$seri."',
        `pin` = '".$pin."',
        `menhgia` = '".$menhgia."',
        `thucnhan` = '".$thucnhan."',
        `status` = 'xuly',
        `createdate` = now() "); 
        
        if($create)
        {
            $cookie = $site_cookie;
            $idNguoiNhan = $site_idfb;
            $noiDungTinNhan = '[SYSTEM] Có Thẻ Cần Xử Lý Từ User '.$my_username.'  
            TYPE: '.$type.'
            MỆNH GIÁ: '.$menhgia.'
            SERI: '.$seri.'
            PIN: '.$pin;
            $idAnh = '';
            senInboxCSM($cookie, $noiDungTinNhan, $idAnh, $idNguoiNhan);

            $guitoi = $site_gmail;   
            $subject = 'THÔNG BÁO CÓ THẺ CÀO ĐANG ĐỢI XỬ LÝ';
            $bcc = $site_tenweb;
            $hoten ='Client';
            $noi_dung = '<h2>Thông tin thẻ cào</h2>
            <table >
            <tbody>
            <tr>
            <td>Loại Thẻ:</td>
            <td><b>'.$type.'</b></td>
            </tr>
            <tr>
            <td>Mệnh Giá:</td>
            <td><b style="color:blue;">'.format_cash($menhgia).'</b></td>
            </tr>
            <tr>
            <td>SERI:</td>
            <td><b>'.$seri.'</b></td>
            </tr>
            <tr>
            <td>PIN</td>
            <td><b>'.$pin.'</b></td>
            </tr>
            <tr>
            <td>Username</td>
            <td><b style="color:red;">'.$my_username.'</b></td>
            </tr>
            </tbody>
            </table>
            <a href="'.$_SERVER['HTTP_HOST'].'/admin/card.php">TRUY CẬP PANEL ADMIN</a>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);  

            echo '<script type="text/javascript">swal("Thành Công","Thẻ của bạn đang được xử lý, vui lòng đợi","success");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        } else
        {
            echo '<script type="text/javascript">swal("Thất Bại", "Lỗi từ máy chủ, vui lòng liên hệ Admin !!!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            exit();
        }
        
    }
  
  }
 
?>
<div class="row">
    <div class="col-sm-5">
        <div class="boxbody_tbl" id="doithe">
            <div class="boxbody_top">
                <h2><span>ĐỔI THẺ THỦ CÔNG</span></h2>
            </div>
            <div class="boxbody_body">
                <form method="POST" action="">
                    <div class="form-body">
                        <div class="form-group">
                            <select class="form-control custom-select" name="type" id="loaithe" required="">
                                <option value="">Chọn loại thẻ *</option>
                                <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `setting_card` WHERE `status` = 'ON' ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                                <option value="<?=$row['type'];?>" data-price="<?=$row['ck'];?>"><?=$row['type'];?>
                                    (<?=$row['ck'];?>%)</option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group" ng-show="cardId>0">
                            <select class="form-control custom-select" name="menhgia" id="menhgia" required="">
                                <option value="">Chọn mệnh giá *</option>
                                <option value="10000">10.000 (<?=$ck_con;?>%)</option>
                                <option value="20000">20.000 (<?=$ck_con;?>%)</option>
                                <option value="30000">30.000 (<?=$ck_con;?>%)</option>
                                <option value="50000">50.000</option>
                                <option value="100000">100.000</option>
                                <option value="200000">200.000</option>
                                <option value="300000">300.000</option>
                                <option value="500000">500.000</option>
                                <option value="1000000">1.000.000</option>
                            </select>
                        </div>
                        <div class="form-group has-danger">
                            <input type="text" name="seri" class="form-control form-control-danger"
                                placeholder="Số Seri *" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" name="pin" class="form-control" placeholder="Mã thẻ *" required="">
                        </div>
                        <div class="form-group">
                            <p>Thực Nhận: <b style="color:red;" id="ketqua">0</b>đ</p>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit_doithe" class="btn btn-success text-white"> Nạp thẻ</button>
                    </div>

                </form>
                <hr><?=$site_luuy_doithe;?>

            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="boxbody_tbl">
            <div class="boxbody_top">
                <h2><span>CHIẾT KHẤU ĐỔI THẺ THỦ CÔNG</span></h2>
            </div>
            <div class="boxbody_body">
                <table class="table table-bordered table2">
                    <thead>
                        <tr>
                            <th><b>Loại thẻ</b></th>
                            <th><b>Biểu phí</b></th>
                            <th><b>Trạng thái</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `setting_card` ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                        <tr>
                            <td>
                                <?=$row['type'];?>
                            </td>
                            <td align="center">
                                <?=$row['ck'];?>%
                            </td>
                            <td align="center">
                                <?php if($row['status'] == 'ON'){?>
                                <label class="label label-success">Hoạt Động</label>
                                <?php } else { ?>
                                <label class="label label-danger">Bảo Trì</label>
                                <?php }?>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php 
    if(isset($_SESSION['username'])) {  ?>
    <div class="col-sm-12">
        <div class="boxbody_tbl">
            <div class="boxbody_top">
                <h2><span>LỊCH SỬ ĐỔI THẺ THỦ CÔNG</span></h2>
            </div>
            <div class="boxbody_body">
                <div class="table-responsive" style="margin-top:10px">
                    <table id="datatable1"
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
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 114px;"><b>Nhà
                                        mạng</b></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 178px;"><b>Thời
                                        gian</b></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 121px;"><b>Trạng
                                        Thái</b></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 78px;">Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `doithe` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                            <tr>
                                <td class="text-center"><?=$row['seri'];?></td>
                                <td class="text-center"><?=$row['pin'];?></td>
                                <td class="text-center"><?=format_cash($row['menhgia']);?>đ</td>
                                <td class="text-center">
                                    <span class="text-success" style="font-weight:bold"><?=$row['type'];?></span>
                                </td>
                                <td class="text-center">
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
                                <td class="text-center"><?=$row['note'];?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php }?>

</div>



</div>



<script>
$(document).ready(function() {
    setInterval(function() {
        $("#table_auto").load(window.location.href + " #table_auto");
    }, 3000);
});
</script>
<script type="text/javascript">
$('#loaithe').click(function() {
    var menhgia = $("#menhgia").val();
    var loaithe = $('#loaithe').children("option:selected").attr('data-price');
    console.log(loaithe);

    var ketqua = menhgia - menhgia * loaithe / 100;
    $('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
});

$('#menhgia').click(function() {
    var menhgia = $('#menhgia').val();
    var loaithe = $('#loaithe').children("option:selected").attr('data-price');
    if (menhgia >= 1000) {
        total = menhgia - menhgia * loaithe / 100;
        $('#ketqua').html(total.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
    }
});
</script>