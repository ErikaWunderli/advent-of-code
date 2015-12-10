<?php
	
/*
	
--- Part Two ---

Neat, right? You might also enjoy hearing John Conway talking about this sequence (that's Conway of Conway's Game of Life fame).

Now, starting again with the digits in your puzzle input, apply this process 50 times. What is the length of the new result?

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

// process 50 times
for($i = 0; $i < 50; $i++) $s = lookAndSay($s);

// output answer
echo strlen($s);


?>