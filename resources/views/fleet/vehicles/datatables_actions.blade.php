{!! Form::open(['route' => [$baseRoute.'.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route('fleet.maintenances.index').'?vehicle_id='.$id }}" class='btn btn-ghost-info' title="history maintenance">
        <i class="fa fa-list"></i>
    </a>    
    <a href="{{ route('fleet.maintenances.history', $id) }}" class='btn btn-ghost-info' title="history">
        <i class="fa fa-file-pdf-o"></i>
    </a> 
    <a href="{{ route('fleet.vehicles.documents.index', $id) }}" class='btn btn-ghost-info' title="document">
        <i class="fa fa-file"></i>
    </a> 
    <a href="{{ route($baseRoute.'.edit', $id) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
