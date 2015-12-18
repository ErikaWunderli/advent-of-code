<?php
	
/*

--- Part Two ---

You flip the instructions over; Santa goes on to point out that this is all just an implementation of Conway's Game of Life. At least, it was, until you notice that something's wrong with the grid of lights you bought: four lights, one in each corner, are stuck on and can't be turned off. The example above will actually run like this:

Initial state:
##.#.#
...##.
#....#
..#...
#.#..#
####.#

After 1 step:
#.##.#
####.#
...##.
......
#...#.
#.####

After 2 steps:
#..#.#
#....#
.#.##.
...##.
.#..##
##.###

After 3 steps:
#...##
####.#
..##.#
......
##....
####.#

After 4 steps:
#.####
#....#
...#..
.##...
#.....
#.#..#

After 5 steps:
##.###
.##..#
.##...
.##...
#.#...
##...#

After 5 steps, this example now has 17 lights on.

In your grid of 100x100 lights, given your initial configuration, but with the four corners always in the on state, how many lights are on after 100 steps?

*/


// create array of lights
$l = array();
$y = 1;
foreach(file('input/day-18.txt', FILE_IGNORE_NEW_LINES) as $row)
{
	for($x = 0; $x < strlen($row); $x++)
	{
		$l[$x+1][$y] = (substr($row, $x, 1) == '#') ? true : false;
	}
	$y++;
}


// force corner lights on
$l[1][1] = true;
$l[1][100] = true;
$l[100][1] = true;
$l[100][100] = true;


// loop i times
for($i = 0; $i < 100; $i++)
{
	
	// next step
	$next_l = array();

	// each col
	for($x = 1; $x <= count($l); $x++)
	{
		
		// each row
		for($y = 1; $y <= count($l[1]); $y++)
		{
			
			// count lit neighbours
			$neighbours = 0;
			for($a = $x-1; $a <= $x+1; $a++)
			{
				for($b = $y-1; $b <= $y+1; $b++)
				{
					if(isset($l[$a][$b]) && (($a != $x) || ($b != $y)))
					{
						if($l[$a][$b]) $neighbours++;
					}
				}
			}
			
			// if currently on
			if($l[$x][$y]) $next_l[$x][$y] = (($neighbours == 2) || ($neighbours == 3)) ? true : false;
			
			// if currently off
			else $next_l[$x][$y] = ($neighbours == 3) ? true : false;
			
		}
		
	}
	
	// update array
	$l = $next_l;
	
	// force corner lights on
	$l[1][1] = true;
	$l[1][100] = true;
	$l[100][1] = true;
	$l[100][100] = true;
	
}


// count all lights now on
$on = 0;
for($x = 1; $x <= count($l); $x++)
{
		
	// each row
	for($y = 1; $y <= count($l[1]); $y++)
	{
		if($l[$x][$y]) $on++;
	}
}


// output answer
echo 'Answer: '.$on;


?>