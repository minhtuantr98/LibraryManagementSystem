
<!DOCTYPE html>
<html>  
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Blog </title>
        <link rel="stylesheet" href="">
        <link href="https://fonts.googleapis.com/css?family=Miriam+Libre:400,700|Merriweather" rel="stylesheet">
        <link rel="icon" type="image/png" href="https://laravel.com/favicon.png">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.1/build/styles/sunburst.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <!-- Styles -->
        <style>
            a {
                    text-decoration: none;
                    color: black;
            }
            .container {
                width: 1140px;
                margin: 25px 0 0 250px;
            }
        
            #logo {
                width: 300px;
                float: left;
            }
        
            #menu {
                width: 500px;
                float: right;
                padding-top: 10px;
            }
        
            #menu a {
                color: black;
                padding: 0 10px;
                font-family: arial;
                font-size: 15px;
                text-transform: uppercase;
        
            }
            
            #menu a:hover {
                text-decoration: underline;
            }
            
            #user {
                width: 200px;
                list-style: none;
                float: right;
                margin-top: -30px;
            }

            #content {
                padding-top: 20px;
                height: auto;
                clear: both;
                margin-left: 250px;
            }
        
            #content a:hover {
                text-decoration: none;
                text-shadow: none;
                color: black;
            }
        
            #content div.card {
                margin-top: 20px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }
            
            #pagination {
                padding : 20px 0 0 250px;
            }

            footer {
                margin-top: 20px;
                width: 100%;
                height: 50px;
                border-top: solid 1px #c9cdd3;
                text-align: center;
            }
        
        </style>        
    </head>
    <body>
            <header class="container">
                <div id="logo">
                    <a href="/" class="flex items-center no-underline text-brand">
                        <svg xmlns="http://www.w3.org/2000/svg" width="45" viewBox="0 0 84.1 57.6">
                            <path fill="#FB503B"
                                d="M83.8 26.9c-.6-.6-8.3-10.3-9.6-11.9-1.4-1.6-2-1.3-2.9-1.2s-10.6 1.8-11.7 1.9c-1.1.2-1.8.6-1.1 1.6.6.9 7 9.9 8.4 12l-25.5 6.1L21.2 1.5c-.8-1.2-1-1.6-2.8-1.5C16.6.1 2.5 1.3 1.5 1.3c-1 .1-2.1.5-1.1 2.9S17.4 41 17.8 42c.4 1 1.6 2.6 4.3 2 2.8-.7 12.4-3.2 17.7-4.6 2.8 5 8.4 15.2 9.5 16.7 1.4 2 2.4 1.6 4.5 1 1.7-.5 26.2-9.3 27.3-9.8 1.1-.5 1.8-.8 1-1.9-.6-.8-7-9.5-10.4-14 2.3-.6 10.6-2.8 11.5-3.1 1-.3 1.2-.8.6-1.4zm-46.3 9.5c-.3.1-14.6 3.5-15.3 3.7-.8.2-.8.1-.8-.2-.2-.3-17-35.1-17.3-35.5-.2-.4-.2-.8 0-.8S17.6 2.4 18 2.4c.5 0 .4.1.6.4 0 0 18.7 32.3 19 32.8.4.5.2.7-.1.8zm40.2 7.5c.2.4.5.6-.3.8-.7.3-24.1 8.2-24.6 8.4-.5.2-.8.3-1.4-.6s-8.2-14-8.2-14L68.1 32c.6-.2.8-.3 1.2.3.4.7 8.2 11.3 8.4 11.6zm1.6-17.6c-.6.1-9.7 2.4-9.7 2.4l-7.5-10.2c-.2-.3-.4-.6.1-.7.5-.1 9-1.6 9.4-1.7.4-.1.7-.2 1.2.5.5.6 6.9 8.8 7.2 9.1.3.3-.1.5-.7.6z">
                            </path>
                        </svg>
                        <span class="text-xl ml-3" style="color:orange">Library System Management</span>
                    </a>
                </div>
                <div id="menu">     

                    {{-- @foreach ($menu as $value) 
                    <a href="/{{ $value->locale.'/category/'.$value->slug }} ">{{ $value->name }}</a>
                    @endforeach
                     --}}
                    @if(Auth::check())
                    <li id="user" class="nav-item dropdown">
                            <a style="margin-left:42px;margin-top:28px" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->is_admin == 0)
                                <a class="dropdown-item" href="/user/profile">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ '/user/post' }}">
                                    {{ __('Cart') }}
                                </a>
                                @else
                                <a class="dropdown-item" href="/admin/profile">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ '/admin/dashboard' }}">
                                    {{ __('Dashboard') }}
                                </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                    </li>
                    @else 
                    <a style="color:red" href="/login">Login</a>
                    @endif
                </div>
            </header>

            <div id="content" class="container">   
                @yield('content')
            </div>

            <footer style="clear:both">
                <span>Follow the <a style="text-decoration:underline" href="">Developer : Tuan & Khanh</a></span>
            </footer>
    </body>
</html>