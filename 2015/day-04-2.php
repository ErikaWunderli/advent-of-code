<?php
	
/*
	
--- Part Two ---

Now find one that starts with six zeroes.

*/


// load key into string
$key = file_get_contents('input/day-04.txt');

// counter
$n = 1;

// loop until answer found
$answer = false;
while($answer == false)
{
	
	// create hash
	$hash = md5($key.$n);
	
	// check for match
	if(substr($hash, 0, 6) === '000000') $answer = $n;
	
	// increment counter
	$n++;
	
}

// output answer
echo 'Answer: '.$answer;


?>