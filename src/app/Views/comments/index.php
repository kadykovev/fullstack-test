<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>

<div class="row m-0 p-3">
    <div class="coll">
    <p>
        В базе две таблицы "names" и "comments". Сортировка по id - это сортировка по имени пользователя,
        по дате - по дате добавления комментария. Добавление, удаление комметариев, изменение сортировки,
        переход по страницам происходит без перезагрузки страницы. Валидация введенных данных на стороне
        клиента и на стороне сервера. Форма сортировки появляется после 2-го добавленного комметнария,
        пагинация после 4-го добавленного комментария.
    </p>
</div>
<style>
    span.error {
        color: #dc3545;
        font-size: .875em;
    }
</style>
<div id="comments-container" class="row p-0 m-0 mt-3"></div>
<div id="form-container" class="row p-3 m-0">
    <div class="row px-0 pt-2 pb-3 m-0 border bg-light rounded">
        <div class="col">
            <form id="commentForm">
                <div class="mb-3">
                    <label for="name" class="form-label">Имя <span class="fw-light text-muted">(адрес электронной почты)</span></label>
                    <input class="form-control" id="name" name="name">
                    <div id="name-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Текст комментария</label>
                    <textarea class="form-control" id="text" name="text" rows="3"></textarea>
                    <div id="text-feedback"></div>
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>