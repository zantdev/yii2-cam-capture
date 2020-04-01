<?php 
use kartik\file\FileInput;
use zantknight\yii\capture\CamCaptureAsset;

$bundle = CamCaptureAsset::register($this);
?>
<div class="avatar-container">

  <?php
  $btnCust = "<button type='button' class='btn btn-secondary' 
    data-toggle='modal' 
    id='btn-show-capture'
    data-target='#modalCaptureImage'
      title='Add picture tags'>
        <i class='cil-camera'></i>
    </button>"; 
  // Usage without a model
  echo '<label class="control-label">Upload Document</label>';
  echo FileInput::widget([
    'name' => 'avatar',
    'options' => [
      'accept' => 'image/*;capture=camera',
    ],
    'pluginOptions' => [
      'overwriteInitial' => true,
      'maxFileSize' => 1500,
      'showClose' => false,
      'showCaption' => false,
      'showCancel' => false,
      'showBrowse' => false,
      'browseOnZoneClick' => true,
      'removeLabel' => '',
      'browseLabel' => '',
      'removeIcon' => '<i class="cil-trash"></i>',
      'browseIcon' => '<i class="cil-folder-open"></i>',
      'removeTitle'=> 'Cancel or reset changes',
      'elErrorContainer' => '#kv-avatar-errors-2',
      'msgErrorClass' => 'alert alert-block alert-danger',
      'defaultPreviewContent' => '<img id="img-avatar" src="'.$bundle->baseUrl.'/img/avatar-man-256.png" alt="Avatar">',
      'layoutTemplates' => [
        'main2'=> "{preview}<div class='avatar-action'>$btnCust {remove} {browse}</div>"
      ],
      'allowedFileExtensions' => ["jpg", "png", "gif"]
    ],
  ]);
  ?>
  <input type="hidden" id="avatar-fileinput" />
</div>

<?= $this->render('modalCaptureImage'); ?>