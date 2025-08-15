<?php
require_once('config.php');
if (isset($_GET['status']) && isset($_GET['pricesvalue']) && isset($_GET['value_receive']) && isset($_GET['card_code']) && isset($_GET['card_seri']) && isset($_GET['requestid']) && isset($_GET['value_customer_receive'])) 
    {
        
        $status = $_GET['status'];
        $realvalue = $_GET['value_receive'];
        $request_id = $_GET['requestid'];
        
        $fromSQL = $ketnoi->query("SELECT * FROM `doithe_auto` WHERE `code` = '".$request_id."'");
        $get_username = $ketnoi->query("SELECT `username` FROM `doithe_auto` WHERE `code` = '".$request_id."' ")->fetch_array()['username'];  
        $get_vnd = $ketnoi->query("SELECT `VND` FROM `account` WHERE `username` = '".$get_username."' ")->fetch_array()['VND'];

        if ($fromSQL->num_rows > 0)
        {
            $row = $fromSQL->fetch_array();
            if ($row['status'] == 'xuly')
            {        
                if ($status == 200)
                {
                    $ketnoi->query("UPDATE `account` SET 
                    `VND` = `VND` + '".$row['thucnhan']."'
                    WHERE `username` = '".$row['username']."'");

                    $ketnoi->query("UPDATE `doithe_auto` SET 
                    `status` = 'hoantat',
                    `updatedate` = now()
                    WHERE `code` = '".$request_id."' ");

                    $ketnoi->query("INSERT INTO `logs` SET 
                    `content` = '".format_cash($get_vnd)." + ".format_cash($row['thucnhan'])." = ".format_cash(phepcong($get_vnd, $row['thucnhan']))." lý do: Đổi Thẻ SERI ".$row['seri'].". ',
                    `username` = '".$row['username']."',
                    `createdate` = now() ");

                    if ( isset($row['callback']) )
                    {
                        curl_get( $row['callback']."?content=".$row['mess']."&status=hoantat");
                    }
                    die();
                } 
                else if ($status == 201)
                {
                    $ketnoi->query("UPDATE `doithe_auto` SET 
                    `status` = 'thatbai',
                    `note` = 'Sai mệnh giá, mệnh giá thực ".format_cash($realvalue)." ',
                    `updatedate` = now()
                    WHERE `code` = '".$request_id."' ");
                    if ( isset($row['callback']) )
                    {
                        curl_get( $row['callback']."?content=".$row['mess']."&status=thatbai");
                    }
                    die();
                }
                else if ($status == 100)
                {
                    $ketnoi->query("UPDATE `doithe_auto` SET 
                    `status` = 'thatbai',
                    `note` = 'Thẻ cào không hợp lệ hoặc đã được sử dụng. ',
                    `updatedate` = now()
                    WHERE `code` = '".$request_id."' ");
                    if ( isset($row['callback']) ){
                        curl_get( $row['callback']."?content=".$row['mess']."&status=thatbai");
                    }
                    die();
                }
                else
                {
                    $ketnoi->query("UPDATE `doithe_auto` SET 
                    `status` = 'thatbai',
                    `note` = 'Vui lòng báo cáo QTV để kiểm tra!',
                    `updatedate` = now()
                    WHERE `code` = '".$request_id."' ");
                    if ( isset($row['callback']) )
                    {
                        curl_get( $row['callback']."?content=".$row['mess']."&status=thatbai");
                    }
                    die();
                }       
            }

        }
        
    }
?>