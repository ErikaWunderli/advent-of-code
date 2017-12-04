<?php
	
/*
	
--- Part Two ---

Now, take the signal you got on wire a, override wire b to that signal, and reset the other wires (including wire a). What new signal is ultimately provided to wire a?

*/


// array to store wire states
$wires = array();

// loop through instructions
foreach(file('input/day-07.txt', FILE_IGNORE_NEW_LINES) as $instruction)
{
	
	// split instruction
	list($in, $out) = explode(' -> ', $instruction);
	
	// store values
	$wires[$out] = $in;

}

// function to get a signal of a wire
function signal($w)
{
	
	global $wires;
	
	// if solved, return signal
	if(preg_match('/^\d+$/', $wires[$w])) return intval($wires[$w]);
	
	// else if just one input, iterate
	if(preg_match('/^([a-z]+)$/', $wires[$w])) return signal($wires[$w]);
	
	// else split
	preg_match('/(([a-z0-9]+) )?([A-Z]+) ([a-z0-9]+)/', $wires[$w], $split);
	$a = $split[2];
	$op = $split[3];
	$b = $split[4];

	// solve parts
	if($a) { if(!preg_match('/^\d+$/', $a)) $a = signal($a); }
	if(!preg_match('/^\d+$/', $b)) $b = signal($b);
	
	// force ints
	$a = intval($a);
	$b = intval($b);
	
	// perform bitwise operation
	if($op == 'AND') $wires[$w] = $a & $b;
	elseif($op == 'OR') $wires[$w] = $a | $b;
	elseif($op == 'XOR') $wires[$w] = $a ^ $b;
	elseif($op == 'NOT') $wires[$w] = ~ $b;
	elseif($op == 'LSHIFT') $wires[$w] = $a << $b;
	elseif($op == 'RSHIFT') $wires[$w] = $a >> $b;
	else die('unexpected operator');
	
	// return signal
	return $wires[$w];
	
}


// reset b
$wires['b'] = 956;

// output answer
echo 'Answer: '.signal('a');


?>