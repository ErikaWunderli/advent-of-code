<?php
	
/*
	
--- Day 9: All in a Single Night ---

Every year, Santa manages to deliver all of his presents in a single night.

This year, however, he has some new locations to visit; his elves have provided him the distances between every pair of locations. He can start and end at any two (different) locations he wants, but he must visit each location exactly once. What is the shortest distance he can travel to achieve this?

For example, given the following distances:

London to Dublin = 464
London to Belfast = 518
Dublin to Belfast = 141

The possible routes are therefore:

Dublin -> London -> Belfast = 982
London -> Dublin -> Belfast = 605
London -> Belfast -> Dublin = 659
Dublin -> Belfast -> London = 659
Belfast -> Dublin -> London = 605
Belfast -> London -> Dublin = 982

The shortest of these is London -> Dublin -> Belfast = 605, and so the answer is 605 in this example.

What is the distance of the shortest route?

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
foreach(file('input/day-9.txt', FILE_IGNORE_NEW_LINES) as $line)
{
	preg_match('/^(.+) to (.+) = (\d+)$/', $line, $x);
	$d[$x[1]][$x[2]] = $x[3];
	$d[$x[2]][$x[1]] = $x[3];
}

// create array of places
$p = array();
foreach($d as $key => $val) $p[] = $key;

// test each permutation of places, calculate distance
// and store if shortest so far
$shortestDistance = false;
foreach(pc_permute($p) as $o)
{
	$dist = 0;
	for($i = 1; $i < count($o); $i++)
	{
		$dist += $d[$o[$i-1]][$o[$i]];
	}
	if(!$shortestDistance || ($dist < $shortestDistance)) $shortestDistance = $dist;
}

// output answer
echo 'Answer: '.$shortestDistance;


?>