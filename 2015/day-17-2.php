<?php
	
/*

--- Part Two ---

While playing with all the containers in the kitchen, another load of eggnog arrives! The shipping and receiving department is requesting as many containers as you can spare.

Find the minimum number of containers that can exactly fit all 150 liters of eggnog. How many different ways can you fill that number of containers and still hold exactly 150 litres?

In the example above, the minimum number of containers was two. There were three ways to use that many containers, and so the answer there would be 3.

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
		// store number of containers in that combination
		$combinations[] = count($combination);
	}
	
}

// count values and sort
$tallies = array_count_values($combinations);
ksort($tallies);

// output answer
echo 'Answer: '.array_shift($tallies);


?>