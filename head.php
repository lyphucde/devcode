<?php include('config.php');?>
<?php 
$check_bug = random('QWERTYUIOPASDFGHJKLZXCVBNM123456789', '4');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="canonical" href="/" />
    <link rel="shortcut icon" href="<?=$site_favicon;?>" type="image/x-icon">
    <meta property="og:image" content="<?=$site_img;?>" />
    <meta name="description" content="<?=$site_mota;?>" />
    <meta name="keywords" content="<?=$site_keyword;?>">


    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap&subset=vietnamese,latin-ext"
        rel="stylesheet" />
    <link href="/css/multizoom.css" rel="stylesheet" />
    <link href="/css/css.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
    <script src="/js/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>


    <style type="text/css">
    .text-center {
        text-align: center;
    }

    #topbar {
        width: 100%;
        background: <?=$site_color;
        ?>;
        color: #fff
    }

    .boxbody_top span {
        display: block;
        padding: 12px 15px;
        font-size: 1.4rem;
        text-transform: uppercase;
        position: relative;
        font-weight: normal;
        background-color: <?=$site_color;?>;
        color: #fff
    }

    .btn-success {
        color: #fff;
        background-color: <?=$site_color;
        ?> !important;
        border-color: #ffffff !important;
    }

    .button {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 5px;
        font-size: 1.2rem;
        color: #fff !important;
        border: none;
        background: <?=$site_color;
        ?>;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        cursor: pointer
    }

    .home-title:after {
        content: "";
        height: 2px;
        width: 60px;
        position: absolute;
        margin: auto;
        bottom: -10px;
        left: 0;
        right: 0;
        background: <?=$site_color;
        ?>
    }

    .boxbody_tbl {
        margin: 20px 0 10px;
        width: 100%;
        text-align: left;
        background: #fff;
        -webkit-box-shadow: 8px 8px 6px 1px rgba(0, 0, 0, .15);
        -moz-box-shadow: 0 0 5px 0 rgba(0, 0, 0, .15);
        box-shadow: 8px 8px 6px 1px rgba(0, 0, 0, .15);
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 5px;
        overflow: hidden
    }
    </style>

    <style>
    html,
    body {
        cursor: url("/upload/mouse.png"), progress;
    }

    a:hover {
        cursor: url("/upload/mouse1.png"), progress;
    }

    .btn:hover {
        cursor: url("/upload/mouse1.png"), progress;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
}
 
::-webkit-scrollbar-thumb {
    background: <?=$site['site_color'];?>;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}

    .btn-primary {
        color: #fff;
        background-color: <?=$site['site_color'];?>;
        border-color: <?=$site['site_color'];
        ?>;
    }

    </style>
</head>

<body>
    <div class="pageloader"></div>
    <div id="wrapper">
        <div id="slideads"></div>
        <div id="topbar">
            <div class="container">
                <div id="hotline"><i class="fas fa-phone"></i>Hotline: <a
                        href="tel:<?=$site_hotline;?>"><?=$site_hotline;?></a></div>
                <?php if (!isset($_SESSION['username'])) { ?>
                <div id="user-area">
                    <ul>
                        <li>
                            <a type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#dangky_<?=$check_bug;?>"><i class="fas fa-user-plus"></i> ĐĂNG KÝ</a>
                        </li>
                        <li>
                            <a type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#dangnhap_<?=$check_bug;?>"><i class="fas fa-user-lock"></i> ĐĂNG NHẬP</a>
                        </li>
                    </ul>
                </div>
                <?php } else { ?>
                <div id="user-area">
                    <span class="user">
                        <a href="#"><i class="fas fa-user"></i> <?=$my_username;?> (<span
                                id="auto_vnd"><?=format_cash($my_vnd);?>đ</span>) <i
                                class="fa fa-angle-down"></i></a><br />

                        <div class="dropdown-content">
                            <?php if ($my_level == 'admin') { ?>
                            <a href="/admin/">
                                <i class="fa fas fa-check-square"></i> PANEL ADMIN
                            </a>
                            <?php }?>
                            <a href="/thong-tin/">
                                <i class="fa fas fa-user-circle"></i> THÔNG TIN TÀI KHOẢN
                            </a>
                            <a href="/rut-tien/">
                                <i class=" fa fa-money">
                                </i> RÚT TIỀN
                            </a>
                            <a href="/thong-tin/">
                                <i class="fa fas fa-unlock-alt"></i>
                                ĐỔI MẬT KHẨU
                            </a>
                            <a href="/dang-xuat/">
                                <i class="fa fa-sign-out-alt"></i>
                                ĐĂNG XUẤT
                            </a>

                        </div>
                    </span>
                </div>
                <?php }?>

            </div>
        </div>
        <div id="header" class="fixed">
            <div class="container">
                <div id="logo">
                    <a href="/">
                        <img src="<?=$site_logo;?>" />
                    </a>
                </div>

                <div id="menu">
                    <div id="nav-toggle">
                        <div id="menu-button"><a href="javascript:void(0);"
                                onclick="$('#menuchinh').css('left','0');$('#closemenu').css('left','0');$('#logo').css('z-index','0');"><i
                                    class="fa fa-bars" aria-hidden="true"></i></a></div>
                    </div>
                    <div id="closemenu"
                        onclick="$('#menuchinh').removeAttr('style');$('#closemenu').css('left','-350px');$('#logo').removeAttr('style');">
                        <i class="fas fa-times-circle"></i> Ẩn Menu
                    </div>
                    <div id="menuchinh" class="ddsmoothmenu">
                        <ul>
                            <li><a href="/home/" class="selected"><span><img src="/img/home.png" /></span><i
                                        class="fa fa-home" aria-hidden="true"></i> HOME</a></li>
                            <li><a href="/rut-tien/"><span><img src="/img/bank.png" /></span><i class="fa fa-university"
                                        aria-hidden="true"></i> RÚT TIỀN</a></li>
                            <li><a href="/api/"><span><img src="/img/api.png" /></span><i class="fa fa-code"
                                        aria-hidden="true"></i> API</a></li>
                            <li><a href="/mua-the/"><span><img src="/img/mua-the.png" /></span><i
                                        class="fa fa-shopping-cart" aria-hidden="true"></i> MUA THẺ</a></li>
                            <li><a href="/donate/<?=$my_username;?>"><span><img src="/img/gift.png" /></span><i
                                        class="fa fa-gift" aria-hidden="true"></i> DONATE</a></li>
                            <li><a href="/nap-dien-thoai/"><span><img src="/img/phone.png" /></span><i
                                        class="fa fa-mobile" aria-hidden="true"></i> NẠP ĐT</a></li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>







        <!-- The Modal -->
        <div class="modal" id="dangky_<?=$check_bug;?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">ĐĂNG KÝ TÀI KHOẢN</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        <form action="" method="post">
                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="U_UserName">Số điện thoại <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-md-9">
                                        <input class="form-control text-box single-line" data-val="true"
                                            data-val-regex="Không đúng định dạng số điện thoại"
                                            data-val-regex-pattern="^[0-9]{6,20}"
                                            data-val-required="Tài khoản không được để trống" id="U_UserName"
                                            name="username" placeholder="Nhập số điện thoại" type="text" value=""
                                            required="" />
                                        <span class="field-validation-valid text-danger" data-valmsg-for="U_UserName"
                                            data-valmsg-replace="true"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="U_UserName">Mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-md-9">
                                        <input class="form-control text-box single-line password" data-val="true"
                                            data-val-length="Mật khẩu phải từ 6 đến 20 ký tự" data-val-length-max="20"
                                            data-val-length-min="6" data-val-required="Password không được để trống"
                                            id="U_Password" name="matkhau" placeholder="Nhập mật khẩu" type="password"
                                            required="" />
                                        <span class="field-validation-valid text-danger" data-valmsg-for="U_Password"
                                            data-valmsg-replace="true"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3" for="U_UserName">Nhập lại mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-md-9">
                                        <input class="form-control text-box single-line password" data-val="true"
                                            data-val-equalto="Mật khẩu với xác nhận mật khẩu không trùng khớp"
                                            data-val-equalto-other="*.U_Password"
                                            data-val-required="Nhập lại password không được để trống"
                                            id="U_RewritePassword" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu"
                                            type="password" required="" />
                                        <span class="field-validation-valid text-danger"
                                            data-valmsg-for="U_RewritePassword" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="U_UserName">Email <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-md-9">
                                        <input class="form-control text-box single-line"
                                            data-val-email="Không đúng định dạng email" id="U_Email" name="email"
                                            placeholder="Nhập email" type="email" value="" required="" />
                                        <span class="field-validation-valid text-danger" data-valmsg-for="U_Email"
                                            data-valmsg-replace="true"></span>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-9">
                                        <input type="submit" name="btn_dangky" value="Đăng ký" class="button" />
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>

                </div>
            </div>
        </div>


        <!-- The Modal -->
        <div class="modal" id="dangnhap_<?=$check_bug;?>">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">ĐĂNG NHẬP</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-horizontal">

                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="U_UserName">Số điện thoại <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control text-box single-line" data-val="true"
                                            data-val-required="Tài khoản không thể để trống" id="U_UserName"
                                            name="username" placeholder="Số điện thoại" required="required" type="text"
                                            value="" />
                                        <span class="field-validation-valid text-danger" data-valmsg-for="U_UserName"
                                            data-valmsg-replace="true"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="U_UserName">Mật khẩu <span
                                            class="text-danger">(*)</span></label>
                                    <div class="col-sm-8">
                                        <input class="form-control text-box single-line password" data-val="true"
                                            data-val-required="Mật khẩu không thể để trống" id="U_Password"
                                            name="password" placeholder="Nhập mật khẩu" required="required"
                                            type="password" />
                                        <span class="field-validation-valid text-danger" data-valmsg-for="U_Password"
                                            data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-8">
                                        <input type="submit" name="dangnhap" value="Đăng nhập"
                                            class="button" /><br /><br />
                                        <a class="forgotpass" href="/quen-mat-khau/"><i class="fas fa-lock-open"></i>
                                            Quên mật khẩu</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>

                </div>
            </div>
        </div>

        <br>






        <?php
    if (isset($_POST["btn_dangky"]))
    {
        
        $username = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['username']))));
        $matkhau = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['matkhau']))));
        $email = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['email']))));
        $nhaplaimatkhau = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['nhaplaimatkhau']))));
        $nhaplaimatkhau = md5($nhaplaimatkhau);
        $matkhau = md5($matkhau);
        $sdt_length = strlen($username);
        $code = random('QWERTYUIOPASDFGHJKLZXCVBNM', '12');
        $token = random('qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM', '32');
        $biensosanh = str_replace(" ", "", $username);
        $checktaikhoan = mysqli_query($ketnoi,"select * from account where username= '$username' ");
        $checkmail = mysqli_query($ketnoi,"select * from account where mail= '$email' ");
        $check_ip = mysqli_query($ketnoi,"select * from account where ip = '$ip_address' ");

        if($sdt_length >= 12 || $sdt_length <= 8)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Độ dài số điện thoại không phù hợp!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            die();
        }
        else if(mysqli_num_rows($checktaikhoan)  > 0)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Số điện thoại này đã tồn tại trong hệ thống", "error");</script>';
        }
        else if(mysqli_num_rows($check_ip)  > 5)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " IP này đã đạt giới hạn tạo tài khoản!", "error");</script>';
        }
        else if(mysqli_num_rows($checkmail)  > 0)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Email đã tồn tại trên hệ thống", "error");</script>';
        }
        else if($username != $biensosanh)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Không được chứa khoản trắng", "error");</script>';
        }
        else if ($matkhau != $nhaplaimatkhau)
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Nhập lại mật khẩu không đúng", "error");</script>';
        }
        else
        {
            $create = $ketnoi->query("INSERT INTO `account` SET 
            `password` = '".$matkhau."',
            `username` = '".$username."',
            `code` = '".$code."',
            `VND` = '0',
            `mail` = '".$email."',
            `ip` = '".$ip_address."',
            `createdate` = now() ");
            $_SESSION['username'] = $username;
            
            if($create)
            {
                $ketnoi->query("INSERT INTO `logs` SET 
                `content` = 'Đăng ký tài khoản IP (".$ip_address.").',
                `username` = '".$username."',
                `createdate` = now() ");
                echo '<script type="text/javascript">swal("Thành Công","Đăng ký tài khoản thành công","success");setTimeout(function(){ location.href = "" },1000);</script>';
                exit();
            }
            else
            {
                echo '<script type="text/javascript">swal("Thất Bại","Lỗi máy chủ","error");setTimeout(function(){ location.href = "" },2000);</script>';
            }

        }    
    }

?>


        <?php

if (isset($_POST["dangnhap"]))
{
    $username = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['username']))));
    $password = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['password']))));
    $password = md5($password);
    if ($username == "" || $password =="") 
    {
        echo '<script type="text/javascript">swal("Thất Bại", " Không được để trống tên đăng nhập hoặc mật khẩu", "error");
        setTimeout(function(){ location.href = "" },2000);</script>';
        die();
    }
    else
    {
        $sql = "select * from account where username = '$username' and password = '$password' ";
        $query = mysqli_query($ketnoi,$sql);
        $num_rows = mysqli_num_rows($query);

        if ($num_rows == 0) 
        {
            echo '<script type="text/javascript">swal("Thất Bại", " Thông tin đăng nhập không chính xác !!!", "error");
            setTimeout(function(){ location.href = "" },2000);</script>';
            die();
        }
        else
        {
            $_SESSION['username'] = $username;
            $ketnoi->query("UPDATE `users` SET ip =  '".$ip_address."', `updatedate` = now() WHERE `username` = '".$username."'");
            $ketnoi->query("INSERT INTO `logs` SET 
            `content` = 'Đăng nhập vào hệ thống IP (".$ip_address.").',
            `username` = '".$username."',
            `createdate` = now() ");
            echo '<script type="text/javascript">swal("Thành Công","Đăng Nhập Thành Công","success");
                setTimeout(function(){ location.href = "" },1000);</script>';
            exit();
        }
    }
}

if ($site_baotri == 'ON')
{
    echo '<script type="text/javascript">swal("THÔNG BÁO","Hệ thông đang bảo trì, vui lòng quay lại sau!","warning");</script>';
    die(); 
}
if(isset($_SESSION['username']))
{  
    if($my_banned == '1')
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Tài khoản của bạn đang bị khóa!", "error");
                setTimeout(function(){ location.href = "/dang-xuat/" },2000);</script>';
        exit();
    }
}

?>



        <script>
        $(document).ready(function() {
            setInterval(function() {
                $("#auto_vnd").load(window.location.href + " #auto_vnd");
            }, 3000);
        });
        </script>