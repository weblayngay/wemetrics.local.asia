@if(count($thumbnail) > 0 || count($banner) > 0)
    @if(count($thumbnail) >= count($banner))
        @foreach($thumbnail as $key => $item)
            <?php
                $bannerLink = !empty($banner[$key]['link']) ? $banner[$key]['link'] : '';
                $bannerId = !empty($banner[$key]['id']) ? $banner[$key]['id'] : 0;
                $nameArray = (!empty($bannerId)) ? "dataBannerUpdate[$bannerId]" : "dataBannerCreate[$bannerId]";
            ?>
            <div class="box-item" data-index="{{$key+1}}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" name="dataThumbnailUpdate[{{ $item['id'] }}]" class="dropify" data-default-file="{{ asset($item['link']) }}" @if(!empty($copy)) disabled="disabled" @endif/>
                        <input type="hidden" name="tIds[]" value="{{ $item['id'] }}">
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="{{ $nameArray }}" class="dropify" @if(!empty($bannerLink)) data-default-file="{{ asset($bannerLink) }}" @endif @if(!empty($copy)) disabled="disabled" @endif/>
                        <input type="hidden" name="bIds[]" value="{{ $bannerId }}">
                    </div>
                    <div class="col-md-3">
                        <select name='dataColorUpdate[]' class='form-control custom-select form-control custom-select-sm' @if(!empty($copy)) disabled="disabled" @endif>
                            <option value='0'>Chọn màu</option>
                            @if(count($colors) > 0)
                                @foreach($colors as $k => $itemColor)
                                    <option value='{{ $itemColor->pcolor_id }}' @if($item['color'] == $itemColor->pcolor_id) selected @endif>{{ $itemColor->pcolor_code }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-1">
                        <span class="delete-image" ><i class="glyphicon glyphicon-remove"></i></span>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @foreach($banner as $key => $item)
            <?php
            $thumbnailLink = !empty($thumbnail[$key]['link']) ? $thumbnail[$key]['link'] : '';
            $thumbnailId = !empty($thumbnail[$key]['id']) ? $thumbnail[$key]['id'] : 0;
            $nameArray = (!empty($thumbnailId)) ? "dataThumbnailUpdate[$thumbnailId]" : "dataThumbnailCreate[$thumbnailId]";

            ?>
            <div class="box-item" data-index="{{$key+1}}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="file" name="{{ $nameArray }}" class="dropify" @if(!empty($thumbnailLink)) data-default-file="{{ asset($thumbnailLink) }}" @endif @if(!empty($copy)) disabled="disabled" @endif/>
                        <input type="hidden" name="tIds[]" value="{{ $thumbnailId }}">
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="dataBannerUpdate[{{ $item['id'] }}]" class="dropify" data-default-file="{{ asset($item['link']) }}" @if(!empty($copy)) disabled="disabled" @endif/>
                        <input type="hidden" name="bIds[]" value="{{ $item['id'] }}">
                    </div>
                    <div class="col-md-3">
                        <select name='dataColorUpdate[]' class='form-control custom-select form-control custom-select-sm' @if(!empty($copy)) disabled="disabled" @endif>
                            <option value='0'>Chọn màu</option>
                            @if(count($colors) > 0)
                                @foreach($colors as $k => $itemColor)
                                    <option value='{{ $itemColor->pcolor_id }}' @if($item['color'] == $itemColor->pcolor_id) selected @endif>{{ $itemColor->pcolor_code }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-1">
                        <span class="delete-image"><i class="glyphicon glyphicon-remove"></i></span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endif
