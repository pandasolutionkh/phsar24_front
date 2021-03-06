NProgress.start();

function is_touch_device() {
 return (('ontouchstart' in window)
      || (navigator.MaxTouchPoints > 0)
      || (navigator.msMaxTouchPoints > 0));
}

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
  $('[data-toggle="collapse"]').collapse();

  var _click_or_touch = 'click';
  if(is_touch_device()){
    _click_or_touch = 'touchend'
  }


  $(document).on(_click_or_touch, function (e){
    /* bootstrap collapse js adds "in" class to your collapsible element*/
    var menu_opened = $('#navbarSupportedContent').hasClass('show');
    if(!$(e.target).closest('#navbarSupportedContent').length &&
        !$(e.target).is('#navbarSupportedContent') &&
        menu_opened === true){
            $('#navbarSupportedContent').collapse('toggle');
    }

  });

  var location = window.location;
  var current_url = location.href;
  if($('.top-menu-right').length > 0){
    $('.top-menu-right a[href=\'' + current_url + '\']').addClass('active');
  }
  
  if($('.menu').length > 0){
    $('.menu a[href=\'' + current_url + '\']').addClass('active');
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
    var _url = _this.data('url');
    axios.get(_url).then(response => {
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
  var _url = _th.attr('data-url');
  var _fa = _th.find('i.fa');
  var _is_fav = 0;
  if(_fa.hasClass(_cls_ho)){
    _is_fav = 1;
  }

  var _params = {
    is_fav : _is_fav
  };
  axios.post(_url,_params).then(response => {
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

$(document).on('click','a.share',function(e){
  e.preventDefault();
  var $link   = $(this);
  var href    = $link.attr('href');
  var network = $link.data('network');
  
  href += '&display=popup&kid_directed_site=0&app_id='+fb_app_id;
  var networks = {
      facebook : { width : 600, height : 300 },
      twitter  : { width : 600, height : 254 },
      google   : { width : 515, height : 490 },
      linkedin : { width : 600, height : 473 }
  };

  var popup = function(network){
    var _height = networks[network].height;
    var _width = networks[network].width;
      //var _options = 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height='+_height+',width='+_width;
      var _options = 'height='+_height;
      _options += ', width='+_width;
      _options += ', top=' + ($(window).height() / 2 - (_height/2));
      _options += ', left=' + ($(window).width() / 2 - ((_width/2)));
      _options += ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0';

      window.open(href, 'fbShareWindow', _options);
  }

  popup(network);
});

/*
* Multiple uploads
*/
function getFileExtension(filename)
{
  var ext = /^.+\.([^.]+)$/.exec(filename);
  return ext == null ? "" : ext[1];
}

//todo upload multip photo
var file_index = 0;

function getLimitUpload(){
  return (typeof limit_upload != 'undefined' ? limit_upload : 1);
}

function getCountFile(){
  return file_index;
}

$(document).on('change','#do-upload-photos', prepareUploadPhotos);

// Grab the files and set them to our variable
function prepareUploadPhotos(event){
    event.preventDefault();
    var _th = $(this);
    var _files = event.target.files;
    var formData = new FormData();
    
    if (_files) {
        var _count_file = getCountFile();
        if(_count_file == getLimitUpload()){
          return false;
        }
        $.each(_files, function (key, value){
          if( _is_extension(value) ){
            if(_count_file >= getLimitUpload()){
              return false;
            }
            formData.append("photos["+key+"]", value);
            _count_file++;
          }
        });
    }else{
        alert("You don't select file.");
        return;
    }

    var _type = _th.data('type');
    if(typeof _type != 'undefined'){
      formData.append("type", _type);
    }else{
      formData.append("type", 'product');
    }
    
    $.ajax({
        type: 'post',
        url: base_url+'/medias/upload_photos',
        data: formData,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': window.Laravel.csrfToken
        },
        processData: false, // Don't process the files
        contentType: false,
        beforeSend: function () {
            photoLoading();
        },
        success: function (res) {
          var _browses = $('.file-preview-frame .loading');
          if(typeof res.data != 'undefined'){
            var _data = res.data;
            for( var _ind = 0; _ind < _data.length; _ind++ ){
              var _item = _data[_ind];

              var _html = '<div class="file-preview-frame">';
              _html += ' <div class="img">';
              _html += '  <div class="img-preview">';
              var _ext = getFileExtension(_item.name);
              if(_ext == 'pdf'){
                _html += '    <div class="fa fa-file-pdf-o fa-2x"></div>';
              }else{
                _html += '    <img src="'+ _item.path + '" alt=""/>';
              }
              _html += '      <input type="hidden" value="'+ _item.name +'" name="photos['+file_index+'][name]"/>';
              _html += '      <input type="hidden" value="'+ _item.path +'" name="photos['+file_index+'][path]"/>';
              _html += '      <div data-img="'+ _item.name +'" class="remove"></div>';
              _html += '    </div>';
              _html += '  </div>';
              _html += '  <label><input type="radio" value="'+ _item.name +'" name="cover"/> Cover</label>';
              _html += '</div>';
              
              $('#drag-and-drop').append(_html);
              file_index++;

            }
            //todo reset value
            $('#do-upload-photos').attr({ value: '' }); 
          }

          if(typeof res.errors != 'undefined'){
            for( var _ind = 0; _ind < res.errors.length; _ind++ ){
              console.log(res.errors[_ind]);
            }
          }
        },
        complete: function () {
            photoRemoveLoading();
        },
        error: function(){
            photoRemoveLoading();
        }
    });
}

function photoLoading() {
    $('#drag-and-drop').append('<div class="dad-loading">&nbsp;</div>');
}

function photoRemoveLoading(){
  $('#drag-and-drop .dad-loading').remove();
}

$(document).on('click','.file-preview-frame .remove',function(e){
    var _th = $(this);
    _th.closest('.file-preview-frame').remove();
    file_index--;
});

function updateSelect2(obj){
  obj.select2({ width: '100%' });
}


window.onload = function () { NProgress.done(); }

