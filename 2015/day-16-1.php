<?php
	
/*

--- Day 16: Aunt Sue ---

Your Aunt Sue has given you a wonderful gift, and you'd like to send her a thank you card. However, there's a small problem: she signed it "From, Aunt Sue".

You have 500 Aunts named "Sue".

So, to avoid sending the card to the wrong person, you need to figure out which Aunt Sue (which you conveniently number 1 to 500, for sanity) gave you the gift. You open the present and, as luck would have it, good ol' Aunt Sue got you a My First Crime Scene Analysis Machine! Just what you wanted. Or needed, as the case may be.

The My First Crime Scene Analysis Machine (MFCSAM for short) can detect a few specific compounds in a given sample, as well as how many distinct kinds of those compounds there are. According to the instructions, these are what the MFCSAM can detect:

children, by human DNA age analysis.
cats. It doesn't differentiate individual breeds.
Several seemingly random breeds of dog: samoyeds, pomeranians, akitas, and vizslas.
goldfish. No other kinds of fish.
trees, all in one group.
cars, presumably by exhaust or gasoline or something.
perfumes, which is handy, since many of your Aunts Sue wear a few kinds.

In fact, many of your Aunts Sue have many of these. You put the wrapping from the gift into the MFCSAM. It beeps inquisitively at you a few times and then prints out a message on ticker tape:

children: 3
cats: 7
samoyeds: 2
pomeranians: 3
akitas: 0
vizslas: 0
goldfish: 5
trees: 3
cars: 2
perfumes: 1

You make a list of the things you can remember about each Aunt Sue. Things missing from your list aren't zero - you simply don't remember the value.

What is the number of the Sue that got you the gift?

*/


// parse the input file into an array of aunts
$sues = array();
$n = 1;
foreach(file('input/day-16.txt') as $line)
{
	preg_match_all('/(\w+): (\d+)/', $line, $m);
	for($i = 0; $i < 3; $i++) $sues[$n][$m[1][$i]] = intval($m[2][$i]);
	$n++;
}

// array of the MFCSAM analysis
$analysis = array(
	'children' => 3,
	'cats' => 7,
	'samoyeds' => 2,
	'pomeranians' => 3,
	'akitas' => 0,
	'vizslas' => 0,
	'goldfish' => 5,
	'trees' => 3,
	'cars' => 2,
	'perfumes' =>1
);

// loop through analysis elements and exclude non-matches
foreach($analysis as $el => $num)
{
	// check all sues
	foreach($sues as $n => $sue)
	{
		// if this attribute exists in the "sue"
		// definition but is not a match...
		if(array_key_exists($el, $sue) && ($sue[$el] != $num))
		{
			// eliminate the sue!
			unset($sues[$n]);
		}
	}
}

// check there's one sue left
if(count($sues) != 1) die('Expected one Sue left!');

// output answer
echo 'Answer: '.array_keys($sues)[0];


?>