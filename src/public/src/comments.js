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
            commentsData = jQuery.parseJSON(response);
        }
    });
    return commentsData;
}

function buildSortingForm(orderBy, sortingOrder) {

    $("#comments-container").append(`<div id="sorting" class="row p-0 m-0"></div>`);

    $("#sorting").html(
        `<form id="sorting-form">
            <div id="sorting" class="row">
                <div class="col-6 col-lg-3 px-3">
                    <select id="order-by" class="form-select bg-light">
                        <option value="date" ${orderBy === 'date' ? 'selected' : ''}>Сортировать по дате</option>
                        <option value="id" ${orderBy === 'id' ? 'selected' : ''}>Сортировать по id</option>
                    </select>
                </div>
                <div class="col-6 col-lg-3 px-3">
                    <select id="sorting-order" class="form-select bg-light">
                        <option value="DESC" ${sortingOrder === 'DESC' ? 'selected' : ''}>По убыванию</option>
                        <option value="ASC" ${sortingOrder === 'ASC' ? 'selected' : ''}>По возрастанию</option>
                    </select>
                </div>
            </div>
        </form>`
    );
}

function buildComments(commentsList) {

    $("#comments-container").append(`<div id="comments" class="row p-3 m-0"></div>`);

    $.each(commentsList, function(index, comment) {
        var date = new Date(comment.date).toLocaleString();
        $("#comments").append(
            `<div class="row border bg-light p-0 m-0 mt-3 rounded">
                <div class="row px-0 py-2 m-0 ">
                    <div class="col">
                        <p class="m-0">
                            <span class="text-primary fw-normal">${comment.name}</span> <span class="fw-light text-muted">(id - ${comment.id})</span>
                        </p>
                        <span class="fw-lighter text-muted">${date}</span>
                    </div>
                    <div class="col-2 text-end">
                        <a href="#" rel="nofollow" role="button" comment-id="${comment.comment_id}">
                            <i class="text-danger fs-5 fa fa-times" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="row px-0 py-2 m-0">
                    <div class="col">${comment.text}</div>
                </div>
            </div>`
        );              
    });
}

function buildPagination(currentPage, pageCount) {
    var currentPage =  parseInt(currentPage);
    var pageCount = parseInt(pageCount);
    var pages = '';
    currentPage = (currentPage > pageCount) ? pageCount : currentPage;

    $("#comments-container").append(`<div id="pagination" class="row p-3 pb-0 m-0"></div>`);

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
    } else {
        $('#pagination').html('');
    }
}

function sendComment(name, comment) {
    var result;
    //var cleanStr = comment.replace(/<\/?div>|<\/?p>|<br>|&nbsp;|\s/g, '');
    //var comment = cleanStr.length === 0 ? '' : comment;
    $.ajax({
        url: "/ajax/comments",
        async: false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        type: 'POST',
        data: {
            "name": name,
            "comment": comment,
        },
        success: function(response){
            result = jQuery.parseJSON(response);
        },
    });
    return result;
}

function deleteComment(commentId) {
    var result;
    $.ajax({
        url: "/ajax/comments/delete",
        async: false,
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        type: 'POST',
        data: {
            "commentId": commentId,
        },
        success: function(response){
            result = jQuery.parseJSON(response);
        },
    });
    return result;
}

function buldCommentsSection(currentPage = 1, perPage = 3, orderBy = 'date', sortingOrder = 'DESC') {
    var commentsData = getCommentsData(currentPage, perPage, orderBy, sortingOrder);
    var commentsList = commentsData.commentsList;
    var commentsLength = commentsList.length;
    var pageCount = commentsData.pageCount;
    var currentPage = currentPage;
    var orderBy = orderBy;
    var sortingOrder = sortingOrder;

    $("#comments-container").html('');
    
    if ((pageCount === 1 && commentsLength > 1) || pageCount > 1) {
        buildSortingForm(orderBy, sortingOrder);
    }

    if (commentsLength > 0) {
        buildComments(commentsList);
    }

    if (pageCount > 1) {
        buildPagination(currentPage, pageCount);
    }
    
    $("#sorting-form #order-by").change(function() {
        orderBy = $(this).val();
        buldCommentsSection(currentPage, perPage, orderBy, sortingOrder);
    });

    $("#sorting-form #sorting-order").change(function() {
        sortingOrder = $(this).val();
        buldCommentsSection(currentPage, perPage, orderBy, sortingOrder);
    });

    $("#pagination li.page-item").click(function() {
        var selectedPage = $(this).find('a').attr('page-num');
        if (selectedPage) {
            currentPage = selectedPage;
        }
        buldCommentsSection(currentPage, perPage, orderBy, sortingOrder);
    });

    $("#comments [comment-id]").click(function() {
        var commentId = $(this).attr("comment-id");
        var response = deleteComment(commentId); 
        if (response.status === "success") {
            var children = $("#comments").children().length;
            if (children === 1 && pageCount == currentPage && pageCount > 1) {
                currentPage = currentPage - 1;
            }
            buldCommentsSection(currentPage, perPage, orderBy, sortingOrder);
        }
    });

    $('#submit').off().click(function(e){
        e.preventDefault();
        var name = $('#name');
        var comment = $('#text');
        var editor = $('.richText-editor');
        var nameFeedback = $('#name-feedback');
        var textFeedback = $('#text-feedback');
        if ($("#commentForm").valid()) {
            var result = sendComment(name.val(), comment.val());
        }
        if (result) {
            if (result.status === 'failure') {
                var errors = result.errors;
                nameFeedback.html(`<div class="invalid-feedback d-block">${errors.name}</div>`);
                textFeedback.html(`<div class="invalid-feedback d-block">${errors.text}</div>`);
            } else if (result.status === 'success') {
                name.val('');
                comment.val('');
                editor.html('');
                nameFeedback.html('');
                textFeedback.html('');
                buldCommentsSection();
            }
        }
    });
}

$(document).ready(function(){

    //$("#text").richText();
    buldCommentsSection();

    jQuery.validator.addMethod("strictEmail", function(value, element) {
        return this.optional( element ) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test( value );
    }, 'Введите действительный email адрес!');

    $("#commentForm").validate(        
    {
        rules: {
            name: {
                required: true,
                strictEmail: true,
            },
            text: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Поле не может быть пустым!",
            },
            text: {
                required: "Поле не может быть пустым!",
            }
        },
        errorElement: "span"
    });

});