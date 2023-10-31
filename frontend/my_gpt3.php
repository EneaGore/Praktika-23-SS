<!DOCTYPE html>
<html>
<style>
button:disabled {
	background-color : black;
}

html {
margin: 10px;
overflow:hidden;
background-color:black;
}

.writebox{
padding: 5px;
background-color: black;
align :center;
overflow-y: scroll;
}

.replybox{
background-color: #000;
height:450px;
width: 100%;
align :center;
overflow-y: scroll;
}

.textbox {
height:100px;
left :0px;
width : 90%;
bottom: 5px;
position:relative ;
resize : none;
border: double 5px #fff;
}


.typereply {
  color:#0000;
 white-space: pre-wrap;
  background:
    linear-gradient(-90deg,#fff 5px,#0000 0) 10px 0,
    linear-gradient(#fff 0 0) 0 0;
  background-size:calc(var(--n)*1ch) 200%;
  -webkit-background-clip:padding-box,text;
  background-clip:padding-box,text;
}

.type {
  color:#0000;
 white-space: pre-wrap;
  background:
    linear-gradient(-90deg,#fff 5px,#0000 0) 10px 0,
    linear-gradient(#fff 0 0) 0 0;
  background-size:calc(var(--n)*1ch) 200%;
  -webkit-background-clip:padding-box,text;
  background-clip:padding-box,text;
   background-repeat:no-repeat;
   animation: 
   b .7s infinite steps(1),   
   t calc(var(--n)*.025s) steps(var(--n)) forwards;
}



@keyframes t{
  from {background-size:0 200%}
}
@keyframes b{
  50% {background-position:0 -100%,0 0}
}
.typewriter h2 {
  color: #000;
  font-family: monospace;
  overflow: hidden; /* Ensures the content is not revealed until the animation */
  border-right: .15em solid white; /* The typwriter cursor */ 
 white-space: nowrap; /* Keeps the content on a single line */
  margin: 0 auto ; /* Gives that scrolling effect as the typing happens */
  letter-spacing: .30em; /* Adjust as needed */
animation: 
    typing 3.5s steps(30, end)
}

@keyframes typing{
from {width : 0}
to {width: 100%}
}

@keyframes blink-caret{
  50% { border-color: white};
}


</style>
<body>
<div align = "center">

<div align = "center">
<h1 align ="center" style="color:white" > Your virtual bartender </h1> 
<div class ="typewriter"> 
<h2 align = "center" style ="color:white" >Share something with your GPT-3 Bartender and get a Recommendation</h2>
</div> 

</div>

<p> </p> 

<button id="send" onclick="send()"> Copy and Customize the recomandation </button>
<p> </p>
<div class ="replybox" id ="replies">
</div>

<div class="writebox">
<textarea onkeypress="generate_input('txt','reply')" align = "center" class = "textbox"  id = "txt" style="background-color:black; color:white"> </textarea>

</div>
</div>
<script>
// const {Configuration, OpenAIApi} = require("openai");
// focus the text area on load
document.getElementById("txt").focus();

var garnish  = ["tabasco", "lemon", "ice", "grenadine","curacao", "simple syrup", "mint","salt",  "sugar","heavy cream","bitters"];
var mixers  = ["cola","tonic","sprudel","redbull","orange_juice","sprite", "cocunt_milk", "seamen", "tomato_juice"];
var alcs  = ["gin", "vodka", "tequila", "whiskey","jagermeister","kahlua", "white_rum", "dark_rum","triple sec", "aperol"];
var parsed_order = "";
let ingred = alcs.concat(garnish).concat(mixers) 

function show(){
	create_rep(my_input,my_response);
}

function print_found(){
console.log(parsi())
}
// take an array of keyword and a txt string as variables
function parsi(){
var found = []
console.log("parse called");
var txt = document.getElementById("reply").innerHTML.toLowerCase(); 
console.log(txt.split("\n"));
for(const el of ingred) {

if (txt.search(" "+el) == -1) {
// console.log(txt.search(/el/i));	
// console.log("didnt find "+el );
} else {
console.log(txt.search(/el/i));
found.push(el.replace(" ","_") )
}
}
return(found);
}

function send(){
window.location = "../frontend/wait.php?gpt="+parsi();
}


//var prompt_text = "I want to make a cocktail, can you recommend me with detailed instructions based on:  "  
//var prompt_text2 ="Can you give me a recommandation"
var my_input = " Write something, press Enter and then press Show response ";

var my_response = "Please wait for the response, GPT 3.5 Turbo is powerful but slow, might take between 1-3 minutes at times"
async function gpt_call(user_input){

const OPEN_API_KEY = "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"
var data = {

    "model": "gpt-3.5-turbo",
    //"prompt": user_input,
	 
    "messages" : [{"role" :"user" , "content" : "Give me detailed cocktail recommandations in metric based on my input:" + user_input }],
    "temperature": 0.7,
    "max_tokens": 256
    //"top_p": 1,
    //"frequency_penalty": 0.8,
    //"presence_penalty": 0
  }

console.log("Sending");
var url = "https://api.openai.com/v1/chat/completions";
//var url = "https://api.openai.com/v1/engines/text-davinci-002/completions"
 fetch(
		url,{
			method: "POST",
			headers: new Headers({
				"Content-Type":"application/json",
				"Authorization":"Bearer "+OPEN_API_KEY
			//	"Accept" :"application/json"
			}),
			body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(responseData => { 
  console.log(responseData);
  //	document.getElementById("replies").innerHTML = "why u no work";
  my_response = responseData["choices"][0]["message"]["content"];
  console.log(my_response);
  create_rep(user_input,my_response);
  }); 
}

// gpt_call();

var prev_chat = []
function go_back(){window.location = "../frontend/wait.php"}

function create_rep(input,output){
	found= []

	var replies = 	document.getElementById("replies");
		x = output.length; 
		// this is the output box
		input_txt  = "<span class ='type' style='color:gray'>"+input+"</span> <br>" 
		reply_txt  = "<span id='reply' class='type' style ='--n:"+ x+"'>"+output+"</span> <br>" 
		
	// button  = "<button style = 'border-radius:20%;color:white;background-color:gray' onclick='parsi()' > Copy reply </button>";
		simple_txt = "<span class ='type'  "+ x+"'>"+output+"</span> <br>"
		total_txt = "" 
		for(const chat of prev_chat){
		total_txt += chat;
		}
		
		total_txt = input_txt + "<br>" +reply_txt 
		replies.innerHTML = total_txt; 	
        	// replies.innerHTML = reply_txt;	

		// replies.scrollTop = replies.scrollHeight;
		prev_chat.push(simple_txt);
		return total_txt;
}

function generate_input(id,rep){
const pre_txt = "Pretend you are a bartender, given the following text give a cocktail Recommendation with metric recipe: "
	var key = window.event.keyCode;
	var shift = window.event.shiftKey; 
	console.log(key);
	console.log(shift);	
	if(key === 13 && !shift){
		
	var clear = true;
	// the element here is the txt area	
	my_input = document.getElementById(id).value
	create_rep(my_input, my_response);
		
	gpt_call(my_input);
	
	console.log(my_response);
	}
	if(clear) {clear_txt()};
	}

function clear_txt(){
	document.getElementById("txt").value  = "";	
}
function parse_output(){
}

function reply(){
//gpt_call();	
document.getElementById("reply").innerHTML = my_response;
}	
</script>
</body>
</html>

