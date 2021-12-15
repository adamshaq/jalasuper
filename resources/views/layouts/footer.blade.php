    <!-- Footer -->
    <div class="navbar navbar-expand-lg navbar-light">
        <div class="text-center d-lg-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                {{ env("APP_NAME")." ".env("APP_INST") }} &copy; {{ date('Y') }} &nbsp; {{round(microtime(true) - LARAVEL_START, 3)}}
            </button>
        </div>

        <div class="navbar-collapse collapse" id="navbar-footer">
            <span class="navbar-text">
                {{ env("APP_NAME")." ".env("APP_INST") }} &copy; {{ date('Y') }} 
            </span>

            <ul class="navbar-nav ml-lg-auto">
                {{-- &nbsp; This page took {{round(microtime(true) - LARAVEL_START, 3)}} seconds to render --}}
            </ul>
        </div>
    </div>
    <!-- /footer -->