<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show c-sidebar-minimized" id="sidebar">
    <div class="c-sidebar-brand d-md-down-none">
        <img src="https://via.placeholder.com/150" width="46"
             class="c-sidebar-brand-full" alt="...">
        <img src="https://via.placeholder.com/150" width="46" height="46"
             class="c-sidebar-brand-minimized" alt="...">
    </div>
    <ul class="c-sidebar-nav">
        @include('adminPanel.layouts.menu')
        <div class="d-none ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="d-none ps__rail-y" style="top: 0px; height: 692px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 369px;"></div>
        </div>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
