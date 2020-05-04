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

class HomeController extends Controller
{
    
	public function index() {
		
		$webUrl = 'https://portal.office365.com';
		$userName = 'Dev@DocTest11.onmicrosoft.com';
		$password = 'Vah56389';
		$authCtx = new AuthenticationContext($webUrl);
		
		$authCtx->acquireTokenForUser($userName,$password);
		$ctx = new ClientContext($webUrl,$authCtx);
echo 'ed';exit;
		echo $localFilePath = public_path()."/test.docx";exit;
		$targetFileUrl = "Documents/user guide.docx";
		$fileContent = file_get_contents($localFilePath);
		File::saveBinary($ctx,$targetFileUrl,$fileContent);
		print "File has been uploaded\r\n";

	}
	
	public function indexOne() {
		
		
		$webUrl = 'https://doctest11.sharepoint.com';
		$userName = 'Dev@DocTest11.onmicrosoft.com';
		$password = 'Vah56389';
		
		$authCtx = new AuthenticationContext($webUrl);
		$authCtx->acquireTokenForUser($userName,$password);
		$ctx = new ClientContext($webUrl,$authCtx);

		//$localFilePath = public_path()."/test.docx"
		$localPath = public_path();
		$targetLibraryTitle = "Documents";
		$targetFolderUrl = "/mydevzone/Shared Documents/upload_test";
		$targetFolderUrl = "/test101/Shared Documents";

		//$list = ListExtensions::ensureList($ctx->getWeb(),$targetLibraryTitle, \Office365\PHP\Client\SharePoint\ListTemplateType::DocumentLibrary);

		//Break role inheritance on the file.
		$fileUrl = "test.docx";
		$file = $ctx->getWeb()->getFileByServerRelativeUrl($fileUrl);
		
		
		$listItem = $file->getListItemAllFields();
		//$listItem->breakRoleInheritance(false);
		$ctx->executeQuery();

		//get role definition
		$roleDefs = $ctx->getWeb()->getRoleDefinitions();
		$ctx->load($roleDefs);
		$ctx->executeQuery();


		//get site users
		$siteUsers = $ctx->getWeb()->getSiteUsers();
		$ctx->load($siteUsers);
		$ctx->executeQuery();
		
		//Add the new role assignment for the user on the file
		$targetRole = $roleDefs->findFirst("Name","Edit");
		$targetUser = $siteUsers->findFirst("Title","Dev@DocTest11.onmicrosoft.com");
		//$listItem->getRoleAssignments()->addRoleAssignment($targetUser->getProperty("Id"),$targetRole->getProperty("Id"));
		$ctx->executeQuery();
		
		
		/*$folderUrl = "upload_test";
		$fileUrl = "http://127.0.0.1/office365/blog/public/test.docx";
		$file = $ctx->getWeb()->getFolders()->getByUrl($folderUrl)->getFiles()->getByUrl($fileUrl);
		
		dump($file);exit;
		$ctx->load($file);
		$ctx->executeQuery();
		print "File name: '{$file->getProperty("Name")}'\r\n";
	
		print ("Done");exit;*/
		
		$this->createSubFolder($ctx,$targetFolderUrl,"2001");
		
		//uploadFiles($localPath,$list);
		
		//$localFilePath = realpath ($localPath . "/test.docx");
		//$this->uploadFileIntoFolder($ctx,$localFilePath,$targetFolderUrl);
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
