<?php
	
	
/*

--- Part Two ---

How many steps away is the furthest he ever got from his starting position?

*/


// load path
$path = explode(',', trim(file_get_contents('input/day-11.txt')));

$x = 0;
$y = 0;
$z = 0;
$furthest = 0;

foreach($path as $step)
{
	switch($step) {
		case 'n':
			$y++;
			$z--;
			break;
		case 'ne':
			$x++;
			$z--;
			break;
		case 'se':
			$x++;
			$y--;
			break;
		case 's':
			$y--;
			$z++;
			break;
		case 'sw':
			$x--;
			$z++;
			break;
		case 'nw':
			$x--;
			$y++;
			break;
	}
	$distance = max(abs($x), abs($y), abs($z));
	if($distance > $furthest) $furthest = $distance;
}

echo "Furthest distance: ".$furthest;

?>