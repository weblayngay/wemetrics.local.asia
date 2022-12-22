@php
    use App\Helpers\MoneyHelper;
    use App\Helpers\DateHelper;
    use App\Helpers\StringHelper;
    //
    use App\Http\Controllers\Backend\Intergrate\Kiotviet\Branch\KiotvietBranchController;
    $branchCtrl = new KiotvietBranchController();
    //
    use VienThuong\KiotVietClient\Model\Product; 
    $productModel = new Product();
    // 
    if($branch == '%')
    {
      $strIntroBranch = 'tất cả các cửa hàng';
      $branchName = 'Tất cả cửa hàng';
    }
    else
    {
      $branchData = $branchCtrl->getBranchById($branch);
      $branchName = $branchData->getBranchName();
      $strIntroBranch = 'theo cửa hàng: '.'<span class="text-primary"><strong>'.$branchName.'</strong></span>';
    }
    //
    $dataProductInventory = $totalProductInventory->first();
    $productName = $dataProductInventory->productName;
    $strIntroProduct = 'theo sản phẩm: '.'<span class="text-primary"><strong>'.$productName.'</strong></span>';
@endphp
<!-- Modal -->
  <div class="modal fade" id="{{__($modalId)}}" tabindex="-1" role="dialog" aria-labelledby="biModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="text-dark" id="biModalLongTitle">
            <strong>{{__($title)}}</strong>
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <p class="pt-0">
               <i class="fa-regular fa-circle-arrow-right"></i> {!! 'Thời gian phân tích: từ '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>' !!}
              </p>
              <p class="pt-0">
                <i class="fa-regular fa-circle-arrow-right"></i> {!! 'Cửa hàng phân tích: '.'<strong><span class="text-primary">'.$strIntroBranch.'</span></strong>' !!}
              </p>
              <p class="pt-0">
                <i class="fa-regular fa-circle-arrow-right"></i> {!! 'Sản phẩm phân tích: '.'<strong><span class="text-primary">'.$strIntroProduct.'</span></strong>' !!}
              </p>
            </ul>

          {{-- Begin tình hình nhập xuất tồn --}}
          @if(!empty($totalProductInventory))
            <p class="pt-0">
              <h5 class="text-primary">
                <strong>
                  <a data-toggle="collapse" href="#totalProductInventoryCollapse" role="button" aria-expanded="false" aria-controls="totalProductInventoryCollapse">
                    <ul class="list-group">
                      <li class="list-group-item btn btn-primary">
                        <i class="fa-solid fa-lightbulb-on"></i> {!!__('Tình hình nhập xuất tồn '.'<span class="text-yellow"><strong>'.$productName.'</strong></span>'.' theo cửa hàng')!!}
                      </li>
                    </ul>
                  </a>
                </strong>
              </h5>
            </p>
            @php
                $totalSubTotal = 0;
                $totalQuantity = 0;
                $totalPurchaseQuantity = 0;
                $totalOnHand = 0;
            @endphp
            {{-- Get Total --}}
            @foreach($totalProductInventory as $key => $item)
              @php
                  $totalSubTotal += $item->salesSubTotal;
                  $totalQuantity += $item->salesQuantity;
                  $totalPurchaseQuantity += $item->purchaseQuantity;
                  $totalOnHand += intval($item->getOnHand());
              @endphp
            @endforeach
            @foreach($totalProductInventory as $key => $item)
              @php
                  // Quantity Percent
                  if($totalQuantity > 0)
                  {
                    $quantityPercent = Round($item->salesQuantity / $totalQuantity * 100, 0);
                  }
                  else
                  {
                    $quantityPercent = 0;
                  }
                  // Subtotal Percent
                  if($totalSubTotal > 0)
                  {
                    $subTotalPercent = Round($item->salesSubTotal / $totalSubTotal * 100, 0); 
                  }
                  else
                  {
                    $subTotalPercent = 0;
                  }                                      
                  // Purchase Quantity percent
                  if($totalPurchaseQuantity > 0)
                  {
                    $purchaseQuantityPercent = Round($item->purchaseQuantity / $totalPurchaseQuantity * 100, 0);  
                  }
                  else
                  {
                    $purchaseQuantityPercent = 0;
                  }
                  // Onhand Percent
                  if($totalOnHand > 0)
                  {
                    $onHandPercent = Round(intval($item->getOnHand()) / $totalOnHand * 100, 0); 
                  }
                  else
                  {
                    $onHandPercent = 0;
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
                  // Lấy ngày nhập kho xa nhất và gần nhất
                  $maxcreatedDate = DateHelper::getDate('d-m-Y', $item->maxcreatedDate);
                  $mincreatedDate = DateHelper::getDate('d-m-Y', $item->mincreatedDate);                                                                                                                                                        
              @endphp
                <div class="collapse" id="totalProductInventoryCollapse">
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
                                <h6 class="text-primary font-weight-bolder"><i class="fa-solid fa-store"></i> {{ Str::title($item->getBranchName()) }}</h6>
                              </p>

                              {{-- Hiển thị số lượng bán --}}
                              <p class="mb-0">
                                <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Số lượng bán: '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getQuantity('', $item->getQuantity()).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$quantityPercent.'%'.'</span>' !!}
                              </p>

                              {{-- Hiển thị tiền hàng --}}
                              @if($adgroup == 1 || $adgroup == 2)
                                <p class="mb-0">
                                  <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Tiền hàng thu: '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getMoney(MASTER_CURRENCY_SYMBOL, $item->getSubTotal()).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$subTotalPercent.'%'.'</span>' !!}
                                </p>
                              @endif

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
                              @if($item->purchaseQuantity > 0)
                                <p class="mb-0">
                                  <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Lượng hàng nhập kho từ đầu năm đến hiện tại: '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getQuantity('', $item->purchaseQuantity).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$purchaseQuantityPercent.'%'.'</span>' !!}
                                </p>
                              @else
                                <p class="mb-0">
                                  <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Không tồn tại dữ liệu nhập kho trong năm'.'</strong>' !!}
                                </p>
                              @endif

                              {{-- Hiển thị số lượng tồn kho --}}
                              @if($item->getOnHand() > 0)
                                <p class="mb-0">
                                  <i class="fa-solid fa-circle-info text-danger"></i> {!! ' <strong>'.'Lượng hàng tồn kho hiện tại: '.'</strong><span class="text-danger font-weight-bolder">'.MoneyHelper::getQuantity('', $item->getOnHand()).'</span>'.'.'.'<strong>'.' Tỷ lệ: '.'</strong><span class="text-danger font-weight-bolder">'.$onHandPercent.'%'.'</span>' !!}
                                </p>
                              @else
                                <p class="mb-0">
                                  <i class="fa-solid fa-circle-info text-danger"></i> {!! '<strong>'.'Hàng đã bán hết không còn tồn kho đến hiện tại'.'</strong>' !!}
                                </p>
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
                                    {!! Str::title($item->getBranchName()). ' bán chạy '.'<span class="text-primary font-weight-bolder">'.$productName.'</span>'.' trong thời gian '.'<strong>'.$frmDate.'</strong>'.' đến '.'<strong>'.$toDate.'</strong>'.'. Nên tăng cường bán mặt hàng này' !!}
                                  </span>
                                </p>
                              @endif                                 
                          </div>
                        </div>
                    </div>
                  </div>
                </div>  
            @endforeach
          @endif
          {{-- End các mặt hàng bán chạy --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Đóng')}}</button>
        </div>
      </div>
    </div>
  </div>