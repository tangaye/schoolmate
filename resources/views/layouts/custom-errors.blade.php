@if(count($errors) > 0)
    @if(count($errors) > 0)
    <div class="alert alert-danger alert-dismissable">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">
    		<i class="glyphicon glyphicon-remove-circle"></i>
    	</a>

      	<ul>
        	@foreach($errors->all() as $error)
        	  	<li>{!! $error !!}</li>
        	@endforeach
      	</ul>
    </div>
  @endif
  @endif