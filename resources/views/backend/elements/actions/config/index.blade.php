<a href='{{app('UrlHelper')::admin('config', 'savecache')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-floppy-save'></i> Lưu cache</button>
</a>
<a href='{{app('UrlHelper')::admin('config', 'clearcache')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-floppy-remove'></i> Xóa cache</button>
</a>
<a href='{{app('UrlHelper')::admin('config', 'detail')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Thêm</button>
</a>
<a data-url='{{app('UrlHelper')::admin('config', 'detail')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Sửa</button>
</a>
