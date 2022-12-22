@php
    $request = Request::all();
    $campaign = '';
    if(!empty($request['campaign']))
    {
        $campaign = $request['campaign'];
    }
    $campaigns = !empty($data['campaigns']) ? $data['campaigns'] : [];
@endphp
<select class="form-control select2" name="campaign">
    <option value="">{{__('Chiến dịch')}}</option>
    @foreach($campaigns as $key => $item)
    	<option value="{{__($item->campaign_id)}}" {{ ($item->campaign_id == $campaign) ? 'selected' : '' }}>{{__($item->campaign_name)}}</option>
    @endforeach
</select>