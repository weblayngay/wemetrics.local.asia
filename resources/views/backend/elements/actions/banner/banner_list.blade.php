<a href='{{app('UrlHelper')::admin('banner', 'index')}}' class='button-refresh'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-refresh'></i>{{__(REFRESH_BUTTON_LABEL)}}</button>
</a>
<a href='{{app('UrlHelper')::admin('banner', 'create')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-plus'></i>{{__(ADD_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-pencil'></i>{{__(EDIT_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-remove'></i>{{__(DEL_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'copy')}}' class="js-copy">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-file'></i>{{__(COPY_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'sort')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon ti-split-v'></i>{{__(SORT_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-ok'></i>{{__(ACTIVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('banner', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-off'></i>{{__(INACTIVE_BUTTON_LABEL)}}</button>
</a>
