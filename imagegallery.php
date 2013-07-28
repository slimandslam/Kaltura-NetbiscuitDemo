<?php
/**
 * imagegallery.php
 *
 * Displays list of images in a gallery format
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
	$cacheid = $_SESSION['pid'].'imglist';
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
		$kfilter->mediaTypeEqual = KalturaMediaType::IMAGE;
		$kfilter->status = KalturaEntryStatus::READY;
		$result = $kclient->media->listAction($kfilter);
		$Cache_Lite->save($result, $cacheid);
	} catch (Exception $e) {
		// echo 'Caught exception: ',  $e->getMessage(), "\n";
		header('Location: error.php?etype=w');
		exit(0);
	}
}

$page = 'photo';
include_once('header.php');
if (empty($result->objects)) {
	echo   '<container>
	     <column>
		       <SEPARATOR/>
		        <TEASER>
            <styles>
			</styles>
            <richtext>
            [b]You Do Not Have Any Photos In Your Account![/b]
			</richtext>
         </TEASER>
		       <SEPARATOR/>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';
} else {
	echo '<gallery id="gallery1">
	<styles>
	<style name="header-align" value="center"/>
	<style name="text-align" value="center"/>
	</styles>
<controls>
<control name="leftarrow" value="res/arrow-left.gif" />
<control name="rightarrow" value="res/arrow-right.gif" />
<control name="action" value="loadimage" />
<control name="columns" value="3"/>
<control name="column-padding" value="3px"/>
</controls>
<headline>
Photo Gallery
</headline>
<items>';

	foreach ($result->objects as $entry) {
		if (strlen($entry->name) > 15) {
			$label = substr($entry->name,0,11).'...';
		} else {
			$label = $entry->name;
		}
		// <richtext>'.$label.'</richtext>
		echo   '<item href="'.$entry->downloadUrl.'" >
<img boxing="1" fillcolor="FFFFFF" src="'.$entry->thumbnailUrl.'"/>
</item>';

	}
	echo '</items>
<view />
</gallery>';

}

include_once('footer.php');

?>