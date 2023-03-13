<!-- Registration Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('registration_number', __('models/vehicles.fields.registration_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('registration_number', null, ['class' => 'form-control','maxlength' => 20,'maxlength' => 20, 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/vehicles.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Merk Field -->
<div class="form-group row mb-3">
    {!! Form::label('merk', __('models/vehicles.fields.merk').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('merk', null, ['class' => 'form-control','maxlength' => 30,'maxlength' => 30, 'required' => 'required']) !!}
</div>
</div>

<!-- Engine Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('engine_number', __('models/vehicles.fields.engine_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('engine_number', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Identity Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('identity_number', __('models/vehicles.fields.identity_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('identity_number', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Owner Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('owner_name', __('models/vehicles.fields.owner_name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('owner_name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
</div>
</div>

<!-- Registration Year Field -->
<div class="form-group row mb-3">
    {!! Form::label('registration_year', __('models/vehicles.fields.registration_year').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('registration_year', null, ['class' => 'form-control','maxlength' => 4,'maxlength' => 4, 'required' => 'required']) !!}
</div>
</div>

<!-- Purchase Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('purchase_date', __('models/vehicles.fields.purchase_date').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('purchase_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'purchase_date']) !!}
</div>
</div>

<!-- Vehicle Ownership Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_ownership_number', __('models/vehicles.fields.vehicle_ownership_number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('vehicle_ownership_number', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>
