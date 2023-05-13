<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/vehicleChecklists.fields.vehicle_id').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleChecklist->vehicle_id }}</p>
    </div>
</div>

<!-- Checklist Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('checklist_date', __('models/vehicleChecklists.fields.checklist_date').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $vehicleChecklist->checklist_date }}</p>
    </div>
</div>

