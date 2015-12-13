<?php
	
/*
	
--- Part Two ---

In all the commotion, you realize that you forgot to seat yourself. At this point, you're pretty apathetic toward the whole thing, and your happiness wouldn't really go up or down regardless of who you sit next to. You assume everyone else would be just as ambivalent about sitting next to you, too.

So, add yourself to the list, and give all happiness relationships that involve you a score of 0.

What is the total change in happiness for the optimal seating arrangement that actually includes yourself?

*/


// fudge the memory limit
ini_set('memory_limit', '1024M');

// function to generate all permutations of an array
// pinched from stackexchange
function pc_permute($items, $perms = array())
{
    if(empty($items))
    {
        $return = array($perms);
    }
    else
    {
        $return = array();
        for ($i = count($items) - 1; $i >= 0; --$i)
        {
			$newitems = $items;
			$newperms = $perms;
			list($foo) = array_splice($newitems, $i, 1);
			array_unshift($newperms, $foo);
			$return = array_merge($return, pc_permute($newitems, $newperms));
		}
	}
	return $return;
}


// parse the input file into 2 arrays, one just of names and one for relationships
$people = array();
$relationships = array();
foreach(file('input/day-13.txt') as $line)
{
	preg_match('/^(\w+) would (gain|lose) (\d+) .* (\w+)\.$/', $line, $m);
	if($m[2] == 'lose') $m[3] = 0 - intval($m[3]);
	else $m[3] = intval($m[3]);
	$relationships[$m[1]][$m[4]] = $m[3];
	$relationships[$m[1]]['me'] = 0;
	$relationships['me'][$m[1]] = 0;
	if(!in_array($m[1], $people)) $people[] = $m[1];
	if(!in_array('me', $people)) $people[] = 'me';
}

// get all the possible seating plans
$plans = pc_permute($people);

// loop the seating plans and work out optimal happiness
$happiest = -999999;
foreach($plans as $plan)
{
	
	$h = 0;
	
	// loop through each guest and work out their happiness
	for($i = 0; $i < count($plan); $i++)
	{
		$person = $plan[$i];
		$left = (($i-1) >= 0) ? $plan[$i-1] : $plan[count($plan)-1];
		$right = (($i+1) < count($plan)) ? $plan[$i+1] : $plan[0];
		$h += $relationships[$person][$left] + $relationships[$person][$right];
	}
	
	if($h > $happiest) $happiest = $h;
	
}


// output answer
echo 'Answer: '.$happiest;


?>