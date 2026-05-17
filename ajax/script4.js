
function dismissReport(
    reportId
){

    fetch(

        '../Controllers/Dismiss-Report.php',

        {

            method: 'POST',

            headers: {

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:
            'report_id='
            + reportId
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        if(data.success){

            document
            .getElementById(

                'report'
                + reportId

            )

            .remove();
        }
    });
}

function deleteReportedComment(
    commentId,
    reportId
){

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

                'report'
                + reportId

            )

            .remove();
        }
    });
}
