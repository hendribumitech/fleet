{!! Form::open(['route' => [$baseRoute.'.destroy', [$vehicle_id, $id]], 'method' => 'delete']) !!}
<div class='btn-group'>    
    <a href="{{ route($baseRoute.'.edit', [$vehicle_id, $id]) }}" class='btn btn-ghost-info'>
       <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-ghost-danger',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
