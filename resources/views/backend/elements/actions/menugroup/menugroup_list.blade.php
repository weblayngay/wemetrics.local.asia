<a href='{{app('UrlHelper')::admin('menugroup', 'index')}}' class='button-refresh'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-refresh'></i>{{__(REFRESH_BUTTON_LABEL)}}</button>
</a>
<a href='{{app('UrlHelper')::admin('menugroup', 'create')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-plus'></i>{{__(ADD_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('menugroup', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-pencil'></i>{{__(EDIT_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('menugroup', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-remove'></i>{{__(DEL_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('menugroup', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-ok'></i>{{__(ACTIVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('menugroup', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-off'></i>{{__(INACTIVE_BUTTON_LABEL)}}</button>
</a>
