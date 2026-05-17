

function loadArticles(categoryId){

    let url =
    '../Controllers/Homepage-API.php';

    if(categoryId != 'all'){

        url +=
        '?category_id='
        + categoryId;
    }

    fetch(url)

    .then(response =>
        response.text()
    )

    .then(data => {

        document
        .getElementById(
            'articleGrid'
        )
        .innerHTML = data;
    });
}


let timer;

document
.getElementById('searchInput')

.addEventListener(

'keyup',

function(){

    clearTimeout(timer);

    let query = this.value;

    timer = setTimeout(() => {

        if(query.length == 0){

            document
            .getElementById(
                'searchResults'
            )
            .style.display = 'none';

            return;
        }

        fetch(
            '../Controllers/Search-API.php?q='
            + query
        )

        .then(response =>
            response.json()
        )

        .then(data => {

            let resultsDiv =
            document.getElementById(
                'searchResults'
            );

            resultsDiv.innerHTML = "";

            if(data.length > 0){

                resultsDiv.style.display =
                'block';

                data.forEach(article => {

                    resultsDiv.innerHTML +=

                    `
                    <div>

                    <a href="
                    article.php?id=${article.id}
                    ">

                    ${article.title}

                    </a>

                    </div>
                    `;
                });
            }

            else{

                resultsDiv.innerHTML =
                "No Results";

                resultsDiv.style.display =
                'block';
            }
        });

    }, 300);
});


document
.getElementById('likeBtn')

.addEventListener(

'click',

function(){

    let articleId =
    this.dataset.id;

    fetch(
        '../Controllers/Like-Controller.php',

        {

            method: 'POST',

            headers: {

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:
            'article_id='
            + articleId
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        if(data.success){

            document
            .getElementById(
                'likeCount'
            )
            .innerText =
            data.count;

            if(data.liked){

                document
                .getElementById(
                    'likeBtn'
                )
                .innerText =
                'Unlike';
            }

            else{

                document
                .getElementById(
                    'likeBtn'
                )
                .innerText =
                'Like';
            }
        }

        else{

            alert(data.message);
        }
    });
});


document
.getElementById('commentBtn')

.addEventListener(

'click',

function(){

    let body =

    document
    .getElementById(
        'commentBody'
    )
    .value;

    fetch(

        '../Controllers/Comment-Controller.php',

        {

            method: 'POST',

            headers: {

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:

            'article_id=<?php
            echo $article['id'];
            ?>'

            +

            '&body='

            +

            encodeURIComponent(body)
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        if(data.success){

            let c =
            data.comment;

            let html =

            `
            <div id="comment${c.id}">

            <img
            src="../public/uploads/avatars/${c.profile_pic_path}"
            width="40">

            <b>

            ${c.name}

            </b>

            <p>

            ${c.body}

            </p>

            <hr>

            </div>
            `;

            document
            .getElementById(
                'commentList'
            )

            .insertAdjacentHTML(

                'afterbegin',

                html
            );

            document
            .getElementById(
                'commentBody'
            )
            .value = "";
        }

        else{

            alert(data.message);
        }
    });
});


function showReportForm(
    commentId
){

    document
    .getElementById(

        'reportForm'
        + commentId

    )

    .style.display =
    'block';
}

function submitReport(
    commentId
){

    let reason =

    document
    .getElementById(
        'reason'
        + commentId
    )
    .value;

    fetch(

        '../Controllers/Report-Controller.php',

        {

            method: 'POST',

            headers: {

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:

            'comment_id='
            + commentId

            +

            '&reason='

            +

            encodeURIComponent(reason)
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        if(data.success){

            document
            .getElementById(

                'reportForm'
                + commentId

            )

            .innerHTML =

            'Reported ✓';
        }

        else{

            alert(data.message);
        }
    });
}



function deleteComment(
    commentId
){

    if(
        !confirm(
            'Delete Comment?'
        )
    ){

        return;
    }

    fetch(

        '../Controllers/Delete-Comment-Controller.php',

        {

            method: 'POST',

            headers: {

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:
            'comment_id='
            + commentId
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        if(data.success){

            document
            .getElementById(

                'comment'
                + commentId

            )

            .remove();
        }

        else{

            alert(data.message);
        }
    });
}

