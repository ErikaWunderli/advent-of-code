<?php
	
	
/*

--- Part Two ---

For added security, yet another system policy has been put in place. Now, a valid passphrase must contain no two words that are anagrams of each other - that is, a passphrase is invalid if any word's letters can be rearranged to form any other word in the passphrase.

For example:

    abcde fghij is a valid passphrase.
    abcde xyz ecdab is not valid - the letters from the third word can be rearranged to form the first word.
    a ab abc abd abf abj is a valid passphrase, because all letters need to be used when forming another word.
    iiii oiii ooii oooi oooo is valid.
    oiii ioii iioi iiio is not valid - any of these words can be rearranged to form any other word.

Under this new system policy, how many passphrases are valid?

*/


// load data
$rows = file('input/day-04.txt');

$valid = 0;

// loop through rows and check for matches
foreach($rows as $row)
{
	
	$words = explode(' ', $row);
	
	for($i = 0; $i < count($words); $i++)
	{
		$words[$i] = str_split(trim($words[$i]));
		sort($words[$i]);
	}
	
	foreach($words as $word)
	{
		$matches = 0;
		foreach($words as $otherword)
		{
			if($word == $otherword) $matches++;
			if($matches > 1) break;
		}
		if($matches > 1) break;
	}
	
	if($matches <= 1) $valid++;
	
}

// output answer
echo "Answer: ".$valid;
	

?>