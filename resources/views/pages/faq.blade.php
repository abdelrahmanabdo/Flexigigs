@extends('layouts.home')
@section('title', trans('staticpages.faq.title'))
@section('bodyClass', 'site-wrap inner dashboard')
@section('content')
<div class="page-header">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('home')}}">{{trans('general.home')}}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{trans('staticpages.faq.title')}}</li>
                </ol>
            </nav>
        </div>
        <section class="container" id="FAQ-section">
            <div class="row">
                <div class="col-12">
                    <div id="FAQList" data-children=".item">
                        
                        <h1 class="items-title text-capitalize mt-5 mb-4">{{trans('staticpages.faq.employerfaq')}}</h1>
                        <?php $i = 0; ?>
                        @foreach($employer_faq as $emp_faq)
                        <?php $i++; ?>
                        <div class="item">
                            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#FAQList" data-target="#FAQ-{{$i}}" aria-expanded="true">
                                <div class="item-info-collapsed">
                                    <h2>{{$emp_faq['question']}}</h2>
                                    <i class="icon-angle-down"></i>
                                </div>
                                <div class="item-info">
                                    <h2>{{$emp_faq['question']}}</h2>
                                    <i class="icon-angle-down"></i>
                                </div>
                            </div>
                            <div id="FAQ-{{$i}}" class="item-content collapse" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mt-3">
                                        <?=$emp_faq['answer']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <h1 class="items-title text-capitalize mt-5 mb-4">{{trans('staticpages.faq.flreelancerfaq')}}</h1>
                        @foreach($freelancer_faq as $free_faq)
                        <?php $i++; ?>
                        <div class="item">
                            <div class="item-trigger collapsed" data-toggle="collapse" data-parent="#FAQList" data-target="#FAQ-{{$i}}" aria-expanded="true">
                                <div class="item-info-collapsed">
                                    <h2>{{$free_faq['question']}}</h2>
                                    <i class="icon-angle-down"></i>
                                </div>
                                <div class="item-info">
                                    <h2>{{$free_faq['question']}}</h2>
                                    <i class="icon-angle-down"></i>
                                </div>
                            </div>
                            <div id="FAQ-{{$i}}" class="item-content collapse" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-12 mt-3">
                                        <?=$free_faq['answer']?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    
                    </div>
                </div>
            </div>
        </section>
@endsection
