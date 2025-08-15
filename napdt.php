<?php include('head.php');?>

<title>NẠP ĐIỆN THOẠI | <?=$site_tenweb;?></title>

<?php
if(!isset($_SESSION['username']))
{
    echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
    setTimeout(function(){ location.href = "/" },1000);</script>';
    die;
}

?>
<div class="container">
<div class="home-title">
    <span class="color3">NẠP ĐIỆN THOẠI</span>
</div>
<?php
if (isset($_POST["napdt"])) 
{

    $loaithe = check_string($_POST['loaithe']);
    $sdt = check_string($_POST['sdt']);
    $passmy = check_string($_POST['passmy']);
    $menhgia = check_string($_POST['menhgia']);
    $password = check_string($_POST['password']);
    $code = random('QWERTYUIOPASDFGHJKLZXCVBNM0123456789', '6');
    $sdt_length = strlen($sdt);
    $password = md5($password);

    if ($loaithe == 'Viettel') { $ck = $ck_napdt_vt; }
    if ($loaithe == 'Vinaphone') { $ck = $ck_napdt_vina; }
    if ($loaithe == 'Mobifone') { $ck = $ck_napdt_mobi; }
    
    $money = $menhgia - $menhgia * $ck / 100;

    $sql = "select * from account where username = '$my_username' and password = '$password' ";
    $query = mysqli_query($ketnoi,$sql);
    $num_rows = mysqli_num_rows($query);
    

    if(!isset($_SESSION['username']))
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
                setTimeout(function(){ location.href = "" },1000);</script>';
        exit();
    }
    else if ($status_napdt == 'OFF')
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Chức năng đang được bảo trì, vui lòng đợi!", "warning");</script>';
    }
    else if ($sdt_length >= 12)
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Số điện thoại không hợp lệ!", "error");</script>';
    }
    else if ($num_rows == 0) 
    {
        echo '<script type="text/javascript">swal("Lỗi", " Mật khẩu không chính xác", "error");
                setTimeout(function(){ location.href = "" },1000);</script>';
        exit();
    }
    else if($money <= '0')
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Số tiền rút không hợp lệ", "error");</script>';
    }
    else if($money > $my_vnd)
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Số dư của bạn không có nhiều như vậy!!!", "error");</script>';
    }
    else 
    {
        $create = $ketnoi->query("INSERT INTO `logs` SET 
        `content` = '".format_cash($my_vnd)." - ".format_cash($money)." = ".format_cash(pheptru($my_vnd, $money))." lý do: Nạp Điện Thoại IP(".$ip_address."). ',
        `username` =  '".$my_username."',
        `createdate` =  now() ");

        $create = $ketnoi->query("UPDATE `account` SET `VND` = `VND` - '$money' WHERE `username`= '".$_SESSION['username']."' ");


        $create = $ketnoi->query("INSERT INTO `napdt` SET
        `username` =  '".$my_username."',
        `loaithe` = '".$loaithe."',
        `sdt` = '".$sdt."',
        `passmy` = '".$passmy."',
        `menhgia` = '".$menhgia."',
        `money` = '".$money."',
        `code` = '".$code."',
        `status` = 'xuly',
        `createdate` = now() ");
        

        if($create)
        {
            $cookie = $site_cookie;
            $idNguoiNhan = $site_idfb;
            $noiDungTinNhan = '[SYSTEM] Có Đơn Nạp Điện Thoại Cần Xử Lý';
            $idAnh = '';
            senInboxCSM($cookie, $noiDungTinNhan, $idAnh, $idNguoiNhan);

            $guitoi = $site_gmail;   
            $subject = 'THÔNG BÁO CÓ ĐƠN NẠP ĐIỆN THOẠI CẦN XỬ LÝ';
            $bcc = $site_tenweb;
            $hoten ='CLIENT';
            $noi_dung = '<h2>Đơn hàng #'.$code.'</h2>
            <table >
            <tbody>
            <tr>
            <td>Nhà Mạng:</td>
            <td><b>'.$loaithe.'</b></td>
            </tr>
            <td>Mệnh Giá Nạp:</td>
            <td><b>'.format_cash($money).'</b></td>
            </tr>
            <tr>
            <td>Số Điện Thoại Cần Nạp:</td>
            <td><b style="color:blue;">'.$sdt.'</b></td>
            </tr>
            <tr>
            <tr>
            <tr>Mật Khẩu MY:</td>
            <td><b>'.$passmy.'</b></td>
            </tr>
            <tr>
            <td>Username</td>
            <td><b style="color:red;">'.$my_username.'</b></td>
            </tr>
            </tbody>
            </table>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);


            echo '<script type="text/javascript">swal("Thành Công","Tạo đơn thành công, vui lòng đợi duyệt!","success");
                setTimeout(function(){ location.href = "" },1000);</script>';
            exit();
            
        }
        else
        {
            echo '<script type="text/javascript">swal("Thất Bại", "Lỗi máy chủ", "error");</script>';
            exit;
        }
        
    }
  }
 
?>


<div class="row">
<div class="col-sm-6">
    <form method="POST" action="">
                <div class="boxbody_tbl">
                    <div class="boxbody_top"><h2><span>THANH TOÁN CƯỚC ĐIỆN THOẠI</span></h2></div>
                    <div class="boxbody_body">
                        <form id="form-add-card">
                            <div class="form-body">
                                <div class="form-group" ng-show="cardId>0">
                                    <select class="form-control custom-select" name="loaithe" id="loaithe" required="">
                                    <option value="">Chọn nhà mạng*</option>
                                    <option value="Viettel" data-price="<?=$ck_napdt_vt;?>">Viettel (<?=$ck_napdt_vt;?>%)</option> 
                                    <option value="Vinaphone" data-price="<?=$ck_napdt_vina;?>">Vinaphone (<?=$ck_napdt_vina;?>%)</option>
                                    <option value="Mobifone" data-price="<?=$ck_napdt_mobi;?>">Mobifone (<?=$ck_napdt_mobi;?>%)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control custom-select" name="menhgia" id="menhgia" required="">
                                    <option value="">Chọn mệnh giá cần nạp *</option>
                                    <option value="50000">50.000</option>
                                    <option value="100000">100.000</option>
                                    <option value="200000">200.000</option>
                                    <option value="300000">300.000</option>
                                    <option value="400000">400.000</option>
                                    <option value="500000">500.000</option>
                                    <option value="600000">600.000</option>
                                    <option value="700000">700.000</option>
                                    <option value="800000">800.000</option>
                                    <option value="900000">900.000</option>
                                    <option value="1000000">1.000.000</option>
                                    <option value="2000000">2.000.000</option>
                                    <option value="3000000">3.000.000</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="sdt" class="form-control" placeholder="Nhập số điện thoại cần nạp" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="passmy" class="form-control" placeholder="Nhập mật khẩu MY" required="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Xác nhận mật khẩu" required="">
                                </div>
                                <div class="form-group">
                                    <p>Thanh Toán: <b style="color:red;" id="ketqua">0</b>đ</p>
                                </div>
                            </div>

                            <div class="form-actions">

                                <button type="submit" name="napdt" class="btn btn-success text-white"> TẠO ĐƠN</button>
                            </div>
                            
                        </form>

                        
                    </div>
                </div>
            </form>
            </div>

            <div class="col-sm-6">
                <div class="boxbody_tbl">
                    <div class="boxbody_top"><h2><span>Lưu Ý</span></h2></div>
                    <div class="boxbody_body">
                            <?=$note_napdt;?>
                    </div>
                </div>
            </div>

<div class="col-sm-12">
    <div class="boxbody_tbl" >
        <div class="boxbody_top">
            <h2><span>LỊCH SỬ NẠP ĐIỆN THOẠI</span></h2>
        </div>
        <div class="boxbody_body">
            <div class="table-responsive" style="margin-top:10px">
                    <table id="datatable1" class="table table-hover table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline" style="width: 100%;" role="grid">
                        <thead>
                            <tr role="row">
                                <th>
                                    <b>MÃ GD</b>
                                </th>
                                <th>
                                    <b>NHÀ MẠNG</b>
                                </th>
                                <th>
                                    <b>MỆNH GIÁ</b>
                                </th>
                                <th>
                                    <b>THANH TOÁN</b>
                                </th>
                                <th>
                                    <b>PASS MY</b>
                                </th>
                                <th>
                                    <b>SDT NẠP</b>
                                </th>
                                <th>
                                    <b>THỜI GIAN TẠO</b>
                                </th>
                                <th>
                                    <b>THỜI GIAN CẬP NHẬT</b>
                                </th>
                                <th>
                                    <b>STATUS</b>
                                </th>
                                <th>
                                    <b>GHI CHÚ</b>
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                        <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `napdt` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                            <tr>
                                <td class="text-center"><?=$row['code'];?></td>
                                <td class="text-center"><b style="color:green"><?=$row['loaithe'];?></b></td>
                                <td class="text-center"><b style="color:red"><?=format_cash($row['menhgia']);?>đ</b></td>
                                <td class="text-center"><b style="color:blue"><?=format_cash($row['money']);?>đ</b></td>
                                <td class="text-center"><i><?=$row['passmy'];?></i></td>
                                <td class="text-center"><b><?=$row['sdt'];?></b></td>
                                <td class="text-center"><?=$row['createdate'];?></td>
                                <td class="text-center"><?=$row['updatedate'];?></td>
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

<script type="text/javascript">
$('#loaithe').click(function()
{
    var menhgia = $("#menhgia").val();
    var loaithe = $('#loaithe').children("option:selected").attr('data-price');
    console.log(loaithe);
    
    var ketqua = menhgia - menhgia * loaithe / 100;
    $('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g,'$1,'));
});

$('#menhgia').click(function()
{
    var menhgia = $('#menhgia').val();
    var loaithe = $('#loaithe').children("option:selected").attr('data-price');
    if(menhgia >= 1000)
    {
        total = menhgia - menhgia * loaithe / 100 ;
        $('#ketqua').html(total.toString().replace(/(.)(?=(\d{3})+$)/g,'$1,'));
    }
});
</script>

<script> 
$(document).ready(function(){
setInterval(function(){
      $("#table_auto").load(window.location.href + " #table_auto" );
}, 12000);
});
</script>
<?php include('foot.php');?>