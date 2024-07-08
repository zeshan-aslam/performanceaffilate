<?php	ob_start();
  //
  //deciding which payment gateway is to be modified
  $id = intval($_GET['id']);
  switch($id)
  {
   	case 1://case of paypal
          header("Location:index.php?Act=paypal");
          exit;
    break;

    case 2://case of paypal
          header("Location:index.php?Act=creditcard");
          exit;
    break;

    case 3://case of stormpay
        header("Location:index.php?Act=stormpay");
        exit;
    break;

    case 4://case of stormpay
        header("Location:index.php?Act=checkout");
        exit;
    break;

	case 5://case of egold
        header("Location:index.php?Act=egold");
        exit;
    break;

  	case 10://case of egold
        header("Location:index.php?Act=worldpay");
        exit;
    break;
  }
?>