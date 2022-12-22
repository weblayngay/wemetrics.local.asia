@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
@endphp
@if(!empty($tuideoByBranch) && $branch == '%')
  <p class="pt-0">
    <h5 class="text-primary">
      <strong>
        <a data-toggle="collapse" href="#{{__($collapseId)}}" role="button" aria-expanded="false" aria-controls="{{__($collapseId)}}">
          <ul class="list-group">
            <li class="list-group-item btn btn-primary">
              <i class="fa-solid fa-lightbulb-on"></i> {{__('Tình hình bán '.$cateProductName.' tại các cửa hàng')}}
            </li>
          </ul>                    
        </a>
      </strong>
    </h5>
  </p>
  @php
      $totalSubTotal = 0;
      $totalQuantity = 0;
  @endphp
  {{-- Get Total --}}
  @foreach($tuideoByBranch as $key => $item)
      @if($item->quantity > 0)
          @php
              $totalSubTotal += $item->subTotal;
              $totalQuantity += $item->quantity;
          @endphp
      @endif
  @endforeach
  @foreach($tuideoByBranch as $key => $item)
    @if($item->quantity > 0)
      @php
          // Quantity Percent
          $quantityPercent = Round($item->quantity / $totalQuantity * 100, 0);
          // Subtotal Percent                                      
          $subTotalPercent = Round($item->subTotal / $totalSubTotal * 100, 0);
          if($loop->index + 1 == 1)
          {
              $badgebg = 'primary';
          }
          if($loop->index + 1 == 2)
          {
              $badgebg = 'success';
          }
          if($loop->index + 1 == 3)
          {
              $badgebg = 'info';
          }
          if($loop->index + 1 == 4)
          {
              $badgebg = 'warning';
          }
          if($loop->index + 1 == 5)
          {
              $badgebg = 'danger';
          }
          if($loop->index + 1 > 5)
          {
              $badgebg = 'secondary';
          }    
      @endphp
      {{-- @if($loop->index <= 4) --}}
        <div class="collapse" id="{{__($collapseId)}}">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  @if($loop->index <= 4)
                    <div class="ribbon-wrapper">
                        <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Top ').($loop->index + 1)}}</div>
                    </div>
                  @else
                    <div class="ribbon-wrapper">
                        <div class="ribbon ribbon-{{__($badgebg)}}">{{__('Regular')}}</div>
                    </div>
                  @endif
                  <div class="card-body">
                      <p class="mb-0">
                        <h6 class="text-primary font-weight-bolder"><i class="fa-solid fa-store"></i> {{ Str::title($item->branchName) }}</h6>
                      </p>

                      {{-- Hiển thị số lượng bán --}}
                      <p class="mb-0">
                        <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Số lượng bán'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.': '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getQuantity('', $item->quantity).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$quantityPercent.'%'.'</span>' !!}
                      </p>

                      {{-- Hiển thị tiền hàng --}}
                      @if($adgroup == 1 || $adgroup == 2)
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Tiền hàng thu'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.': '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->subTotal).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$subTotalPercent.'%'.'</span>' !!}
                        </p>
                      @endif

                      {{-- Hiển thị gợi ý bán hàng --}}
                      @if($loop->index <= 4)
                        <p class="mb-0">
                          <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                            {!! Str::title($item->branchName). ' bán chạy '.$cateProductName.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.'. Nên tăng cường bán nhóm hàng theo cửa hàng' !!}
                          </span>
                        </p>
                      @else
                        @if($item->quantity >= KIOTVIET_LEAD_TUIDEO_QUANTITY)
                          <p class="mb-0">
                            <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                              {!! Str::title($item->branchName). ' bán '.$cateProductName.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.'. Không thuộc hàng top. Nhưng sản lượng bán vẫn đạt mức trung bình. Cửa hàng có thể tăng cường các chiến dịch để thúc đẩy bán sản phẩm' !!}
                            </span>
                          </p>
                        @endif
                      @endif

                      {{-- Hiển thị nút xem chi tiết --}}
                      <div class="row">
                        <div class="col-md-3">
                          <p class="mb-0">
                            <a href="@php echo $urlHelper::admin('kiotvietcateproductreportoverview', 'preloaddrilldownbranchandcateproduct')."?branch=".$item->branchId."&cateProduct=".$item->productCateCode."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
                              <i class="fa-solid fa-arrow-right-from-bracket"></i> {{__('Xem chi tiết')}}
                            </a>
                          </p>
                        </div>
                        <div class="col-md-9" style="text-align: right;">
                          <a href="#{{__($collapseId)}}" type="button" class="btn btn-primary btn-icon" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="{{__($collapseId)}}">
                            <i class="fa-solid fa-minimize"></i>
                          </a>                          
                        </div>  
                      </div>
                                                      
                  </div>
                </div>
            </div>
          </div>  
        </div>    
      {{-- @endif --}}
    @endif
  @endforeach
@endif