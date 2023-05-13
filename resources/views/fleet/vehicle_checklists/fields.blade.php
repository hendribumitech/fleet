<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/vehicleChecklists.fields.vehicle_id').':', ['class' => 'col-md-2 col-form-label']) !!}
<div class="col-md-10"> 
    {!! Form::select('vehicle_id', $vehicleItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Checklist Date Field -->
<div class="form-group row mb-3">        
    {!! Form::label('checklist_item', 'Checklist Item', ['class' => 'col-md-2 col-form-label']) !!}
    <div class="col-md-10">
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Checklist</th>
                    <th>Result</th>
                    <th>Description</th>
                </tr>
            </thead>        
            <tbody>
            @foreach ($checklistItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ Form::select('checklist['.$item->id.'][status]', $statusItems, $vehicleChecklistItem[$item->id]->status ?? null, ['class' => 'form-control', 'required' => 'required']) }}</td>
                    <td>{{ Form::textarea('checklist['.$item->id.'][description]', $vehicleChecklistItem[$item->id]->description ?? null, ['class' => 'form-control', 'rows' => 2]) }}</td>
                </tr>    
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Checklist Date Field -->
<div class="form-group row mb-3">
    {!! Form::label('checklist_date', __('models/vehicleChecklists.fields.checklist_date').':', ['class' => 'col-md-2 col-form-label']) !!}
<div class="col-md-10"> 
    {!! Form::text('checklist_date', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'checklist_date']) !!}
</div>
</div>

<!-- Summary Field -->
<div class="form-group row mb-3">
    {!! Form::label('summary', __('models/vehicleChecklists.fields.summary').':', ['class' => 'col-md-2 col-form-label']) !!}
<div class="col-md-10"> 
    {!! Form::textarea('summary', null, ['class' => 'form-control', 'required' => 'required' , 'rows' => 3]) !!}
</div>
</div>
