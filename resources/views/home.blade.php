@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
  <div class="animated fadeIn">
    @include('flash::message')
    <div class="row">
      @forelse ($notifications['document'] as $item)
      <div class="col">
        <div class="card bg-light mb-3">
          <div class="card-header">{{ $item['title'] }}</div>
          <div class="card-body">
            <ul class="list-group">
              @foreach ($item['datas'] as $data)
              <li class="list-group-item d-flex justify-content-between align-items-center">                
                <div>                  
                  <a href="{{ $data['url'] }}" class="card-link">{!! $data['text'] !!}</a>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @empty
        @include('greeting')
      @endforelse
    </div>
  </div>
</div>
</div>

@endsection