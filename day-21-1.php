<?php

/*
	
--- Day 21: RPG Simulator 20XX ---

Little Henry Case got a new video game for Christmas. It's an RPG, and he's stuck on a boss. He needs to know what equipment to buy at the shop. He hands you the controller.

In this game, the player (you) and the enemy (the boss) take turns attacking. The player always goes first. Each attack reduces the opponent's hit points by at least 1. The first character at or below 0 hit points loses.

Damage dealt by an attacker each turn is equal to the attacker's damage score minus the defender's armor score. An attacker always does at least 1 damage. So, if the attacker has a damage score of 8, and the defender has an armor score of 3, the defender loses 5 hit points. If the defender had an armor score of 300, the defender would still lose 1 hit point.

Your damage score and armor score both start at zero. They can be increased by buying items in exchange for gold. You start with no items and have as much gold as you need. Your total damage or armor is equal to the sum of those stats from all of your items. You have 100 hit points.

Here is what the item shop is selling:

Weapons:    Cost  Damage  Armor
Dagger        8     4       0
Shortsword   10     5       0
Warhammer    25     6       0
Longsword    40     7       0
Greataxe     74     8       0

Armor:      Cost  Damage  Armor
Leather      13     0       1
Chainmail    31     0       2
Splintmail   53     0       3
Bandedmail   75     0       4
Platemail   102     0       5

Rings:      Cost  Damage  Armor
Damage +1    25     1       0
Damage +2    50     2       0
Damage +3   100     3       0
Defense +1   20     0       1
Defense +2   40     0       2
Defense +3   80     0       3

You must buy exactly one weapon; no dual-wielding. Armor is optional, but you can't use more than one. You can buy 0-2 rings (at most one for each hand). You must use any items you buy. The shop only has one of each item, so you can't buy, for example, two rings of Damage +3.

For example, suppose you have 8 hit points, 5 damage, and 5 armor, and that the boss has 12 hit points, 7 damage, and 2 armor:

The player deals 5-2 = 3 damage; the boss goes down to 9 hit points.
The boss deals 7-5 = 2 damage; the player goes down to 6 hit points.
The player deals 5-2 = 3 damage; the boss goes down to 6 hit points.
The boss deals 7-5 = 2 damage; the player goes down to 4 hit points.
The player deals 5-2 = 3 damage; the boss goes down to 3 hit points.
The boss deals 7-5 = 2 damage; the player goes down to 2 hit points.
The player deals 5-2 = 3 damage; the boss goes down to 0 hit points.

In this scenario, the player wins! (Barely.)

You have 100 hit points. The boss's actual stats are in your puzzle input. What is the least amount of gold you can spend and still win the fight?

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
					if(win_fight(100, $boss['hp'], $damage, $boss['damage'], $armour, $boss['armour']))
					{
						// log lowest cost
						if(!isset($lowest_cost_win) || ($cost < $lowest_cost_win)) $lowest_cost_win = $cost;
					}
					
				} 	
			}
		}
	}	
}


// output answer
echo "Answer: ".$lowest_cost_win;


?>