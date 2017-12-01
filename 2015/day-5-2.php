<?php
	
/*
	
--- Part Two ---

Realizing the error of his ways, Santa has switched to a better model of determining whether a string is naughty or nice. None of the old rules apply, as they are all clearly ridiculous.

Now, a nice string is one with all of the following properties:

It contains a pair of any two letters that appears at least twice in the string without overlapping, like xyxy (xy) or aabcdefgaa (aa), but not like aaa (aa, but it overlaps).
It contains at least one letter which repeats with exactly one letter between them, like xyx, abcdefeghi (efe), or even aaa.

For example:

qjhvhtzxzqqjkmpb is nice because is has a pair that appears twice (qj) and a letter that repeats with exactly one letter between them (zxz).
xxyxx is nice because it has a pair that appears twice and a letter that repeats with one between, even though the letters used by each rule overlap.
uurcxstgmygtbstg is naughty because it has a pair (tg) but no repeat with a single letter between them.
ieodomkazucvgmuy is naughty because it has a repeating letter with one between (odo), but no pair that appears twice.

How many strings are nice under these new rules?

*/


// check for a repeating 2-letter sequence (rule 1)
function has_a_two_letter_pair($string) {
	
	// create array for all pairs
	$pairs = array();
	
	// walk through string collecting pairs and testing for match
	for($i = 1; $i < strlen($string); $i++)
	{
			
		// define 2 letter sequence
		$seq = substr($string, $i-1, 2);
		
			
		// check for previous instance of sequence...
		if(in_array($seq, $pairs))
		{
			
			// ...which was not part of this sequence
			foreach(array_keys($pairs, $seq) as $x => $key)
			{
				if(($i - $key) > 1) return true;
			}
			
		}
		
		// store sequence in $pairs
		$pairs[$i] = $seq;	
		
	}
	
	// no beans
	return false;
	
}


// check for a repeating letter with one letter in between (rule 2)
function has_a_pair_with_one_char_between($string) {
	
	// walk through string
	for($i = 2; $i < strlen($string); $i++)
	{
			
		// if char at this position matches char from 2 positions back
		if(substr($string, $i, 1) == substr($string, $i-2, 1)) return true;
		
	}
	
	// bah humbug
	return false;
	
}


// is it nice?
function is_nice($string)
{
	
	// rule 1
	if(!has_a_two_letter_pair($string)) return false;
	
	// rule 2
	if(!has_a_pair_with_one_char_between($string)) return false;
	
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