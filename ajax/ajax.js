


function promoteUser(userId){

    fetch("../../Controllers/task1/promote-controller.php", {

        method: "POST",
        credentials: "same-origin",

        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: new URLSearchParams({
            user_id: userId
        })

    })

    .then(response => response.json())

    .then(data => {

        if(data.success){

            document.getElementById(
                "role-" + userId
            ).innerText = "author";

            alert(data.message || "User promoted successfully.");

        }else{

            alert(data.message || "Promotion failed.");
        }

    })

    .catch(error => {

        console.log(error);

        alert("Something went wrong");
    })

}
