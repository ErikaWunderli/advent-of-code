<?php

/*
	
--- Part Two ---

Turns out the shopkeeper is working with the boss, and can persuade you to buy whatever items he wants. The other rules still apply, and he still only has one of each item.

What is the most amount of gold you can spend and still lose the fight?

*/


// load boss's stats

preg_match_all('/\d+/', file_get_contents('input/day-21.txt'), $m);
$boss = array('hp' => intval($m[0][0]), 'damage' => intval($m[0][1]), 'armour' => intval($m[0][2]));


// format shop inventory

$weapons = array(
	array(
		'name' => 'dagger',
		'cost' => 8,
		'damage' => 4,
		'armour' => 0
	),
	array(
		'name' => 'shortsword',
		'cost' => 10,
		'damage' => 5,
		'armour' => 0
	),
	array(
		'name' => 'warhammer',
		'cost' => 25,
		'damage' => 6,
		'armour' => 0
	),
	array(
		'name' => 'longsword',
		'cost' => 40,
		'damage' => 7,
		'armour' => 0
	),
	array(
		'name' => 'greataxe',
		'cost' => 74,
		'damage' => 8,
		'armour' => 0
	)
);

$armour = array(
	array(
		'name' => 'leather',
		'cost' => 13,
		'damage' => 0,
		'armour' => 1
	),
	array(
		'name' => 'chainmail',
		'cost' => 31,
		'damage' => 0,
		'armour' => 2
	),
	array(
		'name' => 'splintmail',
		'cost' => 53,
		'damage' => 0,
		'armour' => 3
	),
	array(
		'name' => 'bandedmail',
		'cost' => 75,
		'damage' => 0,
		'armour' => 4
	),
	array(
		'name' => 'platemail',
		'cost' => 102,
		'damage' => 0,
		'armour' => 5
	)
);

$rings = array(
	array(
		'name' => 'damage_1',
		'cost' => 25,
		'damage' => 1,
		'armour' => 0
	),
	array(
		'name' => 'damage_2',
		'cost' => 50,
		'damage' => 2,
		'armour' => 0
	),
	array(
		'name' => 'damage_3',
		'cost' => 100,
		'damage' => 3,
		'armour' => 0
	),
	array(
		'name' => 'defense_1',
		'cost' => 20,
		'damage' => 0,
		'armour' => 1
	),
	array(
		'name' => 'defense_2',
		'cost' => 40,
		'damage' => 0,
		'armour' => 2
	),
	array(
		'name' => 'defense_3',
		'cost' => 80,
		'damage' => 0,
		'armour' => 3
	)
);


// work out if you win or lose a fight
function win_fight($your_hp, $enemy_hp, $your_damage, $enemy_damage, $your_armour, $enemy_armour)
{
	$your_attack = max(1, $your_damage - $enemy_armour);
	$enemy_attack = max(1, $enemy_damage - $your_armour);
	$round = 0;
	while(($your_hp > 0) && ($enemy_hp > 0))
	{
		$round++;
		// your turn
		if(($round % 2) != 0) $enemy_hp -= $your_attack;
		// enemy's turn
		else $your_hp -= $enemy_attack;
	}
	return $your_hp > $enemy_hp;
}

// must have 1 weapon
$weapon_options = $weapons;

// must have 0 or 1 armour
$armour_options = $armour;
$armour_options[] = array (
	'name' => 'none',
	'cost' => 0,
	'damage' => 0,
	'armour' => 0
);

// must have 0 to 1 ring on each hand
$ring_options = $rings;
$ring_options[] = array (
	'name' => 'none',
	'cost' => 0,
	'damage' => 0,
	'armour' => 0
);

// weapon
for($w = 0; $w < count($weapon_options); $w++)
{
	// armour
	for($a = 0; $a < count($armour_options); $a++)
	{
		// ring - left hand
		for($r1 = 0; $r1 < count($ring_options); $r1++)
		{
			// ring - right hand
			for($r2 = 0; $r2 < count($ring_options); $r2++)
			{
				// can't have 2 of the same ring
				if(($ring_options[$r1]['name'] == 'none') || ($r1 != $r2))
				{
					// $desc = $weapon_options[$w]['name'].' '.$armour_options[$a]['name'].' '.$ring_options[$r1]['name'].' '.$ring_options[$r2]['name'];
					$cost = $weapon_options[$w]['cost'] + $armour_options[$a]['cost'] + $ring_options[$r1]['cost'] + $ring_options[$r2]['cost'];
					$damage = $weapon_options[$w]['damage'] + $armour_options[$a]['damage'] + $ring_options[$r1]['damage'] + $ring_options[$r2]['damage'];
					$armour = $weapon_options[$w]['armour'] + $armour_options[$a]['armour'] + $ring_options[$r1]['armour'] + $ring_options[$r2]['armour'];
					
					// fight!
					if(!win_fight(100, $boss['hp'], $damage, $boss['damage'], $armour, $boss['armour']))
					{
						// log highest cost
						if(!isset($highest_cost_lose) || ($cost > $highest_cost_lose)) $highest_cost_lose = $cost;
					}
					
				} 	
			}
		}
	}	
}


// output answer
echo "Answer: ".$highest_cost_lose;


?>