<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('sparepart', __('models/maintenances.fields.spareparts').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sparepart</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>                
                @if (!$spareparts->isEmpty())
                    @foreach ($spareparts as $sparepart)
                    <tr data-index="{{ $tmpIndex }}">
                        <td width="60%">{!! Form::select('spareparts['.$sparepart->id.'][sparepart_id]',[$sparepart->sparepart_id => $sparepart->sparepart->name],
                            $sparepart->sparepart_id, array_merge(['class' => 'form-control
                            select2','data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' =>
                            'Fleet\\SparepartRepository'], config('local.select2.ajax')) ) !!} </td>
                        <td>{!! Form::text('spareparts['.$sparepart->id.'][quantity]', $sparepart->quantity, ['class' =>
                            'form-control inputmask', 'data-unmask' => 1, 'data-optionmask' => json_encode( config('local.number.decimal1') )])
                            !!} </td>
                        <td>
                            @if ($loop->last)
                            <button onclick="addRowSelect2(this)" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i></button>
                            @else
                            <button onclick="main.removeRow(this)" class="btn btn-primary btn-sm"><i
                                    class="fa fa-minus"></i></button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                <tr data-index="{{ $tmpIndex }}">
                    <td width="60%">{!! Form::select('spareparts['.$tmpIndex.'][sparepart_id]', [], null, array_merge(['class' => 'form-control
                        select2','data-filter' => json_encode([]), 'data-url' => route('selectAjax'), 'data-repository' =>
                        'Fleet\\SparepartRepository'], config('local.select2.ajax')) ) !!} </td>
                    <td>{!! Form::text('spareparts['.$tmpIndex.'][quantity]', null, ['class' => 'form-control
                        inputmask', 'data-unmask' => 1, 'data-optionmask' => json_encode( config('local.number.decimal1') )]) !!} </td>
                    <td><button onclick="addRowSelect2(this)" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i></button></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
