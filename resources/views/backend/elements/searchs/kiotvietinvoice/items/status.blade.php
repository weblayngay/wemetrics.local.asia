@php
    use VienThuong\KiotVietClient\Model\Invoice;
    $statuses = $data['statuses'];
    $data = Request::all();
    $status = '';
    if(!empty($data['status']))
    {
        $status = $data['status'];
    }
@endphp
<select class="form-control select2" name="status">
    <option value="%">{{__('Tất cả trạng thái')}}</option>
    @foreach($statuses as $key => $item)
        <option value="{{__($key)}}"  {{($key == $status) ? 'selected' : ''}}>
            {{__(Invoice::STATUSES_LABEL[$key])}}
        </option>
    @endforeach
</select>