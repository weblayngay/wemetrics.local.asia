<a data-url='{{app('UrlHelper')::admin('ctokenout', 'store')}}' class='js-post-add' data-action-type="save">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i>{{__(SAVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('ctokenout', 'store')}}' class="js-post-add" data-action-type="save_add">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i>{{__(SAVE_A_BUTTON_LABEL)}}</button>
</a>
<a href='{{app('UrlHelper')::admin('ctokenout', 'index')}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i>{{__(EXIT_BUTTON_LABEL)}}</button>
</a>
