function removeBasket() {
    let key = 'basketmanga';

    localStorage.removeItem(key);

}

// function checkSession() {
//     //? Verification statut de l'user

//     $.ajax({
//         url: 'http://localhost/imie/projetlivre/livre/home.php',
//         type: 'POST',
//         data: {
//             choice: 'check_user',
//         },
//         dataType: 'json',
//         success: (res, status) => {

//             if (res.success) { //? vérifier si l'user est connécté ou non
//                 $('#co').remove();
//                 res.role.forEach(element => {
//                     if (element.is_admin != 1) { //? si l'user n'est pas admin, supprimer le lien admin

//                         $('#admin').remove();

//                     }
//                 });
//             } else {

//                 $('#deco').remove();
//                 $('#admin').remove();

//             }
//         },

//     });

// }

// function checkConnection() {
//     //? Verification statut de l'user
//     console.log($.ajax({
//         url: 'http://localhost/imie/projetlivre/livre/home.php',
//         type: 'POST',
//         data: {
//             choice: 'check_user',
//         },
//         dataType: 'json',
//         success: (res, status) => {

//             if (res.success) { //? vérifier si l'user est connécté ou non
//                 $('#co').remove();
//                 res.role.forEach(element => {
//                     if (element.is_admin != 1) { //? si l'user n'est pas admin, supprimer le lien admin

//                         $('#admin').remove();

//                     }
//                 });
//             } else {

//                 $('#deco').remove();
//                 $('#admin').remove();

//             }
//         }
//     }));
// }

const user = JSON.parse(localStorage.getItem("user"));
// console.log(user);

if (user) {
    const deco = $("<a></a>");
    deco.addClass("active2 footer");
    deco.attr("href", "../login/connection.html?action=logout");
    deco.text(" Se deconnecter");

    const account = $("<a></a>");
    account.addClass("active2 footer");
    account.attr("href", "../my_account/my_account.html");
    account.text(" Mon compte |");

    const admin = $("<a></a>");
    admin.addClass("active2 footer");
    admin.attr("href", "../product/product.html");
    admin.text("Administrateur |");
    if (+user.is_admin)$(".liens").append(admin); 

    $(".liens").append(account, deco);
} else {
    const login = $("<a></a>");
    login.attr("href", "../login/connection.html");
    login.text("Se connecter");
    $(".liens").append(login);
}

