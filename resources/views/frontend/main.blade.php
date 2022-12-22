<?php
/**
 * @var \App\Helpers\ControllerHelper $controllerHelper
 */
$controllerHelper = app('ControllerHelper');
$routeArray = $controllerHelper::getActionAndController();

$actionName = $routeArray['action'];
$controllerName = $routeArray['controller'];
?>
<!doctype html>
<html class="no-js" lang="vi">
<head>
</head>
	<body>
		<div class="body-wrapper">
		    @yield('frontend_content')
		</div>
		@include('frontend.elements.javascript')
	</body>
</html>
