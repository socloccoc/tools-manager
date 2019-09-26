@php($top_menus = \Menus::getMenus())

@foreach($top_menus->where('parent_id', 0) as $item)
        <li class="c-menu-type-classic">
                <a href="{{$item['url']}}" class="c-link dropdown-toggle">
                        {{$item['title']}}
                </a>
        </li>
@endforeach