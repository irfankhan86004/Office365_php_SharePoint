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
use Office365\SharePoint\Folder;


class DirectoryController extends Controller
{
    
	private function iniConnection() {
		$webUrl = 'https://codefoundrycoza.sharepoint.com/sites/test';
        $userName = 'admin@codefoundrycoza.onmicrosoft.com';
        $password = 'Cab53252';
		
		$authCtx = new AuthenticationContext($webUrl);
		
		$authCtx->acquireTokenForUser($userName,$password);
		
		$ctx = new ClientContext($webUrl,$authCtx);
		
		return $ctx;
	}
	
	public function index() {
		
		$ctx = $this->iniConnection();
		
		$site = $ctx->getSite();
		$site->setId('comsite');
		$ctx->load($site);

		
		$targetFolderUrl = "Shared Documents/";
		
		$parentFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl);
		$childFolder = $parentFolder->getFolders();
		$ctx->load($childFolder);
		$ctx->executeQuery();
		
		
		$files = $parentFolder->getFiles();
		$ctx->load($files);
		$ctx->executeQuery();
		
		//foreach ($files->getData() as $file) {
		//	print "File name: '{$file->getProperty("ServerRelativeUrl")}'\r\n";
		//}
		//dump($childFolder->getData());exit;
		//foreach ($childFolder->getData() as $file) {
			
			//print "File name: '{$file->getProperty("ServerRelativeUrl")}' <br>";
		//}
		
		
		return view('folders', compact('childFolder', 'targetFolderUrl', 'files'));
		//dump($childFolder);exit;	
		
		
	}
	
	public function open_child(Request $request) {
		
		$ctx = $this->iniConnection();
		
		$site = $ctx->getSite();
		$site->setId('comsite');
		$ctx->load($site);

		
		//echo $request->folderpath;exit;
		
		$targetFolderUrl = $request->folderpath;
		
		//echo $targetFolderUrl;exit;
		
		$parentFolder = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl);
		$childFolder = $parentFolder->getFolders();
		$ctx->load($childFolder);
		$ctx->executeQuery();
		
		
		$files = $parentFolder->getFiles();
		$ctx->load($files);
		$ctx->executeQuery();
		
		return view('_folders', compact('childFolder', 'targetFolderUrl', 'files'));
		
	}
	
	public function tree_view() {


		return view('tree_view');	
	}
	
	public function upload_file(Request $request) {
		
		$file = $request->file('file');
		
		$name= $file->getClientOriginalName();  
		
		$file->move('images',$name);  
		
		
		$ctx = $this->iniConnection();
		
		//$localPath = public_path();
		$targetFolderUrl = "Shared Documents/";
		$targetFolderUrl = str_replace('/sites/test/', '', $request->current_path);
		
		$localPath = public_path();
		$localFilePath = realpath ($localPath . "/images/".$name);
		//$this->uploadFileIntoFolder($ctx,$localFilePath,$targetFolderUrl);
		
		$fileName = basename($localFilePath);
		$fileCreationInformation = new \Office365\PHP\Client\SharePoint\FileCreationInformation();
		$fileCreationInformation->Content = file_get_contents($localFilePath);
		$fileCreationInformation->Url = $fileName;
		$uploadFile = $ctx->getWeb()->getFolderByServerRelativeUrl($targetFolderUrl)->getFiles()->add($fileCreationInformation);
		$ctx->executeQuery();
		
		//print "File {$uploadFile->getProperty('ServerRelativeUrl')} has been uploaded\r\n";

	}
	/*public function index() {
		
		$webUrl = 'https://codefoundrycoza.sharepoint.com/sites/test';
        $userName = 'admin@codefoundrycoza.onmicrosoft.com';
        $password = 'Cab53252';
		
		$authCtx = new AuthenticationContext($webUrl);
		
		$authCtx->acquireTokenForUser($userName,$password);
		
		$ctx = new ClientContext($webUrl,$authCtx);
		
		$localPath = public_path();
		$targetFolderUrl = "Shared Documents/";
		
		//$targetFolderUrl = "/Shared Documents";
		
		
		$this->createSubFolder($ctx,$targetFolderUrl,"lucky100");
		echo 'ed';exit;
		$localFilePath = realpath ($localPath . "/roy.docx");
		$this->uploadFileIntoFolder($ctx,$localFilePath,$targetFolderUrl);
		echo 'ed';exit;

	}*/
	
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
