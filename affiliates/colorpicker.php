<?

	//get values
	$section = $_GET['section'];
	$oldcolor = $_GET['oldcolor'];
	$objname = $_GET['objname'];

?><head>
<title>Pick A Color</title>


	<link rel="stylesheet" type="text/css" href="../main.css">


<script language="javascript1.1">

function pick(color, target)
{
	target.value = color;
	document.color_picker.color.value = color;

	ns4 = (document.layers)?true:false;
	ie4 = (document.all)?true:false;

	if (ns4) { document.layers["colorDisplay"].bgColor = self.document.color_picker.color.value; }
	else if (ie4) { document.getElementById("colorDisplay").style.backgroundColor = self.document.color_picker.color.value; }
	else { document.getElementById("colorDisplay").style.backgroundColor = self.document.color_picker.color.value; }
}

function isHex(inText) {
	inText = inText.toUpperCase();
	if (inText == "00" || inText == "33" || inText == "66" || inText == "99" || inText == "CC" || inText == "FF")
		return true;
	else
		return false
}

function checkHexField() {
	var color = self.document.color_picker.color.value.toString();
	if (!isHex(color.substr(0,2)) || !isHex(color.substr(2,2)) || !isHex(color.substr(4,2))) {
		alert("You must enter a web-safe color.\n\nExamples: 996633, 003366, 336633");
		return false;
	}
	return true;
}

function saveColor(section,objname)
{

	var color = self.document.color_picker.color.value.toString();
	if (color.length != 6 || !isHex(color.substr(0,2)) || !isHex(color.substr(2,2)) || !isHex(color.substr(4,2)))
    {
		alert("You must enter a web-safe color.\n\nExamples: 996633, 003366, 336633");
		return false;
	}
    else
    {
        hiddenobjname = "hidden_"+objname;

		opener.document.getElementById(objname).style.backgroundColor = "#"+color;

		opener.document.getElementById(section).value = "#"+color;
        window.close();
    }


}

function sendColor(section,objname,color)
{
	if(section == 'color_border')
	{
		tableid = objname+"_table";
		trid    = objname+"_tr";
		colorid = objname+"_border";
		textid  = objname+"_color_border";
		
		opener.document.getElementById(colorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(tableid).style.borderColor = "#"+color;
		opener.document.getElementById(trid).style.backgroundColor = "#"+color;
		//opener.document.getElementById(trid).style.borderColor = "#"+color;
		opener.document.getElementById(textid).value = "#"+color;
	} else if(section == 'color_back')
	{
		trtextid	= objname+"_tr_text";
		trdescid	= objname+"_tr_desc";
		trurlid	= objname+"_tr_url";
		backcolorid = objname+"_back";
		backtextid  = objname+"_color_back";
	
		opener.document.getElementById(backcolorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(trtextid).style.backgroundColor = "#"+color;
		opener.document.getElementById(trdescid).style.backgroundColor = "#"+color;
		opener.document.getElementById(trurlid).style.backgroundColor = "#"+color;
		opener.document.getElementById(backtextid).value = "#"+color;
	}else if(section == 'color_title')
	{
		fontid	= objname+"_title_font";
		titlecolorid = objname+"_title";
		titletextid = objname+"_color_title";
		
		opener.document.getElementById(fontid).style.color = "#"+color;
		opener.document.getElementById(titlecolorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(titletextid).value = "#"+color;
	}else if(section == 'color_url')
	{
		fontid	= objname+"_url_font";
		urlcolorid = objname+"_url";
		urltextid = objname+"_color_url";
		
		opener.document.getElementById(fontid).style.color = "#"+color;
		opener.document.getElementById(urlcolorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(urltextid).value = "#"+color;
	}	else if(section == 'color_borderfont')
	{
		fontid	= objname+"_borderfont_font";
		bordcolorid = objname+"_borderfont";
		bordtextid = objname+"_color_borderfont";
		
		opener.document.getElementById(fontid).style.color = "#"+color;
		opener.document.getElementById(bordcolorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(bordtextid).value = "#"+color;
	}	else if(section == 'color_description')
	{
		fontid	= objname+"_desc_font";
		bordcolorid = objname+"_description";
		bordtextid = objname+"_color_description";
		
		opener.document.getElementById(fontid).style.color = "#"+color;
		opener.document.getElementById(bordcolorid).style.backgroundColor = "#"+color;
		opener.document.getElementById(bordtextid).value = "#"+color;
	}
//	opener.document.getElementById(trid).style.backgroundColor = "#"+color;
	
        hiddenobjname = "hidden_"+objname;

		//opener.document.getElementById(objname).style.backgroundColor = "#"+color;

		//opener.document.getElementById(section).value = "#"+color;
        window.close();
}

</script>
</head>

<body  bgcolor="#eeeeee" marginwidth="0" marginheight="0" leftmargin="0" topmargin="0">
<form name="color_picker">
<input type="hidden" name="oldcolor" value="<?=$oldcolor?>">
<input type="hidden" name="section" value="<?=$section?>">
<!--
  <table cellspacing="0" cellpadding="0" border="0" width="100%" class=tablewbdr>
    <tr><td><img src="../images/shim.gif" width="1" height="10"></td></tr>
    <tr bgcolor="#FFFFFF">
      <td><img src="../images/shim.gif" width="15" height="1"></td>
      <td width="100%"><b>Color Picker</b></td>
      <td nowrap><a onFocus="blur();"  href="javascript:self.close();"><img name="cancel" width=84 height=19 src="../images/cancel.gif" border="0"></a><img src="../images/shim.gif" width="5" height="1"><a onFocus="blur();"  href="javascript:saveColor('<?=$section?>','<?=$objname?>');"><input type="button" name="ok" value="OK"/> </a></td>
      <td><img src="../images/shim.gif" width="10" height="1"></td>
</tr>
<tr><td><img src="../images/shim.gif" width="1" height="20"></td></tr>
<tr>
<td><img src="../images/shim.gif" width="15" height="1"></td>
      <td colspan="2">Click on the color you want, then hit 'Ok' to continue.</td>
<td><img src="../images/shim.gif" width="10" height="1"></td>
</tr>
<tr><td><img src="../images/shim.gif" width="1" height="20"></td></tr>
</table>
-->
<center>

<table cellpadding="0" cellspacing="0" border="1" class=tablewbdr>
<tr><td height="2" colspan="36">&nbsp;</td></tr>
<tr> 


<td bgcolor="#000000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','000000')"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#000033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','000033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#000066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','000066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#000099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','000099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0000cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0000cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0000ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0000ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#003300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','003300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#003333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','003333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#003366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','003366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#003399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','003399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0033cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0033cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0033ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0033ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#006600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','006600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#006633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','006633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#006666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','006666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#006699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','006699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0066cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0066cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0066ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0066ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#009900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','009900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#009933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','009933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#009966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','009966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#009999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','009999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0099cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0099cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#0099ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','0099ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#00cc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00cc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00cc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00cc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00cc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00cc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00cc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00cc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00cccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00cccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#00ff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#00ffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','00ffff');"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>

<tr>


<td bgcolor="#330000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','330000' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#330033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','330033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#330066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','330066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#330099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','330099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3300cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3300cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3300ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3300ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#333300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','333300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#333333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','333333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#333366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','333366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#333399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','333399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3333cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3333cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3333ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3333ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#336600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','336600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#336633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','336633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#336666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','336666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#336699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','336699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3366cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3366cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3366ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3366ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#339900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','339900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#339933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','339933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#339966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','339966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#339999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','339999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3399cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3399cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#3399ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','3399ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#33cc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33cc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33cc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33cc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33cc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33cc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33cc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33cc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33cccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33cccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#33ff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#33ffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','33ffff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>

<tr>


<td bgcolor="#660000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','660000' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#660033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','660033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#660066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','660066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#660099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','660099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6600cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6600cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6600ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6600ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#663300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','663300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#663333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','663333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#663366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','663366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#663399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','663399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6633cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6633cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6633ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6633ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#666600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','666600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#666633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','666633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#666666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','666666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#666699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','666699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6666cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6666cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6666ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6666ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#669900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','669900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#669933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','669933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#669966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','669966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#669999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','669999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6699cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6699cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#6699ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','6699ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#66cc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66cc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66cc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66cc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66cc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66cc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66cc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66cc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66cccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66cccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#66ff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#66ffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','66ffff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>

<tr>


<td bgcolor="#990000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','990000' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#990033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','990033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#990066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','990066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#990099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','990099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9900cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9900cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9900ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9900ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#993300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','993300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#993333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','993333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#993366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','993366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#993399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','993399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9933cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9933cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9933ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9933ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#996600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','996600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#996633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','996633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#996666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','996666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#996699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','996699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9966cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9966cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9966ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9966ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#999900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','999900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#999933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','999933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#999966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','999966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#999999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','999999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9999cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9999cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#9999ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','9999ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#99cc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99cc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99cc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99cc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99cc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99cc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99cc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99cc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99cccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99cccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#99ff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#99ffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','99ffff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>

<tr>


<td bgcolor="#cc0000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc0000' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc0033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc0033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc0066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc0066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc0099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc0099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc00cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc00cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc00ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc00ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#cc3300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc3300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc3333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc3333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc3366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc3366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc3399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc3399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc33cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc33cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc33ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc33ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#cc6600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc6600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc6633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc6633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc6666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc6666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc6699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc6699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc66cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc66cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc66ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc66ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#cc9900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc9900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc9933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc9933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc9966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc9966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc9999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc9999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc99cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc99cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cc99ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cc99ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#cccc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cccc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cccc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cccc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cccc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cccc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cccc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cccc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#cccccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','cccccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ccff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ccffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ccffff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>

<tr>


<td bgcolor="#ff0000" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff0000' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff0033" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff0033' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff0066" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff0066' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff0099" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff0099' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff00cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff00cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff00ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff00ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ff3300" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff3300' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff3333" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff3333' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff3366" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff3366' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff3399" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff3399' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff33cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff33cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff33ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff33ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ff6600" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff6600' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff6633" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff6633' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff6666" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff6666' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff6699" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff6699' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff66cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff66cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff66ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff66ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ff9900" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff9900' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff9933" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff9933' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff9966" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff9966' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff9999" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff9999' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff99cc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff99cc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ff99ff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ff99ff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ffcc00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffcc00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffcc33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffcc33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffcc66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffcc66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffcc99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffcc99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffcccc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffcccc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffccff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffccff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>


<td bgcolor="#ffff00" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffff00' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffff33" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffff33' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffff66" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffff66' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffff99" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffff99' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffffcc" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffffcc' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
<td bgcolor="#ffffff" align="center"><a href="javascript:sendColor('<?=$section?>','<?=$objname?>','ffffff' )"><img border="0" src="/images/shim.gif" width="10" height="10"></a></td>
</table>
<style type="text/css">
<!--
#colorDisplay { border: black 1px solid; position:relative; width:36px; height:10px; z-index:1; visibility:visible; background-color:#ffffff; layer-background-color:#ffffff; }
//-->
</style>

<!--
<table cellspacing=0 cellpadding=4 border=0 class=tablewbdr width=50%>
<tr><td colspan=3><img src="/images/shim.gif" width=1 height=10></td></tr>
<tr>
        <td align="right" width="43%"><b>Hex Color #</b></td>
        <td width="7%">
<input class="InputBox" onKeyUp="if (document.color_picker.color.value.length == 6 && checkHexField() == true) pick(document.color_picker.color.value, document.color_picker.color);" name="color" type=text size=6 maxlength=6 value="<?=$oldcolor?>"></td>
        <td width="50%">
<div id="colorDisplay"><img src="images/shim.gif" width=36 height=16 border=0></div></td>
</tr>

</table>
-->
</center>

</form>