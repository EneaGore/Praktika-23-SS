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
<h1 id="making_2">eeee </h1> 
<progress   class = "fillin"  > 50% </progress>
</div >

</div> 
<div >
<div  >
<h1> col 1 </h1> 
<div id="result"> 
</div>	
</div>

<div  class ="hidi" >
<h1> col 2 </h1> 
<h2> Cock in making </h2>
<div id="making">
</div>


</div>

</div>
<button onclick="call_back()" >Callback test</button>
<?php
// TODO MOVE THIS FUNCTIONALITY TO WAIT.PHP
//require_once("event.php");
$lines =  file("../database/call_cock_log.txt",FILE_IGNORE_NEW_LINES);
$callback = $lines[0];
$order =$_GET["order"];
$id =$_GET["id"];
$order_arr = explode(",",$order);
print_r( $order_arr);
file_put_contents(); 
?> 
<p> Welcome <br>  sdfaasfdasdfasdf </p>


<script>
var url = "<?php echo $callback; ?>";

// TODO: MAKE A TEST BUTTON TO CALLBACK THE WAIT COCKTAIL PHP so it can go on with the next cocktail.


// TODO take from wait.php the methods to get the callback url


async function putCallback(url){
	const response = await fetch(
		url,{
		// "https://cpee.org/flow/engine/80/callbacks/3062aa852560e2905a38a980f0b10213/",{
		method: "PUT",
		headers:{
		"Content-Type":"application/json"
		},
}
);
}
function call_back(){
putCallback(url);
}


var source = new EventSource("../server/event.php");

source.addEventListener("start_processing", (e) => {
document.getElementById("arrows").className = " cock";
// console.log("was " + callback);
// console.log("new " + e.data);
callback = e.data;
});

function build_drink_div(id){
	return  "<h3 id=" + '"' + id + '_name"' + " class = drinky >" +id + "</h3>" 
}

/*
var make_source = new EventSource("event_making.php");
make_source.onmessage =  function(e){
	console.log(new Date()); 
	document.getElementById("making").innerHTML +=e.data + "<br>";

};
 *
 */

source.addEventListener("cocktail_done", (e) => {


});

var notified = false

source.onmessage = function(event) {
	console.log(event.data);
	var making = false;
	//	document.getElementById("result").innerHTML ="<p>"e.data + "</p>";
	//	
	var  ev_da = event.data.split(":");
	let eva  ="<h1> WELCOME TO THE COCKTAIL QUEUE </h1>";
//	console.log(event.data);
	// document.getElementById("result").innerHTML = "";
	let eva_make = "<h1> Welcome to the Other queue  </h1>"; 
	var count = 0 ;
	for (const ev of ev_da){
		
		var is_id = false;
		var ev_arr = ev.split(",");
        	var id = ev_arr[0].replace("","");
		var cock_status = ev_arr[1];
//		console.log(cock_status);
//		console.log(ev);
	
        	if(id === "<?php echo $_GET["id"]?>"){
//			console.log("ITS A MATCH for id: " + id)
			is_id = true;
		} else {
			// document. getElementById("your_id").innerHTML = id;
		}
	        eva += "<br>"
			if(is_id){
			    var h_str = "<h2 id="+id+">"+ "<FONT COLOR=red>"+ ev +" </h2> ";	


			if(cock_status === "in_queue"){
				if(!making){
				
				document.getElementById("making_2").innerHTML = "<p>" +ev_arr[0] +"</p> <p>" + ev_arr.slice(2) +"</p> " ;
				making = true;

document.getElementById('glass').style.animation="animation: wipe 10s cubic-bezier(.2,.6,.8,.4) forwards";
				}

				eva += h_str;} else {
				eva_make += h_str;
//				console.log("will notify maybe"); 
				if (!notified) {
					console.log("notified");
					const notification = new Notification("Your cocktail was made!");
				notified = true
				}
		
			}
			} else {
			var stringi = "<h3 id=" + id + ">"+ "<FONT COLOR =black>" +ev+"</h3>"; 
			if(cock_status === "in_queue"){	
				
				if(!making){
				document.getElementById("making_2").innerHTML = "<p>" +ev_arr[0] +"</p> <p>" + ev_arr.slice(2) +"</p> " ;
				making = true;
			
document.getElementById('glass').style.animation="animation: wipe 10s cubic-bezier(.2,.6,.8,.4) forwards";
				}
				eva += stringi} else {
				eva_make += stringi;
			     	
			}
		}
	count++;
	}
	 
		document.getElementById("result").innerHTML = eva+ "<br>";
		document.getElementById("making").innerHTML = eva_make+ "<br>";
}
/*
$.ajax({
url :"event.php",
	success: function(result){
		console.log(result);
	}
});
 */
</script>
</body>
</html>
