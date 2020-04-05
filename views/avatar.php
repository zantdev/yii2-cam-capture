<?php 
use kartik\file\FileInput;
use zantknight\yii\capture\CamCaptureAsset;

$bundle = CamCaptureAsset::register($this);
?>

<div class="avatar-container">
  <?php
  $noPreview = '<img id="img-avatar" src="'.$bundle->baseUrl.'/img/avatar-man-256.png" alt="Avatar">';
  $defaultPreview = $noPreview;
  $btnRemove = "";
  $btnCapture = "<button type='button' class='btn btn-secondary' 
    data-toggle='modal' 
    id='btn-show-capture'
    data-target='#modalCaptureImage'
      title='Add picture tags'>
        <i class='cil-camera'></i>
    </button>";

  if ($preview) {
    $defaultPreview = '<img id="img-avatar" src="'.$preview['url'].'" alt="Avatar">';   
    $btnRemove = "<button type='button' class='btn btn-secondary' 
      data-id='".$preview['id']."'
      id='btn-remove-capture'
        title='Remove'>
          <i class='cil-trash'></i>
      </button>"; 
  }

  echo FileInput::widget([
    'name' => 'avatar',
    'options' => [
      'id' => 'comp-avatar',
      'accept' => 'image/*;capture=camera',
    ],
    'pluginOptions' => [
      'overwriteInitial' => true,
      'showClose' => false,
      'showCaption' => false,
      'showCancel' => false,
      'showBrowse' => false,
      'browseOnZoneClick' => false,
      'removeLabel' => '',
      'browseLabel' => '',
      'removeIcon' => '<i class="cil-trash"></i>',
      'browseIcon' => '<i class="cil-folder-open"></i>',
      'removeTitle'=> 'Cancel or reset changes',
      'elErrorContainer' => '#kv-avatar-errors-2',
      'msgErrorClass' => 'alert alert-block alert-danger',
      'defaultPreviewContent' => $defaultPreview,
      'layoutTemplates' => [
        'main2'=> "{preview}<div class='avatar-action'>$btnCapture $btnRemove</div>"
      ],
      'allowedFileExtensions' => ["jpg", "png"]
    ],
  ]);
  ?>
  <input type="hidden" id="avatar-fileinput" name="avatarCapture" />
</div>

<?= $this->render('modalCaptureImage', ['noPreview'=>$noPreview]); ?>

