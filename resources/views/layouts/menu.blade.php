@php
    use Illuminate\Support\Facades\Route;
    $routeName = Route::currentRouteName();
@endphp

<ul class="nav nav-sidebar" data-nav-type="accordion">
    <li class="nav-item-header"></li>
    <li class="nav-item">
        <a href='{{ route('dashboard') }}' class="nav-link {{ $routeName == 'dashboard' ? 'active' : '' }}">
            <i class="ph-house"></i><span>{{ lt('menu.dashboard') }}</span>
        </a>
    </li>

    @foreach (config('laranMenu', []) as $name => $info)
        @continue(empty($info))

        @php
            $hasChild = !empty($info['child']);
            $isActive = in_array($routeName, $info['active'] ?? []) || $info['routeName'] == $routeName;
        @endphp

        @if (!$hasChild)
            <li class="nav-item">
                <a href="{{ Route::has($info['routeName']) ? route($info['routeName']) : route('dashboard') }}"
                   class="nav-link {{ $isActive ? 'active' : '' }}">
                    @isset($info['icon'])
                        <i class="{{ $info['icon'] }}"></i>
                    @endisset
                    <span>{!! lt("menu.$name") !!}</span>
                </a>
            </li>
        @else
            <li class="nav-item nav-item-submenu">
                <a class="nav-link {{ $isActive ? 'active' : '' }}">
                    @isset($info['icon'])
                        <i class="{{ $info['icon'] }}"></i>
                    @endisset
                    <span>{!! lt("menu.$name") !!}</span>
                </a>
                <ul class="nav-group-sub collapse {{ $isActive ? 'show' : '' }}" data-submenu-title="{!! $name !!}">
                    @foreach ($info['child'] as $childName => $items)
                        @continue(empty($items))

                        @php
                            $isChildActive = in_array($routeName, $items['active'] ?? []) || $items['routeName'] == $routeName;
                        @endphp

                        <li class="nav-item">
                            <a href="{{ Route::has($items['routeName']) ? route($items['routeName']) : route('dashboard') }}"
                               class="nav-link {{ $isChildActive ? 'active' : '' }}">
                                <span>{!! lt("menu.$childName") !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>
