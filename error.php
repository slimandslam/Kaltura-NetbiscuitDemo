<?php
/**
 * error.php
 *
 * Displays errors as needed
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

$page = 'entry';
include_once('header.php');

$etype = (isset($_GET['etype'])) ? $_GET['etype'] : 'unknown';

switch ($etype) {
case 's': $head = 'Could not establish session';
	$detail = 'Sorry. You entered invalid credentials or your session expired. Try again.';
	break;
case 'w': $head = 'Web services error';
	$detail = 'Sorry. A web services call failed. Try again.';
	break;
default: $head = 'An Unknown Error Occurred';
	$detail = 'Sorry. Try logging in again.';
	break;

}

echo '<container>
	     <column>
		       <TEXT>
            <headline>'.$head.'</headline>
            <richtext>'.$detail.'[br][br]</richtext>
         </TEXT>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>

   <container>
	 	   <LIST cols="1">
         <styles>
				        <style name="color" value="#D90000"/>
			      </styles>
         <items>
  			       <item href="index.php">
  				         <img src="res/arrow-left.gif" alt="*"/>
  				         <text>back</text>
  			       </item>
			      </items>
      </LIST>
   </container>

   <container>
	     <column>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';

include_once('entryFooter.php');
?>