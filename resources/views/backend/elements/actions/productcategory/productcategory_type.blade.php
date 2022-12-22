<?php
$type = request()->get('type', 'shoes');
?>
<a href='{{app('UrlHelper')::admin('productcategory', 'detail', ['type' => $type])}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a href='{{app('UrlHelper')::admin('productcategory', 'index')}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Thoát</button>
</a>
