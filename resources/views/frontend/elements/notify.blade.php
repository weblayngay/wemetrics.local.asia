@if (session('success'))
    <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
        <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
        <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ $error }}<br/>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Basic Alerts start -->
<div class="card-body">
  <div class="alert alert-success mb-2" role="alert" style="display: @if (session('success')) {{__('block')}} @else {{__('none')}} @endif;">
    <ul>
      <li><i class="bx bx-like"></i><span>{{ session('success') }}</span></li>
    </ul>
  </div>

  <div class="alert alert-danger mb-2" role="alert" style="display: @if (session('error')) {{__('block')}} @else {{__('none')}} @endif;">
    <ul>
      <li><i class="bx bx-error"></i><span>{{ session('error') }}</span></li>
    </ul>
  </div>

  <div class="notification-success alert alert-success alert-dismissible mb-2" role="alert" style="display: none;">
    <ul>
        <li><i class="bx bx-error"></i><span></span></li>
    </ul>
  </div>

  <div class="notification-error alert alert-danger alert-dismissible mb-2" role="alert" style="display: @if ($errors->any()) {{__('block')}} @else {{__('none')}} @endif ;">
    <ul>
      @foreach ($errors->all() as $error)
        <li><i class="bx bx-error"></i><span>{{ $error }}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<!-- Basic Alerts end -->
