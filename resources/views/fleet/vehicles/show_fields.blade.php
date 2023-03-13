<!-- Registration Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('registration_number', __('models/vehicles.fields.registration_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->registration_number }}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/vehicles.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->name }}</p>
    </div>
</div>

<!-- Merk Field -->
<div class="form-group row mb-3">
    {!! Form::label('merk', __('models/vehicles.fields.merk').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->merk }}</p>
    </div>
</div>

<!-- Engine Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('engine_number', __('models/vehicles.fields.engine_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->engine_number }}</p>
    </div>
</div>

<!-- Identity Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('identity_number', __('models/vehicles.fields.identity_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->identity_number }}</p>
    </div>
</div>

<!-- Owner Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('owner_name', __('models/vehicles.fields.owner_name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->owner_name }}</p>
    </div>
</div>

<!-- Registration Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('registration_year', __('models/vehicles.fields.registration_year').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->registration_year }}</p>
    </div>
</div>

<!-- Purchase Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('purchase_date', __('models/vehicles.fields.purchase_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->purchase_date }}</p>
    </div>
</div>

<!-- Vehicle Ownership Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_ownership_number', __('models/vehicles.fields.vehicle_ownership_number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicle->vehicle_ownership_number }}</p>
    </div>
</div>

