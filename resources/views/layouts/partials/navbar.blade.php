<!-- Navigation -->
<nav class="navbar fixed-top navbar-expand-md  @if(Request::is('/') || Request::is('faqs')) navbar-transparent navbar-color-on-scroll @endif" color-on-scroll="100">
    <div class="container-md">
        <a class="navbar-brand" href="/">Polk Health</a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="far fa-bars"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Locations</a>
                </li>--}}
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Testing Sites</a>
                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="/faqs">FAQs</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/home">Registration</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{--<span class="fad fa-sign-out mr-1"></span> --}}Sign out
                    </a> 

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>