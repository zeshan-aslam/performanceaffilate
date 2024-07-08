<?php	ob_start();
  include_once '../includes/constants.php';
  include_once '../includes/functions.php';
  include_once '../includes/allstripslashes.php';      

  $partners=new partners;
  $partners->connection($host,$user,$pass,$db);
//  echo "$page";
  switch($act){
  case 'Add a Category':
          $category=trim($category);
          if(!empty($category)){
            $sql        ="SELECT * FROM partners_category WHERE cat_name='".addslashes($category)."'";
        $ret        =mysql_query($sql);
        if(mysql_num_rows($ret)) $msg        ="Category $category already exists";
        else {
                $sql        ="INSERT INTO partners_category (cat_name) VALUES ('".addslashes($category)."')";
            if(mysql_query($sql)){
                    $msg        ="Category ".stripslashes($category)." added";
                //copy("ads/ad_template.html","ads/$category.html");
            } else $msg        =mysql_error();
        }
    }
  break;

  case 'Update':

          $sql        ="SELECT cat_name cat FROM partners_category";
    $ret        =mysql_query($sql);
    $i                =$del        =$mod        =0;

    while($row=mysql_fetch_object($ret)){
            $name        ="name".$i;
        $id                ="id".$i;
        $name        =trim($$name);

        //echo $$name." ".$$id."<br/>";
        if(empty($name)){
                $sql        ="DELETE FROM partners_category WHERE cat_id=".$$id;
            mysql_query($sql);
           // unlink("ads/$row->cat.html");
            $del++;
        }else {
            //echo $$name."-".$row->zone." Nan inke vanthitten<br/>";
            if($name!=$row->cat){
                $sql        ="SELECT * from partners_category WHERE cat_name='".$name."'";
                $ret1        =mysql_query($sql);
                echo mysql_error();
                if(!mysql_num_rows($ret1)){
                        $sql        ="UPDATE partners_category SET cat_name='".addslashes($name)."' WHERE cat_id=".$$id;
                        mysql_query($sql);
             //       rename("ads/$row->cat.html","ads/$name.html");
                    $mod++;
                }
            }
        }
    $i++;
    }
    $msg        ="$del category(s) removed and $mod category(s) updated";
  break;
  }
  header("Location:index.php?Act=category&msg=$msg&page=$page");
  exit;
?>