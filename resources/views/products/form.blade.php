 
<div class="form-group  {{ $errors->has('name') ? 'has-error' : ''}}">
    <?php
        $_field = 'name';
        $_name = 'Name';
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_name,'class' => 'form-control required','data-required'=>$_name)) !!}
    </div>
</div>
<div class="form-group {{ $errors->has('sub_category_id') ? 'has-error' : ''}}">
    <?php
        $_field = 'sub_category_id';
        $_name = 'Category';
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'], false) !!}
    <div>
        {!! Form::select($_field,getSubCategories(),null,['class' => 'form-control required','data-required'=>$_name,'placeholder'=>getPleaseSelect()]) !!}
        {!! $errors->first($_field, '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <?php
        $_field = 'price';
        $_name = 'Price';
    ?>
    {!! Form::label($_field, $_name .' ($)', ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_name,'class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group">
    <?php
        $_field = 'promotion';
        $_name = 'Promotion';
    ?>
    {!! Form::label($_field, $_name.' ($)', ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_name,'class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group  {{ $errors->has('description') ? 'has-error' : ''}}">
    <?php
        $_field = 'description';
        $_name = 'Description';
    ?>
    {!! Form::label($_field, $_name.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::textarea($_field, null, array('placeholder' => $_name,'class' => 'form-control required','data-required'=>$_name)) !!}
    </div>
</div>

<div class="form-group">
  <label>
    <button id="browse-your-file" class="btn btn-info" type="button">Browse your image(s)...</button>
  </label>
  <div id="drag-and-drop" class="drag-and-drop">
    @if(old('photos'))
      @php
        $_incr = 0;
      @endphp
      @foreach(old('photos') as $item)
      @php
        $_name = $item['name'];
        $_path = $item['path'];
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
        <label><input type="radio" name="cover" value="{{ $_name }}"> Cover</label>
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
            <img src="{{ getUrlStorage('products/'.$_name) }}" alt=""/>
            @endif
            <input type="hidden" value="{{ $_name }}" name="photos[{{ $_incr }}][name]">
            <input type="hidden" value="{{ $_name }}" name="photos[{{ $_incr }}][path]">
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
  {!! $errors->first('photos', '<p class="help-block">:message</p>') !!}
  {!! $errors->first('cover', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> {{ _t('Save') }}</button>
    <?php
        $_back = _t('Back');
    ?>
    @if (isset($page))
    <a class="btn btn-danger" href="{{ route('products.index',['page'=>$page]) }}"><i class="fa fa-angle-left"></i> {{ $_back }}</a>
    @else
    <a class="btn btn-danger" href="{{ route('products.index') }}"><i class="fa fa-angle-left"></i> {{ $_back }}</a>
    @endif
</div>
    

@section('script')
<script type="text/javascript">
  file_index = parseInt('<?php echo (isset($_incr) ? $_incr : 0); ?>');
  var _ele = '#browse-your-file';
  $(document).on('click',_ele,function(){
    $('#do-upload-photos').click();
  });
</script>
@endsection
    


