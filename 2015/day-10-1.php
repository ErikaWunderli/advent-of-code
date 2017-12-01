<?php
	
/*
	
--- Day 10: Elves Look, Elves Say ---

Today, the Elves are playing a game called look-and-say. They take turns making sequences by reading aloud the previous sequence and using that reading as the next sequence. For example, 211 is read as "one two, two ones", which becomes 1221 (1 2, 2 1s).

Look-and-say sequences are generated iteratively, using the previous value as input for the next step. For each step, take the previous value, and replace each run of digits (like 111) with the number of digits (3) followed by the digit itself (1).

For example:

1 becomes 11 (1 copy of digit 1).
11 becomes 21 (2 copies of digit 1).
21 becomes 1211 (one 2 followed by one 1).
1211 becomes 111221 (one 1, one 2, and two 1s).
111221 becomes 312211 (three 1s, two 2s, and one 1).

Starting with the digits in your puzzle input, apply this process 40 times. What is the length of the result?

*/


// function to get next sequence
function lookAndSay($s)
{
	
	// output string
	$out = '';
	
	// loop through characters
	$p = 0;
	while($p < strlen($s))
	{
		
		$c = substr($s, $p, 1);
		
		// count continuous occurrences of character
		$n = 1;
		while(substr($s, $p+$n, 1) == $c) $n++;
		
		// add to output
		$out .= $n.$c;
		
		// set next position
		$p += $n;
		
	}
	
	// return result
	return $out;
	
}


// get input
$s = file_get_contents('input/day-10.txt');

// process 40 times
for($i = 0; $i < 40; $i++) $s = lookAndSay($s);

// output answer
echo strlen($s);


?>