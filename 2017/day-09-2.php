<?php
	
	
/*

--- Part Two ---

Now, you're ready to remove the garbage.

To prove you've removed it, you need to count all of the characters within the garbage. The leading and trailing < and > don't count, nor do any canceled characters or the ! doing the canceling.

    <>, 0 characters.
    <random characters>, 17 characters.
    <<<<>, 3 characters.
    <{!>}>, 2 characters.
    <!!>, 0 characters.
    <!!!>>, 0 characters.
    <{o"i!a,<{i<a>, 10 characters.

How many non-canceled characters are within the garbage in your puzzle input?

*/


// load data
$input = file_get_contents('input/day-09.txt');

$groupDepth = 0;
$inGarbage = false;
$score = 0;
$garbageCount = 0;

for($i = 0; $i < strlen($input); $i++)
{
	
	$c = $input[$i];
	switch($c) {
		case '!':
			$i++;
			break;
		case '{':
			if(!$inGarbage)
			{
				$groupDepth++;
				$score += $groupDepth;
			}
			break;
		case '}':
			if(!$inGarbage)
			{
				$groupDepth--;
			}
			break;
		case '<':
			if(!$inGarbage)
			{
				$inGarbage = true;
				$garbageCount--;
			}
			break;
		case '>':
			if($inGarbage)
			{
				$inGarbage = false;
			}
			break;		
	}
	if($inGarbage && ($c != '!')) $garbageCount++;
}

echo "Garbage Count: ".$garbageCount;



?>