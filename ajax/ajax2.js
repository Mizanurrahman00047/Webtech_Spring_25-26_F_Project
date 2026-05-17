
function toggleStatus(id){

    fetch(

        '../Controllers/Toggle-Status.php',

        {

            method:'POST',

            headers:{

                'Content-Type':
                'application/x-www-form-urlencoded'
            },

            body:'id=' + id
        }
    )

    .then(response =>
        response.json()
    )

    .then(data => {

        document
        .getElementById(
            'status' + id
        )

        .innerText =
        data.status;
    });
}