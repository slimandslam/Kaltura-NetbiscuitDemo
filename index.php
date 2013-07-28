<?php
/**
 * index.php
 *
 * The login page
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

session_start();
// Define the default account (if desired)
define("DEFAULT_PID", "557631");
define("DEFAULT_USERNAME", "fredPublic");
define("DEFAULT_PASSWORD", 'fakePassword');

// ini_set('display_errors',1); 
// error_reporting(E_ALL);
	
// Unset all of the session variables.
// $_SESSION = array();

$page = 'entry';
include_once('header.php');

if (!ini_set('session.use_cookies', 1)) {
	die("Could not set session_cookies");
}

$nosession = '0';
// HACK TO USE DEFAULT ACCOUNT
// if ( isset($_SESSION["pid"]) and  isset($_SESSION["username"]) and isset($_SESSION["password"]) ) {
//	$pid = $_SESSION["pid"];
//	$username = $_SESSION["username"];
//	$password = $_SESSION["password"];
// } else {
	// default test account
	$pid = DEFAULT_PID;
	$username = DEFAULT_USERNAME;
	$password = DEFAULT_PASSWORD;
// }

echo '<container>
	     <column>
		       <TEXT>
            <headline>Access Your Kaltura Account[br][br]</headline>
            <richtext>Browse your newest media assets.[br][br]
            </richtext>
         </TEXT>
	     </column>
   </container>

   <container>
	     <form action="home.php" method="post">
         <row>
			         <cell align="left">
				           <text>[b]Kaltura Partner ID:[/b]</text>
			         </cell>
		       </row>
         <row>
			         <cell align="left">
				           <input disabled="disabled" type="text" name="pid" maxlength="10" size="10" align="left" value="'.$pid.'"/>
			         </cell>
		       </row>
         <row>
			         <cell align="left">
				           <text>[b]Username:[/b]</text>
			         </cell>
		       </row>
         <row>
			         <cell align="left">
				           <input disabled="disabled" type="text" name="username" maxlength="30" size="25" align="left" value="'.$username.'"/>
			         </cell>
		       </row>
         <row>
			         <cell align="left">
				           <text>[b]Password:[/b]</text>
			         </cell>
		       </row>
       <row>
			         <cell align="left">
				           <input disabled="disabled" type="password" name="password" maxlength="30" size="25" align="left" value="'.$password.'"/>
			         </cell>
		       </row>
         <row>
			         <cell align="left">
			               
				           <input type="submit" value="authenticate" align="left"/>
			         </cell>
		       </row>
      </form>
   </container>

   <container>
	     <column>
		       <SEPARATOR/>
	     </column>
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