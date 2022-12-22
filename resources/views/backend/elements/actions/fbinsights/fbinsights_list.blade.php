<a href='{{app('UrlHelper')::admin('fbinsights', 'index')}}' class='button-refresh'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-refresh'></i>{{__(REFRESH_BUTTON_LABEL)}}</button>
</a>
<a href='{{app('UrlHelper')::admin('fbinsights', 'create')}}' class='button-add'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-plus'></i>{{__(ADD_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('fbinsights', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-pencil'></i>{{__(EDIT_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('fbinsights', 'delete')}}' class="js-deletes">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-remove'></i>{{__(DEL_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('fbinsights', 'copy')}}' class="js-copy">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-file'></i>{{__(COPY_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('fbinsights', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-ok'></i>{{__(ACTIVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('fbinsights', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-off'></i>{{__(INACTIVE_BUTTON_LABEL)}}</button>
</a>
