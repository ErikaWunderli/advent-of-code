<?php

/*
	
--- Part Two ---

Now that the machine is calibrated, you're ready to begin molecule fabrication.

Molecule fabrication always begins with just a single electron, e, and applying replacements one at a time, just like the ones during calibration.

For example, suppose you have the following replacements:

e => H
e => O
H => HO
H => OH
O => HH

If you'd like to make HOH, you start with e, and then make the following replacements:

e => O to get O
O => HH to get HH
H => OH (on the second H) to get HOH

So, you could make HOH after 3 steps. Santa's favorite molecule, HOHOHO, can be made in 6 steps.

How long will it take to make the medicine? Given the available replacements and the medicine molecule in your puzzle input, what is the fewest number of steps to go from e to the medicine molecule?

*/


// grab the starting molecule (last line of input)
$input = file('input/day-19.txt', FILE_IGNORE_NEW_LINES);
$molecule = $input[count($input)-1];

// grab replacements
preg_match_all('/(\w+) => (\w+)/', file_get_contents('input/day-19.txt'), $m);
$replacements = array();
for($i = 0; $i < count($m[0]); $i++) $replacements[] = array('in' => $m[1][$i], 'out' => $m[2][$i]);

// work backwards, count iterations
$i = 0;
while($molecule != 'e')
{
	foreach($replacements as $r)
	{
		if(($position = strpos($molecule, $r['out'])) !== false)
		{
			$molecule = substr_replace($molecule, $r['in'], $position, strlen($r['out']));
			$i++;
		}
	}
}
    
// output answer
echo 'Answer: '.$i;


?>