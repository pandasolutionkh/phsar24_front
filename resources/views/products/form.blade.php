<div class="form-group">
    <?php
        $_field = 'name';
        $_name = __('Name');
        $_invalid = ($errors->has($_field) ? ' is-invalid' : '');
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_name,'class' => "form-control required $_invalid",'data-required'=>$_name)) !!}
        {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('sub_category_id') ? 'has-error' : ''}}">
    <?php
        $_field = 'sub_category_id';
        $_name = __('Category');
        $_invalid = ($errors->has($_field) ? ' is-invalid' : '');
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'], false) !!}
    <div>
        {!! Form::select($_field,getSubCategories(),null,['class' => "form-control required $_invalid",'data-required'=>$_name,'placeholder'=>getPleaseSelect()]) !!}
        {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <?php
        $_field = 'price';
        $_name = __('Price');
    ?>
    {!! Form::label($_field, $_name, ['class' => 'control-label'],false) !!}
    <div class="input-group">
        @php
          $_opt = array(
            'placeholder' => $_name,
            'class' => 'form-control',
            'aria-describedby'=>"basic-addon-price",
            'autocomplete' => 'off'
          )
        @endphp
        {!! Form::text($_field, null, $_opt) !!}
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon-price">$</span>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
        $_field = 'promotion';
        $_name = __('Promotion');
    ?>
    {!! Form::label($_field, $_name, ['class' => 'control-label'],false) !!}
    <div class="input-group">
        @php
          $_opt = array(
            'placeholder' => $_name,
            'class' => 'form-control',
            'aria-describedby'=>"basic-addon-promotion",
            'autocomplete' => 'off'
          )
        @endphp
        {!! Form::text($_field, null, $_opt) !!}
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon-promotion">$</span>
        </div>
    </div>
</div>

<div class="form-group">
    <?php
        $_field = 'description';
        $_name = __('Description');
        $_invalid = ($errors->has($_field) ? ' is-invalid' : '');
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::textarea($_field, null, array('placeholder' => $_name,'class' => "form-control required $_invalid",'data-required'=>$_name)) !!}
        {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group">
  <label>
    <button id="browse-your-file" class="btn btn-info" type="button">Browse your {{ getLimitUpload() }} image(s)...</button>
  </label>
  @php
  $_invalid_c = ($errors->has('cover') ? ' is-invalid' : '');
  $_invalid_p = ($errors->has('photos') ? ' is-invalid' : '');
  $_cls = '';
  if($_invalid_c or $_invalid_p){
    $_cls = 'is-invalid';
  }
  @endphp
  <div id="drag-and-drop" class="drag-and-drop {{ $_cls }}">
    @if(old('photos'))
      @php
        $_incr = 0;
        $_cover = old('cover');
      @endphp
      @foreach(old('photos') as $item)
      @php
        $_name = $item['name'];
        $_path = $item['path'];
        $_checked = ($_cover == $_name ? 'checked="checked"' : '');
      @endphp
      <div class="file-preview-frame">
        <div class="img">
          <div class="img-preview"> 
            @if(getExtension($_name) == 'pdf')
            <i class="fa fa-file-pdf-o fa-2x"></i>
            @else
            <img src="{{ $_path }}" alt=""/>
            @endif
            <input type="hidden" value="{{ $_name }}" name="photos[{{ $_incr }}][name]">
            <input type="hidden" value="{{ $_path }}" name="photos[{{ $_incr }}][path]">
            <div data-img="{{ $_name }}" class="remove"></div>
          </div>
        </div>
        <label><input type="radio" name="cover" value="{{ $_name }}" {{ $_checked }}> Cover</label>
      </div>
      @php
        $_incr++;
      @endphp
      @endforeach
    @elseif(isset($data) && $data->galleries)
      @php
        $_incr = 0;
      @endphp
      @foreach($data->galleries as $entity)
      @php
        $_checked = ''; 
        $_name = $entity->name;
        $_path = getUrlStorage('products/'.$_name);
        if($entity->is_cover){
          $_checked = 'checked="checked"';
        }
      @endphp
      <div class="file-preview-frame">
        <div class="img">
          <div class="img-preview"> 
            @if(getExtension($_name) == 'pdf')
            <i class="fa fa-file-pdf-o fa-2x"></i>
            @else
            <img src="{{ $_path }}" alt=""/>
            @endif
            <input type="hidden" value="{{ $_name }}" name="photos[{{ $_incr }}][name]">
            <input type="hidden" value="{{ $_path }}" name="photos[{{ $_incr }}][path]">
            <div data-img="{{ $_name }}" class="remove"></div>
          </div>
        </div>
        <label><input type="radio" name="cover" value="{{ $_name }}" {{ $_checked }}> Cover</label>
      </div>
      @php
        $_incr++;
      @endphp
      @endforeach
    @endif
  </div>
  <div hidden="">
    <input type="file" multiple="multiple" id="do-upload-photos" data-type="product">
  </div>
  {!! $errors->first('photos', '<p class="invalid-feedback">:message</p>') !!}
  {!! $errors->first('cover', '<p class="invalid-feedback">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> {{ __('Save') }}</button>
    <?php
        $_back = __('Back');
    ?>
    @if (isset($page))
    <a class="btn btn-danger" href="{{ route('products.index',['page'=>$page,'locale'=>getLang()]) }}"><i class="fa fa-angle-left"></i> {{ $_back }}</a>
    @else
    <a class="btn btn-danger" href="{{ route('products.index',getLang()) }}"><i class="fa fa-angle-left"></i> {{ $_back }}</a>
    @endif
</div>


@section('script')
<script type="text/javascript">
  var limit_upload = parseInt("{!! getLimitUpload() !!}");
  file_index = parseInt('<?php echo (isset($_incr) ? $_incr : 0); ?>');
  var _ele = '#browse-your-file';
  $(document).on('click',_ele,function(){
    $('#do-upload-photos').click();
  });
</script>
@endsection
    


