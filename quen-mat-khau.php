<?php include('head.php');?>

<title>QUÊN MẬT KHẨU | <?=$site_tenweb;?></title>
<?php
if(isset($_SESSION['username']))
{
    echo '<script type="text/javascript">swal("Thất Bại", "", "error");
    setTimeout(function(){ location.href = "/" },1000);</script>';
    die;
}
?>
<?php
if (isset($_POST["submit"]))
{
  $mail = check_string($_POST['mail']);
  $get_username = $ketnoi->query("SELECT `username` FROM `account` WHERE `mail` = '".$mail."'  ")->fetch_array()['username'];
  $get_token = $ketnoi->query("SELECT `token` FROM `account` WHERE `mail` = '".$mail."'  ")->fetch_array()['token'];

  if ($mail == "") 
  {
      echo '<script type="text/javascript">swal("Thất Bại", " Không được để trống", "error");</script>';
  }
  else
  {
      $sql = "select * from account where mail = '".$mail."' ";
      $query = mysqli_query($ketnoi,$sql);
      $num_rows = mysqli_num_rows($query);
      
      if ($num_rows == 0) 
      {
          echo '<script type="text/javascript">swal("Thất Bại", " Email không tồn tại", "error");</script>';
      }
      else
      {  
        $guitoi = $mail;   
        $subject = 'XÁC NHẬN KHÔI PHỤC MẬT KHẨU';
        $bcc = $site_tenweb;
        $hoten ='Client';
        $noi_dung = '<h3>Có ai đó vừa yêu cầu khôi phục lại mật khẩu bằng Email này, nếu là bạn vui lòng nhấn vào liên kết dưới đây để xác minh</h3>
        <table >
        <tbody>
        <tr>
        <td>Tài Khoản:</td>
        <td><b>'.$get_username.'</b></td>
        </tr>
        <tr>
        <td>Liên Kết Xác Minh:</td>
        <td><b style="color:blue;"><a href="'.$_SERVER['HTTP_HOST'].'/reset-password/'.$get_token.'">'.$_SERVER['HTTP_HOST'].'/reset-password/'.$get_token.'</a></b></td>
        </tr>
        </tbody>
        </table>';
        sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);   
        echo '<script type="text/javascript">swal("Thành Công","Vui lòng kiểm tra hòm thư email của bạn!","success");
        setTimeout(function(){ location.href = "" },1000);</script>';

      }
  }
}

?>

<div class="container">
    <div class="home-title">
        <span class="color3">TÌM LẠI MẬT KHẨU</span>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding: 100px;">
            <form method="POST" action="">
                <div class="boxbody_tbl">
                    <div class="boxbody_top">
                        <h2><span>XÁC MINH EMAIL TÀI KHOẢN </span></h2>
                    </div>
                    <div class="boxbody_body">

                        <div class="form-group">
                            <input type="text" name="mail" class="form-control"
                                placeholder="Nhập Email khôi phục mật khẩu" required="">
                        </div>

                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-success text-white"> Xác Nhận</button>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('foot.php');?>