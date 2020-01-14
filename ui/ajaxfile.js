function selectproduct1(value){
	
 
   // var dpt_v=(document.getElementById("dpt").value);
		
	   
		if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  // for old brow.
	}

	xmlhttp.onreadystatechange = function(){
		
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			
			//result = xmlhttp.responseText;
			result=document.getElementById("studID").innerHTML =xmlhttp.responseText;
		}
		else{
			document.getElementById("studID").innerHTML = "";
		
		}
	}
	
	var url="displayproduct1.php";
url=url+"?value="+value;

//url=url+"&dpt_v="+dpt_v;


xmlhttp.open("GET",url,true);
	xmlhttp.send();
}

function selectproduct2(value){
	
 
   // var dpt_v=(document.getElementById("dpt").value);
		
	   
		if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");  // for old brow.
	}

	xmlhttp.onreadystatechange = function(){
		
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			
			//result = xmlhttp.responseText;
			result=document.getElementById("courseID").innerHTML =xmlhttp.responseText;
		}
		else{
			document.getElementById("courseID").innerHTML = "";
		
		}
	}
	
	var url="displayproduct2.php";
url=url+"?value="+value;

//url=url+"&dpt_v="+dpt_v;


xmlhttp.open("GET",url,true);
	xmlhttp.send();
}
//end of all subproduct