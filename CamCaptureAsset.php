<?php 
namespace zantknight\yii\capture;

use yii\web\AssetBundle;

class CamCaptureAsset extends AssetBundle 
{
    public $sourcePath = __DIR__."/assets/dist";
    public $js = [
    ];
    
    public $css = [
        'css/main.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}

?>
