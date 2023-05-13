<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/checklistItems.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $checklistItem->name }}</p>
    </div>
</div>

<!-- Code Field -->
<div class="form-group row mb-3">
    {!! Form::label('code', __('models/checklistItems.fields.code').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        <p>{{ $checklistItem->code }}</p>
    </div>
</div>

