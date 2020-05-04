<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\Runtime\Auth\NetworkCredentialContext;
use Office365\PHP\Client\SharePoint\ClientContext;


use Office365\PHP\Client\Runtime\Utilities\RequestOptions;
use Office365\PHP\Client\Runtime\ClientRuntimeContext;
use Office365\PHP\Client\SharePoint\File;
use Office365\PHP\Client\SharePoint\SPList;

class SharePointController extends Controller
{
    
	public function index() {
		
		//$webUrl = 'https://doctest11.sharepoint.com/sites/test101/';
		$webUrl = 'https://doctest11.sharepoint.com/sites/mydevzone';
		$webUrl = 'https://docustreamco.sharepoint.com';
		$userName = 'Dev@DocTest11.onmicrosoft.com';
		$userName = 'dev@doctest11.onmicrosoft.com';
		$userName = 'roy@DocTest11.onmicrosoft.com';
		$userName = 'demo@Docustreamco.onmicrosoft.com';
		$password = 'Vah56389';
		$password = 'P@ss123!';
		$password = 'Vah56389';
		$authCtx = new AuthenticationContext($webUrl);
		
		$authCtx->acquireTokenForUser($userName,$password);
		exit;
		$ctx = new ClientContext($webUrl,$authCtx);
		exit;
		$localPath = public_path();
		$targetLibraryTitle = "Documents";
		$targetFolderUrl = "/mydevzone/Shared Documents/upload_test";
		$targetFolderUrl = "Shared Documents/upload_test/luckyboy";
		$targetFolderUrl = "Shared Documents/";
		//$targetFolderUrl = "/Shared Documents";
		
		
		$this->createSubFolder($ctx,$targetFolderUrl,"luckyboy101");
		echo 'ed';exit;
		$localFilePath = realpath ($localPath . "/roy.docx");
		$this->uploadFileIntoFolder($ctx,$localFilePath,$targetFolderUrl);
		echo 'ed';exit;

	}
	
	public function uploadFileIntoFolder(ClientContext $ctx, $localPath, $targetFolderUrl)
	{
		$fileName = basename($localPath);
		$fileCreationInformation = new \Office365\PHP\Client\SharePoint\FileCreationInformation();
		$fileCreationInformation->Content = file_get_contents($localPath);
		$fileCreationInformation->Url = $fileName;


		$uploadFile = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl)->getFiles()->add($fileCreationInformation);
		$ctx->executeQuery();
		print "File {$uploadFile->getProperty('ServerRelativeUrl')} has been uploaded\r\n";

		//$uploadFile->getListItemAllFields()->setProperty('Title', $fileName);
		//$uploadFile->getListItemAllFields()->update();
		//$ctx->executeQuery();
	}
	
	public function createSubFolder(ClientContext $ctx,$parentFolderUrl,$folderName){

		$site = $ctx->getSite();
		$site->setId('comsite');
		$ctx->load($site);
		
		
		//dump($site->getId());exit;
		
		$files = $ctx->getWeb()->getFolderByServerRelativeUrl($parentFolderUrl)->getFiles();
		$ctx->load($files);
		$ctx->executeQuery();
		//print files info
		/* @var $file File */
		foreach ($files->getData() as $file) {
			print "File name: '{$file->getProperty("ServerRelativeUrl")}'\r\n";
		}


		$parentFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($parentFolderUrl);
		$childFolder = $parentFolder->getFolders()->add($folderName);
		$ctx->executeQuery();
		print "Child folder {$childFolder->getProperty("ServerRelativeUrl")} has been created ";
	}
	
	
}
