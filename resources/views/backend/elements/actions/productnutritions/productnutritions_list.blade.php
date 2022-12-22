<a href='{{app('UrlHelper')::admin('productnutritions', 'create')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productnutritions', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Sửa</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productnutritions', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Xóa</button>
</a>
{{--<a data-url='{{app('UrlHelper')::admin('productnutritions', 'copy')}}' class="js-posts">--}}
{{--    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-file'></i> Sao chép</button>--}}
{{--</a>--}}
<a data-url='{{app('UrlHelper')::admin('productnutritions', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-ok'></i> Bật</button>
</a>
<a data-url='{{app('UrlHelper')::admin('productnutritions', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-off'></i> Tắt</button>
</a>
