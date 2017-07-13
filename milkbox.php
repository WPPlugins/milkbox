<?php
/*
Plugin Name: Milkbox 'Luca Reghellin' Wordpress Plugin
Plugin URI: http://origami43.net/wp/category/informatique/plugins-wordpress
Feed URI: 
Description: Milkbox 'Luca Reghellin' Wordpress Plugin. Another great lightbox clone.
Version: 0.1-1
Author: By mickael jardet
Author URI: http://www.origami43.net/ 
*/

/*  Copyright 2009  Mickaël Jardet (email : mickael.j@gmail.com)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


load_plugin_textdomain('milkbox', '/wp-content/plugins/milkbox/');

function milkbox_head() {
	$milkbox_path = get_option('siteurl')."/wp-content/plugins/milkbox/";
	$milkboxhead.= "<link rel=\"stylesheet\" href=\"".$milkbox_path."css/milkbox.css\" type=\"text/css\" media=\"screen\" />\n";
	$milkboxhead.= "<script type=\"text/javascript\" src=\"".$milkbox_path."js/mootools-1.2.js\"></script>\n";
	$milkboxhead.= "<script type=\"text/javascript\" src=\"".$milkbox_path."js/mootools-1.2-more.js\"></script>\n";
	$milkboxhead.= "<script type=\"text/javascript\" src=\"".$milkbox_path."js/milkbox.js\"></script>\n";
	$milkboxhead.= "<script type=\"text/javascript\" src=\"".$milkbox_path."js/milkbox.options.js\"></script>\n";
	
	print($milkboxhead);	
}


add_action('wp_head', 'milkbox_head');

add_action('admin_menu', 'milkbox_add_pages');



function milkbox_add_pages() {
	add_options_page('Slimbox', 'Milkbox', 8, __FILE__, 'slimbox_options');
}

function slimbox_options() {	
	$testfile = WP_PLUGIN_DIR.'/milkbox/js/testfile';
	if(!$file = fopen($testfile,"w+")){
	echo '<div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);">';
	echo __('<h3>WARNING: Your JS dir in milbox' ,'milkbox');
	echo WP_PLUGIN_DIR;
	echo __(' is not writable, please fix your permissions !</h3>','milkbox');
	echo '</div>';		
	}else{
		unlink($testfile);
		fclose($file);
	}		
	


	$optFile=WP_PLUGIN_DIR.'/milkbox/js/milkbox.options.js';	
	if (is_writable($optFile)) {
		// echo $optFile;
		if($file = fopen($optFile,'r+')){
			while(!feof($file)){
				$ligne = fgets($file,255);
				$test=explode(':',$ligne);
				
				if(trim($test[0])=='overlayOpacity'){
					$overlayOpacity=strtr($test[1],',',' ');
				}
				if(trim($test[0])=='topPosition'){
					$topPosition=strtr($test[1],',',' ');
				}			
				if(trim($test[0])=='initialWidth'){
					$initialWidth=strtr($test[1],',',' ');
				}
				if(trim($test[0])=='initialHeight'){
					$initialHeight=strtr($test[1],',',' ');
				}
				if(trim($test[0])=='canvasBorderWidth'){
					$canvasBorderWidth=strtr($test[1],',',' ');
					$canvasBorderWidth=strtr($canvasBorderWidth,"'",' ');
				}	
				if(trim($test[0])=='canvasBorderColor'){
					$canvasBorderColor=strtr($test[1],',',' ');
					$canvasBorderColor=strtr($canvasBorderColor,"'",' ');
				}
				if(trim($test[0])=='canvasPadding'){
					$canvasPadding=strtr($test[1],',',' ');
					$canvasPadding=strtr($canvasPadding,"'",' ');
				}
				if(trim($test[0])=='resizeDuration'){
					$resizeDuration=strtr($test[1],',',' ');
				}
				if(trim($test[0])=='resizeTransition'){

				}		
				if(trim($test[0])=='removeTitle'){
					$removeTitle=strtr($test[1],',',' ');
				}						
			}
		}else{
		echo "<div id='message' class='updated fade' style='background-color: rgb(255, 251, 204);'>";
		echo __("<h3>$optFile is not writable, please fix your permission in milkbox plugin dir !</h3></div>",'milkbox');
		}
	}else{
		echo '<div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);">';
		echo __("<h3>WARNING:");
		echo $optFile;
		echo __("is not writable, please fix your permissions in milkbox plugin dir !</h3> Verify permission of'",'milkbox');
		echo WP_PLUGIN_DIR;
		echo __("milkbox.options.js file",'milkbox');
		echo '</div>';
	}
	if ( $_POST["slimbox_submit"] ) {
		unlink($optFile);
		if($file = fopen(WP_PLUGIN_DIR.'/milkbox/js/milkbox.options.js',"w")){
				fputs($file,"window.addEvent('domready', function(){"."\n");
				fputs($file,"milkbox.changeOptions({"."\n"); 
				fputs($file,"overlayOpacity:".trim($_POST[overlayOpacity]).","."\n");
				fputs($file,"topPosition:".trim($_POST[topPosition]).","."\n");
				fputs($file,"initialWidth:".trim($_POST[initialWidth]).","."\n");
				fputs($file,"initialHeight:".trim($_POST[initialHeight]) .","."\n");
				fputs($file,"canvasBorderWidth:'".trim($_POST[canvasBorderWidth])."',"."\n");
				fputs($file,"canvasBorderColor:'".trim($_POST[canvasBorderColor])."',"."\n");
				fputs($file,"canvasPadding:'".trim($_POST[canvasPadding])."',"."\n");
				fputs($file,"resizeDuration:".trim($_POST[resizeDuration]).","."\n");
				fputs($file,"resizeTransition:'".trim($_POST[resizeTransition])."',"."\n");
				fputs($file,"removeTitle:".trim($_POST[removeTitle]).","."\n");

				fputs($file,"});"."\n");
				fputs($file,"});"."\n");
			
			
		}
		chmod(WP_PLUGIN_DIR.'/milkbox/js/milkbox.options.js',0777);
		echo '<div id="message" class="updated fade" style="background-color: rgb(255, 251, 204);">';
		echo __('<h3>Preference file updated.  !</h3> Reload this page to see your modifications.','milkbox');
		echo '</div>';
	}
	
	echo "<div class=\"wrap\"><h2>Milkbox options</h2>";
	echo "
		<div style='border: 1px solid #ccc;padding: 5px;'>
		<h3>Informations</h3>
			<p>";
			
			echo __("<strong>Milkbox</strong> is a fantastic script created by <a href='mailto:milkbox@reghellin.com'>Luca Reghellin</a>, you can download it <a href='http://reghellin.com/milkbox'>here</a>. I have made this wordpress plugin for my own use and, finally, i decided to distribute it (with author accord).",'milkbox');
		echo"
		</p>
		<p>";
		echo __("If you have any problem with this script, you can mail me <a href='mickael.j@gmail.com'>mail me</a> or visit <a href='http://www.origami43.net'>visit my site</a>.",'milkbox');
		echo"</p>
		<p><a href='http://origami43.net/wp/informatique/2009-milkbox-documentation-461'>>Documentation (English)</a</p>
		</div>"
		;	
	echo '<form method="post">';

	echo '<table class="form-table">';
		echo '<tr valign="top"><th scope="row">Overlay opacity. </th>';
		echo '<td><input type="text" name="overlayOpacity" value="'.trim($overlayOpacity).'" size="5"></input>';
		echo __('default : 0.7<br />Float (0 to 1). 0.4 to 0.7 are good choices.</td></tr>','milkbox');		

		echo '<tr valign="top"><th scope="row">Top position. </th>';
		echo '<td><input type="text" name="topPosition" value="'.trim($topPosition).'" size="5"></input>default : 50<br />';
		echo __('Integer. 50 good for big images: changes the offset from the top of the window.</td></tr>','milkbox');		

		echo '<tr valign="top"><th scope="row">Initial width. </th>';
		echo '<td><input type="text" name="initialWidth" value="'.trim($initialWidth).'" size="5"></input>';
		echo __('default : 250<br /></td></tr>','milkbox');		

		echo '<tr valign="top"><th scope="row">Initial height. </th>';
		echo '<td><input type="text" name="initialHeight" value="'.trim($initialHeight).'" size="5"></input>';
		echo __('default : 250<br /></td></tr>','milkbox');	

		echo '<tr valign="top"><th scope="row">Canvas border width. </th>';
		echo '<td><input type="text" name="canvasBorderWidth" value="'.trim($canvasBorderWidth).'" size="8"></input> ';
		echo __('default : \'0px\'<br /><strong>don\'t write quotes</strong></td></tr>','milkbox');


		echo '<tr valign="top"><th scope="row">Canvas Border Color. </th>';
		echo '<td><input type="text" name="canvasBorderColor" value="'.trim($canvasBorderColor).'" size="8"></input>';
		echo __('default : \'#000000\'<br />Color in hexa (do not forget "#", <strong>don\'t write quotes</strong></td></tr>','milkbox');

		echo '<tr valign="top"><th scope="row">Canvas padding. </th>';
		echo '<td><input type="text" name="canvasPadding" value="'.trim($canvasPadding).'" size="5"></input>';
		echo __('default : \'0px\'<br /><strong>don\'t write quotes</strong></td></tr>','milkbox');

		echo '<tr valign="top"><th scope="row">Resize duration. </th>';
		echo '<td><input type="text" name="resizeDuration" value="'.trim($resizeDuration).'" size="5"></input>';
		echo __('default : 500<br />Integer, no more than 1500 for best effect.</td></tr>','milkbox');
		/*
		echo '<tr valign="top"><th scope="row">Autoplay. </th>';
		echo '<td><input type="text" name="autoPlay" value="'.$options['autoPlay'].'" size="5"></input><br />False or true.</td></tr>';

		echo '<tr valign="top"><th scope="row">Autoplay Delay. </th>';
		echo '<td><input type="text" name="autoPlayDelay" value="'.$options['autoPlayDelay'].'" size="5"></input><br />Set it in <strong>seconds</strong>, not milliseconds.</td></tr>';
		*/
		echo '<tr valign="top"><th scope="row">Rezise transition. </th>';
		echo '<td><input type="text" name="resizeTransition" value="sine:in:out" size="15"></input> ';
		echo __('default : \'sine:in:out\'<br /><strong>don\'t write quotes</strong> Not working fine at this time,  always transition by default loaded (fixed soon).<br/> See <a target="new" href="http://mootools.net/docs/Fx/Fx.  Transitions"> mootools transition doc</a> for more information.</td></tr>','milkbox');

		echo '<tr valign="top"><th scope="row">Remove title. </th>';
		echo '<td><input type="text" name="removeTitle" value="'.trim($removeTitle).'" size="5"></input>';
		echo __('default : false<br />If true, you won\'t see the titles contents popping up while hovering the 
		Milkbox links (default behaviour of browsers like FireFox).</td></tr>','milkbox');

		echo '<input type="hidden" name="slimbox_submit" value="true"></input>';
		echo '</table>';
		echo '<p class="submit"><input class="button-primary" type="submit" value="';
		echo __('Update Options &raquo;','milkbox');
		echo '"></input></p>';
	echo '</form>';
	echo __('<p><strong>You can find the option (milkbox.options.js) file in your milkbox plugin directory, in \'js\' sub directory.</strong></p>','milkbox');
}

?>
