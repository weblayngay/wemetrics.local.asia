<a href='{{app('UrlHelper')::admin('adminuser', 'detail')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a data-url='{{app('UrlHelper')::admin('adminuser', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Sửa</button>
</a>
<a data-url='{{app('UrlHelper')::admin('adminuser', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Xóa</button>
</a>
<a data-url='{{app('UrlHelper')::admin('adminuser', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-ok'></i> Bật</button>
</a>
<a data-url='{{app('UrlHelper')::admin('adminuser', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-off'></i> Tắt</button>
</a>
