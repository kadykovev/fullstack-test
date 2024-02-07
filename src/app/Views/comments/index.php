<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="container">
    <form action="/comments" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
            <input type="email" class="form-control" id="name" name="name" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Текст комментария</label>
            <textarea class="form-control" id="text" name="text" rows="3" ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>
<?= $this->endSection() ?>