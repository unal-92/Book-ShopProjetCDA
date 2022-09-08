$.ajax({
    url: 'my_account.php',
    type: 'GET',
    data: {
        choice: 'select_id',
    },
    dataType: 'json',
    success: (res, status) => {

$("#firstname").val(res.user.name)
$("#name").val(res.user.lastname)
$("#date").val(res.user.birthdate)
$("#email").val(res.user.email)






        // let html = ""
        // // let user = res;
        //       console.log(res.user)
        // // res.resUser.forEach(elm => {
        //     html += //"<input type='text' class='text' value='" + elm.login + "' id='login'>" +
        //         "<input type='text' class='text' value='" + res.user.name + "' id='name'>" +
        //         "<input type='text' class='text' value='" + res.user.lastname + "' id='lastname'>" +
        //         "<input type='date' class='text' value='" + res.user.birthdate + "' id='birthdate'>" +
        //         "<input type='text' class='text' value='" + res.user.email + "' id='email'>"
        //         //  "<input type='password' class='text' value='" + elm.password + "' id='password'>"
        //         // "<input type='submit' class ='text test2' id='modifier' value='Modifier'>"

        // // })
        // $('form').prepend(html)
    }
});

$("#modifier").click((event) => {
    event.preventDefault(); //! évite de recharger la page
    // console.log("ok")

    //const login = $("#login").val()
    const name = $("#firstname").val()
    const lastname = $("#name").val()
    const birthdate = $("#date").val()
    const email = $("#email").val()
        //const password = $("#password").val()

    $.ajax({
        url: 'my_account.php',
        type: 'POST',
        data: {
            choice: 'update',
            name,
            lastname,
            birthdate,
            email
        },
        dataType: 'json',
        success: (res, status) => {
if (res.success) {
    user.name = name;
    user.lastname = lastname;
    user.birthdate = birthdate;
    user.email = email;

    localStorage.setItem("user", JSON.stringify(user));
}
        }
    });

})