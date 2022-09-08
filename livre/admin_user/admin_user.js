/**
 * @desc Delete an user
 * @param string id - Id of the user
 * @return Remove an user from the HTML table or send an alert message
 */

function deleteUser(idUser) {
    $.ajax({
        url: 'admin_user.php', // appel l'URL
        type: 'POST', // type de requete
        data: {
            choice: 'delete',
            id: idUser
        },
        dataType: 'json', // type de réponse
        success: (res, status) => { // fonction succès
            console.log(res['success'])
            if (res['success']) {
                $('#tr-' + idUser).remove();
            } else alert("erreur lors de la supression");
        }
    });
}



function updateUser(idUser) {

    console.log(idUser);
    $.ajax({
        url: "admin_user.php", // appel l'URL
        type: 'GET', // type de requete
        data: { //paramètre de demande
            choice: 'select_id',
            id: idUser,
        },
        dataType: 'json', // type de réponse
        success: (res, status) => { // fonction succès

            // const user = res.user
            if (res['success']) {
                console.log(res)
                $("#userId").val(res.user.iduser);
                $("#login").val(res.user.login);
                $("#name").val(res.user.name);
                $("#lastname").val(res.user.lastname);
                $("#birthdate").val(res.user.birthdate);
                $("#email").val(res.user.email);

            }
        }

    })
}
////////////////////////////////////////////////////////////

/**
 * @desc Select all the users
 * @return Add the different user in the HTML table
 */

function init() {
    $.ajax({
        url: 'admin_user.php', // appel l'URL
        type: 'GET', // type de requete
        data: { //paramètre de demande
            choice: 'select_all',
        },
        dataType: 'json',
        success: (res, status) => {
            console.log(res.users)

            let html = '';
            console.log(res.users);
            res.users.forEach(user => {
                html +=
                    "<tr id='tr-" + user.iduser + "'>" +
                    "<td id='td-login-" + user.iduser + "'>" + user.login + "</td>" +
                    "<td id='td-name-" + user.iduser + "'>" + user.name + "</td>" +
                    "<td id='td-lastname-" + user.iduser + "'>" + user.lastname + "</td>" +
                    "<td id='td-birthdate-" + user.iduser + "'>" + user.birthdate + "</td>" +
                    "<td id='td-email-" + user.iduser + "'>" + user.email + "</td>" +

                    "<td><button onclick='deleteUser(" + user.iduser + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +
                    "<td><button onclick='updateUser(" + user.iduser + ")'><i class='fas fa-edit' id='update'></i></button></td>" +
                    "</tr>"
            });
            $('table').append(html);
        }
    });
}


///////////////////////////////////////////////////////////////////

init(); // Appel la fonction init

$("#btn-form").click((event) => {
    event.preventDefault(); //! évite de recharger la page

    // console.log($("#userId").val());

    //? valeurs du form
    const idUser = $("#userId").val(); //! déclaration variable et on affecte une valeur
    // const userId = $("#idUser").val(); //! déclaration variable et on affecte une valeur
    const login = $("#login").val(); //! déclaration variable et on affecte une valeur
    const name = $("#name").val(); //! déclaration variable et on affecte une valeur
    const lastname = $("#lastname").val(); //! déclaration variable et on affecte une valeur
    const birthdate = $("#birthdate").val(); //! déclaration variable et on affecte une valeur
    const email = $("#email").val(); //! déclaration variable et on affecte une valeur


    $.ajax({
        url: "admin_user.php",
        type: "POST",
        data: {
            choice: "update",
            flogin: login,
            fname: name,
            flastname: lastname,
            fbirthdate: birthdate,
            femail: email,
            id: idUser
        },
        dataType: "json",
        success: (res, status) => {
            console.log(idUser)
            if (res.success) { //? If success update the user in the HTML table

                // $("#td-id-" + idUser).html(idUser);
                $("#td-login-" + idUser).html(login);
                $("#td-name-" + idUser).html(name);
                $("#td-lastname-" + idUser).html(lastname);
                $("#td-birthdate-" + idUser).html(birthdate);
                $("#td-email-" + idUser).html(email);

            }
            //document.getElementById("form").reset();
        }
    })

})