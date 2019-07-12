@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.page_title.help'))

@section('content')
@include('frontend.interaction.top')
    <section class="ConneXuz-help-wrap-box">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(!empty($faqs) && count($faqs) > 0)
                    <div id="accordion" class="help-accordion">
                        @foreach($faqs as $faq)
                        <div class="card">
                            <div class="card-header {{($loop->index == 0)?'':'collapsed'}}" id="heading{{$loop->index}}" data-toggle="collapse" data-target="#collapse{{$loop->index}}" aria-expanded="{{($loop->index == 0)?'true':'false'}}" aria-controls="collapse{{$loop->index}}">
                                <h5 class="mb-0">
                                    {{$faq->title}}
                                    <i class="fas fa-angle-down text-right float-right arrow-rotate"></i>
                                </h5>
                            </div>

                            <div id="collapse{{$loop->index}}" class="collapse  {{($loop->index == 0)?'show ':''}}" aria-labelledby="heading{{$loop->index}}" data-parent="#accordion">
                                <div class="card-body">
                                    {{$faq->description}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after-scripts')
@endpush

@section('popup')
    @include('frontend.popup.create-post')
@endsection
