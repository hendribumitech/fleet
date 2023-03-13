<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/maintenances.fields.vehicle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $maintenance->vehicle_id }}</p>
    </div>
</div>

<!-- Start Field -->
<div class="form-group row mb-3">
    {!! Form::label('start', __('models/maintenances.fields.start').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $maintenance->start }}</p>
    </div>
</div>

<!-- End Field -->
<div class="form-group row mb-3">
    {!! Form::label('end', __('models/maintenances.fields.end').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $maintenance->end }}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/maintenances.fields.description').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $maintenance->description }}</p>
    </div>
</div>

