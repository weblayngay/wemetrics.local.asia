@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
    //
    use App\Http\Controllers\Backend\Intergrate\Kiotviet\Report\Children\getTotalCateProductController;
    $totalCateProductCtrl = new getTotalCateProductController();
@endphp
@if( (!empty($totalTopProductByDate) && $cateProduct != '%' && $branch != '%') || $action == 'drilldownbrachesandproducts')
  <p class="pt-0">
    <h5 class="text-primary">
      <strong>
        <a data-toggle="collapse" href="#{{__($collapseId)}}" role="button" aria-expanded="false" aria-controls="{{__($collapseId)}}">
          <ul class="list-group">
            <li class="list-group-item btn btn-primary">
              <i class="fa-solid fa-lightbulb-on"></i> {{__('Top '.$mLimit.' sản phẩm thuộc nhóm '.$cateProductName.' bán chạy')}}
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
  @foreach($totalTopProductByDate as $key => $item)
      @if($item->quantity > 0)
          @php
              $totalSubTotal += $item->subTotal;
              $totalQuantity += $item->quantity;
          @endphp
      @endif
  @endforeach
  @foreach($totalTopProductByDate as $key => $item)
    @php
        // Quantity Percent
        $quantityPercent = Round($item->quantity / $totalQuantity * 100, 0);
        // Subtotal Percent                                      
        $subTotalPercent = Round($item->subTotal / $totalSubTotal * 100, 0);
        // Top
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
        // Purchase
        if($action != 'drilldownbrachesandproducts')
        {
          $purchaseData = $totalCateProductCtrl->doGetTotalPurchase($branch, $item->productCode, $beginYear, $now)->first();
          //
          if(!empty($purchaseData->maxcreatedDate))
          {
            $maxcreatedDate = DateHelper::getDate('d-m-Y', $purchaseData->maxcreatedDate);
          }
          else
          {
            $maxcreatedDate = '';
          }
          //
          if(!empty($purchaseData->mincreatedDate))
          {
            $mincreatedDate = DateHelper::getDate('d-m-Y', $purchaseData->mincreatedDate);
          }
          else
          {
            $mincreatedDate = '';
          }
          //
          if(!empty($purchaseData->mincreatedDate))
          {
            $purchaseQuantity = MoneyHelper::getQuantity('', $purchaseData->quantity);
          }
          else
          {
            $purchaseQuantity = 0;
          }

          // Inventory
          $inventoryData = $totalCateProductCtrl->doGetTotalInventory($branch, $item->productCode)->first();
          $onHandQuantity = MoneyHelper::getQuantity('', $inventoryData->getOnHand());            
        }                                                                                  
    @endphp
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
                      <h6 class="text-primary font-weight-bolder"><i class="fa-solid fa-box-circle-check"></i> {{ Str::title($item->productName) }}</h6>
                    </p>

                    {{-- Hiển thị số lượng bán --}}
                    <p class="mb-0">
                       <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Số lượng bán'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.': '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getQuantity('', $item->quantity).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$quantityPercent.'%'.'</span>' !!}
                    </p>

                    {{-- Hiển thị tiền hàng --}}
                    @if($adgroup == 1 || $adgroup == 2)
                      <p class="mb-0">
                         <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Tiền hàng thu'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.': '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->subTotal).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$subTotalPercent.'%'.'</span>' !!}
                      </p>
                    @endif

                    @if($action != 'drilldownbrachesandproducts')
                      {{-- Hiển thị ngày nhập hàng xa nhất --}}
                      @if($mincreatedDate != '')
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Nhập đầu trong năm: '.'</strong><span class="text-danger font-weight-bolder">'.$mincreatedDate.'</span>' !!}
                        </p>
                      @endif

                      {{-- Hiển thị ngày nhập hàng gần nhất --}}
                      @if($maxcreatedDate != '')
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Nhập gần nhất: '.'</strong><span class="text-danger font-weight-bolder">'.$maxcreatedDate.'</span>' !!}
                        </p>
                      @endif

                      {{-- Hiển thị số lượng nhập kho --}}
                      @if($purchaseQuantity > 0)
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Số lượng nhập đến hiện tại: '.'</strong><span class="text-danger font-weight-bolder">'.$purchaseQuantity.'</span>' !!}
                        </p>
                      @else
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Không tồn tại dữ liệu nhập kho trong năm'.'</strong>' !!}
                        </p>
                      @endif

                      {{-- Hiển thị tồn kho --}}
                      @if($onHandQuantity > 0)
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Tồn kho đến hiện tại: '.'</strong><span class="text-danger font-weight-bolder">'.$onHandQuantity.'</span>' !!}
                        </p>
                      @else
                        <p class="mb-0">
                          <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Hàng đã bán hết không còn tồn kho đến hiện tại'.'</strong>' !!}
                        </p>
                      @endif                                            
                    @endif

                    {{-- Hiển thị gợi ý bán hàng --}}
                    @if($toDate < $now)
                      <p class="mb-0">
                        <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">{{__('Dữ liệu bán hàng đang xem là dữ liệu quá khứ.')}}</span>
                      </p>
                    @endif

                    @if($loop->index <= 4)
                      <p class="mb-0">
                        <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                          {!! '<span class="text-primary font-weight-bolder">'.$item->productName.'</span>'.' đang bán chạy trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.'. Nên tăng cường bán mặt hàng này' !!}
                        </span>
                      </p>
                    @else
                      <p class="mb-0">
                        <i class="fa-solid fa-lightbulb-exclamation-on text-primary"></i> <span class="font-italic">
                          {!! 'Mặt hàng '.'<span class="text-primary font-weight-bolder">'.$item->productName.'</span>'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.' nằm trong top '.'<strong>'.$mLimit.'</strong>'.'. Có thể kết hợp bán mặt hàng này với các mặt hàng chủ lực nằm trong top 5' !!}
                        </span>
                      </p>
                    @endif

                    {{-- Hiển thị nút xem chi tiết --}}
                    <div class="row">
                      <div class="col-md-3">
                        <p class="mb-0">
                          <a href="@php echo $urlHelper::admin('kiotvietproductreportoverview', 'preloadindex')."?branch=".$branch."&code=".$item->productCode."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
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
  @endforeach
@endif