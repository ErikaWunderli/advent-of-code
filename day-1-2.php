<?php
	
	
/*

--- Part Two ---

Now, given the same instructions, find the position of the first character that causes him to enter the basement (floor -1). The first character in the instructions has position 1, the second character has position 2, and so on.

For example:

) causes him to enter the basement at character position 1.
()()) causes him to enter the basement at character position 5.

What is the position of the character that causes Santa to first enter the basement?

*/


// load data into string
$data = file_get_contents('input/day-1.txt');

// initially, floor is 0
$floor = 0;

// loop through data chars
for($i = 0; $i < strlen($data); $i++)
{

	// increment/decrement floor	
	$char = substr($data, $i, 1);
	if($char == '(') $floor++;
	elseif($char == ')') $floor--;
	else die('unexpected char!');
	
	// if floor is < 0, output this position as the answer
	if($floor < 0)
	{
		echo "Answer: ".($i+1);
		break;
	}
	
}

	
?>