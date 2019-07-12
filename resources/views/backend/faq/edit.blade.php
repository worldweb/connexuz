@extends('backend.layouts.app')

@section('title', __('labels.backend.faqs.management') . ' | ' . __('labels.backend.faqs.edit'))

@section('breadcrumb-links')
    @include('backend.faq.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($faq, 'PATCH', route('admin.faq.update', $faq->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.faqs.management')
                        <small class="text-muted">@lang('labels.backend.faqs.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-faq row">
                    {{ html()->label(__('validation.attributes.backend.faqs.title'))->class('col-md-2 form-control-label')->for('title') }}

                        <div class="col-md-10">
                            {{ html()->text('title')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.faqs.title'))
                                ->required()
                                ->autofocus()
                            }}
                        </div><!--col-->
                    </div><!--form-faq-->

                    <div class="form-faq row">
                    {{ html()->label(__('validation.attributes.backend.faqs.description'))->class('col-md-2 form-control-label')->for('description') }}

                        <div class="col-md-10">
                            {{ html()->textarea('description')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.faqs.description'))

                                ->required()
                                ->autofocus()
                            }}
                        </div><!--col-->
                    </div><!--form-faq-->

                    <div class="form-faq row">
                        {{ html()->label(__('validation.attributes.backend.faqs.status'))->class('col-md-2 form-control-label')->for('status') }}

                        <div class="col-md-10">
                            {{ html()->label(
                                html()->checkbox('status')
                                        ->class('switch-input')
                                        ->id('status')
                                    . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                ->class('switch switch-label switch-pill switch-primary mr-2')
                            ->for('status') }}
                        </div><!--col-->
                    </div><!--form-faq-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.faq.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
