$("#submit").click((e) => {
    e.preventDefault();

    $.ajax({
        url: 'verif_format.php',
        type: 'POST',
        data: {
            login: $('#login').val(),
            name: $('#fname').val(),
            lastname: $('#lname').val(),
            birthdate: $('#bdate').val(),
            email: $('#mail').val(),
            password: $('#pwd').val(),
        },
        datatype: 'json',
        success: (res, status) => {
            res = JSON.parse(res);

            if (res.success) {
                //  console.log("ok");
                localStorage.setItem("user", JSON.stringify(res.user)); // ?Je stock dans mon local storage le nom et le prénom de l'utilisateur authentifié
                window.location.replace('../home/index.html');
                alert("Bienvenue");

            } else {
                alert("un champ n'est pas rempli");
                $('error').text("il manque un champ");
            }
        }
    })
})