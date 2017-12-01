<?php
	
/*
	
--- Day 6: Probably a Fire Hazard ---

Because your neighbors keep defeating you in the holiday house decorating contest year after year, you've decided to deploy one million lights in a 1000x1000 grid.

Furthermore, because you've been especially nice this year, Santa has mailed you instructions on how to display the ideal lighting configuration.

Lights in your grid are numbered from 0 to 999 in each direction; the lights at each corner are at 0,0, 0,999, 999,999, and 999,0. The instructions include whether to turn on, turn off, or toggle various inclusive ranges given as coordinate pairs. Each coordinate pair represents opposite corners of a rectangle, inclusive; a coordinate pair like 0,0 through 2,2 therefore refers to 9 lights in a 3x3 square. The lights all start turned off.

To defeat your neighbors this year, all you have to do is set up your lights by doing the instructions Santa sent you in order.

For example:

turn on 0,0 through 999,999 would turn on (or leave on) every light.
toggle 0,0 through 999,0 would toggle the first line of 1000 lights, turning off the ones that were on, and turning on the ones that were off.
turn off 499,499 through 500,500 would turn off (or leave off) the middle four lights.

After following the instructions, how many lights are lit?

*/

// set memory limit to "loads"
ini_set('memory_limit','256M');

// create an array of "lights", all off (=false)
$lights = array_fill(0, 1000, array_fill(0, 1000, false));


// load instructions into array
$data = file('input/day-6.txt');

// loop through instructions
foreach($data as $key => $instruction)
{
	
	// pull out instructions
	if(!preg_match('/(on|off|toggle) (\d+),(\d+) through (\d+),(\d+)/', $instruction, $i)) die('unexpected input');
	$fn = $i[1];
	$x1 = intval($i[2]);
	$y1 = intval($i[3]);
	$x2 = intval($i[4]);
	$y2 = intval($i[5]);
	
	// loop through x coords
	for($x = min($x1,$x2); $x <= max($x1,$x2); $x++)
	{
		
		// loop through y coords
		for($y = min($y1,$y2); $y <= max($y1,$y2); $y++)
		{
			
			// turn on
			if($fn == 'on') $lights[$x][$y] = true;
			
			// turn off
			elseif($fn == 'off') $lights[$x][$y] = false;
			
			// toggle
			elseif($fn == 'toggle') $lights[$x][$y] = !$lights[$x][$y];
			
		}
		
	}
	
}

// count lights that are on
$on = 0;
foreach($lights as $x => $row)
{
	foreach($row as $y => $status)
	{
		if($status) $on++;
	}
}

// output answer
echo 'Answer: '.$on;


?>