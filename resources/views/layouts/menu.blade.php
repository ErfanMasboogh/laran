@php
    use Illuminate\Support\Facades\Route;
    $routeName = Route::currentRouteName();
@endphp

<hr>
<ul class="nav nav-sidebar" data-nav-type="accordion">
    <li class="nav-item w-100">
        <a href='{{ route('admin.dashboard') }}' class="nav-link px-3 w-90 d-block mx-auto {{ $routeName == 'admin.dashboard' ? 'active' : '' }}">
            <i class="fa fa-dashboard mx-2"></i>
            <span>{{ lt('menu.Dashboard') }}</span>
        </a>
    </li>

    @foreach (config('laranMenu', []) as $name => $info)
        @continue(empty($info))

        @php
            $hasChild = !empty($info['child']);
            // Determine if the item is active
            $isItemActive = isset($info['routeName']) && ($info['routeName'] == $routeName || in_array($routeName, $info['active'] ?? []));
            // Check if any child is active to open the parent submenu
            $isChildActiveInGroup = false;
            if ($hasChild) {
                foreach ($info['child'] as $child) {
                    if (isset($child['routeName']) && ($child['routeName'] == $routeName || in_array($routeName, $child['active'] ?? []))) {
                        $isChildActiveInGroup = true;
                        break;
                    }
                }
            }
        @endphp

        @if (!$hasChild)
            {{-- Single Menu Item --}}
            <li class="nav-item w-100">
                <a href="{{ isset($info['routeName']) ? route($info['routeName']) : route('admin.dashboard') }}"
                   class="nav-link px-3 w-90 d-block mx-auto {{ $isItemActive ? 'active' : '' }}">

                    @isset($info['icon'])
                        <i class="{{ $info['icon'] }} mx-2"></i>
                    @endisset
                    <span>{!! lt("menu.$name") !!}</span>
                </a>
            </li>
        @else
            {{-- Submenu Item --}}
            <li class="nav-item nav-item-submenu w-100">
                <a class="nav-link px-3 d-block w-90 mx-auto {{ $isItemActive ? 'active' : '' }}" data-bs-toggle="collapse" href="#submenu-{{ $name }}">
                    @isset($info['icon'])
                        <i class="{{ $info['icon'] }} mx-2"></i>
                    @endisset
                    <span>{!! lt("menu.$name") !!}</span>
                </a>

                <ul id="submenu-{{ $name }}" class="nav-group-sub collapse {{ $isChildActiveInGroup ? 'show' : '' }}" data-submenu-title="{!! $name !!}">
                    @foreach ($info['child'] as $childName => $items)
                        @continue(empty($items))

                        @php
                            $isChildActive = isset($items['routeName']) && ($items['routeName'] == $routeName || in_array($routeName, $items['active'] ?? []));
                        @endphp

                        <li class="nav-item w-100">
                            <a href="{{ isset($items['routeName']) ? route($items['routeName']) : route('admin.dashboard') }}"
                               class="nav-link ps-5 w-90 d-block mx-auto {{ $isChildActive ? 'active' : '' }}">
                                <span class="mx-2" >{!! lt("menu.$childName") !!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endforeach
</ul>
