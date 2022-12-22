@php
    use App\Helpers\StringHelper;
    $regions = $data['regions'];
    $data = Request::all();
    $region = '';
    if(!empty($data['mRegion']))
    {
        $region = $data['mRegion'];
    }
@endphp
<select class="form-control select2" name="mRegion">
    <option value="%">{{__('Tất cả')}}</option>
    @foreach($regions as $key => $item)
        <option value="{{StringHelper::getLatinh($item->name)}}"  {{(StringHelper::getLatinh($item->name) == $region) ? 'selected' : ''}}>
            {{__($item->name)}}
        </option>
    @endforeach
</select>