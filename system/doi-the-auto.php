<div class="home-title">
    <span class="color3">ĐỔI THẺ TỰ ĐỘNG</span>
</div>

<?php
if (isset($_POST["submit_auto"])) 
{
    if(isset($_SESSION['username']))
    {
        $permitted_chars = 'QWERTYUIOPASDFGHJKLZXCVBNM';  
        $request_id = substr(str_shuffle($permitted_chars), 0, 12);
        $seri = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['seri'])))); // string
        $pin = str_replace(array('<',"'",'>','?','/',"\\",'--','eval(','<php'),array('','','','','','','','',''),htmlspecialchars(addslashes(strip_tags($_POST['pin'])))); // string

        $menhgia = check_string($_POST['menhgia']);
        $loaithe = check_string($_POST['loaithe']);
        
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
        if ($menhgia <= '30000')
        {
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
            `username` = '".$my_username."',
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
            echo '<script type="text/javascript">swal("Lỗi", "'.$jdecode->message.'", "error");</script>';
        }

    }
    else
    {
      echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng đăng nhập để tiếp tục", "error");
          setTimeout(function(){ location.href = "" },2000);</script>';
      session_destroy();
      die();
    }

}
?>


<div class="row">
    <!--START ROW-->

    <div class="col-sm-6">
        <div class="boxbody_tbl" id="doithe">
            <div class="boxbody_top">
                <h2><span>Đổi thẻ cào thành tiền mặt Tự động</span></h2>
            </div>
            <div class="boxbody_body">
                <form method="POST" action="">
                    <div class="form-body">
                        <div class="form-group">
                            <select class="form-control custom-select" name="loaithe" id="loaithe" required="">
                                <option value="">Chọn loại thẻ *</option>
                                <option value="Viettel">Viettel Auto (<?=$cardvip_vt;?>%)</option>
                                <option value="Vinaphone">Vinaphone Auto (<?=$cardvip_vina;?>%)</option>
                                <option value="Mobifone">Mobifone Auto (<?=$cardvip_mobi;?>%)</option>
                                <option value="Zing">Zing Auto (<?=$cardvip_zing;?>%)</option>
                                <option value="Vietnamobile">Vietnamobile Auto (<?=$cardvip_viet;?>%)</option>
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
                            <p>Thực Nhận: <b style="color:red;" id="ketqua">0</b>đ</p>
                        </div>

                    </div>

                    <div class="form-actions">

                        <button type="submit" name="submit_auto" class="btn btn-success text-white"> Nạp thẻ</button>
                    </div>
                    <hr>

                </form>

                <?=$site_luuy_doithe;?>

            </div>
        </div>
    </div>


    <div class="col-sm-6">
        <div class="boxbody_tbl">
            <div class="boxbody_top">
                <h2><span>CHIẾT KHẤU ĐỔI THẺ AUTO</span></h2>
            </div>
            <div class="boxbody_body">
                <table class="table table-bordered table2">
                    <thead>
                        <tr>
                            <th><b>LOẠI THẺ</b></th>
                            <th><b>PHÍ</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>VIETTEL</td>
                            <td align="center"><?=$cardvip_vt;?>%</td>
                        </tr>
                        <tr>
                            <td>VINANPHONE</td>
                            <td align="center"><?=$cardvip_vina;?>%</td>
                        </tr>
                        <tr>
                            <td>MOBIFONE</td>
                            <td align="center"><?=$cardvip_mobi;?>%</td>
                        </tr>
                        <tr>
                            <td>ZING</td>
                            <td align="center"><?=$cardvip_zing;?>%</td>
                        </tr>
                        <tr>
                            <td>VIETNAMOBILE</td>
                            <td align="center"><?=$cardvip_viet;?>%</td>
                        </tr>
                        <tr>
                            <td>GATE</td>
                            <td align="center"><?=$cardvip_gate;?>%</td>
                        </tr>
                        <tr>
                            <td>GARENA</td>
                            <td align="center"><?=$cardvip_garena;?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?php 
    if(isset($_SESSION['username'])) {  ?>
    <div class="col-sm-12">
        <div class="boxbody_tbl">
            <div class="boxbody_top">
                <h2><span> LỊCH SỬ ĐỔI THẺ AUTO</span> </h2>
            </div>
            <div class="boxbody_body">
                <div class="table-responsive">
                    <table id="datatable1"
                        class="table table-hover table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline"
                        style="width: 100%;" role="grid">
                        <thead>
                            <tr class="text-center">
                                <th><b>STT</b></th>
                                <th><b>Serial</b></th>
                                <th><b>Pin</b></th>
                                <th><b>Mệnh giá</b></th>
                                <th><b>Thực nhận</b></th>
                                <th><b>Nhà mạng</b></th>
                                <th><b>Thời gian</b></th>
                                <th><b>Trạng Thái</b></th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    $i = 0;
    $result = $ketnoi->query("SELECT * FROM `doithe_auto` WHERE `username` = '".$my_username."' ORDER BY id desc limit 0, 20");
    while($row = mysqli_fetch_assoc($result))
    {
    ?>
                            <tr>
                                <td class="text-center"><?=$i;?> <?php $i++;?></td>
                                <td class="text-center copy" id="copySeri<?=$row['id'];?>" data-clipboard-target="#copySeri<?=$row['id'];?>"><?=$row['seri'];?></td>
                                <td class="text-center copy" id="copyPin<?=$row['id'];?>" data-clipboard-target="#copyPin<?=$row['id'];?>"><?=$row['pin'];?></td>
                                <td class="text-center"><?=format_cash($row['menhgia']);?>đ</td>
                                <td class="text-center"><?=format_cash($row['thucnhan']);?>đ</td>
                                <td class="text-center">
                                    <span class="text-success" style="font-weight:bold"><?=$row['type'];?></span>
                                </td>
                                <td class="text-center">
                                    <?=$row['createdate'];?>
                                </td>
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
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php }?>

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