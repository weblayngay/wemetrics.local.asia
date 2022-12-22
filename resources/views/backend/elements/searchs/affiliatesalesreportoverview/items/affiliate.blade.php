@php
    $affiliates = $data['affiliates'];
    $data = Request::all();
    $affiliate = '';
    if(!empty($data['affiliate']))
    {
        $affiliate = $data['affiliate'];
    }
@endphp
<select class="form-control select2" name="affiliate">
    <option value="%">{{__('Tất cả affiliate')}}</option>
    @foreach($affiliates as $key => $item)
        <option value="{{__($item->id)}}"  {{($item->id == $affiliate) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>