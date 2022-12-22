<a href='{{app('UrlHelper')::admin('order', 'index')}}' class='button-refresh'>
    <button class='btn btn-outline-primary btn-action-80'><i class='glyphicon glyphicon-refresh'></i>{{__(REFRESH_BUTTON_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('order', 'exportOrder')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-120'><i class='glyphicon glyphicon-pencil'></i>{{__(EXPORT_DATA_LABEL)}}</button>
</a>
<a data-url='{{app('UrlHelper')::admin('order', 'exportCustomer')}}' class="js-posts">
    <button class='btn btn-outline-primary btn-action-150'><i class='glyphicon glyphicon-pencil'></i>{{__(EXPORT_CUSTOMER_LABEL)}}</button>
</a>