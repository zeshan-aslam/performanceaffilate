<?php
//############################################################################//
/*  Last Modfd          : 23/Oct/2004                                         */
/*  Script Name         : list_crm.php                                        */
//============================================================================//

//============================================================================//
// Add customer relationship module between merchant and affiliates           //
// List customer relationship module between merchant and affiliates          //
//============================================================================//
//############################################################################//




#=======================================================================
# getting variables back to form

    $crm_affiliate_id  = intval(trim(stripslashes($_GET['crm_affiliate_id'])));
    $crm_cat_id        = intval(trim(stripslashes($_GET['crm_cat_id'])));
    $crm_date          = trim(stripslashes($_GET['crm_date']));
    $crm_subject       = trim(stripslashes($_GET['crm_subject']));
    $crm_note          = trim(stripslashes($_GET['crm_note']));
    $crm_flag          = trim(stripslashes($_GET['crm_flag']));
    $crm_action        = trim(stripslashes($_GET['crm_action']));

    #list by field - show  only, hidden only or all
    $list_by           = $_GET['list_By'];

    # oreder sequesnce -DESC, ASC
    $order_seq         = $_GET['order_seq'];

    # order by - affilite, catgory, flag, date
    $order_by          = $_GET['order_By'];

    # get error code
    $errCode           = trim($_GET['errMsg']);

    # get Merchnat id
    $crm_merchant_id   = $_SESSION['CRMMERCHANT']  ;

    # set default action
    $butCaption        = "Add New" ;

    #get the value of mode
    $mode              = trim($_GET['mode']);

    #get crm id
    $crm_id            = trim($_GET['id']);

    # changing Asc and desc alternatively
    if($order_seq=="DESC") {
           $orderByValue = "ASC";
           $image        = "../images/up.gif";
    }
    else{
           $orderByValue = "DESC";
           $image        = "../images/dawn.gif";
    }

    # normal imaage
    $imageNormal        = "../images/normal.gif";

#ends here
#=======================================================================



#=======================================================================
# checking for edit mode

 if($crm_id){

        #checking whether mode is edit
        if($mode=="Edit"){

                # cahnge  default action
                $butCaption     = "Edit" ;

                      #get values from table
                      $sqlEditCrm = " SELECT *,DATE_FORMAT(crm_date,'%d/%m/%Y') AS CRM_DATE, DATE_FORMAT(crm_crdate,'%d/%m/%Y') AS CRM_CRDATE FROM partners_crm WHERE crm_id = '$crm_id'";
                      $retEditCrm = mysqli_query($con,$sqlEditCrm) or die("Error = ".mysqli_error($con));

                      #checking whether such recor exists in the tabele
                      if(mysqli_num_rows($retEditCrm)>0){

                          #getting values
                          $rowEditCrm        = mysqli_fetch_object($retEditCrm);
                          $crm_affiliate_id  = trim(stripslashes($rowEditCrm->crm_affiliateid));
                          $crm_cat_id        = trim(stripslashes($rowEditCrm->crm_cat_id));
                          $crm_id            = trim(stripslashes($rowEditCrm->crm_id));
                          $crm_date          = trim(stripslashes($rowEditCrm->CRM_DATE));
                          $crm_subject       = trim(stripslashes($rowEditCrm->crm_subject));
                          $crm_crdate        = trim(stripslashes($rowEditCrm->CRM_CRDATE));
                          $crm_type          = trim(stripslashes($rowEditCrm->crm_type));
                          $crm_note          = trim(stripslashes($rowEditCrm->crm_note));
                          $crm_flag          = trim(stripslashes($rowEditCrm->crm_flag));
                          $crm_action        = trim(stripslashes($rowEditCrm->crm_action));
                       }
        }

        #checking for delete
        elseif($mode=="Delete") {

              #deleting crm
              $sqlDeleteCrm = "DELETE FROM partners_crm WHERE crm_id = '$crm_id'";
              $retDeleteCrm = mysqli_query($con,$sqlDeleteCrm) or die("Error = ".mysqli_error($con));

              #set Message for delete
              $errCode      = 6;
        }

        #checking for change status
        elseif($mode="changeStat"){

           # getting change state
           $changeTo    = $_GET['changeTo'];

            #change status
            $sqlChangeCrm = "UPDATE partners_crm SET  crm_status='$changeTo'  WHERE crm_id = '$crm_id'";
            $retChangeCrm = mysqli_query($con,$sqlChangeCrm) or die("Error = ".mysqli_error($con));
        }
  }

# end here
#=======================================================================

#=======================================================================
# getting all affilaites linked to through the site from the table

    $sql        = "SELECT * FROM partners_affiliate ORDER BY affiliate_firstname DESC ";
    $ret        = mysqli_query($con,$sql) or die (mysqli_error($con));
    $retCat     = mysqli_query($con,$sql) or die (mysqli_error($con));

# ends herre
#=======================================================================


#=======================================================================
# generating a javascript global array REGION
# which contains the categories of selected affiliates
# after executing the script will look like

# script starts here
# var REGION = new Array ()
# fiunction loadcat()
# {
#   REGION[affilaite id] = category name;
# }
# scipt ends here

     echo "<script language=\"javascript\" type=\"text/javascript\">";

         # defines a global javascript array to hold cat names
         echo  " var REGION = new Array (); ";

         # category name corresponding to select affilates option
         # ie set default cat name = ""
         $code = " REGION[0]='' ;"  ;

         # finds all the cat names corresponding to each affiliate
         if(mysqli_num_rows($retCat)>0){

            # javascript function statrts here
            # fuction assigns category nam eto each affiliate
            # which will be stored in REGION array
            echo "function loadCat() { ";

            # assigning values to array
            for($i=0,$j=1;$i=mysql_fetch_array($retCat);$i++,$j++){
                $fld   = $i[affiliate_category];
                $pos   = $i[affiliate_id];
                $code .= " REGION[$pos]='$fld' ;"  ;
            }

         }
        echo $code;

        # setting the category name of
        # seleted affiliate
        echo " id= document.crmForm.crm_affiliate_list.value ;" ;
        echo "document.crmForm.crm_cat_id.value = REGION[id];" ;
        echo "document.crmForm.crm_cat_list.value = REGION[id];" ;

        # function endes here
        echo " } ";

   echo "</script>";

# script generation ends here
#=======================================================================


#=======================================================================
# setting err messages

# setting errMsgs Accroding to err code
    switch($errCode){

        # Empty filds
        case '1':
            $msg = " Please Don't Leave Any Fields ";
            break;

        # invalid date format
        case '2':
            $msg = " Please Enter a Valid Date  ";
            break;

        # Duplicate entry
        case '3':
            $msg = " Sorry There is Already An Entry for this Merchant,Affiliate Combination  ";
            $msg .= "<br/> Please Try Some Other Combination Or Edit It" ;
            break;

        # Successful Insertion
        case '4':
            $msg = " Record Has Been Inserted Successfully";
            break;

        # Successful Editing
        case '5':
            $msg = " Record Has Been Editted Successfully";
            break;

         # Successful deletting
        case '6':
            $msg = " Record Has Been Deleted Successfully";
            break;

         default:
           $msg = "";
           break;

    }
# setting err messages   ends here
#=======================================================================


#=======================================================================
# Getting all crm modules added for seleted merchant

    $sqlCrm = " SELECT A.affiliate_firstname, A.affiliate_lastname, C.crm_id, C.crm_flag, C.crm_type,";
    $sqlCrm.= " C.crm_date, DATE_FORMAT(crm_date,'%d/%m/%Y') AS CRM_DATE, DATE_FORMAT(crm_crdate,'%d/%m/%Y') AS CRM_CRDATE, C.crm_status, C.crm_subject ";
    $sqlCrm.= " FROM partners_crm  AS C ,partners_affiliate AS A ";
    $sqlCrm.= " WHERE crm_merchantid= '$crm_merchant_id' ";
    $sqlCrm.= " AND A.affiliate_id = C.crm_affiliateid ";

    # select by status
    if(!empty($list_by))
       $sqlCrm.= "AND C.crm_status like '$list_by' ";

    # arrange in asc or desc order
    if(!empty($order_by))
       $sqlCrm.= " ORDER BY $order_by $order_seq";


    $retCrm = mysqli_query($con,$sqlCrm) or die("Error=".mysqli_error($con));

#ends here
#=======================================================================


?>
 <iframe width="168" height="175" name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="../cal/ipopeng.htm" scrolling="no" frameborder='0' style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<br/>
<table width="90%" class="tablewbdr" align="center">
    <tr >
        <td height="25" colspan="2" class="tdhead heading-3" style="text-align:center"> Customer Relationship Module </td>
    </tr>
    <tr >
        <td height="10" colspan="2" class="textred" align="center"><?=$msg?></td>
    </tr>
</table>
<form name="crmForm" action="crm_validate.php" method="post">
<table width="90%" class="tablebdr" align="center" cellpadding="2" cellspacing="2">
    <tr class="grid1">
        <td height="25" align="right" width="40%">Affiliate Name</td>
        <td height="25" align="left">
             <select size="1" name="crm_affiliate_list" onchange="getCategory()">
                 <option value="0" >Select Affiliate</option>
                 <?
                     #=======================================================================
                     # populating affiliates list
                     #=======================================================================
                     if(mysqli_num_rows($ret)>0){
                        for($i=0,$j=1;$i=mysql_fetch_array($ret);$i++,$j++){
                            ?>
                                <option value="<?=$i[affiliate_id]?>" <?=($i[affiliate_id]==$crm_affiliate_id)?"selected='selected'":""?>><?=stripslashes($i[affiliate_firstname])?>&nbsp;<?=stripslashes($i[affiliate_lastname])?></option>
                            <?
                        }
                     }
                 ?>
      </select>   	  </td>
    </tr>
    <tr class="grid2">
        <td height="25" align="right" width="40%">Category</td>
        <td height="25" align="left"> <input name="crm_cat_list" type="text"  readonly="readonly" />
      <input name="crm_cat_id" type="hidden"  /></td>
    </tr>
    <tr class="grid2">
        <td height="25" align="right" width="40%">Subject</td>
      <td height="25" align="left"><input name="crm_subject" type="text" value="<?=$crm_subject?>" /></td>
    </tr>
     <tr class="grid2">
        <td height="25" align="right" width="40%">Correspondence Type</td>
       <td height="25" align="left"><input name="crm_type" type="text" value="<?=$crm_type?>" /></td>
    </tr>
     <tr class="grid1">
        <td height="25" align="right" width="40%">Correspondence Date</td>
       <td height="25" align="left"><input type="text" name="crm_crdate" size="10"  value="<?=$crm_crdate?>" /><a href="javascript:void(0)" onclick="javascript:cr_date();return false;" ><img name="popcal" align="bottom" src="../images/calbtn.gif" width="34" height="22" border='0' alt=""/></a></td>
    </tr>
    <tr class="grid1">
        <td height="25" align="right" width="40%">Action Date</td>
      <td height="25" align="left"><input type="text" name="crm_date" size="10"  value="<?=$crm_date?>" /><a href="javascript:void(0)" onclick="javascript:from_date();return false;" ><img name="popcal" align="bottom" src="../images/calbtn.gif" width="34" height="22" border='0' alt=""/></a></td>
    </tr>

    <tr class="grid1">
        <td height="25" align="right" width="40%">Note</td>
      <td height="25" align="left"><textarea name="crm_note" rows="5" cols="20"><?=$crm_note?></textarea></td>
    </tr>
    <tr class="grid2">
        <td height="25" align="right" width="40%">Flag</td>
        <td height="25" align="left">   <select  name="crm_flag">
                                <option value="high"   <?=($crm_flag=="high")?"selected='selected'":""?>>High</option>
                                <option value="low"    <?=($crm_flag=="low")?"selected='selected'":""?>>Low</option>
                                <option value="medium" <?=($crm_flag=="medium")?"selected='selected'":""?>>Medium</option>
      </select></td>
    </tr>
</table>
	<table width="90%" class="tablewbdr" align="center">
	    <tr >
	        <td height="10" colspan="2" ></td>
	    </tr>
	    <tr >
	        <td height="25" colspan="2" align="center" class="tdhead">
	        <input type="hidden"  name="crm_merchant_id" value="<?=$crm_merchant_id?>" />
	        <input type="hidden"  name="crm_id" value="<?=$crm_id?>" />
	        <input type="submit" value="<?=$butCaption?>" name="crm_action" />&nbsp;&nbsp;&nbsp; <input type="reset" value="Cancel"  /> </td>
	    </tr>

	</table>
</form>
<br/>
 <table width="60%" class="tablebdr" align="center">
        <tr >
           <td align="center" width="30%"> <a href="index.php?Act=list_crm"> <span class="textred">All</span>  </a> - <b>Show All</b></td>
       </tr>
       <tr>
           <td align="center" width="30%"> <a href="index.php?Act=list_crm&amp;list_By=show"> <span class="textred">Active </span></a>- <b>Show Only Active CRM</b></td>
       </tr>
       <tr>
           <td align="center" width="30%"> <a href="index.php?Act=list_crm&amp;list_By=hide"> <span class="textred"> Hidden</span> </a>- <b>Show Only Hidden CRM</b> </td>
        </tr>

 </table>
 <br/>

    <?
    if(mysqli_num_rows($retCrm)>0){
       ?>
       <table width="98%" class="tablebdr" align="center">
        <tr class="tdhead">
            <td height="25" align="center" width="20%">
                <a href="index.php?Act=list_crm&amp;order_By=A.affiliate_firstname&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='A.affiliate_firstname')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />&nbsp;
                Affiliate
                </a>
            </td>
            <td height="25" align="center" width="20%">
                <a href="index.php?Act=list_crm&amp;order_By=C.crm_subject&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='C.crm_subject')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />
                Subject
                </a>
            </td>
             <td height="25" align="center" width="10%">
                <a href="index.php?Act=list_crm&amp;order_By=C.crm_type&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='C.crm_type')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />
                Type
                </a>
            </td>
            <td height="25" align="center" width="10%">
                <a href="index.php?Act=list_crm&amp;order_By=C.crm_date&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='C.crm_date')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />
                Date
                </a>
            </td>
             <td height="25" align="center" width="10%">
                <a href="index.php?Act=list_crm&amp;order_By=C.crm_crdate&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='C.crm_crdate')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />
                Cr. Date
                </a>
            </td>

            <td height="25" align="center" width="10%">
                <a href="index.php?Act=list_crm&amp;order_By=C.crm_flag&amp;order_seq=<?=$orderByValue?>&amp;list_By=<?=$list_by?>">
                <img src="<?=($order_By=='C.crm_flag')?$image:$imageNormal?>" border='0' height="10" width="10" alt="" />
                Flag
                </a>
            </td>

            <td height="25" align="center" width="20%">Action</td>
        </tr>
       <?
       for($i=0,$j=1;$i=mysql_fetch_array($retCrm);$i++,$j++){

            $affil_name  = trim(stripslashes($i[affiliate_firstname]))." ".trim(stripslashes($i[affiliate_lastname]));
            $flag        = trim($i[crm_flag]);
            $status      = trim($i[crm_status]);


            $editStatus  = ($status=="show"?"hide":"show");
       ?>
       <tr class="<?=($j%2==0)?'grid1':'grid2'?>">
          <td height="25" align="center"><?=ucwords(strtolower($affil_name))?>  </td>
           <td height="25" align="center"><?=stripslashes($i[crm_subject])?>  </td>
            <td height="25" align="center"><?=stripslashes($i[crm_type])?>  </td>
          <td height="25" align="center"><?=$i[CRM_DATE]?>  </td>
           <td height="25" align="center"><?=$i[CRM_CRDATE]?>  </td>
          <td height="25" align="center"><?=ucwords(strtolower($flag))?>  </td>
          <td height="25" align="center">
             <a href="index.php?Act=list_crm&amp;mode=Edit&amp;id=<?=$i[crm_id]?>">Edit</a>
          || <a href="index.php?Act=list_crm&amp;mode=Delete&amp;id=<?=$i[crm_id]?>" onclick="return deleteConfirm()">Delete</a>
          || <a href="index.php?Act=list_crm&amp;mode=changeStat&amp;id=<?=$i[crm_id]?>&amp;changeTo=<?=$editStatus?>"><?=$editStatus?></a></td>
      </tr>
      <?
      }
      ?>
       </table>
      <?
    }else{
     ?><p class="textred"> Sorry No Records Found</p><?
    }
    ?>




<script language="javascript" type="text/javascript">


      function deleteConfirm(){

         var id = confirm("Do you really want to Delete ?");

         if(id) return true;
         else   return false;
        }


       function getCategory(){

            var id = document.crmForm.crm_affiliate_list.value;

            document.crmForm.crm_cat_id.value = REGION[id];
            document.crmForm.crm_cat_list.value = REGION[id];
        }

        function from_date()  {
            gfPop.fStartPop(document.crmForm.crm_date,Date);
        }

         function cr_date()  {
            gfPop.fStartPop(document.crmForm.crm_crdate,Date);
        }
</script>