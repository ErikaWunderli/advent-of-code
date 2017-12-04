<?php
	
/*
	
--- Part Two ---

You just finish implementing your winning light pattern when you realize you mistranslated Santa's message from Ancient Nordic Elvish.

The light grid you bought actually has individual brightness controls; each light can have a brightness of zero or more. The lights all start at zero.

The phrase turn on actually means that you should increase the brightness of those lights by 1.

The phrase turn off actually means that you should decrease the brightness of those lights by 1, to a minimum of zero.

The phrase toggle actually means that you should increase the brightness of those lights by 2.

What is the total brightness of all lights combined after following Santa's instructions?

For example:

turn on 0,0 through 0,0 would increase the total brightness by 1.
toggle 0,0 through 999,999 would increase the total brightness by 2000000.

*/


// set memory limit to "loads"
ini_set('memory_limit','256M');

// create an array of "lights", all at zero brightness
$lights = array_fill(0, 1000, array_fill(0, 1000, 0));


// load instructions into array
$data = file('input/day-06.txt');

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
			
			// turn on (increase brightness by 1)
			if($fn == 'on') $lights[$x][$y]++;
			
			// turn off (decrease brightness by 1)
			elseif($fn == 'off') $lights[$x][$y] = max(0, $lights[$x][$y] - 1);
			
			// toggle (increase brightness by 2)
			elseif($fn == 'toggle') $lights[$x][$y] = $lights[$x][$y] + 2;
			
		}
		
	}
	
}

// count brightness of all lights
$brightness = 0;
foreach($lights as $x => $row)
{
	foreach($row as $y => $light)
	{
		$brightness += $light;
	}
}

// output answer
echo 'Answer: '.$brightness;


?>