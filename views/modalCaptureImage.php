<div class="modal fade modalCaptureImage" id="modalCaptureImage" tabindex="-1" role="dialog" 
  aria-labelledby="Image Chooser" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Take a picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">  
        <video class="avatar-player" id="player" autoplay></video>
        <canvas width="480" height="640" style="display: none" class="avatar-canvas" id="canvas"></canvas>
        <a href="#" class="btn btn-primary btn-capture" id="capture">Capture</a>
      </div>
    </div>
  </div>
</div>

<?php 
use yii\web\View;

$this->registerJs(
  "
  const constraints = {
    audio: false,
    video: {
      width: 480,
      height: 640,
    },
  };

  $('#btn-show-capture').on('click', function(e){
    navigator.mediaDevices.getUserMedia(constraints)
      .then((stream) => {
        // Attach the video stream to the video element and autoplay.
        $('#player')[0].srcObject = stream;
      });
  })

  $('#capture').on('click', function(e){
    $('#canvas')[0].getContext('2d').drawImage(
      $('#player')[0], 0, 0, $('#player').width(), $('#player').height()
    );
    $('#player')[0].srcObject.getVideoTracks().forEach(track => track.stop());
    $('#player').hide();
    $('#canvas').show();
    setTimeout(function(){
      var img = $('#canvas')[0].toDataURL('image/png');
      $('#avatar-fileinput').val(img);

      var tpl = `
        <div class='file-drop-zone clearfix'>
          <div class='file-preview-thumbnails clearfix'>
            <div class='file-preview-frame krajee-default  kv-preview-thumb' id='thumb-w1-11305_asus-zenpad-c.jpg' data-fileindex='0' data-fileid='11305_asus-zenpad-c.jpg' data-template='image'>
              <div class='kv-file-content'>
                <img class='img-capture' src='\${img}' />
              </div>
            </div>

            <div class='kv-zoom-cache' style='display:none'>
              <div class='file-preview-frame krajee-default  kv-zoom-thumb' id='zoom-thumb-w1-11305_asus-zenpad-c.jpg' data-fileindex='0' data-fileid='11305_asus-zenpad-c.jpg' data-template='image'>
                <div class='kv-file-content'>
                  <img class='img-capture' src='\${img}' />
                </div>
              </div>
            </div>
          </div>
        </div>
      `;
      $('.file-preview *').remove();
      $('.file-preview').append(tpl);
      $('#modalCaptureImage').modal('hide');
      $('#player').show();
      $('#canvas').hide();
    }, 200);
  });
  ",  
    View::POS_READY,
    'capture-image-handler'
);
?>