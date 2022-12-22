@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
@endphp
@if(!empty($totalCateProduct) && $cateProduct == '%')
  <p class="pt-0">
    <h5 class="text-primary">
      <strong>
        <a data-toggle="collapse" href="#{{__($collapseId)}}" role="button" aria-expanded="false" aria-controls="{{__($collapseId)}}">
          <ul class="list-group">
            <li class="list-group-item btn btn-primary">
              <i class="fa-solid fa-lightbulb-on"></i> {{__('Nhóm sản phẩm bán chạy nhất')}}
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
  @foreach($totalCateProduct as $key => $item)
      @if($item->quantity > 0)
          @php
              $totalSubTotal += $item->subTotal;
              $totalQuantity += $item->quantity;
          @endphp
      @endif
  @endforeach
  @foreach($totalCateProduct as $key => $item)
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
              $badgebg = 'warning';
          } 
          if($loop->index + 1 > 3)
          {
              $badgebg = 'info';
          }  
      @endphp
      <div class="collapse" id="{{__($collapseId)}}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  @if($loop->index <= 2)
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
                        <h6 class="text-primary font-weight-bolder"><i class="fa-solid fa-cubes"></i> {{ Str::title($item->name) }}</h6>
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
                      @if($loop->index <= 2)
                        <p class="mb-0">
                          <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                            {!! Str::title($item->name). ' bán chạy trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.'. Nên tăng cường bán nhóm hàng' !!}
                          </span>
                        </p>
                      @else
                        <p class="mb-0">
                          <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                            {!! 'Mặt hàng '.'<span class="text-primary font-weight-bolder">'.$item->name.'</span>'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.' có thể kết hợp bán mặt hàng này với các mặt hàng chủ lực nằm trong top 3' !!}
                          </span>
                        </p>
                      @endif

                      {{-- Hiển thị nút xem chi tiết --}}
                      <div class="row">
                        @if($branch == '%')
                            <div class="col-md-3">
                              <p class="mb-0">
                                  <a href="@php echo $urlHelper::admin('kiotvietcateproductreportoverview', 'preloaddrilldownbranchesandcateproduct')."?branch=".$branch."&cateProduct=".$item->code."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>  {{__('Phân tích theo cửa hàng')}}
                                  </a>
                              </p>
                            </div>
                            <div class="col-md-3">
                              <p class="mb-0">
                                  <a href="@php echo $urlHelper::admin('kiotvietcateproductreportoverview', 'preloaddrilldownbrachesandproducts')."?branch=".$branch."&cateProduct=".$item->code."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>  {{__('Phân tích theo sản phẩm')}}
                                  </a>
                              </p>
                            </div>                       
                        @else
                          <div class="col-md-3">
                            <p class="mb-0">
                                <a href="@php echo $urlHelper::admin('kiotvietcateproductreportoverview', 'preloaddrilldownbranchandcateproduct')."?branch=".$branch."&cateProduct=".$item->code."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
                                  <i class="fa-solid fa-arrow-right-from-bracket"></i>  {{__('Phân tích theo cửa hàng')}}
                                </a>
                            </p>
                          </div>

                          <div class="col-md-3">
                          </div>
                        @endif

                        {{-- Hiển thị nút thu nhỏ --}}
                        <div class="col-md-6" style="text-align: right;">
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
    @endif
  @endforeach
@endif