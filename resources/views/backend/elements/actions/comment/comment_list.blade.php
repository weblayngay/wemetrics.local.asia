<a href='{{app('UrlHelper')::admin('comment', 'index')}}' class='button-refresh'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-refresh'></i>{{__(REFRESH_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('comment', 'edit')}}' class="js-edit">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-pencil'></i>{{__(EDIT_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('comment', 'active')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-ok'></i>{{__(ACTIVE_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('comment', 'inactive')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-off'></i>{{__(INACTIVE_BUTTON_LABEL)}}</button>
</a>
