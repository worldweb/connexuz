<li class="breadcrumb-menu">
    <div class="btn-faq" role="faq" aria-label="Button faq">
        <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" id="breadcrumb-dropdown-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('menus.backend.faqs.main')</a>

            <div class="dropdown-menu" aria-labelledby="breadcrumb-dropdown-1">
                <a class="dropdown-item" href="{{ route('admin.faq.index') }}">@lang('menus.backend.faqs.all')</a>
                <a class="dropdown-item" href="{{ route('admin.faq.create') }}">@lang('menus.backend.faqs.create')</a>
            </div>
        </div><!--dropdown-->

        <!--<a class="btn" href="#">Static Link</a>-->
    </div><!--btn-faq-->
</li>
