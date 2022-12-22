@php
    use VienThuong\KiotVietClient\Model\Product;
    use Illuminate\Support\Str;
    $codes = $data['codes'];
    $data = Request::all();
    $code = '';
    if(!empty($data['code']))
    {
        $code = $data['code'];
    }
@endphp
<select class="form-control select2" name="code">
    <option value="%">{{__('Tất cả mặt hàng')}}</option>
    @foreach($codes as $key => $item)
        <option value="{{__($item->code)}}"  {{($item->code == $code) ? 'selected' : ''}}>
            {{__(\Str::title($item->name))}}
        </option>
    @endforeach
</select>