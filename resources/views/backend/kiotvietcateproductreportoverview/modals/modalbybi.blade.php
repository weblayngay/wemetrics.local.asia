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
    if($cateProduct == '%')
    {
      $strIntroCateProduct = 'tất cả các nhóm sản phẩm';
      $cateProductName = 'Tất cả các nhóm sản phẩm';
    }
    else
    {
      $cateProductName = $productModel::CATEGORIES[$cateProduct];
      $strIntroCateProduct = 'theo nhóm sản phẩm: '.'<span class="text-primary"><strong>'.$cateProductName.'</strong></span>';
    }
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
                <i class="fa-regular fa-circle-arrow-right"></i> {!! 'Nhóm sản phẩm phân tích: '.'<strong><span class="text-primary">'.$strIntroCateProduct.'</span></strong>' !!}
              </p>
            </ul>

          {{-- Dự báo theo nhóm sản phẩm --}}
          @if(!empty($totalCateProduct))
            @include('backend.kiotvietcateproductreportoverview.modals.items.totalcateproduct', 
            [
                'collapseId' => 'totalCateProductCollapse',
                'totalCateProduct' => $totalCateProduct,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => $cateProductName,
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif

          {{-- Dự báo theo nhóm sản phẩm/ cửa hàng --}}

          {{-- Begin nhóm túi đeo --}}
          @if(!empty($tuideoByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.tuideobybranch', 
            [
                'collapseId' => 'tuideoCollapse',
                'action' => $action,
                'tuideoByBranch' => $tuideoByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Túi đeo',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])          
          @endif
          {{-- End nhóm túi đeo --}}

          {{-- Begin nhóm cặp xách --}}
          @if(!empty($capxachByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.capxachbybranch', 
            [
                'collapseId' => 'capxachCollapse',
                'action' => $action,
                'capxachByBranch' => $capxachByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Cặp xách',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif 
          {{-- End nhóm cặp xach --}}

          {{-- Begin nhóm túi quàng --}}
          @if(!empty($tuiquangByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.tuiquangbybranch', 
            [
                'collapseId' => 'tuiquangCollapse',
                'action' => $action,
                'tuiquangByBranch' => $tuiquangByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Túi quàng',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif 
          {{-- End nhóm túi quàng --}}

          {{-- Begin nhóm túi xách --}}
          @if(!empty($tuixachByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.tuixachbybranch', 
            [
                'collapseId' => 'tuixachCollapse',
                'action' => $action,
                'tuixachByBranch' => $tuixachByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Túi xách',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif           
          {{-- End nhóm túi xách --}}

          {{-- Begin nhóm bóp ví --}}
          @if(!empty($bopviByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.bopvibybranch', 
            [
                'collapseId' => 'bopviCollapse',
                'action' => $action,
                'bopviByBranch' => $bopviByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Bóp ví',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif            
          {{-- End nhóm bóp ví --}}

          {{-- Begin nhóm balo --}}
          @if(!empty($baloByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.balobybranch', 
            [
                'collapseId' => 'baloCollapse',
                'action' => $action,
                'baloByBranch' => $baloByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Balo',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif           
          {{-- End nhóm balo --}}

          {{-- Begin nhóm túi du lịch --}}
          @if(!empty($tuidulichByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.tuidulichbybranch', 
            [
                'collapseId' => 'tuidulichCollapse',
                'action' => $action,
                'tuidulichByBranch' => $tuidulichByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Túi du lịch',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif            
          {{-- End nhóm túi du lịch --}}

          {{-- Begin nhóm dây nịt --}}
          @if(!empty($daynitByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.daynitbybranch', 
            [
                'collapseId' => 'daynitCollapse',
                'action' => $action,
                'daynitByBranch' => $daynitByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Dây nịt',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif          
          {{-- End nhóm dây nịt --}}

          {{-- Begin nhóm phụ kiện --}}
          @if(!empty($phukienByBranch))
            @include('backend.kiotvietcateproductreportoverview.modals.items.phukienbybranch', 
            [
                'collapseId' => 'phukienCollapse',
                'action' => $action,
                'phukienByBranch' => $phukienByBranch,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => 'Phụ kiện',
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif           
          {{-- End nhóm phụ kiện --}}

          {{-- Begin các mặt hàng bán chạy --}}
          @if(!empty($totalTopProductByDate))
            @include('backend.kiotvietcateproductreportoverview.modals.items.totaltopproductbydate', 
            [
                'collapseId' => 'totaltopproductCollapse',
                'action' => $action,
                'totalTopProductByDate' => $totalTopProductByDate,
                'branch' => $branch,
                'branchName' => $branchName,
                'cateProductName' => $cateProductName,
                'cateProduct' => $cateProduct,
                'frmDate' => $frmDate,
                'toDate' => $toDate,
                'beginYear' => $beginYear,
                'now' => $now,
                'adgroup' => $adgroup,
                'mLimit' => $mLimit
            ])
          @endif           
          {{-- End các mặt hàng bán chạy --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Đóng')}}</button>
        </div>
      </div>
    </div>
  </div>