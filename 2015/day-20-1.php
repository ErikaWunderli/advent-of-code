<?php

/*
	
--- Day 20: Infinite Elves and Infinite Houses ---

To keep the Elves busy, Santa has them deliver some presents by hand, door-to-door. He sends them down a street with infinite houses numbered sequentially: 1, 2, 3, 4, 5, and so on.

Each Elf is assigned a number, too, and delivers presents to houses based on that number:

The first Elf (number 1) delivers presents to every house: 1, 2, 3, 4, 5, ....
The second Elf (number 2) delivers presents to every second house: 2, 4, 6, 8, 10, ....
Elf number 3 delivers presents to every third house: 3, 6, 9, 12, 15, ....

There are infinitely many Elves, numbered starting with 1. Each Elf delivers presents equal to ten times his or her number at each house.

So, the first nine houses on the street end up like this:

House 1 got 10 presents.
House 2 got 30 presents.
House 3 got 40 presents.
House 4 got 70 presents.
House 5 got 60 presents.
House 6 got 120 presents.
House 7 got 80 presents.
House 8 got 150 presents.
House 9 got 130 presents.

The first house gets 10 presents: it is visited only by Elf 1, which delivers 1 * 10 = 10 presents. The fourth house gets 70 presents, because it is visited by Elves 1, 2, and 4, for a total of 10 + 20 + 40 = 70 presents.

What is the lowest house number of the house to get at least as many presents as the number in your puzzle input?

*/


// this may take a while...
set_time_limit(0);

// get target number
$target = intval(file_get_contents('input/day-20.txt'));


// loop through house numbers until one gets enough presents
// in theory this works, but it's so slow it's no good
/*
$house = 0;
while(!isset($target_met))
{
	$house++;
	$presents = 0;
	// loop elves
	for($e = 1; $e <= $house; $e++)
	{
		if(($house % $e) == 0) $presents += $e*10;
	}
	if($presents >= $target) $target_met = true; 
}
*/


// function to get divisors of an integer
// still slow, but fast enough to crack the answer
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
while(!isset($target_met))
{
	$house++;
	$presents = array_sum(get_divisors($house)) * 10;	
	if($presents >= $target) $target_met = true;
}

// output answer
echo "Answer: ".$house;


?>