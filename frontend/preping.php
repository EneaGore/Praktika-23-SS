<!DOCTYPE html>
<html> 
<head>
</head>
<style> 
.column {
float: left;  
width: 44.33%;
height : 700px;
padding: 0px;
overflow: scroll;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table; 
  clear: both;
}


.hidi {
visibility:hidden;
}
.fillin {
animation-name: filling 10s backwards  2s 6;
position:relative;
}

@keyframes filling{
from {left: 0px;}
to {left:200px;}
}

#glass {
  width: 150px;
  height: 300px;
  position: relative;
  background: #000;
  border-radius: 20%;
  overflow: hidden;
}
#glass::before {
  content: '';
  position: absolute;
  background: #04ACFF;
  width: 100%;
  bottom: 0;
  animation: wipe 10s cubic-bezier(.2,.6,.8,.4) forwards infinite;
}
@keyframes wipe {
  0% {
    height: 0;
  }
  100% {
    height: 100%;
  }
}


</style>
<body>

<div class ="row">
<div id="glass" class="column">
</div>
<div align ="center" > 
<h1> Currently making: </h1> 
<h1 id="making_2"> Making Nothing  </h1> 
<progress   class = "fillin"  > 50% </progress>
</div >
</div> 


<div class = "row" >


<div class ="column">
<h1> Cocktail in Queue </h1> 
<div id="result"> 
</div>	
</div>

<div class ="column"> 
<h1> Cocktails finished  </h1> 
<div id="making">
</div>
</div>

</div>


<script>

var source = new EventSource("../server/event.php");

function build_drink_div(id){
	return  "<h3 id=" + '"' + id + '_name"' + " class = drinky >" +id + "</h3>" 
}

var notified = false

source.onmessage = function(event) {
	console.log(event.data);
	var making = false;
	
	var  ev_da = event.data.split(":");
	let eva  ="<h1> EVENT UPDATED COCKTAIL QUEUE </h1>";
	let eva_make = ""; 
console.log(ev_da)	
	var count = 0 ;
	for (const ev of ev_da){
		
		var is_id = false;
		var ev_arr = ev.split(",");
        	var id = ev_arr[0].replace("","");
		var cock_status = ev_arr[1];
		
		if (cock_status === "making") {
		making = true;	
		document.getElementById("making_2").innerHTML = "<p>" +ev_arr[0] +"</p> <p>" + ev_arr.slice(2) +"</p> " ;
		}
		else {
		
				
        	if(id === "<?php echo $_GET["id"]?>"){
			is_id = true;
		} else {
		}
	        eva += "<br>"
			if(is_id){
			    var h_str = "<h2 id="+id+">"+ "<FONT COLOR=red>"+ ev +" </h2> ";	


			if(cock_status === "in_queue"){

				eva += h_str;} else {
				eva_make = h_str + eva_make;
		
			}
			} else {
			var stringi = "<h3 id=" + id + ">"+ "<FONT COLOR =black>" +ev+"</h3>"; 
			if(cock_status === "in_queue"){	
				
				eva += stringi} else {
				eva_make = stringi + eva_make;
			     	
			}
		}}
	count++;
	}
	if (!making){	
		var my_msg = "";
		if (ev_da.length == 1) {my_msg = "Queue is empty"} else {my_msg = "Processing Orders..."}
		document.getElementById("making_2").innerHTML =my_msg;
	} 
		document.getElementById("result").innerHTML = eva+ "<br>";
		document.getElementById("making").innerHTML = eva_make+ "<br>";
}
</script>
</body>
</html>
