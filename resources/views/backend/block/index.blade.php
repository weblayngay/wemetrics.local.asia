<?php
$blocks = count(@$data['blocks']) > 0 ? $data['blocks'] : [];
$title  = isset($data['title']) ? $data['title'] : '';
?>
@extends('backend.main')
@section('content')
    @include('backend.elements.content_action', ['title' => $title, 'action' => 'backend.elements.actions.block.block_index'])
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
                                        <th><input type="checkbox" class="checkAll" name="checkAll" value=""></th>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Mô tả</th>
                                        <th>Vị trí</th>
                                        <th>Trạng thái</th>
                                        <th>Id</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($blocks) > 0)
                                        @foreach($blocks as $key => $block)
                                            <tr>
                                                <th><input type="checkbox" class="checkItem" name="cid[]" value="{{ $block->block_id }}"></th>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{$block->block_name }}</td>
                                                <td>{{$block->block_description }}</td>
                                                <td><input style="width: 40px;" type="number" name="sort[]" value="{{ $block->block_sorted }}"><span style="display: none">{{$block->block_sorted}}</span></td>
                                                <td>{{$block->block_status }}</td>
                                                <td>{{$block->block_id}}</td>
                                            </tr>
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
