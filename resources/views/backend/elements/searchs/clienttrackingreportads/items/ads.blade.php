@php
    $ads = $data['ads'];
    $data = Request::all();
    $mAds = '';
    if(!empty($data['mAds']))
    {
        $mAds = $data['mAds'];
    }
@endphp
<select class="form-control select2" name="mAds">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($ads as $key => $item)
        <option value="{{__($item->name)}}"  {{($item->name == $mAds) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>