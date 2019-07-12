@extends('backend.layouts.app')

@section('title', __('labels.backend.posts.management') . ' | ' . __('labels.backend.posts.view'))

@section('breadcrumb-links')
    @include('backend.post.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('labels.backend.posts.management')
                    <small class="text-muted">@lang('labels.backend.posts.view')</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-file"></i> @lang('labels.backend.posts.tabs.titles.overview')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th>@lang('labels.backend.posts.tabs.content.overview.description')</th>
                                        <td>{!! $post->description !!}</td>
                                    </tr>

                                    <tr>
                                        <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
                                        <td>{{ $users[$post->user_id] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div><!--table-responsive-->

                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>@lang('labels.backend.posts.tabs.content.overview.created_at'):</strong> {{ timezone()->convertToLocal($post->created_at) }} ({{ $post->created_at->diffForHumans() }}),
                    <strong>@lang('labels.backend.posts.tabs.content.overview.last_updated'):</strong> {{ timezone()->convertToLocal($post->updated_at) }} ({{ $post->updated_at->diffForHumans() }})
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
