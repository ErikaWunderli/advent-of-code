<?php
	
	
/*

--- Part Two ---

Now, the jumps are even stranger: after each jump, if the offset was three or more, instead decrease it by 1. Otherwise, increase it by 1 as before.

Using this rule with the above example, the process now takes 10 steps, and the offset values after finding the exit are left as 2 3 2 3 -1.

How many steps does it now take to reach the exit?

*/


// load data
$instructions = file('input/day-05.txt');

$key = 0;
$jumps = 0;

// jump!
while(array_key_exists($key, $instructions))
{
	$jumps++;
	$instructions[$key] = intval($instructions[$key]);
	$jump = $instructions[$key];
	if($jump >= 3) $instructions[$key]--;
	else $instructions[$key]++;
	$key += $jump;
}

echo "Answer: ".$jumps;	

?>