@extends('backend.layouts.app')

@section('title', __('labels.backend.invites.management') . ' | ' . __('labels.backend.invites.edit'))

@section('breadcrumb-links')
    @include('backend.invite.includes.breadcrumb-links')
@endsection

@section('content')
{{ html()->modelForm($invite, 'PATCH', route('admin.invite.update', $invite->id))->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.invites.management')
                        <small class="text-muted">@lang('labels.backend.invites.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <hr>

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-invite row">
                    {{ html()->label(__('validation.attributes.backend.invites.name'))->class('col-md-2 form-control-label')->for('name') }}

                        <div class="col-md-10">
                            {{ html()->text('name')
                                ->class('form-control')
                                ->placeholder(__('validation.attributes.backend.invites.name'))

                                ->required()
                                ->autofocus()
                            }}
                        </div><!--col-->
                    </div><!--form-invite-->

                    <div class="form-invite row">
                        {{ html()->label(__('validation.attributes.backend.invites.status'))->class('col-md-2 form-control-label')->for('status') }}

                        <div class="col-md-10">
                            {{ html()->label(
                                html()->checkbox('status')
                                        ->class('switch-input')
                                        ->id('status')
                                    . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                ->class('switch switch-label switch-pill switch-primary mr-2')
                            ->for('status') }}
                        </div><!--col-->
                    </div><!--form-invite-->
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.invite.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->closeModelForm() }}
@endsection
