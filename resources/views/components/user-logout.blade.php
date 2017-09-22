<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      {{ $user_name}} <span class="caret"></span>
  </a>

  <ul class="dropdown-menu list-group">
    <a style="border: none;" class="list-group-item" href="{{$slot}}"
            onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
        Logout
    </a>
    <form id="logout-form" action="{{ $slot }}" method="POST" style="display: none;">
            {{ csrf_field() }}
      </form>
  </ul>
</li>