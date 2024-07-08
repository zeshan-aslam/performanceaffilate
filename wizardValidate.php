<?php
include_once 'includes/db-connect.php';

$program_title = $_POST['program_title'];
$mid = $_POST['mid'];
$aid = $_POST['aid'];
$SaleAmountType = $_POST['SaleAmountType'];
$sales_amount = $_POST['sales_amount'];
$leadAmountType = $_POST['leadAmountType'];
$lead_amount = $_POST['lead_amount'];
$Tracking_Period = $_POST['Tracking_Period'];
$bio = $_POST['bio'];
// $mer_logo = $_FILES['mer_logo'];
$progAgreement = $_POST['progAgreement'];
$approval = $_POST['approval'];
$tracking_url = $_POST['tracking_url'];
$tracking_text = $_POST['tracking_text'];
$tracking_description = $_POST['tracking_description'];
$current_date = date('y-m-d');

$link_id = '';
$last_pid = '';

// Program's data storing in the database
$sql1 = "SELECT * FROM partners_program  WHERE program_merchantid = '$mid'";
$res = mysqli_query($con, $sql1);
if (mysqli_num_rows($res) > 0) {
    $msg = "Merchant already has program";
    $prog_reject_msg = json_encode($msg);
    echo $prog_reject_msg;
    exit;
} else {

    $sql2 = "INSERT INTO partners_program (program_merchantid, program_date, program_status, program_url,
    program_description,program_cookie, program_agreement, program_affiliateapproval, program_mailaffiliate, program_mailmerchant)
    VALUES ('$mid', '$current_date', 'active', '$program_title', '$bio','$Tracking_Period', '$progAgreement', '$approval', 'no', 'no')";
    $result2 = mysqli_query($con, $sql2);
    $last_pid = mysqli_insert_id($con);
    // echo json_encode(['prog_lastId' => $last_id]);
    // exit;  
    if ($last_pid) {
        $sql8 = "INSERT INTO partners_pgm_commission (commission_programid, commission_leadrate, commission_salerate, commission_saletype)
                    VALUES ( '$last_pid', '$lead_amount', '$sales_amount', '$SaleAmountType')";
        $result8 = mysqli_query($con, $sql8);
        // To join the program automatically to the Test affiliate named as 'Fareed test Comp'
        $findDupSql = "SELECT joinpgm_id FROM partners_joinpgm WHERE joinpgm_programid = '" . $last_pid . "' AND joinpgm_affiliateid = '" . $aid . "' ";
        $findRes    =  mysqli_query($con, $findDupSql);
        mysqli_num_rows($findRes);

        if (mysqli_num_rows($findRes) < 1) {
            $sql4 = "INSERT INTO partners_joinpgm (joinpgm_status,joinpgm_programid,joinpgm_merchantid,joinpgm_affiliateid,joinpgm_date)
                VALUES ('approved','" . $last_pid  . "','" . $mid . "','$aid','$current_date')";
            $res4 = mysqli_query($con, $sql4);
            $joinflag = false;
        }

        $dir = "merchants/uploadedimage/";
        if (isset($_FILES['mer_logo'])) {
            $imge = $_FILES['mer_logo'];
            $filename = $imge['name'];
            $destination = $dir . $imge['name'];
            $isuploaded = move_uploaded_file($imge['tmp_name'], $destination);
            if ($isuploaded) {
                $sql7 = "UPDATE `partners_merchant` SET `merchant_profileimage` = '$filename'
             WHERE `merchant_id` = '$mid'";
                $result7 = mysqli_query($con, $sql7);
            }
        }

        $sql5 = "INSERT INTO partners_text_old (text_programid,text_text,text_url,text_description,text_status)
            VALUES ('$last_pid','$tracking_text','$tracking_url','$tracking_description','active')";
        $result5 = mysqli_query($con, $sql5);
        $last_tid = mysqli_insert_id($con);
    }
    // To get the tracking link 
    if ($last_tid) {

        $sql6 = "SELECT * FROM partners_text_old WHERE text_programid = $last_pid AND text_id = $last_tid";
        $link_data = mysqli_query($con, $sql6);
        foreach ($link_data as $val) {
            $link_id = $val['text_id'];
        }
    }

    $final_data = array('tracking_link' => 'https://performanceaffiliate.com/performanceAffiliateClone/trackingcode.php?aid=' . $aid . '&linkid=N' . $link_id);
    echo json_encode($final_data);
}
