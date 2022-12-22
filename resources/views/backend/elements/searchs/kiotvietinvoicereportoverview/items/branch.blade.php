@php
    $branches = $data['branches'];
    $data = Request::all();
    $branch = '';
    if(!empty($data['branch']))
    {
        $branch = $data['branch'];
    }
@endphp
<select class="form-control select2" name="branch">
    <option value="%">{{__('Tất cả cửa hàng')}}</option>
    @foreach($branches as $key => $item)
        <option value="{{__($item->getId())}}"  {{($item->getId() == $branch) ? 'selected' : ''}}>
            {{__($item->getBranchName())}}
        </option>
    @endforeach
</select>