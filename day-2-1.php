<?php
	
/*
	
--- Day 2: I Was Told There Would Be No Math ---

The elves are running low on wrapping paper, and so they need to submit an order for more. They have a list of the dimensions (length l, width w, and height h) of each present, and only want to order exactly as much as they need.

Fortunately, every present is a box (a perfect right rectangular prism), which makes calculating the required wrapping paper for each gift a little easier: find the surface area of the box, which is 2*l*w + 2*w*h + 2*h*l. The elves also need a little extra paper for each present: the area of the smallest side.

For example:

A present with dimensions 2x3x4 requires 2*6 + 2*12 + 2*8 = 52 square feet of wrapping paper plus 6 square feet of slack, for a total of 58 square feet.
A present with dimensions 1x1x10 requires 2*1 + 2*10 + 2*10 = 42 square feet of wrapping paper plus 1 square foot of slack, for a total of 43 square feet.

All numbers in the elves' list are in feet. How many total square feet of wrapping paper should they order?

*/


// load data into array
$data = file('input/day-2.txt');

// keep track of area here
$area = 0;

// loop through presents
foreach($data as $key => $row)
{
	
	// split dimension string into array and convert to ints
	$d = explode('x', $row);
	$d[0] = intval($d[0]);
	$d[1] = intval($d[1]);
	$d[2] = intval($d[2]);
	
	// calculate the surface area of the present and add it to $area
	$area += 2*$d[0]*$d[1] + 2*$d[1]*$d[2] + 2*$d[2]*$d[0];
	
	// find area of the smallest side and add it to $area
	sort($d);
	$area += $d[0]*$d[1];
	
}

// output answer
echo 'Answer: '.$area;


?>