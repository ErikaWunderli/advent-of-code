<?php
	
/*
	
--- Part Two ---

Uh oh - the Accounting-Elves have realized that they double-counted everything red.

Ignore any object (and all of its children) which has any property with the value "red". Do this only for objects ({...}), not arrays ([...]).

[1,2,3] still has a sum of 6.
[1,{"c":"red","b":2},3] now has a sum of 4, because the middle object is ignored.
{"d":"red","e":[1,2,3,4],"f":5} now has a sum of 0, because the entire structure is ignored.
[1,"red",5] has a sum of 6, because "red" in an array has no effect.

*/


// well that escalated. going to have to do it properly this time.
$json = json_decode(file_get_contents('input/day-12.json'));

// iterative fn to total the value in an element
function totalOf($item)
{
	
	$total = 0;
	
	// loop
	foreach($item as $subitem)
	{
		
		// if this is an object, check for "red" and iterate if not found
		if(is_object($subitem))
		{
			$redFound = false;
			foreach($subitem as $subsubitem) if($subsubitem === 'red') $redFound = true;
			if(!$redFound) $total += totalOf($subitem);
		}
		
		// if this is an array, iterate
		elseif(is_array($subitem)) $total += totalOf($subitem);
		
		// if this is an integer, add to total
		elseif(is_int($subitem)) $total += $subitem;
	}
	
	return $total;
	
}

// output answer
echo 'Answer: '.totalOf($json);


?>