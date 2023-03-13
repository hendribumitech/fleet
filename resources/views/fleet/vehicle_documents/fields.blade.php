<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('name', __('models/vehicleDocuments.fields.name').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Number Field -->
<div class="form-group row mb-3">
    {!! Form::label('number', __('models/vehicleDocuments.fields.number').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('number', null, ['class' => 'form-control','maxlength' => 50,'maxlength' => 50, 'required' => 'required']) !!}
</div>
</div>

<!-- Document Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('document_id', __('models/vehicleDocuments.fields.document_id').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::select('document_id', $documentItems, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
</div>
</div>

<!-- Name Field -->
<div class="form-group row mb-3">
    {!! Form::label('file_upload', __('models/vehicleDocuments.fields.file_upload').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9">
    @if (isset($vehicleDocument) && !empty($vehicleDocument->path_file))
    <div>
        <a href="{{ Storage::url('').'?path='.$vehicleDocument->path_file }}"  target="_blank" rel="noopener noreferrer">file attachment</a>
    </div>    
    @endif     
    {!! Form::file('file_upload') !!}    
</div>
</div>

<!-- Issued At Field -->
<div class="form-group row mb-3">
    {!! Form::label('issued_at', __('models/vehicleDocuments.fields.issued_at').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('issued_at', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'issued_at']) !!}
</div>
</div>

<!-- Expired At Field -->
<div class="form-group row mb-3">
    {!! Form::label('expired_at', __('models/vehicleDocuments.fields.expired_at').':', ['class' => 'col-md-3 col-form-label']) !!}
<div class="col-md-9"> 
    {!! Form::text('expired_at', null, ['class' => 'form-control datetime', 'required' => 'required' ,'data-optiondate' => json_encode( ['locale' => ['format' => config('local.date_format_javascript') ]]),'id'=>'expired_at']) !!}
</div>
</div>
