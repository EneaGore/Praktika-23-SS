<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> 
<script src= "../server/voice_assist.php" ></script>  
		<link rel="stylesheet" href = "../stylesheets/wait_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<meta charset="utf-8" />
		<title>Le Cocktail UI</title>
		<style>
body {
	margin: 0;
	padding: 0;
	background-color: #fff;

}

	.color_input{background:#C35306 }
	.color_drinky{
                        background:#C35306;
}

.zdiv {
top:0px;
left:0px;
height :  300px;
width 200px; 
position: fixed;
z-index :0;
visibility: hidden;
background-color : black;
}
.column {
float: left;  
width: 33.33%;
height : 700px;
padding: 0px;
overflow: scroll;
}
/* Style the button that is used to open and close the collapsible content */
.collapsible {
  cursor: pointer;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .collapsible:hover {
  background-color: #ccc;
}

/* Style the collapsible content. Note: hidden by default */
.content {
  align: center;
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
}

	  html {
		  overflow: hidden;
	  } /* The switch - the box around the slider */
		</style>
	</head>
	<body> 
		<div class="topnav" >

<a class ="collapsible active" onclick = "open_popup('order_info')"> Confirm Order </a>


			<a  onclick="clear_drink()"> Clear Selection</a>
			<a onclick="window.location = 'wheel_tutorial.html'"> Spin the wheel</a>
			<a onclick="record()" > Voice Assist Ordering </a> 
			<a class ="collapsible" onclick="open_popup('commands')" >Voice Commands </a> 
<div id = "commands" class ="content">
<p> Try saying the Name of a cocktail to choose it </p> 
<p> Say Stop to end the recording </p> 
 </div> 
			<a onclick ="open_gpt3()"> GPT-3 bartender </a>
			<a onclick= "make_black()"> Dark mode  </a>  
		</div>

		<div align = "center" >
			<div id ="nav2" class="topnav_2">
			</div>
		</div>
<div align ="center" style = "background-color:white"> <h3 id ="info"> informations </h3> </div>

<div align ="center" id="order_info" style ="height:100%; width:100%; position:absolute; y-index:10"class = "content">


<p> cock </p>
</div>
		<div class = "row">


			<div  class="column">
				<h2 id = "col1h" align = "center" style="color:black"> Alchools (4 cl) </h2>	
				<div id = "col1"  align = "center" class = "number">
				</div>

			</div>
			<div class="column">
				<h2 id="col2h" align ="center" style="color:black" > Mixers (x cl) </h2>	

				<div id ="col2" align = "center" class = "number">
				</div>
			</div>


			<div  class="column">
				<h2 id ="col3h" align = "center" style="color:black"> Garnish </h2>	
				<div id = "col3" align ="center" class = "number"> 
				</div>
			</div>

		</div>
<script>

var max_alc = 16 //cl
var max_drink = 40 // cl


function count_ocurences(arr){
	var dict = {}
	for(el of arr) {
		if (!(el in dict)){
		dict[el] = 1;
		} else {
		dict[el]+=1;
		}
	}
	return (dict);
}	

var popup_is_open = false;
function open_popup(id){
	popup_is_open = !popup_is_open

if (id === "order_info"){
var end_txt = "<p> Your order is: </p>"
ord_arr = get_order();		
oc_dict = count_ocurences(ord_arr)
ord_set = new Set(ord_arr)
for(ingr of ord_set) {
	end_txt  += "<p>" +oc_dict[ingr] +"x " +ingr+  " </p>";
	console.log(ingr)
}
end_txt += "<button onclick='do_drink()'> Confirm </button> <button onclick='open_popup(" + '"' + id + '"' + ")'> Change </button>"
document.getElementById("order_info").innerHTML = end_txt;

} 	
	
var content = document.getElementById(id); 
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
//}
//);
//}
}
function recordi(){
record();
}

var total_cl = 0 // maximum is probably like 40 cl

<?php 
$content = file_get_contents("../database/cocktails.json");
$json_content = json_decode($content,true);
?>

var cocktails = <?php echo json_encode($json_content["cocktails"]); ?> ;
var garnish = <?php echo json_encode($json_content["garnishes"]); ?> ;
var mixers = <?php echo json_encode($json_content["mixers"]); ?>; 
var alcs = <?php echo json_encode($json_content["alcs"]); ?>;

var cock_button = ""; 

var color_txt = "black"
var recipes = <?php echo json_encode($json_content["recipes"]); ?> ;


let ingred = alcs.concat(garnish).concat(mixers) 

// XXX Building cocktail button 	
for(const cock of cocktails) {
	console.log(cock);
	cock_button += "<a  id=" + cock+  ' onclick=set_one('+  '"' + cock + '"' +')>' + cock + " </a>" 
}
document.getElementById("nav2").innerHTML = cock_button;

let person = "test_person"; 
var callback = "absolutelty fucking nothing";
const sse = new  EventSource("../server/event.php");
sse.addEventListener("callback_change", (e) => {
	callback = e.data;
});

// Turns the thing darker
var is_black = false;
function make_black(){	
	if(!is_black){
	var bgk = "#4f4f4f"
	var clr = "white" 
	is_black = true;
} else {
	is_black = false;
	var bgk = "white"
	var clr = "black" 
}
	document.body.style.backgroundColor = bgk;
	document.getElementById("col1h").style.color =clr;
	document.getElementById("col2h").style.color =clr;
	document.getElementById("col3h").style.color =clr;
	for(const el of ingred){
		document.getElementById(el+"_name").style.color = clr
		document.getElementById(el).style.backgroundColor = bgk
		document.getElementById(el).style.color = clr;
	}

}


function build_drink_div(id){
	return  "<h3 id=" + '"' + id + '_name"' + " class = drinky style='color:"+ color_txt+"'  >" +id + "</h3>" 
		+ '<span onclick= dec('+'"'+ id+ '"'  +")"+" class=minus>-</span>"
		+ "<input  id=" + '"' +id+'"' + 'type="text" value="0"/>'+
		"<span onclick=inc(" + '"' + id + '"' + ') class=plus>+</span>' + "<br>"
}

var col3_str ="";
var col1_str = "";
var col2_str = "";
for(const id  of garnish){	col3_str += build_drink_div(id); }
for(const id  of mixers){ 	col2_str += build_drink_div(id); }
for(const id  of alcs){	        col1_str += build_drink_div(id); }

document.getElementById("col1").innerHTML = col1_str ;
document.getElementById("col2").innerHTML = col2_str ;
document.getElementById("col3").innerHTML = col3_str ;


let sum = 0
function getQSVar( varname ) { 
	var query = window.location.search.substring( 1 ); 
	var vars = query.split( "&" );
	var len = vars.length; 
	for ( var i = 0; i < len; i++ ) { 
		var pair = vars[ i ].split( "=" ); 
		if ( pair[ 0 ] == varname ) { 
			return pair[ 1 ]; 
		} 
	} 
	return null;
}
var  col  = getQSVar( 'cock' ); 
// console.log(col);
let ingred_arr = [];
var ingred_order = getQSVar( "gpt");
console.log(ingred_order);
if(ingred_order !== null){
	console.log("wasnt null")
 ingred_arr = ingred_order.split(",");
//console.log(document.getElementById(ingred_arr[0]).value =2 )
 console.log(ingred_arr);
} else {}
function focus_btn(){

	for(const [key,value]  of Object.entries(recipes)){
		console.log(key);
		highlight(key);
	}
}


var wait = (ms) => {
	const start = Date.now();
	let now = start;
	while (now - start < ms) {
		now = Date.now();
	}
}


//  open the gpt 3 page
function open_gpt3(){
	window.location = "my_gpt3.php";
}

function do_drink(){
	var prompt_str = "Give a name :-) (no spaces)";
	//var person = ""
	while(!person){
		var person = prompt(prompt_str);
		if(person.indexOf(" ") !== -1){
			console.log("FOUND A SPACE") ;
			//continue;
			prompt_str = "No space amigo, NO SPACE";
			person = false;
		}
		if (person ==="Max" ||  person === "Justus"){
			prompt_str = "I said be original: ";
			person = false;

		}
	}

	let uniq =  person.replace(" ","_");
	let order = get_order();
	console.log(order)

	var order_join = ""

	const test_url = "https://lehre.bpm.in.tum.de/~ge72git/prak_23_enea/server/order_queue.php"
	// Calls back the waiting service, sends the order details with it:


	$.post(test_url,{id:uniq, order:order.toString() } ,function(response) {
	window.location = "preping.php?id="+uniq;	
	console.log(response)
		});
	
}


function say_something(say_msg){
	const synth = speechSynthesis;
	synth.cancel()
	utter = new SpeechSynthesisUtterance(say_msg );
	utter.rate = 1
	// window.speechSynthesis.cancel();
	synth.speak(utter);
}

async function putCallback(url,iid,oorder){
	return	await fetch(
		callback,{
			method: "PUT",
			headers:{
				"Content-Type":"application/json"
			},
			body: JSON.stringify({id:iid, order:oorder })
		}
	) ;
}

function get_order(){
	var order_arr = [];
	for(const el_id of ingred){
		const doc_val = parseInt(document.getElementById(el_id).value,10);
		for(let i = 0; i <doc_val;i++){
			order_arr.push(el_id);
		}
	}
	return order_arr;
	// TODO a lot of stu
}

//get_order();
function clear_drink(){

	for (const el of ingred) {
		document.getElementById(el).value = 0 ;
		document.getElementById(el+"_name").className = " drinky";

		document.getElementById(el).className = " ";
	}	
}


if(col !== null){
set_one(col);
}
if(ingred_order !== null) {
// 	console.log(ingred_arr.length)
set_arr();
} 

function set_arr(){
clear_drink();
for(const el of ingred_arr){
	inc(el);
}
}
function set_one(drink) {
	var txt = ""
	clear_drink();	
	let rec_arr = recipes[drink];
	
	console.log(drink);

	switch (drink){
	case "bloody_mary":
		txt = "Sometimes you need coffee, and sometimes you need a Bloody Mary.";
		break;
	case "white_russian":
		txt ="The dude abides."; 
		break;
	case "gin_tonic":
		txt  = "The gin and tonic has saved more Englishmen's lives, and minds, than all the doctors in the Empire “ Sir Winston Churchill";
		break;
	case "mojito":
		txt = "When life gives you lemons, make mojito of course";
		break;
	case "old_fashioned":
		txt = "There is no bad whiskey. There are only some whiskeys that aren’t as good as others";
		break;
	case "cuba_libre":
		txt = "Muchos gustos selección";
		break;
	case "long_island":
		txt = "https://www.aa.org/";
			break;
	default:
	txt = " Excellent choice";
	}
	
	document.getElementById("info").innerHTML = txt 
		for(const element of rec_arr){
	//	document.getElementById(element).value = 1;
		inc(element);
		document.getElementById(element+"_name").className += " color_drinky";
		document.getElementById(element).className = " color_input";
	}
	if(popup_is_open) {
console.log("popup was open closing")
	open_popup("order_info"); } else {console.log("popup was closed")}
}

// dont let the name drink fool you, its just one ingredient
function dec(drink){
	//      let parentDom = document.getElementById('n1');
	let value =parseInt( document.getElementById(drink).value,10);
	new_val = value > 0 ? value -1 : value
	document.getElementById(drink).value = new_val;
	if(new_val == 0){

		document.getElementById(drink+"_name").className = " drinky";
		document.getElementById(drink).className = " ";
	}

}

function inc(drink) {
	console.log("called for: " + drink);
	let value = parseInt(document.getElementById(drink).value,10);
	new_val = value + 1
	document.getElementById(drink).value = new_val;

	//	document.getElementById(drink+"_name").className += " cock";
	document.getElementById(drink+"_name").className += " color_drinky";
	document.getElementById(drink).className += " color_input";
	var amount = 0
	if(drink in mixers){amount = 10;} 
	else if (drink in alcs) {amount = 4}
	else if(drink === "ice") {amount = 4} 
	// id dont fucking know we have to calcualted ice displacmend

	if(total_cl + amount < 40){
	total_cl += 4;
	console.log(total_cl)
	} else {console.log("amount exceded "+total_cl)}
}


// XXX NOTIFICATION REQUESTS
function request_notifs() {
Notification.requestPermission().then((result) => {
  console.log(result);
  if(result == "denied"){
  document.getElementById("info").innerHTML = "Your browser has denied Notifications, Press the lock button on the left and enable";
  } else if (result == "granted") {
  
  document.getElementById("info").innerHTML = "Your notifications are enabled, you will be notified when your cocktail is ready";
  } 
});


}

function record(){ 
const grammar =
  "clear selection | gin| gin tonic |white russian | caipirinha |old fashioned | mojito |long island ice tea | bloody mary ;";

// XXX VOICE ASSITANCE CODE
let recognition = new webkitSpeechRecognition();
	const speechRecognitionList = new webkitSpeechGrammarList();
	speechRecognitionList.addFromString(grammar, 1);
	recognition.grammars = speechRecognitionList;
	recognition.continous = true;
	recognition.interimResults =true;
	recognition.lang = "en-GB";
	recognition.maxAlternatives =3;
	console.log("starting to record")
	recognition.start();
	
	recognition.addEventListener("soundstart", () => {
  		console.log("Some sound is being received");
	});

	recognition.addEventListener("speechend", () => {
//		recognition.stop();
		console.log("stoped speaking")
	});
	
		var txtRec = '';
	recognition.onresult = function(event){
		txtRec = event.results[0][0].transcript.toLowerCase().replace(".","");
		// document.getElementById('speech').innerHTML = txtRec;
		console.log(txtRec);
		if(txtRec === "order") {
			console.log("you said order");
		document.getElementById("info").innerHTML = txtRec;
		}

		const myArr = txtRec.split(" ");
		console.log(myArr); 
		if(myArr.indexOf("and") > -1){
		
	document.getElementById("info").innerHTML = "chill bro im slow";
		} else {
			document.getElementById("info").innerHTML = txtRec;}
		

		for(const cock of cocktails) {
			if(txtRec === cock.replace("_"," ")){
				set_one(cock);
			}
		}

		
		
/*
		switch(txtRec){
		case "gin tonic": 
				set_one("gin_tonic");
				break;
		case "cocktail":
		case "more gin":
		case "more gin":
		case "add gin":
		case "extra gin":
		case "add gene":
		case "extra gene":
		case "more gene":	
				inc("gin");
				break;
		case "stop":
				return;
		}*/
	}

recognition.onend = function(event) {	
	if(txtRec === "stop"){
		console.log("returning");
	return;
	}
	console.log("waiting")
	wait(250);
	console.log("started")
	recognition.start();
	//console.log("rec ended");
}		
	console.log("finished recording")	
}

		</script>
		</div> 
	</body>
</html>



