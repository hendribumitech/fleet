<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/vehicleDocuments.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->name }}</p>
    </div>
</div>

<!-- Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('number', __('models/vehicleDocuments.fields.number').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->number }}</p>
    </div>
</div>

<!-- Document Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('document_id', __('models/vehicleDocuments.fields.document_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->document_id }}</p>
    </div>
</div>

<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/vehicleDocuments.fields.vehicle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->vehicle_id }}</p>
    </div>
</div>

<!-- Path File Field -->
<div class="form-group row mb-3">
    {!! Form::label('path_file', __('models/vehicleDocuments.fields.path_file').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->path_file }}</p>
    </div>
</div>

<!-- Issued At Field -->
<div class="form-group row mb-3">
    {!! Form::label('issued_at', __('models/vehicleDocuments.fields.issued_at').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->issued_at }}</p>
    </div>
</div>

<!-- Expired At Field -->
<div class="form-group row mb-3">
    {!! Form::label('expired_at', __('models/vehicleDocuments.fields.expired_at').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleDocument->expired_at }}</p>
    </div>
</div>

