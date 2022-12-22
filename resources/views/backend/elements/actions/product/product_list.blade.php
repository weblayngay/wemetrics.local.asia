<a href='{{app('UrlHelper')::admin('product', 'create', ['type' => $type])}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a data-url='{{app('UrlHelper')::admin('product', 'edit')}}' data-http-query="&type={{$type}}" class="js-edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Sửa</button>
</a>
<a data-url='{{app('UrlHelper')::admin('product', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Xóa</button>
</a>
{{--<a data-url='{{app('UrlHelper')::admin('product', 'copy')}}' data-http-query="&type={{$type}}" class="js-posts">--}}
{{--    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-file'></i> Sao chép</button>--}}
{{--</a>--}}
<a data-url='{{app('UrlHelper')::admin('product', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-ok'></i> Bật</button>
</a>
<a data-url='{{app('UrlHelper')::admin('product', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-off'></i> Tắt</button>
</a>
<a href='{{app('UrlHelper')::admin('product', 'type', ['type' => $type])}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Thoát</button>
</a>
