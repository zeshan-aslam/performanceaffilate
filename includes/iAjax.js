var loadedobjects=""
var rootdomain="http://"+window.location.hostname

function ajaxpage(url, containerid,type){  
	var page_request = false

	if (window.XMLHttpRequest) // if Mozilla, Safari etc
		page_request = new XMLHttpRequest()
	else if (window.ActiveXObject) // if IE
	{ 
			try
			{
				page_request = new ActiveXObject("Msxml2.XMLHTTP")
			}
			catch (e)
			{
				try
				{
					page_request = new ActiveXObject("Microsoft.XMLHTTP")
				}
				catch (e){}
			}
	}
	else
		return false
	
	page_request.onreadystatechange=function()
	{
		loadpage(page_request, containerid,type)
		//document.getElementById(containerid).innerHTML = url;
	}

	page_request.open('GET', url, true)
	page_request.send(null)
}

function loadpage(page_request, containerid,type) {  
		
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)){
		if(type=='value')
			document.getElementById(containerid).value=page_request.responseText
		else
			document.getElementById(containerid).innerHTML=page_request.responseText
	}
}