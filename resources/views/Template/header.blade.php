<!-- header css -->
<link rel="stylesheet" href="{{URL::asset("CSS/Templates/Header/header.css")}}">
<header>
    <div class="bild">
        <img src="{{URL::asset("Images/tevis.jpg")}}" alt="Tevis Logo" width="150px" height="auto">
    </div>
    <nav>
        <ul class="header-ul">
            @yield('links')
            <li class="header-li"><a href="/konto">{{__("Mein Konto")}}</a></li>
            <form action="/logout" method="post">
                @csrf
                <li id="logout-li"><button type="submit">Logout</button></li>
            </form>
        </ul>
    </nav>
</header>
