<a data-url='{{app('UrlHelper')::admin('product', 'duplicate')}}' class='js-post-copy' data-action-type="save">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Lưu</button>
</a>
<a data-url='{{app('UrlHelper')::admin('product', 'duplicate')}}' class="js-post-copy" data-action-type="save_edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Lưu và Sửa</button>
</a>
<a href='{{app('UrlHelper')::admin('product', 'index', ['type' => $type])}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Thoát</button>
</a>