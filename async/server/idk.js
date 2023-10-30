var txt =`I'm sorry to hear that your therapist isn't available at the moment. I can definitely help you with a cocktail suggestion that incorporates your preference for tequila and a spicy flavor. How about trying a 'Spicy Paloma'  cocktail? It's a delicious and refreshing drink that combines the boldness of tequila with a kick of spice. Here's a recipe you can try  Ingredients: 2 ounces tequila (blanco or reposado)
- 3/4 ounce fresh lime juice
1/2 ounce agave nectar or simple syrup
2-3 dashes hot sauce (adjust to your preferred level of spiciness)
Grapefruit soda (such as Jarritos or Squirt)
Chili salt or Tajín for rimming the glass
- Lime wedge or grapefruit slice for garnish`

var test = "ahdshsfhdhsffaj asdffsda sfdfds fsddfs"
var arr = ["tequila","gin","ice","salt", "sugar"];
var found =[]
for(const el of arr) {
if (txt.search(el) == -1) {
console.log(txt.search(/el/i));
	
	console.log("didnt find "+el );
} else {
console.log(txt.search(/el/i));
console.log("found " + el);
found.push(el)
}
}

console.log(found)
