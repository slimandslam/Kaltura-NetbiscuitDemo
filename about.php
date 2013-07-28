<?php
/**
 * about.php
 *
 * The about page
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */
 
$page = 'entry';
require_once('header.php');

  echo '<container>
	     <column>
		       <TEXT>
            <headline>Browse Your Kaltura Account Using Netbiscuits</headline>
            <richtext>This is a simple application that lists the video, audio, and image assets from any Kaltura account. It only lists the first 30 items of each media type.[br][br]Media assets are cached for one hour so any added items will take up to an hour to show up here.[br][br]</richtext>
         </TEXT>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>

<group test="show if http[\'Referer\'] eq null">
	 <LIST cols="1">
        <items>
 	 <item href="home.php">
 	<img src="res/arrow-left.gif" alt="*"/>
 	<text>back</text>
 	 </item>
	  </items>
     </LIST>
</group>

<group test="show if http[\'Referer\'] neq null">
	 <LIST cols="1">
        <items>
 	 <item href="'.$_SERVER['HTTP_REFERER'].'">
 	<img src="res/arrow-left.gif" alt="*"/>
 	<text>back</text>
 	 </item>
	  </items>
     </LIST>
</group>

   <container>
	     <column>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';

include_once('noFooter.php');
?>