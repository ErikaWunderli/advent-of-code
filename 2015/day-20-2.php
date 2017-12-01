<?php

/*
	
--- Part Two ---

The Elves decide they don't want to visit an infinite number of houses. Instead, each Elf will stop after delivering presents to 50 houses. To make up for it, they decide to deliver presents equal to eleven times their number at each house.

With these changes, what is the new lowest house number of the house to get at least as many presents as the number in your puzzle input?

*/


// this may take a while...
set_time_limit(0);

// get target number
$target = intval(file_get_contents('input/day-20.txt'));

// function to get divisors of an integer
function get_divisors($n)
{
	$divsors = array();
	$sqrt_n = sqrt($n);
	for($i = 1; $i <= $sqrt_n; $i++)
	{
		if(($n % $i) == 0) 
		{
			$divisors[] = $i;
			$divisors[] = $n / $i;
		}
	}
	return array_unique($divisors);
}

// loop houses until > target
$house = 0;
$elves = array();
while(!isset($target_met))
{
	$house++;
	$e = get_divisors($house);
	foreach($e as $key => $elf)
	{
		if(!isset($elves[$elf])) $elves[$elf] = 1;
		else $elves[$elf]++;
		if($elves[$elf] > 50) unset($e[$key]);
	}
	$presents = array_sum($e) * 11;	
	if($presents >= $target) $target_met = true;
}

// output answer
echo "Answer: ".$house;


?>