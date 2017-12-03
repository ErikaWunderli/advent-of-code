<?php
	
	
/*

--- Part Two ---

As a stress test on the system, the programs here clear the grid and then store the value 1 in square 1. Then, in the same allocation order as shown above, they store the sum of the values in all adjacent squares, including diagonals.

So, the first few squares' values are chosen as follows:

    Square 1 starts with the value 1.
    Square 2 has only one adjacent filled square (with value 1), so it also stores 1.
    Square 3 has both of the above squares as neighbors and stores the sum of their values, 2.
    Square 4 has all three of the aforementioned squares as neighbors and stores the sum of their values, 4.
    Square 5 only has the first and fourth squares as neighbors, so it gets the value 5.

Once a square is written, its value does not change. Therefore, the first few squares would receive the following values:

147  142  133  122   59
304    5    4    2   57
330   10    1    1   54
351   11   23   25   26
362  747  806--->   ...

What is the first value written that is larger than your puzzle input?

Your puzzle input is still 361527.

*/



$input = 361527;

// fuck, this is going to be disgusting.

$grid = array();
$sum = 1;
$x = 0;
$y = 0;
$grid[$x][$y] = 1;
$direction = 'R';
$length = 1;
$pos = 1;
$sides = 1;

while($sum <= $input)
{
	
	if($direction == 'R') $x++;
	elseif($direction == 'U') $y++;
	elseif($direction == 'L') $x--;
	elseif($direction == 'D') $y--;
	
	$sum = 0;
	for($h = $x-1; $h <= $x+1; $h++)
	{
		for($v = $y-1; $v <= $y+1; $v++)
		{
			if(($h != $x) || ($v != $y))
			{
				if(isset($grid[$h][$v])) $sum += $grid[$h][$v];
			}
		}
	}
	$grid[$x][$y] = $sum;
	
	$pos++;
	if($pos > $length)
	{
		$sides++;
		$pos = 1;
		if(($sides % 2) != 0) $length++;
		if($direction == 'R') $direction = 'U';
		elseif($direction == 'U') $direction = 'L';
		elseif($direction == 'L') $direction = 'D';
		elseif($direction == 'D') $direction = 'R';
	}
	
}

// output answer
echo "Answer: ".$sum;

?>