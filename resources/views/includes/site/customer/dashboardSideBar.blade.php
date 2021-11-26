
<style>

    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #936f3b;
        border-color: #936f3b;
    }

</style>

<div class="col-md-3">
    <div class="list-group">
      <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action {{ (\Request::route()->getName() == 'customer.dashboard') ? ' active' : '' }}">@lang('lang.Dashboard')</a>
      <a href="{{ route('customer.order.history') }}" class="list-group-item list-group-item-action {{ ((\Request::route()->getName() == 'customer.order.history') || (\Request::route()->getName() == 'customer.order.detail') || (\Request::route()->getName() == 'customer.order.review')) ? ' active' : '' }}">@lang('lang.Order History')</a>
      <a href="{{ route('customer.profile.index') }}" class="list-group-item list-group-item-action {{ (\Request::route()->getName() == 'customer.profile.index') ? ' active' : '' }}">@lang('lang.Profile Setting')</a>
   </div> 
</div>