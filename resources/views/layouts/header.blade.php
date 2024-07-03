<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="{{ url('/') }}" class="logo">
                        <h1>KEKOST</h1>
                    </a>
                    <ul class="nav">
                        <li><a href="{{ url('/') }}">Beranda</a></li>
                        <li><a href="{{ url('/carikamar') }}">Cari Kamar</a></li>
                        <li><a href="{{ url('/hubungi') }}">Hubungi Kami</a></li>
                        @if (Auth::guard('penyewa')->check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="usernameDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::guard('penyewa')->user()->Username }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="usernameDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Akun</a> 
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-penyewa').submit();">
                                    Keluar
                                </a>
                            </div>
                        </li>
                        <form id="logout-form-penyewa" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @elseif (Auth::guard('pemilik')->check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="usernameDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-cog"></i> {{ Auth::guard('pemilik')->user()->Nama_Kost }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="usernameDropdown">
                                <a class="dropdown-item" href="{{ route('profile.pemilik') }}">Akun</a>
                                <a class="dropdown-item" href="{{ route('kamar.pemilik') }}">Kamar</a>
                                <a class="dropdown-item" href="{{ route('logout.pemilik') }}" onclick="event.preventDefault(); document.getElementById('logout-form-pemilik').submit();">
                                    Keluar
                                </a>
                            </div>
                        </li>
                        <form id="logout-form-pemilik" action="{{ route('logout.pemilik') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @else
                        <li><a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> Masuk</a></li>
                        @endif
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>




<script>
    $(document).ready(function() {
        // Handle dropdown hover behavior
        $('.dropdown-toggle').on('click', function() {
            // Remove hover effect from dropdown items when dropdown is open
            $(this).siblings('.dropdown-menu').on('shown.bs.dropdown', function() {
                $(this).find('.dropdown-item').removeClass('hover-active');
            });

            // Add hover effect back when dropdown is closed
            $(this).siblings('.dropdown-menu').on('hidden.bs.dropdown', function() {
                $(this).find('.dropdown-item').addClass('hover-active');
            });
        });
    });
</script>