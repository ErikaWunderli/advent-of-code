<?php
	
/*
	
--- Day 11: Corporate Policy ---

Santa's previous password expired, and he needs help choosing a new one.

To help him remember his new password after the old one expires, Santa has devised a method of coming up with a password based on the previous one. Corporate policy dictates that passwords must be exactly eight lowercase letters (for security reasons), so he finds his new password by incrementing his old password string repeatedly until it is valid.

Incrementing is just like counting with numbers: xx, xy, xz, ya, yb, and so on. Increase the rightmost letter one step; if it was z, it wraps around to a, and repeat with the next letter to the left until one doesn't wrap around.

Unfortunately for Santa, a new Security-Elf recently started, and he has imposed some additional password requirements:

Passwords must include one increasing straight of at least three letters, like abc, bcd, cde, and so on, up to xyz. They cannot skip letters; abd doesn't count.
Passwords may not contain the letters i, o, or l, as these letters can be mistaken for other characters and are therefore confusing.
Passwords must contain at least two different, non-overlapping pairs of letters, like aa, bb, or zz.

For example:

hijklmmn meets the first requirement (because it contains the straight hij) but fails the second requirement requirement (because it contains i and l).
abbceffg meets the third requirement (because it repeats bb and ff) but fails the first requirement.
abbcegjk fails the third requirement, because it only has one double letter (bb).
The next password after abcdefgh is abcdffaa.
The next password after ghijklmn is ghjaabcc, because you eventually skip all the passwords that start with ghi..., since i is not allowed.

Given Santa's current password (your puzzle input), what should his next password be?

*/


// function to increment password
function incrementPass($pass)
{
	
	// work backwards through the string
	for($i = strlen($pass) - 1; $i >= 0; $i--)
	{
		
		$char = ord(substr($pass, $i, 1)) + 1;
		
		// if > z, wrap
		if($char > 122)
		{
			
			$char = 97; // a
			for($z = $i; $z < strlen($pass); $z++) $pass = substr_replace($pass, chr($char), $z, 1);
			
			// fudge on a new character if we're all z's (won't happen, but...)
			if($i == 0) $pass = chr($char).$pass;
			
		}
		
		// otherwise, replace character and break
		else
		{
			$pass = substr_replace($pass, chr($char), $i, 1);
			break;
		}
		
	}
	
	// return incremented pass
	return $pass;
	
}


// function to check for an increasing straight of at least 3 letters (rule 1)
function hasTriplet($pass)
{

	// count sequence of incrementing letters
	$seq = 1;
	$lastChar = null;
	
	// run through string
	for($i = 0; $i < strlen($pass); $i++)
	{
		
		// check for sequence
		$char = ord(substr($pass, $i, 1));
		if(($char - 1) == $lastChar) $seq++;
		else $seq = 1;
		
		// if we've got a sequence of 3, break
		if($seq >= 3) break;
		
		// update last char
		$lastChar = $char;
		
	}
	
	if($seq >= 3) return true;
	return false;

}


// function to check for illegal letters (rule 2)
function allLegalLetters($pass)
{

	if(preg_match('/[iol]/', $pass)) return false;
	return true;

}


// function to check for at least 2 pairs
function hasPairs($pass)
{
	
	// count pairs
	$pairs = 0;

	// hold last char 
	$lastChar = null;
	
	// loop through letters
	for($i = 0; $i < strlen($pass); $i++)
	{
		$char = substr($pass, $i, 1);
		
		// if pair, count it and reset $lastChar
		if($char == $lastChar)
		{
			$pairs++;
			$lastChar = null;
		}
		
		// otherwise update $lastChar
		else $lastChar = $char;
		
	}
	
	// if 2+ pairs, true
	if($pairs >= 2) return true;
	return false;
	
}


// function to check for a valid password
function validPass($pass)
{
	
	return hasTriplet($pass) & allLegalLetters($pass) & hasPairs($pass);
	
}


// get current password
$pass = file_get_contents('input/day-11.txt');


// increment until we find a valid pass
$pass = incrementPass($pass);
while(!validPass($pass)) $pass = incrementPass($pass);


// output answer
echo 'Answer: '.$pass;


?>