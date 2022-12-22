@php
    $data = Request::all();
    $selected = '';
@endphp
@if(count($parents) > 0)
    @foreach ($parents as $key => $parents_item)
        @php
            if(!empty($data['group']))
            {
                if($parents_item->campaigngroup_id == $data['group'])
                {
                    $selected = 'selected';
                }
            }
        @endphp
        <option value="{{($parents_item->campaigngroup_id)}}" {{ ($parents_item->campaigngroup_id == $parentId) ? 'selected' : '' }} {{($selected == 'selected') ? 'selected' : ''}}>
            {{ $verticalBar . str_pad('', $node, $separate, STR_PAD_RIGHT) . $parents_item->campaigngroup_name}}
        </option>
        @if(count($parents_item->childItems))
            @foreach ($parents_item->childItems as $key => $childItems)
                @include($sub, ['sub_items' => $childItems, 'parentId' => $parentId, 'sub' => $sub, 'node' => $node + 1, 'separate' => $separate, 'verticalBar' => $verticalBar])
            @endforeach
        @endif
    @endforeach
@endif