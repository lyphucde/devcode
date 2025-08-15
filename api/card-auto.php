
<?php 
require_once('../config.php');

if (isset($_GET['auto']))
{
    if ( $_GET['auto'] == true && isset($_GET['type']) && isset($_GET['menhgia']) && isset($_GET['seri']) && isset($_GET['pin']) && isset($_GET['APIKey']) && isset($_GET['callback']) )
    {
        $type = check_string($_GET['type']);
        $menhgia = check_string($_GET['menhgia']);
        $seri = check_string($_GET['seri']);
        $pin = check_string($_GET['pin']);
        $APIKey = check_string($_GET['APIKey']);
        $content = check_string($_GET['content']);
        $callback = trim($_GET['callback']);
        $code = random('qwertyuiopasdfghklzxcvbnm1234567890',12);
        $IsFast = 'true';
        if ($type == 'Viettel'){
            $ck = $cardvip_vt;
        }
        if ($type == 'Vinaphone'){
            $ck = $cardvip_vina;
        }
        if ($type == 'Mobifone'){
            $ck = $cardvip_mobi;
        }
        if ($type == 'Zing'){
            $ck = $cardvip_zing;
        }
        if ($type == 'Vietnamobile'){
            $ck = $cardvip_viet;
        }
        if ($menhgia <= '30000'){
            $ck = $ck + $ck_con;
        }
        $thucnhan = $menhgia - $menhgia * $ck / 100;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partner.cardvip.vn/api/createExchange",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n    \"APIKey\": \"$apikey\",\n    \"NetworkCode\": \"$type\",\n    \"PricesExchange\": \"$menhgia\",\n    \"NumberCard\": \"$pin\",\n    \"SeriCard\": \"$seri\",\n    \"IsFast\": \"$IsFast\",\n    \"RequestId\": \"$code\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $jdecode = json_decode($response);

        if ($jdecode->status == 100)
        {
            $data['data'] = [
            "status"=>'error',
            "msg"=>'Nhập thiếu dữ liệu !'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($jdecode->status == 400)
        {
            $data['data'] = [
            "status"=>'error',
            "msg"=>'Mã thẻ đã tồn tại !'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($jdecode->status == 401)
        {
            $data['data'] = [
            "status"=>'error',
            "msg"=>'Mệnh giá hoặc mã nhà mạng không tồn tại !'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($jdecode->status == 500)
        {
            $data['data'] = [
            "status"=>'error',
            "msg"=>'Hệ thống bảo trì, vui lòng đợi !'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($jdecode->status == 403)
        {
            $data['data'] = [
            "status"=>'error',
            "msg"=>'Lỗi hệ thống !'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
        if ($jdecode->status == 200)
        {
            $user = $ketnoi->query("SELECT * FROM account WHERE APIKey = '$APIKey' ")->fetch_array();
            $create = $ketnoi->query("INSERT INTO `doithe_auto` SET 
                `username` = '".$user['username']."',
                `type` = '".$type."',
                `code` = '".$code."',
                `seri` = '".$seri."',
                `mess` = '".$content."',
                `pin` = '".$pin."',
                `callback` = '".$callback."',
                `menhgia` = '".$menhgia."',
                `thucnhan` = '".$thucnhan."',
                `status` = 'xuly',
                `createdate` = now() ");
            $data['data'] = [
            "status"=>'success',
            "msg"=>'Gửi thẻ thành công, vui lòng đợi kết quả'];
            die(json_encode($data, JSON_PRETTY_PRINT));
        }
    }
    else
    {
        $data['data'] = [
        "status"=>'error',
        "msg"=>'Vui lòng nhập đầy đủ thông tin !'];
        die(json_encode($data, JSON_PRETTY_PRINT));
    }
}
else
{
    $data['data'] = [
    "status"=>'error',
    "msg"=>'Vui lòng không SPAM !'];
    die(json_encode($data, JSON_PRETTY_PRINT));
}
?>