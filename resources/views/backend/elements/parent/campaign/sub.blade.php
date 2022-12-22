@php
    $data = Request::all();
    $selected = '';
    if(!empty($data['group']))
    {
        if($sub_items->campaigngroup_id == $data['group'])
        {
            $selected = 'selected';
        }
    }
@endphp
<option value="{{($sub_items->campaigngroup_id)}}" {{ ($sub_items->campaigngroup_id == $parentId) ? 'selected' : '' }} {{($selected == 'selected') ? 'selected' : ''}}>
    {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $sub_items->campaigngroup_name}}
</option>
@if ($sub_items->items)
    <ul>
        @if(count($sub_items->items) > 0)
            @foreach ($sub_items->items as $key => $childItems)
                @include(CAMPAIGN_SUB, ['sub_items' => $childItems, 'sub' => CAMPAIGN_SUB ,'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    </ul>
@endif