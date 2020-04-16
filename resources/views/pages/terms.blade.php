@extends('layouts.home')
@section('title', trans('home.menu_terms_conditions'))
@section('bodyClass', 'site-wrap inner bg-white')
@section('content')
  <div class="page-header">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">{{trans('general.home')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{trans('home.menu_terms_conditions')}}</li>
        </ol>
    </nav>
    <section class="container how-it-works">
      @foreach($terms as $term)
      <div class="row">
          <div class="col-md-12">
             <div>
                @foreach($term as $item)
                  <{{$item['tag']}} <?=($item['tag']=="p")?"class='text-left'":""?>><?=$item['text']?></{{$item['tag']}}> 
                @endforeach
             </div>
          </div>
      </div>
      @endforeach
    </section>
  </div>
       
@endsection
