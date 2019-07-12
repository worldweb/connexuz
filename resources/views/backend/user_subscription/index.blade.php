@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.user_subscriptions.management'))

@section('breadcrumb-links')
    @include('backend.user_subscription.includes.breadcrumb-links')
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.user_subscriptions.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.user_subscriptions.table.name')</th>
                            <th>@lang('labels.backend.user_subscriptions.table.subscription_name')</th>
                            <th>@lang('labels.backend.user_subscriptions.table.amount')</th>
                            <th>@lang('labels.backend.user_subscriptions.table.status')</th>
                            <th>@lang('labels.backend.user_subscriptions.table.last_updated')</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userSubscriptions as $UserSubscription)

                            <tr>
                                <td>{{ $UserSubscription->users->first_name }}</td>
                                <td>{{ $UserSubscription->subscription->name }}</td>
                                <td>{{ $UserSubscription->payment_amount }}</td>
                                <td>{{ $UserSubscription->payment_status}}</td>
                                <td>{{ $UserSubscription->updated_at->diffForHumans() }}</td>
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
