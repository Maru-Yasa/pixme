<x-head>Home</x-head>
<body>

    <x-navbar></x-navbar>

    <div class="container">
        <div class="row justify-content-center">

            @guest
            <div class="col-6 mt-5 my-border my-shadow">
                <h1 class="text-center mb-3 mt-2">Login / Register</h1>
                <form method="POST" action="/">
                    @csrf
                      <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control my-border-sub" id="username" aria-describedby="usernameHelp">
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control my-border-sub" id="exampleInputPassword1">
                        @if ($errors->any())
                                <div class="mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                        @if (session()->has('msg'))
                            <div class="mt-3">
                                <ul>
                                    <li class="text-success"> {{ session()->get('msg') }} </li>
                                </ul>
                            </div> 
                        @endif
                      </div>
                      <div class="mb-3">
                        <input type="submit" name="submit" class="my-button-black" value="Login">
                        <input type="submit" name="submit" class="my-button-white" value="Register">
                      </div>                
                </form>
            </div>
            @endguest
            @auth
                <div class="col-7 mx-5 my-border my-shadow p-5" style="margin-top:90px;">
                    <h1 class="text-center mb-3">You've alredy loggedin</h1>
                    <div class="d-flex justify-content-center">
                        <a class="button my-button-green mx-1" href="/profile">Goto My Profile</a>
                        <a class="button my-button-yellow mx-1" href="/u/{{ auth()->user()->username }}">Goto My Page</a>
                    </div>
                </div>
            @endauth

            <div class="col-9 mb-5 p-5 my-border my-shadow blue" id="about" style="margin-top: 250px;">
                <div class="col-12 mb-5" >
                    <h1 >About Pixme</h1>
                    <p class="" id="">  Pixme is a web that designed to create the next level of user experiences
                        about Question and Ask, with retro and unique design it gives more special experiences. User can ask someone anonymously and someone who got asked can reply the questions. You may also share the link or put it on social media, like Instagram, Facebook, WhatsApp, SnapChat, etc
                    </p>
                </div>

                <div class="col-12 " style="">
                    <h1>About Developer</h1>
                    <p class="">This entire website built by one person called Maru. Maru actually isn't his real name but his internet name, you can also find on <a href="https://github.com/Maru-Yasa">GitHub</a>.
                    At first this website was built just for his school assigment, but eventtualy the project goes intereting and Maru remake entire website with <a href="https://laravel.com/">Laravel</a>
                    </p>
                </div>
                
            </div>

            <div class="col-9 mb-5 mt-5 p-5 my-border my-shadow" id="donate">
                <div class="col-12" >
                    <h1 >Support Developer</h1>
                    <p class="" id="">  Due to this website not gonna put ads in, and the server isn't free,
                        you can donate and support this website by clicking Donate button below
                    </p>
                    <a href="https://saweria.co/Maru" class="buttn my-button-gold">Donate</a>
                </div>
                
            </div>

        </div>
    </div>


<x-footer></x-footer>

</body>
</html>