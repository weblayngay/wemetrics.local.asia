@php
    $cateProducts = $data['cateProducts'];
    $data = Request::all();
    $cateProduct = '';
    if(!empty($data['cateProduct']))
    {
        $cateProduct = $data['cateProduct'];
    }
@endphp
<select class="form-control select2" name="cateProduct">
    <option value="%">{{__('Tất cả nhóm sản phẩm')}}</option>
    @foreach($cateProducts as $key => $item)
        <option value="{{__($item->getCategoryId())}}"  {{($item->getCategoryId() == $cateProduct) ? 'selected' : ''}}>
            {{ \Str::title($item->getCategoryName())}}
        </option>
    @endforeach
</select>