@extends('backend.layouts.app')

@section('title', __('labels.backend.settings.management') . ' | ' . __('labels.backend.settings.update'))

@section('content')
{{ html()->form('POST', route('admin.setting.store'))->class('form-horizontal')->open() }}
<?php //dd($settings[0]->setting_value); exit; ?>
    <div class="card">
        <div class="card-body">

            <div class="row mt-4 mb-4">
                <div class="col">
                @foreach($settings as $setting)
                    <div class="form-group row">
                    {{ html()->label(__($setting->setting_title))->class('col-md-2 form-control-label')->for($setting->setting_title) }}

                        <div class="col-md-10">
                            {{ html()->text($setting->setting_key)
                                ->class('form-control')
                                ->placeholder(__($setting->setting_title))
                                ->value($setting->setting_value) }}
                        </div><!--col-->
                    </div><!--form-group-->
                @endforeach
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                
                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.update')) }}
                </div><!--row-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->form()->close() }}
@endsection
