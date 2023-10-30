<?php
$path = "cocktails.json" ;
$my_json = file_get_contents($path);

$decoded_json = json_decode($my_json, true);

#var_dump($my_json);
$cocktail_array = $decoded_json["cocktails"];
$recipes = $decoded_json["recipes"];
var_dump($recipes);
#echo $recipes;
$garnishes = $decoded_json["garnishes"];
echo json_encode($garnishes);
# echo $decoded_json-> cocktails;
?> 
