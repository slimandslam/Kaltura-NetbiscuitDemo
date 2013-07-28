<?php
/**
 * footer.php
 *
 * The usual footer for most pages
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
			            <richtext>[b]contact[/b]</richtext>
 				          <link href="contact.php"/>
			         </item>
			<item position="2">
			            <text>|</text>
			         </item>
            <item position="3">	
			            <richtext>[b]about[/b]</richtext>
			            <link href="about.php"/>
			         </item>
			    <item position="4">
			            <text>|</text>
			         </item>
               <item position="5">
                     <richtext>[b]logout[/b]</richtext>
				           <link href="index.php"/> 
			         </item>
         </PAGEFOOTER>
	     </column>
   </container>
   </page>';


?>