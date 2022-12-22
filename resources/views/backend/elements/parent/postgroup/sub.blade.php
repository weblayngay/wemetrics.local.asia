<option value="{{($sub_items->postgroup_id)}}" {{ ($sub_items->postgroup_id == $parentId) ? 'selected' : '' }}>
    {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $sub_items->postgroup_name}}
</option>
@if ($sub_items->items)
    <ul>
        @if(count($sub_items->items) > 0)
            @foreach ($sub_items->items as $key => $childItems)
                @include(POST_GROUP_SUB, ['sub_items' => $childItems, 'sub' => POST_GROUP_SUB ,'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    </ul>
@endif