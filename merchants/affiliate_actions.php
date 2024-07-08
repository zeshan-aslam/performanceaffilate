<?php ob_start();

/***************************************************************************************************
     PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES DETAILS (processing )
      VARIABLES          :      $MERCHANTID       =merchantid
              					$page             =page no
                                $aff              =affilaite id+status
                                $pgmname          =program url
  //*************************************************************************************************/

include_once '../includes/constants.php';
include_once '../includes/db-connect.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';
include_once '../includes/allstripslashes.php';

include "../mail.php";

$partners = new partners;
$partners->connection($host, $user, $pass, $db);

/************************************variables********************************/
$MERCHANTID   = $_SESSION['MERCHANTID'];       // merchantid
$page         = trim($_GET['page']);           //page no
$selaction    = trim($_POST['selaction']);     //getting action + join id
$aff          = explode('~', $selaction);

/****************************************************************************/


/********************getting program name ***********************************/
$sql          = "select * from partners_program,partners_joinpgm where joinpgm_id ='$aff[0]' and joinpgm_programid=program_id";
$result       = mysqli_query($con, $sql);
$row          = mysqli_fetch_object($result);
$pgmname      = $row->program_url;
$pgmname      = $pgmname . "~" . $aff[0];
/*****************************************************************************/



/****************************getting to email id*****************************/
$sql = "select * from partners_login,partners_joinpgm where joinpgm_id='$aff[0]' and login_flag='a' and joinpgm_affiliateid=login_id";
$ret1 = mysqli_query($con, $sql);
$row = mysqli_fetch_object($ret1);
$to = $row->login_email;
/****************************************************************************/

//===================Start Functions for country name and category name for affiliates ============================//
function getCountryOfPromotionName($affiliate_id)
{
      $conn = $GLOBALS['con'];

      $country_pro_query = "SELECT partners_country.country_name FROM aff_cop 
		join partners_country on aff_cop.cop_id = partners_country.country_no
		WHERE aff_cop.client_id='$affiliate_id'";
      $country_pro = "";
      $data = mysqli_query($conn, $country_pro_query);

      foreach ($data as $c_promotion) {
            $country_pro .= $c_promotion['country_name'] . ',';
      }
      $final_pro_country = rtrim($country_pro, ',');
      return $final_pro_country;
}
function CategoryName($affiliate_id)
{
      $conn = $GLOBALS['con'];
      $merchant_cat = "SELECT partners_category.cat_name FROM aff_cates 
	  join partners_category on aff_cates.cates_id = partners_category.cat_id
	  WHERE aff_cates.client_id='$affiliate_id'";

      $categories = "";
      $data = mysqli_query($conn, $merchant_cat);

      foreach ($data as $category) {
            $categories .= $category['cat_name'] . ',';
      }
      $final_categories = rtrim($categories, ',');
      return $final_categories;
}

//===================End Functions for country name and category name for affiliates============================//

/******************  actions selected****************************************/
switch ($aff[1]) // cahecking action
{
      case  'ViewProfile':  //view profile of affilaite
            // header("Location:index.php?Act=affiliates&mode=ViewProfile&affid=$aff[2]&page=$page");
            // Return the response as JSON
            $sql_aff        = "select * from partners_affiliate where affiliate_id='$aff[2]'";
            $res_aff        = mysqli_query($con, $sql_aff);
            while ($row = mysqli_fetch_object($res_aff)) {
                  $affiliate_id                                = $row->affiliate_id;
                  $affiliate_firstname                                  = stripslashes($row->affiliate_firstname);
                  $affiliate_lastname                                   = stripslashes($row->affiliate_lastname);
                  $affiliate_company                           = stripslashes($row->affiliate_company);
                  $affiliate_address                           = stripslashes($row->affiliate_address);
                  $affiliate_city                              = stripslashes($row->affiliate_city);
                  $affiliate_country                           = stripslashes(getCountryOfPromotionName($affiliate_id));
                  $affiliate_phone                             = stripslashes($row->affiliate_phone);
                  $affiliate_url                               = stripslashes(trim($row->affiliate_url));
                  $affiliate_category                              = stripslashes(CategoryName($affiliate_id));
                  $affiliate_status                                = stripslashes($row->affiliate_status);
                  $affiliate_date                              = stripslashes($row->affiliate_date);
                  $affiliate_fax                               = stripslashes($row->affiliate_fax);
            }
            $response = array(
                  'msg' => 'View Profile',
                  'affiliate_id' => $affiliate_id,
                  'affiliate_firstname' => $affiliate_firstname,
                  'affiliate_lastname' => $affiliate_lastname,
                  'affiliate_company' => $affiliate_company,
                  'affiliate_address' => $affiliate_address,
                  'affiliate_city' => $affiliate_city,
                  'affiliate_country' => $affiliate_country,
                  'affiliate_phone' => $affiliate_phone,
                  'affiliate_url' => $affiliate_url,
                  'affiliate_category' => $affiliate_category,
                  'affiliate_status' => $affiliate_status,
                  'affiliate_date' => $affiliate_date,
                  'affiliate_fax' => $affiliate_fax
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
            break;
      case 'Reject':        //reject affilaite (joinpgm)
            header("Location:index.php?Act=affiliates&mode=Reject&affid=$aff[2]&loginflag=a&page=$page&pgmname=$pgmname");
            exit;
            break;
      case 'Approve':      //reject affilaite (joinpgm)
            $sql = "update partners_joinpgm set joinpgm_status='approved' where joinpgm_id='$aff[0]'";
            MailEvent("Approve AffiliateProgram", $MERCHANTID, $aff[0], $to, 0);
            break;
      case 'Suspend':
            $sql = "update partners_joinpgm set joinpgm_status='suspend' where joinpgm_id='$aff[0]'";

            MailEvent("Suspend AffiliateProgram", $MERCHANTID, $aff[0], $to, 0);
            break;
}

/***************************************************************************/
$ret   = mysqli_query($con, $sql);
//   header("location:index.php?Act=affiliates&page=$page&affiliate=$affiliatename");

if ($ret) {
      $response = "sql result: " . $sql;
} else {
      $response = false;
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
