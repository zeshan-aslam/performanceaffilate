<style type="text/css">
  th {
    padding: 8px !important;
    font-size: 15px !important;
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

/////getting page no
if (empty($page))
  $page        = $partners->getpage();

/////////


// $sql   = "SELECT  joinpgm_programid, program_url FROM partners_joinpgm, partners_program
//             WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND program_id=joinpgm_programid ";

$sql   = "SELECT  joinpgm_programid, program_url, merchant_id, merchant_status FROM partners_joinpgm, partners_program, partners_merchant
            WHERE joinpgm_affiliateid =  '$_SESSION[AFFILIATEID]' AND joinpgm_status = 'approved' AND program_id=joinpgm_programid 
            AND merchant_id=joinpgm_merchantid AND merchant_status='approved'"; //adding to drop down box

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) < "1") {
  echo "<div class='row'> 
			<div class='col-md-12'>
				<div class='card'>
					<div class='card-body'>
						<span class='error'><? echo $lang_notjoined?></span>
						<h5 align='center'><a href='index.php?Act=Affiliates&joinstatus=notjoined'> click here to Join</a></h5>
					 </div>	
				</div>	 
			</div>	
		</div>";

  exit;
} ///closing of if list populating ;

$programs = trim($_POST['programs']);
if (empty($programs))
  $programs = trim($_GET['programs']);

if (empty($programs)) {
  $programs = "All";
  $link = 0;
}

switch ($programs) //checking program
{
  case 'All';    //all pgm
    $bsql = "SELECT * FROM partners_banner,partners_joinpgm where banner_status ='active' and joinpgm_affiliateid= '$AFFILIATEID' AND  joinpgm_status = 'approved' AND joinpgm_programid= banner_programid ";
    $pgmid = 0;
    $link = 0;

    $allresult = "--";
    $flag = 0;

    break;
  default:    //selected pgm
    $bsql = "SELECT * FROM partners_banner where banner_programid='$programs' and banner_status ='active'";

    // $bresult=mysqli_query($con,$bsql);

}

include 'getadd.php';

?>



<form name="f1" action="index.php?Act=getbanner" method="post">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="form-group">
            <label><?= $lang_Getbanner ?></label>
            <select name="programs" onchange="document.f1.submit()" class="selectpicker" data-title="Please Select" data-style="btn-default btn-outline" data-menu-style="dropdown-blue">
              <option value="All"><?= $lang_home_all_pgms  ?></option>
              <? while ($row = mysqli_fetch_object($result)) {
                if ($programs == "$row->joinpgm_programid")
                  $programName = "selected";
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
          <div class="text-right">
            <a href="index.php?Act=sub_id_list">&laquo;<?= $lang_home_manage_subid ?>&raquo;</a>
          </div>
        </div>
      </div>
    </div>
    <?php
    $msql = " SELECT m.merchant_firstname, m.merchant_lastname, m.merchant_profileimage, m.merchant_date, m.merchant_company FROM partners_program p ";
    $msql .= " left join partners_merchant m on m.merchant_id = p.program_merchantid   ";
    $msql .= " where program_id ='$programs'  ";

    $mres = mysqli_query($con, $msql);

    if (mysqli_num_rows($mres) > 0) {
      $mDetails = mysqli_fetch_assoc($mres);

      $merchantImage = "";
      if ($mDetails["merchant_profileimage"] == "") {
        $merchantImage = "https://performanceaffiliate.com/assets/imgs/photo.jpg";
      } else {
        $merchantImage = "/merchants/uploadedimage/" . $mDetails["merchant_profileimage"];
      }


    ?>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-md-1" style="text-align: center;">
                <img src="<?php  ?>" style="max-width: 100px;">
              </div>
              <div class="col-md-8">
                <p>Merchant Name: <?php echo $mDetails["merchant_company"]; ?><br>Merchant Active Since: <?php echo $mDetails["merchant_date"]; ?></p>
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
          <table class="" cellspacing="0" width="auto" border="1">
            <thead style="background: #f1f1f1;">
              <tr>
                <th class="th-sm">Preview

                </th>
                <th class="th-sm">Type

                </th>
                <th class="th-sm">ID

                </th>
                <th class="th-sm">Track Url

                </th>
                <th class="th-sm">Title

                </th>
                <th class="th-sm">Tags
                </th>
                <th class="th-sm">Dimensions
                </th>
                <th class="th-sm">Last Modified
                </th>
                <th class="th-sm">View Details
                </th>
              </tr>
            </thead>
            <tbody>
              <?php    ///////////// display  banners /////////////
              $bsql1 = $bsql;
              $bsql  .= "LIMIT " . ($page - 1) * $lines . "," . $lines; //adding page no
              $bres = mysqli_query($con, $bsql);
              //echo $sql3;
              echo mysqli_error($con);
              $i = 0;
              if (mysqli_num_rows($bres) <= "0") {
              ?>
                <p class="textred"><b><?= $lang_banner_norec ?></b></p>
                <?php } else {
                while ($row = mysqli_fetch_object($bres)) {

                ?>
                  <tr id="link">
                    <td>
                      <div class="affi_banner_img">
                        <?php $id = base64_encode($row->banner_id); ?>
                        <a href='javascript:void(0)'>
                          <img data-toggle="modal" data-target="#divBannerFull" style="max-height: 25px;" height="100px" width="100px" src='https://performanceaffiliate.com/code.php?id=<?= $id ?>' border='0' data-width="<?= $row->banner_width ?>" data-height="<?= $row->banner_height ?>">
                        </a>
                      </div>
                    </td>
                    <td>0</td>
                    <td><?= $row->banner_id ?></td>

                    <?php
                    //if the affiliate has chosen a sub id then add that also to the url
                    $subidurl = "&amp;subid=1";
                    if (!empty($subid)) $subidurl = "&amp;subid=$subid";
                    $url .= "&auid={auid}&trafficSource={trafficsource}&redirectURL={redirecturl}";
                    $targetUrl = $track_site_url . "/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id" . $subidurl;
                    $targetUrl .= "&auid={auid}&trafficSource={trafficsource}&redirectURL={redirecturl}";
                    ?>
                    <td><a href="<?= $targetUrl ?>"><?= $targetUrl ?></td>
                    <td>0</td>
                    <td>0</td>
                    <td><?= $row->banner_width ?>x<?= $row->banner_height ?></td>
                    <td>0</td>
                    <td data-toggle="collapse" data-target="#demo<?= $i ?>">View Details</td>
                  </tr>
                  <tr id="demo<?= $i ?>" class="collapse">
                    <td colspan="9">
                      <div width="100%" height="100%">
                        <div class="col-md-5">
                          <p><b>Descriptions:</b>Use this code to track your transaction</p>
                        </div>
                        <div class="text-center">
                          <textarea width="100%" cols="90" rows="6"><?php
                                                                    //if the affiliate has chosen a sub id then add that also to the url
                                                                    $subidurl = "";
                                                                    if (!empty($subid)) $subidurl = "&amp;subid=$subid";

                                                                    //$track_site_url = urlencode($track_site_url);
                                                                    $track_site_url = str_replace(" ", "%20", $track_site_url);
                                                                    $id = base64_encode($row->banner_id);
                                                                    $url = $track_site_url . "/trackingcode.php?aid=$_SESSION[AFFILIATEID]&linkid=B$row->banner_id$subidurl";
                                                                    $url .= "&auid={auid}&trafficSource={trafficsource}&redirectURL={redirecturl}";
                                                                    $code = "<!-- START $title CODE -->\n<a href='$url'>\n<img src='https://performanceaffiliate.com/code.php?id=$id' border='0' />\n</a>\n<!-- END $title CODE -->";
                                                                    echo $code;
                                                                    ?></textarea>
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
</form>


<div id="divBannerFull" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">&nbsp;</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: center;">


        <img id="imgBannerFull" src="" class="img-fluid" />

      </div>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {

    $('#divBannerFull').on('show.bs.modal', function(event) {
      var img = $(event.relatedTarget) // Button that triggered the modal

      var src = $(img).attr("src");
      var width = $(img).data("width");
      var height = $(img).data("height");

      $("#imgBannerFull").attr("src", src);
      $("#imgBannerFull").attr("width", width);
      $("#imgBannerFull").attr("height", height);



    })

  })
</script>