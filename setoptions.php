<?php 

// hook for adding the plugin setting page
add_action('admin_menu','set_options_menu');
// action for the hook
function set_options_menu(){
	// add a menu under settings 
	add_options_page('WordFrequency Options','WordFrequencyPlugin','manage_options','WordFrequencyPlugin','wordFrequency_options');

	}
	
function wordFrequency_options(){
	
	//check if $_POST['frequency'] and $_POST['number'] are set
	if(isset($_POST['frequency']) && isset($_POST['number']))
	{   
        $errorMsg = '';
		// check if $_POST['frequency'] or $_POST['number'] is blank
        if (($_POST['frequency'] == '') || ($_POST['number'] == ''))
		{
			$errorMsg = 'One of required field is blank.';
		}
		// check if $_POST['frequency'] is a number
		elseif (!is_numeric($_POST['frequency']))
		{
			$errorMsg = 'frequency field is not a number';
		}
		// check if $_POST['number'] is a number
		elseif (!is_numeric($_POST['number']))
		{ 
		    $errorMsg = 'number field is not a number';
		}
		// check if capacity is greater than 1 or equals to 1
		elseif ($_POST['frequency'] < 1)
		{
			$errorMsg = 'frequency field should be greater than one or equals one';
		} 
		// show an error message 
		if ($errorMsg != '')
		{  
			echo '<p><font color="red">Error: '.$errorMsg.'</font></p>';
		}
		else
		{  
	        // update the option values
			update_option('Frequency',$_POST['frequency']);
			update_option('MaxNumber',$_POST['number']);
			update_option('FontSize',$_POST['fontsize']);
			update_option('FontColor',$_POST['fontcolor']);
			echo '<p><font color="blue">The values are saved successfully!</font></p>';
		}
	}
	
	echo '<h2>WordFrequency Plugin Settings</h2>';
    echo '<form name="wordfrequencyForm" method="post">';
	echo '<table style="border: 0px;" cellspacing="10" cellpadding="1">';
	echo '<tr><td><label for="frequency">Minimal frequency for showing: </label></td><td><input type="text" name="frequency" maxlength="5" id="frequency" value="'.get_option('Frequency').'" /></td>';
	echo '<tr><td><label for="number">Maximal words number for showing: </label></td><td><input type="text" name="number" maxlength="5" id="number" value="'.get_option('MaxNumber').'" /></td>';
	echo '<tr><td>Choose font size: </td><td><select name="fontsize"><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option></td>';
	echo '<tr><td>Choose font color: </td><td><input type="color" name="fontcolor"></td>';
	echo '<tr><td></td><td><input type="submit" name="submit" value="Save" /></td></tr>';
	echo '</table></form>';
	
}

// add new variables and sets the default values
function set_options(){		
		add_option('Frequency', 2);
		add_option('MaxNumber', 10);
		add_option('FontSize', '3');
		add_option('FontColor','black');
}	


// delete variables
function unset_options(){ 
		delete_option('Frequency');
		delete_option('MaxNumber');
		delete_option('FontSize');
		delete_option('FontColor');
}

?>