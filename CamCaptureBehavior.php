<?php 
namespace zantknight\yii\capture;

use Yii;
use yii\helpers\FileHelper;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;
use yii\base\Exception;
use zantknight\yii\gallery\models\Gallery4;
use zantknight\yii\gallery\models\GalleryOwner;

class CamCaptureBehavior extends Behavior 
{
    public $model = null;
    public $fieldName = null;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'updateCreateOwnerModel',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateCreateOwnerModel',
            // ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteOwnerModel',
        ];
    }

    public function updateCreateOwnerModel($event) 
    {
        $avatarImageBlob = Yii::$app->request->post('avatarCapture');
        if ($avatarImageBlob) {
            $ext = "png";
            $name = "";
            $gallery = null;
            $newGallery = true;
            
            if ($event->name == 'afterUpdate') {
                $gallery = Gallery4::find()->joinWith('go')->where([
                    'owner_id' => strval($this->model->primaryKey),
                    'model' => StringHelper::basename(
                        $this->model::className()
                    ),
                    'category' => 'CAMCAPTURE'
                ])->one();
                if ($gallery) {
                    $newGallery = false;
                    $name = $gallery->generateName(32);
                    $this->generateImageFile($avatarImageBlob, $name, $ext, false, $gallery);
                }
            }
            
            if ($newGallery) {
                $gallery = new Gallery4();
                $name = $gallery->generateName(32);
                $this->generateImageFile($avatarImageBlob, $name, $ext, true, null);
            }

            $gallery->type = "image/png";
            $gallery->ext = $ext;
            $size = $this->getBase64ImageSize($avatarImageBlob);
            $gallery->file_size = $size;
            if ($this->fieldName) {
                $gallery->title = $this->model[$this->fieldName];
            }
            $gallery->name = $name;
            $gallery->category = "CAMCAPTURE";
            $gallery->created_at = date('Y-m-d H:i:s');
            if ($gallery->save()) {
                if ($newGallery) {
                    $galleryOwner = new GalleryOwner();
                    $galleryOwner->owner_id = strval($this->model->primaryKey);
                    $galleryOwner->gallery_id = $gallery->id;
                    $galleryOwner->model = StringHelper::basename(
                        $this->model::className()
                    );
                    $galleryOwner->created_at = date('Y-m-d H:i:s');
                    $galleryOwner->save();
                }
            }
        }
    }

    public function getBase64ImageSize($base64Image) { //return memory size in B, KB, MB
        try{
            $size_in_bytes = (int) (strlen(rtrim($base64Image, '=')) * 3 / 4);
            // $size_in_kb    = $size_in_bytes / 1024;
            // $size_in_mb    = $size_in_kb / 1024;
            return $size_in_bytes;
        }
        catch(Exception $e){
            return $e;
        }
    }

    private function generateImageFile($avatarImageBlob, $name, $ext, 
        $isNewRecord = true, $gallery = null
    ) {
        if (!$isNewRecord && $gallery) {
            $filePath = Yii::$app->basePath."/web/media/".
                $gallery->name.".".$gallery->ext;
            FileHelper::unlink($filePath);
        }
        $destPath = Yii::$app->basePath."/web/media/".$name.".".$ext;
        $physicalFile = fopen($destPath, "w");
        $data = $avatarImageBlob;
        $data = str_replace("data:image/png;base64,", "", $avatarImageBlob);
        fwrite($physicalFile, base64_decode($data));
        fclose($physicalFile);
    }
}
?>