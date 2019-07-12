@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.subscriptions.management'))

@section('breadcrumb-links')
    @include('backend.subscription.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.subscriptions.management') }}
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.subscription.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.subscriptions.table.title')</th>
                            <th>@lang('labels.backend.subscriptions.table.price')</th>
                            <th>@lang('labels.backend.subscriptions.table.no_of_days')</th>
                            <th>@lang('labels.backend.subscriptions.table.free_days')</th>
                            <th>@lang('labels.backend.subscriptions.table.last_updated')</th>
                            <th>@lang('labels.general.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->name }}</td>
                                <td>{{ $subscription->price }}</td>
                                <td>{{ $subscription->no_of_days }}</td>
                                <td>{{ $subscription->no_of_days }}</td>
                                <td>{{ $subscription->updated_at->diffForHumans() }}</td>
                                <td>{!! $subscription->action_buttons !!}</td>
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
