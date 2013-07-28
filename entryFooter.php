<?php
/**
 * entryFooter.php
 *
 * The footer to display on the entry pages
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

echo ' <container>
	     <column>
		       <PAGEFOOTER>
            <styles>
				           <style name="color" value="#FFFFFF"/>
				           <style name="link-color" value="#FFFFFF"/>
				           <style name="bgcolor" value="#db001b"/>
			 </styles>
            <item position="1">
			            <richtext>[b]about[/b]</richtext>
				           <link href="about.php"/>
			         </item>
			          <item position="3">
			            <text>|</text>
			         </item>
             <item position="5">
			            <richtext>[b]contact[/b]</richtext>
				           <link href="contact.php"/>
			         </item>
	          </PAGEFOOTER>
	     </column>
   </container>
   </page>';
?>