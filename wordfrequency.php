<?php
/*
Plugin Name: WordFrequency
Plugin URI: 
Description: The WordFrequency plugin is to count the words' frequencies of a post. It's helpful to find keywords of the post.
Version: 0.1
Author: Jiaxin Li
Author URI: 
*/

// Execute set_options() when activating the plugin 
register_activation_hook(__FILE__,'set_options');

require_once(dirname(__FILE__).'/setoptions.php'); 
	
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
		
		// get the option values
		$maxnum = get_option('MaxNumber');
		$minfreq = get_option('Frequency');
		$fontsize = get_option('FontSize');
		$fontcolor = get_option('FontColor');
		
		// show words number and frequencies
		echo '<div id="wordFreqInfo"  style="margin-left:10px">';
		echo '<p><font size="'.$fontsize.'" color="'.$fontcolor.'">Total number of words is: '.$wordscount.'</font></p>';
		echo '<p><font size="'.$fontsize.'" color="'.$fontcolor.'">The frequencies of words are: '.'</font></p>';
		
		$shownum = 0;
		foreach($freqarr as $word=>$fre) {
			$shownum++;
			// only show words and frequencies that meet the conditions
			if (($fre >= $minfreq) && ($shownum <= $maxnum)) {
				echo '<font size="'.$fontsize.'" color="'.$fontcolor.'">' . $word . '": ' . $fre."</font>;&nbsp&nbsp";
			}
        }
		echo '</div>';
    }

add_action( 'wp_head', 'count_words' );

// Execute unset_options() when deactivating the plugin 
register_deactivation_hook(__FILE__,'unset_options');
?>