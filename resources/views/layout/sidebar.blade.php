<div id="sidebar" class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
    <ul class="nav nav-pills nav-stacked nav-kaoyan">
        <li @if($menu == 1) class="active"@endif><a href="/shuoshuo">研友交流</a></li>
        <li @if($menu == 2) class="active"@endif><a href="/examdata">资料下载</a></li>
        <li @if($menu == 3) class="active"@endif><a href="/experience/">复习攻略</a></li>
        <li @if($menu == 4) class="active"@endif><a href="/question">问答</a></li>
        <li @if($menu == 5) class="active"@endif><a href="/zhenti">真题</a></li>
        @if(\Auth::user())
            <li><a target="_blank" href="/user/{{ \Auth::user()->id }}">个人中心</a></li>
        @endif
    </ul>
</div>