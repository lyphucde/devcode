<?php 
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once('SMTP/class.smtp.php');
include_once('SMTP/PHPMailerAutoload.php');
include_once('SMTP/class.phpmailer.php');

$site_domain = 'http://localhost/'; // Link Website
$DATABASE = 'card24h';
$USERNAME = 'root';
$PASSWORD = '';
$LOCALHOST = 'localhost';




define("DATABASE", $DATABASE);////////////////////////////////////////////////
define("USERNAME", $USERNAME);///////////////N/T/T/H/A/N/H////////////////////
define("PASSWORD", $PASSWORD);////////////////////////////////////////////////
define("LOCALHOST", $LOCALHOST);//////////////////////////////////////////////
$ketnoi = mysqli_connect(LOCALHOST,USERNAME,PASSWORD,DATABASE);
mysqli_query($ketnoi,"set names 'utf8'");




if(isset($_SESSION['username']))
{  
    $query_user = $ketnoi->query("SELECT * FROM `account` WHERE `username` = '".$_SESSION['username']."'  ");
    $user = $query_user->fetch_array();
    if($query_user->num_rows == 0)
    {
        session_start();
        session_destroy();
        header('location: /');
    }
	$my_username = $user['username'];
    $my_vnd = $user['VND'];
    $my_fullname = $user['fullname'];
    $my_mail = $user['mail'];
    $my_password = $user['password'];
    $my_banned = $user['banned'];
    $my_level = $user['level'];
    $my_token = $user['token'];
    $my_createdate = $user['createdate'];
    $my_updatedate = $user['updatedate'];

    if ($user['VND'] < 0)
    {
        $ketnoi->query("UPDATE `account` SET `banned` = 1 WHERE `username` = '".$user['username']."' ");
        session_start();
        session_destroy();
        header('location: /');
    }
}

$query_site = $ketnoi->query("SELECT * FROM `settings` WHERE `id` = '0' ");
$site = $query_site->fetch_array();
$site_tenweb = $site['tenweb'];
$site_mota = $site['mota'];
$site_cookie = $site['cookie'];
$site_keyword = $site['tukhoa'];
$site_thongbao = $site['thongbao'];
$site_baotri = $site['baotri'];
$site_idfb = $site['idfb'];
$site_hotline = $site['site_hotline'];
$site_luuy_doithe = $site['site_luuy_doithe'];
$site_luuy_ruttien = $site['site_luuy_ruttien'];
$site_pass_email = $site['site_pass_email'];
$site_gmail = $site['site_gmail'];
$site_livechat = $site['site_livechat'];
$cardvip_vt = $site['cardvip_vt'];
$cardvip_mobi = $site['cardvip_mobi'];
$cardvip_vina = $site['cardvip_vina'];
$cardvip_viet = $site['cardvip_viet'];
$cardvip_zing = $site['cardvip_zing'];
$cardvip_gate = $site['cardvip_gate'];
$cardvip_garena = $site['cardvip_garena'];
$ck_con = $site['ck_con'];
$apikey = $site['apikey'];
$site_img = $site['site_img'];
$site_favicon = $site['site_favicon'];
$site_logo = $site['site_logo'];
$site_color = $site['site_color'];
$site_min_bank = $site['site_min_bank'];
$site_min_momo = $site['site_min_momo'];
$ck_napdt_vt = $site['ck_napdt_vt'];
$ck_napdt_mobi = $site['ck_napdt_mobi'];
$ck_napdt_vina = $site['ck_napdt_vina'];
$status_napdt = $site['status_napdt'];
$note_napdt = $site['note_napdt'];
$status_auto = $site['status_auto'];
$status_muathe = $site['status_muathe'];
$status_cham = $site['status_cham'];
$site_diachi = $site['site_diachi'];
$site_fanpage = $site['site_fanpage'];


function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    
    curl_close($ch);
    return $data;
}

function display($data)
{
    if ($data == 'hide')
    {
        $show = '<span class="badge bg-danger">ẨN</span>';
    }
    else if ($data == 'show')
    {
        $show = '<span class="badge bg-success">HIỂN THỊ</span>';
    }
    return $show;
}
function pheptru($int1, $int2)
{
    return $int1 - $int2;
}
function phepcong($int1, $int2)
{
    return $int1 + $int2;
}
function phepnhan($int1, $int2)
{
    return $int1 * $int2;
}
function phepchia($int1, $int2)
{
    return $int1 / $int2;
}
function random($string, $int)
{
    $chars = $string;  
    $data = substr(str_shuffle($chars), 0, $int);
    return $data;
}
function check_img($img)
{
    $filename = $_FILES[$img]['name'];
    $ext = explode(".", $filename);
    $ext = end($ext);
    $valid_ext = array("png","jpeg","jpg","PNG","JPEG","JPG","gif","GIF");
    if(in_array($ext, $valid_ext))
    {
        return true;
    }
}
function status($data)
{
    if ($data == 'xuly')
    {
        $show = '<span class="badge badge-info">Đang xử lý</span>';
    }
    else if ($data == 'hoantat')
    {
        $show = '<span class="badge badge-success">Hoàn tất</span>';
    }
    else if ($data == 'thatbai')
    {
        $show = '<span class="badge badge-danger">Thất bại</span>';
    }
    else
    {
        $show = '<span class="badge badge-warning">Khác</span>';
    }
    return $show;
}
function check_string($data)
{
    return str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($data))));

}

if (!empty($_SERVER['HTTP_CLIENT_IP']))     
{  
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];  
}  
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))    
{  
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];  
}  
else  
{  
    $ip_address = $_SERVER['REMOTE_ADDR'];  
}

function format_cash($price) {
    return str_replace(",", ".", number_format($price));
}

function sendCSM($mail_nhan,$ten_nhan,$chu_de,$noi_dung,$bcc)
{
        // PHPMailer Modify
        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail ->Debugoutput = "html";
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'systemcard24h@gmail.com'; // GMAIL STMP
        $mail->Password = 'none'; // PASS STMP
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('systemcard24h@gmail.com', $bcc);
        $mail->addAddress($mail_nhan, $ten_nhan);
        $mail->addReplyTo('systemcard24h@gmail.com', $bcc);
        $mail->isHTML(true);
        $mail->Subject = $chu_de;
        $mail->Body    = $noi_dung;
        $mail->CharSet = 'UTF-8';
        $send = $mail->send();
        return $send;
}


// inbox facebook
set_time_limit(0);
function curl_post($url, $method, $postinfo, $cookie_file_path) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
    curl_setopt($ch,CURLOPT_COOKIEFILE, $cookie_file_path);
    curl_setopt($ch, CURLOPT_USERAGENT,
        "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    if ($method=='POST') 
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
    }
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}
function convertTokenToCookie($token) {
    $html = json_decode(file_get_contents("https://api.facebook.com/method/auth.getSessionforApp?access_token=$token&format=json&new_app_id=350685531728&generate_session_cookies=1"), true);
    $cookie = $html['session_cookies'][0]['name']."=".$html['session_cookies'][0]['value'].";".$html['session_cookies'][1]['name']."=".$html['session_cookies'][1]['value'].";".$html['session_cookies'][2]['name']."=".$html['session_cookies'][2]['value'].";".$html['session_cookies'][3]['name']."=".$html['session_cookies'][3]['value'];
    return $cookie;
}
function senInboxCSM($cookie, $noiDungTinNhan, $idAnh, $idNguoiNhan) {

//lấy id người gửi
    preg_match("/c_user=([0-9]+);/", $cookie, $idNguoiGui);
    $idNguoiGui = $idNguoiGui[1];

//lấy dtsg
    $html =  curl_post('https://m.facebook.com', 'GET' , "" , $cookie);
    $re = "/<input type=\"hidden\" name=\"fb_dtsg\" value=\"(.*?)\" autocomplete=\"off\" \\/>/"; 
    preg_match($re, $html, $dtsg);
    $dtsg = $dtsg[1];


//tách chuỗi thành vòng lặp, lấy từng người nhận ra
    $ex = explode("|", $idNguoiNhan);
    foreach ($ex as $idNguoiNhan) {
    // echo ".$idNguoiNhan.";


    //lấy tids
        $html1 = curl_post("https://m.facebook.com/messages/read/?fbid=$idNguoiNhan&_rdr",'GET','', $cookie);
        $re = "/tids=(.*?)\&/"; 
        preg_match($re, $html1, $tid);
        if (isset($tid[1])) {
        $tid=urldecode($tid[1]);  //encode mã tids lại
        $data = array("fb_dtsg" => "$dtsg",
            "body" => "$noiDungTinNhan",
            "send" => "Gá»­i",
            "photo_ids[$idanh]" => "$idAnh",
            "tids" => "$tid",
            "referrer" => "",
            "ctype" => "",
            "cver" => "legacy");
    } else {
        $data = array("fb_dtsg" => "$dtsg",
            "body" => "$noiDungTinNhan",
            "Send" => "Gá»­i",
            "ids[0]" => "$idNguoiNhan",
            "photo" => "",
            "waterfall_source" => "message");
    }

    //Gửi tin nhắn
    $html = curl_post('https://m.facebook.com/messages/send/?icm=1&refid=12', 'POST', http_build_query($data), $cookie);
    $re = preg_match("/send_success/", $html, $rep); //bắt kết quả trả về
    if (isset($rep[0])) {
        return true;
        ob_flush();
        flush();
    } else {
        return false;
        ob_flush();
        flush();
    }
}
}


?>