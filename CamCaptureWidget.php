<?php

namespace zantknight\yii\capture;

use yii\helpers\Url;
use yii\helpers\StringHelper;
use zantknight\yii\gallery\models\Gallery4;
use zantknight\yii\gallery\models\GalleryOwner;

/**
 * This is just an example.
 */
class CamCaptureWidget extends \yii\base\Widget
{
    public $config;
    public $ownerModel;
    public function init(){
        parent::init();

        $this->config = [
            'options' => [
                'accept' => 'image/*',
            ],
            'pluginOptions' => [
                'showCancel' => false,
                'showRemove' => false,
            ],
            'model' => new Gallery4(),
            'attribute' => 'avatarInput',
        ];
    }

    public function run()
    {
        $preview = null;
        if ($this->ownerModel) {
            if (!$this->ownerModel->isNewRecord) {
                $preview = $this->getData();
            }
        }
        return $this->render('avatar', [
            'config' => $this->config,
            'preview' => $preview
        ]);
    }

    public function getData() {
        $ret = [];

        $gallery = Gallery4::find()->joinWith('go')->where([
            'owner_id' => strval($this->ownerModel->primaryKey),
            'model' => StringHelper::basename(
                $this->ownerModel::className()
            ),
            'gallery_4.category' => 'CAMCAPTURE'
        ])->one();
        
        if ($gallery) {
            $fileUrl = Url::to(
                "@web/media/$gallery->name.$gallery->ext", 
                true
            );
            $ret = [
                'id' => $gallery->id,
                'model' => $gallery->go[0]->model,
                'title' => $gallery->title,
                'file_size' => $gallery->file_size,
                'url' => $fileUrl
            ];
        }

        return $ret;
    }
}
