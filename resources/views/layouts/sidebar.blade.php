<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
         @if($institution->logo)
            <img class="img-circle" src="{{ asset("images/".$institution->logo) }}" alt="institution logo">
        @else
            <img src="{{ asset("images/default-school.png") }}" class="img-circle" alt="institution logo"/>
        @endif
      </div>
      <div class="pull-left info">
        @if($institution->exists())
          <p style="white-space: nowrap; width: 150px; Overflow: hidden;text-overflow: ellipsis;">
            {{$institution->name}}
          </p>
        @else
          <p>Schoo Name</p>
        @endif
      </div>
    </div>

    @yield('sidebar-navigation')
  </section>
  <!-- /.sidebar -->
</aside>