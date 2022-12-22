<a data-url='{{app('UrlHelper')::admin('product', 'store')}}' class='js-post-add' data-action-type="save">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i> Lưu</button>
</a>
<a data-url='{{app('UrlHelper')::admin('product', 'store')}}' class="js-post-add" data-action-type="save_add">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i> Lưu và Thêm</button>
</a>
<a href='{{app('UrlHelper')::admin('product', 'index', ['type' => $type])}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i> Thoát</button>
</a>
