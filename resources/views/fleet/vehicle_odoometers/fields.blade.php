<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/vehicleOdoometers.fields.vehicle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('vehicle_id', $vehicleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Odoometer Field -->
<div class="form-group row mb-3">
    {!! Form::label('odoometer', __('models/vehicleOdoometers.fields.odoometer').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('odoometer', null, ['class' => 'form-control inputmask', 'required' => 'required', 'data-unmask' => 1, 'data-optionmask' => json_encode( config('local.number.decimal1'))]) !!}
</div>
</div>
