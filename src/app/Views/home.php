<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<div class="row m-0 p-3">
  <div class="col">
    <h1>Тестовое задание на основе Docker и CodeIgniter для Fullstack разработчика</h1>
    <h2 tabindex="-1" dir="auto">Первоначальная настройка</h2>
    <ul dir="auto">
      <li>Устанавливаем Docker c <a href="https://www.docker.com/products/docker-desktop" rel="nofollow">официального сайта</a> и <a href="https://docs.docker.com/compose/install/" rel="nofollow">Docker Compose</a>;</li>
      <li>Для пользователей Windows дополнительно необходимо установить виртуальное ядро Linux, следуя данной <a href="https://docs.docker.com/desktop/install/windows-install/" rel="nofollow">инструкции</a>;</li>
      <li>Собираем контейнер командой в папке проекта <code>docker-compose up -d</code>;</li>
      <li>Инициализируем сервер:
        <ul dir="auto">
          <li>при запущенном контейнере в папке проекта запускаем команду <code>docker-compose exec web bash</code>;</li>
          <li>запускаем сборку <code>composer install</code>.</li>
        </ul>
    </li>
    </ul>
    <h2 tabindex="-1" dir="auto">Описание записи</h2>
    <ul dir="auto">
      <li>name -  почта создателя;</li>
      <li>text - Текст комментария;</li>
      <li>date - Дата создания комментария в строковом формате(выбирается создателем).</li>
    </ul>
    <h2 tabindex="-1" dir="auto">Стек</h2>
    <ul dir="auto">
      <li>PHP 7.4;</li>
      <li>MYSQL 8;</li>
      <li>CodeIgniter 4;</li>
      <li>jQuery 3;</li>
      <li>Bootstrap 4.</li>
    </ul>
    <h2 tabindex="-1" dir="auto">Задание</h2>
    <p dir="auto">Создать сайт со списком комментариев.
    Форма с добавлением комментариевдолжна располагаться под уже добавленными комментариями.</p>
    <p dir="auto">Требования к разработке:</p>
    <ul dir="auto">
      <li>добавление и удаление комментариев (желательно, без перезагрузки страницы);</li>
      <li>постраничный просмотр комментариев (3 комментария на страницу c возможностью выбора конкретной);</li>
      <li>сортировка по:
        <ul dir="auto">
          <li>id;</ li>
          <li>дате добавления;</li>
        </ul>
      </li>
      <li>направления сортировки:
        <ul dir="auto">
          <li>по возрастанию;</li>
          <li>по убыванию;</li>
        </ul>
      </li>
      <li>использование валидации почты при вводе для пользователя (с отображением ошибки), а также на сервере;</li>  
    </ul>
  </div>
</div>
<?= $this->endSection() ?>