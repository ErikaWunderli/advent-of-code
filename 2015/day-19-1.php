<?php

/*
	
--- Day 19: Medicine for Rudolph ---

Rudolph the Red-Nosed Reindeer is sick! His nose isn't shining very brightly, and he needs medicine.

Red-Nosed Reindeer biology isn't similar to regular reindeer biology; Rudolph is going to need custom-made medicine. Unfortunately, Red-Nosed Reindeer chemistry isn't similar to regular reindeer chemistry, either.

The North Pole is equipped with a Red-Nosed Reindeer nuclear fusion/fission plant, capable of constructing any Red-Nosed Reindeer molecule you need. It works by starting with some input molecule and then doing a series of replacements, one per step, until it has the right molecule.

However, the machine has to be calibrated before it can be used. Calibration involves determining the number of molecules that can be generated in one step from a given starting point.

For example, imagine a simpler machine that supports only the following replacements:

H => HO
H => OH
O => HH

Given the replacements above and starting with HOH, the following molecules could be generated:

HOOH (via H => HO on the first H).
HOHO (via H => HO on the second H).
OHOH (via H => OH on the first H).
HOOH (via H => OH on the second H).
HHHH (via O => HH).

So, in the example above, there are 4 distinct molecules (not five, because HOOH appears twice) after one replacement from HOH. Santa's favorite molecule, HOHOHO, can become 7 distinct molecules (over nine replacements: six from H, and three from O).

The machine replaces without regard for the surrounding characters. For example, given the string H2O, the transition H => OO would result in OO2O.

Your puzzle input describes all of the possible replacements and, at the bottom, the medicine molecule for which you need to calibrate the machine. How many distinct molecules can be created after all the different ways you can do one replacement on the medicine molecule?

*/


// grab the starting molecule (last line of input)
$input = file('input/day-19.txt', FILE_IGNORE_NEW_LINES);
$molecule = $input[count($input)-1];

// grab replacements
preg_match_all('/(\w+) => (\w+)/', file_get_contents('input/day-19.txt'), $m);
$replacements = array();
for($i = 0; $i < count($m[0]); $i++) $replacements[] = array('in' => $m[1][$i], 'out' => $m[2][$i]);

// try all possible replacements,
// store all unique results
$new = array();
foreach($replacements as $r)
{
	$position = 0;
	$offset = 0;
	while(($position = strpos(substr($molecule, $position), $r['in'])) != false) {
		
		$offset += $position;
		$position = $offset + 1;
		$new_molecule = substr_replace($molecule, $r['out'], $offset, strlen($r['in']));
		if(!in_array($new_molecule, $new)) $new[] = $new_molecule;
		$offset = $position;
	}
	
}


// output answer
echo 'Answer: '.count($new);


?>