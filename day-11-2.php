<?php
	
/*
	
--- Part Two ---

Santa's password expired again. What's the next one?

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

// and then do it all over again...
$pass = incrementPass($pass);
while(!validPass($pass)) $pass = incrementPass($pass);


// output answer
echo 'Answer: '.$pass;


?>