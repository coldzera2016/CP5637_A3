<?php
/*
Plugin Name: wordfrequency
Plugin URI: 
Description: The wordfrequency plugin is to count the words' frequencies of a post. It's helpful to find keywords of the post.
Version: 1.0
Author: Jiaxin Li
Author URI: 
*/

	
function count_words () {
    	global $post;
		// remove tags
    	$content = strip_tags($post->post_content); 
		// remove some special characters
		$reg = '/(\.|\!|\,)/';
		$new = "";
		$content = preg_replace($reg, $new, $content);
		// split the content into an array
		$array = explode(" ", $content); 
		// count the words number
		$wordscount = count($array);
		$num = 0;
		// count the words' frequency and store the frequency into the $freqarr array
        for ($i=0; $i<$wordscount; $i++){
			for($j=0; $j<$wordscount; $j++){
				if((i!=j) && ($array[$i] == $array[$j])){
					$num++;
				}
			}
			$freqarr[$array[$i]] = $num;
			$num = 0;
		}
		// sort descending according to the frequency
		arsort($freqarr);
		echo '<p>Total number of words is: '.$wordscount.'</p>';
		echo '<p>The frequency of words is: '.'</p>';
		$maxnum = 4;
		$minfreq = 1;
		$shownum = 0;
		foreach($freqarr as $word=>$fre) {
			$shownum++;
			// only show words and frequencies that meet the conditions
			if (($fre > $minfreq) && ($shownum <= $maxnum)) {
				echo '"' . $word . '": ' . $fre;
                echo "<br>";
			}
        }
    }

add_action( 'wp_head', 'count_words' );

?>