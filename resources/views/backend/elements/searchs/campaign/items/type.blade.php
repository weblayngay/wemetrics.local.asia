@php
    $types = $data['types'];
    $data = Request::all();
    $type = '';
    if(!empty($data['type']))
    {
        $type = $data['type'];
    }
@endphp
<select class="form-control select2" name="type">
    <option value="">{{__('Loại chiến dịch')}}</option>
    @foreach($types as $key => $item)
        <option value="{{($item->campaigntype_id)}}"  {{($item->campaigntype_id == $type) ? 'selected' : ''}}>
            {{($item->campaigntype_name)}}
        </option>
    @endforeach
</select>