<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<script>

    function getCommentsData(currentPage, perPage, orderBy, sortingOrder) {
        var commentsData;
        $.ajax({
            url: "/ajax/comments",
            async: false,
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            type: 'GET',
            data: {
                "currentPage": currentPage,
                "perPage": perPage,
                "orderBy": orderBy,
                "sortingOrder": sortingOrder,
            },
            success: function(response){
                if (response) {
                    commentsData = jQuery.parseJSON(response);
                }
            }
        });
        return commentsData;
    }

    function buildComments(commentsList) {
        $("#comments").html('');
        $.each(commentsList, function(index, comment) {
            $("#comments").append(
                `<div class="row border bg-light p-0 m-0 mt-3 rounded">
                    <div class="row px-0 py-2 m-0 bg-secondary-subtle">
                        <div class="col"><h4>${comment.name} (id-${comment.id})</h4></div>
                        <div class="col text-end">
                            <a class="btn btn-danger" href="#" rel="nofollow" role="button">Удалить</a>
                        </div>
                    </div>
                    <div class="row px-0 py-2 m-0">
                        <div class="col">${comment.text}</div>
                    </div>
                    <div class="row px-0 py-2 m-0">
                        <div class="col">${comment.date}</div>
                    </div>
                </div>`
            );              
        });
    }

    function buildPagination(currentPage, pageCount) {
        var currentPage =  parseInt(currentPage);
        var pageCount = parseInt(pageCount);
        var pages = '';
        if (pageCount > 1) {
            $('#pagination').html('<nav class="p-0"><ul class="pagination"></ul></nav>');
            var previous = `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                                <a class="page-link" href="#" page-num="${currentPage > 1 ? currentPage - 1 : ''}">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>`;
            var next = `<li class="page-item ${currentPage === pageCount ? 'disabled' : ''}">
                            <a class="page-link" href="#" page-num="${currentPage < pageCount ? currentPage + 1 : ''}">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>`;
            for (var i = 1; i <= pageCount; i++) {
                pages +=    `<li class="page-item ${currentPage === i ? 'active' : ''}">
                                <a class="page-link" href="#"  page-num="${currentPage === i ? '' : i}">${i}</a>
                            </li>`;
            }
            $('#pagination ul.pagination').append([previous, pages, next]);   
        }
    }

    function buildSortingForm(orderBy, sortingOrder) {
        $("#sorting").html(
            `<form id="sorting-form">
                <div id="sorting" class="row">
                    <div class="col-6 col-md-3 col-lg-2 p-0">
                        <select id="order-by" class="form-select bg-light">
                            <option value="date" ${orderBy === 'date' ? 'selected' : ''}>Сортировать по дате</option>
                            <option value="id" ${orderBy === 'id' ? 'selected' : ''}>Сортировать по id</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 p-0">
                        <select id="sorting-order" class="form-select bg-light">
                            <option value="DESC" ${sortingOrder === 'DESC' ? 'selected' : ''}>По убыванию</option>
                            <option value="ASC" ${sortingOrder === 'ASC' ? 'selected' : ''}>По возрастанию</option>
                        </select>
                    </div>
                </div>
            </form>`
        );
    }

    function buildCommentsPage(currentPage = 1, perPage = 3, orderBy = 'date', sortingOrder = 'DESC') {

        var commentsData = getCommentsData(currentPage, perPage, orderBy, sortingOrder);
        var commentsList = commentsData.commentsList;
        var pageCount = commentsData.pageCount;
        var currentPage = currentPage;
        var orderBy = orderBy;
        var sortingOrder = sortingOrder;

        buildSortingForm(orderBy, sortingOrder);
        buildComments(commentsList);
        buildPagination(currentPage, pageCount);

        $("#sorting-form #order-by").change(function() {
            orderBy = $(this).val();
            buildCommentsPage(currentPage, perPage, orderBy, sortingOrder);
        });

        $("#sorting-form #sorting-order").change(function() {
            sortingOrder = $(this).val();
            buildCommentsPage(currentPage, perPage, orderBy, sortingOrder);
        });

        $("#pagination li.page-item").click(function() {
            var selectedPage = $(this).find('a').attr('page-num');
            if (selectedPage) {
                currentPage = selectedPage;
            }
            buildCommentsPage(currentPage, perPage, orderBy, sortingOrder);
        });
    }

    $(document).ready(function(){

        buildCommentsPage();

        $('#submit').click(function(e){
            e.preventDefault();
            var name = $('#name');
            var comment = $('#text');
            var nameFeedback = $('#name-feedback');
            var textFeedback = $('#text-feedback');
            $.ajax({
                url: "/ajax/comments",
                async: false,
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                type: 'POST',
                data: {
                    "name": name.val(),
                    "comment": comment.val(),
                },
                success: function(response){
                    if (response) {
                        var result = jQuery.parseJSON(response);
                        if (result.status === 'failure') {
                            var errors = result.errors;
                            nameFeedback.html(`<div class="invalid-feedback d-block">${errors.name}</div>`);
                            textFeedback.html(`<div class="invalid-feedback d-block">${errors.text}</div>`);
                        } else if (result.status === 'success') {
                            name.val('');
                            comment.val('');
                            nameFeedback.html('');
                            textFeedback.html('');
                            buildCommentsPage();
                        }
                    }
                },
            });
        });
    });
</script>

<div class="container">
    <div id="comments-container" class="row p-0 m-0 mt-3">
        <div id="sorting" class="row p-0 m-0"></div>
        <div id="comments" class="row p-0 m-0"></div>
        <div id="pagination" class="row p-0 m-0 mt-3"></div>
        <div id="comment-form" class="row p-0 pb-3 pt-2 m-0 border bg-light rounded">
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" id="name" name="name" aria-describedby="emailHelp" required>
                    <div id="name-feedback"></div>
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Текст комментария</label>
                    <textarea class="form-control" id="text" name="text" rows="3" ></textarea>
                    <div id="text-feedback"></div>
                </div>
                <button type="submit" id="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>