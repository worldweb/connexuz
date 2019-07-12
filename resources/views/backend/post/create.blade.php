@extends('backend.layouts.app')

@section('title', __('labels.backend.posts.management') . ' | ' . __('labels.backend.posts.create'))

@section('breadcrumb-links')
    @include('backend.post.includes.breadcrumb-links')
@endsection

@section('content')
    {{ html()->form('POST', route('admin.post.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            @lang('labels.backend.posts.management')
                            <small class="text-muted">@lang('labels.backend.posts.create')</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4 mb-4">
                    <div class="col">
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.posts.description'))->class('col-md-2 form-control-label')->for('description') }}

                            <div class="col-md-10">
                                {{ html()->textarea('description')
                                    ->class('form-control ckeditor')
                                    ->id('description')
                                    ->placeholder(__('validation.attributes.backend.posts.description'))                                    
                                    ->required()
                                    ->autofocus()
                                    ->attribute('rows', 8) }}
                            </div><!--col-->
                        </div><!--form-group-->                        
                        <div class="form-group row">
                            {{ html()->label(__('validation.attributes.backend.posts.user'))->class('col-md-2 form-control-label')->for('user') }}

                            <div class="col-md-10">
                                
                                {{ html()->select('user', $user)
                                    ->class('form-control')
                                    ->placeholder(__('validation.attributes.backend.posts.select_user'))                                   
                                    ->required() }}
                            </div><!--col-->
                        </div><!--form-group-->                                              
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.post.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
