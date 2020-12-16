<!-- header css -->
<link rel="stylesheet" href="{{URL::asset("CSS/Templates/Header/header.css")}}">
<header>
    <div class="bild">
        <img src="{{URL::asset("Images/tevis.jpg")}}" alt="Tevis Logo" width="150px" height="auto">
    </div>
    <nav>
        <ul class="header-ul">
            <li class="header-li"><a href="/HiWi/main_HiWi">Dashboard Student</a></li>
            <li class="header-li"><a href="/HiWi/HiWi">Dashboard HiWi</a></li>
            <li class="header-li"><a href="/HiWi/konto_HiWi">Mein Konto</a></li>

            <form action="/pruefungsamt/logout" method="post">
                @csrf
                <li id="logout-li"><button type="submit" href="pruefungsamt/logout">Logout</button></li>
            </form>

            <a class="a-img" href="#"><img src="../Images/german.png" alt="dsf" id="german"></a>
            <a class="a-img" href="#"><img src="../Images/uk.png" alt="dsf" id="uk"></a>
        </ul>
    </nav>
</header>
