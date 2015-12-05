<?php
	
/*
	
--- Day 5: Doesn't He Have Intern-Elves For This? ---

Santa needs help figuring out which strings in his text file are naughty or nice.

A nice string is one with all of the following properties:

It contains at least three vowels (aeiou only), like aei, xazegov, or aeiouaeiouaeiou.
It contains at least one letter that appears twice in a row, like xx, abcdde (dd), or aabbccdd (aa, bb, cc, or dd).
It does not contain the strings ab, cd, pq, or xy, even if they are part of one of the other requirements.
For example:

ugknbfddgicrmopn is nice because it has at least three vowels (u...i...o...), a double letter (...dd...), and none of the disallowed substrings.
aaa is nice because it has at least three vowels and a double letter, even though the letters used by different rules overlap.
jchzalrnumimnmhp is naughty because it has no double letter.
haegwjzuvuyypxyu is naughty because it contains the string xy.
dvszwmarrgswjxmb is naughty because it contains only one vowel.

How many strings are nice?

*/


// check for 3+ vowels (rule 1)
function has_three_vowels($string)
{
	return (preg_match_all('/[aeiou]/i', $string) >= 3);
}


// check for at least one letter twice in a row (rule 2)
function has_repeated_char($string) {
	
	// loop through string
	for($i = 1; $i < strlen($string); $i++)
	{
		
		// check if char matches previous char
		if(substr($string, $i, 1) == substr($string, $i-1, 1)) return true;

	}
	
	// nada
	return false;
	
}


// check for 'ab', 'cd', 'pq' or 'xy' (rule 3)
function has_patterns($string)
{
	return preg_match('/ab|cd|pq|xy/', $string);
}


// is it nice?
function is_nice($string)
{
	
	// rule 1
	if(!has_three_vowels($string)) return false;
	
	// rule 2
	if(!has_repeated_char($string)) return false;
	
	// rule 3
	if(has_patterns($string)) return false;if(preg_match_all('/[aeiou]/i', $string) < 3) return false;
	
	return true;
	
}


// load strings into array
$data = file('input/day-5.txt');

// count nice strings
$nice = 0;

// loop through strings
foreach($data as $key => $str)
{
	
	// if string is "nice", increment counter
	if(is_nice($str)) $nice++;
	
}

// output answer
echo 'Answer: '.$nice;


?>