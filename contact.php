<?php
/**
 * contact.php
 *
 * The contact page
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

$page = 'entry';
include_once('header.php');

  echo '<container>
	     <column>
		       <TEXT>
            <headline>Contact Us</headline>
            <richtext>Interested in adding mobile applications to your Kaltura account? Contact us![br][br]
            [b]Kaltura[/b][br]
            [u][tel="+18008715224"]Call:1-800-871-5224 [/tel][/u][br][br]
            [u][url="mailto:sales@kaltura.com"]Email:sales@kaltura.com[/url][/u][br][br]
            [u][url="http://corp.kaltura.com/about/contact"]Web:www.kaltura.com[/url][/u][br]
            </richtext>
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