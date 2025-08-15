<?php include('head.php');?>

<title>MUA THẺ | <?=$site_tenweb;?></title>

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
    <span class="color3">MUA THẺ CÀO</span>
</div>
<?php
if (isset($_POST["muathe"])) 
{
    $loaithe = check_string($_POST['loaithe']);
    $menhgia = check_string($_POST['menhgia']);
    $password = check_string($_POST['password']);   
    $email = check_string($_POST['email']);    
    $code = random('QWERTYUIOPASDFGHJKLZXCVBNM123456790', '6');

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
    else if ($status_muathe == 'OFF')
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Chức năng đang được bảo trì, vui lòng đợi!", "warning");</script>';
    }
    elseif ($password == '')
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Định dạng mật khẩu không hợp lệ", "error");</script>';
    }
    elseif ($email == '')
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Định dạng Email không hợp lệ", "error");</script>';
    }
    else if ($num_rows == 0) 
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Mật khẩu không chính xác", "error");</script>';
    }
    else if($menhgia < '10000')
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Mệnh giá không hợp lệ!", "error");</script>';
    }
    else if($menhgia > '1000000')
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Mệnh giá không hợp lệ!", "error");</script>';
    }
    else if($menhgia > $my_vnd)
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Số dư của bạn không có nhiều như vậy!!!", "error");</script>';

    }
    else 
    {
        

        $create = $ketnoi->query("INSERT INTO `logs` SET 
        `content` = ' ".format_cash($my_vnd)." - ".format_cash($menhgia)." = ".format_cash(pheptru($my_vnd, $menhgia))." lý do: Mua Thẻ ".$loaithe." IP(".$ip_address."). ',
        `username` =  '".$my_username."',
        `createdate` =  now() ");

        $create = $ketnoi->query("UPDATE `account` SET `VND` = `VND` - '$menhgia' WHERE `username`= '".$_SESSION['username']."' ");

        $create = $ketnoi->query("INSERT INTO `muathe` SET
        `username` =  '".$my_username."',
        `loaithe` = '".$loaithe."',
        `menhgia` = '".$menhgia."',
        `money` = '".$menhgia."',
        `email` = '".$email."',
        `code` = '".$code."',
        `status` = 'xuly',
        `createdate` = now() ");
        

        if($create)
        {
            $cookie = $site_cookie;
            $idNguoiNhan = $site_idfb;
            $noiDungTinNhan = '[SYSTEM] Có Đơn Mua Thẻ Cần Xử Lý';
            $idAnh = '';
            senInboxCSM($cookie, $noiDungTinNhan, $idAnh, $idNguoiNhan);

            $guitoi = $site_gmail;   
            $subject = 'THÔNG BÁO CÓ ĐƠN MUA THẺ ĐANG ĐỢI XỬ LÝ';
            $bcc = $site_tenweb;
            $hoten ='Client';
            $noi_dung = '<h2>Thông tin đơn hàng</h2>
            <table >
            <tbody>
            <tr>
            <td>Loại Thẻ:</td>
            <td><b>'.$loaithe.'</b></td>
            </tr>
            <tr>
            <td>Mệnh Giá:</td>
            <td><b style="color:blue;">'.format_cash($menhgia).'</b></td>
            </tr>
            <tr>
            <td>Username</td>
            <td><b style="color:red;">'.$my_username.'</b></td>
            </tr>
            </tbody>
            </table>
            <a href="'.$_SERVER['HTTP_HOST'].'/admin/mua-the.php">TRUY CẬP PANEL ADMIN</a>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);


            echo '<script type="text/javascript">swal("Thành Công","Mua thẻ thành công, vui lòng đợi duyệt!","success");
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
                    <div class="boxbody_top"><h2><span>MUA THẺ </span></h2></div>
                    <div class="boxbody_body">
                        <form id="form-add-card">
                            <div class="form-body">
                                <div class="form-group" ng-show="cardId>0">
                                    <select class="form-control custom-select" name="loaithe" required="">
                                    <option value="">Chọn loại thẻ *</option>
                                    <option value="Viettel">Viettel</option> 
                                    <option value="Vinaphone">Vinaphone</option>
                                    <option value="Mobifone">Mobifone</option>
                                    <option value="Zing">Zing</option>
                                    <option value="Vietnamobile">Vietnamobile</option>
                                    <option value="Gate">Gate</option>
                                    <option value="Garena">Garena</option>
                                    <option value="Vcoin">Vcoin</option>
                                    <option value="Gosu">Gosu</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-control custom-select" name="menhgia" id="menhgia" required="">
                                        <option value="">Chọn mệnh giá *</option>
                                        <option value="10000">10.000</option>
                                        <option value="20000">20.000</option>
                                        <option value="30000">30.000</option>
                                        <option value="50000">50.000</option>
                                        <option value="100000">100.000</option>
                                        <option value="200000">200.000</option>
                                        <option value="300000">300.000</option>
                                        <option value="500000">500.000</option>
                                        <option value="1000000">1.000.000</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" value="<?=$my_mail;?>" placeholder="Email nhận thông tin thẻ" required="">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Xác nhận mật khẩu" required="">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="muathe" class="btn btn-success text-white"> THANH TOÁN</button>
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
                           <ul>
                               <li>Thông tin thẻ cào sẽ được gửi vào Email sau khi duyệt Hoàn Tất.</li><br>
                               <li>Quý khách có thể tùy chỉnh Email nhận thông tin thẻ vào ô phía tay trái.</li><br>
                               <li>Mua thẻ được xử lý trong vài phút.</li><br>
                               <li>Để tăng tính bảo mật, chúng tôi cần bạn nhập mật khẩu để tiến hành Thanh Toán.</li><br>
                           </ul>
                    </div>
                </div>
            </div>

<div class="col-sm-12">
    <div class="boxbody_tbl" >
        <div class="boxbody_top">
            <h2><span>LỊCH SỬ MUA THẺ</span></h2>
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
                                    <b>LOẠI THẺ</b>
                                </th>
                                <th>
                                    <b>MỆNH GIÁ</b>
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
                                <th>
                                    <b>THAO TÁC</b>
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                                        <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `muathe` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 20");
while($row = mysqli_fetch_assoc($result))
{
?>
                            <tr>
                                <td class="text-center"><?=$row['code'];?></td>
                                <td class="text-center"><?=$row['loaithe'];?></td>
                                <td class="text-center"><?=format_cash($row['menhgia']);?></td>
                                <td class="text-center"><?=format_cash($row['money']);?></td>
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
                                <td class="text-center"><?=$row['note'];?></td>
                                <td class="text-center"><a type="button" class="btn btn-info" data-toggle="modal" data-target="#xem_<?=$row['code'];?>"><i class="fa fa-eye" aria-hidden="true"></i>
 XEM</a></td>
                            </tr>


<!-- The Modal -->
<div class="modal" id="xem_<?=$row['code'];?>">
<div class="modal-dialog">
  <div class="modal-content">
  
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Thông Tin Đơn Hàng #<?=$row['code'];?></h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">

<div class="form-horizontal">

    <div class="form-group">
    <label class="control-label col-md-3" for="U_UserName">Loại Thẻ</label>
        <div class="col-md-9">
            <input class="form-control text-box single-line" type="text" value="<?=$row['loaithe'];?>" readonly>
        </div>
    </div>
    <div class="form-group">
    <label class="control-label col-md-3" for="U_UserName">Mệnh Giá</label>
        <div class="col-md-9">
            <input class="form-control text-box single-line" type="text" value="<?=format_cash($row['menhgia']);?>" readonly>
        </div>
    </div>
    <div class="form-group">
    <label class="control-label col-md-3" for="U_UserName">Seri</label>
        <div class="col-md-9">
            <input class="form-control text-box single-line" type="text" value="<?=$row['seri'];?>" readonly>
        </div>
    </div>
    <div class="form-group">
    <label class="control-label col-md-3" for="U_UserName">Pin</label>
        <div class="col-md-9">
            <input class="form-control text-box single-line" type="text" value="<?=$row['pin'];?>" readonly>
        </div>
    </div>

</div>


    </div>
    
    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
    </div>
    
  </div>
</div>
</div>
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
$(document).ready(function(){
setInterval(function(){
      $("#table_auto").load(window.location.href + " #table_auto" );
}, 4000);
});
</script>
<?php include('foot.php');?>