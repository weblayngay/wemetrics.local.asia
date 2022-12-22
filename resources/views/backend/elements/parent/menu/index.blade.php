@if(count($parents) > 0)
    @foreach ($parents as $key => $parents_item)
        <option value="{{($parents_item->menu_id)}}" {{ ($parents_item->menu_id == $parentId) ? 'selected' : '' }}>
            {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $parents_item->menu_name}}
        </option>
        @if(count($parents_item->childItems))
            @foreach ($parents_item->childItems as $key => $childItems)
                @include($sub, ['sub_items' => $childItems, 'parentId' => $parentId, 'sub' => $sub, 'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    @endforeach
@endif