@php
    $resellers = $data['resellers'];
    $data = Request::all();
    $reseller = '';
    if(!empty($data['reseller']))
    {
        $reseller = $data['reseller'];
    }
@endphp
<select class="form-control select2" name="reseller">
    <option value="%">{{__('Tất cả cửa hàng')}}</option>
    @foreach($resellers as $key => $item)
        <option value="{{__($item->id)}}"  {{($item->id == $reseller) ? 'selected' : ''}}>
            {{__($item->reseller)}}
        </option>
    @endforeach
</select>