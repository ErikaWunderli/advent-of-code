<?php
	
/*
	
--- Part Two ---

The next year, just to show off, Santa decides to take the route with the longest distance instead.

He can still start and end at any two (different) locations he wants, and he still must visit each location exactly once.

For example, given the distances above, the longest route would be 982 via (for example) Dublin -> London -> Belfast.

What is the distance of the longest route?

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

// create a lookup array of all distances between points,
// in both directions
$d = array();
foreach(file('input/day-09.txt', FILE_IGNORE_NEW_LINES) as $line)
{
	preg_match('/^(.+) to (.+) = (\d+)$/', $line, $x);
	$d[$x[1]][$x[2]] = $x[3];
	$d[$x[2]][$x[1]] = $x[3];
}

// create array of places
$p = array();
foreach($d as $key => $val) $p[] = $key;

// test each permutation of places, calculate distance
// and store if longest so far
$longestDistance = false;
foreach(pc_permute($p) as $o)
{
	$dist = 0;
	for($i = 1; $i < count($o); $i++)
	{
		$dist += $d[$o[$i-1]][$o[$i]];
	}
	if(!$longestDistance || ($dist > $longestDistance)) $longestDistance = $dist;
}

// output answer
echo 'Answer: '.$longestDistance;


?>