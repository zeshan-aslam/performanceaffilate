<?php

/**

 * Functions Class

 * @author Gulfam Khan

 * @copyright 2021

 */
class custom_functions
{

    #Top affiliates totals
    public $topAffImpressions, $topAffClicks, $topAffCommission, $topAffSalesNumbers, $topAffSalesValues;

    public function makeSidebar()
    {
        global $db, $custom_fun, $user;
        $accessAreas      = $user->getUserAreas();
        foreach ($accessAreas as $key => $accessArea) {
            $putInWhere .= $accessArea . ",";
        }
        $putInWhere = rtrim($putInWhere, ",");
        $makeWhare  = 'id IN (' . $putInWhere . ') AND isActive = 0';
        $superCates = $db->baseSelect('sidebar_sup_clone', $makeWhare);

        #Stop access to not allowed pages
        $exactPage  = basename($_SERVER['PHP_SELF']);

        if ($exactPage != 'index.php') {

            $pageCate   = $db->baseSelect('sidebar_subClone', 'sub_menu_link = "' . $exactPage . '" ');
            #Get user who have access to specific category
            if (!in_array($pageCate['main_cate'], $accessAreas)) {
                //$custom_fun->redirect_page('login.php');  
            }
        }

        foreach ($superCates as $key => $superCate) {
            if ($pageCate['main_cate'] == $superCate['id']) {
                $supActive = 'active';
            } else {
                $supActive = '';
            }
            echo       '<li class="sub-menu ' . $supActive . ' ">
                    <a href="javascript:;" class="">
                        <i class="' . $superCate['cateIcon'] . '"></i>
                        <span>' . $superCate['menu_title'] . '</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub">';

            #Get sub categories 
            //$subCates   = $db->baseSelect('sidebar_subClone', 'main_cate = '.$superCate['id'].' AND isSidebar = 1  ');  

            $subCateSql = " SELECT * FROM " . PREFIX . "sidebar_subClone WHERE main_cate = " . $superCate['id'] . " AND isSidebar = 1 ";

            if ($db->number_rows_hide($subCateSql) > 1) {
                $subCates = $db->fetch_all($subCateSql);
                foreach ($subCates as $key => $subCate) {
                    if ($exactPage == $subCate['sub_menu_link']) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    echo '<li class="' . $active . '"><a class="" href="' . $subCate['sub_menu_link'] . '">' . $subCate['sub_menu_title'] . '</a></li>';
                }
            } else {
                $subCate = $db->fetch_single_row($subCateSql);
                echo '<li class="' . $active . '"><a class="" href="' . $subCate['sub_menu_link'] . '">' . $subCate['sub_menu_title'] . '</a></li>';
            }


            echo           '</ul>
                </li>';
        }
    }

    public function addInAccess($supCate = null, $subCate = null, $cont = 'show')
    {
        global $db;
        if ($cont == 'show' && empty($supCate) && empty($subCate)) {
            $getSupSql = "SELECT * FROM " . PREFIX . "sidebar_sup";
            $getSup = $db->fetch_all($getSupSql);
            $this->showPre($getSup);
            $pageName = basename($_SERVER['PHP_SELF']);
            print("<br> PageName: " . $pageName);
            exit();
        } else {
            $pageName = basename($_SERVER['PHP_SELF']);
            $dupSql = "SELECT * FROM " . PREFIX . "sidebar_sub WHERE sub_menu = '" . $pageName . "' ";
            if ($db->number_rows_hide($dupSql) < 1) {
                $accessData = array(
                    'main_cate' => $supCate,
                    'sub_menu' => $subCate,
                );
                $db->insert_values($accessData, 'sidebar_sub', 'hide');
            }
        }
    }

    public function GET_SEP_URL($GB = 'c')
    {
        if ($GB == 'C') {
            return $_SERVER['HTTP_REFERER'] . $_SERVER['QUERY_STRING'];
        } else {
            return $_SERVER['HTTP_REFERER'];
        }
    }

    public function GET_SEP_URLII($GB = 'C')
    {
        if ($GB == 'C') {
            #$_SERVER[HTTP_HOST]
            return $_SERVER[REQUEST_URI];
        } else {
            return $_SERVER['HTTP_REFERER'];
        }
    }

    public function showPre($arr)
    {
        echo "<pre>";
        print_r($arr);
        echo "</pre>";
    }

    public function modiDate($sepDate, $choice, $number)
    {
        return $DatetoRet = date('Y-m-d', strtotime($sepDate . ' ' . $choice . ' ' . $number . ' days'));
    }

    public function objection_stuff($table, $col)
    {

        global $db, $user;
        $current_user = $user->get_current_user()['first_name'];
        $set_active = $db->fetch_single_row("SELECT " . $col . " FROM " . PREFIX . $table . " WHERE id=" . $_GET['id']);

        if ($set_active[$col] == "1") {
            if ($user->is_login_admin()) {
                $SQL = "UPDATE " . PREFIX . $table . " SET " . $col . "=0, obj_by='" . "" . "' WHERE id =" . $_GET['id'];
                $db->run_query($SQL);
                global $custom_fun;
                $custom_fun->redirect_page($_SERVER['HTTP_REFERER']);
            } else {
                //header('Location: ' . $_SERVER['HTTP_REFERER']);
                //echo "<script>setTimeout(\"location.href = '".$_SERVER['HTTP_REFERER']."';\",2500);</script>";
                global $custom_fun;
                $custom_fun->redirect_page($_SERVER['HTTP_REFERER']);

                echo '

                   <div id="s_msg" style="margin-top:100px; width:400px;">

                   <div class="alert alert-error">

                       <strong>Error!</strong>Only admin remove this objection.
                       </div>

                       </div>

                       ';
            }
        } else {
            $SQL = "UPDATE " . PREFIX . $table . " SET " . $col . "=1, obj_by='" . $current_user . "' WHERE id =" . $_GET['id'];
            $db->run_query($SQL);
            global $custom_fun;
            $custom_fun->redirect_page($_SERVER['HTTP_REFERER']);
        }
    }

    // Function to get the client IP address
    public function getIP()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public function getSystemInfo()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows phone 8/i' => 'Windows Phone 8',
            '/windows phone os 7/i' => 'Windows Phone 7',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );
        $found = false;
        $addr = new RemoteAddress;
        $device = '';
        foreach ($os_array as $regex => $value) {
            if ($found) {
                break;
            } else if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
                $device = !preg_match('/(windows|mac|linux|ubuntu)/i', $os_platform)
                    ? 'MOBILE' : (preg_match('/phone/i', $os_platform) ? 'MOBILE' : 'SYSTEM');
            }
        }
        $device = !$device ? 'SYSTEM' : $device;
        return array('os' => $os_platform, 'device' => $device);
    }

    public function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if ($found) {
                break;
            } else if (preg_match($regex, $user_agent, $result)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    public function delete_popup_bd($tbl, $title_field, $ref_page, $pre_id = "del", $conti_class = "cm_del")
    {
        #conti_class: remove the ambugivity when function calls are multiple
        global $db;
        $all_data = $db->fetch_all("SELECT  id, " . $title_field . " FROM " . PREFIX . $tbl);
        foreach ($all_data as $key => $fet_data) {
            echo '
                    <div id="' . $pre_id . $fet_data['id'] . '" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 id="myModalLabel3">Confirm Delete</h3>
                    </div>
                    <div class="modal-body">
                        <p>Are you Sure! to want delete ' . $fet_data[$title_field] . ' ?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        <button data-dismiss="modal" class="btn btn-primary ' . $conti_class . ' " id="' . $fet_data['id'] . '">Confirm</button>
                    </div>
                </div>';
            echo
            '<script src="../js/jquery-1.8.3.min.js"></script>
                <script>
                $(document).ready(function(){

                    $(".' . $conti_class . '").click(function(){

                         var id = $(this).attr("id");
                         window.location.replace("' . $ref_page . '.php?id="+id);
                    });
                });
                </script>';
        }
    }

    public function delete_popup($tbl, $title_field, $ref_page, $pre_id = "del", $conti_class = "cm_del")
    {

        #Prams Expalined:
        #conti_class: remove the ambugivity when function calls are multiple

        global $db, $sec;
        $all_data = $db->fetch_all("SELECT  id, " . $title_field . " FROM " . PREFIX . $tbl);
        foreach ($all_data as $key => $fet_data) {
            echo
            '<div class="modal fade" id="' . $pre_id . $sec->encode_it($fet_data['id']) . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                </div>
                                <div class="modal-body">
                                   <p>Are you Sure! to want delete ' . $fet_data[$title_field] . ' ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary ' . $conti_class . '" id="' . $sec->encode_it($fet_data['id']) . '">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>';
            echo
            '<script src="' . SITEURL . '/assets/js/jquery-1.10.2.js"></script>
                <script>
                $(document).ready(function(){

                    $(".' . $conti_class . '").click(function(){

                         var id = $(this).attr("id");
                         window.location.replace("' . $ref_page . '?' . SENTID . '="+id);
                    });
                });
                </script>';
        }
    }

    public function show_ack($msg, $case)
    {
        switch ($case) {
            case '1':

                echo
                '<div class="alert alert-success">
                                <button data-dismiss="alert" class="close">×</button>
                                <strong>Success!</strong> ' . $msg . '
                      </div>';
                break;

            case '0':
                echo
                '<div class="alert alert-error">
                                <button data-dismiss="alert" class="close">×</button>
                                <strong>Error!</strong> ' . $msg . '
                      </div>';
                break;

            default:
                echo '
                       <div id="s_msg" style="margin-top:100px; width:100%;">
                       <div class="alert alert-error">
                       <strong>Error:</strong> Please Provide TRUE(1) or FALSE(0) as third parameter.
                       </div>
                       </div>
                             ';
                break;
        }
    }

    public function file_upload($file_from, $dir = null, $type)
    {
        global $user;
        if ($type == 'image') {
            $DEC_DIR = UPLOAD_DIR;
        }

        if ($type == 'other') {
            //$DEC_DIR = UPLOADED_FILES;
            $DEC_DIR = 'UPLOADS/FILES/';
        }

        if ($user->is_login_admin()) {
            $targetfolder = $DEC_DIR . $dir;
        }

        $file_name = date('Y-m-d') . time() . $_FILES[$file_from]['name'];
        $targetfolder = $targetfolder . basename($file_name);

        if (move_uploaded_file($_FILES[$file_from]['tmp_name'], $targetfolder)) {
            return $file_name;
        } else {
            $this->show_ack(FILE_UPLOAD_ERROR, 0);
        }
    }

    public function make_thumb($src, $dest, $desired_width)
    {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }

    public function date_diff($date_1, $date_2, $caption = null)
    {
        $date1 = new DateTime($date_1);
        $date2 = new DateTime($date_2);
        $diff = $date1->diff($date2);
        echo "<span> " . $caption . ": " . $diff->y . " years, " . $diff->m . " months, " . $diff->d . " days";
    }

    public function d_format($date, $format)
    {
        $date_ob = date_create($date);
        $final_date = date_format($date_ob, $format);
        return $final_date;
    }

    public function toMonth($month)
    {
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        return $monthName;
    }
    /*Start JS Functions*/

    public function validate_it($data, $cons_con = null, $step_back)
    {

        $cons_fields = null;
        $cons_vars = null;
        $count = null;

        foreach ($data as $key => $val_arr) {

            $count++;
            $cons_fields .= 'var_' . $key . ' = document.getElementById("' . $val_arr . '").value;  ';
            $cons_vars .= 'var_' . $key . " == '' || ";
            $req_line .= "var_" . $key . ".after('<span class='error'>* Please fill out this field</span>');";

            $cons_if .= "if(var_" . $key . " == '' ){
                 var e_f = document.getElementById('e_msg" . $count . "');
                 if(e_f){
                 e_f.remove();
                 }
                 $('#" . $key . "').after('<span id=\"e_msg" . $count . "\" class=\"error\">Please fill out this field<br></span>');
                 //$('#" . $key . "').attr(\"placeholder\", \"Please fill out this field<br>\");
                 //$('#" . $key . "').addClass('plh');
                 }
                 ";
        }

        echo
        "   <script type='text/javascript'>
      function vali_" . $cons_con . "(){
        " . $cons_fields . "
        if(" . rtrim($cons_vars, " || ") . "){
          var bbtn = document.getElementById('" . $step_back . "');
          bbtn.click();
          " . $cons_if . "
        }
      }
    </script>";
    }

    public function hide_it($on_it, $f_hide1 = null, $f_hide2 = null, $f_hide3 = null)
    {
        echo
        "
 <script>
$('#" . $f_hide1 . "').hide();
$('#" . $f_hide2 . "').hide();
$('#" . $f_hide3 . "').hide();

 $('#" . $on_it . "').change(
      function(){
      var sp_val = $('#" . $on_it . "').val();
      if (sp_val == 1)
         {
           $('#" . $f_hide1 . "').show();
           $('#" . $f_hide2 . "').show();
           $('#" . $f_hide3 . "').show();
         }

      else
         {
           $('#" . $f_hide1 . "').hide();
           $('#" . $f_hide2 . "').hide();
           $('#" . $f_hide3 . "').hide();
         }
      });
</script>
 ";
    }

    public function hide_it_conditional($on_it, $ref_1, $ref_2, $f_hide1 = null, $f_hide2 = null, $f_hide3 = null)
    {
        echo
        "
 <script>
$('#" . $f_hide1 . "').hide();
$('#" . $f_hide2 . "').hide();
$('#" . $f_hide3 . "').hide();

 $('#" . $on_it . "').change(
      function(){
      var sp_val = $('#" . $on_it . "').val();
      if (sp_val == " . $ref_1 . ")
         {
           $('#" . $f_hide1 . "').show();
           $('#" . $f_hide2 . "').hide();
           $('#" . $f_hide3 . "').show();
         }

      if (sp_val == " . $ref_2 . ")
         {
           $('#" . $f_hide1 . "').hide();
           $('#" . $f_hide2 . "').show();
           $('#" . $f_hide3 . "').hide();
         }

      else
        {
         $('#" . $f_hide1 . "').hide();
         $('#" . $f_hide2 . "').hide();
         $('#" . $f_hide3 . "').hide();
        }

      });
</script>
 ";
    }

    public function acc_select($on_it, $ref_page, $res_div)
    {

        echo
        '<script type="text/javascript">
  $(document).ready(function(){
      $("#' . $on_it . '").change(function(){
          var sel_opt = $("#' . $on_it . ' option:selected").val();
          $.ajax({
              type: "POST",
              url: "' . SITEURL . $ref_page . '",
              data: { id : sel_opt }
          }).done(function(data){
              $("#' . $res_div . '").html(data);
          });
      });
  });
  </script>';
    }

    public function loadAjax($refId, $ref_page, $res_div)
    {
        echo
        '<script type="text/javascript">
        $(document).ready(function(){
            var refId = ' . $refId . ' ;
                $.ajax({
                    type: "POST",
                    url: "' . SITEURL . $ref_page . '",
                    data: { consID : refId }
                }).done(function(data){
                    //$("#' . $res_div . '").html(data);
                    $("#' . $res_div . '").load("' . $ref_page . '");
                });
        });
        </script>';
    }

    public function acc_click($data, $on_it, $ref_page, $res_div, $ref = "#")
    {

        foreach ($data as $key => $valData) {
            $varsJs .= 'var v' . $key . ' = $("' . $ref . '' . $valData . '").val();';
            $varData .= ' ' . $key . ': v' . $key . ', ';
        }

        echo
        '<script type="text/javascript">
    $(document).ready(function(){
        $("' . $ref . '' . $on_it . '").click(function(){
            ' . $varsJs . '
            $.ajax({
                type: "POST",
                url: "' . $ref_page . '",
                data: { ' . $varData . ' }
            }).done(function(data){
                $("' . $ref . '' . $res_div . '").html(data);
            });
        });
    });
    </script>';
    }

    public function acc_click_clone($data, $on_it, $ref_page, $res_div, $ref = "#")
    {
        $backToRaw = substr($on_it, 3);
        
        if($backToRaw == 1){
          $backTo = 1;  
        }else{
          $backTo    = ($backToRaw - 1);
        }

        $valArrCont = " const mightEmpty = [   ";
        foreach ($data as $key => $valData) {
            $varsJs .= 'var v' . $key . ' = $("' . $ref . '' . $valData . '").val();';
            $varData .= ' ' . $key . ': v' . $key . ', ';
            $justVars .= 'v'.$key.',';
        }
        $valArrCont .= $justVars;
        $valArrCont .= "];";

    echo
    '<script type="text/javascript">
    $(document).ready(function(){ 
         $("' . $ref . '' . $on_it . '").click(function(){            
            ' . $varsJs . '
             '.$valArrCont.'
             var arrLen = mightEmpty.length;
             var allowNext = true;
              for (var i = 0; i < arrLen; i++) {
                //console.log(mightEmpty[i]);
                  if( mightEmpty[i] == "" ){
                    allowNext = false;
                  }  
              } //End for
              if(allowNext == false ){
                alert("Please fill out all fields values.");
              }
        });
     });

    
    </script>';



    }

    public function in_millions($on_it, $response_div)
    {
        echo
        "<script>
    document.getElementById('" . $on_it . "').onkeyup = function(event) {
    var cmil  = document.getElementById('" . $on_it . "').value/1000000;
    var inmil = '<p>'+cmil+'&nbsp; Million</p>';
    document.getElementById('" . $response_div . "').innerHTML = inmil;
    }
    </script>";
    }

    public function in_pkr($on_it, $response_div)
    {
        echo
        "<script>
    document.getElementById('" . $on_it . "').onkeyup = function(event) {
    var cmil  = document.getElementById('" . $on_it . "').value*1000000;
    var inmil = '<p>'+cmil+'&nbsp; PKR</p>';
    document.getElementById('" . $response_div . "').innerHTML = inmil;
    }
    </script>";
    }

    public function ref_div($outer_div, $inner_div, $cu_interval = 5000)
    {

        echo
        '<script>
      $(document).ready(
      function()
       {
      setInterval(function() {
      $("#' . $outer_div . '").load(location.href+" #' . $outer_div . '>*","");
      $("#' . $inner_div . '").load(location.href+" #' . $inner_div . '>*","");
        }, ' . $cu_interval . ');
       }
      );
      </script>';
    }

    /*End JS Functions*/

    public function update_config()
    {
        global $user, $db;
        $uploaded_logo = $user->img_upload(null, $_FILES['fileToUpload']);

        if ($_FILES['fileToUpload']['size'] == 0) {
            $fetch_data_sql = "SELECT * FROM " . PREFIX . "config";
            $result_fetch = $db->fetch_single_row($fetch_data_sql);
            $f_logo_img = $result_fetch['logo_img'];
            $img_name = $f_logo_img;
        }

        if ($_FILES['fileToUpload']['size'] != 0) {
            $img_name = $uploaded_logo;
        }

        $config_data = array(
            'page_title' => $_POST['page_title'],
            'page_footer' => $_POST['page_footer'],
            'logo_img' => $img_name,
        );
        $db->update_values($config_data, "config", 9);
    }

    public function show_footer()
    {
        global $db;
        $fetch_data_sql = "SELECT * FROM " . PREFIX . "config";
        $result_fetch = $db->fetch_single_row($fetch_data_sql);
        return $f_footer = $result_fetch['page_footer'];
    }

    public function show_title()
    {
        global $db;
        $fetch_data_sql = "SELECT * FROM " . PREFIX . "config";
        $result_fetch = $db->fetch_single_row($fetch_data_sql);
        echo $f_title = $result_fetch['page_title'];
    }

    public function remove_get($url, $varname)
    {
        return preg_replace('/([?&])' . $varname . '=[^&]+(&|$)/', '$1', $url);
    }

    public function redirect_page($location)
    {

        if (!headers_sent()) {

            header('Location: ' . $location);

            exit;
        } else {
            echo '<script type="text/javascript">';
        }

        echo 'window.location.href="' . $location . '";';

        echo '</script>';

        echo '<noscript>';

        echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';

        echo '</noscript>';
    }

    /**

     * Start Japan Industries function

     */
    // function for check

    public function ischeck($id, $att_name)
    {
        global $db;
        $sql_c = "SELECT * FROM " . PREFIX . "car_specs WHERE parent_id=" . $id;
        $chck = $db->fetch_single_row($sql_c);
        if ($chck[$att_name] == '1') {
            echo '<img src="' . SITEURL . 'img/users/tick.png" alt="" width="35" height="35">';
        } else {
            echo '<img src="' . SITEURL . 'img/users/n_tick.jpg" alt="" width="30" height="30">';
        }
    }

    public function list_show()
    {

        global $sec, $db, $custom_fun;

        $def_limit = 100;
        if (!isset($_GET['page']) || $_GET['page'] == 1) {
            $index = 0;
        } else {
            $index = ($def_limit * $_GET['page']) - $def_limit;
        }

        $feature_car = "SELECT * FROM " . PREFIX . "car_details order by id LIMIT " . $index . ", " . $def_limit . " ";

        $fet_car = $db->fetch_all($feature_car);

        foreach ($fet_car as $key => $value) {
            // value fetchh for car brand
            $fet_brand = "SELECT * FROM " . PREFIX . "car_brands WHERE id=" . $value['make'];
            $fet_brand_det = $db->fetch_single_row($fet_brand);
            //value fetch for seats
            $fet_seats = "SELECT * FROM " . PREFIX . "car_seats WHERE id=" . $value['seats'];
            $fet_seat_det = $db->fetch_single_row($fet_seats);
            //value fetch for petrol
            $fet_fuel = "SELECT * FROM " . PREFIX . "fuel_typs WHERE id=" . $value['fuel'];
            $fet_fuel_det = $db->fetch_single_row($fet_fuel);
            // value fetch for doors
            $fet_doors = "SELECT * FROM " . PREFIX . "car_doors WHERE id=" . $value['doors'];
            $fet_door_det = $db->fetch_single_row($fet_doors);
            //value for year
            $fet_yr = "SELECT * FROM " . PREFIX . "mdl_years WHERE id=" . $value['year'];
            $fet_years = $db->fetch_single_row($fet_yr);

            //value for color

            $fet_clr = "SELECT * FROM " . PREFIX . "car_clrs WHERE id=" . $value['color'];
            $fet_cl = $db->fetch_single_row($fet_clr);

            $fet_img_thumb_SQL = "SELECT * FROM " . PREFIX . "rel_images WHERE parent_id = " . $value['id'] . " LIMIT 1";

            echo "<div class='listing'>" . "<a href='details.php?id=" . $sec->encode_it($value['id']) . "'>"
                . "<div class='image' style='background-image:url(" . SITEURL . "en-sys/img/car_cons_imgs/" . $db->fetch_single_row($fet_img_thumb_SQL)['img'] . ");'> </div>"

                //details

                . "</div>"
                /*end .detail*/
                . "<div class='content'>"
                . "<div class='title'>Maker :" . $fet_brand_det['brand_title'] . " || Model : " . $value['model'] . "</div>"
                . "<div><b> CC</b> : " . $value['CC'] . "  <b>Color</b> : " . $fet_cl['clr_title'] . "</div>"

                . "<div><b>Year </b> : " . $fet_years['mdl_yr'] . " <b>Starting from</b>" . $value['st_bid_frm'] . "</div>"
                . "<div> <b>Auction Date:</b>02/08/2019 <b>Auction Time:</b>02:08:00</div>"
                . "</table>"
                . "<div class='button border'>View Detials</div> "
                . "</div>"
                /*end .content*/
                . "</a>"

                /* <!-- end .listing -->*/;
        } //foreach

        #Paginatin portion
        $pages = array();
        $pages_ref = $db->number_rows_hide('SELECT id FROM ' . PREFIX . 'car_details ');
        $count_pge = 1;
        $dev_page = round($pages_ref / $def_limit) + 1;

        echo
        '<div class="pagination-wrapper">
<nav>
<ul class="pagination">';
        for ($i = 1; $i <= $dev_page; $i++) {
            echo "<li><a href='listing-list-view.php?page=" . $i . "'>" . $i . "</a></li>";
        }
        echo
        '</ul>
</nav>
</div>';
    }
    public function feature_show()
    {

        global $sec, $db, $custom_fun;
        $feature_car = "SELECT * FROM " . PREFIX . "car_details WHERE feature_car= 1";
        $fet_car = $db->fetch_all($feature_car);
        foreach ($fet_car as $key => $value) {
            // value fetchh for car brand
            $fet_brand = "SELECT * FROM " . PREFIX . "car_brands WHERE id=" . $value['make'];
            $fet_brand_det = $db->fetch_single_row($fet_brand);
            //value fetch for seats
            $fet_seats = "SELECT * FROM " . PREFIX . "car_seats WHERE id=" . $value['seats'];
            $fet_seat_det = $db->fetch_single_row($fet_seats);
            //value fetch for petrol
            $fet_fuel = "SELECT * FROM " . PREFIX . "fuel_typs WHERE id=" . $value['fuel'];
            $fet_fuel_det = $db->fetch_single_row($fet_fuel);
            // value fetch for doors
            $fet_doors = "SELECT * FROM " . PREFIX . "car_doors WHERE id=" . $value['doors'];
            $fet_door_det = $db->fetch_single_row($fet_doors);
            // value fetch for condition
            $fet_con = "SELECT * FROM " . PREFIX . "car_condition WHERE id=" . $value['condshn'];
            $fet_cond = $db->fetch_single_row($fet_con);
            // value fetch for transmission
            $fet_tra = "SELECT * FROM " . PREFIX . "car_trans WHERE id=" . $value['transmission'];
            $fet_trans = $db->fetch_single_row($fet_tra);

            $fet_img_thumb_SQL = "SELECT * FROM " . PREFIX . "rel_images WHERE parent_id = " . $value['id'] . " LIMIT 1";

            echo " <div class='item'  >" . "<div class='featured-car' >" . "<a href='details.php?id=" . $sec->encode_it($value['id']) . "'>" .
                "<div class='image'>"

                . "<img src='" . SITEURL . "en-sys/img/car_cons_imgs/" . $db->fetch_single_row($fet_img_thumb_SQL)['img'] . "'>" .
                "<span class='sale-tag'>For sale " . $fet_cond['car_cndshn_rate'] . "</span>"

                . "</div>"
                . "<div class='content'>"
                . "<div class='clearfix'>"
                . "<h5>" . $value['model'] . "</h5>"
                . "<span class='price'>" . $value['st_bid_frm'] . "/</span>"
                . "</div>"
                . "</div>"
                . "<div class='line'></div>"
                . "<p>Bid Date:20/12/2019</p>"
                . "<div class='details clearfix'>"
                . "<div class='seats'>" . $fet_brand_det['brand_title'] . "</div>"
                . "<div class='fuel'>1300cc</div>"
                . "<div class='type'>" . $fet_trans['trans_title'] . "
</div>"
                . "</div>"
                . "</div>"
                . "</a>"
                . "</div>";
        }
    }
    public function count_time($tar_date, $tar_time)
    {
    }

    public function manage_days()
    {
        global $db, $sec, $custom_fun;
        $day_query = "SELECT * FROM " . PREFIX . "car_list";
        $day_fetch = $db->fetch_all($day_query);

        foreach ($day_fetch as $key => $value) {
            $fet_brand = "SELECT * FROM " . PREFIX . "car_brands WHERE id=" . $value['maker'];
            $fet_brand_det = $db->fetch_single_row($fet_brand);

            $fet_yr = "SELECT * FROM " . PREFIX . "mdl_years WHERE id=" . $value['year'];
            $fet_years = $db->fetch_single_row($fet_yr);

            $fet_tra = "SELECT * FROM " . PREFIX . "car_trans WHERE id=" . $value['trans'];
            $fet_trans = $db->fetch_single_row($fet_tra);

            $fet_con = "SELECT * FROM " . PREFIX . "car_condition WHERE id=" . $value['condshn'];
            $fet_cond = $db->fetch_single_row($fet_con);

            $FOR_SENT_ID = $sec->encode_it($value['id']);
            $cons_img_thumb_SQL = "SELECT * FROM " . PREFIX . "rel_images WHERE parent_id = " . $value['id'] . " LIMIT 1";

            echo "<tr class='odd gradeX'><td clas='hidden-phone'>" . $value['id'] . "</td>" .
                "<td clas='hidden-phone'>" . "<img style='border: 4px solid; border-radius: 10px !important;' src='" . SITEURL . "img/thumbs/" . $value['img'] . "' alt='NO_IMG'>" . "</td>" .
                "<td clas='hidden-phone'>" . $fet_brand_det['brand_title'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_years['mdl_yr'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['cc'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_trans['trans_title'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['kms'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_cond['car_cndshn_rate'] . "</td>" .
                "<td clas='hidden-phone'>02:09:00</td>" .
                "<td clas='hidden-phone'>09/09/2019</td>" .
                "<td clas='hidden-phone'>02:09:00</td>" .
                "<td clas='hidden-phone'>sold</td>" .
                '<td class="hidden-phone">
      <div class="btn-group">
      <button class="btn btn-mini">Action</button>
      <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
      <ul class="dropdown-menu">
<li><a data-toggle="modal" data-target="#del' . $value['id'] . '"><i class="icon-trash"></i>Dlete</a></li>
 </ul>
</div>
</td>' .
                '</tr>';

            /*delete model*/
            echo "<div id='del" . $value['id'] . "' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel3' aria-hidden='true'>
<div class='modal-body'>
<p>Are you Sure! to permanently delete?</p>
</div>
<div>
<form action='' method='POST'>
<input type=hidden name='fet_del_id' value=" . $value['id'] . ">
<center><input type='submit' class='btn btn-danger'  name='delete' value='delete' />
<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
</center>
</form>
</div>
</div>";
            /*End DELETE ModeL*/

            /*Delete Module*/
            if (isset($_POST['delete'])) {
                $del_qry = "DELETE FROM " . PREFIX . "car_list WHERE id=" . $_POST['fet_del_id'];
                $db->run_query($del_qry);
                $custom_fun->redirect_page(SITEURL . 'ALASA/TODAY-LIST.php?');
            }
            /*End*/
        }
    }
    /*For Front End Page Auctions*/
    public function show_stock()
    {
        global $db, $sec, $custom_fun;
        $day_query = "SELECT * FROM " . PREFIX . "car_list";
        $day_fetch = $db->fetch_all($day_query);

        foreach ($day_fetch as $key => $value) {
            $fet_brand = "SELECT * FROM " . PREFIX . "car_brands WHERE id=" . $value['maker'];
            $fet_brand_det = $db->fetch_single_row($fet_brand);

            $fet_yr = "SELECT * FROM " . PREFIX . "mdl_years WHERE id=" . $value['year'];
            $fet_years = $db->fetch_single_row($fet_yr);

            $fet_tra = "SELECT * FROM " . PREFIX . "car_trans WHERE id=" . $value['trans'];
            $fet_trans = $db->fetch_single_row($fet_tra);

            $fet_con = "SELECT * FROM " . PREFIX . "car_condition WHERE id=" . $value['condshn'];
            $fet_cond = $db->fetch_single_row($fet_con);

            $fet_price = "SELECT * FROM " . PREFIX . "car_details WHERE id=" . $value['auc_no'];
            $fet_bid = $db->fetch_single_row($fet_price);

            $FOR_SENT_ID = $sec->encode_it($value['id']);
            $cons_img_thumb_SQL = "SELECT * FROM " . PREFIX . "rel_images WHERE parent_id = " . $value['id'] . " LIMIT 1";

            echo "<tr class='odd gradeX'><td clas='hidden-phone'>" . $value['id'] . "</td>" .
                "<td clas='hidden-phone'>" . "<img style='border: 4px solid; border-radius: 10px !important;' src='" . SITEURL . "en-sys/img/thumbs/" . $value['img'] . "' alt='NO_IMG'>" . "</td>" .
                "<td clas='hidden-phone'>" . $fet_brand_det['brand_title'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_years['mdl_yr'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['cc'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_trans['trans_title'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['kms'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_cond['car_cndshn_rate'] . "</td>" .
                "<td clas='hidden-phone'>" . $fet_bid['st_bid_frm'] . "/pk</td>" .
                "<td clas='hidden-phone'>09/09/2019</td>" .
                "<td clas='hidden-phone'>02:09:00</td>" .
                "<td clas='hidden-phone'>sold</td>" .
                '</tr>';
        }
    }

    public function manage_bids()
    {
        global $db, $sec, $feature_act;
        $users_fetch_query = "SELECT * FROM " . PREFIX . "car_details order by id";
        $res = $db->fetch_all($users_fetch_query);
        foreach ($res as $key => $value) {

            if ($value['bid_status'] == '1') {
                $bid_act = '<span class="label label-success">current bidding</span>';
            } else {
                $bid_act = null;
            }

            $cap_bid = (!empty($bid_act)) ? ' Close' : ' Active';

            if ($value['feature_car'] == '1') {
                $feature_act_car = '<span class="label label-success">Current Featured </span>';
            } else {
                $feature_act_car = null;
            }
            $feature_act = (!empty($feature_act_car)) ? ' Close' : 'Active';

            /*     if ($value['active'] == '1')
{
$img_active = "<i class='icon-eye-open'></i> Active";
}

else
{
$img_active = "<i class='icon-eye-close'></i> Inactive";
}

if ($value['level_access'] == '1')
{
$lable = "<i class='icon-user'></i>"." Admin";
}

else
{
$lable = "<i class='icon-group'></i>"." User";
}*/

            $FOR_SENT_ID = $sec->encode_it($value['id']);
            $cons_img_thumb_SQL = "SELECT * FROM " . PREFIX . "rel_images WHERE parent_id = " . $value['id'] . " LIMIT 1";

            echo
            "<tr class='odd gradeX'><td clas='hidden-phone'>" . $value['id'] . "</td>" .
                "<td clas='hidden-phone'>" . "<img style='border: 4px solid; border-radius: 10px !important;' src='" . SITEURL . "img/thumbs/" . $db->fetch_single_row($cons_img_thumb_SQL)['img'] . "' alt='NO_IMG'>" . "</td>" .
                "<td clas='hidden-phone'>" . $value['model'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['ad_post_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . $bid_act . "</td> " .
                "<td clas='hidden-phone'>" . $feature_act_car . "</td> " .
                '<td class="hidden-phone">
               <div class="btn-group">
                    <button class="btn btn-mini">Action</button>
                    <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                        <li><a href="' . SITEURL . 'ALASA/MANAGE-BIDS.php/?' . SENTID . '=' . $FOR_SENT_ID . '&ACTION=ADD_LIST"><i class="icon-eye-open"></i>Add TodayList</a></li>
                            <li><a href="' . SITEURL . 'ALASA/MANAGE-BIDS.php/?' . SENTID . '=' . $FOR_SENT_ID . '&ACTION=BID_ST"><i class="icon-eye-open"></i>' . $cap_bid . ' bidding</a></li>

                            <li><a href="' . SITEURL . 'ALASA/MANAGE-BIDS.php/?' . SENTID . '=' . $FOR_SENT_ID . '&ACTION=FEATURE"><i class="icon-eye-open"></i>' . $feature_act . ' Featured</a></li>

                            <li><a href="' . SITEURL . 'ALASA/ED_CAR_DET.php/?' . SENTID . '=' . $FOR_SENT_ID . '&ACTION=' . EC . '"><i class="icon-edit"></i> Edit</a></li>
                            <li><a data-toggle="modal" data-target="#del' . $sec->encode_it($value['id']) . '"><i class="icon-trash"></i> Dlete</a></li>
                            <li><a href="' . SITEURL . 'BUSA/dashboard_users/?' . SENTID . '=' . $sec->encode_it($value['id']) . '&ACTION=active"><i class="icon-user"></i>Active/Inactive </a></li>
                            </ul>
                </div>
            </td>
            </tr>';
        }
    }

    public function show_alert($msg = 'Success')
    {
        echo
        '<script type="text/javascript">
   alert("' . $msg . '");
   </script>
  ';
    }

    public function send_mail($to, $subject, $msg)
    {

        #$headers .= "CC: sombodyelse@example.com\r\n";
        #$headers .= "BCC: hidden@example.com\r\n";
        $headers  = "X-Mailer: PHP" . phpversion() . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: info@searlco.com\r\n";
        $headers .= "Reply-To: noreply@searlco.com\r\n";
        $headers .= "Return-Path: info@searlco.com\r\n";
        mail($to, $subject, $msg, $headers);
        return true;
    }

    public function show_popup($cnt = null)
    {

        echo
        '<div id="myModal4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel4">Alert</h3>
    </div>
    <div class="modal-body">
        <p>' . $cnt . '</p>
    </div>
    <div class="modal-footer">
        <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
        <button data-dismiss="modal" class="btn btn-success">Close</button>
    </div>
</div>';
    }

    public function try_popup()
    {
        echo
        '<script type="text/javascript">
     $("#myModal4").modal("show");
   </script>';
    }

    ## AN-APP Start

    public function show_existing_visitors()
    {

        global $db;
        $vis_fetch_query = "SELECT * FROM " . PREFIX . "vistors";
        $res = $db->fetch_all($vis_fetch_query);
        $counter = null;
        foreach ($res as $key => $value) {
            $counter++;
            $pulsate = '<a href="javascript:;" class="btn" id="pulsate-regular">Pulsate regular</a>';
            #cons date
            $dte_sql = "SELECT * FROM " . PREFIX . "web_dte WHERE id = " . $value['cons_dte'];
            echo
            "<tr class='odd gradeX'><td clas='hidden-phone'>" . $counter . "</td>" .
                "<td class='hidden-phone'>" . $value['full_nme'] . "</td>" .
                "<td class='hidden-phone'>" . $value['sep_email'] . "</td>" .
                "<td class='hidden-phone'>" . $value['sep_phone'] . "</td>" .
                "<td class='hidden-phone'>" . $db->fetch_single_row($dte_sql)['web_dte'] . "</td>" .
                '</tr>';
        }
    }

    public function show_existing_att()
    {

        global $db;
        $vis_fetch_query = "SELECT * FROM " . PREFIX . "vistors";
        $res = $db->fetch_all($vis_fetch_query);
        $count = null;
        foreach ($res as $key => $value) {
            $count++;
            $pulsate = '<a href="javascript:;" class="btn" id="pulsate-regular">Pulsate regular</a>';
            #cons date
            $dte_sql = "SELECT * FROM " . PREFIX . "web_dte WHERE id = " . $value['cons_dte'];
            $cons_webi = "SELECT webi_nme FROM " . PREFIX . "sh_webinar WHERE id =" . $value['cons_webinar'];

            echo
            "<td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $value['full_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['sep_email'] . "</td>" .
                "<td clas='hidden-phone'>" . $db->fetch_single_row($cons_webi)['webi_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $db->fetch_single_row($dte_sql)['web_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . '<span class="label label-warning label-mini">' . $value['refered_by'] . '</span>' . "</td>" .
                '<!--<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Send Joining Link <i class="icon-envelope"></i></button>
      </td>
      -->
      </tr>';
        }
    }

    public function show_existing_webinars()
    {

        global $db, $sec;
        $webi_fetch_query = "SELECT * FROM " . PREFIX . "sh_webinar";
        $res = $db->fetch_all($webi_fetch_query);
        $count = null;
        foreach ($res as $key => $value) {
            $pulsate = '<a href="javascript:;" class="btn" id="pulsate-regular">Pulsate regular</a>';

            #cons date
            $dte_sql = "SELECT * FROM " . PREFIX . "web_dte WHERE cons_web = " . $value['id'];
            $fet_dte = $db->fetch_single_row($dte_sql);

            #List of registered users for a specific webinar
            $webi_usrs_sql = "SELECT * FROM " . PREFIX . "vistors WHERE cons_webinar =" . $value['id'];
            $fet_vis = $db->fetch_all($webi_usrs_sql);

            $count++;
            echo
            "<td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $db->number_rows_hide($webi_usrs_sql) . "</td>" .
                "<td clas='hidden-phone'>" . $db->fetch_single_row($dte_sql)['web_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_link'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_pass'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_details'] . "</td>" .
                "<td clas='hidden-phone'><a href='inf_usrs.php?CNSW=" . $sec->encode_it($value['id']) . "'><button class='btn btn-success'><i class='mail-plus'></i> Inform Attendees </button></a></td>" .
                "<!-- <td clas='hidden-phone'>" . '<span class="label label-warning label-mini">Referal- User</span>' . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Send Joining Link <i class="icon-envelope"></i></button>
      </td>-->
      </tr>';
        }
    }

    public function show_user_webinars()
    {

        global $db, $sec, $user;
        $c_l_usr = $user->get_current_user()['id'];

        $sel_webi_sql = "SELECT * FROM " . PREFIX . "usr_webinar WHERE cons_usr = " . $c_l_usr . " AND cons_dte >= '" . date('Y-m-d') . "' ";
        $fet_sel_webi = $db->fetch_all($sel_webi_sql);
        $webi_in = null;

        foreach ($fet_sel_webi as $key => $val_sel_webi) {
            $webi_in .= $val_sel_webi['cons_webinar'] . ",";
        }

        if (sizeof(count(explode(",", $webi_in))) <= 1) {
            $in_st = " = " . rtrim($webi_in, ',');
        } else {
            $in_st = " IN (" . rtrim($webi_in, ",") . ") ";
        }

        $webi_fetch_query = "SELECT * FROM " . PREFIX . "sh_webinar WHERE id " . $in_st . " ";
        $res = $db->fetch_all($webi_fetch_query);
        $count = null;
        foreach ($res as $key => $value) {
            $pulsate = '<a href="javascript:;" class="btn" id="pulsate-regular">Pulsate regular</a>';

            #cons date
            $dte_sql = "SELECT * FROM " . PREFIX . "web_dte WHERE cons_web = " . $value['id'];
            $fet_dte = $db->fetch_single_row($dte_sql);

            #List of registered users for a specific webinar
            $webi_usrs_sql = "SELECT * FROM " . PREFIX . "vistors WHERE cons_webinar =" . $value['id'];
            $fet_vis = $db->fetch_all($webi_usrs_sql);

            $count++;
            echo
            "<td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $db->fetch_single_row($dte_sql)['web_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_link'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_pass'] . "</td>" .
                "<td clas='hidden-phone'><a href='m_account.php?CNSW=" . $sec->encode_it($value['id']) . "'><button class='btn btn-success'><i class='mail-plus'></i> Change it </button></a></td>" .
                "<!-- <td clas='hidden-phone'>" . '<span class="label label-warning label-mini">Referal- User</span>' . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Send Joining Link <i class="icon-envelope"></i></button>
      </td>-->
      </tr>';
        }
    }

    public function available_user_webinars($cons_webi)
    {

        global $db, $sec, $user;
        $c_l_usr = $user->get_current_user()['id'];

        $webi_fetch_query = "SELECT * FROM " . PREFIX . "sh_webinar WHERE id != " . $sec->decode_it($cons_webi) . " ";
        $res = $db->fetch_all($webi_fetch_query);
        $count = null;
        foreach ($res as $key => $value) {
            $pulsate = '<a href="javascript:;" class="btn" id="pulsate-regular">Pulsate regular</a>';

            #cons date
            $dte_sql = "SELECT * FROM " . PREFIX . "web_dte WHERE cons_web = " . $value['id'];
            $fet_dte = $db->fetch_single_row($dte_sql);

            #List of registered users for a specific webinar
            $webi_usrs_sql = "SELECT * FROM " . PREFIX . "vistors WHERE cons_webinar =" . $value['id'];
            $fet_vis = $db->fetch_all($webi_usrs_sql);

            $count++;
            echo
            "<td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $db->fetch_single_row($dte_sql)['web_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_link'] . "</td>" .
                "<td clas='hidden-phone'>" . $value['webi_pass'] . "</td>" .
                "<td clas='hidden-phone'><a href='sel_webi.php?EC=T&NCNSW=" . $sec->encode_it($value['id']) . "&CNSW=" . $_GET['CNSW'] . "'><button class='btn btn-success'><i class='mail-plus'></i> Change to it </button></a></td>" .
                "<!-- <td clas='hidden-phone'>" . '<span class="label label-warning label-mini">Referal- User</span>' . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Send Joining Link <i class="icon-envelope"></i></button>
      </td>-->
      </tr>';
        }
    }

    public function inform_visitors($cons_webi)
    {
        global $db, $sec;
        $cons_vis_sql = "SELECT * FROM " . PREFIX . "vistors WHERE cons_webinar = " . $sec->decode_it($cons_webi);
        $cons_vis_fet = $db->fetch_all($cons_vis_sql);

        #cons webi details
        $webi_sql = "SELECT * FROM " . PREFIX . "sh_webinar WHERE id = " . $sec->decode_it($cons_webi);
        $webi_fet = $db->fetch_single_row($webi_sql);

        #cons mail template
        $mail_fet_sql = "SELECT * FROM " . PREFIX . "webi_mail ";
        $feted_mail = $db->fetch_single_row($mail_fet_sql);

        foreach ($cons_vis_fet as $key => $val_vis) {

            $to_replace = ["cons_person", "cons_link", "cons_pass"];
            $replace_in = [$val_vis['full_nme'], $webi_fet['webi_link'], $webi_fet['webi_pass']];
            echo $mail_body = str_replace($to_replace, $replace_in, $feted_mail['mail_body']);

            $this->send_mail($val_vis['sep_email'], 'Webinar Notification', $mail_body);
            $mail_log_data = array(
                'mail_subject' => 'Webinar Notification',
                'sent_to' => $val_vis['sep_email'],
                'sent_dte' => date('Y-m-d'),
                'mail_body' => $mail_body,
            );
            $db->insert_values($mail_log_data, 'mail_log', 'hide');
        }

        $this->redirect_page($_SERVER['HTTP_REFERER'] . "?SM=S");
    }

    public function show_existing_speakers()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "speakers";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['sep_nme'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['sep_tag'] . "</td>" .
                "<td clas='hidden-phone'><img width='100px' height='100px' src='" . SITEURL . "images/" . $val_sp['sep_img'] . "'/></td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit Info </button>
      </td>
      </tr>';
        }
    }

    public function show_existing_campaigns()
    {

        global $db, $sec;
        if (isset($_REQUEST['STFL'])) {
            $_WHERE = " WHERE status = " . $sec->decode_it($_REQUEST['STFL']);
        } else {
            $_WHERE = null;
        }

         $sp_fetch_query = "SELECT * FROM " . PREFIX . "campaigns " . $_WHERE . " ";
        //$sp_fetch_query = "SELECT * FROM " . PREFIX . "campaigns  INNER JOIN ".PREFIX."camp_details ON ".PREFIX."campaigns.id = ".PREFIX."camp_details.cons_camp    " . $_WHERE . "  ORDER BY ".PREFIX."camp_details.cons_camp  ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        #check is user exists

        foreach ($sp_feted as $key => $val_sp) {

            $checkUserSQL = "SELECT first_name FROM " . PREFIX . "users WHERE first_name LIKE '" . $val_sp['camp_name'] . "%' AND last_name LIKE '" . $val_sp['camp_name'] . "%' ";

            if ($val_sp['status'] == 0) {
                $statusCaption = '<span class="btn btn-mini btn-info" >Pending</span>';
            }
            if ($val_sp['status'] == 1) {
                $statusCaption = '<span class="btn btn-mini btn-success" >Active</span>';
            }
            if ($val_sp['status'] == 2) {
                $statusCaption = '<span class="btn btn-mini btn-danger" >Suspended</span>';
            }
            if ($val_sp['status'] == 3) {
                $statusCaption = '<span class="btn btn-mini btn-warning" >Paused</span>';
            }



            #@ count accounts
            $countAccountSql = "SELECT id FROM " . PREFIX . "users WHERE client_id = " . $val_sp['id'];
            $countAccount = $db->number_rows_hide($countAccountSql);

            #Get client Types
            $clientTypeSql = "SELECT * FROM ".PREFIX."camp_details WHERE cons_camp = '".$val_sp['id']."'  ";
            $clientDet     = $db->fetch_single_row($clientTypeSql);
            $clientType    = $clientDet['accType'];
            
            $typeSql       = "SELECT name FROM ".PREFIX."leads_account_types WHERE id = '".$clientType."' "; 
            $orgClientType = $db->fetch_single_row($typeSql)['name']; 


            #Get Marketing Lead and Accont Manager
            $getMaSql = "SELECT first_name, last_name FROM " . PREFIX ."users WHERE id='".$clientDet ['mar_lead']."'";
            $getMa    = $db->fetch_single_row($getMaSql);

            $getAMSql = "SELECT first_name, last_name FROM " . PREFIX ."users WHERE id='".$clientDet ['aff_man']."'";
            $getAM    = $db->fetch_single_row($getAMSql);

            #Get commission and fee of a client 
            $getComSqlI = "SELECT lead_id FROM ".PREFIX."link_lead_camp WHERE camp_id = '".$val_sp['id']."'";
            $getComI    = $db->fetch_single_row($getComSqlI)['lead_id'];
            $getComSqlII = "SELECT monthly_fee, commission FROM ".PREFIX."done_deals WHERE sale_client_lead_id = '".$getComI."'";
            $getComII    = $db->fetch_single_row($getComSqlII);

            
            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $val_sp['id'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['camp_name'] . "<br> <span style='color: #0daed3;'> ( Lead: ".$getMa['first_name']." ".$getMa['last_name']." |  AM: ".$getAM['first_name']." ".$getAM['last_name']." ) </span>  </td>" .
                "<td clas='hidden-phone'>" . $orgClientType . " <br> <span style='color: #0daed3;'> ( Fee: ".number_format($getComII['monthly_fee'],2)." | Commission: ".number_format($getComII['commission'],2)." ) </span> </td>" .
                "<td clas='hidden-phone'>" . $val_sp['cam_date'] . "</td>" .

                '
      <td>
      <div class="btn-group">
          <button class="btn btn-mini btn-info">Action</button>
          <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
          <ul class="dropdown-menu">';

            echo '<li><a href="merchantUser.php?CONCAMP=' . $sec->encode_it($val_sp['id']) . '"><i class="icon-user"></i> Create Account (' . $countAccount . ')</a></li>';

            echo
            '<li><a href="new_ma.php?CONCAMP=' . $sec->encode_it($val_sp['id']) . '"><i class="icon-edit"></i> Edit Client</a></li>
           <li><a href="newOffer.php?CONCAMP=' . $sec->encode_it($val_sp['id']) . '"><i class="icon-plus"></i> Create Offer</a></li>
           <li><a href="dailyReportDetailsAllSep.php?' . SENTID . "=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-eye-open"></i> Show Daily Report</a></li>
           <li><a href="weeklyReportDetails.php?' . SENTID . "=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-eye-open"></i> Show Weekly Report</a></li>
           <li><a href="monthlyReportDetails.php?' . SENTID . "=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-eye-open"></i> Show Monthly Report</a></li>
           <li><a href="affiliateAudit.php?' . SENTIDU . "=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-book"></i> Affiliate Audit</a></li>
           <li><a href="offerCalender.php?' . "CONST=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-calendar"></i> Offer Calender</a></li>
           <li><a href="#" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Change Status</a></li>
           <!-- <li><a href="#" data-toggle="modal" data-target="#Modaltask' . $val_sp['id'] . '"><i class="icon-edit"></i> Task</a></li> -->
           <li><a href="assign_task_list.php?' . SENTID . "=" . $sec->encode_it($val_sp['id']) . '"><i class="icon-eye-open"></i> View Task List</a></li>
           <li><a target="_blank" href="clientPromotions.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '"><i class="icon-gift"></i> Promotions</a></li>
           <li><a target="_blank" href="gapAnalysis.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '"><i class="icon-magic"></i> Gap Analysis</a></li>
           <li><a target="_blank" href="monthEndReport.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '"><i class="icon-calendar"></i> Month End Report</a></li>
          </ul>
      </div>
      </td>
      ' .
                "<td clas='hidden-phone'>" . $statusCaption . "</td>" .
                '</tr>';
        }
    }

    public function show_team_tags()
    {
        global $db;
        $sp_fetch_sql = "SELECT * FROM " . PREFIX . "speakers";
        $a_sp_feted = $db->fetch_all($sp_fetch_sql);

        foreach ($a_sp_feted as $key => $val_asp) {
            echo
            '<div class="speaker">
      <a href="#" data-toggle="modal" data-target="#s' . $val_asp['id'] . '">
        <img src="' . SITEURL . 'images/' . $val_asp['sep_img'] . '">
        <p>' . $val_asp['sep_nme'] . '</p>
        <span> ' . $val_asp['sep_tag'] . ' </span>
      </a>
      </div>';
        }
    }

    public function show_team_modal()
    {
        global $db;
        $sp_fetch_mod_sql = "SELECT * FROM " . PREFIX . "speakers";
        $a_sp_mod_feted = $db->fetch_all($sp_fetch_mod_sql);

        foreach ($a_sp_mod_feted as $key => $val_mod_sp) {
            echo
            '<div id="s' . $val_mod_sp['id'] . '" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

          <div class="modal-content">
            <div class="modal-header">
          <h4 class="modal-title">OUR SPEAKERS</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
        <img src="' . SITEURL . 'images/' . $val_mod_sp['sep_img'] . '">
              <p>' . $val_mod_sp['sep_nme'] . '</p>
              <span> ' . $val_mod_sp['sep_tag'] . ' </span>
            </div>
          </div>
        </div>
        </div>';
        }
    }

    public function show_mail_log()
    {

        global $db, $sec;
        $log_fetch_query = "SELECT * FROM " . PREFIX . "mail_log ORDER BY id desc";
        $log_feted = $db->fetch_all($log_fetch_query);
        $count = null;
        foreach ($log_feted as $key => $val_log) {

            $count++;
            echo
            "<tr>
     <td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_log['mail_subject'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_log['sent_to'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_log['sent_dte'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_log['mail_body'] . "</td>" .
                "</tr>";
        }
    }

    public function validate_eml($str)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
    }

    public function show_existing_sm()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "social_media";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['sm_nme'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }

    public function show_existing_niches()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "niche";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['niche'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }

    public function show_existing_networks()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "networks";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['network_nme'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }

    public function show_leadActions()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_status";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['stName'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }
    public function show_AbsenceTypeActions()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "absence_type";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['name'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }

    public function DashaccountTypes()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "leads_account_types";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['name'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['details'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }

    public function showUpReports()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            $clientNameSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $val_sp['clientId'];
            $clientName = $db->fetch_single_row($clientNameSql)['camp_name'];
            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $this->d_format($val_sp['dteTo'], 'd-m-Y') . "</td>" .
                "<td clas='hidden-phone'>" . $clientName . "</td>" .
                '<td class=" ">
          <button class="btn btn-warning" data-toggle="modal" data-target="#conf' . $val_sp['id'] . '"><i class="icon-bitbucket"></i> Delete Report </button>
      </td>
      </tr>';
        }
    }

    public function showUpReportsMonthly()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "monthly_report_data";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            $clientNameSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $val_sp['clientId'];
            $clientName = $db->fetch_single_row($clientNameSql)['camp_name'];
            $capMonthSql = "SELECT * FROM " . PREFIX . "months WHERE id = " . $val_sp['month'];
            $capMonth = $db->fetch_single_row($capMonthSql)['monthTitle'];
            $capYearSql = "SELECT * FROM " . PREFIX . "years WHERE id = " . $val_sp['year'];
            $capYear = $db->fetch_single_row($capYearSql)['yearTitle'];
            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $capMonth . " " . $capYear . "</td>" .
                "<td clas='hidden-phone'>" . $clientName . "</td>" .
                '<td class=" ">
          <button class="btn btn-warning" data-toggle="modal" data-target="#conf' . $val_sp['id'] . '"><i class="icon-bitbucket"></i> Delete Report </button>
      </td>
      </tr>';
        }
    }

    public function track_log($act)
    {
        global $user, $db;
        $dte = date("Y-m-d H:i:s");
        $ins_log_data = array(
            'cons_usr' => $user->get_current_user()['id'],
            'activity' => $act,
            'dte' => $dte,
        );

        $db->insert_values($ins_log_data, 'user_logs');
    }

    public function show_logs($q_get = null)
    {

        global $db, $sec;
        if (!empty($q_get)) {
            $q_get_c = " WHERE u_l.cons_usr = " . $sec->decode_it($_REQUEST[SENTID]);
        }
        // else{
        //   $q_get_c = null;
        // }
        $log_sql = "SELECT u_l.cons_usr, u_l.activity, u_l.dte, m_u.first_name, m_u.last_name  FROM " . PREFIX . "user_logs AS u_l
                    INNER JOIN " . PREFIX . "users AS m_u ON  u_l.cons_usr = m_u.id " . $q_get_c . " ORDER BY dte DESC LIMIT 1000
                   ";
        $log_fet = $db->fetch_all($log_sql);
        $count = null;

        foreach ($log_fet as $key => $val_log) {
            $count++;
            echo
            '
        <tr>
        <td>' . $count . '</td>
        <td>
        <div class="alert alert-success">
            <!--<button class="close" data-dismiss="alert">×</button>-->
            <strong>' . $val_log['dte'] . '&nbsp;' . $val_log['first_name'] . '&nbsp' . $val_log['last_name'] . '</strong> ' . $val_log['activity'] . '.
        </div>
        </td>
        </tr>
        ';
        }
    }

    public function show_front_fill()
    {
        global $db, $sec;
        $f_fetch_query = "SELECT * FROM " . PREFIX . "email_details WHERE c_status = 0 AND sep_email IS NOT NULL ";
        $f_feted = $db->fetch_all($f_fetch_query);
        $count = null;
        foreach ($f_feted as $key => $val_f) {

            $count++;
            echo
            "<tr>" .
                "<td clas='hidden-phone'>" . $val_f['sep_email'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['e_type'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['demographics_m'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['demographics_f'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['company'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['web_url'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['uni_vis'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['comp_country'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['comp_phone'] . "</td>" .
                "<td clas='hidden-phone'>
        " .
                '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
                  <li><a href="ch_front_status.php?' . SENTID . '=' . $val_f['id'] . '&REQ=c"><i class="icon-thumbs-up"></i> Confirm</a></li>
                  <li><a href="ch_front_status.php?' . SENTID . '=' . $val_f['id'] . '&REQ=d"><i class="icon-thumbs-down"></i> Decline</a></li>
				          <li><a href="front_request_detail.php?' . SENTID . '=' . $val_f['id'] . '&SEP_R=FED"><i class="icon-list"></i>View Detail</a></li>
              </ul>
          </div>'
                . "
        </td>" .
                "</tr>";
        }
    }

    public function conf_front_fill()
    {
        global $db, $sec;
        $f_fetch_query = "SELECT * FROM " . PREFIX . "email_details WHERE c_status = 1";
        $f_feted = $db->fetch_all($f_fetch_query);
        $count = null;
        foreach ($f_feted as $key => $val_f) {

            $count++;
            echo
            "<tr>" .
                "<td clas='hidden-phone'>" . $val_f['sep_email'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['company'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['web_url'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['comp_phone'] . "</td>" .
                "<td clas='hidden-phone'>
        " .
                '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
                <!-- <li><a href="front_request_detail.php?' . SENTID . '=' . $val_f['id'] . '&SEP_R=FED"><i class="icon-list"></i> View Detail</a></li> -->
                <li><a href="EditAffiliate.php?' . SENTIDU . '=' . $sec->encode_it($val_f['id']) . '"><i class="icon-edit"></i> Edit Detail</a></li>
                <li><a data-toggle="modal" data-target="#exampleModal' . $val_f['id'] . '"><i class="icon-trash"></i> Delete Details</a></li>

                </ul>
          </div>'
                . "
        </td>" .
                "</tr>";
        }
    }

    public function front_status($c_status, $case)
    {
        global $db, $custom_fun;
        if ($case == 'c') {
            echo
            $sep_sql = "UPDATE " . PREFIX . "email_details SET c_status = 1 WHERE id = " . $c_status;
        } else {
            echo
            $sep_sql = "DELETE " . PREFIX . "email_details.*, " . PREFIX . "sep_sm.* FROM " . PREFIX . "email_details
                      INNER JOIN  " . PREFIX . "sep_sm ON " . PREFIX . "sep_sm.cons_mail = " . PREFIX . "email_details.id
                      WHERE " . PREFIX . "email_details.id = " . $c_status . "
                     ";
        }
        if ($db->run_query($sep_sql)) {
            $custom_fun->redirect_page('index.php');
        }
    }

    public function front_ser_result($sep_q)
    {
        global $db, $sec;
        $f_fetch_query = "SELECT * FROM " . PREFIX . "front_email_details WHERE company LIKE '%" . $sep_q . "%' OR sep_email LIKE '%" . $sep_q . "%'  ";

        //  if($db->number_rows_hide($f_fetch_query) > 0){
        echo
        '<table class="table table-striped table-bordered" id="sample_1">
        <thead>
        <tr>
            <th class="hidden-phone">Email</th>
            <th class="hidden-phone">Type</th>
            <th class="hidden-phone">D Male</th>
            <th class="hidden-phone">D Female</th>
            <th class="hidden-phone">Company</th>
            <th class="hidden-phone">Website</th>
            <th class="hidden-phone">U Visitor</th>
            <th class="hidden-phone">Country</th>
            <th class="hidden-phone">Phone</th>
            <th class="hidden-phone">Action</th>
        </tr>
        </thead>
        <tbody>';

        $f_feted = $db->fetch_all($f_fetch_query);
        $count = null;
        foreach ($f_feted as $key => $val_f) {

            $count++;
            echo
            "<tr>" .
                "<td clas='hidden-phone'>" . $val_f['sep_email'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['e_type'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['demographics_m'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['demographics_f'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['company'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['web_url'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['uni_vis'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['comp_country'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_f['comp_phone'] . "</td>" .
                "<td clas='hidden-phone'>
         " .
                '<div class="btn-group">
               <button class="btn btn-mini btn-info">Action</button>
               <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
               <ul class="dropdown-menu">
                <li><a target="_blank" href="front_request_detail.php?' . SENTID . '=' . $val_f['id'] . '&RS=V&SEP_R=FED"><i class="icon-list"></i> View Detail</a></li>
                <!-- <li><a href="editMailDetails.php?' . SENTID . '=' . $val_f['id'] . '&SEP_R=FED"><i class="icon-edit"></i> Edit Detail</a></li> -->
               </ul>
           </div>'
                . "
         </td>" .
                "</tr>";
        }

        #Data form other table

        # Search By Company Name
        $compnay_sql = "SELECT eml_id FROM " . PREFIX . "email_details WHERE company LIKE '%" . $sep_q . "%' ";

        # Search By Email
        $fetch_eml_qry = "SELECT * FROM " . PREFIX . "emmails WHERE email_ad LIKE '%" . $sep_q . "%' OR id = (" . $compnay_sql . ")  ";
        $fetAll = $db->fetch_all($fetch_eml_qry);

        $countTow = null;
        $sepIdsList = null;
        foreach ($fetAll as $key => $valFet) {
            $sepIdsList .= $valFet['id'] . ',';
        }

        $preEmailSql = "SELECT * FROM " . PREFIX . "email_details WHERE eml_id IN (" . rtrim($sepIdsList, ",") . ") ";
        $allPreEmails = $db->fetch_all($preEmailSql);

        foreach ($allPreEmails as $key => $valPre) {
            $mailCapSql = "SELECT email_ad FROM " . PREFIX . "emmails WHERE id = " . $valPre['eml_id'];
            $fetMailCap = $db->fetch_single_row($mailCapSql);
            echo
            "<tr>" .
                "<td clas='hidden-phone'>" . $fetMailCap['email_ad'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['e_type'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['demographics_m'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['demographics_f'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['company'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['web_url'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['uni_vis'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['comp_country'] . "</td>" .
                "<td clas='hidden-phone'>" . $valPre['comp_phone'] . "</td>" .
                "<td clas='hidden-phone'>
          " .
                '<div class="btn-group">
                <button class="btn btn-mini btn-info">Action</button>
                <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a target="_blank" href="front_request_detail.php?' . SENTID . '=' . $valPre['id'] . '&RS=V&SEP_R=ED"><i class="icon-list"></i> View Detail</a></li>
                  <!-- <li><a href="editMailDetails.php?' . SENTID . '=' . $valPre['eml_id'] . '&SEP_R=ED"><i class="icon-edit"></i> Edit Detail</a></li> -->
                </ul>
            </div>'
                . "
          </td>" .
                "</tr>";
        }

        $emDetailSql = "SELECT eml_id FROM  " . PREFIX . "email_details";
        $allemDetails = $db->fetch_all($emDetailSql);
        $sepIdsListII = null;

        foreach ($allemDetails as $key => $valEdetails) {
            $sepIdsListII .= $valEdetails['eml_id'] . ",";
        }

        #Data from Emmails table
        $onlyEmailSql = "SELECT * FROM " . PREFIX . "emmails WHERE email_ad LIKE '%" . $sep_q . "%' AND id NOT IN (" . rtrim($sepIdsListII, ",") . ") ";
        $allOnlyEmails = $db->fetch_all($onlyEmailSql);

        foreach ($allOnlyEmails as $key => $valOnly) {
            echo
            "<tr>" .
                "<td clas='hidden-phone'>" . $valOnly['email_ad'] . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>" . '-' . "</td>" .
                "<td clas='hidden-phone'>
          " .
                '<div class="btn-group">
                <button class="btn btn-mini btn-info">Action</button>
                <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <li><a target="_blank" href="front_request_detail.php?' . SENTID . '=' . $valOnly['id'] . '&RS=V&SEP_R=OE"><i class="icon-list"></i> View Detail</a></li>
                  <!-- <li><a href="editMailDetails.php?' . SENTID . '=' . $valOnly['id'] . '&SEP_R=ED"><i class="icon-edit"></i> Edit Detail</a></li> -->
                </ul>
            </div>'
                . "
          </td>" .
                "</tr>";
        }

        echo
        '</tbody>
        </table>';

        // }

    }

    public function affiliateWeeklyReportDetails($sepClient)
    {
        global $db, $sec;
        $f_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report WHERE clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " ORDER BY id ASC";
        $f_feted = $db->fetch_all($f_fetch_query);

        $prevSale = null;
        $prevOrder = null;
        $prevComm = null;
        $prevClicks = null;

        foreach ($f_feted as $key => $val_f) {

            $sep_clientSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $val_f['clientId'];
            $fetSepClient = $db->fetch_single_row($sep_clientSql);

            $sep_NetworkSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id = " . $val_f['networkId'];
            $fetSepNetwork = $db->fetch_single_row($sep_NetworkSql);

            #Calculated Percentages
            if ($prevSale != null) {
                $salesPercentage = ($val_f['totalSales'] - $prevSale) / $val_f['totalSales'] * 100;
            } else {
                $salesPercentage = '-';
            }

            if ($prevOrder != null) {
                $orderPercentage = ($val_f['totalOrders'] - $prevOrder) / $val_f['totalOrders'] * 100;
            } else {
                $orderPercentage = '-';
            }

            if ($prevComm != null) {
                $commPercentage = ($val_f['totalAffiliateCommissions'] - $prevComm) / $val_f['totalAffiliateCommissions'] * 100;
            } else {
                $commPercentage = '-';
            }

            if ($prevClicks != null) {
                $clicksPercentage = ($val_f['totalClicks'] - $prevClicks) / $val_f['totalClicks'] * 100;
            } else {
                $clicksPercentage = '-';
            }

            #--------------------------------------------------------------------------------------------------------#
            $estNetRevenue = ($val_f['totalSales'] - $val_f['totalAffiliateCommissions'] - $val_f['totalNetworkFee']);
            $AOV = ($val_f['totalSales'] / $val_f['totalOrders']);
            $CPA = ($val_f['totalAffiliateCommissions'] / $val_f['totalOrders']);
            $EPC = ($val_f['totalSales'] / $val_f['totalClicks']);
            $CR = ($val_f['totalOrders'] / $val_f['totalClicks']);

            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='label label-success'>" . $this->d_format($val_f['dteTo'], 'd-m-Y') . "</span></td>" .
                "<td class='hidden-phone'>" . $val_f['totalSales'] . "</td>" .
                "<td class='hidden-phone'>" . number_format(($salesPercentage), 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format($estNetRevenue, 2) . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalOrders'] . "</td>" .
                "<td class='hidden-phone'>" . number_format(($orderPercentage), 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format($AOV, 2) . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalAffiliateCommissions'] . "</td>" .
                "<td class='hidden-phone'>" . number_format($CPA, 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format(($commPercentage), 2) . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalNetworkFee'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalImpressions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalClicks'] . "</td>" .
                "<td class='hidden-phone'>" . number_format(($clicksPercentage), 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format($EPC, 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format($CR, 2) . "</td>" .
                "</tr>";

            #Previous week Records
            $prevSale = $val_f['totalSales'];
            $prevOrder = $val_f['totalOrders'];
            $prevComm = $val_f['totalAffiliateCommissions'];
            $prevClicks = $val_f['totalClicks'];
        }
    }

    public function affiliateWeeklyReportDetailsMod($sepClient)
    {
        global $db, $sec, $user;
        $f_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report WHERE clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " ORDER BY id ASC";
        $f_feted = $db->fetch_all($f_fetch_query);

        foreach ($f_feted as $key => $val_f) {

            $sep_clientSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $val_f['clientId'];
            $fetSepClient = $db->fetch_single_row($sep_clientSql);

            $sep_NetworkSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id = " . $val_f['networkId'];
            $fetSepNetwork = $db->fetch_single_row($sep_NetworkSql);

            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='label label-success'>" . $this->d_format($val_f['dteTo'], 'd-m-Y') . "</span></td>" .
                "<td class='hidden-phone'><center><a href='affDetails.php?consRep=" . $sec->encode_it($val_f['id']) . "'><img src='https://searlco.xyz/email_filter/img/Search-icon.png' width='20px;' ></a></center></td>" .
                "<td class='hidden-phone'>" . $val_f['totalSales'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['sales_percent'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['est_net_revenue'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalOrders'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['orders_percent'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['aov'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalAffiliateCommissions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['cpa'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['comm_percent'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalNetworkFee'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalImpressions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['totalClicks'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['click_percent'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['epc'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['cr'] . "</td>" .
                "</tr>";

            $accSales += $val_f['totalSales'];
            $accNerRev += $val_f['est_net_revenue'];
            $accOrders += $val_f['totalOrders'];
            $accAov += $val_f['aov'];
            $accAfCo += $val_f['totalAffiliateCommissions'];
            $accComm += $val_f['comm_percent'];
            $accNetworkFee += $val_f['totalNetworkFee'];
            $accImpressions += $val_f['totalImpressions'];
            $accClicks += $val_f['totalClicks'];
            $accEpc += $val_f['epc'];
            $accCr += $val_f['cr'];
            $accCpa += $val_f['cpa'];
        }

        $AOV = number_format($accSales / $accOrders, 2);
        $CPA = number_format($accAfCo / $accOrders, 2);
        $EPC = number_format($accAfCo / $accClicks, 2);
        $CR = number_format($accOrders / $accClicks, 2);

        $totalsData = array(
            'bookSales' => $accSales,
            'estNetRevenue' => $accNerRev,
            'orders' => $accOrders,
            'aov' => $AOV,
            'affCommission' => $accAfCo,
            'cpa' => $CPA,
            'networkFee' => $accNetworkFee,
            'impressions' => $accImpressions,
            'clicks' => $accClicks,
            'epc' => $EPC,
            'cr' => $CR,
            'consClient' => $val_f['clientId'],
        );

        if ($db->find_duplicates('consClient', 'weekly_report_totals', "consClient = " . $val_f['clientId'])) {
            $db->update_values_wor($totalsData, 'weekly_report_totals', null, null, 'consClient');
        } else {
            $db->insert_values($totalsData, 'weekly_report_totals', 'hide');
        }
    }

    public function affiliateWeeklyReportDetailsByAff()
    {

        global $db, $sec;
        //  $f_fetch_query = "SELECT * FROM ".PREFIX."weekly_report_data WHERE client = ".$sec->decode_it($_REQUEST['consClient'])." AND affiliateName LIKE '".$sec->decode_it($_REQUEST['consAff'])."%'  ORDER BY id ASC";
        //$esNet = array();
        $f_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE client = " . $sec->decode_it($_REQUEST['consClient']) . " AND affiliate = " . $sec->decode_it($_REQUEST['consAff']) . " AND network = " . $sec->decode_it($_REQUEST['CONSNET']) . " ORDER BY id ASC";
        $f_feted = $db->fetch_all($f_fetch_query);

        $prevSale = null;
        $prevOrder = null;
        $prevComm = null;
        $prevClicks = null;

        foreach ($f_feted as $key => $val_f) {

            $sep_clientSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $val_f['client'];
            $fetSepClient = $db->fetch_single_row($sep_clientSql);

            // $sep_NetworkSql = "SELECT network_nme FROM ".PREFIX."networks WHERE id = ".$val_f['network'];
            // $fetSepNetwork  = $db->fetch_single_row($sep_NetworkSql);

            $sep_DateSql = "SELECT dteTo FROM " . PREFIX . "weekly_report WHERE id = " . $val_f['weeklyReport'];
            $fetSepDate = $db->fetch_single_row($sep_DateSql);

            #Calculated Percentages
            if ($prevSale != null and $prevSale != 0 and $val_f['salesValues']) {
                $salesPercentage = number_format(($val_f['salesValues'] - $prevSale) / $val_f['salesValues'] * 100, 2);
            } else {
                $salesPercentage = '-';
            }

            if ($prevOrder != null and $prevOrder != 0 and $val_f['salesNumber']) {
                $orderPercentage = number_format(($val_f['salesNumber'] - $prevOrder) / $val_f['salesNumber'] * 100, 2);
            } else {
                $orderPercentage = '-';
            }

            if ($prevComm != null and $prevComm != 0 and $val_f['affiliateCommission']) {
                $commPercentage = number_format(($val_f['affiliateCommission'] - $prevComm) / $val_f['affiliateCommission'] * 100, 2);
            } else {
                $commPercentage = '-';
            }

            if ($prevClicks != null and $prevClicks != 0 and $val_f['clicks'] != 0) {
                $clicksPercentage = number_format(($val_f['clicks'] - $prevClicks) / $val_f['clicks'] * 100, 2);
            } else {
                $clicksPercentage = '-';
            }

            #--------------------------------------------------------------------------------------------------------#
            // if($val_f['salesNumber'] != 0){
            //   $estNetRevenue    =  number_format(($val_f['salesValues']-$val_f['affiliateCommission']-$val_f['networkFee']),2);
            //   $estNetRevenueWN  =  ($val_f['salesValues']-$val_f['affiliateCommission']-$val_f['networkFee']);
            //   $estNetRevenueWN  =  ($val_f['salesValues']-$val_f['affiliateCommission'])-$val_f['networkFee'];
            // }
            // else{
            //   $estNetRevenue    =  0;
            // }

            #Estimated Net Revenue
            $estNetRevenue = number_format(($val_f['salesValues'] - $val_f['affiliateCommission'] - $val_f['networkFee']), 2);
            $incExpenses = $val_f['networkFee'] + $val_f['affiliateCommission'];
            $estNetRevenueWN = $val_f['salesValues'] - $incExpenses;

            //$esNet[]            = $estNetRevenueWN;

            if ($val_f['salesValues'] != 0 and $val_f['salesNumber'] != 0) {
                $AOV = number_format(($val_f['salesValues'] / $val_f['salesNumber']), 2);
            } else {
                $AOV = 0;
            }

            if ($val_f['affiliateCommission'] != 0 and $val_f['salesNumber'] != 0) {
                $CPA = number_format(($val_f['affiliateCommission'] / $val_f['salesNumber']), 2);
            } else {
                $CPA = 0;
            }

            if ($val_f['salesValues'] != 0 and $val_f['clicks'] != 0) {
                $EPC = number_format(($val_f['affiliateCommission'] / $val_f['clicks']), 2);
            } else {
                $EPC = 0;
            }

            if ($val_f['salesNumber'] != 0 and $val_f['clicks'] != 0) {
                $CR = number_format(($val_f['salesNumber'] / $val_f['clicks'] * 100), 2);
            } else {
                $CR = 0;
            }

            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='label label-success'>" . $this->d_format($fetSepDate['dteTo'], 'd-m-Y') . "</span></td>" .
                "<td class='hidden-phone'>" . $val_f['salesValues'] . "</td>" .
                "<td class='hidden-phone'>" . $salesPercentage . "</td>" .
                "<td class='hidden-phone'>" . $estNetRevenue . "</td>" .
                "<td class='hidden-phone'>" . $val_f['salesNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $orderPercentage . "</td>" .
                "<td class='hidden-phone'>" . $AOV . "</td>" .
                "<td class='hidden-phone'>" . $val_f['affiliateCommission'] . "</td>" .
                "<td class='hidden-phone'>" . $CPA . "</td>" .
                "<td class='hidden-phone'>" . $commPercentage . "</td>" .
                "<td class='hidden-phone'>" . $val_f['networkFee'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['impressions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_f['clicks'] . "</td>" .
                "<td class='hidden-phone'>" . $clicksPercentage . "</td>" .
                "<td class='hidden-phone'>" . $EPC . "</td>" .
                "<td class='hidden-phone'>" . $CR . "</td>" .
                "</tr>";

            $accSales += $val_f['salesValues'];
            $accNerRev += $estNetRevenueWN;
            $accOrders += $val_f['salesNumber'];
            $accAov += $AOV;
            $accAfCo += $val_f['affiliateCommission'];
            $accComm += $commPercentage;
            $accNetworkFee += $val_f['networkFee'];
            $accImpressions += $val_f['impressions'];
            $accClicks += $val_f['clicks'];
            $accEpc += $EPC;
            $accCr += $CR;
            $accCpa += $CPA;

            #Previous week Records
            $prevSale = $val_f['salesValues'];
            $prevOrder = $val_f['salesNumber'];
            $prevComm = $val_f['affiliateCommission'];
            $prevClicks = $val_f['clicks'];
        }

        $AOVTO = number_format($accSales / $accOrders, 2);
        $CPATO = number_format($accAfCo / $accOrders, 2);
        $EPCTO = number_format($accAfCo / $accClicks, 2);
        $CRTO = number_format($accOrders / $accClicks, 2);

        $totalsData = array(
            'bookSales' => $accSales,
            'estNetRevenue' => $accNerRev,
            'orders' => $accOrders,
            'aov' => $AOVTO,
            'affCommission' => $accAfCo,
            'cpa' => $CPATO,
            'networkFee' => $accNetworkFee,
            'impressions' => $accImpressions,
            'clicks' => $accClicks,
            'epc' => $EPCTO,
            'cr' => $CRTO,
            'consClient' => $val_f['client'],
            'consAffiliate' => $sec->decode_it($_REQUEST['consAff']),
            'sepNet' => $sec->decode_it($_REQUEST['CONSNET']),
        );

        #update totals according to new entries
        // $findExtSql = "SELECT id FROM ".PREFIX."weekly_report_aff_totals WHERE consClient = ".$sec->decode_it($_REQUEST['consClient'])." AND consAffiliate LIKE '".$sec->decode_it($_REQUEST['consAff'])."%'  ORDER BY id ASC";
        $findExtSql = "SELECT id FROM " . PREFIX . "weekly_report_aff_totals WHERE consClient = " . $sec->decode_it($_REQUEST['consClient']) . " AND consAffiliate = " . $sec->decode_it($_REQUEST['consAff']) . " AND sepNet = " . $sec->decode_it($_REQUEST['CONSNET']) . "   ORDER BY id ASC";
        $db->number_rows_hide($findExtSql);
        if ($db->number_rows_hide($findExtSql) > 0) {
            $refId = $db->fetch_single_row($findExtSql)['id'];
            $db->update_values_wor($totalsData, 'weekly_report_aff_totals', $refId);
        } else {
            $db->insert_values($totalsData, 'weekly_report_aff_totals', 'hide');
        }

        //$this->showPre($esNet);
        //echo "The sum is:".array_sum($esNet);
    }

    public function affiliateWeeklyReports()
    {
        global $db, $sec;
        $allClients = "SELECT * FROM " . PREFIX . "campaigns";
        $fetchedClients = $db->fetch_all($allClients);

        $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');
        foreach ($fetchedClients as $key => $fetchedClient) {
            $rand = rand(0, 4);
            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>SC-00-" . $fetchedClient['id'] . "</a></td>" .
                "<td class='hidden-phone'>" . $fetchedClient['camp_name'] . "</td>" .
                "<td class='hidden-phone'>
        " .
                '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="weeklyReportDetails.php?' . SENTID . '=' . $sec->encode_it($fetchedClient['id']) . '"><i class="icon-list"></i>View Report</a></li>
              </ul>
          </div>'
                . "
        </td>" .
                "</tr>";
        }
    }

    public function affiliateMonthlyReports()
    {
        global $db, $sec;
        $allClients = "SELECT * FROM " . PREFIX . "campaigns";
        $fetchedClients = $db->fetch_all($allClients);

        $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');
        foreach ($fetchedClients as $key => $fetchedClient) {
            $rand = rand(0, 4);
            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>SC-00-" . $fetchedClient['id'] . "</a></td>" .
                "<td class='hidden-phone'>" . $fetchedClient['camp_name'] . "</td>" .
                "<td class='hidden-phone'>
        " .
                '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="monthlyReportDetails.php?' . SENTID . '=' . $sec->encode_it($fetchedClient['id']) . '"><i class="icon-list"></i>View Report</a></li>
              </ul>
          </div>'
                . "
        </td>" .
                "</tr>";
        }
    }

    public function clientMonthlyReportDetailsNew()
    {
        global $db, $sec;
        #get current year 
        $currentYear    = date('Y');
        $currentYearCap = $db->baseSelect("years", "yearTitle =" . $currentYear);

        $allMonthlyData = "SELECT month, SUM(sales) AS totalSales, SUM(orders) AS totalOrders, SUM(affiliateCommission) AS totalAffCommission,
                              SUM(networkFee) AS totalNetworkFee, SUM(impressions) AS totalImpressions,
                              SUM(clicks) AS totalClicks
                              FROM " . PREFIX . "monthly_report_data WHERE clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " AND year = " . $currentYearCap['id'] . "   GROUP BY month " . " ORDER BY ID DESC";
        $fetchedMonthlyData = $db->fetch_all($allMonthlyData);

        $badgesClass = array('text-warning', 'text-error', 'text-info', 'text-info', 'text-success');
        // $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');

        ##Grand Totals
        $gTotalSales = null;
        $gTotalOrders = null;
        $gTotalAffCom = null;
        $gTotalNetFee = null;
        $gTotalImpressions = null;
        $gTotalClicks = null;
        $gTotalCosts = null;

        foreach ($fetchedMonthlyData as $key => $valMD) {
            $monthTitleSQL = "SELECT monthTitle FROM " . PREFIX . "months WHERE id = " . $valMD['month'];
            $monthTitle = $db->fetch_single_row($monthTitleSQL)['monthTitle'];
            $rand = rand(0, 4);

            $totalCosts = $valMD['totalAffCommission'] + $valMD['totalNetworkFee'];

            echo
            "<tr id='mtitle'>" .
                // "<td class='hidden-phone' colspan = '12'> <span class='  " . $badgesClass[$rand] . " '>" . $monthTitle . " </span></td>" .
                "<td class='hidden-phone' colspan = '1'><center> " . $monthTitle . "</center></td>" .
                // "<td class='hidden-phone' colspan = '12' ><center><span class='label label-info'>" . $monthTitle . "</span></center></td>" .
                "</tr>";

            echo
            "<tr id='tcontent'>" .
                "<td class='hidden-phone'>" . 'Total' . "</td>" .
                // "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>" . 'Total' . "</span></td>" .
                "<td class='hidden-phone'><center>" . number_format($valMD['totalSales'], 2) . "</center></td>" .
                "<td class='hidden-phone'><center>" . ($valMD['totalSales'] - $valMD['totalAffCommission'] - $valMD['totalNetworkFee']) . "</center></td>" .
                "<td class='hidden-phone'><center>" . $valMD['totalOrders'] . "</center></td>" .
                "<td class='hidden-phone'><center>" . number_format(($valMD['totalSales'] / $valMD['totalOrders']), 2) . "</center></td>" .
                "<td class='hidden-phone'><center>" . number_format($valMD['totalAffCommission'], 2) . "</center></td>" .
                "<td class='hidden-phone'><center>" . number_format($valMD['totalNetworkFee'], 2) . "</center></td>" .
                "<td class='hidden-phone'><center>" . $totalCosts . "</center></td>" .
                "<td class='hidden-phone'><center>" . number_format($valMD['totalSales'] / $totalCosts, 2) . "</center></td>" .
                "<td class='hidden-phone'><center>" . $valMD['totalImpressions'] . "</center></td>" .
                "<td class='hidden-phone'><center>" . $valMD['totalClicks'] . "</center></td>" .
                "<td class='hidden-phone'><center>" . number_format(($valMD['totalOrders'] / $valMD['totalClicks'] * 100), 2) . "</center></td>" .
                "</tr>";

            $gTotalSales += $valMD['totalSales'];
            $gTotalOrders += $valMD['totalOrders'];
            $gTotalAffCom += $valMD['totalAffCommission'];
            $gTotalNetFee += $valMD['totalNetworkFee'];
            $gTotalImpressions += $valMD['totalImpressions'];
            $gTotalClicks += $valMD['totalClicks'];
            $gTotalCosts += $totalCosts;

            $networkDataSql = "SELECT * FROM " . PREFIX . "monthly_report_data WHERE month = " . $valMD['month'] . " AND clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " AND year = " . $currentYearCap['id'] . "    GROUP BY networkId";
            $networkData = $db->fetch_all($networkDataSql);

            foreach ($networkData as $key => $valNetData) {

                $totalCostsNet = $valMD['totalAffCommission'] + $valMD['totalNetworkFee'];

                $networkCapSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id =  " . $valNetData['networkId'];
                $networkCap = $db->fetch_single_row($networkCapSql)['network_nme'];
                echo
                "<tr>" .
                    "<td class='hidden-phone'>" . $networkCap . "</a></td>" .
                    // "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>" . $networkCap . "</a></td>" .
                    "<td class='hidden-phone'><center>" . $valNetData['sales'] . "</center></td>" .
                    "<td class='hidden-phone'><center>" . ($valNetData['sales'] - $valNetData['affiliateCommission'] - $valNetData['networkFee']) . "</center></td>" .
                    "<td class='hidden-phone'><center>" . $valNetData['orders'] . "</center></td>" .
                    "<td class='hidden-phone'><center>" . number_format(($valNetData['sales'] / $valNetData['orders']), 2) . "</center></td>" .
                    "<td class='hidden-phone'><center>" . number_format($valNetData['affiliateCommission'], 2) . "</center></td>" .
                    "<td class='hidden-phone'><center>" . number_format($valNetData['networkFee'], 2) . "</center></td>" .
                    "<td class='hidden-phone'><center>" . $totalCostsNet . "</center></td>" .
                    "<td class='hidden-phone'><center>" . number_format($valNetData['sales'] / $totalCostsNet, 2) . "</center></td>" .
                    "<td class='hidden-phone'><center>" . $valNetData['impressions'] . "</center></td>" .
                    "<td class='hidden-phone'><center>" . $valNetData['clicks'] . "</center></td>" .
                    "<td class='hidden-phone'><center>" . number_format(($valNetData['orders'] / $valNetData['clicks'] * 100), 2) . "</center></td>" .
                    "</tr>";
            }
        }
        echo
        "<tr >" .
            "<td class='hidden-phone' colspan = '12' >&nbsp</td>" .
            "</tr>";

        echo
        "<tr>" .
            "<td class='hidden-phone'><b>Total</b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalSales . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . number_format($gTotalSales - $gTotalAffCom - $gTotalNetFee, 2) . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalOrders . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . number_format(($gTotalSales / $gTotalOrders), 2) . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalAffCom . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalNetFee . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalCosts . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . number_format($gTotalSales / $gTotalCosts, 2) . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalImpressions . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . $gTotalClicks . "</center></b></td>" .
            "<td class='hidden-phone'><b><center>" . number_format(($gTotalOrders / $gTotalClicks * 100), 2) . "</center></b></td>" .
            "</tr>";
    }

    public function clientMonthlyReportDetails()
    {
        global $db, $sec;
        #get current year 
        $currentYear    = date('Y');
        $currentYearCap = $db->baseSelect("years", "yearTitle =" . $currentYear);

        $allMonthlyData = "SELECT month, SUM(sales) AS totalSales, SUM(orders) AS totalOrders, SUM(affiliateCommission) AS totalAffCommission,
                              SUM(networkFee) AS totalNetworkFee, SUM(impressions) AS totalImpressions,
                              SUM(clicks) AS totalClicks
                              FROM " . PREFIX . "monthly_report_data WHERE clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " AND year = " . $currentYearCap['id'] . "   GROUP BY month ";
        $fetchedMonthlyData = $db->fetch_all($allMonthlyData);

        $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');

        ##Grand Totals
        $gTotalSales = null;
        $gTotalOrders = null;
        $gTotalAffCom = null;
        $gTotalNetFee = null;
        $gTotalImpressions = null;
        $gTotalClicks = null;
        $gTotalCosts = null;

        foreach ($fetchedMonthlyData as $key => $valMD) {
            $monthTitleSQL = "SELECT monthTitle FROM " . PREFIX . "months WHERE id = " . $valMD['month'];
            $monthTitle = $db->fetch_single_row($monthTitleSQL)['monthTitle'];
            $rand = rand(0, 4);

            $totalCosts = $valMD['totalAffCommission'] + $valMD['totalNetworkFee'];

            echo
            "<tr>" .
                "<td class='hidden-phone' colspan = '12' ><center><span class='label label-info'>" . $monthTitle . "</span></center></td>" .
                "</tr>";

            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>" . 'Total' . "</span></td>" .
                "<td class='hidden-phone'>" . number_format($valMD['totalSales'], 2) . "</td>" .
                "<td class='hidden-phone'><span class='badge' >" . ($valMD['totalSales'] - $valMD['totalAffCommission'] - $valMD['totalNetworkFee']) . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . $valMD['totalOrders'] . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . number_format(($valMD['totalSales'] / $valMD['totalOrders']), 2) . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . number_format($valMD['totalAffCommission'], 2) . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . number_format($valMD['totalNetworkFee'], 2) . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . $totalCosts . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . number_format($valMD['totalSales'] / $totalCosts, 2) . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . $valMD['totalImpressions'] . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . $valMD['totalClicks'] . "</span></td>" .
                "<td class='hidden-phone'><span class='badge' >" . number_format(($valMD['totalOrders'] / $valMD['totalClicks'] * 100), 2) . "</span></td>" .
                "</tr>";

            $gTotalSales += $valMD['totalSales'];
            $gTotalOrders += $valMD['totalOrders'];
            $gTotalAffCom += $valMD['totalAffCommission'];
            $gTotalNetFee += $valMD['totalNetworkFee'];
            $gTotalImpressions += $valMD['totalImpressions'];
            $gTotalClicks += $valMD['totalClicks'];
            $gTotalCosts += $totalCosts;

            $networkDataSql = "SELECT * FROM " . PREFIX . "monthly_report_data WHERE month = " . $valMD['month'] . " AND clientId = " . $sec->decode_it($_REQUEST[SENTID]) . " AND year = " . $currentYearCap['id'] . "    GROUP BY networkId";
            $networkData = $db->fetch_all($networkDataSql);

            foreach ($networkData as $key => $valNetData) {

                $totalCostsNet = $valMD['totalAffCommission'] + $valMD['totalNetworkFee'];

                $networkCapSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id =  " . $valNetData['networkId'];
                $networkCap = $db->fetch_single_row($networkCapSql)['network_nme'];
                echo
                "<tr>" .
                    "<td class='hidden-phone'><span class='badge  " . $badgesClass[$rand] . " '>" . $networkCap . "</a></td>" .
                    "<td class='hidden-phone'>" . $valNetData['sales'] . "</td>" .
                    "<td class='hidden-phone'>" . ($valNetData['sales'] - $valNetData['affiliateCommission'] - $valNetData['networkFee']) . "</td>" .
                    "<td class='hidden-phone'>" . $valNetData['orders'] . "</td>" .
                    "<td class='hidden-phone'>" . number_format(($valNetData['sales'] / $valNetData['orders']), 2) . "</td>" .
                    "<td class='hidden-phone'>" . number_format($valNetData['affiliateCommission'], 2) . "</td>" .
                    "<td class='hidden-phone'>" . number_format($valNetData['networkFee'], 2) . "</td>" .
                    "<td class='hidden-phone'>" . $totalCostsNet . "</td>" .
                    "<td class='hidden-phone'>" . number_format($valNetData['sales'] / $totalCostsNet, 2) . "</td>" .
                    "<td class='hidden-phone'>" . $valNetData['impressions'] . "</td>" .
                    "<td class='hidden-phone'>" . $valNetData['clicks'] . "</td>" .
                    "<td class='hidden-phone'>" . number_format(($valNetData['orders'] / $valNetData['clicks'] * 100), 2) . "</td>" .
                    "</tr>";
            }
        }

        echo
        "<tr>" .
            "<td class='hidden-phone'><b>Total</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalSales . "</b></td>" .
            "<td class='hidden-phone'><b>" . number_format($gTotalSales - $gTotalAffCom - $gTotalNetFee, 2) . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalOrders . "</b></td>" .
            "<td class='hidden-phone'><b>" . number_format(($gTotalSales / $gTotalOrders), 2) . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalAffCom . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalNetFee . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalCosts . "</b></td>" .
            "<td class='hidden-phone'><b>" . number_format($gTotalSales / $gTotalCosts, 2) . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalImpressions . "</b></td>" .
            "<td class='hidden-phone'><b>" . $gTotalClicks . "</b></td>" .
            "<td class='hidden-phone'><b>" . number_format(($gTotalOrders / $gTotalClicks * 100), 2) . "</b></td>" .
            "</tr>";
    }

    public function showClientAffMer()
    {

        global $db, $sec, $user;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport =" . $sec->decode_it($_REQUEST['consRep']);
        $sp_feted = $db->fetch_all($sp_fetch_query);

        #Previous Report Calculation
        $getReportDateSql = "SELECT dteTo, clientId FROM  " . PREFIX . "weekly_report WHERE id = " . $sec->decode_it($_REQUEST['consRep']);
        $getReportDate = $db->fetch_single_row($getReportDateSql);
        $prevReportDate = date('Y-m-d', strtotime($getReportDate['dteTo'] . ' - 7 days'));

        #Get Report Client
        $clientSql = "SELECT id FROM " . PREFIX . "weekly_report WHERE dteTo = '" . $prevReportDate . "' AND clientId = " . $getReportDate['clientId'];
        if ($db->number_rows_hide($clientSql)) {
            #prevReportId
            $preReportId = $db->fetch_single_row($clientSql)['id'];
        }

        #Check user login
        if ($user->is_login_admin()) {
            $imgPath = "";
        } else {
            $imgPath = "../";
        }

        foreach ($sp_feted as $key => $val_sp) {

            if ($db->number_rows_hide($clientSql)) {
                #doing comparison with previous report.
                $prevWeekSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport = " . $preReportId . " AND client = " . $getReportDate['clientId'] . " AND network = " . $val_sp['network'] . " AND affiliate =  " . $val_sp['affiliate'];
                if ($db->number_rows_hide($prevWeekSql)) {
                    $compareData = $db->fetch_single_row($prevWeekSql);
                    $prevClicks = $compareData['clicks'];
                    $prevSalesValues = $compareData['salesValues'];
                    // $calculatedSalesValues =
                } else {
                    $prevClicks = 0;
                    $prevSalesValues = 0;
                }
                if ($prevClicks > 0) {
                    if ($val_sp['clicks'] < $prevClicks) {
                        $aggPercentDec = ($val_sp['clicks'] - $prevClicks) / $prevClicks * 100;
                        $calculatedClicks = " <i style='color: red;' class='icon-long-arrow-down'></i> " . number_format($aggPercentDec, 2) . "% ($prevClicks)";
                    } elseif ($val_sp['clicks'] > $prevClicks) {
                        $aggPercentInc = ($val_sp['clicks'] - $prevClicks) / $prevClicks * 100;
                        $calculatedClicks = " <i style='color: green;' class='icon-long-arrow-up'></i> " . number_format($aggPercentInc, 2) . "% ($prevClicks)";
                    } else {
                        $aggPercentInc = 0;
                        $calculatedClicks = null;
                    }
                } else {
                    $aggPercentInc = 0;
                    $calculatedClicks = null;
                }

                if ($prevSalesValues > 0) {
                    if ($val_sp['salesValues'] < $prevSalesValues) {
                        $aggSalesDec = ($val_sp['salesValues'] - $prevSalesValues) / $prevSalesValues * 100;
                        $calculatedSales = " <i style='color: red;' class='icon-long-arrow-down'></i> " . number_format($aggSalesDec, 2) . "% ($prevSalesValues)";
                    }
                    if ($val_sp['salesValues'] > $prevSalesValues) {
                        $aggSalesInc = ($val_sp['salesValues'] - $prevSalesValues) / $prevSalesValues * 100;
                        $calculatedSales = " <i style='color: green;' class='icon-long-arrow-up'></i> " . number_format($aggSalesInc, 2) . "% ($prevSalesValues)";
                    }
                } else {
                    $calculatedSales = null;
                    $aggSalesInc = 0;
                }
            } else {
                $calculatedSales = 0;
                $aggSalesInc = 0;
            }
            $mapIt = null;
            $sepNetworkSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id =" . $val_sp['network'];
            $sepNetwork = $db->fetch_single_row($sepNetworkSql)['network_nme'];
            echo
            "<tr><td clas='hidden-phone'>" . $val_sp['affiliateName'] . " &nbsp; &nbsp;" . $mapIt . "</td>" .
                //"<td clas='hidden-phone'><a href='weeklyReportByNetwork.php?consRep=".$_REQUEST['consRep']."'>".$sepNetwork."</a></td>".
                "<td clas='hidden-phone'>" . $sepNetwork . "</td>" .
                // "<td clas='hidden-phone'>".'<center><a href="weeklyReportDetailsByAff.php?consClient='.$sec->encode_it($val_sp['client']).'&consAff='.$sec->encode_it($val_sp['affiliateName']).'"><img src="https://searlco.xyz/email_filter/img/Search-icon.png" width="20px;"></a></center>'."</td>".
                "<td clas='hidden-phone'>" . '<center><a href="weeklyReportDetailsByAffOld.php?consClient=' . $sec->encode_it($val_sp['client']) . '&consAff=' . $sec->encode_it($val_sp['affiliate']) . '&CONSNET=' . $sec->encode_it($val_sp['network']) . '"><img src="https://searlco.xyz/email_filter/img/Search-icon.png" width="20px;"></a></center>' . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['clicks'] . "</td>" .
                "<td clas='hidden-phone'>" . $calculatedClicks . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['impressions'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['salesNumber'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['salesValues'] . "</td>" .
                "<td clas='hidden-phone'>" . $calculatedSales . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['affiliateCommission'] . "</td>" .
                '</tr>';
        }
    }

    public function showClientAff()
    {

        global $db, $sec, $user;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport =" . $sec->decode_it($_REQUEST['consRep']);
        $sp_feted = $db->fetch_all($sp_fetch_query);

        #Previous Report Calculation
        $getReportDateSql = "SELECT dteTo, clientId FROM  " . PREFIX . "weekly_report WHERE id = " . $sec->decode_it($_REQUEST['consRep']);
        $getReportDate = $db->fetch_single_row($getReportDateSql);
        $prevReportDate = date('Y-m-d', strtotime($getReportDate['dteTo'] . ' - 7 days'));

        #Get Report Client
        $clientSql = "SELECT id FROM " . PREFIX . "weekly_report WHERE dteTo = '" . $prevReportDate . "' AND clientId = " . $getReportDate['clientId'];
        if ($db->number_rows_hide($clientSql)) {
            #prevReportId
            $preReportId = $db->fetch_single_row($clientSql)['id'];
        }

        #Check user login
        if ($user->is_login_admin()) {
            $imgPath = "";
        } else {
            $imgPath = "../";
        }

        foreach ($sp_feted as $key => $val_sp) {

            if ($db->number_rows_hide($clientSql)) {
                #doing comparison with previous report.
                $prevWeekSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport = " . $preReportId . " AND client = " . $getReportDate['clientId'] . " AND network = " . $val_sp['network'] . " AND affiliate =  " . $val_sp['affiliate'];
                if ($db->number_rows_hide($prevWeekSql)) {
                    $compareData = $db->fetch_single_row($prevWeekSql);
                    $prevClicks = $compareData['clicks'];
                    $prevSalesValues = $compareData['salesValues'];
                    // $calculatedSalesValues =
                } else {
                    $prevClicks = 0;
                    $prevSalesValues = 0;
                }
                if ($prevClicks > 0) {
                    if ($val_sp['clicks'] < $prevClicks) {
                        $aggPercentDec = ($val_sp['clicks'] - $prevClicks) / $prevClicks * 100;
                        $calculatedClicks = " <i style='color: red;' class='icon-long-arrow-down'></i> " . number_format($aggPercentDec, 2) . "% ($prevClicks)";
                    } elseif ($val_sp['clicks'] > $prevClicks) {
                        $aggPercentInc = ($val_sp['clicks'] - $prevClicks) / $prevClicks * 100;
                        $calculatedClicks = " <i style='color: green;' class='icon-long-arrow-up'></i> " . number_format($aggPercentInc, 2) . "% ($prevClicks)";
                    } else {
                        $aggPercentInc = 0;
                        $calculatedClicks = null;
                    }
                } else {
                    $aggPercentInc = 0;
                    $calculatedClicks = null;
                }

                if ($prevSalesValues > 0) {
                    if ($val_sp['salesValues'] < $prevSalesValues) {
                        $aggSalesDec = ($val_sp['salesValues'] - $prevSalesValues) / $prevSalesValues * 100;
                        $calculatedSales = " <i style='color: red;' class='icon-long-arrow-down'></i> " . number_format($aggSalesDec, 2) . "% ($prevSalesValues)";
                    }
                    if ($val_sp['salesValues'] > $prevSalesValues) {
                        $aggSalesInc = ($val_sp['salesValues'] - $prevSalesValues) / $prevSalesValues * 100;
                        $calculatedSales = " <i style='color: green;' class='icon-long-arrow-up'></i> " . number_format($aggSalesInc, 2) . "% ($prevSalesValues)";
                    }
                } else {
                    $calculatedSales = null;
                    $aggSalesInc = 0;
                }
            } else {
                $calculatedSales = 0;
                $aggSalesInc = 0;
            }

            #check is it existing link affiliates
            $findAffiliateSql = "SELECT * FROM " . PREFIX . "link_affiliates WHERE network_affiliate_id = " . $val_sp['affiliate'] . " AND network_id = " . $val_sp['network'] . "   ";
            //echo "-". $val_sp['affiliate']."-";

            $findAffiliate = $db->fetch_single_row($findAffiliateSql);

            if ($findAffiliate['affiliate_id'] != '0') {
                $foundId = $findAffiliate['affiliate_id'];
            } else {
                $foundId = 'N/A2';
            }


            if ($val_sp['affiliate'] == '0') {
                $mapIt = '<button class="btn btn-mini btn-warning"> Cant Map </button>';
            } else {

                if ($db->number_rows_hide($findAffiliateSql) < 1) {
                    $mapIt = '<button class="btn btn-mini btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"> Map it </button>';
                    $unmapBtn = NULL; 
                } else {
                    $unmapBtn = "<button onclick='javascript:unmapIt(".$foundId.");'  class ='btn btn-mini btn btn-danger'> Unmap it </button>"; 
                    $mapIt = "<img src='https://searlco.xyz/email_filter/img/check-icon.png'>" . " [" . $foundId . "] ";
                }
            }

            if(!empty($foundId)){
                $refLink = "EditAffiliate.php?" . SENTIDU . "=" . M_EI($foundId); 
            }
            else{
                $refLink = "#";
            }


            $sepNetworkSql = "SELECT network_nme FROM " . PREFIX . "networks WHERE id =" . $val_sp['network'];
            $sepNetwork = $db->fetch_single_row($sepNetworkSql)['network_nme'];
            echo
            "<tr><td clas='hidden-phone'><a href='".$refLink."' target='_blank'>" . $val_sp['affiliateName'] . "</a> &nbsp; &nbsp;" . $mapIt . $unmapBtn. "</td>" .
                "<td clas='hidden-phone'><a href='weeklyReportByNetwork.php?consRep=" . $_REQUEST['consRep'] . "'>" . $sepNetwork . "</a></td>" .
                // "<td clas='hidden-phone'>".'<center><a href="weeklyReportDetailsByAff.php?consClient='.$sec->encode_it($val_sp['client']).'&consAff='.$sec->encode_it($val_sp['affiliateName']).'"><img src="https://searlco.xyz/email_filter/img/Search-icon.png" width="20px;"></a></center>'."</td>".
                "<td clas='hidden-phone'>" . '<center><a href="weeklyReportDetailsByAff.php?consClient=' . $sec->encode_it($val_sp['client']) . '&consAff=' . $sec->encode_it($val_sp['affiliate']) . '&CONSNET=' . $sec->encode_it($val_sp['network']) . '"><img src="https://searlco.xyz/email_filter/img/Search-icon.png" width="20px;"></a></center>' . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['clicks'] . "</td>" .
                "<td clas='hidden-phone'>" . $calculatedClicks . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['impressions'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['salesNumber'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['salesValues'] . "</td>" .
                "<td clas='hidden-phone'>" . $calculatedSales . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['affiliateCommission'] . "</td>" .
                '</tr>';
        }
    }


    public function getMoverShaker()
    {

        global $db, $sec;
        $clickMovers  = NULL;
        $clickShakers = NULL;
        $salesMovers  = NULL;
        $salesShakers = NULL;

        $currentDate = date('Y-m-d');
        $monthBack   = date('Y-m-d', strtotime($currentDate . ' - 30 days'));

        $getWeeklyReportDataSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport =" . $sec->decode_it($_REQUEST['consRep']);
        $getWeeklyReportData    = $db->fetch_all($getWeeklyReportDataSql);

        foreach ($getWeeklyReportData as $key => $valWRD) {
            $previousReportDate     = date('Y-m-d', strtotime($valWRD['sep_date'] . ' - 7 days'));
            #compare with previous performance

            $getSameAffiliatePWDSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE affiliate = '" . $valWRD['affiliate'] . "'  AND client = '" . $valWRD['client'] . "' AND network = '" . $valWRD['network'] . "' AND date(sep_date) = '" . $previousReportDate . "' ";

            #check if this affiliate existing in previous weekly report
            if ($db->number_rows_hide($getSameAffiliatePWDSql) > 0) {
                $getSameAffiliatePWD    =  $db->fetch_single_row($getSameAffiliatePWDSql);

                #get mover and shakers of sales 
                if ($getSameAffiliatePWD['salesValues'] > 0) {
                    $compareResultSales = ($valWRD['salesValues'] - $getSameAffiliatePWD['salesValues']) / $getSameAffiliatePWD['salesValues'] * 100;
                    if ($compareResultSales > 0) {

                        #If movers
                        if ($compareResultSales > 20) {

                            if ($valWRD['affiliate'] != 0) {

                                #Get movers IDs
                                $salesMoverIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = '" . $valWRD['network'] . "' AND network_affiliate_id = '" . $valWRD['affiliate'] . "'   ";
                                $salesMoverId    = $db->fetch_single_row($salesMoverIdSql)['affiliate_id'];
                                #Get movers emails
                                if (!empty($salesMoverId)) {
                                    #check if note not added withing a month
                                    $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = '" . $salesMoverId . "'";
                                    if ($db->number_rows_hide($checkNoteSql) < 1) {
                                        $salesMoverEmailSql = "SELECT sep_email FROM " . PREFIX . "email_details WHERE id = '" . $salesMoverId . "'";
                                        $salesMoverEmail    = $db->fetch_single_row($salesMoverEmailSql)['sep_email'];
                                        if (!empty($salesMoverEmail)) {
                                            $salesMovers .= $salesMoverEmail . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($compareResultSales < 0) {

                    #If shakers   
                    if ($compareResultSales < -20) {
                        if ($valWRD['affiliate'] != 0) {
                            #Get shakers IDs
                            $salesShakerIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = '" . $valWRD['network'] . "' AND network_affiliate_id = '" . $valWRD['affiliate'] . "'   ";
                            $salesShakerId    = $db->fetch_single_row($salesShakerIdSql)['affiliate_id'];
                            #Get shakers emails
                            if (!empty($salesShakerId)) {
                                #check if note not added withing a month
                                $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = '" . $salesMoverId . "'";
                                if ($db->number_rows_hide($checkNoteSql) < 1) {
                                    #check if note not added withing a month
                                    $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = '" . $salesShakerId . "'";
                                    if ($db->number_rows_hide($checkNoteSql) < 1) {
                                        $salesShakerEmailSql = "SELECT sep_email FROM " . PREFIX . "email_details WHERE id = '" . $salesShakerId . "'";
                                        $salesShakerEmail    = $db->fetch_single_row($salesShakerEmailSql)['sep_email'];
                                        if (!empty($salesShakerEmail)) {
                                            $salesShakers .= $salesShakerEmail . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                #check is previous clicks greater than 0. For right calculation
                if ($getSameAffiliatePWD['clicks'] > 0) {
                    $compareResult =  ($valWRD['clicks'] - $getSameAffiliatePWD['clicks']) / $getSameAffiliatePWD['clicks'] * 100;

                    if ($compareResult > 0) {
                        #If movers
                        if ($compareResult > 20) {

                            if ($valWRD['affiliate'] != 0) {
                                #Get movers IDs
                                $moverIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                                $moverId    = $db->fetch_single_row($moverIdSql)['affiliate_id'];
                                #Get movers emails
                                if (!empty($moverId)) {
                                    #check if note not added withing a month
                                    $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $moverId;
                                    if ($db->number_rows_hide($checkNoteSql) < 1) {
                                        $moverEmailSql = "SELECT sep_email FROM " . PREFIX . "email_details WHERE id = " . $moverId;
                                        $moverEmail    = $db->fetch_single_row($moverEmailSql)['sep_email'];
                                        if (!empty($moverEmail)) {
                                            $clickMovers .= $moverEmail . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    #If shakers
                    if ($compareResult < 0) {

                        #If Shakers
                        if ($compareResult > -20) {

                            if ($valWRD['affiliate'] != 0) {
                                #Get movers IDs
                                $shakerIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                                $shakerId    = $db->fetch_single_row($shakerIdSql)['affiliate_id'];
                                #Get movers emails
                                if (!empty($shakerId)) {
                                    #check if note not added withing a month
                                    $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $shakerId;
                                    if ($db->number_rows_hide($checkNoteSql) < 1) {

                                        $shakerEmailSql = "SELECT sep_email FROM " . PREFIX . "email_details WHERE id = " . $shakerId;
                                        $shakerEmail    = $db->fetch_single_row($shakerEmailSql)['sep_email'];
                                        if (!empty($shakerEmail)) {
                                            $clickShakers .= $shakerEmail . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $MSData = array(
            'clickMovers'  => $clickMovers,
            'clickShakers' => $clickShakers,
            'salesMovers'  => $salesMovers,
            'salesShakers' => $salesShakers
        );

        return $MSData;
    }


    public function autoNotesMS()
    {

        global $db, $sec, $user;
        $clickMovers  = NULL;
        $clickShakers = NULL;
        $salesMovers  = NULL;
        $salesShakers = NULL;
        $consClient   = NULL;
        $consClientId = NULL;

        $currentDate = date('Y-m-d');
        $monthBack   = date('Y-m-d', strtotime($currentDate . ' - 30 days'));

        $getWeeklyReportDataSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE weeklyReport =" . $sec->decode_it($_REQUEST['consRep']);
        $getWeeklyReportData    = $db->fetch_all($getWeeklyReportDataSql);

        foreach ($getWeeklyReportData as $key => $valWRD) {
            $previousReportDate     = date('Y-m-d', strtotime($valWRD['sep_date'] . ' - 7 days'));
            $consClientId = $valWRD['client'];
            #compare with previous performance    
            $getSameAffiliatePWDSql = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE affiliate = " . $valWRD['affiliate'] . "  AND client = " . $valWRD['client'] . " AND network = " . $valWRD['network'] . " AND date(sep_date) = '" . $previousReportDate . "' ";
            $consClient = $db->baseSelect("campaigns", "id = " . $valWRD['client'] . " ")['camp_name'];

            #check if this affiliate existing in previous weekly report
            if ($db->number_rows_hide($getSameAffiliatePWDSql) > 0) {
                $getSameAffiliatePWD    =  $db->fetch_single_row($getSameAffiliatePWDSql);

                #get mover and shakers of sales 
                if ($getSameAffiliatePWD['salesValues'] > 0) {
                    $compareResultSales = ($valWRD['salesValues'] - $getSameAffiliatePWD['salesValues']) / $getSameAffiliatePWD['salesValues'] * 100;
                    if ($compareResultSales > 0) {

                        #If movers
                        if ($compareResultSales > 20) {
                            #Get movers IDs
                            $salesMoverIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                            $salesMoverId    = $db->fetch_single_row($salesMoverIdSql)['affiliate_id'];
                            #Get movers emails
                            if (!empty($salesMoverId)) {
                                #check if note not added withing a month
                                $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $salesMoverId;
                                if ($db->number_rows_hide($checkNoteSql) < 1) {
                                    $salesMoverEmailSql = "SELECT id, sep_email FROM " . PREFIX . "email_details WHERE id = " . $salesMoverId;
                                    $salesMoverEmail    = $db->fetch_single_row($salesMoverEmailSql)['id'];
                                    if (!empty($salesMoverEmail)) {
                                        $salesMovers .= $salesMoverEmail . ",";
                                    }
                                }
                            }
                        }
                    }
                }

                if ($compareResultSales < 0) {

                    #If shakers   
                    if ($compareResultSales < -20) {
                        #Get shakers IDs
                        $salesShakerIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                        $salesShakerId    = $db->fetch_single_row($salesShakerIdSql)['affiliate_id'];
                        #Get shakers emails
                        if (!empty($salesShakerId)) {
                            #check if note not added withing a month
                            $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $salesMoverId;
                            if ($db->number_rows_hide($checkNoteSql) < 1) {
                                #check if note not added withing a month
                                $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $salesShakerId;
                                if ($db->number_rows_hide($checkNoteSql) < 1) {
                                    $salesShakerEmailSql = "SELECT id, sep_email FROM " . PREFIX . "email_details WHERE id = " . $salesShakerId;
                                    $salesShakerEmail    = $db->fetch_single_row($salesShakerEmailSql)['id'];
                                    if (!empty($salesShakerEmail)) {
                                        $salesShakers .= $salesShakerEmail . ",";
                                    }
                                }
                            }
                        }
                    }
                }

                #check is previous clicks greater than 0. For right calculation
                if ($getSameAffiliatePWD['clicks'] > 0) {
                    $compareResult =  ($valWRD['clicks'] - $getSameAffiliatePWD['clicks']) / $getSameAffiliatePWD['clicks'] * 100;

                    if ($compareResult > 0) {
                        #If movers
                        if ($compareResult > 20) {
                            #Get movers IDs
                            $moverIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                            $moverId    = $db->fetch_single_row($moverIdSql)['affiliate_id'];
                            #Get movers emails
                            if (!empty($moverId)) {
                                #check if note not added withing a month
                                $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $moverId;
                                if ($db->number_rows_hide($checkNoteSql) < 1) {
                                    $moverEmailSql = "SELECT id, sep_email FROM " . PREFIX . "email_details WHERE id = " . $moverId;
                                    $moverEmail    = $db->fetch_single_row($moverEmailSql)['id'];
                                    if (!empty($moverEmail)) {
                                        $clickMovers .= $moverEmail . ",";
                                    }
                                }
                            }
                        }
                    }

                    #If shakers
                    if ($compareResult < 0) {

                        #If Shakers
                        if ($compareResult > -20) {
                            #Get movers IDs
                            $shakerIdSql = "SELECT affiliate_id FROM " . PREFIX . "link_affiliates WHERE network_id = " . $valWRD['network'] . " AND network_affiliate_id = " . $valWRD['affiliate'] . "   ";
                            $shakerId    = $db->fetch_single_row($shakerIdSql)['affiliate_id'];
                            #Get movers emails
                            if (!empty($shakerId)) {
                                #check if note not added withing a month
                                $checkNoteSql = "SELECT id FROM " . PREFIX . "affiliates_notes WHERE DATE(dte) < '" . $monthBack . "' AND cons_aff = " . $shakerId;
                                if ($db->number_rows_hide($checkNoteSql) < 1) {

                                    $shakerEmailSql = "SELECT id,sep_email FROM " . PREFIX . "email_details WHERE id = " . $shakerId;
                                    $shakerEmail    = $db->fetch_single_row($shakerEmailSql)['id'];
                                    if (!empty($shakerEmail)) {
                                        $clickShakers .= $shakerEmail . ",";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $MSData = array(
            'clickMovers'  => $clickMovers,
            'clickShakers' => $clickShakers,
            'salesMovers'  => $salesMovers,
            'salesShakers' => $salesShakers
        );

        $allAffs = NULL;
        foreach ($MSData as $key => $msVal) {
            $allAffs .= $msVal;
        }
        $allAffsII = rtrim($allAffs, ",");
        $allAffsIds = explode(",", $allAffsII);

        $noteDes = "Contacted for movers and shakers for " . $consClient . " ";
        $length = count($allAffsIds);
        $merchantNote =  'Movers and shakers complete for ' . date('Y-m-d') . ' ';

        if (count($length) > 0) {

            for ($i = 0; $i < $length; $i++) {

                $affNoteData = array(
                    'cons_aff' => $allAffsIds[$i],
                    'note'     => $noteDes,
                    'dte'      => date("Y-m-d H:i:s"),
                    'admin_id' => $user->get_current_user()['id']
                );
                $db->insert_values($affNoteData, "affiliates_notes");
            }

            $MerNoteData = array(
                'cons_camp' => $consClientId,
                'note'      => $merchantNote,
                'dte'       => date("Y-m-d H:i:s"),
                'admin_id'  => $user->get_current_user()['id']
            );
            $db->insert_values($MerNoteData, "marchent_notes");
        }

        $this->redirect_page('affDetails.php?consRep=' . $_REQUEST['consRep'] . '');
    }




    public function showClientsTotals()
    {
        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_totals WHERE consClient =" . $sec->decode_it($_REQUEST[SENTID]);
        $tolVal = $db->fetch_single_row($sp_fetch_query);
        echo
        "<tr>" .
            "<td class='hidden-phone'>" . $tolVal['bookSales'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['estNetRevenue'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['orders'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['aov'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['affCommission'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['cpa'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['networkFee'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['impressions'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['clicks'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['epc'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['cr'] . "</td>" .
            "</tr>";
    }

    public function showClientsTotalsAff()
    {
        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_aff_totals WHERE consClient = " . $sec->decode_it($_REQUEST['consClient']) . " AND consAffiliate LIKE '" . $sec->decode_it($_REQUEST['consAff']) . "%'  ";
        $tolVal = $db->fetch_single_row($sp_fetch_query);
        echo
        "<tr>" .
            "<td class='hidden-phone'>" . $tolVal['bookSales'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['estNetRevenue'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['orders'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['aov'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['affCommission'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['cpa'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['networkFee'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['impressions'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['clicks'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['epc'] . "</td>" .
            "<td class='hidden-phone'>" . $tolVal['cr'] . "</td>" .
            "</tr>";
    }

    public function dailyReportData()
    {
        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data WHERE consClient = " . $sec->decode_it($_REQUEST[SENTID]);
        $allRepData = $db->fetch_all($sp_fetch_query);
        foreach ($allRepData as $key => $repData) {

            $clientCapSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $repData['consClient'];
            $clientCap = $db->fetch_single_row($clientCapSql)['camp_name'];
            //$this->d_format($val_f['dteTo'], 'd-m-Y')

            // $days = cal_days_in_month(CAL_GREGORIAN,$this->d_format($repData['reportDate'],'m'),$this->d_format($repData['reportDate'],'Y') );
            // $runRateI  = number_format($repData['salesValue'],2) / $this->d_format($repData['reportDate'], 'd');
            // $runRateII = $runRateI * $days;

            $days_of_current_month = date("t");
            $current_date = date("j");
            $totalSales = $repData['salesValue'];
            $runRate = ($totalSales / $current_date) * $days_of_current_month;
            echo
            "<tr>" .
                "<td class='hidden-phone'><span class='label label-success'>" . $this->d_format($repData['reportDate'], 'd-m-Y') . "</span></td>" .
                "<td class='hidden-phone'>" . $clientCap . "</td>" .
                "<td class='hidden-phone'>" . $repData['saleNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['leadNumber'] . "</td>" .
                "<td class='hidden-phone'>" . number_format($repData['salesValue'], 2) . "</td>" .
                "<td class='hidden-phone'><span class='label'>" . number_format($runRate, 2) . "</span></td>" .
                "</tr>";
        }
    }

    public function dailyReportDataAll()
    {
        global $db, $sec;
        $currentDate = date('Y-m-d');
        $reportDate = date('Y-m-d', strtotime($currentDate . ' - 1 days'));

        if (isset($_REQUEST['SEPDTE']) and !empty($_REQUEST['SEPDTE'])) {

            $oneDayBack = date('Y-m-d', strtotime($_REQUEST['SEPDTE'] . ' - 1 days'));
            $sp_fetch_query = "SELECT *, " . PREFIX . "daily_report_data.id AS mainId FROM " . PREFIX . "daily_report_data INNER JOIN aa_campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.reportDate = '" . $oneDayBack . "'  ORDER BY " . PREFIX . "campaigns.camp_name ";
            $dateCap = $this->d_format($_REQUEST['SEPDTE'], 'd-m-Y');
        } else {
            $sp_fetch_query = "SELECT *, " . PREFIX . "daily_report_data.id AS mainId  FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE reportDate = '" . $reportDate . "'  ORDER BY " . PREFIX . "campaigns.camp_name ";
            $dateCap = date('d-m-Y');
        }

        $allRepData = $db->fetch_all($sp_fetch_query);
        echo "<td class='hidden-phone' colspan='11' ><center><span class='label label-success'>" . $dateCap . "</span></center></td>";
        foreach ($allRepData as $key => $repData) {
            $clientCapSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $repData['consClient'];
            $clientCap = $db->fetch_single_row($clientCapSql)['camp_name'];
            $days_of_current_month = date("t");
            $current_date = date("j");
            $totalSales = $repData['salesValue'];
            $runRate = ($totalSales / $current_date) * $days_of_current_month;
            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $clientCap . "</td>" .
                "<td class='hidden-phone'>" . $repData['saleNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['leadNumber'] . "</td>" .
                "<td class='hidden-phone'>" . number_format($repData['salesValue'], 2) . "</td>" .
                "<td class='hidden-phone'><span class='label'>" . number_format($runRate, 2) . "</span></td>" .
                "<td class='hidden-phone'>" . number_format($repData['netBalance'], 2) . "</td>" .
                "<td class='hidden-phone'>" . $repData['affApp'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['affApprovals'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['meetings'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['emails_sent'] . "</td>" .
                "<td class='hidden-phone'><a href='dailyReportDetailsAll.php?" . SENTIDU . "=" . $sec->encode_it($repData['mainId']) . "'><img src='" . SITEURL . "img/del-icon.png'></a></td>" .
                "</tr>";
            #Total Values
            $totalSalesNumber += $repData['saleNumber'];
            $totalLeadsNumber += $repData['leadNumber'];
            $totalSalesValue += $repData['salesValue'];
        }

        $totalRunRate = ($totalSalesValue / $current_date) * $days_of_current_month;

        echo
        "<tr>" .
            "<td class='hidden-phone'><span class='label'><b>" . "Total: " . $db->number_rows_hide($sp_fetch_query) . " " . "</b></span></td>" .
            "<td class='hidden-phone'><b>" . $totalSalesNumber . "</b></td>" .
            "<td class='hidden-phone'><b>" . $totalLeadsNumber . "</b></td>" .
            "<td class='hidden-phone'><span class='label label-success'><b>" . number_format($totalSalesValue, 2) . "</b></span></td>" .
            "<td class='hidden-phone'><span class='label label-info'><b>" . number_format($totalRunRate, 2) . "</b></span></td>" .
            "<td class='hidden-phone'>-</td>" .
            "<td class='hidden-phone'>-</td>" .
            "<td class='hidden-phone'>-</td>" .
            "<td class='hidden-phone'>-</td>" .
            "<td class='hidden-phone'>-</td>" .
            "<td class='hidden-phone'>-</td>" .
            "</tr>";
    }

    public function dailyMissingClients()
    {
        global $db; 
        $refDte = NULL;
        if( !isset($_GET['SEPDTE']) ){
            $currentDate = date('Y-m-d');
            $refDte      = date('Y-m-d', strtotime($currentDate . ' - 1 days'));
        }else{
            $currentDate = $_GET['SEPDTE'];
            $refDte      = date('Y-m-d', strtotime($currentDate . ' - 1 days'));
        }    
        
        $extClients       = array();
        $dailyRepClients  = array();
        $allClientsSql = "SELECT id FROM " . PREFIX ."campaigns WHERE status = '1' ";
        $allClients    = $db->fetch_all($allClientsSql);
        foreach ($allClients as $key => $valClient) {
            $extClients[] = $valClient['id']; 
        }
        $dailyRepClientsSql = "SELECT consClient FROM " . PREFIX ."daily_report_data WHERE reportDate= '".$refDte."' ";
        $dailyRepCli        = $db->fetch_all($dailyRepClientsSql);
        foreach ($dailyRepCli as $key => $valDailyClient) {
            $dailyRepClients[] = $valDailyClient['consClient']; 
        }
        
        #Find missing clients
        $count = NULL;
        $missingDaily = array_diff($extClients,$dailyRepClients);  
        foreach($missingDaily as $key => $missingClient) {
           $count++;
           $getClientNameSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = '".$missingClient."' "; 
           $getClientName    = $db->fetch_single_row($getClientNameSql)['camp_name'];
           echo
           "<tr>" .
               "<td class='hidden-phone'>".$count."</td>" .
               "<td class='hidden-phone'>".$refDte."</td>" .
               "<td class='hidden-phone'>".$getClientName."</td>" .
           "</tr>";
        }

    }

    public function dailyReportDataSep()
    {
        global $db, $sec;
        $currentDate = date('Y-m-d');
        $reportDate = date('Y-m-d', strtotime($currentDate . ' - 1 days'));

        #Filters
        $currentMonth = date('n');
        $currentYear = date('Y');

        if (isset($_REQUEST['SEPDTE']) and !empty($_REQUEST['SEPDTE'])) {
            $oneDayBack = date('Y-m-d', strtotime($_REQUEST['SEPDTE'] . ' - 1 days'));
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN aa_campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND " . PREFIX . "daily_report_data.reportDate = '" . $oneDayBack . "'  ORDER BY " . PREFIX . "campaigns.camp_name ";
            $dateCap = $this->d_format($_REQUEST['SEPDTE'], 'd-m-Y');
        } else {
            if (isset($_REQUEST['MONTH']) and !empty($_REQUEST['MONTH'])) {
                $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND month(" . PREFIX . "daily_report_data.reportDate) = " . $_REQUEST['MONTH'] . "  AND year(" . PREFIX . "daily_report_data.reportDate) = " . $currentYear . "  ORDER BY " . PREFIX . "campaigns.camp_name ";
            } else {
                $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND month(" . PREFIX . "daily_report_data.reportDate) = " . $currentMonth . "  AND year(" . PREFIX . "daily_report_data.reportDate) = " . $currentYear . "  ORDER BY " . PREFIX . "campaigns.camp_name ";
            }

            $dateCap = date('d-m-Y');
        }

        $allRepData = $db->fetch_all($sp_fetch_query);
        foreach ($allRepData as $key => $repData) {
            $clientCapSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $repData['consClient'];
            $clientCap = $db->fetch_single_row($clientCapSql)['camp_name'];
            $days_of_current_month = $this->d_format($repData['reportDate'], 't');
            $current_date = $this->d_format($repData['reportDate'], 'j');
            $totalSales = $repData['salesValue'];
            $runRate = ($totalSales / $current_date) * $days_of_current_month;

            //echo $totalSales."|".$current_date."|".$days_of_current_month."<br>";

            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $this->d_format($this->modiDate($repData['reportDate'], '+', 1), 'd-m-Y') . "</td>" .
                "<td class='hidden-phone'>" . $clientCap . "</td>" .
                "<td class='hidden-phone'>" . $repData['saleNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['leadNumber'] . "</td>" .
                "<td class='hidden-phone'>" . number_format($repData['salesValue'], 2) . "</td>" .
                "<td class='hidden-phone'><span class='label'>" . number_format($runRate, 2) . "</span></td>" .
                "</tr>";
        }
    }

    public function dailyReportDataSepAdmin()
    {
        global $db, $sec;
        $currentDate = date('Y-m-d');
        $reportDate = date('Y-m-d', strtotime($currentDate . ' - 1 days'));

        #Filters
        $currentMonth = date('n');
        $currentYear = date('Y');

        if (isset($_REQUEST['SEPDTE']) and !empty($_REQUEST['SEPDTE'])) {
            $oneDayBack = date('Y-m-d', strtotime($_REQUEST['SEPDTE'] . ' - 1 days'));
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN aa_campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND " . PREFIX . "daily_report_data.reportDate = '" . $oneDayBack . "'  ORDER BY " . PREFIX . "campaigns.camp_name ";
            $dateCap = $this->d_format($_REQUEST['SEPDTE'], 'd-m-Y');
        } else {
            if (isset($_REQUEST['MONTH']) and !empty($_REQUEST['MONTH'])) {
                #$sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND month(" . PREFIX . "daily_report_data.reportDate) = " . $_REQUEST['MONTH'] . "  AND year(" . PREFIX . "daily_report_data.reportDate) = " . $currentYear . "  ORDER BY " . PREFIX . "campaigns.camp_name ";
                $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND month(" . PREFIX . "daily_report_data.reportDate) = " . $_REQUEST['MONTH'] . "  AND year(" . PREFIX . "daily_report_data.reportDate) = " . $_REQUEST['YEAR'] . "  ORDER BY " . PREFIX . "campaigns.camp_name ";
            } else {
                $sp_fetch_query = "SELECT * FROM " . PREFIX . "daily_report_data INNER JOIN " . PREFIX . "campaigns ON " . PREFIX . "daily_report_data.consClient = " . PREFIX . "campaigns.id WHERE " . PREFIX . "daily_report_data.consClient = " . $sec->decode_it($_REQUEST[SENTID]) . " AND month(" . PREFIX . "daily_report_data.reportDate) = " . $currentMonth . "  AND year(" . PREFIX . "daily_report_data.reportDate) = " . $currentYear . "  ORDER BY " . PREFIX . "campaigns.camp_name ";
            }

            $dateCap = date('d-m-Y');
        }

        $allRepData = $db->fetch_all($sp_fetch_query);
        foreach ($allRepData as $key => $repData) {
            $clientCapSql = "SELECT camp_name FROM " . PREFIX . "campaigns WHERE id = " . $repData['consClient'];
            $clientCap = $db->fetch_single_row($clientCapSql)['camp_name'];
            $days_of_current_month = $this->d_format($repData['reportDate'], 't');
            $current_date = $this->d_format($repData['reportDate'], 'j');
            $totalSales = $repData['salesValue'];
            $runRate = ($totalSales / $current_date) * $days_of_current_month;

            //echo $totalSales."|".$current_date."|".$days_of_current_month."<br>";

            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $this->d_format($this->modiDate($repData['reportDate'], '+', 1), 'd-m-Y') . "</td>" .
                "<td class='hidden-phone'>" . $clientCap . "</td>" .
                "<td class='hidden-phone'>" . $repData['saleNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $repData['leadNumber'] . "</td>" .
                "<td class='hidden-phone'>" . number_format($repData['salesValue'], 2) . "</td>" .
                "<td class='hidden-phone'><span class='label'>" . number_format($runRate, 2) . "</span></td>" .
                "</tr>";
        }
    }

    // Old functionality.
    // public function showSalesClientLeads()
    // {
    //     global $db, $sec;
    //     if (M_QS($_GET[SENTIDU])) {
    //         $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_leads WHERE status = " . M_DI($_GET[SENTIDU]) . "  ";
    //     } else {
    //         $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_leads";
    //     }

    //     $allRec = $db->fetch_all($sp_fetch_query);
    //     foreach ($allRec as $key => $valRec) {
    //         $leadDate = $this->d_format($valRec['date_added'], 'd-m-Y');
    //         $countrySql = "SELECT * FROM " . PREFIX . "country WHERE code = '" . $valRec['country'] . "'  ";
    //         $country = $db->fetch_single_row($countrySql);
    //         #Get status caption
    //         $statusSql = "SELECT * FROM " . PREFIX . "sale_client_status WHERE stOrder =  " . $valRec['status'];
    //         $status = $db->fetch_single_row($statusSql);

    //         #@ Manage contract file
    //         #@ Check is contract made for this client
    //         $checkIFContract = "SELECT * FROM " . PREFIX . "contract_signed WHERE sale_client_leadsID = " . $valRec['id'] . " AND sigStatus = 1  ";
    //         if ($db->number_rows_hide($checkIFContract) > 0) {
    //             $haveContract = true;
    //         } else {
    //             $haveContract = false;
    //         }

    //         if (!empty($valRec['contractFile'])) {
    //             $fileCap = '<a href="' . SITEURL . UPLOADED_FILES . $valRec['contractFile'] . '" download ><span class="label label-info" >Download</span></a>';
    //             $contractInfoAction = null;
    //         } elseif ($haveContract) {
    //             $contractFor = $db->baseSelect('contract_signed', 'sale_client_leadsID = ' . $valRec['id'] . ' ');
    //             $fileCap = '<a target="_blank" href="ContractPDF.php?' . SENTID . '=' . M_EI($contractFor['id']) . '" ><span class="label label-info" >Download</span></a>';
    //             $contractInfoAction = null;
    //         } else {
    //             $fileCap = '<span class="label" >Not uploaded</span>';
    //         }

    //         #@ Handle action buttons
    //         $dupSql = "SELECT id FROM " . PREFIX . "done_deals WHERE sale_client_lead_id = " . $valRec['id'];
    //         if ($db->number_rows_hide($dupSql) > 0) {
    //             $startContractAction = null;
    //         } else {
    //             $startContractAction = '<li><a href="#" class="" data-toggle="modal" data-target="#exampleModal' . $valRec['id'] . '"><i class="icon-check"></i> Start Contract </a></i>';
    //         }

    //         #@ Check if existing into contract info
    //         $isInInfoSql = "SELECT id FROM " . PREFIX . "client_contract_info WHERE consClient = " . $valRec['id'];
    //         if ($db->number_rows_hide($isInInfoSql) > 0) {
    //             $contractInfoAction = null;
    //         } elseif (!empty($valRec['contractFile'])) {
    //             $contractInfoAction = null;
    //         } else {
    //             $contractInfoAction = '<li><a href="#conStMdl' . $valRec['id'] . '" role="button" data-toggle="modal"><i class="icon-file"></i> Add a Contract</a></a></li>';
    //         }

    //         echo
    //         "<tr>" .
    //             "<td class='hidden-phone'>" . $leadDate . "</td>" .
    //             "<td class='hidden-phone'>" . $valRec['company_name'] . "</td>" .
    //             "<td class='hidden-phone'>" . $valRec['contact_name'] . "</td>" .
    //             "<td class='hidden-phone'>" . $country['countryname'] . "</td>" .
    //             "<td class='hidden-phone'><span class='label label-success'>" . $valRec['salesAgent'] . "</span></span></td>" .
    //             "<td class='hidden-phone'>" . $valRec['url'] . "</td>" .
    //             "<td class='hidden-phone'>" . $fileCap . "</td>" .
    //             "<td class='hidden-phone'>" . $valRec['contact_email'] . "</td>" .
    //             "<td class='hidden-phone'>
    //     " .
    //             '<div class="btn-group">
    //           <button class="btn btn-mini btn-info">Action</button>
    //           <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
    //           <ul class="dropdown-menu">
    //           <li><a href="addSalesLead.php?' . SENTIDU . '=' . $sec->encode_it($valRec['id']) . '"><i class="icon-edit"></i> Edit</a></li>
    //             ' . $contractInfoAction . '
    //             ' . $startContractAction . '
    //           </ul>
    //       </div>'
    //             . "
    //     </td>" .
    //             "<td class='hidden-phone'>" . $status['stName'] . "</td>" .
    //             "</tr>";
    //     }
    // }

    public function showSalesClientLeads()
    {
        global $db, $sec;
        if (M_QS($_GET[SENTIDU])) {
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_leads WHERE status = " . M_DI($_GET[SENTIDU]) . " AND  isDel != '1'  ";
        } else {
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_leads WHERE isDel != '1' ";
        }

        $allRec = $db->fetch_all($sp_fetch_query);
        foreach ($allRec as $key => $valRec) {
            $leadDate = $this->d_format($valRec['date_added'], 'd-m-Y');
            $countrySql = "SELECT * FROM " . PREFIX . "country WHERE code = '" . $valRec['country'] . "'  ";
            $country = $db->fetch_single_row($countrySql);
            #Get status caption
            $statusSql = "SELECT * FROM " . PREFIX . "sale_client_status WHERE stOrder =  " . $valRec['status'];
            $status = $db->fetch_single_row($statusSql);

            #@ Manage contract file
            #@ Check is contract made for this client
            $checkIFContract = "SELECT * FROM " . PREFIX . "contract_signed WHERE sale_client_leadsID = " . $valRec['id'] . " AND sigStatus = 1  ";
            if ($db->number_rows_hide($checkIFContract) > 0) {
                $haveContract = true;
            } else {
                $haveContract = false;
            }

            if (!empty($valRec['contractFile'])) {
                $fileCap = '<a href="' . SITEURL . UPLOADED_FILES . $valRec['contractFile'] . '" download ><span class="label label-info" >Download</span></a>';
                $contractInfoAction    = null;
 
            } elseif ($haveContract) {
                $contractFor = $db->baseSelect('contract_signed', 'sale_client_leadsID = ' . $valRec['id'] . ' ');
                $fileCap = '<a target="_blank" href="ContractPDF.php?' . SENTID . '=' . M_EI($contractFor['id']) . '" ><span class="label label-info" >Download</span></a>';
                $contractInfoAction = null;
            } else {
                $fileCap = '<span class="label" >Not uploaded</span>';
            }

            #@ Handle action buttons
            $dupSql = "SELECT id FROM " . PREFIX . "done_deals WHERE sale_client_lead_id = " . $valRec['id'];
            if ($db->number_rows_hide($dupSql) > 0) {
                $startContractAction = null;
            } else {
                $startContractAction = '<li><a href="#" class="" data-toggle="modal" data-target="#exampleModal' . $valRec['id'] . '"><i class="icon-check"></i> Start Contract </a></i>';
            }

            #@ Check if existing into contract info
            #@ Manage functionality for additional contract
            $isInInfoSql = "SELECT id FROM " . PREFIX . "client_contract_info WHERE consClient = " . $valRec['id'];
            if ($db->number_rows_hide($isInInfoSql) > 0) {
                $contractInfoAction = null;
                $additionalContract = '<li><a href="#conStMdl' . $valRec['id'] . '" role="button" data-toggle="modal"><i class="icon-file"></i> Add Additional Contract</a></a></li>';
            } elseif (!empty($valRec['contractFile'])) {
                $contractInfoAction = null;
                $additionalContract = '<li><a href="#conStMdl' . $valRec['id'] . '" role="button" data-toggle="modal"><i class="icon-file"></i> Add Additional Contract</a></a></li>';
            } else {
                $contractInfoAction = '<li><a href="#conStMdl' . $valRec['id'] . '" role="button" data-toggle="modal"><i class="icon-file"></i> Add a Contract</a></a></li>';
                $additionalContract = null;
            }

            $deleteActionBtn = '<li><a href="#condelMdl' . $valRec['id'] . '" role="button" data-toggle="modal"><i class="icon-trash"></i> Delete Lead</a></a></li>';

            echo
            "<tr>" .
            "<td class='hidden-phone'>" . $leadDate . "</td>" .
            "<td class='hidden-phone'>" . $valRec['company_name'] . "</td>" .
            "<td class='hidden-phone'>" . $valRec['contact_name'] . "</td>" .
            "<td class='hidden-phone'>" . $country['countryname'] . "</td>" .
            "<td class='hidden-phone'><span class='label label-success'>" . $valRec['salesAgent'] . "</span></span></td>" .
            "<td class='hidden-phone'><span style='width: 50px !important;'>" . $valRec['url'] . "</span></td>" .
            "<td class='hidden-phone'>" . $fileCap . "</td>" .
            "<td class='hidden-phone'>" . $valRec['contact_email'] . "</td>" .
            "<td class='hidden-phone'>
        " .
            '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
              <li><a href="addSalesLead.php?' . SENTIDU . '=' . $sec->encode_it($valRec['id']) . '"><i class="icon-edit"></i> Edit</a></li>
                ' . $contractInfoAction . '
                '.$additionalContract.'
                ' . $startContractAction . '
                '.$deleteActionBtn.'
              </ul>
          </div>'
                . "
        </td>" .
                "<td class='hidden-phone'>" . $status['stName'] . "</td>" .
                "</tr>";
        }
    }


    public function showDoneLeads()
    {
        global $db, $sec;

        #@ Just adding values
        $totalMonthlyFee = null;
        $totalCommission = null;

        if (isset($_REQUEST[SENTIDU]) && !empty($_REQUEST[SENTIDU]) && $_REQUEST[SENTIDU] == 'SS') {
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "done_deals WHERE close_date = '0000-00-00'  ";
        }

        if (isset($_REQUEST[SENTIDU]) && !empty($_REQUEST[SENTIDU]) && $_REQUEST[SENTIDU] == 'SC') {
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "done_deals WHERE close_date != '0000-00-00'";
        }
        if (!isset($_REQUEST[SENTIDU])) {
            $sp_fetch_query = "SELECT * FROM " . PREFIX . "done_deals ";
        }

        $allRec = $db->fetch_all($sp_fetch_query);
        foreach ($allRec as $key => $valRec) {

            if ($valRec['close_date'] == '0000-00-00') {
                $dateCap = null;
                $showOptionClose = true;
                $statusCaption = 'Started';
                $lableClass = 'label-success';
                $reContAction = null;
            } else {
                $dateCap = M_DF($valRec['close_date'], 'd-m-Y');
                $showOptionClose = false;
                $statusCaption = 'Closed';
                $lableClass = 'label-important';
                $reContAction = '<li><a href="' . M_CP() . '?CURCLI=' . M_EI($valRec['id']) . '&CMD=RES_CON" > <i class="icon-rotate-left"></i> Restart Contract</a>';
            }

            if ($showOptionClose) {
                $SoCA = '<li><a href="#contCloseModel' . $valRec['id'] . '" role="button" class="" data-toggle="modal"> <i class="icon-check"></i> Close Contract</a>';
            } else {
                $SoCA = null;
            }

            #@ Handle View it action Table {aa_link_lead_camp}
            $linkedClient = $db->baseSelect('link_lead_camp', 'lead_id = ' . $valRec['sale_client_lead_id'] . ' ');
            if ($linkedClient['camp_id'] != 0) {
                $actionView = '<li><a href="new_ma.php?CONCAMP=' . M_EI($linkedClient['camp_id']) . '"><i class="icon-eye-open"></i> View Account</a></li>';
            } else {
                $actionView = null;
            }

            #@ Handle temp start date Cap
            if ($valRec['start_date'] == '0000-00-00') {
                $stDateCap = null;
            } else {
                $stDateCap = M_DF($valRec['start_date'], 'd-m-Y');
            }

            #@ Handle restarted contracts
            if (!empty($valRec['contract_note']) && empty($valRec['close_date'])) {
                $reStartCap = "<br><br><span class='label'>" . $valRec['contract_note'] . "</span> ";
            } else {
                $reStartCap = null;
            }

            $leadClient = $db->baseSelect("sale_client_leads", "id = " . $valRec['sale_client_lead_id'] . " ")['company_name'];
            $accType = $db->baseSelect("leads_account_types", "id = " . $valRec['account_type'] . " ")['name'];
            #@ Totaling values
            $totalMonthlyFee += $valRec['monthly_fee'];
            $totalCommission += $valRec['commission'];

            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $leadClient . "</td>" .
                "<td class='hidden-phone'><span class='label label-success'>" . $valRec['sales_staff_id'] . "</span></td>" .
                "<td class='hidden-phone'>" . $stDateCap . "</td>" .
                "<td class='hidden-phone'>" . $dateCap . "</td>" .
                "<td class='hidden-phone'>" . number_format($valRec['monthly_fee'], 2) . "</td>" .
                "<td class='hidden-phone'>" . number_format($valRec['commission'], 2) . "</td>" .
                "<td class='hidden-phone'>" . $valRec['currency'] . "</td>" .
                "<td style='text-align: center; ' class='hidden-phone'><span class='label " . $lableClass . " ' >" . $statusCaption . "</span>" . $reStartCap . "</td>" .
                "<td class='hidden-phone'>
        " .
                '<div class="btn-group">
              <button class="btn btn-mini btn-info">Action</button>
              <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
              <ul class="dropdown-menu">
              <li><a href="#" class="" data-toggle="modal" data-target="#editContract' . $valRec['id'] . '"><i class="icon-edit"></i> Edit Contract</a></li>
              <li><a href="createNewInvoiceContracts.php?' . SENTIDU . '=' . M_EI($linkedClient['camp_id']) . '" class="" ><i class="icon-eur"></i> Create Invoice</a></li>
                ' . $actionView . '
                ' . $SoCA . '
                ' . $reContAction . '
              </ul>
          </div>'
                . "
        </td>" .
                "<td class='hidden-phone'>" . $accType . "</td>" .

                "</tr>";
        }

        echo "<tr>
            <td><b>-</b></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>" . number_format($totalMonthlyFee, 2) . "</td>
            <td>" . number_format($totalCommission, 2) . "</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
           </tr>";
    }

    public function showLeadsNotes()
    {
        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "sale_client_notes WHERE sale_client_lead_id = " . $sec->decode_it($_REQUEST[SENTIDU]) . "  ";
        $allRec = $db->fetch_all($sp_fetch_query);
        foreach ($allRec as $key => $valRec) {
            $noteDate = $this->d_format($valRec['date_added'], 'd-m-Y');

            $notContent = '<div class="alert alert-block alert-success fade in">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <p>
                              ' . $valRec['note'] . '
                            </p>
                        </div>';

            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $noteDate . "</td>" .
                "<td class='hidden-phone'>" . $notContent . "</td>" .
                "</tr>";
        }
    }

    public function manageContractTemplates()
    {

        global $db, $sec;
        $allcontracts = "SELECT * FROM " . PREFIX . "master_contract";
        $fetchedcontracts = $db->fetch_all($allcontracts);

        $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');
        $count = null;
        foreach ($fetchedcontracts as $key => $fetchedcontract) {

            $templateBody = '<div class="widget black">
                        <div class="widget-title">
                        <h4><i class="icon-reorder"></i> ' . $fetchedcontract['name'] . '</h4>
                        <span class="tools">
                        <!--
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                        -->

                        <a href="startContract.php?' . SENTID . '=' . M_EI($fetchedcontract['id']) . '" class="icon-edit"></a>
                        <a href="" class="icon-trash"></a>
                        </span>
                          </div>
                          <div class="widget-body">
                            ' . $fetchedcontract['content'] . '
                          </div>
                      </div>';

            $count++;
            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $templateBody . "</td>" .
                "</tr>";
        }
    }

    public function showAllContractsOld()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "contract_signed WHERE sigStatus =  0";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            #@ get client Name
            $leadClient = $db->baseSelect("sale_client_leads", "id=" . $val_sp['sale_client_leadsID'] . "");
            #@ get lead Admin
            $leadAdmin = $db->baseSelect("users", "id=" . $val_sp['admin_created'] . "");

            if ($val_sp['sigStatus'] == '1') {
                $stCap = "<span class='label label-success' >Signed</span>";
            } else {
                $stCap = "<span class='label label-danger' >Pending</span>";
            }

            echo
            "<tr><td class='hidden-phone'>" . $leadClient['company_name'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['date_created'] . "</td>" .
                "<td class='hidden-phone'>" . $leadAdmin['first_name'] . " " . $leadAdmin['last_name'] . "</td>" .
                "<td class='hidden-phone'>" . "https://searlco.xyz/email_filter/finalContractView.php?" . SENTID . "=" . M_EI($val_sp['id']) . "</td>" .
                "<td class='hidden-phone'><a class='btn btn-info' href='initiateContract.php?" . SENTIDU . "=" . M_EI($val_sp['sale_client_leadsID']) . "' >Edit</a></td>" .
                "<td clas='hidden-phone'>" . $stCap . "</td>" .
                '</tr>';
        }
    }


    public function showAllContracts()
    {

        global $db, $sec;
        // $sp_fetch_query = "SELECT * FROM " . PREFIX . "contract_signed WHERE sigStatus =  0 AND isDel = 0 ";
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "contract_signed WHERE isDel = 0 ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            #@ get client Name
            $leadClient = $db->baseSelect("sale_client_leads", "id=" . $val_sp['sale_client_leadsID'] . "");
            #@ get lead Admin
            $leadAdmin = $db->baseSelect("users", "id=" . $val_sp['admin_created'] . "");

            if ($val_sp['sigStatus'] == '1') {
                $stCap = "<span class='label label-success' >Signed</span>";
            } else {
                $stCap = "<span class='label label-danger' >Pending</span>";
            }

            if ($val_sp['date_signed'] == '0000-00-00') {
                $sigCap = NULL;
            } else {
                $sigCap = $val_sp['date_signed'];
            }
            

            echo
            "<tr><td class='hidden-phone'>" . $leadClient['company_name'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['date_created'] . "</td>" .
                "<td class='hidden-phone'>" .$sigCap . "</td>" .
                "<td class='hidden-phone'>" . $leadAdmin['first_name'] . " " . $leadAdmin['last_name'] . "</td>" .
                "<td class='hidden-phone'>" . "https://searlco.xyz/email_filter/finalContractView.php?" . SENTID . "=" . M_EI($val_sp['id']) . "</td>" .
                '<td class="hidden-phone"><div class="btn-group">
                <button class="btn btn-mini btn-info">Actions</button>
                <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle b2"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                <li> <a href="initiateContract.php?' . SENTIDU . '=' . M_EI($val_sp['sale_client_leadsID']) . '&OFFAD=TRUE&NC=FALSE&CONSEDIT='.M_EI($val_sp['id']).'"><i class="icon-edit"></i> Edit</a> </li>
                <li> <a href="AllContracts.php?action=del&' . SENTIDU . '=' . M_EI($val_sp['id']) . '"><i class="icon-trash"></i> Delete</a> </li>
                </ul>
            </div>
            </td>' .

                "<td clas='hidden-phone'>" . $stCap . "</td>" .
                "</tr>";
        }
    }

    public function showTopAffs()
    {

        global $db, $sec;
        $currentYear = date('Y');
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "affiliate_monthly_report WHERE year = " . $currentYear . "  ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            $count++;
            $sepDate = $val_sp['month'] . " " . $val_sp['year'];

            #get related data Network
            $sepNetwork = $db->baseSelect("networks", "id = '" . $val_sp['network'] . "'");

            #Attempt to get the right affiliate account
            $linkedAffiliateSql = "SELECT * FROM " . PREFIX . "link_affiliates WHERE network_affiliate_id = " . $val_sp['network_affiliate_id'] . " AND network_id = " . $val_sp['network'] . "  LIMIT 1  ";

            #Get specific affiliate if mapped
            if ($db->number_rows_hide($linkedAffiliateSql) > 0) {
                $linkedAffiliate = $db->fetch_single_row($linkedAffiliateSql);
                $affiliateNameSql = "SELECT * FROM " . PREFIX . "email_details WHERE id = " . $linkedAffiliate['affiliate_id'] . " ";
                // $affiliateName    = $db->fetch_single_row($affiliateNameSql)['company'];
                $affiliateName = "Mapped";
                $affiliateLinkUrl = "EditAffiliate.php?MDAKU=" . M_EI($linkedAffiliate['affiliate_id']) . "";
                $affLink = $linkedAffiliate['affiliate_id'];
            } else {
                $affiliateName = "Not Mapped";
                $affiliateLinkUrl = "#";
                $affLink = null;
            }

            #get related client
            $sepClient = $db->baseSelect("affiliates", "id = '" . $val_sp['affiliate_id'] . "'");

            echo
            "<tr><td clas='hidden-phone'>" . $sepDate . "</td>" .
                "<!-- <td clas='hidden-phone'>" . $sepClient['affiliateName'] . " (<a target='_blank' href='" . $affiliateLinkUrl . "'> " . $affiliateName . ")" . "</a> [" . $affLink . "] {" . $linkedAffiliate['id'] . "}</td> -->" .
                "<td clas='hidden-phone'>" . $sepClient['affiliateName'] . " (<a target='_blank' href='" . $affiliateLinkUrl . "'> " . $affiliateName . ")" . "</a> </td>" .
                "<!-- <td class='hidden-phone'>" . $sepNetwork['network_nme'] . " [" . $val_sp['network_affiliate_id'] . "]" . "</td> -->" .
                "<td class='hidden-phone'><a target='_blank' href='MonthlyAffSepNet.php?" . SENTIDU . "=" . M_EI($val_sp['id']) . "' >" . $sepNetwork['network_nme'] . "</a></td> " .
                "<td class='hidden-phone'>" . $val_sp['impressions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['commission'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['clicks'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['sales'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['salesValue'] . "</td>" .
                '<td class="hidden-phone">
   <div class="btn-group">
        <button class="btn btn-mini">Action</button>
        <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
            <ul class="dropdown-menu">
            <li><a target="_blank" href="splitTopAffiliates.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '" target="_blank"><i class="icon-eye-open"></i> Network Sales Data</a></li>
            <li><a target="_blank" href="MonthlyAffsNet.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '"><i class="icon-eye-open"></i> Mapped Performance </a></li>
            </ul>
    </div>
    </td>' .
                "<td clas='hidden-phone'>" . $val_sp['leads'] . "</td>"
                . '</tr>';
            $totalImpressions += $val_sp['impressions'];
            $totalClicks += $val_sp['clicks'];
            $totalCommission += $val_sp['commission'];
            $totalSales += $val_sp['sales'];
            $totalSalesValue += $val_sp['salesValue'];
        }
        $this->topAffImpressions = $totalImpressions;
        $this->topAffClicks = $totalClicks;
        $this->topAffCommission = $totalCommission;
        $this->topAffSalesNumbers = $totalSales;
        $this->topAffSalesValues = $totalSalesValue;
    }

    public function showSplitTopAffs()
    {

        global $db, $sec;
        $getSepData = $db->baseSelect("affiliate_monthly_report", "id=" . M_DI($_REQUEST[SENTIDU]) . "");

        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE affiliate = " . $getSepData['network_affiliate_id'] . " AND network = " . $getSepData['network'] . " AND MONTH(sep_date) = " . $getSepData['month'] . "  AND YEAR(sep_date) = " . $getSepData['year'] . "   ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $doneWith = array();
        $dup = false;

        foreach ($sp_feted as $key => $val_sp) {
            $doneWith[] = $val_sp['client'];
        }

        $doneWithUnique = array_unique($doneWith);
        $arrayLength = count($doneWithUnique);

        foreach ($doneWithUnique as $key => $valMer) {

            $sp_fetch_inner_query = "SELECT SUM(impressions) AS tImpressions, SUM(affiliateCommission) AS tCommissions ,SUM(clicks) AS tClicks, SUM(salesNumber) AS tSalesNumber, SUM(salesValues) AS tSalesValues FROM " . PREFIX . "weekly_report_data WHERE affiliate = " . $getSepData['network_affiliate_id'] . " AND network = " . $getSepData['network'] . " AND MONTH(sep_date) = " . $getSepData['month'] . "  AND YEAR(sep_date) = " . $getSepData['year'] . " AND client = " . $valMer . "    ";

            $sp_fetch_inner = $db->fetch_single_row($sp_fetch_inner_query);
            #get related data Network
            $sepNetwork = $db->baseSelect("networks", "id = '" . $val_sp['network'] . "'");
            #get related merchant
            $relMerchant = $db->baseSelect("campaigns", "id = " . $valMer . " ");

            // echo
            // "<td class='hidden-phone'>".$relMerchant['camp_name']."</td>".
            // "<td class='hidden-phone'>".$sepNetwork['network_nme']."</td>".
            // "<td class='hidden-phone'>".$val_sp['impressions']."</td>".
            // "<td class='hidden-phone'>".$val_sp['affiliateCommission']."</td>".
            // "<td class='hidden-phone'>".$val_sp['clicks']."</td>".
            // "<td class='hidden-phone'>".$val_sp['salesNumber']."</td>".
            // "<td class='hidden-phone'>".$val_sp['salesValues']."</td>"
            // .'</tr>';
            // $totalImpressions    += $val_sp['impressions'];
            // $totalClicks         += $val_sp['clicks'];
            // $totalCommission     += $val_sp['affiliateCommission'];
            // $totalSales          += $val_sp['salesNumber'];
            // $totalSalesValue     += $val_sp['salesValues'];

            echo
            "<td class='hidden-phone'>" . $relMerchant['camp_name'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tImpressions'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tComissions'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tClicks'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tSalesNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tSalesValues'] . "</td>"
                . '</tr>';
            $totalImpressions += $sp_fetch_inner['tImpressions'];
            $totalClicks += $sp_fetch_inner['tClicks'];
            $totalCommission += $sp_fetch_inner['tComissions'];
            $totalSales += $sp_fetch_inner['tSalesNumber'];
            $totalSalesValue += $sp_fetch_inner['tSalesValues'];
        }

        $this->topAffImpressions = $totalImpressions;
        $this->topAffClicks = $totalClicks;
        $this->topAffCommission = $totalCommission;
        $this->topAffSalesNumbers = $totalSales;
        $this->topAffSalesValues = $totalSalesValue;

        //$this->showPre($doneWith);
    }

    public function showSplitNetTopAffs()
    {

        global $db, $sec;
        $getSepData = $db->baseSelect("affiliate_monthly_report", "id=" . M_DI($_REQUEST[SENTIDU]) . "");

        # Getting data form weekly report table { network wise for specific affiliate }
        $sepAffiliateSQL = "SELECT * FROM " . PREFIX . "link_affiliates WHERE network_id = " . $getSepData['network'] . " AND   network_affiliate_id = " . $getSepData['network_affiliate_id'] . "  ";
        $sepAffiliate = $db->fetch_single_row($sepAffiliateSQL);

        #get other related networks for the specific affiliate
        $sepAffiliateNetworksSql = "SELECT * FROM  " . PREFIX . "link_affiliates WHERE affiliate_id = " . $sepAffiliate['affiliate_id'] . "   ";
        $sepAffiliateNetworks = $db->fetch_all($sepAffiliateNetworksSql);
        $targetedNetworks = null;
        foreach ($sepAffiliateNetworks as $key => $valAffNet) {
            $targetedNetworks .= $valAffNet['network_affiliate_id'] . ",";
        }

        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE MONTH(sep_date) = " . $getSepData['month'] . "  AND YEAR(sep_date) = " . $getSepData['year'] . " AND affiliate IN(" . rtrim($targetedNetworks, ",") . ")  ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            #get related data Network
            $sepNetwork = $db->baseSelect("networks", "id = '" . $val_sp['network'] . "'");
            $clientName = $db->baseSelect("campaigns", "id = " . $val_sp['client'] . "  ");

            echo
            "<td class='hidden-phone'>" . $sepNetwork['network_nme'] . "</td>" .
                "<td class='hidden-phone'>" . $clientName['camp_name'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['impressions'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['affiliateCommission'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['clicks'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['salesNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['salesValues'] . "</td>"
                . '</tr>';
            $totalImpressions += $val_sp['impressions'];
            $totalClicks += $val_sp['clicks'];
            $totalCommission += $val_sp['affiliateCommission'];
            $totalSales += $val_sp['salesNumber'];
            $totalSalesValue += $val_sp['salesValues'];
        }

        $this->topAffImpressions = $totalImpressions;
        $this->topAffClicks = $totalClicks;
        $this->topAffCommission = $totalCommission;
        $this->topAffSalesNumbers = $totalSales;
        $this->topAffSalesValues = $totalSalesValue;
    }

    public function showSepNetTopAffs()
    {

        #This report is showing every sale on a specific network for all clients
        #Now need to show group by clients name

        global $db, $sec;
        $getSepData = $db->baseSelect("affiliate_monthly_report", "id=" . M_DI($_REQUEST[SENTIDU]) . "");

        $sp_fetch_query = "SELECT * FROM " . PREFIX . "weekly_report_data WHERE MONTH(sep_date) = " . $getSepData['month'] . "  AND YEAR(sep_date) = " . $getSepData['year'] . " AND network = " . $getSepData['network'] . "   ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        $doneWith = array();
        foreach ($sp_feted as $key => $val_sp) {
            $doneWith[] = $val_sp['client'];

            #get related data Network
            // $sepNetwork   = $db->baseSelect("networks","id = '".$val_sp['network']."'");
            // $clientName   = $db->baseSelect("campaigns","id = ".$val_sp['client']."  ");

            // echo
            // "<td class='hidden-phone'>".$clientName['camp_name']."</td>".
            // "<td class='hidden-phone'>".$val_sp['impressions']."</td>".
            // "<td class='hidden-phone'>".$val_sp['affiliateCommission']."</td>".
            // "<td class='hidden-phone'>".$val_sp['clicks']."</td>".
            // "<td class='hidden-phone'>".$val_sp['salesNumber']."</td>".
            // "<td class='hidden-phone'>".$val_sp['salesValues']."</td>"
            // .'</tr>';

            // $totalImpressions    += $val_sp['impressions'];
            // $totalClicks         += $val_sp['clicks'];
            // $totalCommission     += $val_sp['affiliateCommission'];
            // $totalSales          += $val_sp['salesNumber'];
            // $totalSalesValue     += $val_sp['salesValues'];
        }

        $doneWithUnique = array_unique($doneWith);
        foreach ($doneWithUnique as $key => $valMer) {

            $sp_fetch_inner_query = "SELECT SUM(impressions) AS tImpressions, SUM(affiliateCommission) AS tCommissions ,SUM(clicks) AS tClicks, SUM(salesNumber) AS tSalesNumber, SUM(salesValues) AS tSalesValues FROM " . PREFIX . "weekly_report_data WHERE MONTH(sep_date) = " . $getSepData['month'] . "  AND YEAR(sep_date) = " . $getSepData['year'] . " AND network = " . $getSepData['network'] . " AND  client = " . $valMer . "  ";
            $sp_fetch_inner = $db->fetch_single_row($sp_fetch_inner_query);

            #get related merchant
            $relMerchant = $db->baseSelect("campaigns", "id = " . $valMer . " ");

            echo
            "<td class='hidden-phone'>" . $relMerchant['camp_name'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tImpressions'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tComissions'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tClicks'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tSalesNumber'] . "</td>" .
                "<td class='hidden-phone'>" . $sp_fetch_inner['tSalesValues'] . "</td>"
                . '</tr>';

            $totalImpressions += $sp_fetch_inner['tImpressions'];
            $totalClicks += $sp_fetch_inner['tClicks'];
            $totalCommission += $sp_fetch_inner['tComissions'];
            $totalSales += $sp_fetch_inner['tSalesNumber'];
            $totalSalesValue += $sp_fetch_inner['tSalesValues'];
        }

        $this->topAffImpressions = $totalImpressions;
        $this->topAffClicks = $totalClicks;
        $this->topAffCommission = $totalCommission;
        $this->topAffSalesNumbers = $totalSales;
        $this->topAffSalesValues = $totalSalesValue;
    }

    public function compareClient($consClient = null, $compClient = null)
    {
        global $db;
        $getAffiliateSql = "SELECT network, network_affiliate_id FROM " . PREFIX . "affiliate_monthly_report WHERE month = " . $_POST['sepMonth'] . " AND year = " . $_POST['sepYear'] . "  GROUP BY network, network_affiliate_id  ";
        $getAffiliate = $db->fetch_all($getAffiliateSql);
        $involvedAffs = array();
        foreach ($fetAffiliate as $key => $valAff) {
            $involvedAffs = $valAff['network_affiliate_id'];
        }
        $count = null;
        $uniqueInvolvedAffs = array_unique($involvedAffs);
        foreach ($getAffiliate as $key => $valAff) {
            $count++;
            $sp_fetch_inner_query = "SELECT SUM(clicks) AS tClicks, SUM(salesNumber) AS tSalesNumber, SUM(salesValues) AS tSalesValues FROM " . PREFIX . "weekly_report_data WHERE MONTH(sep_date) = " . $_POST['sepMonth'] . "  AND YEAR(sep_date) = " . $_POST['sepYear'] . " AND affiliate = " . $valAff['network_affiliate_id'] . " AND network = " . $valAff['network'] . "  AND client = " . $consClient . "  ";
            $sp_fetch_inner = $db->fetch_all($sp_fetch_inner_query);

            foreach ($sp_fetch_inner as $key => $valInner) {
                if (!empty($valInner['tClicks'])) {

                    $sp_fetch_inner_query_comp = "SELECT id FROM " . PREFIX . "weekly_report_data WHERE MONTH(sep_date) = " . $_POST['sepMonth'] . "  AND YEAR(sep_date) = " . $_POST['sepYear'] . " AND affiliate = " . $valAff['network_affiliate_id'] . " AND network = " . $valAff['network'] . "  AND client = " . $compClient . "  ";
                    if ($db->number_rows_hide($sp_fetch_inner_query_comp) > 0) {
                        $isCommon = "<img src='" . SITEURL . "img/check-icon.png' width='16' height='16' >";
                    } else {
                        $isCommon = "<img src='" . SITEURL . "img/del-icon.png'  width='16' height='16' >";
                    }

                    $affiliateName = $db->baseSelect('weekly_report_data', "network = " . $valAff['network'] . " AND affiliate = " . $valAff['network_affiliate_id'] . " LIMIT 1 ")['affiliateName'];
                    #Get specific affiliate information
                    $findAffSql = "SELECT affiliate_id FROM ".PREFIX."link_affiliates WHERE network_id = '".$valAff['network']."' AND network_affiliate_id = '".$valAff['network_affiliate_id']."' "; 
                    $findAff    = $db->fetch_single_row($findAffSql)['affiliate_id']; 

                    echo
                    "<td class='hidden-phone'>" . $isCommon . "</td>" .
                        "<td class='hidden-phone'><a target='_blank' href='EditAffiliate.php?".SENTIDU."=".M_EI($findAff)."' >" . $affiliateName . "</a></td>" .
                        "<td class='hidden-phone'>" . $valInner['tClicks'] . "</td>" .
                        "<td class='hidden-phone'>" . $valInner['tSalesNumber'] . "</td>" .
                        "<td class='hidden-phone'>" . $valInner['tSalesValues'] . "</td>"
                        . '</tr>';
                }
            }
        }
    }

    public function sidbarCates()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "sidebar_sup_clone WHERE isActive = 0 ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<td clas='hidden-phone'>" . $val_sp['menu_title'] . "</td>" .
                '<td class=" ">
                    <div class="btn-group">
                        <button class="btn btn-mini">Action</button>
                        <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit</a></li>
                                <li><a data-toggle="modal" data-target="#exampleActive' . $val_sp['id'] . '"><i class="icon-trash"></i> Delete</a></li>
                            </ul>
                    </div>
      </td>
      </tr>';
        }
    }

    public function sidbarSubCates()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "sidebar_subClone ";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            $cateCap = $db->baseSelect("sidebar_sup_clone", "id = " . $val_sp['main_cate'] . " ")['menu_title'];
            echo
            "<td clas='hidden-phone'>" . $cateCap . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['sub_menu_title'] . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['sub_menu_link'] . "</td>" .
                '<td class=" ">
                    <div class="btn-group">
                        <button class="btn btn-mini">Action</button>
                        <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
                            <ul class="dropdown-menu">   
                                <li><a href="newSubCate.php?' . SENTID . '=' . M_EI($val_sp['id']) . '" ><i class="icon-edit"></i> Edit</a></li>
                                <li><a data-toggle="modal" data-target="#delModel' . $val_sp['id'] . '"><i class="icon-trash"></i> Delete</a></li>
                            </ul>
                    </div>
      </td>
      </tr>';
        }
    }


    public function showAffTypes()
    {

        global $db, $sec;
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "affiliates_types";
        $sp_feted = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {

            $count++;
            echo
            "<tr><td clas='hidden-phone'>" . $count . "</td>" .
                "<td clas='hidden-phone'>" . $val_sp['typeNme'] . "</td>" .
                '<td class=" ">
          <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal' . $val_sp['id'] . '"><i class="icon-edit"></i> Edit </button>
      </td>
      </tr>';
        }
    }


    public function manageRoTemplates()
    {

        global $db, $sec;
        $allcontracts = "SELECT * FROM " . PREFIX . "reachout_templates";
        $fetchedcontracts = $db->fetch_all($allcontracts);

        $badgesClass = array('badge-success', 'label-warning', 'badge-important', 'badge-info', 'badge-inverse');
        $count = null;
        foreach ($fetchedcontracts as $key => $fetchedcontract) {

            $templateBody = '<div class="widget black">
                        <div class="widget-title">
                        <h4><i class="icon-reorder"></i> ' . $fetchedcontract['tempName'] . '</h4>
                        <span class="tools">
                        <!--
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                        -->

                        <a href="affReachoutTemp.php?' . SENTID . '=' . M_EI($fetchedcontract['id']) . '" class="icon-edit"></a>
                        <!--<a href="" class="icon-trash"></a>-->
                        </span>
                          </div>
                          <div class="widget-body">
                            ' . $fetchedcontract['tempCont'] . '
                          </div>
                      </div>';

            $count++;
            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $templateBody . "</td>" .
                "</tr>";
        }
    }


    public function manageNewsletters()
    {

        global $db, $sec;
        $allnewsletters = "SELECT * FROM " . PREFIX . "client_newsletters";
        $fetchednewsletters = $db->fetch_all($allnewsletters);
        $count = null;
        foreach ($fetchednewsletters as $key => $fetchednewsletter) {
            $consClient = $db->baseSelect("campaigns", "id=" . $fetchednewsletter['consClient'])['camp_name'];
            $templateBody = '<div class="widget black">
                        <div class="widget-title">
                        <h4><i class="icon-reorder"></i> ' . $fetchednewsletter['nlName'] . ' | ' . $consClient . '</h4>
                        <span class="tools">
                        <!--
                        <a href="javascript:;" class="icon-chevron-down"></a>
                        <a href="javascript:;" class="icon-remove"></a>
                        -->

                        <a href="clientNewsletter.php?' . SENTID . '=' . M_EI($fetchednewsletter['id']) . '" class="icon-edit"></a>
                        <!--<a href="" class="icon-trash"></a>-->
                        </span>
                          </div>
                          <div class="widget-body">
                            ' . $fetchednewsletter['nlContents'] . '
                          </div>
                      </div>';

            $count++;
            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $templateBody . "</td>" .
                "</tr>";
        }
    }

    public function affAuditSer()
    {
        #imported jquery into this function
        echo '<script src="js/jquery-1.8.2.min.js"></script>';
        global $db, $custom_fun, $sec;
        if (isset($_REQUEST['doneSer']) and (!empty($_POST['affiliate_id']) or !empty($_POST['network_affiliate_id']))) {

            #Query Builder
            if (M_QS($_REQUEST['network_affiliate_id'])) {
                $getNetAff  = "&NETAFF=" . M_EI($_REQUEST['network_affiliate_id']);
                $naiConcate = " AND  network_affiliate_id  = " . $_REQUEST['network_affiliate_id'];
            } else {
                $naiConcate = NULL;
                $getNetAff  = NULL;
            }

            #Query Builder
            if (M_QS($_REQUEST['network_id'])) {
                $getNet    = "&NET=" . M_EI($_REQUEST['network_id']);
                $niConcate = " AND  network_id  = " . $_REQUEST['network_id'];
            } else {
                $getNet    = NULL;
                $niConcate = NULL;
            }

            #Redirect with values for LT selection
            //$redStr = "CONSAFF=".M_EI($_POST['affiliate_id']).$getNetAff.$getNet; 
            // $custom_fun->redirect_page(M_CP()."?".$redStr); 

            #complete search flow   
            if (M_QS($_REQUEST['affiliate_id'])) {
                $consAff = $_REQUEST['affiliate_id'];
            }
            if (!M_QS($_REQUEST['affiliate_id']) && isset($_REQUEST['network_affiliate_id'])) {
                $fetAffSql = "SELECT  affiliate_id  FROM " . PREFIX . "link_affiliates WHERE network_affiliate_id = " . $_REQUEST['network_affiliate_id'] . "    ";
                $consAff   = $db->fetch_single_row($fetAffSql)['affiliate_id'];
            }

            $throwHead = FALSE;

            $searchSql = "SELECT * FROM " . PREFIX . "email_details WHERE id = " . $consAff . "  ";
            #Get related search
            $relRec = $db->fetch_single_row($searchSql);
            #Get registerd on
            $des = NULL;
            $searchRegSql = "SELECT * FROM " . PREFIX . "link_affiliates WHERE affiliate_id = " . $consAff . " " . $naiConcate . " " . $niConcate . "  ";
            if ($db->number_rows_hide($searchRegSql) == 1) {

                $regOn = $db->fetch_single_row($searchRegSql);
                $NetName = $db->baseSelect("networks", "id = " . $regOn['network_id'] . "  ")['network_nme'];
                $addButton = ' <input type="hidden" id="sepClient' . M_DI($_REQUEST[SENTIDU]) . '" value="' . M_DI($_REQUEST[SENTIDU]) . '"  >  <input type="hidden" id="sepAff' . $consAff . '" value="' . $consAff . '"  > <input type="hidden" id="sepNet' . $regOn['network_id'] . '" value="' . $regOn['network_id'] . '"  > <input type="hidden" id="sepNetId' . $regOn['network_affiliate_id'] . '" value="' . $regOn['network_affiliate_id'] . '"  >  <button id = "doneAudit' . $regOn['network_affiliate_id'] . '"  class="btn btn-mini btn-success" > <i class="icon-plus" ></i> Add To Audit</button>';
                //$addButton = ' <input type="hidden" id="sepAff" value="1"  > <input type="hidden" id="sepNet" value="1"  > <input type="hidden" id="sepNetId" value="1"  >  <button id = "doneAudit"  class="btn btn-mini btn-success" > <i class="icon-plus" ></i> Add To Audit</button>'; 
                $des = "<tr>  <td>" . $NetName . " </td>  <td>" . $regOn['network_affiliate_id'] . "</td><td>" . $addButton . "</td></tr>";
                $throwHead = TRUE;

                /*Add to audit table*/
                $dataToIns = array(
                    'sepAff' . $consAff . ''                         => 'sepAff' . $consAff . '',
                    'sepNet' . $regOn['network_id'] . ''             => 'sepNet' . $regOn['network_id'] . '',
                    'sepNetId' . $regOn['network_affiliate_id'] . '' => 'sepNetId' . $regOn['network_affiliate_id'] . '',
                    'sepClient' . M_DI($_REQUEST[SENTIDU]) . ''      => 'sepClient' . M_DI($_REQUEST[SENTIDU]) . ''
                );
                $this->acc_click($dataToIns, 'doneAudit' . $regOn['network_affiliate_id'] . '', 'ins_audit.php', 'resDiv');
            }

            if ($db->number_rows_hide($searchRegSql) > 1) {
                $regOn = $db->fetch_all($searchRegSql);

                foreach ($regOn as $key => $regOnVal) {
                    $addButton = ' <input type="hidden" id="sepClient' . M_DI($_REQUEST[SENTIDU]) . '" value="' . M_DI($_REQUEST[SENTIDU]) . '"  > <input type="hidden" id="sepAff' . $consAff . '" value="' . $consAff . '"  > <input type="hidden" id="sepNet' . $regOnVal['network_id'] . '" value="' . $regOnVal['network_id'] . '"  > <input type="hidden" id="sepNetId' . $regOnVal['network_affiliate_id'] . '" value="' . $regOnVal['network_affiliate_id'] . '"  >  <button id = "doneAudit' . $regOnVal['network_affiliate_id'] . '"  class="btn btn-mini btn-success" > <i class="icon-plus" ></i> Add To Audit</button>';
                    $NetName = $db->baseSelect("networks", "id = " . $regOnVal['network_id'] . "  ")['network_nme'];
                    $des .= "<tr>  <td>" . $NetName . "</td>   <td>" . $regOnVal['network_affiliate_id'] . "</td><td>" . $addButton . "</td></tr>";

                    $dataToIns = array(
                        'sepAff' . $consAff . ''                            => 'sepAff' . $consAff . '',
                        'sepNet' . $regOnVal['network_id'] . ''             => 'sepNet' . $regOnVal['network_id'] . '',
                        'sepNetId' . $regOnVal['network_affiliate_id'] . '' => 'sepNetId' . $regOnVal['network_affiliate_id'] . '',
                        'sepClient' . M_DI($_REQUEST[SENTIDU]) . ''         => 'sepClient' . M_DI($_REQUEST[SENTIDU]) . ''
                    );
                    $this->acc_click($dataToIns, 'doneAudit' . $regOnVal['network_affiliate_id'] . '', 'ins_audit.php', 'resDiv');
                }
                $btn = '<a class="btn btn-success btn-small" data-toggle="modal" data-target="#addAffModal"><i class="icon-plus"></i> Add</a>';
                $throwHead = TRUE;
            }

            if ($db->number_rows_hide($searchRegSql) < 1) {


                $btn = '<a class="btn btn-success btn-small" data-toggle="modal" data-target="#addAffModal"><i class="icon-plus"></i> Add</a>';

                $des = "<tr><td>Record not found according to your search parameter | Please map from here " . $btn . "</td></tr>";

                #Get affiliate and network name

                if (!empty($consAff)) {
                    $affiliateName = $db->baseSelect("email_details", "id = " . $consAff . " ");
                } else {
                    $affiliateName = NULL;
                }

                if (!empty($_REQUEST['network_id'])) {
                    $networkName   = $db->baseSelect("networks", "id = " . $_REQUEST['network_id'] . " ");
                } else {
                    $networkName   = NULL;
                }


                echo '<div class="modal fade" id="addAffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"> </span>
                        </button><h2 class="modal-title" id="exampleModalLabel">Mapping Affiliate</h2>
                        
                        </div>
                        <div class="modal-body">
                        <form method="post" class="form-horizontal" enctype="multipart/form-data">

                                <div class="control-group">
                                    <label class="control-label">Affiliate Name:</label>
                                    <div class="controls">
                                        <input type="text" value="' . $affiliateName['company'] . '" readonly>
                                        <input type="hidden" value="' . $consAff . '" name="company" >
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Network Affiliate ID:</label>
                                    <div class="controls">
                                        <input type="text" value="' . $_REQUEST['network_affiliate_id'] . '" name="network_affiliate_id" readonly>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Network:</label>
                                    <div class="controls">
                                        <input type="text" value="' . $networkName['network_nme'] . '"  readonly>
                                        <input type="hidden" value="' . $_REQUEST['network_id'] . '" name="network_nme" >
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="doneNewAff" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    </div> 
                    </div>
                </div>';
            }

            if ($throwHead) {
                $tableHead = "<tr><th>Network</th><th>Network Affilaite ID</th><th>Actions</th></tr>";
            } else {
                $tableHead = NULL;
            }

            $desToShow = "<table border='1'class='table table-striped table-bordered ' >" . $tableHead . $des . "</table>";
            $btn = '<a class="btn btn-success btn-small" data-toggle="modal" data-target="#add_sp_modal"><i class="icon-plus"></i> Add New Network</a>';
            echo '<div>
                    <a href="#"><h3 style="color: #1a0dab; font-weight: bold; ">Details of ' . $relRec['company'] . '  </h3></a>
                    ' . $desToShow . "<br><br>" . $btn . '
                 </div> ';
        }
    }

    public function existingAffiliateAudit()
    {
        global $db, $sec;
        //$sp_fetch_query = "SELECT * FROM " . PREFIX . "affiliates_audit WHERE client_id = ".M_DI($_REQUEST[SENTIDU]);
        $sp_fetch_query = "SELECT * FROM " . PREFIX . "affiliates_audit WHERE client_id = 3";
        $sp_feted       = $db->fetch_all($sp_fetch_query);
        $count = null;
        foreach ($sp_feted as $key => $val_sp) {
            // $affDetails = $db->baseSelect("email_details" , "id =".$val_sp['affiliate_id'] );
            $affSql     = "SELECT * FROM " . PREFIX . "email_details WHERE id = " . $val_sp['affiliate_id'];
            $affDetails = $db->fetch_single_row($affSql);

            if ($val_sp['status'] == 0) {
                $capStatus = '<span class="label label-warning">Pending</span>';
            } elseif ($val_sp['status'] == 1) {
                $capStatus = '<span class="label label-info">Responded</span>';
            } elseif ($val_sp['status'] == 2) {
                $capStatus = '<span class="label label-success">Active</span>';
            } else {
                $capStatus = '<span class="label label-important">Rejected</span>';
            }
            echo
            "<tr>" .
                "<td class='hidden-phone'>" . $val_sp['network_affiliate_id'] . "</td>" .
                "<td class='hidden-phone'><a href='EditAffiliate.php?" . SENTIDU . "=" . M_EI($affDetails['id']) . "' >" . $affDetails['company'] . "</a></td>" .
                "<td class='hidden-phone'>" . $affDetails['sep_email'] . "</td>" .
                "<td class='hidden-phone'>" . $affDetails['web_url'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['date_added'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['7_day'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['14_day'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['21_day'] . "</td>" .
                "<td class='hidden-phone'>" . $val_sp['28_day'] . "</td>" .
                '<td class="hidden-phone"><div class="btn-group">
                <button class="btn btn-mini">Action</button>
                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle b2"><span class="caret"></span></button>
                    <ul class="dropdown-menu">   
                        <!--<li><a href="auditNotes.php?' . SENTIDU . '=' . M_EI($val_sp['id']) . '" ><i class="icon-edit"></i> Audit Notes</a></li>-->
                        <li><a data-toggle="modal" data-target="#getCom' . $val_sp['id'] . '"><i class="icon-comment"></i> Audit Notes</a></li>
                        <li><a data-toggle="modal" data-target="#statusChange' . $val_sp['id'] . '"><i class="icon-check-sign"></i> Change Status</a></li>
                    </ul>
                </div></td>' .
                "<td class='hidden-phone'>" . $capStatus . "</td>" .
                "</tr>";
        }
    }


    public function gapHeaders()
    {
        global $db, $sec;
        $fetSql     = "SELECT * FROM " . PREFIX . "org_gap_analysis WHERE consClient=" . $sec->decode_it($_REQUEST[SENTIDU]) . " LIMIT 1";
        $allFet     = $db->fetch_single_row($fetSql);
        $dynRec     = $allFet['gapWithComp'];

        $splitForInComp = explode(",", $dynRec);
        $outLength = count($splitForInComp);
        $incompitition = array();

        for ($i = 0; $i < $outLength; $i++) {
            $splitVal        = explode(":", $splitForInComp[$i]);

            if ($i < $outLength - 1)
                $incompitition[] = $splitVal[0];
        }

        foreach ($incompitition as $key => $value) {
            $headName   = $db->baseSelect('gap_clients', "id=" . $value . "")['affWebNme'];
            echo '<th><span>' . $headName . '</span></th>';
        }
    }

    public function getJSCall()
    {
        global $db, $sec;
        $fetSql     = "SELECT * FROM " . PREFIX . "org_gap_analysis WHERE consClient=" . $sec->decode_it($_REQUEST[SENTIDU]) . " LIMIT 1";
        $allFet     = $db->fetch_single_row($fetSql);
        $dynRec     = $allFet['gapWithComp'];

        $splitForInComp = explode(",", $dynRec);
        $outLength = count($splitForInComp);
        $incompitition = array();

        for ($i = 0; $i < $outLength; $i++) {
            $splitVal        = explode(":", $splitForInComp[$i]);

            if ($i < $outLength - 1)
                $incompitition[] = $splitVal[0];
        }
        $contJsData = " {data: 'affiliate'}, {data: 'affEmail'},";
        foreach ($incompitition as $key => $value) {
            $contJsData .= "{data: 'aff" . $key . "'},";
        }
        $contJsData .= "{data: 'status'},{data: 'actBtn'},{data: 'contactDte'},{data: '7_day'},{data: '14_day'},{data: '21_day'},{data: '28_day'}";
        return $contJsData;
    }

    public function showMailStaus()
    {
        global $db;
        $sepFetSql = "SELECT * FROM " . PREFIX . "mails_raw_data";
        $sepFetRes = $db->fetch_all($sepFetSql);
        $counter = null;
        $statusCaption = null;
        foreach ($sepFetRes as $key => $value) {
            $counter++;
            #Change status captions 
            if( $value['emailStatus'] == '0' ){
                $statusCaption = '<span class="btn btn-mini btn-info">Unknown</span> ';
            }elseif( $value['emailStatus'] == '1' ){
                $statusCaption = '<span class="btn btn-mini btn-success">Cleanded</span> ';
            }else{
                $statusCaption = '<span class="btn btn-mini btn-danger">Blocked</span> '; 
            }
            echo
            "<tr class='odd gradeX'><td clas='hidden-phone'>" . $counter . "</td>" .
                "<td class='hidden-phone'>" . $value['consEmail'] . "</td>" .
                "<td class='hidden-phone'>" . $statusCaption . "</td>" .
            '</tr>';
        }
    }

    public function showCleandedMailStaus()
    {
        $stWhere = null;
        #Get mails if date is tagged
        if(isset($_GET['UPON']) && !empty($_GET['UPON']) ){
           $stWhere = " AND updated_at = '".$_GET['UPON']."' "; 
        }else{
           $stWhere = null;
        }
        
        global $db;
        $sepFetSql = "SELECT * FROM " . PREFIX . "mails_raw_data WHERE emailStatus = 1 ".$stWhere;
        $sepFetRes = $db->fetch_all($sepFetSql);
        $counter = null;
        $statusCaption = null;
        foreach ($sepFetRes as $key => $value) {
            $counter++;
            #Change status captions 
            if( $value['emailStatus'] == '0' ){
                $statusCaption = '<span class="btn btn-mini btn-info">Unknown</span> ';
            }elseif( $value['emailStatus'] == '1' ){
                $statusCaption = '<span class="btn btn-mini btn-success">Cleanded</span> ';
            }else{
                $statusCaption = '<span class="btn btn-mini btn-danger">Blocked</span> '; 
            }
            echo
            "<tr class='odd gradeX'><td clas='hidden-phone'>" . $counter . "</td>" .
                "<td class='hidden-phone'>" . $value['consEmail'] . "</td>" .
                "<td class='hidden-phone'>" . $statusCaption . "</td>" .
            '</tr>';
        }
    }


    public function showBlockedMailStaus()
    {
        $stWhere = null;
        #Get mails if date is tagged
        if(isset($_GET['UPON']) && !empty($_GET['UPON']) ){
           $stWhere = " AND updated_at = '".$_GET['UPON']."' "; 
        }else{
           $stWhere = null;
        }

        global $db;
        $sepFetSql = "SELECT * FROM " . PREFIX . "mails_raw_data WHERE emailStatus = 2 ".$stWhere;
        $sepFetRes = $db->fetch_all($sepFetSql);
        $counter = null;
        $statusCaption = null;
        foreach ($sepFetRes as $key => $value) {
            $counter++;
            #Change status captions 
            if( $value['emailStatus'] == '0' ){
                $statusCaption = '<span class="btn btn-mini btn-info">Unknown</span> ';
            }elseif( $value['emailStatus'] == '1' ){
                $statusCaption = '<span class="btn btn-mini btn-success">Cleanded</span> ';
            }else{
                $statusCaption = '<span class="btn btn-mini btn-danger">Blocked</span> '; 
            }
            echo
            "<tr class='odd gradeX'><td clas='hidden-phone'>" . $counter . "</td>" .
                "<td class='hidden-phone'>" . $value['consEmail'] . "</td>" .
                "<td class='hidden-phone'>" . $statusCaption . "</td>" .
            '</tr>';
        }
    }


    public function emailsCsvReports($consSql,$outFileName,$colTitle=null)
    {
        global $db;        
        $csv = "".$colTitle." \n";//Column headers
        $all_records = $db->fetch_all($consSql); 
        foreach ($all_records as $key => $value_csv) {
            $csv.= $value_csv['consEmail']."\n"; 
        }
        chmod($file, 0777);
        $csv_handler = fopen('EmailFiles/'.$outFileName.'.csv','w');
        fwrite($csv_handler,$csv);
        fclose($csv_handler);
    }

} //End Class
