<?php
	
/*
	
--- Part Two ---

Your cookie recipe becomes wildly popular! Someone asks if you can make another recipe that has exactly 500 calories per cookie (so they can use it as a meal replacement). Keep the rest of your award-winning process the same (100 teaspoons, same ingredients, same scoring system).

For example, given the ingredients above, if you had instead selected 40 teaspoons of butterscotch and 60 teaspoons of cinnamon (which still adds to 100), the total calorie count would be 40*8 + 60*3 = 500. The total score would go down, though: only 57600000, the best you can do in such trying circumstances.

Given the ingredients in your kitchen and their properties, what is the total score of the highest-scoring cookie you can make with a calorie total of 500?

*/


// parse the input file into an array
$ingredients = array();
foreach(file('input/day-15.txt') as $line)
{
	preg_match('/^(\w+): capacity ([0-9\-]+), durability ([0-9\-]+), flavor ([0-9\-]+), texture ([0-9\-]+), calories ([0-9\-]+)$/', $line, $m);
	$ingredients[$m[1]] = array('capacity' => intval($m[2]), 'durability' => intval($m[3]), 'flavour' => intval($m[4]), 'texture' => intval($m[5]), 'calories' => intval($m[6]));
}

$score = 0;

// work out all the possible ways of making 100
for($sugar = 0; $sugar <= 100; $sugar++)
{
	for($sprinkles = 0; $sprinkles <= 100 - $sugar; $sprinkles++)
	{
		for($candy = 0; $candy <= 100 - $sugar - $sprinkles; $candy++)
		{
			for($chocolate = 0; $chocolate <= 100 - $sugar - $sprinkles - $candy; $chocolate++)
			{
				
				// if this adds to 100...
				if($sugar + $sprinkles + $candy + $chocolate == 100)
				{
				
					// work out the scores based on this mix
					$cap = max(0, $sugar * $ingredients['Sugar']['capacity'] + $sprinkles * $ingredients['Sprinkles']['capacity'] + $candy * $ingredients['Candy']['capacity'] + $chocolate * $ingredients['Chocolate']['capacity']);
					$dura = max(0, $sugar * $ingredients['Sugar']['durability'] + $sprinkles * $ingredients['Sprinkles']['durability'] + $candy * $ingredients['Candy']['durability'] + $chocolate * $ingredients['Chocolate']['durability']);
					$flav = max(0, $sugar * $ingredients['Sugar']['flavour'] + $sprinkles * $ingredients['Sprinkles']['flavour'] + $candy * $ingredients['Candy']['flavour'] + $chocolate * $ingredients['Chocolate']['flavour']);
					$tex = max(0, $sugar * $ingredients['Sugar']['texture'] + $sprinkles * $ingredients['Sprinkles']['texture'] + $candy * $ingredients['Candy']['texture'] + $chocolate * $ingredients['Chocolate']['texture']);
					$cals = $sugar * $ingredients['Sugar']['calories'] + $sprinkles * $ingredients['Sprinkles']['calories'] + $candy * $ingredients['Candy']['calories'] + $chocolate * $ingredients['Chocolate']['calories'];
					if($cals == 500) $score = max($score, $cap * $dura * $flav * $tex);					
			
				}
				
			}
		}
	}
}

// output answer
echo 'Answer: '.$score;


?>