<?php
	
	
/*

--- Day 8: I Heard You Like Registers ---

You receive a signal directly from the CPU. Because of your recent assistance with jump instructions, it would like you to compute the result of a series of unusual register instructions.

Each instruction consists of several parts: the register to modify, whether to increase or decrease that register's value, the amount by which to increase or decrease it, and a condition. If the condition fails, skip the instruction without modifying the register. The registers all start at 0. The instructions look like this:

b inc 5 if a > 1
a inc 1 if b < 5
c dec -10 if a >= 1
c inc -20 if c == 10

These instructions would be processed as follows:

    Because a starts at 0, it is not greater than 1, and so b is not modified.
    a is increased by 1 (to 1) because b is less than 5 (it is 0).
    c is decreased by -10 (to 10) because a is now greater than or equal to 1 (it is 1).
    c is increased by -20 (to -10) because c is equal to 10.

After this process, the largest value in any register is 1.

You might also encounter <= (less than or equal to) or != (not equal to). However, the CPU doesn't have the bandwidth to tell you what all the registers are named, and leaves that to you to determine.

What is the largest value in any register after completing the instructions in your puzzle input?

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
foreach($instructions as $i)
{
	if(!isset($registers[$i['register']])) $registers[$i['register']] = 0;
	if(!isset($registers[$i['condRegister']])) $registers[$i['condRegister']] = 0;
	eval('$c = ('.$registers[$i['condRegister']].' '.$i['condOperator'].' '.$i['condValue'].');');
	if($c) $registers[$i['register']] += $i['change'];	
}

// find largest value
echo "Max value: ".max($registers);


?>