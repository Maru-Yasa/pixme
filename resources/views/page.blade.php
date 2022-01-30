
<x-head>{{ $data['user']['username'] }}</x-head>

<body>
	
<x-navbar></x-navbar>



	<div class="container">
		<div class="row justify-content-center">

			<div class="col-9 mt-5 mb-5 p-3 my-border my-shadow">
				<h1 class="text-center"> {{ $data['user']['username'] }}</h1>
				<h5 class="text-center"> {{ $data['page']['comments_count'] }} Comment | {{ $data['page']['visitors'] }} Visitors</h5>
				<p class="text-center">{{ $data['page']['desc'] }}</p>
			</div>

			<div class="col-9 mt-5 mb-5 p-3 my-border my-shadow">
				<h4>Send comment to {{ $data['user']['username'] }}</h4>
				<form method="POST" action="/sendcomment">
					@csrf
					<textarea type="text" name="comment_text" class="form-control my-border-sub" placeholder="type comment here"></textarea>
					<input type="text" name="user_id" value={{ $data['user']['id'] }} hidden>
						   	@if (session()->has('msg'))
	                            <div class="mt-3">
	                                <ul>
	                                    <li class="text-success"> {{ session()->get('msg') }} </li>
	                                </ul>
	                            </div> 
	                        @endif
						   	@if (session()->has('msg_error'))
	                            <div class="mt-3">
	                                <ul>
	                                    <li class="text-danger"> {{ session()->get('msg_error') }} </li>
	                                </ul>
	                            </div> 
	                        @endif	
					<input type="submit" class="my-button-green mt-2" name="send_comment" value="Send">
				</form>
			</div>

			@foreach ($data['comments'] as $el)

				<div class="col-9 mt-5 p-3 my-border my-shadow">
					<h4 class="text-left">Anonymous</h4>
					<p>{{ $el['comment'] }}</p>
					<span class="text-right text-muted"> {{ $el['created_at']}}</span>
					<hr>

					@if ($el['sub_comments'])
						@foreach ($el['sub_comments'] as $sub)
							<p class="mx-3 my-0"> <span class="fw-bold"> <?= $sub['owner'] ?> </span> : <?= $sub['comment'] ?></p>						
						@endforeach
					@endif
				</div>

			@endforeach
			<div class="col-10 mt-5 d-flex justify-content-center">
				{{ $data['comments']->links() }}				
			</div>


<x-footer></x-footer>

</body>