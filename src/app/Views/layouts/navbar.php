<nav class="navbar navbar-expand navbar-light bg-light mx-3 mb-4 p-2">
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link <?= uri_string() === '/' ? 'fw-bold' : '' ?> text-primary" href="/">Главная</a>
      <a class="nav-item nav-link <?= uri_string() === 'comments' ? 'fw-bold' : '' ?> text-primary" href="/comments">Комментарии</a>
    </div>
  </div>
</nav>