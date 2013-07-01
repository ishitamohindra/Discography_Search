
function validate_form() {
	a1 = document.myform.myname.value;
	a2 = document.myform.mycategory.value;
	if(a1 =="" || a1 == null) {
		alert("This field is empty");
		}
	else {
		var url1 = "http://cs-server.usc.edu:12712/examples/servlet/HelloWorldExample?myname="+a1+"&mycategory="+a2;
		
		alert(encodeURI(url1).replace('%20','+'));
		var myreq = new XMLHttpRequest();
		myreq.open("GET","http://cs-server.usc.edu:12712/examples/servlet/HelloWorldExample",true);
		myreq.onreadystatechange = processReqChange();
		
		}
	return false;
}




function processReqChange() {
	// only if req shows "loaded"
	if (myreq.readyState == 4) {
	// only if "OK"
		if (myreq.status == 200) {
			document.getElementById("test").innerHTML = myreq.responseText;
			// and req.responseXML go here...
			} else {
				alert("There was a problem retrieving the XML data:\n"
				+ myreq.statusText);
				}
	}
} 
