<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/dashboard')) }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon icon-speedometer"></i> @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/auth*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/auth*')) }}" href="#">
                        <i class="nav-icon icon-user"></i> @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/user*')) }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/auth/role*')) }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/post*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/post*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.posts.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/post')) }}" href="{{ route('admin.post.index') }}">
                                @lang('labels.backend.posts.management')
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/comment')) }}" href="{{ route('admin.comment.index') }}">
                                @lang('labels.backend.comments.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/group*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/group*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.groups.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/group')) }}" href="{{ route('admin.group.index') }}">
                                @lang('labels.backend.groups.management')
                            </a>
                        </li>
                    </ul>
                </li> -->

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/faq*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/faq*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.faqs.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/faq')) }}" href="{{ route('admin.faq.index') }}">
                                @lang('labels.backend.faqs.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/subscription*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/subscription*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.subscriptions.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/subscription')) }}" href="{{ route('admin.subscription.index') }}">
                                @lang('labels.backend.subscriptions.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/user_subscription*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/user_subscription*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.user_subscriptions.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/user_subscription')) }}" href="{{ route('admin.usersubscription.index') }}">
                                @lang('labels.backend.user_subscriptions.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/invite*'), 'open') }}">
                    <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/invite*')) }}" href="#">
                        <i class="nav-icon icon-note"></i> @lang('menus.backend.invites.title')
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{ active_class(Active::checkUriPattern('admin/invite')) }}" href="{{ route('admin.invite.index') }}">
                                @lang('labels.backend.invites.management')
                            </a>
                        </li>
                    </ul>
                </li>
                
                <a class="nav-link {{ active_class(Active::checkUriPattern('admin/setting*')) }}" href="{{ route('admin.setting.index') }}">
                <li class="nav-item">
                        <i class="nav-icon icon-settings"></i> @lang('menus.backend.settings.title')
                    </li>
                </a>

            @endif

            <li class="divider"></li>

            <!-- <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/log-viewer*')) }}" href="#">
                    <i class="nav-icon icon-list"></i> @lang('menus.backend.log-viewer.main')
                </a>

                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer')) }}" href="{{ route('log-viewer::dashboard') }}">
                            @lang('menus.backend.log-viewer.dashboard')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/log-viewer/logs*')) }}" href="{{ route('log-viewer::logs.list') }}">
                            @lang('menus.backend.log-viewer.logs')
                        </a>
                    </li>
                </ul>
            </li> -->
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
