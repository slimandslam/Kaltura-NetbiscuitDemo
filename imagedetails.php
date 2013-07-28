<?php
/**
 * imagedetails.php
 *
 * Displays details for one image
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */
session_start();
require_once('KalturaClient.php');
require_once('Cache/Lite.php');

// Cache Lite options
$options = array(
	'cacheDir' => '/tmp/',
	'lifeTime' => 3600,  // one hour
	'automaticSerialization' => true
);

// Cache ID
if (isset($_SESSION['pid']) and isset($_GET['id']) and isset($_SESSION['client_type'])) {
	$cacheid = $_SESSION['pid'].$_GET['id'];
} else {
	header('Location: error.php?etype=s');
	exit(0);
}

if (isset($_SESSION['kclient'])) {
	$kclient = unserialize($_SESSION['kclient']);
} else {
	header('Location: error.php?etype=s');
	exit(0);
}

// Create a Cache_Lite object
$Cache_Lite = new Cache_Lite($options);

if ($entry = $Cache_Lite->get($cacheid)) {
	// continue;
} else {
	try {
		$entry = $kclient->media->get($_GET['id']);
		$Cache_Lite->save($entry, $cacheid);
	} catch (Exception $e) {
		// echo 'Caught exception: ',  $e->getMessage(), "\n";
		header('Location: error.php?etype=w');
		exit(0);
	}
}

$page = 'entry';
include_once('header.php');             
echo   '<container>
	     <column>
		       <SEPARATOR/>
		  		       <TEASER>
			<img convert="true" src="'.$entry->thumbnailUrl.'" zoom="true" />
            <richtext align="left">
             [b]Title: [/b]'.$entry->name.'[br]
             [b]Description: [/b]'.$entry->description.'[br]
             [b]Width: [/b]'. $entry->width.' pixels[br]
             [b]Height: [/b]'. $entry->height.' pixels[br]
             [b]Uploaded on: [/b]'.date("D M j G:i:s T Y", $entry->createdAt).'[br]
             	</richtext>
             	<link href="'.$entry->downloadUrl.'">VIEW NOW</link> 
  	  		         </TEASER>
		       <SEPARATOR/>
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
  			       <item href="image.php">
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