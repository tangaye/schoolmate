<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
        </div>
      </div>

      @if(!Auth::user()->hasType('\App\Guardian'))
         @include('layouts.partials.admin-navigation')
      @elseif(Auth::user()->hasType('\App\Guardian'))
        @include('layouts.partials.guardian-navigation')
      @endif 
    </section>
    <!-- /.sidebar -->
  </aside>