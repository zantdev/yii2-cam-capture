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
Note: Working on with yii2-bootstrap4 only, to shift onto bootstrap4, follow [this instruction](https://www.yiiframework.com/wiki/2556/yii2-upgrading-to-bootstrap-4/)
1. If you have not migrate gallery4 yet, simply execute migration by calling this command
   ```
   php yii migrate --migrationPath=@vendor/zantknight/yii2-gallery4/migrations
   ```
2. Update config/web.php
   ```php
   return [
       ...
       'modules' => [
           'gallery4' => [
                'class' => 'zantknight\yii\gallery\Module',
            ],
       ]
   ]
   ```
3. Put this chunk in params.php
   ```php
    return [
        ...
        'bsVersion' => '4.x',
        ...
    ];
   ```
4. Add this behavior to your model
   ```php
    ...
    use zantknight\yii\capture\CamCaptureBehavior;

    class YourModel extends \yii\db\ActiveRecord
    {
        ...

        public function behaviors()
        {
            return [
                ...
                [
                    'class' => CamCaptureBehavior::className(),
                    'model' => $this,
                    'fieldName' => 'name'
                ]
                ...
            ];
        }
    }
   ```
   - fieldName = which field you want to add as picture filename
5. Put this widget into your view
    ```php
    <?= \zantknight\yii\capture\CamCaptureWidget::widget([
        'ownerModel' => $model
    ]); ?>
    ```
6. Make a folder "media" under @web
7. Viola

Screenshots
- Widget
  ![Widget UI](https://i.postimg.cc/NFgTtCP7/HTML5-capture.png)
- Pop-up Capture
  ![Pop-up Capture](https://i.postimg.cc/W4mgyJ2k/HTML5-capture-pop-up.png)
- Image Captured to widget
  ![Pop-up Capture](https://i.postimg.cc/02TqWzXx/HTML5-capture-captured.png)
