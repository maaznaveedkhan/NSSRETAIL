@extends('frontend.layouts.app')
@section('content')
<div class="content-page">
   <div class="container-fluid">
        <div class="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
        
                @foreach($stocks as $key => $item)
        
                    <li role="presentation" @if($key == 0) class="active" @endif>
                        <a href="#tab-{{ $item->id }}" aria-controls="#tab-{{ $item->id }}" role="tab" data-toggle="tab">{{ $item->item_name }}</a>
                    </li>
        
                @endforeach 
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
        
                @foreach($stocks as $key => $item)
        
                    <div role="tabpanel" @if($key == 0) class="tab-pane active" @else class="tab-pane" @endif id="tab-{{ $item->id }}">
        
                        <h2>{{ $item->item_name }}</h2>
        
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim obcaecati praesentium repellat. Est explicabo facilis fuga illum iusto, obcaecati saepe voluptates! Dolores eaque porro quaerat sunt totam ut, voluptas.</p>
        
                    </div>
        
                @endforeach 
                
            </div>
        
        </div>
   </div>
</div>
@endsection