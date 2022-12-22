<a data-url='{{app('UrlHelper')::admin('bannergroup', 'update')}}' class='js-post-edit' data-action-type="save">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-plus'></i>{{__(SAVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('bannergroup', 'update')}}' class="js-post-edit" data-action-type="save_edit">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i>{{__(SAVE_E_BUTTON_LABEL)}}</button>
</a>
<a href='{{app('UrlHelper')::admin('bannergroup', 'index')}}'>
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-remove'></i>{{__(EXIT_BUTTON_LABEL)}}</button>
</a>
