<!-- header css -->
<link rel="stylesheet" href="{{URL::asset("CSS/Templates/Header/header.css")}}">
<header>
    <div class="bild">
        <img src="{{URL::asset("Images/tevis.jpg")}}" alt="Tevis Logo" width="150px" height="auto">
    </div>
    <nav>
        <ul class="header-ul">
            @yield('links')

            <form action="../logout" method="post">
                @csrf
             <li id="logout-li"><button type="submit" href="">Logout</button></li>
            </form>

            <a class="a-img" href="#"><img src="../Images/german.png" alt="dsf" id="german"></a>
            <a class="a-img" href="#"><img src="../Images/uk.png" alt="dsf" id="uk"></a>
        </ul>
    </nav>
</header>
