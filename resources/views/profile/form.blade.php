@php
    $_is_invalid = 'is-invalid';
@endphp
<div class="form-group">
    @php
    $_label = __('Photo');
    @endphp
    {!! Form::label('photo', $_label, ['class' => 'control-label']) !!}
    <div class="photo-cover">
        <div class="photo-profile" data-change="do-upload-banner" data-input="photo">
            @if (isset($user) && $user->photo != '')
                <div><img src="{!! getUrlStorage('profiles/'.$user->photo) !!}" alt=""/></div>
            @else
                @if (old('photo_path') != '')
                    <div><img src="{{ old('photo_path')  }}" alt="" /></div>
                @endif
            @endif
        </div>
        <div class="photo-remove" data-file="do-upload-banner" data-hidden="photo">x</div>
        <div class="photo-tooltip">
            (Width 250px and Height166px)
        </div>
    </div>
    <div class="invisible h-1px"> 
    {!! Form::file('photo_file',array('placeholder' => 'Photo','class' => 'form-control','id'=>'do-upload-banner')) !!}
    {{ Form::hidden('photo_path') }}
    {{ Form::hidden('photo') }}
    </div>
</div>

<div class="form-group">
    @php
        $_label = __('Name');
        $_field = 'name';
        $_error = ($errors->has($_field) ? $_is_invalid : '');
    @endphp
    {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_label,'class' => "form-control $_error")) !!}
        {!! $errors->first($_field, '<p class="invalid-feedback">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    @php
        $_label = __('Gender');
    @endphp
    {!! Form::label('gender', $_label, ['class' => 'control-label']) !!}
    <div>
        {!! Form::select('gender',getGenders(),null,['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    @php
        $_label = __('Phone');
        $_field = 'phone';
        $_error = ($errors->has($_field) ? $_is_invalid : '');
    @endphp
    {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => $_label,'class' => "form-control required $_error",'data-required'=>$_label,'id'=>'phone')) !!}
        {!! $errors->first($_field, '<p class="help-block">:message</p>') !!}
    </div>
</div>
        
 <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    @php
        $_label = __('Email');
        $_field = 'email';
        $_error = ($errors->has($_field) ? $_is_invalid : '');
    @endphp
    {!! Form::label($_field, $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
    <div>
        {!! Form::text($_field, null, array('placeholder' => 'Email','class' => "form-control required-or-valid-email $_error",'data-required'=>$_label,'id'=>'email')) !!}
        {!! $errors->first($_field, '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ __('Save') }}</button>
</div>

