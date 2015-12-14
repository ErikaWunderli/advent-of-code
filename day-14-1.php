<?php
	
/*
	
--- Day 14: Reindeer Olympics ---

This year is the Reindeer Olympics! Reindeer can fly at high speeds, but must rest occasionally to recover their energy. Santa would like to know which of his reindeer is fastest, and so he has them race.

Reindeer can only either be flying (always at their top speed) or resting (not moving at all), and always spend whole seconds in either state.

For example, suppose you have the following Reindeer:

Comet can fly 14 km/s for 10 seconds, but then must rest for 127 seconds.
Dancer can fly 16 km/s for 11 seconds, but then must rest for 162 seconds.

After one second, Comet has gone 14 km, while Dancer has gone 16 km. After ten seconds, Comet has gone 140 km, while Dancer has gone 160 km. On the eleventh second, Comet begins resting (staying at 140 km), and Dancer continues on for a total distance of 176 km. On the 12th second, both reindeer are resting. They continue to rest until the 138th second, when Comet flies for another ten seconds. On the 174th second, Dancer flies for another 11 seconds.

In this example, after the 1000th second, both reindeer are resting, and Comet is in the lead at 1120 km (poor Dancer has only gotten 1056 km by that point). So, in this situation, Comet would win (if the race ended at 1000 seconds).

Given the descriptions of each reindeer (in your puzzle input), after exactly 2503 seconds, what distance has the winning reindeer traveled?

*/


// parse the input file into an array
$deer = array();
foreach(file('input/day-14.txt') as $line)
{
	preg_match('/^(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds\.$/', $line, $m);
	$deer[$m[1]] = array('speed' => $m[2], 'duration' => $m[3], 'rest' => $m[4]);
}

// function to work out the km travelled of a reindeer after n seconds
function distanceAfter($d, $s)
{
	
	// work out length of go/rest cycle
	$cycle = $d['duration'] + $d['rest'];
	
	// distance - full cycles
	$distance = floor($s / $cycle) * $d['speed'] * $d['duration'];
	
	// distance - remaining part cycle
	$distance += min(($s % $cycle), $d['duration']) * $d['speed'];
	
	return intval($distance);
	
}

// loop reindeer and work out how far each has travelled
foreach($deer as $name => $d) $deer[$name]['distance'] = distanceAfter($d, 2503);

// find the winner
$furthest = 0;
foreach($deer as $d) if($d['distance'] > $furthest) $furthest = $d['distance'];

// output answer
echo 'Answer: '.$furthest;


?>