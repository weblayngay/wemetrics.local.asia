<?php
	/**
	 * @var \App\Helpers\ControllerHelper $controllerHelper
	 */
	use Illuminate\Config\Repository as Config;
	$controllerHelper = app('ControllerHelper');
	$routeArray = $controllerHelper::getActionAndController();
	$actionName = $routeArray['action'];
	$controllerName = $routeArray['controller'];
	$companyOfficial = app('Config')->getConfig('trang-official', '');
	$companyName = app('Config')->getConfig('ten-cong-ty', '');
	$companyLogo = app('Config')->getConfig('logo-cong-ty-main', '');
	$companyFavicon = app('Config')->getConfig('favicon-cong-ty-main', '');
	$appUrl = Config('app.url');
	$title = $campaign->campaign_name;
?>
<!DOCTYPE html>
<html class="no-js" lang="vi">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="vi">
	<meta name="geo.region" content="VN">
	<meta name="geo.placename" content="Ho Chi Minh City">
	<meta name="geo.position" content="10.823099;106.629664">
	<meta name="ICBM" content="10.823099, 106.629664">
	<meta property="og:locale" content="vi_VN">
	<meta property="og:type" content="website">
	<meta property="og:title" content="Lee&Tee - Túi xách thương hiệu Việt - Túi da thời trang">
	<meta property="og:url" content="{{__($appUrl)}}">
	<meta property="og:site_name" content="{{__($companyName)}}">
	<meta property="og:description" content="Túi da thời trang LeeAndTee phong cách cổ điển, dễ phối đồ, phù hợp với mọi đối tượng, thương hiệu Việt Nam">
	<meta property="og:image" content="{{__($companyLogo)}}">
	<meta name="robots" content="INDEX,NOFOLLOW">
	<meta name="keywords" content="túi xách da, cặp sách, túi bác hồ, balo laptop, túi Ipad, bóp ví, túi da thời trang, túi dành cho nữ, túi nam, cửa hàng túi xách">
	<meta name="description" content="Túi da thời trang LeeAndTee phong cách cổ điển, dễ phối đồ, phù hợp với mọi đối tượng, thương hiệu Việt Nam">
	<meta name="generator" content="3T SOFTWARE AND SOLUTIONS MANAGEMENT">
	<link href="{{__($companyFavicon)}}" rel="shortcut icon" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,500i,600,700&amp;display=swap" rel="stylesheet">
	{{-- <base href="{{__($appUrl)}}"> --}}
	{{-- <title>@php echo strtoupper($_SERVER['HTTP_HOST']); @endphp - COUPON</title> --}}
	<title>@php echo strtoupper(parse_url($companyOfficial, PHP_URL_HOST).'-'.$title); @endphp</title>
	@include('frontend.elements.css')
</head>
	<body>
		<div class="body-wrapper">
		    @foreach($blocks as $block)
		        @include('frontend.page.coupon-2022-08.childrens.' . $block->block_code, ['block' => $block])
		    @endforeach
		</div>
		@include('frontend.elements.javascript')
		{{-- BEGIN: ajax/locate-ajax --}}
		@include('frontend.page.coupon-2022-08.childrens.ajax.get-voucher-ajax')
		{{-- END: ajax/locate-ajax --}}
	</body>
</html>
