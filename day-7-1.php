<?php
	
/*
	
--- Day 7: Some Assembly Required ---

This year, Santa brought little Bobby Tables a set of wires and bitwise logic gates! Unfortunately, little Bobby is a little under the recommended age range, and he needs help assembling the circuit.

Each wire has an identifier (some lowercase letters) and can carry a 16-bit signal (a number from 0 to 65535). A signal is provided to each wire by a gate, another wire, or some specific value. Each wire can only get a signal from one source, but can provide its signal to multiple destinations. A gate provides no signal until all of its inputs have a signal.

The included instructions booklet describe how to connect the parts together: x AND y -> z means to connect wires x and y to an AND gate, and then connect its output to wire z.

For example:

123 -> x means that the signal 123 is provided to wire x.
x AND y -> z means that the bitwise AND of wire x and wire y is provided to wire z.
p LSHIFT 2 -> q means that the value from wire p is left-shifted by 2 and then provided to wire q.
NOT e -> f means that the bitwise complement of the value from wire e is provided to wire f.
Other possible gates include OR (bitwise OR) and RSHIFT (right-shift). If, for some reason, you'd like to emulate the circuit instead, almost all programming languages (for example, C, JavaScript, or Python) provide operators for these gates.

For example, here is a simple circuit:

123 -> x
456 -> y
x AND y -> d
x OR y -> e
x LSHIFT 2 -> f
y RSHIFT 2 -> g
NOT x -> h
NOT y -> i
After it is run, these are the signals on the wires:

d: 72
e: 507
f: 492
g: 114
h: 65412
i: 65079
x: 123
y: 456

In little Bobby's kit's instructions booklet (provided as your puzzle input), what signal is ultimately provided to wire a?

*/


// array to store wire states
$wires = array();

// loop through instructions
foreach(file('input/day-7.txt', FILE_IGNORE_NEW_LINES) as $instruction)
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


// output answer
echo 'Answer: '.signal('a');


?>