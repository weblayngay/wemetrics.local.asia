<option value="{{($sub_items->vouchergroup_id)}}" {{ ($sub_items->vouchergroup_id == $parentId) ? 'selected' : '' }}>
    {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $sub_items->vouchergroup_name}}
</option>
@if ($sub_items->items)
    <ul>
        @if(count($sub_items->items) > 0)
            @foreach ($sub_items->items as $key => $childItems)
                @include(VOUCHER_GROUP_SUB, ['sub_items' => $childItems, 'sub' => VOUCHER_GROUP_SUB ,'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    </ul>
@endif