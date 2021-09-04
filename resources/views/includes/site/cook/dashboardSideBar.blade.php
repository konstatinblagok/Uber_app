
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
      <a href="{{ route('cook.dashboard') }}" class="list-group-item list-group-item-action {{ (\Request::route()->getName() == 'cook.dashboard') ? ' active' : '' }}">Dashboard</a>
      <a href="{{ route('cook.meal.index') }}" class="list-group-item list-group-item-action {{ ((\Request::route()->getName() == 'cook.meal.index') || (\Request::route()->getName() == 'cook.meal.create') || (\Request::route()->getName() == 'cook.meal.edit')) ? ' active' : '' }}">Meal Management</a>
      <a href="{{ route('cook.profile.index') }}" class="list-group-item list-group-item-action {{ (\Request::route()->getName() == 'cook.profile.index') ? ' active' : '' }}">Profile Setting</a>
      <a href="{{ route('cook.billing.info.index') }}" class="list-group-item list-group-item-action {{ (\Request::route()->getName() == 'cook.billing.info.index') ? ' active' : '' }}">Billing Information</a>     
      <a href="{{ route('cook.order.history') }}" class="list-group-item list-group-item-action {{ ((\Request::route()->getName() == 'cook.order.history') || (\Request::route()->getName() == 'cook.order.detail') || (\Request::route()->getName() == 'cook.order.review')) ? ' active' : '' }}">Order History</a>
      <a href="{{ route('cook.account.index') }}" class="list-group-item list-group-item-action {{ ((\Request::route()->getName() == 'cook.account.index') || (\Request::route()->getName() == 'cook.account.withdraw.amount')) ? ' active' : '' }}">Account Management</a>     
   </div> 
</div>