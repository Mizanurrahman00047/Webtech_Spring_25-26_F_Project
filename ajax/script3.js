const BASE = '/Webtech_Spring_25-26_F_Project/Webtech_Spring_25-26_F_Project/Controllers';

// Global functions that can be called from HTML onclick handlers
function loadArticles(categoryId) {
    let url = BASE + '/task3/homepage-controller.php';
    if (categoryId != 'all') {
        url += '?category_id=' + categoryId;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            let articleGrid = document.getElementById('articleGrid');
            if (articleGrid) {
                articleGrid.innerHTML = data;
            }
        })
        .catch(error => {
            console.error('Error loading articles:', error);
            alert('Failed to load articles. Please try again.');
        });
}

function showReportForm(commentId) {
    document.getElementById('reportForm' + commentId).style.display = 'block';
}

function submitReport(commentId) {
    let reason = document.getElementById('reason' + commentId).value;

    fetch(BASE + '/task4/report-controller.php', {
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

function deleteComment(commentId) {
    if (!confirm('Delete Comment?')) return;

    fetch(BASE + '/task4/delete-comment-controller.php', {
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

// Post comment from onclick handler
function postCommentClick() {
    console.log('postCommentClick called');
    let commentBtn = document.getElementById('commentBtn');
    if (!commentBtn) {
        alert('ERROR: Comment button not found');
        return;
    }
    
    let articleId = commentBtn.dataset.article;
    let commentBody = document.getElementById('commentBody');
    
    if (!commentBody) {
        alert('ERROR: Comment textarea not found');
        return;
    }
    
    let body = commentBody.value.trim();

    console.log('Article ID:', articleId);
    console.log('Comment body:', body);
    console.log('Body length:', body.length);

    if (!body) {
        alert('Please write a comment');
        return;
    }

    if (body.length < 5) {
        alert('Comment must be at least 5 characters');
        return;
    }

    console.log('Posting comment to article:', articleId);

    // Construct the POST data
    let postData = 'article_id=' + encodeURIComponent(articleId) + '&body=' + encodeURIComponent(body);
    console.log('POST data:', postData);

    fetch(BASE + '/task4/comment-controller.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: postData
    })
        .then(response => {
            console.log('Response received - Status:', response.status);
            if (!response.ok) {
                throw new Error('HTTP Error ' + response.status);
            }
            return response.text();
        })
        .then(text => {
            console.log('Raw response text:', text);
            
            if (!text) {
                throw new Error('Empty response from server');
            }
            
            let data = JSON.parse(text);
            console.log('Parsed JSON response:', data);
            
            if (data.success) {
                let c = data.comment;
                console.log('Comment data:', c);
                
                let profileImg = c.profile_pic_path ? `<img src="../../public/uploads/avatars/${c.profile_pic_path}" width="40">` : '';

                let html = `
                    <div id="comment${c.id}">
                        ${profileImg}
                        <b>${c.name || 'Anonymous'}</b>
                        <p>${c.body}</p>
                        <hr>
                    </div>`;

                let commentList = document.getElementById('commentList');
                if (commentList) {
                    commentList.insertAdjacentHTML('afterbegin', html);
                    document.getElementById('commentBody').value = '';
                    alert('✓ Comment posted successfully!');
                    console.log('Comment added to DOM');
                } else {
                    alert('ERROR: Comment list container not found');
                }
            } else {
                alert('Server error: ' + (data.message || 'Unknown error'));
                console.log('Server returned error:', data);
            }
        })
        .catch(error => {
            console.error('ERROR:', error);
            alert('ERROR: ' + error.message + '\n\nPlease check browser console (F12) for details.');
        });
}

// Initialize event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired - initializing event listeners');

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
                        document.getElementById('likeBtn').innerText = data.liked ? 'Unlike' : 'Like';
                    } else {
                        alert(data.message);
                    }
                });
        });
    }

    // COMMENT BUTTON
    let commentBtn = document.getElementById('commentBtn');
    console.log('Comment button found:', commentBtn);
    if (commentBtn) {
        commentBtn.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Comment button clicked!');
            let articleId = this.dataset.article;
            let body = document.getElementById('commentBody').value.trim();

            console.log('Article ID:', articleId);
            console.log('Comment body:', body);

            if (!body) {
                alert('Please write a comment');
                return;
            }

            if (body.length < 5) {
                alert('Comment must be at least 5 characters');
                return;
            }

            console.log('Posting comment to article:', articleId, 'Body:', body);

            fetch(BASE + '/task4/comment-controller.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'article_id=' + articleId + '&body=' + encodeURIComponent(body)
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Response text:', text);
                    try {
                        let data = JSON.parse(text);
                        console.log('Parsed response:', data);
                        
                        if (data.success) {
                            let c = data.comment;
                            let profileImg = c.profile_pic_path ? `<img src="../../public/uploads/avatars/${c.profile_pic_path}" width="40">` : '';

                            let html = `
                                <div id="comment${c.id}">
                                    ${profileImg}
                                    <b>${c.name || 'Anonymous'}</b>
                                    <p>${c.body}</p>
                                    <hr>
                                </div>`;

                            let commentList = document.getElementById('commentList');
                            if (commentList) {
                                commentList.insertAdjacentHTML('afterbegin', html);
                                document.getElementById('commentBody').value = '';
                                console.log('Comment added successfully');
                            }
                        } else {
                            alert(data.message || 'Failed to post comment');
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        alert('Error parsing response: ' + e.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Error posting comment: ' + error.message);
                });
        });
    }

    // LIVE SEARCH
    let timer;
    let searchInput = document.getElementById('searchInput');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            clearTimeout(timer);
            let query = this.value;

            timer = setTimeout(() => {
                let resultsDiv = document.getElementById('searchResults');

                if (!resultsDiv) return;

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

});
