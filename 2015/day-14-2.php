<?php
	
/*
	
--- Part Two ---

Seeing how reindeer move in bursts, Santa decides he's not pleased with the old scoring system.

Instead, at the end of each second, he awards one point to the reindeer currently in the lead. (If there are multiple reindeer tied for the lead, they each get one point.) He keeps the traditional 2503 second time limit, of course, as doing otherwise would be entirely ridiculous.

Given the example reindeer from above, after the first second, Dancer is in the lead and gets one point. He stays in the lead until several seconds into Comet's second burst: after the 140th second, Comet pulls into the lead and gets his first point. Of course, since Dancer had been in the lead for the 139 seconds before that, he has accumulated 139 points by the 140th second.

After the 1000th second, Dancer has accumulated 689 points, while poor Comet, our old champion, only has 312. So, with the new scoring system, Dancer would win (if the race ended at 1000 seconds).

Again given the descriptions of each reindeer (in your puzzle input), after exactly 2503 seconds, how many points does the winning reindeer have?

*/


// parse the input file into an array
$deer = array();
foreach(file('input/day-14.txt') as $line)
{
	preg_match('/^(\w+) can fly (\d+) km\/s for (\d+) seconds, but then must rest for (\d+) seconds\.$/', $line, $m);
	$deer[$m[1]] = array('speed' => intval($m[2]), 'duration' => intval($m[3]), 'rest' => intval($m[4]), 'score' => 0);
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

// work out who is in front each second
for($i = 1; $i <= 2503; $i++)
{
	
	// loop reindeer and work out how far each has travelled
	foreach($deer as $name => $d) $deer[$name]['distance'] = distanceAfter($d, $i);
	
	// award a point to whoever is in the lead
	$furthest = 0;
	foreach($deer as $name => $d)
	{
		if($d['distance'] > $furthest)
		{
			$furthest = $d['distance'];
			$fastBastards = array($name);
		}
		// in case of a draw
		elseif($d['distance'] == $furthest) $fastBastards[] = $name;
	}
	
	// add point(s)
	foreach($fastBastards as $jimmySpeedyPants) $deer[$jimmySpeedyPants]['score']++;

}

// find the winner
$score = 0;
foreach($deer as $d) if($d['score'] > $score) $score = $d['score'];

// output answer
echo 'Answer: '.$score;


?>