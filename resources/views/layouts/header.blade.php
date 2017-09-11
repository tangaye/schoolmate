<header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>MT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>School</b>MATE</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->

          <li style="padding-right: 10px">
            @foreach($academics as $academic)
               <b class="label pull-right bg-aqua" style="margin-top: 11%; font-size: 12px;" > Academic Year: {{$academic->date_start->year}} - {{$academic->date_end->year}}</b> 
            @endforeach
          </li>

          <!-- Authentication Links -->
           @if (Auth::user())
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      {{ Auth::user()->user_name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu list-group">
                    <a style="border: none;" class="list-group-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                      </form>
                  </ul>
              </li>
          @endif
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>