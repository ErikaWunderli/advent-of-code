<?php
	
/*
	
--- Day 13: Knights of the Dinner Table ---

In years past, the holiday feast with your family hasn't gone so well. Not everyone gets along! This year, you resolve, will be different. You're going to find the optimal seating arrangement and avoid all those awkward conversations.

You start by writing up a list of everyone invited and the amount their happiness would increase or decrease if they were to find themselves sitting next to each other person. You have a circular table that will be just big enough to fit everyone comfortably, and so each person will have exactly two neighbors.

For example, suppose you have only four attendees planned, and you calculate their potential happiness as follows:

Alice would gain 54 happiness units by sitting next to Bob.
Alice would lose 79 happiness units by sitting next to Carol.
Alice would lose 2 happiness units by sitting next to David.
Bob would gain 83 happiness units by sitting next to Alice.
Bob would lose 7 happiness units by sitting next to Carol.
Bob would lose 63 happiness units by sitting next to David.
Carol would lose 62 happiness units by sitting next to Alice.
Carol would gain 60 happiness units by sitting next to Bob.
Carol would gain 55 happiness units by sitting next to David.
David would gain 46 happiness units by sitting next to Alice.
David would lose 7 happiness units by sitting next to Bob.
David would gain 41 happiness units by sitting next to Carol.

Then, if you seat Alice next to David, Alice would lose 2 happiness units (because David talks so much), but David would gain 46 happiness units (because Alice is such a good listener), for a total change of 44.

If you continue around the table, you could then seat Bob next to Alice (Bob gains 83, Alice gains 54). Finally, seat Carol, who sits next to Bob (Carol gains 60, Bob loses 7) and David (Carol gains 55, David gains 41). The arrangement looks like this:

     +41 +46
+55   David    -2
Carol       Alice
+60    Bob    +54
     -7  +83
     
After trying every other seating arrangement in this hypothetical scenario, you find that this one is the most optimal, with a total change in happiness of 330.

What is the total change in happiness for the optimal seating arrangement of the actual guest list?

*/


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
	if(!in_array($m[1], $people)) $people[] = $m[1];
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