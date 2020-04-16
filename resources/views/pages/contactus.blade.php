@extends('layouts.home')
@section('title', trans('contactus.title'))
@section('bodyClass', 'site-wrap inner')
@section('content')
    <section class="mb-0 reset-password">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="reset-password-form col-md-6">
                        <div class="reset-password-form-header mb-5">
                            <h1 class="text-capitalize lato-bold">{{trans('contactus.title')}}</h1>
                        </div>
                        @if (session('success'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success alert-dismissible fade show rounded-0 ml-3 mr-3" role="alert">
                                    <h4 class="alert-heading font-weight-bold ">@lang('contactus.messagesent')</h4>
                                    <button type="button" class="close mt-1" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="reset-password-form-body">
                            <form class="mt-5" method="post">
                        		{{ csrf_field() }}
                                <div class="row">
                                    <label class="form-group has-float-label col-12 pl-0 pr-0  {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <input type="text" name="name" id="" class="form-control alt col-12" placeholder="{{trans('contactus.name')}}" required>
                                        <span>{{trans('contactus.name')}}</span>
                                        @if ($errors->has('name'))
                                            <p class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </p>
                                        @endif
                                    </label>
                                    <label class="form-group has-float-label col-12 mt-5 pl-0 pr-0{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" name="email" id="" class="form-control alt col-12" placeholder="{{trans('contactus.email')}}" required>
                                        <span>{{trans('contactus.email')}}</span>
                                         @if ($errors->has('email'))
                                            <p class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </p>
                                        @endif
                                    </label>
                                    <label class="form-group d-flex justify-content-between align-items-center mt-4 pl-0 pr-0 col-12{{ $errors->has('subject') ? ' has-error' : '' }}">
                                        <select class="form-control alt" name="subject" required>
                                            <option selected disabled>{{trans('contactus.subject')}}</option>
                                            <option>{{trans('contactus.General_Inquiry')}}</option>
                                            <option>{{trans('contactus.Follow_up_on_a_payment')}}</option>
                                            <option>{{trans('contactus.Follow_up_on_a_dispute_case')}}</option>
                                            <option>{{trans('contactus.Adding_a_new_category_subcategories')}}</option>
                                            <option>{{trans('contactus.suggestions')}}</option>
                                            <option>{{trans('contactus.Other')}}</option>
                                        </select>
                                        @if ($errors->has('subject'))
                                            <p class="help-block">
                                                <strong>{{ $errors->first('subject') }}</strong>
                                            </p>
                                        @endif
                                    </label>
                                    <label class="form-group has-float-label col-12 mt-5 pl-0 pr-0{{ $errors->has('message') ? ' has-error' : '' }}">
                                        <textarea name="message" rows="1" class="form-control alt col-12" placeholder="{{trans('contactus.message')}}" required></textarea>
                                        <span>{{trans('contactus.message')}}</span>
                                        <p class="char">0/2000</p>
                                        @if ($errors->has('message'))
                                            <p class="help-block">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </p>
                                        @endif
                                    </label>
                                    <button type="submit" class="btn btn-primary btn-lg rounded btn-block mt-5">{{trans('contactus.send')}}</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
@endsection
