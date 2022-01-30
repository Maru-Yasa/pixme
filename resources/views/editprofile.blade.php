<x-head>Edit Profile</x-head>

<body>
<x-navbar></x-navbar>

	
<div class="container">
		<div class="row justify-content-center">

			<div class="col-6 mb-5 mt-5 p-3 my-border my-shadow">
				<h1 class="text-center">Edit Profile</h1>
					<form method="POST" class="" action="/editgeneralprofile">
						@csrf
						  <div class="mb-3">
						    <label for="username" class="form-label">Username</label>
						    <input type="text" name="username" value="{{ $user->username }}" class="form-control my-border-sub" id="username" aria-describedby="usernameHelp">
						  </div>
						  <div class="mb-3">
						    <label for="exampleInputPassword1" class="form-label">Password</label>
						    <input type="password" name="password" class="form-control my-border-sub" id="exampleInputPassword1">
						    <div id="emailHelp" class="form-text">keep this blank if you're not gonna change your password</div>
							@if ($errors->any())
	                                <div class="mt-3">
	                                    <ul>
	                                        @foreach ($errors->all() as $error)
	                                            <li class="text-danger">{{ $error }}</li>
	                                        @endforeach
	                                    </ul>
	                                </div>
	                        @endif
	                        @if (session()->has('msg_profile'))
	                            <div class="mt-3">
	                                <ul>
	                                    <li class="text-success"> {{ session()->get('msg_profile') }} </li>
	                                </ul>
	                            </div> 
	                        @endif	          
						  </div>
						  <div class="mb-3">
						  	<input type="submit" name="edit" class="my-button-green" value="Edit">
						    <a href="/profile" class="my-button-pink">cancel</a>
						  </div>				
					</form>
			</div>


			<div class="col-6 mx-2 mb-5 mt-5 p-3 my-border my-shadow">
				<h1 class="text-center">Edit Page's desc</h1>
					<form method="POST" class="" action="/editpage" id="page">
						@csrf
						  <div class="mb-3">
						    <label for="username" class="form-label">Describe about you :</label>
						    <textarea class="form-control my-border-sub" name="desc"> {{ $page->desc }} </textarea>
						   	@if (session()->has('msg_page'))
	                            <div class="mt-3">
	                                <ul>
	                                    <li class="text-success"> {{ session()->get('msg_page') }} </li>
	                                </ul>
	                            </div> 
	                        @endif
						   	@if (session()->has('msg_page_error'))
	                            <div class="mt-3">
	                                <ul>
	                                    <li class="text-danger"> {{ session()->get('msg_page_error') }} </li>
	                                </ul>
	                            </div> 
	                        @endif	
						  </div>
						  <div class="mb-3">
						  	<input type="submit" name="edit_desc" class="my-button-green" value="Edit">
						    <a href="/profile" class="my-button-pink">cancel</a>
						  </div>				
					</form>
			</div>
	</div>



<x-footer></x-footer>
</body>