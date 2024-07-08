<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial;
    }

    /* Style the tab */
    .tab {
      overflow: hidden;
      /* border: 1px solid #ccc;*/
      background-color: #f9f9f9;
    }

    /* Style the buttons inside the tab */
    .tab a {
      background-color: inherit;
      float: left;
      outline: none;
      cursor: pointer;
      padding: 8px 10px;
      transition: 0.3s;
      font-size: 13px;
      color: #000000;
      border: 1px solid #ccc;
    }

    /* Change background color of buttons on hover */
    .tab a:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab a.active {
      background-color: #ffffff;
      border-bottom: none;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
  </style>
</head>

<body>
  <?php
  /***************************************************************************************************
                    PROGRAM DESCRIPTION :  PROGRAM TO VIEW AND EDIT THE AFFILIATES pgms -HELP
                       VARIABLES          : all             =TOTAL NO OF pgms
 							 			  waiting			=waiting   pgms
                                          approved			=approved  pgms
                                          suspend   		=suspended  pgms
                                          pending			=pgms with pending transcation
          //*************************************************************************************************/

  $joinstatus = trim($_REQUEST['joinstatus']);
  /*****************************Get Affiliate Currency*******************/
  // $q = "SELECT affiliate_currency FROM partners_affiliate WHERE affiliate_id ='$AFFILIATEID'";
  // $res = mysqli_query($con, $q);
  // while ($row = mysqli_fetch_assoc($res)) {
  //   $curr_value = $row['affiliate_currency'];
  // }
  /*****************************list affiliate pgms*******************/
  $affiliateid = $_SESSION['AFFILIATEID'];

  //================getting total no of programs joined by affiliate
  $sql_all   = "SELECT COUNT(program_id) FROM partners_program, partners_merchant WHERE   program_status LIKE ('active')
 AND merchant_status LIKE ('approved')  AND program_merchantid=merchant_id";
  // $sql_all   = "SELECT COUNT(program_id)  FROM partners_program WHERE program_status = 'active' ";
  $ret_all     = mysqli_query($con, $sql_all);
  list($all)   = mysqli_fetch_row($ret_all);

  //===================getting total no of waiting programs joined by affiliate  
  $sql_wait   = "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm, partners_merchant
    WHERE joinpgm_status='waiting'  AND joinpgm_affiliateid='$AFFILIATEID' 
 AND program_status = 'active' AND merchant_status LIKE ('approved') AND joinpgm_programid = program_id AND program_merchantid = merchant_id";
  $ret_wait     = mysqli_query($con, $sql_wait);
  list($waiting) = mysqli_fetch_row($ret_wait);

  //=================getting total no of approved programs joined by affiliate
  $sql_approved   = "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm, partners_merchant
    WHERE joinpgm_status='approved'  AND joinpgm_affiliateid='$AFFILIATEID' 
 AND program_status = 'active' AND merchant_status LIKE ('approved') AND joinpgm_programid = program_id AND program_merchantid = merchant_id";
  $ret_approved     = mysqli_query($con, $sql_approved);
  list($approved)  = mysqli_fetch_row($ret_approved);

  //=====================getting total no of waiting suspended programs joined by affiliate
  $sql_suspend   = "SELECT COUNT(program_id) FROM partners_program, partners_joinpgm, partners_merchant
    WHERE joinpgm_status='suspend'  AND joinpgm_affiliateid='$AFFILIATEID' 
 AND program_status = 'active' AND merchant_status LIKE ('approved') AND joinpgm_programid = program_id AND program_merchantid = merchant_id";

  $ret_suspend = mysqli_query($con, $sql_suspend);
  list($suspend) = mysqli_fetch_row($ret_suspend);


  //getting total no of  programs not joined by affiliate
  $notjoin     = $all - ($approved + $waiting + $suspend);

  /*******************************************************************/
  ?>

  <script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
  </script>

</body>

</html>

<div class="tab">
  <a class="nav-link <?= ($joinstatus == 'All' ? ' active ' : '') ?>" href="index.php?Act=Affiliates&amp;joinstatus=All">Total Programs(<?= "$all" ?>)</a>
  <a class="nav-link <?= ($joinstatus == 'approved' ? ' active ' : '') ?>" href="index.php?Act=Affiliates&amp;joinstatus=approved">
    <img alt="" border="0" height="<?= $icon_height ?>" width="<?= $icon_width ?>" src="../images/approved.gif" />Approved(<?= "$approved" ?>) </a>

  <a class="nav-link <?= ($joinstatus == 'waiting' ? ' active ' : '') ?>" href="index.php?Act=Affiliates&amp;joinstatus=waiting">
    <img alt="" border="0" height="<?= $icon_height ?>" width="<?= $icon_width ?>" src="../images/waiting.gif" /> &nbsp;
    Waiting(<?= "$waiting" ?>)
  </a>
  <a class="nav-link <?= ($joinstatus == 'suspend' ? ' active ' : '') ?>" href="index.php?Act=Affiliates&amp;joinstatus=suspend">
    <img alt="" border="0" height="<?= $icon_height ?>" width="<?= $icon_width ?>" src="../images/suspend.gif" /> &nbsp;
    Suspend (<?= "$suspend" ?>)
  </a>
  <a class="nav-link <?= ($joinstatus == 'notjoined' ? ' active ' : '') ?>" href="index.php?Act=Affiliates&amp;joinstatus=notjoined">
    <img alt="" border="0" height="<?= $icon_height ?>" width="<?= $icon_width ?>" src="../images/notjoined.gif" />&nbsp;
    <?= $lang_aff_notjoined ?> (<?= "$notjoin" ?>)

  </a>
</div>

<div id="London" class="tabcontent">

</div>

<div id="Paris" class="tabcontent">

  &nbsp;
  <?= $lang_aff_approved ?> (<?= "$approved" ?>)
  </a>
</div>


<!-- <ul class="nav nav-tabs">
  <li class="nav-item ">
   
  </li>
  <li class="nav-item">
  
  </li>
  <li class="nav-item">
  
  </li>
  <li class="nav-item">
  
  </li>


<li class="nav-item">
  
</li>

</ul>
 -->