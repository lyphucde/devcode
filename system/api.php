<?php require_once('../head.php');?>
<title>API | <?=$site_tenweb;?></title>

<?php 
if (!isset($_SESSION["username"]))
{
    echo '<script type="text/javascript">setTimeout(function(){ location.href = "/" },0);</script>';
    die;
}
?>
<?php 
if ( isset($_POST['btnChangeApiKey']) && isset($_SESSION['username']) )
{
  $random_key = random('QWERTYUIOPASDFGHJKLZXCVBNM0123456789qwertyuiopasdfghjklzxcvbnm', 24);
  $create = $ketnoi->query("UPDATE account SET APIKey = '$random_key' WHERE username = '$my_username' ");
  if($create)
  {
    $ketnoi->query("INSERT INTO logs SET content = 'Thay đổi API KEY ', createdate = now(), username = '$my_username' ");
    echo '<script type="text/javascript">swal("Thành Công","Thay đổi API KEY thành công !","success");
    setTimeout(function(){ location.href = "" },1000);</script>';
    die;
  }
  else
  {
    echo '<script type="text/javascript">swal("Thất Bại", "Vui lòng liên hệ bộ phận kỹ thuật !", "error");
    setTimeout(function(){ location.href = "" },1000);</script>';
    die;
  }
}
?>


<div class="container">
    <div class="home-title">
        <span class="color3">TÀI LIỆU TÍCH HỢP API</span>
    </div>

    <div class="row">
        <!--START ROW-->
        <div class="col-sm-12">
            <div class="boxbody_tbl" id="doithe">
                <div class="boxbody_top">
                    <h2><span>CHUỖI KHÓA API CỦA BẠN</span></h2>
                </div>
                <div class="boxbody_body">
                    <h4>API KEY của bạn là: <span class="badge badge-info copy" id="copyApiToken"
                            data-clipboard-target="#copyApiToken"><?=$user['APIKey'];?></span></h4><br>
                    <i>Vui lòng không cung cấp khóa API cho người khác để tránh trường hợp kẻ gian chiếm đoạt tài
                        sản!</i>
                    <br><br>
                    <div class="form-group">
                        <button type="button" data-toggle="modal" data-target="#modalChangeApiKey"
                            class="btn btn-primary">Thay Đổi API KEY</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="boxbody_tbl" id="doithe">
                <div class="boxbody_top">
                    <h2><span>GỬI THẺ LÊN HỆ THỐNG</span></h2>
                </div>
                <div class="boxbody_body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phương thức GET:</label>
                                <input type="text" class="form-control copy"
                                    value="<?=$site_domain;?>api/card-auto.php?auto=true&type=Viettel&menhgia=10000&seri=10006139342354&pin=114384960423544&APIKey=<?=$user['APIKey'];?>&callback=http://localhost/callback.php&content=1233"
                                    id="copyPostCard" data-clipboard-target="#copyPostCard" readonly>
                            </div>
                            <div class="form-group">
                                <label>Trong đó:</label>
                                <h6><b style="color: blue;">type</b>: Viettel,Vinaphone,Mobifone,Zing,Vietnamobile.</h6>
                                <h6><b style="color: blue;">menhgia</b>: 10000,20000,30000,50000,100000,200000,300000,500000,1000000.</h6>
                                <h6><b style="color: blue;">seri</b>: Seri thẻ.</h6>
                                <h6><b style="color: blue;">pin</b>: Mã thẻ.</h6>
                                <h6><b style="color: red;">APIKey</b>: APIKey của bạn.</h6>
                                <h6><b style="color: red;">callback</b>: URL callback của bạn, ví dụ
                                    domain.com/callback.php.</h6>
                                <h6><b style="color: green;">content</b>: Nội dung được gửi lên, ví dụ request id thẻ để
                                    nhận dạng thẻ khi gửi về.</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Response</label>
                            <textarea class="form-control" style="background:#222222;color:#8fdc33;" rows="10" readonly>
"data":
    "status": "Trạng thái thẻ, error hoặc success",
    "msg": "Thông báo trạng thái thẻ"
</textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Code Mẫu</label>
                            <textarea class="form-control copy" id="copyCodeMau1" data-clipboard-target="#copyCodeMau1"
                                style="background:#222222;color:#8fdc33;" rows="15" readonly>
$url = '<?=$site_domain;?>api/card-auto.php?auto=true&type=Viettel&menhgia=10000&seri=10006139342354&pin=114384960423544&APIKey=<?=$user['APIKey'];?>&callback=http://localhost/callback.php&content=1233';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);
$json = json_decode($data, true);

if (isset($json['data']))
{
    if ($json['data']['status'] == 'error')
    {
        //Trạng thái thẻ lỗi
    }
    else if ($json['data']['status'] == 'success')
    {
        //Gửi thẻ hoàn tắt
    }
}
</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="boxbody_tbl" id="doithe">
                <div class="boxbody_top">
                    <h2><span>CALLBACK TRẢ VỀ</span></h2>
                </div>
                <div class="boxbody_body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phương thức GET:</label>
                                <input type="text" class="form-control copy"
                                    value="domaincuaban.com/callbakcuaban.php?content=noidungthe&status=trangthaithe"
                                    id="copyCallback" data-clipboard-target="#copyCallback" readonly>
                            </div>
                            <div class="form-group">
                                <label>Trong đó:</label>
                                <h6><b style="color: blue;">content</b>: Request ID của bạn đưa lên.
                                </h6>
                                <h6><b style="color: red;">status</b>: Trạng thái thẻ chúng tôi gửi về callback của bạn.
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Response</label>
                            <textarea class="form-control" style="background:#222222;color:#8fdc33;" rows="10" readonly>
"data":
    "status": "Trạng thái thẻ được gửi về, error hoặc success",
    "content": "Nội dung trạng thái thẻ được gửi về"
</textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Code Mẫu</label>
                            <textarea class="form-control copy" id="copyCodeMau2" data-clipboard-target="#copyCodeMau2"
                                style="background:#222222;color:#8fdc33;" rows="12" readonly>
if ( isset($_GET['content']) && isset($_GET['status']) )
{
    if ($_GET['status'] == 'hoantat')
    {
        // Thẻ ok
    }
    else if ($_GET['status'] == 'thatbai')
    {
        // Thẻ lỗi
    }
}
</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalChangeApiKey" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">XÁC NHẬN TẠO MỚI API KEY</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Chúng tôi cần bạn hiểu rằng chuỗi khóa API được sử dụng để tích hợp giữa hệ thống của bạn và của
                chúng
                tôi. Vui lòng không tạo chuỗi khóa mới nếu bạn không hiểu điều gì đang xảy ra hoặc không có sự
                xác nhận
                từ nhà phát triển của bạn.
            </div>
            <div class="modal-footer">
                <form action="" method="POST">
                    <button type="submit" name="btnChangeApiKey" class="btn btn-primary">XÁC NHẬN</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('../foot.php');?>