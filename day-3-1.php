<?php

/*
	
--- Day 3: Perfectly Spherical Houses in a Vacuum ---

Santa is delivering presents to an infinite two-dimensional grid of houses.

He begins by delivering a present to the house at his starting location, and then an elf at the North Pole calls him via radio and tells him where to move next. Moves are always exactly one house to the north (^), south (v), east (>), or west (<). After each move, he delivers another present to the house at his new location.

However, the elf back at the north pole has had a little too much eggnog, and so his directions are a little off, and Santa ends up visiting some houses more than once. How many houses receive at least one present?

For example:

> delivers presents to 2 houses: one at the starting location, and one to the east.
^>v< delivers presents to 4 houses in a square, including twice to the house at his starting/ending location.
^v^v^v^v^v delivers a bunch of presents to some very lucky children at only 2 houses.

*/


// load data into string
$data = file_get_contents('input/day-3.txt');

// use an array as a counter of visits, using the x/y coordinates as the key and the number of visits as the value
$visits = array();

// initially, santa is at x=0, x=0
$x = 0;
$y = 0;
$visits['0|0'] = 1;

// loop through instructions
for($i = 0; $i < strlen($data); $i++)
{
	
	// set x/y change
	$char = substr($data, $i, 1);
	if($char == '^') $y++;
	elseif($char == 'v') $y--;
	elseif($char == '<') $x--;
	elseif($char == '>') $x++;
	else die('unexpected char');
	
	// add visit to array
	$key = $x.'|'.$y;
	if(!array_key_exists($key, $visits)) $visits[$key] = 1;
	else $visits[$key]++;
	
}

// output answer
echo 'Answer: '.count($visits);
	

?>