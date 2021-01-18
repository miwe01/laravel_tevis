@section('links')
    @if ((isset($_SESSION['HiWi_UserId'])))
        <li class="header-li"><a href="/Tutor/dashboard">Dashboard HiWi</a></li>
        <li class="header-li"><a href="/Student/dashboard">Dashboard Student</a></li>
        <li class="header-li"><a href="/Student/testatbogen">{{__("Testatbogen")}}</a></li>
    @elseif((isset($_SESSION['Student_UserId'])))
        <li class="header-li"><a href="/Student/dashboard">Dashboard</a></li>
        <li class="header-li"><a href="/Student/testatbogen">{{__("Testatbogen")}}</a></li>
@elseif((isset($_SESSION['WiMi_UserId'])))
    <li class="header-li"><a href="/Tutor/dashboard">Dashboard WiMi</a></li>
@elseif((isset($_SESSION['Prof_UserId'])))
    <li class="header-li"><a href="/Professor/dashboard">Dashboard</a></li>
@elseif((isset($_SESSION['PA_UserId'])))
    <li class="header-li"><a href="/pruefungsamt">Dashboard</a></li>
@endif
@endsection
