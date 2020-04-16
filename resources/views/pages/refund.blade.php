@extends('layouts.home')
@section('title', trans('staticpages.refund.title'))
@section('bodyClass', 'site-wrap inner bg-white')
@section('content')
  <div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">{{trans('general.home')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{trans('staticpages.refund.title')}}</li>
        </ol>
    </nav>
    <section class="container how-it-works">
      @foreach($refund as $ref)
      <div class="row">
          <div class="col-md-12">
             <div>
                @foreach($ref as $item)
                  @if($item['tag'] == "img")
                  <br>
                  <img class="img-fluid" src="{{url($item['text'])}}">
                  @elseif($item['tag']=="ul"||$item['tag']=="/ul")
                  <{{$item['tag']}}>
                  @else
                  <{{$item['tag']}} <?=($item['tag']=="p")?"class='text-left'":""?>>{{$item['text']}}</{{$item['tag']}}> 
                  @endif
                @endforeach
             </div>
          </div>
      </div>
      @endforeach
    </section>
  </div>
       
@endsection
