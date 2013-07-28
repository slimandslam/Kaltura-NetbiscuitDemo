<?php
/**
 * audio.php
 *
 * List audio files
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

session_start();
include_once('KalturaClient.php');
require_once('Cache/Lite.php');

if (isset($_SESSION['kclient'])) {
	$kclient = unserialize($_SESSION['kclient']);
} else {
	header('Location: error.php?etype=s');
	exit(0);
}

// Cache ID
if (isset($_SESSION['pid'])) {
	$cacheid = $_SESSION['pid'].'audlist';
} else {
	header('Location: error.php?etype=s');
	exit(0);
}

// Cache Lite options
$options = array(
	'cacheDir' => '/tmp/',
	'lifeTime' => 3600,  // one hour
	'automaticSerialization' => true
);

// Create a Cache_Lite object
$Cache_Lite = new Cache_Lite($options);

if ($result = $Cache_Lite->get($cacheid)) {
	// continue;
} else {
	try {
		$kfilter = new KalturaMediaEntryFilter();
		$kfilter->mediaTypeEqual = KalturaMediaType::AUDIO;
		$kfilter->status = KalturaEntryStatus::READY;
		$result = $kclient->media->listAction($kfilter);
		$Cache_Lite->save($result, $cacheid);
	} catch (Exception $e) {
		// echo 'Caught exception: ',  $e->getMessage(), "\n";
		header('Location: error.php?etype=w');
		exit(0);
	}
}

$page = 'audio';
require_once('header.php');
if (empty($result->objects)) {
	echo   '<container>
	     <column>
		       <SEPARATOR/>
		        <TEASER>
            <styles>
			</styles>
            <richtext>
            [b]You Do Not Have Any Audio Files In Your Account![/b]
			</richtext>
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';

} else {
	foreach ($result->objects as $entry) {
		echo   '<container>
	     <column>
		       <SEPARATOR/>
		       <TEASER href="audiodetails.php?id='.$entry->id.'">
            <styles>
			</styles>
            <richtext align="right">[url="audiodetails.php?id='.$entry->id.'"]'.$entry->name.'[/url]
			</richtext>
			<img convert="true" src="'.$entry->thumbnailUrl.'" zoom="true" />
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';
	}
}

include_once('footer.php');

?>