<?php
$productCategories = $data['productCategories'];
$title = isset($data['title']) ? $data['title'] : '';
$type  = $data['type'];
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.productcategory.productcategory_type'])
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <div class="table-wrap">
                            <form action="#" method="post" id="admin-form">
                                @csrf
                                <table id="datable_1" class="table table-hover w-100 display pb-30 js-main-table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if( count($productCategories) > 0)
                                        @php
                                            $index = -1;
                                            $aTag  = '';
                                            $statusTag = '';
                                            $deleteTag = '';
                                            $productCategoryArr = $productCategories->toArray();
                                        @endphp
                                        @foreach($productCategoryArr as $key => $item)
                                            @php
                                                $nextProductCategory = @next($productCategoryArr);
                                                $isClose    = false;
                                                $level      = $item['level'] - 2;
                                                $detailUrl  = app('UrlHelper')::admin('productcategory', 'detail', ['id' => $item['pcat_id'], 'type' => $type]);
                                                $deleteUrl  = app('UrlHelper')::admin('productcategory', 'delete', ['id' => $item['pcat_id'], 'type' => $type]);
                                                if ($level == 0){
                                                    $parentLeft  = $item['left'];
                                                    $parentRight = $item['right'];
                                                    $aTag .= "<div class='nested-set-model__text'><a href='". $detailUrl ."'>". $item['pcat_name'] . "</a></div>";
                                                    $statusTag .= "<div class='nested-set-model__text'>". $item['pcat_status'] . "</div>";
                                                    $deleteTag .= "<div class='nested-set-model__text'><a href='". $deleteUrl ."'>[Xóa]</a></div>";
                                                    if ((@$nextProductCategory['level'] - 2) == 0 || !$nextProductCategory){
                                                        $index++;
                                                        $isClose = true;
                                                    }
                                                }elseif($item['left'] > $parentLeft && $item['right'] < $parentRight){
                                                    $aTag .= "<div class='nested-set-model__text'>".app('NestedSetModelHelper')::notationByLevel($level)."<a href='". $detailUrl ."'>". $item['pcat_name'] . "</a></div>";
                                                    $statusTag .= "<div class='nested-set-model__text'>". $item['pcat_status'] . "</div>";
                                                    $deleteTag .= "<div class='nested-set-model__text'><a href='". $deleteUrl ."'>[Xóa]</a></div>";
                                                    if ( !$nextProductCategory || (@$nextProductCategory['level'] - 2) == 0){
                                                        $isClose = true;
                                                        $index++;
                                                    }
                                                }
                                            @endphp
                                            @if($isClose == true)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>@php echo $aTag; $aTag = '';  @endphp</td>
                                                <td>@php echo $statusTag; $statusTag = '';  @endphp</td>
                                                <td>@php echo $deleteTag; $deleteTag = '';  @endphp</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
