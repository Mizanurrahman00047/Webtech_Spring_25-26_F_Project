const BASE = '/Webtech_Spring_25-26_F_Project/Webtech_Spring_25-26_F_Project/Controllers';

// CATEGORY FILTER 

function loadArticles(categoryId) {

    let url = BASE + '/task3/homepage-controller.php';

    if (categoryId != 'all') {
        url += '?category_id=' + categoryId;
    }

    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById('articleGrid').innerHTML = data;
        });
}


//LIVE SEARCH 

let timer;

let searchInput = document.getElementById('searchInput');

if (searchInput) {

    searchInput.addEventListener('keyup', function () {

        clearTimeout(timer);

        let query = this.value;

        timer = setTimeout(() => {

            let resultsDiv = document.getElementById('searchResults');

            if (query.length == 0) {
                resultsDiv.style.display = 'none';
                return;
            }

            fetch(BASE + '/task3/search-controller.php?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {

                    resultsDiv.innerHTML = '';

                    if (data.length > 0) {

                        resultsDiv.style.display = 'block';

                        data.forEach(article => {
                            resultsDiv.innerHTML += `
                                <div>
                                    <a href="article.php?id=${article.id}">
                                        ${article.title}
                                    </a>
                                </div>`;
                        });

                    } else {
                        resultsDiv.innerHTML = 'No Results';
                        resultsDiv.style.display = 'block';
                    }
                });

        }, 300);
    });
}


// LIKE BUTTON 

let likeBtn = document.getElementById('likeBtn');

if (likeBtn) {

    likeBtn.addEventListener('click', function () {

        let articleId = this.dataset.id;

        fetch(BASE + '/task3/like-controller.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'article_id=' + articleId
        })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    document.getElementById('likeCount').innerText = data.count;

                    document.getElementById('likeBtn').innerText =
                        data.liked ? 'Unlike' : 'Like';

                } else {
                    alert(data.message);
                }
            });
    });
}


//  COMMENT BUTTON

let commentBtn = document.getElementById('commentBtn');

if (commentBtn) {

    commentBtn.addEventListener('click', function () {

        // Article ID is read from a data attribute on the button — no PHP needed in JS
        let articleId = this.dataset.article;

        let body = document.getElementById('commentBody').value;

        fetch(BASE + '/task3/comment-controller.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'article_id=' + articleId + '&body=' + encodeURIComponent(body)
        })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    let c = data.comment;

                    let html = `
                        <div id="comment${c.id}">
                            <img src="../../public/uploads/avatars/${c.profile_pic_path}" width="40">
                            <b>${c.name}</b>
                            <p>${c.body}</p>
                            <hr>
                        </div>`;

                    document.getElementById('commentList')
                        .insertAdjacentHTML('afterbegin', html);

                    document.getElementById('commentBody').value = '';

                } else {
                    alert(data.message);
                }
            });
    });
}


//REPORT FORM 

function showReportForm(commentId) {
    document.getElementById('reportForm' + commentId).style.display = 'block';
}

function submitReport(commentId) {

    let reason = document.getElementById('reason' + commentId).value;

    fetch(BASE + '/task3/report-controller.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'comment_id=' + commentId + '&reason=' + encodeURIComponent(reason)
    })
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                document.getElementById('reportForm' + commentId).innerHTML = 'Reported ✓';
            } else {
                alert(data.message);
            }
        });
}


//DELETE COMMENT

function deleteComment(commentId) {

    if (!confirm('Delete Comment?')) return;

    fetch(BASE + '/task3/delete-comment-controller.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'comment_id=' + commentId
    })
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                document.getElementById('comment' + commentId).remove();
            } else {
                alert(data.message);
            }
        });
}
