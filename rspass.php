<?php include('head.php');?>

<title>RESET MẬT KHẨU | <?=$site_tenweb;?></title>
<?php
if(isset($_SESSION['username']))
{
    echo '<script type="text/javascript">swal("Thất Bại", "", "error");
    setTimeout(function(){ location.href = "/" },1000);</script>';
    die;
}
?>

<?php
if(isset($_GET["id"]))
{
  $id = check_string($_GET['id']);
  $query = $ketnoi->query("select * from account where token = '".$id."' ");
  $check_token = mysqli_num_rows($query);
  if ($check_token == 0) 
  {
    echo '<script type="text/javascript">swal("Thất Bại","Liên kết không tồn tại!","error");
      setTimeout(function(){ location.href = "/" },2000);</script>';
  }
}

if (isset($_POST["submit"]))
{
  $password = check_string($_POST['password']);
  $repassword = check_string($_POST['repassword']);

  $password = md5($password);
  $repassword = md5($repassword);

  $get_username = mysqli_fetch_assoc(mysqli_query($ketnoi, "SELECT `username` FROM `account` WHERE `token` = '".$id."'  ")) ['username'];

  $query = $ketnoi->query("select * from account where token = '".$id."' ");
  $check_token = mysqli_num_rows($query);

  if ($check_token == 0) 
  {
      echo '<script type="text/javascript">swal("Thất Bại", " Liên kết không tồn tại!", "error");</script>';
  }
  else if ($password == "" || $repassword == "") 
  {
      echo '<script type="text/javascript">swal("Thất Bại", " Vui lòng điền vào ô dưới!", "error");</script>';
  }
  else if ($password != $repassword) 
  {
      echo '<script type="text/javascript">swal("Thất Bại", " Nhập lại mật khẩu không đúng!", "error");</script>';
  }
  else
  {
    $create = $ketnoi->query("INSERT INTO `logs` SET 
    `content` = 'Khôi phục lại mật khẩu IP (".$ip_address."). ',
    `username` =  '".$get_username."',
    `createdate` =  now() ");
    $ketnoi->query("UPDATE account SET 
    password =  '".$password."' WHERE token = '".$id."' ");
    echo '<script type="text/javascript">swal("Thành Công","Cập nhật mật khẩu thành công!","success");
    setTimeout(function(){ location.href = "/" },1000);</script>';
  }
}

?> 

<div class="container">
<div class="home-title">
      <span class="color3">THAY ĐỔI MẬT KHẨU</span>
</div>
<div class="row">
<div class="col-sm-12" style="padding: 100px;">
<form method="POST" action="">
    <div class="boxbody_tbl">
        <div class="boxbody_top">
          <h2><span>THAY ĐỔI MẬT KHẨU </span></h2>
        </div>
        <div class="boxbody_body">
            
                <div class="form-group">
                  <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới" required="">
                </div>
                <div class="form-group">
                  <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu mới" required="">
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