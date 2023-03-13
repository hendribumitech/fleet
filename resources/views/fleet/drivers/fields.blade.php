<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/drivers.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/drivers.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => 20,'maxlength' => 20, 'required' => 'required']) !!}
</div>
</div>

<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/drivers.fields.vehicle_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('vehicle_id', $vehicleItems, null, ['class' => 'form-control select2']) !!}
    </div>
</div>
