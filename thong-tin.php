<?php include('head.php');?>

<title>THÔNG TIN | <?=$site_tenweb;?></title>

<div class="container">
    <div class="home-title">
        <span class="color3">THÔNG TIN TÀI KHOẢN</span>
    </div>
    <?php
if(!isset($_SESSION['username']))
{
    echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
    setTimeout(function(){ location.href = "/" },1000);</script>';
    die;
}
?>

    <div class="boxbody_tbl">
        <div class="boxbody_top clearfix"><span>
                <h1 class="uppercase">Quản lý thông tin</h1>
            </span></div>
        <div class="boxbody_body">

            <form action="" method="post">
                <p style="color:green"></p>
                <table cellpadding="5" cellspacing="0" width="100%" style="border:1px solid #e2e2e2;" border="1">
                    <tbody>
                        <tr bgcolor="#f0f0f0">
                            <td colspan="2" class="t"><b>Thông tin </b></td>
                        </tr>
                        <tr bgcolor="#f8f8f8">
                            <td class="l">Điện thoại</td>
                            <td>
                                <input class="form-control" readonly="readonly" style="width:100%;display:inline"
                                    type="text" value="<?=$my_username;?>" />
                            </td>
                        </tr>
                        <tr>
                            <td class="l">Email </td>
                            <td>
                                <input class="form-control form-control-inline" readonly="readonly" style="width:100%"
                                    type="text" value="<?=$my_mail;?>" />

                            </td>
                        </tr>
                        <tr>
                            <td class="l">Ngày Đăng Ký </td>
                            <td>
                                <input class="form-control form-control-inline" readonly="readonly" style="width:100%"
                                    type="text" value="<?=$my_createdate;?>" />

                            </td>
                        </tr>
                        <tr>
                            <td class="l">Lần Cuối Đăng Nhập </td>
                            <td>
                                <input class="form-control form-control-inline" readonly="readonly" style="width:100%"
                                    type="text" value="<?=$my_updatedate;?>" />

                            </td>
                        </tr>
                        <tr>
                            <td class="l">Số Dư Ví </td>
                            <td>
                                <b style="color:green;"><?=format_cash($my_vnd);?>đ</b>

                            </td>
                        </tr>
                        <tr bgcolor="#f8f8f8">
                            <td class="l">Mật khẩu mới</td>
                            <td>
                                <input class="form-control" name="newpassword" style="width:100%" type="password" />

                            </td>
                        </tr>
                        <tr>
                            <td class="l">Mật khẩu hiện tại </td>
                            <td>
                                <input class="form-control text-box single-line" name="password" style="width:100%"
                                    type="password" required="" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p align="center"><button class="button button-noicon" type="submit" name="capnhat_info">CẬP
                        NHẬT</button></p>
            </form>

        </div>
    </div>


    <div class="boxbody_tbl">
        <div class="boxbody_top">
            <h2><span>NHẬT KÝ HOẠT ĐỘNG</span></h2>
        </div>
        <div class="boxbody_body">
            <div class="table-responsive" style="margin-top:10px">
                <table id="datatable1"
                    class="table table-hover table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline"
                    style="width: 100%;" role="grid">
                    <thead>
                        <tr role="row">
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 5%;"><b>STT</b></th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 75%;"><b>NỘI DUNG</b>
                            </th>
                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 20%;"><b>THỜI GIAN</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
$result = mysqli_query($ketnoi,"SELECT * FROM `logs` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 1000");
$i = 0;
while($row = mysqli_fetch_assoc($result))
{
?>
                        <tr>
                            <td class="text-center"><?=$i;?></td>
                            <td> <?=$row['content'];?></td>

                            <td class="text-center"><b><?=$row['createdate'];?></b></td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="clear"></div>



<?php
if (isset($_POST["capnhat_info"])) 
{
  $newpassword = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['newpassword']))));
  $password = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['password']))));
  $fullname = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['fullname']))));
  $get_password = mysqli_fetch_assoc(mysqli_query($ketnoi,"SELECT `password` FROM `account` WHERE `username` = '".$_SESSION['username']."'"))['password'];

  $newpassword = md5($newpassword);
  $password = md5($password);

  if(!isset($_SESSION['username']))
  {
    echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
    setTimeout(function(){ location.href = "" },1000);</script>';
    die;
  }
  else if ($password != $get_password) 
  {
    echo '<script type="text/javascript">swal("Lỗi", " Mật khẩu cũ không chính xác", "error");</script>';
  }
  else 
  {
    $create = mysqli_query($ketnoi,"UPDATE account SET 
      password =  '".$newpassword."'
      WHERE username = '".$_SESSION['username']."'");

    $create = $ketnoi->query("INSERT INTO `logs` SET 
        `content` = 'Thay đổi thông tin tài khoản IP (".$ip_address."). ',
        `username` =  '".$my_username."',
        `createdate` =  now() ");

    if ($create)
    {
      echo '<script type="text/javascript">swal("Thành Công","Thay đổi đã được lưu!","success");
      setTimeout(function(){ location.href = "" },2000);</script>';
    }
    else
    {
      echo '<script type="text/javascript">swal("Lỗi","Lỗi máy chủ","error");
      setTimeout(function(){ location.href = "" },2000);</script>';
    }
    
  } 
}
?>


<?php include('foot.php');?>