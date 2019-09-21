<div class="row">
    <div class="col-sm-6"> 
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            @php
            $_label = _t('Name');
            @endphp
            {!! Form::label('name', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text('name', null, array('placeholder' => $_label,'class' => 'form-control')) !!}
                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            @php
            $_label = _t('Gender');
            @endphp
            {!! Form::label('gender', $_label, ['class' => 'control-label']) !!}
            <div>
                {!! Form::select('gender',getGenders(),null,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
            @php
            $_label = _t('Phone');
            @endphp
            {!! Form::label('phone', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text('phone', null, array('placeholder' => $_label,'class' => 'form-control required','data-required'=>$_label,'id'=>'phone')) !!}
                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
                
         <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            @php
            $_label = _t('Email');
            @endphp
            {!! Form::label('email', $_label.getRequireStar(), ['class' => 'control-label'],false) !!}
            <div>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control required-or-valid-email','data-required'=>$_label,'id'=>'email')) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="form-group">
            @php
            $_label = _t('Photo');
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
            <div class="invisible"> 
            {!! Form::file('photo_file',array('placeholder' => 'Photo','class' => 'form-control','id'=>'do-upload-banner')) !!}
            {{ Form::hidden('photo_path') }}
            {{ Form::hidden('photo') }}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ _t('Save') }}</button>
        </div>
    </div>
</div>

