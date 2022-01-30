<div>

    <nav class="navbar navbar-expand mb-5 navbar-light my-border-nav bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Pixme</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="/">Home</a>
            <a class="nav-link" href="/#about">About</a>
            <a class="nav-link" style="color: gold;" href="/#donate">Donate</a>
            @auth
            <a class="nav-link" href="/profile">Profile</a>
            @endauth
          </div>
        </div>
      </div>
    </nav>

</div>