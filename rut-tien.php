<?php include('head.php');?>

<title>RÚT TIỀN | <?=$site_tenweb;?></title>

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
        <span class="color3">RÚT TIỀN</span>
    </div>
    <?php
if (isset($_POST["ruttien"])) 
{
    $chi_nhanh = check_string($_POST['chi_nhanh']);
    $money = check_string($_POST['money']);
    $stk = check_string($_POST['stk']);
    $chu_tai_khoan = check_string($_POST['chu_tai_khoan']);
    $ngan_hang = check_string($_POST['ngan_hang']);
    $password = check_string($_POST['password']);
    $permitted_chars = 'QWERTYUIOPASDFGHJKLZXCVBNM';        
    $code = substr(str_shuffle($permitted_chars), 0, 10);

    $password = md5($password);


    $sql = "select * from account where username = '$my_username' and password = '$password' ";
    $query = mysqli_query($ketnoi,$sql);
    $num_rows = mysqli_num_rows($query);
    

    if(!isset($_SESSION['username']))
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
                setTimeout(function(){ location.href = "" },1000);</script>';
        exit();
    }
    else if ($num_rows == 0) 
    {
        echo '<script type="text/javascript">swal("Lỗi", " Mật khẩu không chính xác", "error");
                setTimeout(function(){ location.href = "" },1000);</script>';
        exit();
    }
    else if($ngan_hang == 'MOMO' && $money < $site_min_momo)
    {
        echo '<div class="alert-home">Số tiền rút về MOMO tối thiểu <b style="color=red;">'.format_cash($site_min_momo).'đ</b></div>';
        echo '<script type="text/javascript">swal("Thất Bại", "Số tiền rút về ví MOMO không hợp lệ", "error");</script>';
    }
    else if($ngan_hang != 'MOMO' && $money < $site_min_bank)
    {
        echo '<div class="alert-home">Số tiền rút về Bank tối thiểu <b style="color=red;">'.format_cash($site_min_bank).'đ</b></div>';
        echo '<script type="text/javascript">swal("Thất Bại", "Số tiền rút về Bank không hợp lệ", "error");</script>';
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
        `content` = '".format_cash($my_vnd)." - ".format_cash($money)." = ".format_cash(pheptru($my_vnd, $money))." lý do: Rút Tiền IP(".$ip_address."). ',
        `username` =  '".$my_username."',
        `createdate` =  now() ");

        $create = $ketnoi->query("UPDATE `account` SET `VND` = `VND` - '$money' WHERE `username`= '".$_SESSION['username']."' ");


        $create = $ketnoi->query("INSERT INTO `ruttien` SET
        `username` =  '".$my_username."',
        `ngan_hang` = '".$ngan_hang."',
        `stk` = '".$stk."',
        `chi_nhanh` = '".$chi_nhanh."',
        `chu_tai_khoan` = '".$chu_tai_khoan."',
        `money` = '".$money."',
        `code` = '".$code."',
        `status` = 'xuly',
        `createdate` = now() ");
        

        if($create)
        {
            $cookie = $site_cookie;
            $idNguoiNhan = $site_idfb;
            $noiDungTinNhan = '[SYSTEM] Có Đơn Rút Tiền Cần Xử Lý';
            $idAnh = '';
            senInboxCSM($cookie, $noiDungTinNhan, $idAnh, $idNguoiNhan);

            $guitoi = $site_gmail;   
            $subject = 'THÔNG BÁO CÓ ĐƠN RÚT TIỀN ĐANG XỬ LÝ';
            $bcc = $site_tenweb;
            $hoten ='Client';
            $noi_dung = '<h2>Thông tin tài khoản rút tiền</h2>
            <table >
            <tbody>
            <tr>
            <td>Ngân Hàng:</td>
            <td><b>'.$ngan_hang.'</b></td>
            </tr>
            <tr>
            <td>Số Tài Khoản:</td>
            <td><b style="color:blue;">'.$stk.'</b></td>
            </tr>
            <tr>
            <td>Chủ Tài Khoản:</td>
            <td><b>'.$chu_tai_khoan.'</b></td>
            </tr>
            <tr>
            <td>Số Tiền Rút</td>
            <td><b>'.format_cash($money).'</b></td>
            </tr>
            <tr>
            <td>Nội Dung Rút:</td>
            <td><b>'.$chi_nhanh.'</b></td>
            </tr>
            <tr>
            <td>Username</td>
            <td><b style="color:red;">'.$my_username.'</b></td>
            </tr>
            </tbody>
            </table>
            <a href="'.$_SERVER['HTTP_HOST'].'/admin/rut-tien.php">TRUY CẬP PANEL ADMIN</a>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);


            echo '<script type="text/javascript">swal("Thành Công","Rút tiền thành công, vui lòng đợi duyệt!","success");
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
                    <div class="boxbody_top">
                        <h2><span>Rút tiền </span></h2>
                    </div>
                    <div class="boxbody_body">
                        <form id="form-add-card">
                            <div class="form-body">
                                <div class="form-group" ng-show="cardId>0">
                                    <select class="form-control custom-select" name="ngan_hang" required="">
                                        <option value="">Chọn ngân hàng</option>
                                        <option value="MOMO">MOMO</option>
                                        <option value="VTPAY">VIETTEL PAY</option>
                                        <option value="VIETINBANK">VIETINBANK</option>
                                        <option value="VIETCOMBANK">VIETCOMBANK</option>
                                        <option value="AGRIBANK">AGRIBANK</option>
                                        <option value="TPBANK">TPBANK</option>
                                        <option value="HDB">HDB</option>
                                        <option value="VPBANK">VPBANK</option>
                                        <option value="MBBANK">MBBANK</option>
                                        <option value="OCEANBANK">OCEANBANK</option>
                                        <option value="BIDV">BIDV</option>
                                        <option value="SACOMBANK">SACOMBANK</option>
                                        <option value="ACB">ACB</option>
                                        <option value="ABBANK">ABBANK</option>
                                        <option value="NCB">NCB</option>
                                        <option value="IBK">IBK</option>
                                        <option value="CIMB">CIMB</option>
                                        <option value="EXIMBANK">EXIMBANK</option>
                                        <option value="SEABANK">SEABANK</option>
                                        <option value="SCB">SCB</option>
                                        <option value="DONGABANK">DONGABANK</option>
                                        <option value="SAIGONBANK">SAIGONBANK</option>
                                        <option value="PG BANK">PG BANK</option>
                                        <option value="PVCOMBANK">PVCOMBANK</option>
                                        <option value="KIENLONGBANK">KIENLONGBANK</option>
                                        <option value="VIETCAPITAL BANK">VIETCAPITAL BANK</option>
                                        <option value="OCB">OCB</option>
                                        <option value="MSB">MSB</option>
                                        <option value="SHB">SHB</option>
                                        <option value="VIETBANK">VIETBANK</option>
                                        <option value="VRB">VRB</option>
                                        <option value="NAMABANK">NAMABANK</option>
                                        <option value="SHBVN">SHBVN</option>
                                        <option value="VIB">VIB</option>
                                        <option value="TECHCOMBANK">TECHCOMBANK</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="stk" class="form-control" placeholder="Số tài khoản"
                                        required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="chu_tai_khoan" class="form-control"
                                        placeholder="Tên chủ thẻ" required="">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="chi_nhanh" class="form-control"
                                        placeholder="Nội dung chuyển tiền">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="money" class="form-control" placeholder="Số tiền cần rút"
                                        required="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Xác nhận mật khẩu" required="">
                                </div>
                            </div>

                            <div class="form-actions">

                                <button type="submit" name="ruttien" class="btn btn-success text-white"> RÚT
                                    TIỀN</button>
                            </div>

                        </form>


                    </div>
                </div>
            </form>
        </div>

        <div class="col-sm-6">
            <div class="boxbody_tbl">
                <div class="boxbody_top">
                    <h2><span>Lưu Ý</span></h2>
                </div>
                <div class="boxbody_body">
                    <?=$site_luuy_ruttien;?>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="boxbody_tbl">
                <div class="boxbody_top">
                    <h2><span>LỊCH SỬ RÚT TIỀN</span></h2>
                </div>
                <div class="boxbody_body">
                    <div class="table-responsive" style="margin-top:10px">
                        <table id="datatable1"
                            class="table table-hover table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="width: 100%;" role="grid">
                            <thead>
                                <tr role="row">
                                    <th>
                                        <b>STT</b>
                                    </th>
                                    <th>
                                        <b>MÃ GD</b>
                                    </th>
                                    <th>
                                        <b>NGÂN HÀNG</b>
                                    </th>
                                    <th>
                                        <b>STK</b>
                                    </th>
                                    <th>
                                        <b>CHỦ TK</b>
                                    </th>
                                    <th>
                                        <b>NỘI DUNG</b>
                                    </th>
                                    <th>
                                        <b>SỐ TIỀN</b>
                                    </th>
                                    <th>
                                        <b>THỜI GIAN</b>
                                    </th>
                                    <th>
                                        <b>TRẠNG THÁI</b>
                                    </th>
                                    <th>
                                        <b>GHI CHÚ</b>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
$result = mysqli_query($ketnoi,"SELECT * FROM `ruttien` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                                <tr>
                                    <td class="text-center"><?=$i++;?></td>
                                    <td class="text-center"><?=$row['code'];?></td>
                                    <td class="text-center"><?=$row['ngan_hang'];?></td>
                                    <td class="text-center"><?=$row['stk'];?></td>
                                    <td class="text-center"><?=$row['chu_tai_khoan'];?></td>
                                    <td class="text-center"><?=$row['chi_nhanh'];?></td>
                                    <td class="text-center"><?=format_cash($row['money']);?>đ</td>
                                    <td class="text-center"><?=$row['createdate'];?></td>
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
<script>
$(document).ready(function() {
    setInterval(function() {
        $("#table_auto").load(window.location.href + " #table_auto");
    }, 4000);
});
</script>
<?php include('foot.php');?>