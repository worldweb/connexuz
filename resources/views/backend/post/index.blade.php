@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.posts.management'))

@section('breadcrumb-links')
    @include('backend.post.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.posts.management') }}
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.post.includes.header-buttons')
            </div><!--col-->

        </div><!--row-->
   
        <div class="row mt-4">
            <div class="col">
            <div class="table-responsive">
                    
                <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{!! truncate($post->description,'20') !!}</td>
                                <td>{{ $post->user->first_name.' '.$post->user->last_name }}</td>
                                <td>{{ $post->status }}</td>
                                <td>{{ $post->updated_at->diffForHumans() }}</td>
                                <td>{!! $post->action_buttons !!}</td>
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
