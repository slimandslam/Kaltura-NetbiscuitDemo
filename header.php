<?php
/**
 * header.php
 *
 * The header menu and BiscuitML
 *
 * PHP version 5
 *
 * @author     Jason Levitt
 * @copyright  2011, Kaltura Inc
 */

$ishome = '';
$isvideo = '';
$isimage = '';
$isaudio = '';
switch ($page) {
			case "photo":
			$isimage = 'active="true"';
			break;
			case "video":
			$isvideo = 'active="true"';
			break;
			case "audio":
			$isaudio = 'active="true"';
			break;
			default:
			$ishome = 'active="true"';
}
header("Content-Type: text/xml;");
echo '<?xml version="1.0" encoding="iso-8859-1" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://www.netbiscuits.com/schema/netbiscuits.xsd" title="demo" xmlns:nb="http://www.emoveo.de/netbiscuits" paging="true">
<styles>
		    <style name="link-color" value="#D90000"/>
   </styles>
   <container>
	     <column>
		       <IMAGEHEADER fillcolor="FFFFFF" boxing="3">
            <styles>
				           <style name="bgcolor" value="#FFFFFF"/>
			         </styles>
            <img src="./res/generic-header-image.jpg" href="about.php" alt="home"/>
         </IMAGEHEADER>
		       <BUTTONMENU>
            <styles>
               <style name="bgcolor" value="#d90000"/>
               <style name="active-color" value="#cccccc"/>
               <style name="active-bgcolor" value="#d90000"/>
               <style name="inactive-color" value="#FFFFFF"/>
               <style name="inactive-bgcolor" value="#d90000"/>
   		       </styles>';

if ($page == 'entry') {
    echo '<items></items>';
    } else {
echo  '<items>
	  			       <item '.$ishome.'>
	  				           <link href="home.php">home</link>
	  			         </item>
	  			         <item '.$isvideo.'>
	  				           <link href="video.php">video</link>
	  			         </item>
	  			         <item '.$isaudio.'>
	  				           <link href="audio.php">audio</link>
	  			         </item>
	  			         <item '.$isimage.'>
	  				           <link href="image.php">photo</link>
	  			         </item>
			         </items>';
			   }

echo  '</BUTTONMENU>
		       <SEPARATOR>
            <hr/>
         </SEPARATOR>
	     </column>
   </container>';

?>