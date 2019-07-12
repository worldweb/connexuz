@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.comments.management'))

@section('breadcrumb-links')
    @include('backend.comment.includes.breadcrumb-links')
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.comments.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.comments.table.name')</th>
                            <th>@lang('labels.backend.comments.table.post_title')</th>
                            <th>Comment</th>
                            <th>@lang('labels.backend.comments.table.last_updated')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->users->first_name }}</td>
                                <td>{!! truncate($comment->posts->description,'20') !!}</td>
                                <td>{!! truncate($comment->description,'20') !!}</td>
                                <td>{{ $comment->updated_at->diffForHumans() }}</td>
                                <td>{!! $comment->action_buttons !!}</td>
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
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endpush
