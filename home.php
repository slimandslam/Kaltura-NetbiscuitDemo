<?php
/**
 * home.php
 *
 * The main menu page
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

define("DEFAULT_PID", "557631");
define("DEFAULT_USERNAME", "fredPublic");
define("DEFAULT_PASSWORD", '69$jasjas');
session_start();
require_once('KalturaClient.php');
require_once('mobiled.php');

// Need this function just in case we're not using PHP as an Apache module.
// In actuality, we are not looking at the special request headers that
// Netbiscuit returns. (see debug code later on in this file for usage)
//if (!function_exists('apache_request_headers')) {
//	function apache_request_headers() {
//		foreach($_SERVER as $key=>$value) {
//			if (substr($key,0,5)=="HTTP_") {
//				$key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5)))));
//				$out[$key]=$value;
//			}else{
//				$out[$key]=$value;
//			}
//		}
//		return $out;
//	}
//}

// Setup Kaltura Session, if necessary
// HACK TO USE DEFAULT ACCOUNT
// if (isset($_POST['pid'])) {

	// $_SESSION["username"] = (isset($_POST['username'])) ? $_POST['username'] : '';
	// $_SESSION["password"] = (isset($_POST['password'])) ? $_POST['password'] : '';
	// $_SESSION["pid"] = $_POST['pid'];
	// HACK TO USE DEFAULT ACCOUNT
	$_SESSION["password"] = DEFAULT_PASSWORD;
	$_SESSION["pid"] = DEFAULT_PID;
	$_SESSION["username"] = DEFAULT_USERNAME;
	

	// $pid = $_POST['pid'];
	// $user = (isset($_POST['username'])) ? $_POST['username'] : '';
	// $pw = (isset($_POST['password'])) ? $_POST['password'] : '';
	// HACK TO USE DEFAULT ACCOUNT
	$user = DEFAULT_USERNAME;
	$pid = DEFAULT_PID;
	$pw = DEFAULT_PASSWORD;
	

	try {
		$kconf = new KalturaConfiguration($pid);
		// $kconf->serviceUrl = "http://myKalturaSite.com";
		$kclient = new KalturaClient($kconf);
		$ksession = $kclient->user->login($pid, $user, $pw);
		if (!isset($ksession)) {
			header('Location: error.php?etype=s');
			exit(0);
		}
		$kclient->setKs($ksession);
		$kconf->format = KalturaClientBase::KALTURA_SERVICE_FORMAT_PHP;
	} catch (Exception $e) {
		// echo 'Caught exception: ',  $e->getMessage(), "\n";
		header('Location: error.php?etype=w');
		exit(0);
	}

	$_SESSION['kclient'] = serialize($kclient);
// } elseif (!isset($_SESSION['kclient'])) {
//	header('Location: error.php?etype=s');
//	exit(0);
// }

// Determine type of mobile client, if necessary
if (!isset($_SESSION['client_type'])) {
	$m = new mobiled();
	// notmobile will also be the value for unknown handsets. This needs to be improved, obviously.
	$client_type = ($m->detect()) ? trim(strtolower($m->getVersion())) : 'notmobile';
	$_SESSION['client_type'] = $client_type;
}

$page = 'home';
include_once('header.php');

// DEBUG STUFF
/* echo '<container>
	     <column>
		       <TEXT>
     <richtext>CLIENT_TYPE= '.$client_type.'</richtext>
         </TEXT>
	     </column>
</container>';

echo '<container>
	     <column>
		       <TEXT>
     <richtext>';
 foreach (apache_request_headers() as $name => $value) {
    if ($name == 'User-Agent') echo "$name: $value [br]";
 }
echo  '</richtext>
         </TEXT>
	     </column>
</container>';
 */

echo ' <container>
	     <column>
	      <styles>
              <style name="text-align" value="center" />
            </styles>
		       <TEXT>
     <richtext>Access your audio, video, and photo assets here[br]</richtext>
         </TEXT>

	     </column>
   </container>

   <container>
	     <column>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>


   <container>
	     <column>
		       <SEPARATOR/>
		       <TEASER href="video.php">
            <styles>
			</styles>
            <richtext align="right">[b]Video[/b][br][br][url="video.php"]List my videos[/url]
			</richtext>
            <img format="png" convert="true" src="res/video.png" alt="myImage"/>
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>

   <container>
	     <column>
		       <SEPARATOR/>
		       <TEASER href="audio.php">
            <styles>
			</styles>
            <richtext align="right">[b]Audio[/b][br][br][url="audio.php"]List my audio[/url]
			</richtext>
            <img format="png" convert="true" src="res/audio.png" alt="myImage"/>
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>

   <container>
	     <column>
		       <SEPARATOR/>
		       <TEASER href="image.php">
            <styles>
			</styles>
            <richtext align="right">[b]Photo[/b][br][br][url="image.php"]List my photos[/url]
			</richtext>
            <img format="png" convert="true" src="res/image.png" alt="myImage"/>
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';

include_once('footer.php');

?>