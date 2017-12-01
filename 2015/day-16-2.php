<?php
	
/*

--- Part Two ---

As you're about to send the thank you note, something in the MFCSAM's instructions catches your eye. Apparently, it has an outdated retroencabulator, and so the output from the machine isn't exact values - some of them indicate ranges.

In particular, the cats and trees readings indicates that there are greater than that many (due to the unpredictable nuclear decay of cat dander and tree pollen), while the pomeranians and goldfish readings indicate that there are fewer than that many (due to the modial interaction of magnetoreluctance).

What is the number of the real Aunt Sue?

*/


// parse the input file into an array of aunts
$sues = array();
$n = 1;
foreach(file('input/day-16.txt') as $line)
{
	preg_match_all('/(\w+): (\d+)/', $line, $m);
	for($i = 0; $i < 3; $i++) $sues[$n][$m[1][$i]] = intval($m[2][$i]);
	$n++;
}

// array of the MFCSAM analysis
$analysis = array(
	'children' => 3,
	'cats' => 7,
	'samoyeds' => 2,
	'pomeranians' => 3,
	'akitas' => 0,
	'vizslas' => 0,
	'goldfish' => 5,
	'trees' => 3,
	'cars' => 2,
	'perfumes' =>1
);

// loop through analysis elements and exclude non-matches
foreach($analysis as $el => $num)
{
	// check all sues
	foreach($sues as $n => $sue)
	{
		// if this attribute exists
		if(array_key_exists($el, $sue))
		{
			
			// check for match
			$match = false;
			if(($el == 'cats') || ($el == 'trees'))
			{
				if($sue[$el] > $num) $match = true;
			}
			elseif(($el == 'pomeranians') || ($el == 'goldfish'))
			{
				if($sue[$el] < $num) $match = true;
			}
			else
			{
				if($sue[$el] == $num) $match = true;
			}
			
			// eliminate the sue!
			if(!$match) unset($sues[$n]);
			
		}
	}
}

// check there's one sue left
if(count($sues) != 1) die('Expected one Sue left!');

// output answer
echo 'Answer: '.array_keys($sues)[0];


?>