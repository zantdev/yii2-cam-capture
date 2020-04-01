A HTML5 Camera Capture
======================
This extension is HTML5 Media Capture, integrating with yii2-gallery4

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist zantknight/yii2-cam-capture "*"
```

or add

```
"zantknight/yii2-cam-capture": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \zantknight\yii\capture\CamCaptureWidget::widget(); ?>```