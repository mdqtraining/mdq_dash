<!-- PAGE TITLE START -->
<div {{ $attributes->merge(['class' => 'page-title']) }}>
    <div class="page-heading">
        <h2 class="mb-0 pr-3 text-blue f-18 font-weight-bold d-flex align-items-center">
            <span class="d-inline-block text-truncate mw-300">{{ $pageTitle }}</span>

            <span class="text-lightest f-12 f-w-500 ml-2 mw-250 text-truncate">
                <a href="{{ route('dashboard') }}" class="text-lightest">@lang('app.menu.home')</a> &bull;
                @php
                    $link = '';
                @endphp

                @for ($i = 1; $i <= count(Request::segments()); $i++)
                    @if (($i < count(Request::segments())) && ($i> 0))
                        @php $link .= '/' . Request::segment($i); @endphp

                        @if (Request::segment($i) != 'account')
                            <a href="{{str_contains(url()->current(),'public')?'/public'.$link:$link }}" class="text-lightest">
                                @php
                                    $langKey = 'app.'.str_replace('-', ' ', Request::segment($i));
                                @endphp

                                {{ Lang::has($langKey) ? __($langKey) : ucwords(str_replace('-', ' ', Request::segment($i)))}}
                </a> &bull;
                        @endif
                        @else
                            <span class="text-dark">{{ $pageTitle }}</span>
                        @endif

                @endfor
            </span>
        </h2>
    </div>
</div>
<!-- PAGE TITLE END -->
