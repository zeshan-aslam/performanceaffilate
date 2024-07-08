<?   reset ($_GET);

    foreach ($_GET as $key => $value)//to stripslash all get variables
    {
           $value=stripslashes(trim($value));
           $$key=$value;
           //echo "$key=>$value <br/>";
    }

        reset ($_POST);

    foreach ($_POST as $key => $value)//to stripslash all posted variables
            {
          $value=stripslashes(trim($value));
          $$key=$value;
          //echo "$key=>$value <br/>";
        }

    reset ($_GET);
    reset ($_POST);
 ?>