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
use yii\helpers\Url;

$this->registerJs(
  "
  const constraints = {
    audio: false,
    video: {
      width: 480,
      height: 640,
    },
  };

  var hasInvokedRemAvatar = false;

  function invokeRemoveAvatar() {
    $('#btn-remove-capture').on('click', function(e){
      var id = $(this).attr('data-id');
      c = confirm('Are you sure to remove avatar?');
      if (c) {
        if (id) {
          $.ajax({
            type: 'POST',
            url: '".Url::to(["gallery4/api/delete-persistent"])."',
            data: {
              id: id,
            },
            success: function(data){
              if (data.success) {
                $('.avatar-container').find('.file-default-preview *').remove();
                setTimeout(function(){
                  $('.avatar-container').find('.file-default-preview').append('$noPreview');
                }, 200)
              }
            }
          })
        }else {
          $('#avatar-fileinput').val('');
          $('.avatar-container').find('.file-default-preview *').remove();
          setTimeout(function(){
            $('.avatar-container').find('.file-default-preview').append('$noPreview');
          }, 200)
        }
      }
    });
  }

  const tplRemove = `<button type='button' class='btn btn-secondary' data-id='' id='btn-remove-capture' title='Remove'>
      <i class='cil-trash'></i>
    </button>`;

  $('#btn-show-capture').on('click', function(e){
    navigator.mediaDevices.getUserMedia(constraints)
      .then((stream) => {
        // Attach the video stream to the video element and autoplay.
        $('#player')[0].srcObject = stream;
      });
  });

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
          <div class='file-default-preview'>
            <img id='img-avatar' src='\${img}' alt='Avatar'>
          </div>
        </div>
      `;
      $('.file-preview *').remove();
      $('.file-preview').append(tpl);
      $('#modalCaptureImage').modal('hide');
      $('#player').show();
      $('#canvas').hide();

      var hasButtonRemove = $('.avatar-action').children('#btn-remove-capture');
      if (hasButtonRemove.length == 0) {
        $('.avatar-action').append(tplRemove);
      }
      if (!hasInvokedRemAvatar){
        invokeRemoveAvatar();
        hasInvokedRemAvatar = true;
      }
    }, 200);
  });
  invokeRemoveAvatar();
  ",  
    View::POS_READY,
    'capture-image-handler'
);
?>

