NProgress.start();

$(document).ready(function(){
	if($('select').length > 0){
		$('select').select2({ width: '100%' });
	}

	$('#confirmDelete').on('show.bs.modal', function (e) {
	    var _target = e.relatedTarget;
	    var _message = $(_target).attr('data-message');
	    $(this).find('.modal-body p').text(_message);
	    var _title = $(_target).attr('data-title');
	    $(this).find('.modal-title').text(_title);

	    setTimeout(function(){
	      // Pass form reference to modal for submission on yes/ok
	      var _formId = $(_target).attr('data-formid');
	      var form = $(e.relatedTarget).closest('form');
	      if(typeof _formId != 'undefined'){
	        form = $('#' + _formId);
	      }
	      $('#confirmDelete .modal-footer #confirm').data('form', form);

	    },200);
	});

	$('#confirmDelete .modal-footer #confirm').on('click', function(){
		var _form = $(this).data('form');
		$(_form).submit();
	});

	$('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover()

  var location = window.location;
  var current_url = location.href;
  if($('.top-menu-right').length > 0){
    $('.top-menu-right a[href=\'' + current_url + '\']').addClass('active');
  }
  
  if($('.menu').length > 0){
    $('.menu a[href=\'' + current_url + '\']').addClass('active');
  }
});


//todo custom javascript

function _is_extension(param_file){
    var _extensions = ["image/png","image/gif","image/jpg","image/jpeg"];
    for(var _ind = 0; _ind < _extensions.length; _ind++){
        var _ext = _extensions[_ind];
        var _type = param_file.type;
        if(_type == _ext){
            return true;
        }
    }
    return false;
}

$(document).on('click','.photo-profile',function(e){
    e.preventDefault();
    var _id_change = $(this).attr('data-change');
    if(typeof _id_change != 'undefined' && _id_change != ''){
      $('#'+_id_change).click();
    }else{
      $('#do-upload').click();
    }
});

$(document).on('change','#do-upload', prepareUpload);
// Grab the files and set them to our variable
function prepareUpload(event){
    var files = event.target.files;
    if(files.length){
        addNewFile(files[0],'.photo-profile');            
    }
}


function addNewFile(obj,ele){
  var _src = URL.createObjectURL(obj);
  var _row = '';
  if(_is_extension(obj)){
    var _ele_img = $(ele + ' img')
    if(_ele_img.length > 0){
      $(ele + ' img').attr('src',_src);
    }else{
      var _img = '<img src="'+_src+'" alt=""/>';
      $(ele).html(_img);
    }
  }else{
      alert('Your file is not support.')
  }
}

$(document).on('click','.photo-cover .photo-remove',function(e){
    e.preventDefault();
    var _th = $(this);
    var _parent = _th.closest('.photo-cover');
    if(_parent.find('.photo-profile').length > 0){
      _parent.find('.photo-profile').html('');
    }

    if(_parent.find('.video-file').length > 0){
      _parent.find('.video-file').html('');
    }
    
    var _file = _th.attr('data-file');
    var _hidden = _th.attr('data-hidden');
    if(typeof _file != 'undefined' && typeof _hidden != 'undefined'){
      $('#'+_file).val('');
      $('input[name="'+_hidden+'"][type="hidden"]').val('');
    }else{
      $('#do-upload').val('');
      $('input[name="photo"][type="hidden"]').val('');
    }
});

$(document).on('change','#do-upload-banner', prepareUploadBanner);
// Grab the files and set them to our variable
function prepareUploadBanner(event){
    var files = event.target.files;
    if(files.length){
        doUpload(files[0],'.photo-profile[data-change="do-upload-banner"]'); 
    }
}

$(document).on('change','#do-upload-thumbnail', prepareUploadThumbnail);
// Grab the files and set them to our variable
function prepareUploadThumbnail(event){
    var files = event.target.files;
    if(files.length){
        doUpload(files[0],'.photo-profile[data-change="do-upload-thumbnail"]'); 
    }
}

function setLoading(){
  if($('#loading').length > 0){
    $('#loading').remove();
    $('.loading-layout').remove();
  }

  var _html = '<div class="loading-layout"></div>';
  _html += '<div class="loading" id="loading">';
  _html += '  <div class="loading-table">';
  _html += '    <div class="loading-row">';
  _html += '      <div class="loading-cell">';
  _html += '        <div class="loading-round">';
  _html += '          <div class="lds-ellipsis">';
  _html += '            <div></div><div></div><div></div><div></div>';
  _html += '          </div>';
  _html += '          <div>Loading <span id="loading-progress"></span></div>';
  _html += '        </div>';
  _html += '      </div>';
  _html += '    </div>';
  _html += '  </div>';
  _html += '</div>';
  $('body').append(_html);
}

function removeLoading(){
  if($('#loading').length > 0){
    $('#loading').remove();
    $('.loading-layout').remove();
  }
}

//image|mimes:jpeg,png,jpg,gif,svg|max:2048
function doUpload(obj,ele){
    var _row = '';
    if(_is_extension(obj)){
        var formData = new FormData();
        formData.append('photo', obj);
        $.ajax({
          type: 'post',
          url: base_url + '/medias/upload',
          headers: {
              'X-CSRF-TOKEN': window.Laravel.csrfToken
          },
          data: formData,
          dataType: 'json',
          processData: false, // Don't process the files
          contentType: false,
          beforeSend: function () {
            
          },
          success: function (res) {
            if(res.result == 'ok'){
              if(typeof res.data.name != 'undefined'){
                var _input = $(ele).attr('data-input');
                $('input[type="hidden"][name="'+_input+'"]').val(res.data.name);
                $('input[type="hidden"][name="'+_input+'_path"]').val(res.data.path);
              }
              var _src = URL.createObjectURL(obj);
              var _ele_img = $(ele + ' img')
              if(_ele_img.length > 0){
                  $(ele + ' img').attr('src',_src);
              }else{
                  var _img = '<div><img src="'+_src+'" alt=""/></div>';
                  $(ele).html(_img);
              }
            }else{
              alert('Please check your file');
            }
          }
        });
    }else{
        alert('Your file is not support.')
    }
}

$(document).on('click','.btn-product-see-more',function(e){
  e.preventDefault();
  $(this).closest('.product-content').addClass('active');
});

//module post
$(document).on('show.bs.modal','#modalPopup',function(e){
  var _target = e.relatedTarget;
  var _this = $(_target);
  var _mthis = $(this);
  var _body = _mthis.find('.modal-body .modal-data');
  _body.html('<p>Please wait for a minute ...</p>');

  setTimeout(function(){
    var _id = _this.data('id');
    axios.get('/product/'+_id).then(response => {
      var _data = response.data;
      var _form = _data.form;
      _body.html(_form);

      $('#viewProduct').carousel({
        pause: true,        // init without autoplay (optional)
        interval: false,    // do not autoplay after sliding (optional)
        wrap:false 
      });
    }).catch(response => {
      console.log(response)
    });
  },200);
});

$(document).on('click','.btn-product-favorite',function(e){
  e.preventDefault();
  var _cls_ho = 'fa-heart-o';
  var _cls_h = 'fa-heart';

  var _th = $(this);
  var _id = _th.attr('data-id');
  var _fa = _th.find('i.fa');
  var _is_fav = 0;
  if(_fa.hasClass(_cls_ho)){
    _is_fav = 1;
  }

  var _params = {
    is_fav : _is_fav
  };
  axios.post('/favorites/dofav/'+_id,_params).then(response => {
    //var _data = response.data;
    if(_is_fav == 1){
      _fa.removeClass(_cls_ho).addClass(_cls_h);
    }else{
      _fa.removeClass(_cls_h).addClass(_cls_ho);
    }
    
  }).catch(response => {
    console.log(response)
  });
});

window.onload = function () { NProgress.done(); }
