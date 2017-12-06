<?php
	
	
/*

--- Part Two ---

Out of curiosity, the debugger would also like to know the size of the loop: starting from a state that has already been seen, how many block redistribution cycles must be performed before that same state is seen again?

In the example above, 2 4 1 2 is seen again after four cycles, and so the answer in that example would be 4.

How many cycles are in the infinite loop that arises from the configuration in your puzzle input?

*/


// load data
$input = file_get_contents('input/day-06.txt');
$data = explode("\t", $input);
for($i = 0; $i < count($data); $i++) $data[$i] = intval($data[$i]);

// store states
$states = array();

// main loop
while(!in_array($data, $states))
{
	
	// add current state to states
	$states[] = $data;
	
	// find max value (and key)
	$max = 0;
	$max_key = false;
	foreach($data as $key => $val)
	{
		if($val > $max)
		{
			$max = $val;
			$max_key = $key;
		}
	}
	
	// reallocate blocks
	$blocks = $max; 
	$key = $max_key;
	$data[$key] = 0;
	while($blocks > 0)
	{
		$key++;
		if(!array_key_exists($key, $data)) $key = 0;
		$data[$key]++;
		$blocks--;
	}
		
}

// find loop size
$loop_size =  count($states) - array_search($data, $states);

// output loop size
echo "Loop size: ".$loop_size;

?>