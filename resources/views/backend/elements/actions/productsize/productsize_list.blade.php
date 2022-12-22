<a href='{{app('UrlHelper')::admin('productsize', 'create')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productsize', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Sửa</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productsize', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Xóa</button>
</a>
{{--<a data-url='{{app('UrlHelper')::admin('productsize', 'copy')}}' class="js-posts">--}}
{{--    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-file'></i> Sao chép</button>--}}
{{--</a>--}}
<a data-url='{{app('UrlHelper')::admin('productsize', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-ok'></i> Bật</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productsize', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-off'></i> Tắt</button>
</a>
