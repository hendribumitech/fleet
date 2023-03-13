<!-- Description Field -->
<div class="form-group row mb-3">
    {!! Form::label('service_description', __('models/maintenances.fields.service_description').':', ['class' => 'col-md-3
    col-form-label']) !!}
    <div class="col-md-9">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Deskripsi</th>                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if (!$services->isEmpty())
                    @foreach ($services as $service)                    
                    <tr data-index="{{ $tmpIndex }}">
                        <td>{!! Form::textarea('services['.$service->id.'][description]', $service->description, ['class' => 'form-control', 'rows' => 1]) !!} </td>
                        <td>
                            @if ($loop->last)
                                <button onclick="main.addRow(this, updateIndexNameElement)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button>    
                            @else
                                <button onclick="main.removeRow(this)" class="btn btn-primary btn-sm"><i class="fa fa-minus"></i></button></td>
                            @endif
                        </td>    
                    </tr>
                    @endforeach 
                @else
                <tr data-index="{{ $tmpIndex }}">
                    <td>{!! Form::textarea('services['.$tmpIndex.'][description]', null, ['class' => 'form-control', 'rows' => 1]) !!} </td>
                    <td><button onclick="main.addRow(this, updateIndexNameElement)" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></button></td>
                </tr>
                @endif
                
            </tbody>
        </table>    
    </div>
</div>
