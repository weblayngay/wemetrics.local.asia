<div class="notification card-body">
    @if (session()->has(SESSION_SUCCESS_KEY))
        <div class="alert alert-success alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span> {{ session()->get(SESSION_SUCCESS_KEY) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @php session()->remove(SESSION_SUCCESS_KEY);@endphp
    @endif
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
    @if (session()->has(SESSION_ERROR_KEY))
        <div class="alert alert-danger alert-wth-icon alert-dismissible fade show" role="alert">
            <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span> {{ session()->has(SESSION_ERROR_KEY) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @php session()->remove(SESSION_ERROR_KEY);@endphp
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
</div>

