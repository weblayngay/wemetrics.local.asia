@php
    use VienThuong\KiotVietClient\Model\Product;
    $cateProducts = $data['cateProducts'];
    $data = Request::all();
    $cateProduct = '';
    if(!empty($data['cateProduct']))
    {
        $cateProduct = $data['cateProduct'];
    }
@endphp
<select class="form-control select2" name="cateProduct">
    <option value="%">{{__('Tất cả nhóm hàng')}}</option>
    @foreach($cateProducts as $key => $item)
        <option value="{{__($key)}}"  {{($key == $cateProduct) ? 'selected' : ''}}>
            {{__(Product::CATEGORIES[$key])}}
        </option>
    @endforeach
</select>