<option value="{{($sub_items->menu_id)}}" {{ ($sub_items->menu_id == $parentId) ? 'selected' : '' }}>
    {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $sub_items->menu_name}}
</option>
@if ($sub_items->items)
    <ul>
        @if(count($sub_items->items) > 0)
            @foreach ($sub_items->items as $key => $childItems)
                @include(MENU_SUB, ['sub_items' => $childItems, 'sub' => MENU_SUB ,'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    </ul>
@endif