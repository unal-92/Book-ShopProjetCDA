const urlParams = new URLSearchParams(window.location.search);
const action = urlParams.get('action') || null;

if (action == "logout") {
    localStorage.removeItem("user");

    $.ajax({
        url: 'logout.php',
        type: 'GET',
        dataType:'json',
        success: (res) => {
        if (res.success) console.log("Déconnecté");
    }
});
}


$('#submit').click((e) => {
    e.preventDefault();
    console.log("event");
    $.ajax({
        url: "login.php", // appel l'URL
        type: "POST", // type de requete
        headers: { "X-My-Custom-Header": "some value" },
        xhrFields: {
            withCredentials: true
        },
        data: { //paramètre de demande
            mail: $('#mail').val(), // Valeur de mon champ de fomulaire correspondant à mon login
            password: $('#password').val(), // Valeur de mon champ de fomulaire correspondant à mon mot de passe
        },
        dataType: 'json', // type de réponse
        success: (res, status) => { // fonction succès
            // res = JSON.parse(res);
            console.log(res);

            if (res.success) { //? si l'user éxiste
                console.log("OK");
                localStorage.setItem("user", JSON.stringify(res.user)); //Je stock dans mon local storage le nom et le prénom de l'utilisateur authentifié
                window.location.replace('../home/index.html'); // Je le redirige ensuite vers home.html
                alert('Bienvenue');
            } else { //? si l'user n'éxiste pas
                $('error').text("imposteur");
            }
        }
    })
})