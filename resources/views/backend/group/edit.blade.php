@extends('backend.layouts.app')

@section('title', __('labels.backend.groups.management') . ' | ' . __('labels.backend.groups.edit'))

@section('breadcrumb-links')
    @include('backend.group.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($group, 'PATCH', route('admin.group.update', $group->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.groups.management')
                        <small class="text-muted">@lang('labels.backend.groups.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                    {{ html()->label(__('validation.attributes.backend.groups.name'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.groups.name'))

                                ->required()
                                ->autofocus()
                            }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label(__('validation.attributes.backend.groups.status'))->class('col-md-2 form-control-label')->for('status') }}

                        <div class="col-md-10">
                            {{ html()->label(
                                html()->checkbox('status')
                                        ->class('switch-input')
                                        ->id('status')
                                    . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                ->class('switch switch-label switch-pill switch-primary mr-2')
                            ->for('status') }}
                        </div><!--col-->
                    </div><!--form-group-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.group.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
