<?php
	
	
/*

--- Part Two ---

There are more programs than just the ones in the group containing program ID 0. The rest of them have no way of reaching that group, and still might have no way of reaching each other.

A group is a collection of programs that can all communicate via pipes either directly or indirectly. The programs you identified just a moment ago are all part of the same group. Now, they would like you to determine the total number of groups.

In the example above, there were 2 groups: one consisting of programs 0,2,3,4,5,6, and the other consisting solely of program 1.

How many groups are there in total?

*/


$lines = file('input/day-12.txt');
$nodes = array();
foreach($lines as $line)
{	
	preg_match('/^(\d+)\s{1}<->\s{1}(.+)$/', $line, $matches);
	if(count($matches) == 3)
	{
		$node = intval($matches[1]);
		$connections = explode(', ', $matches[2]);
		for($i = 0; $i < count($connections); $i++) $connections[$i] = intval($connections[$i]);
		$nodes[$node] = $connections;
	}	
}


function checkConnection($startNode, $endNode, $nodes, &$nodesChecked)
{
	$nodesChecked[] = $startNode;
	if(in_array($endNode, $nodes[$startNode])) return true;
	elseif($startNode == $endNode) return true;
	else
	{
		foreach($nodes[$startNode] as $n)
		{
			if(!in_array($n, $nodesChecked))
			{
				if(checkConnection($n, $endNode, $nodes, $nodesChecked) == true) return true;
			}
		}
	}	
}


$nodePool = array();
foreach($nodes as $key => $val) $nodePool[] = $key;
$groups = array();
while(count($nodePool) > 0)
{
	$source = $nodePool[0];
	$group = array();
	foreach($nodePool as $n)
	{
		$nodesChecked = array();
		if(checkConnection($n, $source, $nodes, $nodesChecked)) $group[] = $n;
	}
	$groups[] = $group;
	$swap = array();
	foreach($nodePool as $n)
	{
		if(!in_array($n, $group)) $swap[] = $n;
	}
	$nodePool = $swap;
}

echo "Groups: ".count($groups);


?>