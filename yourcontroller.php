<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\httpclient\Client;

class YourController extends Controller
{

    /***
     * 
     * mulitple attachments upload
     */
    public function actionFileUpload()
    { 
     $session = Yii::$app->session;
     $uid = $session->get('userId');
     $multipleAttachmentsUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $preview = $config = $errors = [];
     $input = 'attachment'; // the input name for the fileinput plugin
        if (empty($_FILES[$input])) {
            return [];
        }
     
        $total = count($_FILES[$input]['name']); // multiple files
        $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."socialmedia-attachments/temp/".$multipleAttachmentsUserDirectory."/"; // your upload path
                if(!is_dir($path)) {
                mkdir($path);
            } 
    for ($i = 0; $i < $total; $i++) {
        $tmpFilePath = $_FILES[$input]['tmp_name'][$i]; // the temp file path
        $fileName = $uid."_".date('YmdHis').'_'.$_FILES[$input]['name'][$i]; // the file name
        $fileSize = $_FILES[$input]['size'][$i]; // the file size
     
     //Make sure we have a file path
     if ($tmpFilePath != ""){
         //Setup our new file path
         $newFilePath = $path . $fileName;
         $newFileUrl = Yii::$app->request->hostinfo.Yii::$app->homeurl.'uploads/socialmedia-attachments/temp/'.$multipleAttachmentsUserDirectory.'/'. $fileName;
         
         //Upload the file into the new path
         if(move_uploaded_file($tmpFilePath, $newFilePath)) {
             $fileId = $fileName . $i; // some unique key to identify the file
             $preview[] = $newFileUrl;
             $config[] = [
                 'key' => $fileId,
                 'caption' => $fileName,
                 'size' => $fileSize,
                 'downloadUrl' => $newFileUrl, // the url to download the file
                 'url' => '../permohonan/delete-file', // server api to delete the file based on key
                 'showZoom' => false,
                 
             ];
         } else {
             $errors[] = $fileName;
         }
        } else {
         $errors[] = $fileName;
        }
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
        if (!empty($errors)) {
            $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
            $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
        }
        header('Content-Type: application/json'); // set json response headers
        //$outData = upload(); // a function to upload the bootstrap-fileinput files
        echo json_encode($out); // return json data
        exit(); // terminate
    }


     /***
     * 
     * single attachments upload
     */


    public function actionSingleFileUpload()
    { 
     $session = Yii::$app->session;
     $uid = $session->get('userId');
     $suratRasmiUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $laporanPoliceUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $preview = $config = $errors = [];
     $fileInput = ''; // the input name for the fileinput plugin
     $newFileUrlPath = "";
     $fileName = "";
     $deleteUrl = "";
     $tmpFilePath = "";
     $fileSize = "";
     if (count($_FILES) == 0) {
         return [];
     }
     if(isset($_FILES['PermohonanForm']))
     {
          
         $fileInput = $_FILES['PermohonanForm'];
             if (array_key_exists("surat_rasmi",$fileInput['name']))
             { 
                  $fileName = $uid."_".date('YmdHis').'_'.$fileInput['name']['surat_rasmi'];
                  $tmpFilePath = $fileInput['tmp_name']['surat_rasmi'];
                  $fileSize = $fileInput['size']['surat_rasmi'];
                  $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/temp/surat_rasmi/".$suratRasmiUserDirectory."/";
                  $newFileUrlPath = Yii::$app->request->hostinfo.Yii::$app->homeurl.'uploads/permohonan/temp/surat_rasmi/'.$suratRasmiUserDirectory."/";
                  $deleteUrl = '?url='.$fileName.'&page=socialmedia&type=surat_rasmi';
                  if(!is_dir($path)) {
                     mkdir($path);
                 } 
             }
             if (array_key_exists("laporan_polis",$fileInput['name']))
             {
                 $fileName = $uid."_".date('YmdHis').'_'.$fileInput['name']['laporan_polis'];
                 $tmpFilePath = $fileInput['tmp_name']['laporan_polis'];
                 $fileSize = $fileInput['size']['laporan_polis'];
                  $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/temp/laporan_polis/".$laporanPoliceUserDirectory."/";
                  $newFileUrlPath = Yii::$app->request->hostinfo.Yii::$app->homeurl.'uploads/permohonan/temp/laporan_polis/'.$laporanPoliceUserDirectory."/";
                  $deleteUrl = '?url='.$fileName.'&page=socialmedia&type=laporan_police';
                  if(!is_dir($path)) {
                     mkdir($path);
                 } 
             }
     } 
     else if(isset($_FILES['BlockRequestForm'])){ 
         $fileInput = $_FILES['BlockRequestForm'];
             if (array_key_exists("surat_rasmi",$fileInput['name']))
             {
                  $fileName = $uid."_".date('YmdHis').'_'.$fileInput['name']['surat_rasmi'];
                  $tmpFilePath = $fileInput['tmp_name']['surat_rasmi'];
                  $fileSize = $fileInput['size']['surat_rasmi'];
                  $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/temp/surat_rasmi/".$suratRasmiUserDirectory."/";
                  $newFileUrlPath = Yii::$app->request->hostinfo.Yii::$app->homeurl.'uploads/block-request/temp/surat_rasmi/'.$suratRasmiUserDirectory."/";
                  $deleteUrl = '?url='.$fileName.'&page=blockrequest&type=surat_rasmi';
                  if(!is_dir($path)) {
                     mkdir($path);
                 } 
             }
             if (array_key_exists("laporan_polis",$fileInput['name']))
             {
                 $fileName = $uid."_".date('YmdHis').'_'.$fileInput['name']['laporan_polis'];
                 $tmpFilePath = $fileInput['tmp_name']['laporan_polis'];
                 $fileSize = $fileInput['size']['laporan_polis'];
                  $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/temp/laporan_polis/".$laporanPoliceUserDirectory."/";
                  $newFileUrlPath = Yii::$app->request->hostinfo.Yii::$app->homeurl.'uploads/block-request/temp/laporan_polis/'.$laporanPoliceUserDirectory."/";
                  $deleteUrl = '?url='.$fileName.'&page=blockrequest&type=laporan_police';
                  if(!is_dir($path)) {
                     mkdir($path);
                 } 
             }
     }
     
      // the temp file path
     //$fileName = $uid."_".date('YmdHis').'_'.$fileName; // the file name
     //$fileSize = $fileInput; // the file size
     
     //Make sure we have a file path
     if ($tmpFilePath != ""){
         //Setup our new file path
         $newFilePath = $path . $fileName;
         $newFileUrl = $newFileUrlPath. $fileName;
         
         if(count(glob("$path/*")) > 0)
         { 
             $files = scandir($path);
             $files = array_diff(scandir($path), array('.', '..'));
             $fkey = 0;
             foreach($files as $file){
                 //$uploadedFiles[$fkey]['path'] = $attachmentsUpload.$file;
              unlink($path.$file);
             }
         }
         //Upload the file into the new path
         if(move_uploaded_file($tmpFilePath, $newFilePath)) {
             $fileId = $fileName; // some unique key to identify the file
             $preview[] = $newFileUrl;
             $config[] = [
                 'key' => $fileId,
                 'caption' => $fileName,
                 'size' => $fileSize,
                 'downloadUrl' => $newFileUrl, // the url to download the file
                 'url' => '../permohonan/single-delete-file'.$deleteUrl, // server api to delete the file based on key
                 'showZoom' => false,
                 
             ];
         } else {
             $errors[] = $fileName;
         }
     } else {
         $errors[] = $fileName;
     }
 //}
    $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
    if (!empty($errors)) {
        $img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
        $out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
    }
    header('Content-Type: application/json'); // set json response headers
    //$outData = upload(); // a function to upload the bootstrap-fileinput files
    echo json_encode($out); // return json data
    exit(); // terminate
    }

     /***
     * 
     * Single attachment delete
     */
    public function actionSingleDeleteFile()
    { 
     $session = Yii::$app->session;
     $suratRasmiUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $laporanPoliceUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $file = "";
     if($_GET['page'] == 'socialmedia')
     {
         if($_GET['type'] == 'surat_rasmi')
         { 
             $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/temp/surat_rasmi/".$suratRasmiUserDirectory."/";
             $file = $path.$_GET['url'];
             if(!is_dir($path)) {
                 mkdir($path);
             } 
         }
         else if($_GET['type'] == 'laporan_police')
         { 
             $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/temp/laporan_polis/".$laporanPoliceUserDirectory."/";
             $file = $path.$_GET['url'];
             if(!is_dir($path)) {
                 mkdir($path);
             } 
         }
     }
     if($_GET['page'] == 'blockrequest')
     { 
         if($_GET['type'] == 'surat_rasmi')
         { 
             $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/temp/surat_rasmi/".$suratRasmiUserDirectory."/";
             $file = $path.$_GET['url'];
             if(!is_dir($path)) {
                 mkdir($path);
             } 
         }
         else if($_GET['type'] == 'laporan_police')
         { 
             $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/temp/laporan_polis/".$laporanPoliceUserDirectory."/";
             $file = $path.$_GET['url'];
             if(!is_dir($path)) {
                 mkdir($path);
             } 
         }
         
     }

     $out = [];
     if(unlink($file))
     {
         $out['status'] = 200;
         $out['message'] = 'Successfully deleted';
     }
     else{
         $out['status'] = 404;
         $out['message'] = 'File not found';
     }
     header('Content-Type: application/json'); // set json response headers
     echo json_encode($out); // return json data
     exit();
    }

  /***
     * 
     * mulitple attachments delete
     */
    public function actionDeleteFile()
    { 
     $session = Yii::$app->session;
     $file = "";
     $multipleAttachmentsUserDirectory = $session->get('userId')."_".date('Y_m_d');
     $path = \Yii::getAlias('@webroot')."/". Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."socialmedia-attachments/temp/".$multipleAttachmentsUserDirectory."/";
     if(!is_dir($path)) {
         mkdir($path);
     } 
     if(!empty($_POST['key']))
     { 
     $file = chop($path.$_POST['key'],"0");
     }
     else{
     $file = $path.$_GET['url'];
     }
     
     $out = [];
     if(unlink($file))
     {
         $out['status'] = 200;
         $out['message'] = 'Successfully deleted';
     }
     else{
         $out['status'] = 404;
         $out['message'] = 'File not found';
     }
     header('Content-Type: application/json'); // set json response headers
     echo json_encode($out); // return json data
     exit();
    }
}
?>
