<?php include('head.php');?>

<?php
if (isset($_GET['id']))
{
    $id = check_string($_GET['id']);
}
?>
<title>DONATE | <?=$site_tenweb;?></title>




<div class="container">
    <!--OPEN container-->

    <div class="home-title">
        <span class="color3">LINK DONATE</span>
    </div>
    <div class="alert-home">
        <ul>
            <li>Nạp thẻ không cần đăng nhập.</li>
            <li>Tốc độ xử lý thẻ trong vài giây.</li>
        </ul>
    </div>

    <?php
if (isset($_POST["submit_auto"])) 
{


    $request_id = random('QWERTYUIOPASDFGHJKLZXCVBNM','12');
    $seri = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['seri'])))); // string
    $pin = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['pin'])))); // string

    $menhgia = check_string($_POST['menhgia']);
    $loaithe = check_string($_POST['loaithe']);
    $mess = check_string($_POST['mess']);

    $IsFast = 'true';
    if ($loaithe == 'Viettel')
    {
        $ck = $cardvip_vt;
    }
    if ($loaithe == 'Vinaphone')
    {
        $ck = $cardvip_vina;
    }
    if ($loaithe == 'Mobifone')
    {
        $ck = $cardvip_mobi;
    }
    if ($loaithe == 'Zing')
    {
        $ck = $cardvip_zing;
    }
    if ($loaithe == 'Vietnamobile')
    {
        $ck = $cardvip_viet;
    }
    if ($loaithe == 'Gate')
    {
        $ck = $cardvip_gate;
        $IsFast = 'false';
    }
    if ($loaithe == 'Garena')
    {
        $ck = $cardvip_garena;
        $IsFast = 'false';
    }
    if ($menhgia <= '30000')
    {
        $ck = $ck + $ck_con;
    }

    $thucnhan = $menhgia - $menhgia * $ck / 100;



    $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://apidaily.cardvip.vn/api/createExchange",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n    \"APIKey\": \"$apikey\",\n    \"NetworkCode\": \"$loaithe\",\n    \"PricesExchange\": \"$menhgia\",\n    \"NumberCard\": \"$pin\",\n    \"SeriCard\": \"$seri\",\n    \"IsFast\": \"$IsFast\",\n    \"RequestId\": \"$request_id\"\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    
    $jdecode = json_decode($response);

    if ($status_auto == 'OFF')
    {
        echo '<script type="text/javascript">swal("Thất Bại", "Chức năng đang được bảo trì, vui lòng đợi!", "warning");</script>';
    }
    else if ($jdecode->status == 200)
    {
        $create = $ketnoi->query("INSERT INTO `doithe_auto` SET 
        `username` = '".$id."',
        `type` = '".$loaithe."',
        `code` = '".$request_id."',
        `seri` = '".$seri."',
        `pin` = '".$pin."',
        `menhgia` = '".$menhgia."',
        `thucnhan` = '".$thucnhan."',
        `status` = 'xuly',
        `createdate` = now() ");
        if($create)
        {
            echo '<script type="text/javascript">swal("Thành Công", "Gửi thẻ thành công, vui lòng đợi!","success");
              setTimeout(function(){ location.href = "" },1000);</script>';
        }
        else
        {
            echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng thao tác lại hoặc báo cáo QTV", "error");</script>';
        } 
    }
    else if ($jdecode->status == 100)
    {
        echo '<script type="text/javascript">swal("Lỗi", " Nhập thiếu dữ liệu", "error");</script>';
    }
    else if ($jdecode->status == 400)
    {
        echo '<script type="text/javascript">swal("Lỗi", " Mã thẻ đã tồn tại", "error");</script>';
    }
    else if ($jdecode->status == 401)
    {
        echo '<script type="text/javascript">swal("Lỗi", "  Mệnh giá hoặc mã nhà mạng không tồn tại", "error");</script>';
    }
    else if ($jdecode->status == 500)
    {
        echo '<script type="text/javascript">swal("Thông Báo", " Hệ thống bảo trì, vui lòng đợi!", "warning");</script>';
    }
    else if ($jdecode->status == 403)
    {
        echo '<script type="text/javascript">swal("Lỗi", " Lỗi hệ thống", "error");</script>';
    }
    else if ($jdecode->status == 300)
    {
        echo '<script type="text/javascript">swal("Lỗi", " API không tồn tại", "error");</script>';
    }
    else if ($jdecode->status == 301)
    {
        echo '<script type="text/javascript">swal("Lỗi", " API Key chưa được kích hoạt", "error");</script>';
    }
    else if ($jdecode->status == 302)
    {
        echo '<script type="text/javascript">swal("Lỗi", " API Key đã bị khóa", "error");</script>';
    }
    else
    {   
        echo '<script type="text/javascript">swal("Lỗi", " Lỗi API", "error");</script>';
    }
}
?>


    <div class="row">
        <!--START ROW-->

        <div class="col-sm-12">
            <div class="boxbody_tbl" id="doithe">
                <div class="boxbody_top">
                    <h2><span>NẠP TIỀN VÀO TÀI KHOẢN <b><?=$id;?></b></span></h2>
                </div>
                <div class="boxbody_body">
                    <form method="POST" action="">
                        <div class="form-body">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-danger"
                                    value="Tài khoản nhận tiền: <?=$id;?>" readonly>
                            </div>
                            <div class="form-group">
                                <select class="form-control custom-select" name="loaithe" id="loaithe" required="">
                                    <option value="">Chọn loại thẻ *</option>
                                    <option value="Viettel">Viettel Auto (<?=$cardvip_vt;?>%)</option>
                                    <option value="Vinaphone">Vinaphone Auto (<?=$cardvip_vina;?>%)</option>
                                    <option value="Mobifone">Mobifone Auto (<?=$cardvip_mobi;?>%)</option>
                                    <option value="Zing">Zing Auto (<?=$cardvip_zing;?>%)</option>
                                    <option value="Vietnamobile">Vietnamobile Auto (<?=$cardvip_viet;?>%)</option>
                                    <option value="Gate">Gate Chậm (<?=$cardvip_gate;?>%)</option>
                                    <option value="Garena">Garena Chậm (<?=$cardvip_garena;?>%)</option>
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
                            <div class="form-group">
                                <input type="text" name="seri" class="form-control form-control-danger"
                                    placeholder="Số Seri *" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" name="pin" class="form-control" placeholder="Mã thẻ *" required="">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="mess"
                                    placeholder="Lời nhắn đến người nhận"></textarea>
                            </div>
                            <div class="form-group">
                                <p>Thực Nhận: <b style="color:red;" id="ketqua">0</b>đ</p>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" name="submit_auto" class="btn btn-success text-white btn-block"> Nạp
                                thẻ</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>




    </div>
    <!--END ROW-->




</div>
<!--END container-->
















<script>
$(document).ready(function() {
    setInterval(function() {
        $("#table_auto").load(window.location.href + " #table_auto");
    }, 3000);
});
</script>

<script type="text/javascript">
$('#menhgia').click(function() {
    var menhgia = $("#menhgia ").val();
    var loaithe = $("#loaithe ").val();

    if (loaithe == 'Viettel') {
        var ck = <?=$cardvip_vt;?>;
    }
    if (loaithe == 'Mobifone') {
        var ck = <?=$cardvip_mobi;?>;
    }
    if (loaithe == 'Vinaphone') {
        var ck = <?=$cardvip_vina;?>;
    }
    if (loaithe == 'Vietnamobile') {
        var ck = <?=$cardvip_viet;?>;
    }
    if (loaithe == 'Zing') {
        var ck = <?=$cardvip_zing;?>;
    }
    if (loaithe == 'Gate') {
        var ck = <?=$cardvip_gate;?>;
    }
    if (loaithe == 'Garena') {
        var ck = <?=$cardvip_garena;?>;
    }
    if (menhgia <= 30000) {
        var ck = ck + <?=$ck_con;?>;
    }
    var ketqua = menhgia - menhgia * ck / 100;
    $('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
});
$('#loaithe').click(function() {
    var menhgia = $("#menhgia ").val();
    var loaithe = $("#loaithe ").val();

    if (loaithe == 'Viettel') {
        var ck = <?=$cardvip_vt;?>;
    }
    if (loaithe == 'Mobifone') {
        var ck = <?=$cardvip_mobi;?>;
    }
    if (loaithe == 'Vinaphone') {
        var ck = <?=$cardvip_vina;?>;
    }
    if (loaithe == 'Vietnamobile') {
        var ck = <?=$cardvip_viet;?>;
    }
    if (loaithe == 'Zing') {
        var ck = <?=$cardvip_zing;?>;
    }
    if (loaithe == 'Gate') {
        var ck = <?=$cardvip_gate;?>;
    }
    if (loaithe == 'Garena') {
        var ck = <?=$cardvip_garena;?>;
    }
    if (menhgia <= 30000) {
        var ck = ck + 5;
    }
    var ketqua = menhgia - menhgia * ck / 100;
    $('#ketqua').html(ketqua.toString().replace(/(.)(?=(\d{3})+$)/g, '$1,'));
});
</script>



<?php include('foot.php');?>