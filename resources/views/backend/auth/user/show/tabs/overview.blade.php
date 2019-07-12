<div class="col">
    <div class="table-responsive">
        <table class="table table-hover backuser_overview_table">
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.avatar')</th>
                <td><img src="{{ $user->avatar_location }}" class="user-profile-image" /></td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.name')</th>
                <td>{{ $user->name }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.email')</th>
                <td>{{ $user->email }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.date_of_birth')</th>
                <td>{{ date("d-m-Y", strtotime($user->date_of_birth)) }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.gender')</th>
                <td>{{ ($user->gender == 1) ? "Male": "Female" }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.city')</th>
                <td>{{ $user->city }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.country')</th>
                <td>{{ $user->country }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.mobile_numer')</th>
                <td>{{ $user->mobile_number }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.about')</th>
                <td>{{ $user->about }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.user_university')</th>
                <td>{{ $user->university }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.from')</th>
                <td>{{ date("d-m-Y", strtotime($user->education_from_date)) }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.to')</th>
                <td>{{ date("d-m-Y", strtotime($user->education_to_date)) }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.about_university')</th>
                <td>{{ $user->education_about }}</td>
            </tr>
            
            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.user_interests')</th>
                <td>
                    @if($interest->count())
                                            @foreach($interest as $ik)
                                            @php
                                                echo $ik->title."<br/>"
                                            @endphp
                                            @endforeach
                                            @endif
                </td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.status')</th>
                <td>{!! $user->status_label !!}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.confirmed')</th>
                <td>{!! $user->confirmed_label !!}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.timezone')</th>
                <td>{{ $user->timezone }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.last_login_at')</th>
                <td>
                    @if($user->last_login_at)
                        {{ timezone()->convertToLocal($user->last_login_at) }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.users.tabs.content.overview.last_login_ip')</th>
                <td>{{ $user->last_login_ip ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div><!--table-responsive-->
