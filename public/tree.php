<?php

require_once '../vendor/autoload.php';


use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\Runtime\Auth\NetworkCredentialContext;
use Office365\PHP\Client\SharePoint\ClientContext;


use Office365\PHP\Client\Runtime\Utilities\RequestOptions;
use Office365\PHP\Client\Runtime\ClientRuntimeContext;
use Office365\PHP\Client\SharePoint\File;
use Office365\PHP\Client\SharePoint\SPList;
use Office365\SharePoint\Folder;


function iniConnection() {
	$webUrl = 'https://codefoundrycoza.sharepoint.com/sites/test';
	$userName = 'admin@codefoundrycoza.onmicrosoft.com';
	$password = 'Cab53252';
	
	$authCtx = new AuthenticationContext($webUrl);
	
	$authCtx->acquireTokenForUser($userName,$password);
	
	$ctx = new ClientContext($webUrl,$authCtx);
	
	return $ctx;
}

$ctx = iniConnection();
		
$site = $ctx->getSite();
$site->setId('comsite');
$ctx->load($site);


if(array_key_exists('n',$_REQUEST)) {
	$pName=$_REQUEST['n'];
	
	$targetFolderUrl = "Shared Documents/".$pName.'/';
} else {
	$targetFolderUrl = "Shared Documents/";	
}



$parentFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl);
$childFolder = $parentFolder->getFolders();
$ctx->load($childFolder);
$ctx->executeQuery();

/*foreach ($childFolder->getData() as $file) {
	
	print "File name: '{$file->getProperty("ServerRelativeUrl")}' <br>";
}
exit;*/

?>
[<?php
$pId = "0";
$pName = "";
$pLevel = "";
$pCheck = "";
$pNameName = '';
if(array_key_exists( 'id',$_REQUEST)) {
	$pId=$_REQUEST['id'];
}
if(array_key_exists( 'lv',$_REQUEST)) {
	$pLevel=$_REQUEST['lv'];
}
if(array_key_exists('n',$_REQUEST)) {
	$pName=$_REQUEST['n'];
	//$pNameName = $pName.'/';
}
if(array_key_exists('chk',$_REQUEST)) {
	$pCheck=$_REQUEST['chk'];
}
if ($pId==null || $pId=="") $pId = "0";
if ($pLevel==null || $pLevel=="") $pLevel = "0";
if ($pName==null) $pName = "";
else $pName = $pName.".";

$pId = htmlspecialchars($pId);

$pName = htmlspecialchars($pName);

$i = 1;
foreach ($childFolder->getData() as $folder) {
	
	$nId = $pId.$i;
	
	$folderName = str_replace("/sites/test/Shared Documents/".$pNameName, '', $folder->getProperty("ServerRelativeUrl"));
	echo '{id: "'.$nId.'", name: "'.$folderName.'", isParent: true},';
	//echo "{ id:'".$nId."',	name:'".$folderName."',	isParent:".(( $pLevel < "2" && ($i%2)!=0)?"true":"false").($pCheck==""?"":((($pLevel < "2" && ($i%2)!=0)?", halfCheck:true":"").($i==3?", checked:true":"")))."},";	
	
	$i++;
}
?>]
