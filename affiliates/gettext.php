<style type="text/css">
  th {
    padding: 8px !important;
    font-size: 14px !important;
    color: #000000 !important;
    font-weight: 600 !important;
  }

  <style type="text/css">th {
    font-size: 12px !important;
    color: #000000 !important;
    font-weight: 600 !important;
  }

  #link>td:last-child {
    font-size: 14px;
  }

  #link>td:last-child:hover {
    color: blue;
    cursor: pointer;
    text-decoration: underline;
  }

  table {
    background: white !important;
  }
</style>
<?

include_once '../includes/constants.php';
include_once '../includes/functions.php';
include_once '../includes/session.php';

if (empty($page))                               //getting page no
  $page = $partners->getpage();

// $sql   = "SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
// WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved'  AND program_id=joinpgm_programid ";


$sql   = "SELECT  joinpgm_programid, program_url, merchant_id, merchant_status FROM partners_joinpgm, partners_program, partners_merchant
  WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND program_id=joinpgm_programid 
  AND merchant_id=joinpgm_merchantid AND merchant_status='approved'"; //adding to drop down box

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) < "1") {

  echo "<p>&nbsp;</p>
                                                     <table border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse: collapse'  width='96%' id='AutoNumber1' class='tablebdr'>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' align='center'>
                                                               <font size='4'>$lang_notjoined</font></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               &nbsp;</td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%'>
                                                               <h5 align='center'><a href='index.php?Act=Affiliates&joinstatus=notjoined'> click here to Join</a></td>
                                                             </tr>
                                                             <tr>
                                                               <td width='100%' class='tdhead'>
                                                               &nbsp;</td>
                                                             </tr>
                                                           </table> ";

  exit;
} ///closing of if list populating ;

/////////////////////////////




$programs = intval(trim($_POST['programs']));
if (empty($programs))
  $programs = intval(trim($_GET['programs']));

if (empty($programs)) {
  $programs = "All";
  $link = 0;
}

//$sql="SELECT * from partners_program where program_merchantid=$MERCHANTID"; //adding to drop down box
//$result=mysqli_query($con,$sql);

switch ($programs) //checking program
{
  case 'All';    //all pgm
    $bsql = "SELECT * FROM partners_text_old,partners_joinpgm  where	text_status ='active' and joinpgm_affiliateid = '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND joinpgm_programid=text_programid ";
    $pgmid = 0;
    $link = 0;

    $allresult = "--";
    $flag = 0;

    break;
  default:    //selected pgm
    $bsql = "SELECT * FROM partners_text_old where text_programid ='$programs' and text_status ='active'	";

    // $bresult=mysqli_query($con,$bsql);

}

include 'getadd.php'

?>
<form name="f1" action="index.php?Act=gettext" method="post">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label><?= $lang_Gettext ?></label>
            <select name="programs" onchange="document.f1.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
              <option value="All"><?= $lang_home_all_pgms ?></option>
              <? while ($row = mysqli_fetch_object($result)) {
                if ($programs == "$row->joinpgm_programid")
                  $programName = "selected = 'selected'";
                else
                  $programName = "";
              ?>
                <option <?= $programName ?> value="<?= $row->joinpgm_programid ?>"><?= $common_id ?>:<?= $row->joinpgm_programid ?>...<?= stripslashes($row->program_url) ?> </option>
              <?
              }
              ?>
            </select>
          </div>
          <!--Choose Sub-ID-->
          <?php include("subid_choose.php"); ?>
          <!--Choose Sub-ID-->
        </div>
      </div>
    </div>

    <?php
    $msql = " SELECT m.merchant_firstname, m.merchant_lastname,m.merchant_company, m.merchant_profileimage, m.merchant_date FROM partners_program p ";
    $msql .= " left join partners_merchant m on m.merchant_id = p.program_merchantid";
    $msql .= " where program_id ='$programs'  ";

    $mres = mysqli_query($con, $msql);

    if (mysqli_num_rows($mres) > 0) {
      $mDetails = mysqli_fetch_assoc($mres);

      $merchantImage = "";
      if ($mDetails["merchant_profileimage"] == "") {
        $merchantImage = "https://searlco.net/assets/imgs/photo.jpg";
      } else {
        $merchantImage = "/merchants/uploadedimage/" . $mDetails["merchant_profileimage"];
      }


    ?>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body" style="height: 188px;">

            <div class="row">
              <div class="col-md-4" style="text-align: center;">
                <img src="<?php echo $merchantImage ?>" style="max-width: 100px;">
              </div>
              <div class="col-md-8">
                <p>Merchant Name: <?php echo $mDetails["merchant_company"]; ?></p>
                <p>Member Since: <?php echo $mDetails["merchant_date"]; ?></p>
              </div>
            </div>

          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="col-md-12">
      <div class="card">
        <div class="card-body">

          <table id="dtBasicExample" class="" cellspacing="0" width="100%" border="1">
            <thead style="background: #f1f1f1;">
              <tr>
                <th class="th-sm"><?= $lang_home_text ?>

                </th>

                <th class="th-sm">Track Url
                </th>
                <th class="th-sm">ID

                </th>
                <th class="th-sm">Description

                </th>
                <th class="th-sm">Status

                </th>

                <th class="th-sm">Last Modified
                </th>
                <th class="th-sm">View Detail
                </th>
              </tr>
            </thead>
            <tbody>
              <?php    ///////////// display  texts /////////////

              $bsql1 = $bsql;
              $bsql  .= "LIMIT " . ($page - 1) * $lines . "," . $lines; //adding page no
              $bres = mysqli_query($con, $bsql);
              //echo $sql3;
              //echo mysql_error();
              $i = 0;
              if (mysqli_num_rows($bres) <= "0") {
              ?>
                <p class="textred"><b><?= $lang_text_norec ?></b></p>

                <? } else {
                while ($row = mysqli_fetch_object($bres)) {
                ?>
                  <tr id="link">

                    <td><?= $row->text_text ?></td>

                    <?php
                    //if the affiliate has chosen a sub id then add that also to the url
                    $subidurl = "&amp;subid=1";
                    if (!empty($subid)) $subidurl = "&amp;subid=$subid";

                    $targetUrl = $track_site_url . "/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=N$row->text_id" . $subidurl;

                    //Added by Ankit Kedia on 14th July 2019
                    $targetUrl .= "&auid={auid}&trafficSource={trafficsource}&redirectURL={redirecturl}";

                    ?>
                    <td><a href="<?= $targetUrl ?>"><?= $targetUrl ?></a></td>
                    <td><?= $row->text_id ?></td>
                    <td><?= $row->text_description ?></td>
                    <td><?= $row->text_status ?></td>
                    <td>0</td>
                    <td data-toggle="collapse" data-target="#demo<?= $i ?>">View Details</td>
                  <tr id="demo<?= $i ?>" class="collapse">
                    <td colspan="9">
                      <div width="100%" height="100%">
                        <div class="col-md-5">
                          <p><b>Descriptions:</b>Use this code to track your transaction</p>
                        </div>
                        <div class="text-center">
                          <? //if the affiliate has chosen a sub id then add that also to the url
                          $subidurl = "";
                          if (!empty($subid)) $subidurl = "&amp;subid=$subid";
                          //$track_site_url = urlencode($track_site_url);
                          $track_site_url = str_replace(" ", "%20", $track_site_url);
                          $url = $track_site_url . "/trackingcode.php?aid=$_SESSION[AFFILIATEID]&amp;linkid=N$row->text_id" . $subidurl;
                          //Added by Ankit Kedia on 14th July 2019
                          $url .= "&auid={auid}&trafficSource={trafficsource}&redirectURL={redirecturl}";
                          $code = "<!-- START $title CODE -->\n<a href='$url'>$row->text_text</a>\n<!-- END $title CODE -->";
                          //  echo $code;
                          ?>
                          <textarea width="100%" cols="80" rows="6"><?= $code ?></textarea>
                        </div>
                      </div>
                    </td>
                  </tr>
              <?php $i++;
                }
              } ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('#dtBasicExample').DataTable();
    "paging": false;
    $('.dataTables_length').addClass('bs-select');
  });
</script>