@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
@endphp
<!-- The Modal -->
<div class="modal" id="{{__($modalId)}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{__($title)}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table class="table table-striped table-bordered table-hover w-100 display pb-30 js-main-table">
                                    <thead class="thead-info">
                                    <tr>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Cửa hàng')}}
                                            </span>
                                        </th>
                                        <th scope="col">
                                            <span class="text-center font-weight-bolder">
                                                {{__('Số lượng bán')}}
                                            </span><br>
                                            <span class="text-center font-weight-bolder">
                                                {{__('từ '.$frmDate.' đến '.$toDate)}}
                                            </span>
                                        </th>
                                        {{-- Show with admin --}}
                                        @if($adgroup == 1 || $adgroup == 2)
                                            <th scope="col">
                                                <span class="text-center font-weight-bolder">
                                                    {{__('Tiền hàng')}}
                                                </span><br>
                                                <span class="text-center font-weight-bolder">
                                                    {{__('từ '.$frmDate.' đến '.$toDate)}}
                                                </span>
                                            </th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($tuideoByBranch))
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
                                                        if($quantityPercent >= 15)
                                                        {
                                                            $quantityBgProcess = 'bg-primary';
                                                        }
                                                        if($quantityPercent >= 10 && $quantityPercent < 15)
                                                        {
                                                            $quantityBgProcess = 'bg-success';
                                                        }
                                                        if($quantityPercent >= 5 && $quantityPercent < 10)
                                                        {
                                                            $quantityBgProcess = 'bg-info';
                                                        } 
                                                        if($quantityPercent < 5)
                                                        {
                                                            $quantityBgProcess = 'bg-warning';
                                                        }
                                                        // Subtotal Percent                                      
                                                        $subTotalPercent = Round($item->subTotal / $totalSubTotal * 100, 0);
                                                        if($subTotalPercent >= 15)
                                                        {
                                                            $subTotalBgProcess = 'bg-primary';
                                                        }
                                                        if($subTotalPercent >= 10 && $subTotalPercent < 15)
                                                        {
                                                            $subTotalBgProcess = 'bg-success';
                                                        }
                                                        if($subTotalPercent >= 5 && $subTotalPercent < 10)
                                                        {
                                                            $subTotalBgProcess = 'bg-info';
                                                        } 
                                                        if($subTotalPercent < 5)
                                                        {
                                                            $subTotalBgProcess = 'bg-warning';
                                                        }  
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
                                                    @endphp
                                                    <tr>
                                                        <td data-label="Tên cửa hàng">
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
                                                                                <strong>{{ Str::title($item->branchName) }}</strong>
                                                                            </p>
                                                                            <p class="mb-0">
                                                                              <a href="@php echo $urlHelper::admin('kiotvietcateproductreportoverview', 'preloaddrilldownbranchandcateproduct')."?branch=".$item->branchId."&cateProduct=".$item->productCateCode."&frmDate=".$frmDate."&toDate=".$toDate; @endphp" target="_blank" type="button" class="btn btn-info btn-sm">
                                                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> {{__('Xem chi tiết')}}
                                                                              </a>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                                                    
                                                            </div>

                                                        </td>
                                                        <td data-label="Số lượng">
                                                            <span class="text-danger font-weight-bolder">
                                                                {{ MoneyHelper::getQuantity('', $item->quantity) }}
                                                            </span>
                                                            <div class="progress">
                                                                <div class="progress-bar {{__($quantityBgProcess)}} progress-bar-striped progress-bar-animated" style="width:{{ $quantityPercent.'%'}}"></div>
                                                            </div>
                                                        </td>
                                                        {{-- Show with admin --}}
                                                        @if($adgroup == 1 || $adgroup == 2)
                                                            <td data-label="Tiền hàng">
                                                                <span class="text-danger font-weight-bolder">
                                                                    {{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->subTotal) }}
                                                                </span>
                                                                <div class="progress">
                                                                    <div class="progress-bar {{__($subTotalBgProcess)}} progress-bar-striped progress-bar-animated" style="width:{{ $subTotalPercent.'%'}}"></div>
                                                                </div>                                                                                    
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                            {{-- Show with admin --}}
                                            @if($adgroup == 1 || $adgroup == 2)
                                                <tr>
                                                    <td></td>
                                                    <td><strong>{{__('Số lượng bán: ')}}</strong></td>
                                                    <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td><strong>{{__('Số lượng bán: ')}}</strong></td>                                                                        
                                                    <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getQuantity('', $totalQuantity) }}</span></td>
                                                </tr>
                                            @endif
                                            {{-- Show with admin --}}
                                            @if($adgroup == 1 || $adgroup == 2)
                                                <tr>
                                                    <td></td>
                                                    <td><strong>{{__('Tiền hàng: ')}}</strong></td>
                                                    <td><span style="color: crimson; font-weight: bold;">{{ MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $totalSubTotal) }}</span></td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>