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
		// get the option values
		$maxnum = get_option('MaxNumber');
		$minfreq = get_option('Frequency');
		$fontsize = get_option('FontSize');
		$fontcolor = get_option('FontColor');
		$commonwords = get_option('CommonWords');
		
		// remove tags
    	$content = strip_tags($post->post_content); 
		// remove some special characters
		$reg = '/(\.|\!|\,)/';
		$new = "";
		$content = preg_replace($reg, $new, $content);
		// split the content into an array
		$array = explode(" ", $content); 
		$array = array_filter($array);
		// count the words number
		$wordscount = count($array);
				
		// remove spaces in the common words array
		if ('' != $commonwords) {
			// split the common words into an array
		    $commonarr = explode(",", $commonwords);
			
			for ($i=0; $i<count($commonarr); $i++) { 
			    $commonarr[$i] = trim($commonarr[$i]);
			}
		}
        $freqarr = array();
		// count the words' frequency and store the frequency into the $freqarr array
        for ($i=0; $i<$wordscount; $i++){
			if (in_array(trim($array[$i]),$commonarr)){
				continue;
			}
			
			if ((null != $freqarr) && array_key_exists($array[$i], $freqarr))
				$freqarr[$array[$i]]++;
			else 
				$freqarr[$array[$i]] = 1;
			
		}
		// sort descending according to the frequency
		arsort($freqarr);
		
		// show words number and frequencies
		// '<div id="wordFreqInfo"  style="margin-left:10px">';

		$showstr = '<p><font size="'.$fontsize.'" color="'.$fontcolor.'">Total number of words is: '.$wordscount.'</></p>';
		$showstr = $showstr.'<p><font size="'.$fontsize.'" color="'.$fontcolor.'">The frequencies of words are: '.'</></p>';
		
		$shownum = 0;
		foreach($freqarr as $word=>$fre) {
			$shownum++;
			// only show words and frequencies that meet the conditions
			if (($fre >= $minfreq) && ($shownum <= $maxnum)) {
				$showstr = $showstr.'<font size="'.$fontsize.'" color="'.$fontcolor.'">"' . $word . '": ' . $fre.";</font>&nbsp&nbsp";
			}
        }
		
		echo '<div id="app">
        <ul>
            <li>
                <a href="#">Word frequency</a>
                <div class="none">'.$showstr.'</div>
            </li>
            
        </ul>
    </div>
    <script>
        var app = new showresult({
            el: "#app",
            methods: {}
        })
    </script>';
    }
function show_result(){
	echo '<style lang="scss">
        li {
            position: relative;
            width: 150px;
            height: 30px;
            background-color: rgba(100, 163, 200, 0.3);
            margin-bottom: 30px;
        }
        li > a {
            display: inline-block;
            width: 100%;
            height: 100%;
        }

        .none {
            width: 300px;
            height: 200px;
            padding: 19px 24px 11px 16px;
            box-sizing: border-box;
            background: rgba(255, 100, 0, 0.1);
            border: 1px solid #999;
            position: absolute;
            left: 150px;
			overflow-y:scroll;
            top: -1px;
            z-index: 3;
            display: none;
        }

        li:hover .none{
            display: block;
        }
    </style>';
	
 
}
add_action( 'wp_head', 'show_result' );
add_action( 'wp_head', 'count_words' );

// Execute unset_options() when deactivating the plugin 
register_deactivation_hook(__FILE__,'unset_options');
?>