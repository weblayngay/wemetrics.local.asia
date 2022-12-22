<?php
/**
 * @var \App\Models\Menu $menuModel
 */
$menuModel = app('Menu');
$tutorialMenus = $menuModel::parentQuery()
                ->where('group_id', 7)
                ->join(MENU_GROUP_TBL, MENU_GROUP_TBL.'.menugroup_id', MENU_TBL . '.group_id')
                ->where('menu_status', 'activated')
                ->orderBy('menu_number', 'asc')
                ->get();

$policyMenus = $menuModel::parentQuery()
                ->where('group_id', 8)
                ->join(MENU_GROUP_TBL, MENU_GROUP_TBL.'.menugroup_id', MENU_TBL . '.group_id')
                ->where('menu_status', 'activated')
                ->orderBy('menu_number', 'asc')
                ->get();

$emailAddress = app('Config')->getConfig('email');
$phoneNumber = app('Config')->getConfig('phone');
$addressValue = app('Config')->getConfig('address')
?>

<div class="footer">
    <div class="footer-full">
        <div class="footer-static-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="footer-block first-child">
                            <h4>Về chúng tôi</h4>
                            <p class="footer-desc">{{app('Config')->getConfig('short_about_us')}}</p>
                            <ul class="footer-contact">
                                <!--<li class="address add"><i class="fas fa-map-marker"></i>{{app('Config')->getConfig('address')}}</li>-->
								<li><i class="fas fa-map-marker-alt"></i>{!! $addressValue !!}</li>
								<li><i class="fas fa-phone-alt"></i><a href="tel:{!! $phoneNumber !!}" >{!! $phoneNumber !!}</a></li>
								<li><i class="fas fa-envelope"></i></i><a href="mailto:{!! $emailAddress !!}" >{!! $emailAddress !!}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="footer-block">
                            @if($tutorialMenus->count())
                            <h4>{{$tutorialMenus->first()->menugroup_name}}</h4>
                            <ul>
                                @foreach($tutorialMenus as $menu)
                                    <li><a href="{{$menu->menu_url}}">{{$menu->menu_name}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="footer-block">
                            @if($policyMenus->count())
                                <h4>{{$policyMenus->first()->menugroup_name}}</h4>
                                <ul>
                                    @foreach($policyMenus as $menu)
                                        <li><a href="{{$menu->menu_url}}">{{$menu->menu_name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <h4></h4>                                
                        </div>
                        <div class="footer-block">
                            <h4>{{__('Kênh Facebook DAIKONVN')}}</h4>
                            <div class="footer-iframe">
                                {!! app('Config')->getConfig('facebook_fan_page_iframe') !!}
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-static-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="copyright">
                            <?php echo app('Config')->getConfig('copyright') ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="payment f-right">
                            {{--<a href="#">
                                <img src="images/payment/1.png" alt="Giày thể thao DaiKon, Mỹ phẩm Thái Lan DaiKon">
                            </a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
