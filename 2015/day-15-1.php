<?php
	
/*
	
--- Day 15: Science for Hungry People ---

Today, you set out on the task of perfecting your milk-dunking cookie recipe. All you have to do is find the right balance of ingredients.

Your recipe leaves room for exactly 100 teaspoons of ingredients. You make a list of the remaining ingredients you could use to finish the recipe (your puzzle input) and their properties per teaspoon:

capacity (how well it helps the cookie absorb milk)
durability (how well it keeps the cookie intact when full of milk)
flavor (how tasty it makes the cookie)
texture (how it improves the feel of the cookie)
calories (how many calories it adds to the cookie)

You can only measure ingredients in whole-teaspoon amounts accurately, and you have to be accurate so you can reproduce your results in the future. The total score of a cookie can be found by adding up each of the properties (negative totals become 0) and then multiplying together everything except calories.

For instance, suppose you have these two ingredients:

Butterscotch: capacity -1, durability -2, flavor 6, texture 3, calories 8
Cinnamon: capacity 2, durability 3, flavor -2, texture -1, calories 3

Then, choosing to use 44 teaspoons of butterscotch and 56 teaspoons of cinnamon (because the amounts of each ingredient must add up to 100) would result in a cookie with the following properties:

A capacity of 44*-1 + 56*2 = 68
A durability of 44*-2 + 56*3 = 80
A flavor of 44*6 + 56*-2 = 152
A texture of 44*3 + 56*-1 = 76

Multiplying these together (68 * 80 * 152 * 76, ignoring calories for now) results in a total score of 62842880, which happens to be the best score possible given these ingredients. If any properties had produced a negative total, it would have instead become zero, causing the whole score to multiply to zero.

Given the ingredients in your kitchen and their properties, what is the total score of the highest-scoring cookie you can make?

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
					$score = max($score, $cap * $dura * $flav * $tex);					
			
				}
				
			}
		}
	}
}

// output answer
echo 'Answer: '.$score;


?>