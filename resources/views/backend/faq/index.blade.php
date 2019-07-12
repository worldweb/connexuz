@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.faqs.management'))

@section('breadcrumb-links')
    @include('backend.faq.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.faqs.management') }}
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.faq.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.faqs.table.title')</th>
                            <th>@lang('labels.backend.faqs.table.description')</th>
                            <th>@lang('labels.backend.faqs.table.last_updated')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($faqs as $faq)
                            <tr>
                                <td>{{ $faq->title }}</td>
                                <td>{{ $faq->description }}</td>
                                <td>{{ $faq->updated_at->diffForHumans() }}</td>
                                <td>{!! $faq->action_buttons !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
 
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endpush