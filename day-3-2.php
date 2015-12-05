<?php

/*

--- Part Two ---

The next year, to speed up the process, Santa creates a robot version of himself, Robo-Santa, to deliver presents with him.

Santa and Robo-Santa start at the same location (delivering two presents to the same starting house), then take turns moving based on instructions from the elf, who is eggnoggedly reading from the same script as the previous year.

This year, how many houses receive at least one present?

For example:

^v delivers presents to 3 houses, because Santa goes north, and then Robo-Santa goes south.
^>v< now delivers presents to 3 houses, and Santa and Robo-Santa end up back where they started.
^v^v^v^v^v now delivers presents to 11 houses, with Santa going one direction and Robo-Santa going the other.
	
*/


// load data into string
$data = file_get_contents('input/day-3.txt');

// use an array as a counter of visits, using the x/y coordinates as the key and the number of visits as the value
$visits = array();

// initially, both santa and robot are at x=0, x=0
$santa_x = 0;
$santa_y = 0;
$robot_x = 0;
$robot_y = 0;
$visits['0|0'] = 2;

// loop through instructions
for($i = 0; $i < strlen($data); $i++)
{
	
	// if position in data is even move santa
	if(($i % 2) == 0)
	{
		$x = 'santa_x';
		$y = 'santa_y';
	}
	
	// otherwise move the robot
	else
	{
		$x = 'robot_x';
		$y = 'robot_y';
	}
	
	// set x/y change
	$char = substr($data, $i, 1);
	if($char == '^') $$y++;
	elseif($char == 'v') $$y--;
	elseif($char == '<') $$x--;
	elseif($char == '>') $$x++;
	else die('unexpected char');
	
	// add visit to array
	$key = $$x.'|'.$$y;
	if(!array_key_exists($key, $visits)) $visits[$key] = 1;
	else $visits[$key]++;
	
}

// output answer
echo 'Answer: '.count($visits);
	

?>