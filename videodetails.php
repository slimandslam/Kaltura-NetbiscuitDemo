<?php
/**
 * videodetails.php
 *
 * Displays the details for one video
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
		$kclient->startMultiRequest();
		$kclient->media->get($_GET['id']);
		$kclient->flavorAsset->getByEntryId($_GET['id']);
		$entry = $kclient->doQueue();
		$Cache_Lite->save($entry, $cacheid);
	} catch (Exception $e) {
		// echo 'Caught exception: ',  $e->getMessage(), "\n";
		header('Location: error.php?etype=w');
		exit(0);
	}
}

// Following flavor tags represent flavors that are mobile-playable:
// 'iphone' - h264 for iphone3/android and on via progressive download
// 'ipad' - h264 for ipad and iphone4 and on via progressive download
// 'iphonenew' - h264 for iphone3 and on via progressive download and Akamai HD Network
// 'ipadnew' - h264 for ipad and iphone4 and on via progressive download and Akamai HD Network
// 'mobile,mpeg4' - visual mpeg4 for the older video capable cellphones, via progressive download
// Older entries may have just "iphone" tag. Newer ones with iphonenew also have just "iphone"
//$HANDSET='missed';
switch ($_SESSION['client_type']) {
case 'ipod':
case 'iphone':
case 'android':
	foreach ($entry[1] as $flavor) {
		if ( strpos( $flavor->tags, 'iphonenew' ) !== false ) {
			$theurl = $kclient->flavorAsset->getDownloadUrl($flavor->id);
			$size = round($flavor->size/1024,1);
			//$HANDSET='iphone';
			break 2;
		}
	}
	// If iphonenew search failes, look again and see if an entry has just the iphone tag (not optimal)
	foreach ($entry[1] as $flavor) {
		if ( strpos( $flavor->tags, 'iphone' ) !== false ) {
			$theurl = $kclient->flavorAsset->getDownloadUrl($flavor->id);
			$size = round($flavor->size/1024,1);
			//$HANDSET='iphone';
			break 2;
		}
	}
case 'ipad':
	foreach ($entry[1] as $flavor) {
		if ( strpos( $flavor->tags, 'ipadnew' ) !== false ) {
			$theurl = $kclient->flavorAsset->getDownloadUrl($flavor->id);
			$size = round($flavor->size/1024,1);
			//$HANDSET='ipad';
			break 2;
		}
	}
case 'blackberry':
default:
	foreach ($entry[1] as $flavor) {
		if ( strpos($flavor->tags, 'mobile') !== false and strpos($flavor->tags, 'mpeg4') !== false  ) {
			$theurl = $kclient->flavorAsset->getDownloadUrl($flavor->id);
			$size = round($flavor->size/1024,1);
			//$HANDSET='other';
			break 2;
		}
	}
	// If nothing matches, use the original source
	$theurl = $kclient->flavorAsset->getDownloadUrl($entry[1][0]->id);
	$size = round($entry[1][0]->size/1024,1);
}


if ($entry[0]->duration < 60) {
	$runtime = $entry[0]->duration;
	$scale = 'seconds';
} elseif ($entry[0]->duration < 600) {
	$runtime = round($entry[0]->duration/60, 1); // show fractions for less than 10 mins
	$scale = 'minutes';
} else {
	$runtime = round($entry[0]->duration/60);
	$scale = 'minutes';
}

$page = 'entry';
include_once('header.php');

//[b]HANDSET: [/b]'.$HANDSET.'[br]
//[b]CLIENT: [/b]'.$_SESSION['client_type'].'[br]
             
echo   '<container>
	     <column>
		       <SEPARATOR/>
		  		       <TEASER>
			<img convert="true" src="'.$entry[0]->thumbnailUrl.'" zoom="true" />
            <richtext align="left">
             [b]Title: [/b]'.$entry[0]->name.'[br]
             [b]Description: [/b]'.$entry[0]->description.'[br]
             [b]Length: [/b]'.$runtime.' '.$scale.'[br]
             [b]Size: [/b]'.$size.' mbytes[br]
             [b]Uploaded on: [/b]'.date("D M j G:i:s T Y", $entry[0]->createdAt).'[br]
             	</richtext>
             	<link href="'.$theurl.'">VIEW/DOWNLOAD NOW</link>
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
  			       <item href="video.php">
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