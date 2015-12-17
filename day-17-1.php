<?php
	
/*

--- Day 17: No Such Thing as Too Much ---

The elves bought too much eggnog again - 150 liters this time. To fit it all into your refrigerator, you'll need to move it into smaller containers. You take an inventory of the capacities of the available containers.

For example, suppose you have containers of size 20, 15, 10, 5, and 5 liters. If you need to store 25 liters, there are four ways to do it:

15 and 10
20 and 5 (the first 5)
20 and 5 (the second 5)
15, 5, and 5

Filling all containers entirely, how many different combinations of containers can exactly fit all 150 liters of eggnog?

*/


// get input
$containers = file('input/day-17.txt');

// get all combinations using binary numbers and bitwise operator
// yeah - totally stole this.
$combinations = array();
for($i = 0; $i < pow(2, count($containers)); $i++)
{
	
	$combination = array();
	
	for($j = 0; $j < count($containers); $j++)
	{
		 if(pow(2, $j) & $i) $combination[] = intval($containers[$j]);
	}
	
	// only keep combinations that total 150
	if(array_sum($combination) == 150)
	{
		$combinations[] = $combination;
	}
	
}

// output answer
echo 'Answer: '.count($combinations);


?>