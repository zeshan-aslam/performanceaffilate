<?php
include('header_two.php');
?>

<?php
include_once 'includes/db-connect.php';

include 'lang/english.php';
//Last Modified By DPT on May/28/05 to fix issues with HTML
$Err    = $_GET['Err'];
$ErrType = $_GET['ErrType'];
$Action  = $_GET['Action'];

if ($Action == "affiliate")
  $aff = "selected = 'selected' ";
else
  $mer = "selected = 'selected' ";
?>
<?php /*?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$forgotpass_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<table width="69%" height="155"  border="0" align="center" class="tablebdr1" BGCOLOR=#FFFFFF>
   <tr class="tdhead">
     <td>&nbsp;</td>
   </tr>
   <tr>

     <td valign="center">
     <div align="center">

         <table width="100%"  border="0" cellpadding="1" class="tablewbdr" >
          <form name="login" action="password_process.php" method="post">
          <tr>
             <td class="txtred" align="center" colspan="3" height="15"><?=$Err?></td>
          </tr>
          <tr align="center" >
            <td width="33%" height="20" align="right"><?=$forgotpass_choose?></td>
            <td width="66%" height="20">
            <select name="flag" height="20">
                <option <?=$mer?> value="merchant"><?=$forgotpass_merchant?></option>
                <option <?=$aff?> value="affiliate"><?=$forgotpass_affiliate?></option>
            </select></td>
            <td width="1%"></td>
          </tr>
          <tr height="30" align="center">
            <td height="20" align="right"><?=$forgotpass_email?></td>
            <td width="66%" height="20">
              <input name="login" type="text"  size="13"></td>
         </tr>
         <tr height="30">
            <td align="center" colspan="2" >
               <input name="Get Password" type="submit"  size="13" value="<?=$forgotpass_submit?>"></td>
         </tr>
        </form>
     </table>
     </div></td>
   </tr>
   <tr class="tdhead">
     <td>&nbsp;</td>
   </tr>
</table>
</body>
</html><?php */ ?>



<section class="signuppage">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="Signupform">
          <form name="login" action="password_process.php" method="post">
            <div class="form-title">
              <h3> <?= $forgotpass ?> </h3>
            </div>
            <?php
            if ($Err != "") {
              $alertClass = $ErrType === "Error" ? "alert-danger" : "alert-success";
            ?>
              <div class="form-group row">
                <div class="col-12">
                  <div class="alert <?= $alertClass ?>" role="alert"><?= $Err ?> </div>
                </div>
              </div>
            <?php
            }
            ?>
            <div class="mb-1 mt-1 col-md-12">
              <label for="name" class="form-label">Please Select Account Type:</label>
              <select name="flag" class="custom-select form-control" required>
                <option value="">Select Account Type</option>
                <option <?= $mer ?> value="merchant"><?= $forgotpass_merchant ?></option>
                <option <?= $aff ?> value="affiliate"><?= $forgotpass_affiliate ?></option>
              </select>
            </div>
            <div class="mb-1 mt-1 col-md-12">
              <label for="name" class="form-label"><?= $forgotpass_email ?></label>
              <input class="form-control" placeholder="Enter email" name="login" type="text">
            </div>
            <button class="btn btn-primary" name="Get Password" type="submit"><?= $forgotpass_submit ?></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>




<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->

<!-- <body style="background-color:#FFFFFF; background-image:url(images/white.jpg); background-repeat:repeat; margin-top:25px">
  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-left: 465px;">
    <tr>
      <td class="affiliates-top">
        <div class="box-heading">&nbsp;&nbsp;&nbsp;<?= $forgotpass ?></div>
      </td>
    </tr>
    <tr>
      <td class="affiliate-content-bg">
        <table border="0" cellpadding="1">
          <form name="login" action="password_process.php" method="post">
            <tr>
              <td class="error" align="center" colspan="3" height="15"><?= $Err ?></td>
            </tr>
            <tr align="center">
              <td width="38%" height="20" align="right"><?= $forgotpass_choose ?> :</td>
              <td width="61%" height="20" align="left">
                &nbsp;&nbsp;&nbsp;
                <select name="flag" height="20">
                  <option <?= $mer ?> value="merchant"><?= $forgotpass_merchant ?></option>
                  <option <?= $aff ?> value="affiliate"><?= $forgotpass_affiliate ?></option>
                </select>
              </td>
            </tr>
            <tr height="30" align="center">
              <td height="20" align="right"><?= $forgotpass_email ?> :</td>
              <td width="61%" height="20" align="left">
                &nbsp;&nbsp;&nbsp;
                <input name="login" type="text" size="25">
              </td>
            </tr>
            <tr height="30">
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;
                <input name="Get Password" type="submit" size="13" value="<?= $forgotpass_submit ?>">
              </td>
            </tr>
          </form>
        </table>
      </td>
    </tr>
    <tr>
      <td><img src="images/affiliate-bottom.jpg" width="349" height="10" /></td>
    </tr>
  </table>
</body> -->

<?php
include('includes/footer.php');
?>