<?

/*****************************************************************************/
/*                  payment report											 */
/*					date 13/may/2004										 */
/*****************************************************************************/

 $from			=$_POST['txtfrom'];
 $to			=$_POST['txtto'];
 $type			=$_POST['type'];
 $name			=addslashes(trim($_POST['name']));
 $search		=$_POST['search'];
 $id			=intval($_GET['id']);
 if(empty($page))                                     //getting page no
        $page        =$connection->getpage();
 if(empty($type)) $type="date";
 switch ($type){
 case 'date' :
 		if((!empty($from)) or (!empty($to)))
 		{
 	  			$from			=date2mysql($from);
 	   			$to				=date2mysql($to);
 	  			$sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user WHERE payment_date between '$from' and '$to'   ";
		 }
 		else
 		{
 				$sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user where user_id=payment_userid  ";
 		}
 		break;
    case 'string':
          switch($search)
          {
         case '1';
          $sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user where concat(user_fname,' ',user_lname) like '%$name%'  ";
          break;

         case '2':
          $sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user where concat(user_fname,' ',user_lname) like '$name'   ";
          break;

        case '3':
          $sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user where concat(user_fname,' ',user_lname) like '$name%'   ";
          break;

        case '4':
          $sql="SELECT *,date_format(payment_date,'%b %d,%Y')  AS date,date_format(user_expdate,'%b %d,%Y')  AS expdate FROM purchase_payment,purchase_user where concat(user_fname,' ',user_lname) like '%$name'  ";
          break;

          }
        break;
 }


        if(!empty($id)) $sql .=" and user_id='$id' ";
        $sql .= " and user_id=payment_userid ";
        $pgsql	=$sql;
        $sql   .="LIMIT ".($page-1)*$lines.",".$lines;         //adding page no
        $ret	=mysql_query($sql) ;

 if($type=='date')
 	{
    $seldate="checked" ;
    $selstr	="";
    }
 else
   {
   $seldate="";
   $selstr="checked";
   }
?>


<script>
        function from_date()
        {
         gfPop.fStartPop(document.trans.txtfrom,Date);
        }

        function to_date()
        {
         gfPop.fStartPop(document.trans.txtto,Date);
        }
</script>
<iframe width=168 height=175 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>



<form name="trans" method="post" action="">
<table   class="tablebdr" width="100%" cellpadding="0" cellspacing="0">
<tr>
		<td height="22" colspan="4" class="tdhead">Search</td>
</tr>
<tr>
		<td height="22" colspan="4" ><?=$msg?></td>
</tr>
<tr class="grid">
		<td colspan="2" align="center" >
		<input type=radio name="type" value="date" <?=$seldate?>>
		<b>Search by date</b></td>
 		<td colspan="2" align="center" ><input type=radio name="type" value="string" <?=$selstr?>>
     	<b>Search by string</b></td>
</tr>
<tr>
		<td height="22" colspan="4" ></td>
</tr>
<tr>
    	<td width="14%">From:</td>
    	<td width="30%"><input type="text" name="txtfrom" size="18"  ><a href="javascript:void(0)" onclick="javascript:from_date();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="../images/calbtn.gif" width="34" height="22" border='0' ALT=""/></a>
        </td>
        <td >Username  </td>
  		<th style='text-align: left'><select   name=search size=1 class=small>
   				 <option value="1">Contains</option>
   				 <option value="2">Equals</option>
   				 <option value="3">Start with</option>
   				 <option value="4">End Width</option>

  		</select>
    	</th>
</tr>
<tr>
		<td width="14%">To:</td>
   		<td width="30%"><input type="text" name="txtto" size="18"  ><a href="javascript:void(0)" onclick="javascript:to_date();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="../images/calbtn.gif" width="34" height="22" border='0' ALT=""/></a>
        </td>
        <td width="10%"></td>
   		<td width="35%"><input type=text name="name" value="" size=20 class=small></td>

</tr>
<tr>

    	<td colspan="4" align="center"><input name="submit" type=submit value=Display>
    	</td>

</tr>
<table>
<br/>
<?
if(mysql_num_rows($ret)>0)
{
?>

  <table class=tablebdr width="100%" cellpadding="0" cellspacing="0">

      <tr>
             <td width="25%" height="20" class="tdhead" ALIGN="center">User</td>
             <td width="25%" height="20" class="tdhead" ALIGN="center">Product</td>
             <td width="25%" height="20" class="tdhead" ALIGN="center">Period</td>
             <td width="25%" height="20" class="tdhead" ALIGN="center">Paid</td>
      </tr>
        <tr>
           <td width="100%" colspan="5" height="20" class="red">
           <p align="center"><B></B></td>
      </tr>
        <?
  		while($row=mysql_fetch_object($ret))
        {
         //--------assigning class---------------------------------//
                   $rcount++;
                   $cl=$rcount%2 ;
                   if($cl==0) $cn="grid";
                   else $cn ="grid1";

        //---------------------------------------------------------//

        //----------------finding product name---------------------//
				   $query	="SELECT * FROM purchase_product where product_id='$row->payment_productid'";
				   $output	=mysql_query($query);
					//echo $query;
					if(mysql_num_rows($output)>0)
					{
						$record		=mysql_fetch_object($output);
						$productname=$record->product_name;
					}
           //--------------------------------------------------------//
        ?>
         <tr class="<?=$cn?>">
             <td width="25%" height="20" ALIGN="center"><?=$row->user_fname?>&nbsp;<?=$row->user_lname?></td>
             <td width="25%" height="20" ALIGN="center"><a href="index.php?Act=product_edit&amp;id=<?=$row->payment_productid?>"><?=$productname?></a></td>
             <td width="25%" height="20" ALIGN="center"><?=$row->date?>---<?=$row->expdate?></td>
             <td width="25%" height="20" ALIGN="center"><?=$row->payment_amount?></td>
        </tr>

        <?
        }
         //----------close getting each day in month------------------//
                   if($cn=="grid") $cn ="grid1";       //assigning class
                   else $cn ="grid";

                  ?>
                   <tr class="<?=$cn?>">
                   <td width="100%" colspan="9" align="center">
                  <?

                   $url    ="index.php?Act=income_total&id=$id";    //adding page nos
                   include '../includes/show_pagenos.php';
                  ?>
  	                </td>
	                </tr>

  </table>
<?
}
?>