<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/vehicleOdoometers.fields.vehicle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleOdoometer->vehicle_id }}</p>
    </div>
</div>

<!-- Odoometer Field -->
<div class="form-group row mb-3">
    {!! Form::label('odoometer', __('models/vehicleOdoometers.fields.odoometer').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleOdoometer->odoometer }}</p>
    </div>
</div>

