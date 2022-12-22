<section class="hk-sec-wrapper hk-sec-header">
    <div class="hk-pg-header js-admin-action">
        <div class="row">
            <div class="col-md-3">
                <h4 class="hk-pg-title btn btn-success content-action">
                    {{ Str::of($title)->title()->replace('-', ' ') }}
                </h4>
            </div>
            <div class="col-md-9">
                <div class="btn-action">
                    @if(isset($action)) @include($action) @endif
                </div>
            </div>
        </div>
    </div>
</section>
