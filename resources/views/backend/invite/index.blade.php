@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.invites.management'))

@section('breadcrumb-links')
    @include('backend.invite.includes.breadcrumb-links')
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.invites.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.invites.table.name')</th>
                            <th>@lang('labels.backend.invites.table.invite_name')</th>
                            <th>@lang('labels.backend.invites.table.status')</th>
                            <th>@lang('labels.backend.invites.table.last_updated')</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invites as $invite)

                            <tr>
                                <td>{{ $invite->users->first_name }}</td>
                                <td>
                                  @if(!empty($invite->invite_user))
                                        {{$invite->invite_user->first_name}}
                                    @else
                                        {{$invite->invite_email}}
                                    @endif
                                </td>
                                <td>
                                @php
                                    if($invite->status == 0){
                                        echo '<span class="badge badge-warning">Pending</span>';
                                    }elseif($invite->status == 1){
                                        echo '<span class="badge badge-success">Approved</span>';
                                    }elseif($invite->status == 2){
                                        echo '<span class="badge badge-danger">Rejected</span>';
                                    }
                                @endphp                                    </td>
                                <td>{{ $invite->updated_at->diffForHumans() }}</td>
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
