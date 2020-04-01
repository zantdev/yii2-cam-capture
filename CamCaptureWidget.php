<?php

namespace zantknight\yii\capture;

use zantknight\yii\gallery\models\Gallery4;
/**
 * This is just an example.
 */
class CamCaptureWidget extends \yii\base\Widget
{
    public $config;

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
            'attribute' => 'avatarInput'
        ];
    }

    public function run()
    {
        return $this->render('avatar', [
            'config' => $this->config
        ]);
    }
}
