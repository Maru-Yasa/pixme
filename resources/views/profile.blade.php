<x-head>Profile</x-head>
<body>

<x-navbar></x-navbar>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-9 mt-5 mb-5 p-3 my-border my-shadow">
				<h1 class="text-center">Hello {{ auth()->user()->username }}</h1>
				<h5 class="text-center"> {{ $data['page']['comments_count'] }} Comment | {{ $data['page']['visitors'] }} Visitors</h5>
				<p class="text-center">{{ $data['page']['desc'] }}</p>
				<div class="mb-2">
					<div class="d-flex justify-content-center">
						<button onclick="copyToClipboard(this,'{{ $data['user']['username'] }}')" class="my-button-gold m-2">Copy link</button>
						<a href="/u/{{ auth()->user()->username }}" class="my-button-green m-2">Goto my page</a>
						<a href="/editprofile" class="my-button-yellow m-2">Edit profile</a>
						<a href="/logout" class="my-button-pink m-2">Logout</a>
					</div>
				</div>
			</div>



			@foreach ($data['comments'] as $el)

				<div class="col-9 mt-5 p-3 my-border my-shadow" id={{ $el['id'] }}>
					<div class="col-sm-12 d-flex justify-content-center">
						<div class="col-6">
							<h4 class="">Anonymous</h4>							
						</div>
						<div class="col-6 d-flex justify-content-end">
							<a class="my-button-pink" href="/deletecomment/{{ $el['id'] }}"><i class="bi bi-trash-fill"></i></a>							
						</div>
					</div>
					<p>{{  $el['comment'] }}</p>
					<span class="text-right text-muted"> {{  $el['created_at'] }}</span>
					<hr>


					@foreach ($el['sub_comments'] as $sub)
						<p class="mx-3 my-0"> <span class="fw-bold"> <?= $sub['owner'] ?> </span> : <?= $sub['comment'] ?>			

						</p>						
					@endforeach

					<form method="POST" action="/sendsubcomment" class="mt-3 row g-2">
						@csrf
						<div class="col-sm-8">
							<input type="text" name="reply_text" class="form-control my-border-sub" placeholder="type reply here" required="">
							<input type="text" name="commentId" value="<?= $el['id'] ?>" hidden>
						</div>
						<div class="col-sm">
							<input type="submit" class="my-button-green" name="reply" value="Send">		
						</div>
					</form>
				</div>

			@endforeach

			<div class="col-10 mt-5 d-flex justify-content-center">
				{{ $data['comments']->links() }}				
			</div>
		</div>

	</div>

<x-footer></x-footer>


<script>


function copyToClipboard(obj,text){
	var host = "http://"+window.location.hostname;
    let val = host+"/u/"+text;
    const selBox = document.createElement('textarea');
    selBox.style.position = 'fixed';
    selBox.style.left = '0';
    selBox.style.top = '0';
    selBox.style.opacity = '0';
    selBox.value = val;
    document.body.appendChild(selBox);
    selBox.focus();
    selBox.select();
    document.execCommand('copy');
    document.body.removeChild(selBox);
    obj.innerHTML = "Coppied to clipboard"
    obj.classList = "my-button-white m-2"
  }


</script>

</body>
</html>