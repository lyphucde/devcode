<div id="footer">
    <div class="container">
        <div id="footer-facebook">
            <p class="title">Facebook Fanpage</p>
            <div class="fb-page" data-href="<?=$site_fanpage;?>" data-tabs="timeline" data-width="" data-height="200px"
                data-small-header="true" data-adapt-container-width="true" data-hide-cover="false"
                data-show-facepile="true">
                <blockquote cite="<?=$site_fanpage;?>" class="fb-xfbml-parse-ignore"><a
                        href="<?=$site_fanpage;?>"><?=$site_tenweb;?></a></blockquote>
            </div>
        </div>
        <div id="footer-policy">
            <p class="title">Quy định & chính sách</p>
            <ul>
                <li>
                    <a href="#">
                        Ch&#237;nh s&#225;ch bảo mật th&#244;ng tin
                    </a>
                </li>
                <li>
                    <a href="#">
                        Giải quyết khiếu nại
                    </a>
                </li>
                <li>
                    <a href="#">
                        Điều khoản sử dụng
                    </a>
                </li>
            </ul>
        </div>
        <div id="footer-cat">
            <p class="title">Danh mục</p>
            <ul>
                <li><a href="/">Đổi thẻ tự động</a></li>
                <li><a href="/card-cham/">Đổi thẻ thủ công</a></li>
                <li><a href="/rut-tien/">Rút tiền về ngân hàng</a></li>
            </ul>
        </div>
        <div id="footer-info">
            <p class="title">Liên hệ với chúng tôi</p>
            <p><span style="color:#FFD700;"><strong><?=$site_tenweb;?></strong></span></p>

            <p><strong>Địa chỉ:</strong> <?=$site_diachi;?></p>

            <p><strong>Hotline:</strong> <?=$site_hotline;?></p>

            <p><strong>Website:</strong> <?=$site_tenweb;?></p>

        </div>
    </div>
</div>
<div id="footer-designed">
    <div class="container">
        © 2020 <?=$site_tenweb;?> | Đơn Vị Thiết Kế Website <a href="https://www.cmsnt.co/">CMSNT.CO</a>
    </div>
</div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
new ClipboardJS('.copy');
</script>

<script src="//code.jquery.com/jquery-1.10.0.min.js"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="/js/pnotify.min.js"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/js/alljs?v=rS7lw9yVjIfiNhMk2rV3C67exTnJ4FM8k3VjVeF2lsM1"></script>
<script src="/js/angular.min.js"></script>


<script type="text/javascript">
$(window).load(function() {
    $(".pageloader").fadeOut("slow");
});
</script>

<script>
$(function() {
    $("#datatable1").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
});
</script>
<script src="/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
        xfbml: true,
        version: 'v7.0'
    });
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution=setup_tool page_id="102718941104461" theme_color="#7646ff"
    logged_in_greeting="Chào Anh!, Anh cần hỗ trợ gì không ạ ?"
    logged_out_greeting="Chào Anh!, Anh cần hỗ trợ gì không ạ ?">
</div>


</body>

</html>