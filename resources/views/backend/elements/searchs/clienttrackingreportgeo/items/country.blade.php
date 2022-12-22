@php
    $countries = $data['countries'];
    $data = Request::all();
    $country = '';
    if(!empty($data['mCountry']))
    {
        $country = $data['mCountry'];
    }
@endphp
<select class="form-control select2" name="mCountry">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($countries as $key => $item)
        <option value="{{__($item)}}"  {{($item == $country) ? 'selected' : ''}}>
            {{__($item)}}
        </option>
    @endforeach
</select>