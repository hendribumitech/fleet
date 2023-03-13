@extends('layouts.app')

@section('content')
    @push('breadcrumb')
        <ol class="breadcrumb  my-0 ms-2">
          <li class="breadcrumb-item">
             <a href="{!! route($baseRoute.'.index', $vehicle->id) !!}">@lang('models/vehicleDocuments.singular')</a>
          </li>
          <li class="breadcrumb-item active">@lang('crud.edit')</li>
        </ol>
    @endpush
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('common.errors')
             <div class="row">
                 <div class="col-lg-12">
                    {!! Form::model($vehicleDocument, ['route' => [$baseRoute.'.update', [$vehicle->id, $vehicleDocument->id]], 'method' => 'patch', 'enctype' => 'multipart/form-data']) !!}  
                      <div class="card">                          
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit @lang('models/vehicleDocuments.singular')</strong>
                          </div>
                          <div class="card-body">                              

                              @include($baseView.'.fields')

                              
                            </div>
                          <div class="card-footer">
                          <!-- Submit Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
                                <a href="{{ route($baseRoute.'.index', $vehicle->id) }}" class="btn btn-default">@lang('crud.cancel')</a>
                            </div>
                          </div>                            
                      </div>                    
                    {!! Form::close() !!}  
                    </div>                    
                </div>
         </div>
    </div>
@endsection