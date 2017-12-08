<?php
	
	
/*

--- Part Two ---

To be safe, the CPU also needs to know the highest value held in any register during this process so that it can decide how much memory to allocate to these operations. For example, in the above instructions, the highest value ever held was 10 (in register c after the third instruction was evaluated).

*/


// load data
$input = file('input/day-08.txt');
$instructions = array();

// prepare instructions list
for($i = 0; $i < count($input); $i++)
{
	if(!preg_match('/^(\w+)\s{1}(inc|dec)\s{1}(\-?\d+)\s{1}if\s{1}(\w+)\s{1}(.{1,2})\s{1}(\-?\d+)$/', trim($input[$i]), $parts)) die('regex error on line '.($i+1));
	$instructions[] = array(
		'register' => $parts[1],
		'change' => ($parts[2] == 'inc') ? intval($parts[3]) : intval(0-$parts[3]),
		'condRegister' => $parts[4],
		'condOperator' => $parts[5],
		'condValue' => intval($parts[6])
	);
}

// process instructions
$registers = array();
$highestVal = 0;
foreach($instructions as $i)
{
	if(!isset($registers[$i['register']])) $registers[$i['register']] = 0;
	if(!isset($registers[$i['condRegister']])) $registers[$i['condRegister']] = 0;
	eval('$c = ('.$registers[$i['condRegister']].' '.$i['condOperator'].' '.$i['condValue'].');');
	if($c) $registers[$i['register']] += $i['change'];
	if($registers[$i['register']] > $highestVal) $highestVal = $registers[$i['register']];	
}

// output highest value
echo "Highest value: ".$highestVal;


?>