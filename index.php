<?php

/* @var $this yii\web\View */

namespace app\widgets;
namespace kartik\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\file\FileInput;


?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>

<div class="container-fluid">
    

           <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options' => ['enctype' => 'multipart/form-data']]); ?>
                   
  <h5 class="m-t-20"style="color:#337ab7"> URL Terbabit / Email / Nama Pengguna Social Media / Etc.</h5>
      <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
					  	<label>Image1</label>
                <?= $form->field($model, 'image1')->widget(FileInput::classname(), ['pluginOptions' => [
                                                                'uploadUrl' => Url::to(['yourcontroller/single-file-upload']),
                                                                'maxFileCount' => 10,
                                                                'allowedFileExtensions'=> ['jpg','jpeg', 'png', 'gif', 'pdf','doc','docx'],
                                                                'uploadAsync' => false,
                                                                'overwriteInitial' => true,
                                                                'initialPreviewAsData' => true,
                                                                'showUpload' => false,
                                                                'showRemove' => false,
                                                                'showCaption' => false,
                                                              ]])->label(false);?>  
						    <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <!--<div id="fileList"></div>   -->                  
				  	</div>
          </div>
</div>
  <!--Laporan Polis-->   
  <div class="row">       
          <div class="col-md-6">
            <div class="form-group">
					  	<label>Image2</label>
              <?= $form->field($model, 'laporan_pimage2')->widget(FileInput::classname(), ['pluginOptions' => [
                                                                'uploadUrl' => Url::to(['yourcontroller/single-file-upload']),
                                                                'maxFileCount' => 10,
                                                                'allowedFileExtensions'=> ['jpg','jpeg', 'png', 'gif', 'pdf','doc','docx'],
                                                                'uploadAsync' => false,
                                                                'overwriteInitial' => true,
                                                                'initialPreviewAsData' => true,
                                                                'showUpload' => false,
                                                                'showRemove' => false,
                                                                'showCaption' => false,
                                                              ]])->label(false);?>
						     <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>
               </div>      
				  	</div>
          </div>
        
<br>
          <div class="row">
            <div class="col-md-6">
            ` <div class="form-group">
                          <label>multiple attachments</label>
                            <?php 
                            echo FileInput::widget([
                                'name' => 'attachment[]',
                                'id' => 'attachment',
                                'options'=>[
                                      'multiple'=>true
                                  ],
                                'pluginOptions' => [
                                  
                                    'uploadUrl' => Url::to(['yourcontroller/file-upload']),
                                    'maxFileCount' => 10,
                                    'allowedFileExtensions'=> ['jpg','jpeg', 'png', 'gif', 'pdf','doc','docx'],
                                    'uploadAsync' => false,
                                    'overwriteInitial' => false,
                                    'initialPreviewAsData' => true,
                                    'showUpload' => false,
                                    'showRemove' => false,
                                    'showCaption' => false,
                                  ],
                                ]);
                            ?>
                </div>` 
            </div>
          </div>
            

               

    <?php ActiveForm::end(); ?>
            </div>
          </div>
       
    </div>
</div>

