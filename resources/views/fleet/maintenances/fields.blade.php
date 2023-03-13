<!-- Vehicle Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('vehicle_id', __('models/maintenances.fields.vehicle_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('vehicle_id', $vehicleItems, null, ['class' => 'form-control select2', 'required' =>
        'required']) !!}
    </div>
</div>

<!-- Odometer Field -->
<div class="form-group row mb-3">
    {!! Form::label('odometer', __('models/maintenances.fields.odometer').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">        
        {!! Form::text('odometer', null, ['class' => 'form-control inputmask', 'required' => 'required', 'data-unmask' => 1, 'data-optionmask' => json_encode( config('local.number.decimal1') )]) !!}
    </div>
</div>


<!-- Categories Id Field -->
<div class="form-group row mb-3">
    {!! Form::label('categories_id', __('models/maintenances.fields.categories_id').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::select('categories_id', $categoryItems, null, ['class' => 'form-control select2', 'required' =>
        'required']) !!}
    </div>
</div>


<!-- Start Field -->
<div class="form-group row mb-3">
    {!! Form::label('start', __('models/maintenances.fields.start').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('start', null, ['class' => 'form-control datetime', 'required' => 'required', 'data-unmask' => 1 ,'data-optiondate'
        => json_encode( array_merge(['maxDate' => localFormatDateTime( \Carbon\Carbon::now()) ],
        config('local.datetime'))),'id'=>'start']) !!}
    </div>
</div>
@if ($end)
<!-- End Field -->
<div class="form-group row mb-3">
    {!! Form::label('end', __('models/maintenances.fields.end').':', ['class' => 'col-md-3 col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::text('end', null, ['class' => 'form-control datetime', 'required' => 'required', 'data-unmask' => 1 ,'data-optiondate' =>
        json_encode( array_merge(['maxDate' => localFormatDateTime( \Carbon\Carbon::now()) ],
        config('local.datetime'))),'id'=>'end']) !!}
    </div>
</div>
@include('fleet.maintenances.service_fields')
@include('fleet.maintenances.sparepart_fields')
@endif

<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('description', __('models/maintenances.fields.description').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'required' => 'required']) !!}
    </div>
</div>

@push('scripts')
    <script type="text/javascript">        

        function addRowSelect2(_elm){
            const _tr = $(_elm).closest('tr')
            _tr.find('select.select2').select2('destroy')
            main.addRow($(_elm), reinitSelect2 )
        }
        function reinitSelect2(_newTr){
            _newTr.find('.is-valid').removeClass('is-valid')
            main.initSelect(_newTr.closest('tbody'))
            _newTr.find('select,input').prop('required',1)
            main.initInputmask(_newTr)
            updateIndexNameElement(_newTr)
        }
        
        function updateIndexNameElement(_newTr){
            let _index = _newTr.data('index').toString()
            
            let _tmpIndex = _index.split('_')
            let _newIndex = [_tmpIndex[0],parseInt(_tmpIndex[1]) + 1].join('_')            
            
            let _name, _indexElement
            
            _newTr.find('input, select, textarea').each(function(){
                _name = $(this).attr('name')
                _indexElement = getFirstIndexArray(_name)
                $(this).attr('name', _name.replaceAll(_indexElement, _newIndex));
            })
            _newTr.attr('data-index', _newIndex)            
        }

        function getFirstIndexArray(str){            
            let _tmp = str.split('][')
            let _index = _tmp[0].split('[')
            return _index[1]
        }
    </script>
@endpush