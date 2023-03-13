<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/drivers.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $driver->name }}</p>
    </div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/drivers.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $driver->code }}</p>
    </div>
</div>

