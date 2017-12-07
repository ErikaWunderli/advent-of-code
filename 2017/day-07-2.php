<?php
	
	
/*

--- Part Two ---

The programs explain the situation: they can't get down. Rather, they could get down, if they weren't expending all of their energy trying to keep the tower balanced. Apparently, one program has the wrong weight, and until it's fixed, they're stuck here.

For any program holding a disc, each program standing on that disc forms a sub-tower. Each of those sub-towers are supposed to be the same weight, or the disc itself isn't balanced. The weight of a tower is the sum of the weights of the programs in that tower.

In the example above, this means that for ugml's disc to be balanced, gyxo, ebii, and jptl must all have the same weight, and they do: 61.

However, for tknk to be balanced, each of the programs standing on its disc and all programs above it must each match. This means that the following sums must all be the same:

    ugml + (gyxo + ebii + jptl) = 68 + (61 + 61 + 61) = 251
    padx + (pbga + havc + qoyq) = 45 + (66 + 66 + 66) = 243
    fwft + (ktlj + cntj + xhth) = 72 + (57 + 57 + 57) = 243

As you can see, tknk's disc is unbalanced: ugml's stack is heavier than the other two. Even though the nodes above ugml are balanced, ugml itself is too heavy: it needs to be 8 units lighter for its stack to weigh 243 and keep the towers balanced. If this change were made, its weight would be 60.

Given that exactly one program is the wrong weight, what would its weight need to be to balance the entire tower?

*/


/* Never ever code like this. It's horrible. */


// load data
$input = file('input/day-07.txt');
$programs = array();
$allChildren = array();
foreach($input as $p)
{
	preg_match('/^(\w+)\s{1}\((\d+)\)(\s{1}->\s{1}(.+)?)?$/', trim($p), $parts);
	$children = (isset($parts[4])) ? explode(', ', $parts[4]) : array();
	foreach($children as $child) $allChildren[] = $child;
	$programs[$parts[1]] = array('weight' => intval($parts[2]), 'children' => $children);
}

foreach($programs as $name => $p)
{
	if(!in_array($name, $allChildren))
	{
		$rootNode = $name;
		break;
	}
}

function getWeight($node, &$programs)
{
	$childNodes = $programs[$node]['children'];
	$weight = $programs[$node]['weight'];
	foreach($childNodes as $child) $weight += getWeight($child, $programs);
	return $weight;
}

function findImbalance($node, $parentNode, &$programs)
{
	$childNodes = $programs[$node]['children'];
	$weights = array();
	$sorter = array();
	echo $node." -> ";
	for($i = 0; $i < count($childNodes); $i++)
	{
		$weights[$i] = getWeight($childNodes[$i], $programs);
		if(!isset($sorter[$weights[$i]])) $sorter[$weights[$i]] = 1;
		else $sorter[$weights[$i]]++;
		if($i > 0) echo ", ";
		echo $childNodes[$i]." (".$weights[$i].")";
	}
	echo "<br>";
	asort($sorter);
	if(count($sorter) == 1)
	{
		reBalance($node, $parentNode, $programs);
	}
	else {
		$unBalancedNodeKey = array_search(array_keys($sorter)[0], $weights);
		$unBalancedNode = $childNodes[$unBalancedNodeKey];
		return findImbalance($unBalancedNode, $node, $programs);
	}	
}

function reBalance($node, $parentNode, &$programs)
{
	$siblingNodes = $programs[$parentNode]['children'];
	$weights = array();
	for($i = 0; $i < count($siblingNodes); $i++)
	{
		$weights[$i] = getWeight($siblingNodes[$i], $programs);
	}
	$key = array_search($node, $siblingNodes);
	$anotherKey = ($key !== 0) ? 0 : 1;
	$diff = $weights[$anotherKey] - $weights[$key];
	echo 'Node '.$node.'\'s weight is off by '.$diff.', it should be '.($programs[$node]['weight'] + $diff);
	
}


findImbalance($rootNode, null, $programs);




?>