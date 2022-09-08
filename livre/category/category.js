/**
 * @desc Delete an catégory
 * @param string id - Id of the catégory
 * @return Remove an catégory from the HTML table or send an alert message
 */

function deleteCategory(idCategory) {
    console.log(idCategory);

    $.ajax({
        url: 'flux_category.php',
        type: 'POST', // requête de type GET/POST
        data: {
            choice: 'delete',
            id: idCategory
        },
        dataType: 'json', // type de réponse
        success: (res, status) => {
            console.log(res['success'])
            if (res['success']) { //? If success, remove the category from the table
                $('#tr-' + idCategory).remove();
            } else alert("erreur lors de la suppression") //? Else send an alert message
        }
    });
}


function updateCategory(idCategory) {
    console.log(idCategory);
    $.ajax({

        url: "flux_category.php",
        type: "GET",
        data: {
            choice: "select_id",
            id: idCategory
        },
        dataType: "json",
        success: (res, status) => {

            //res = JSON.parse(res)
            $("input:checkbox").prop("checked", false);
            if (res['success']) {
                res.gender.forEach(el => {
                    $("#check-" + el.genre_id_genre).prop("checked", true);
                });


                const category = res.category
                console.log(res)

                $("#categorieId").val(category.id_category);
                $("#title").val(category.label);
                //  $("#genre").val(category.id_genre);

                //   $("#-title-" + idCategory).html(title); // Update the title

            }
        }
    })
}

/**
 * @desc Select all the catégorys
 * @return Add the different catégory in the HTML table
 */

function init() {
    $(".row").remove();
    $("#title").val("");
    $("#categoryId").val("");
    $.ajax({
        url: 'flux_category.php',
        type: 'GET',
        data: {
            choice: 'select_all',
        },
        dataType: 'json',
        success: (res, status) => {
            console.log(res.categories);
            // IF res.success TODO
            let html = '';
            console.log(res.categories);
            res.categories.forEach(category => {
                html +=
                    "<tr class='row' id='tr-" + category.id_category + "'>" +
                    "<td id='td-title-" + category.id_category + "'>" + category.label + "</td>" +
                    "<td id='td-genre-" + category.id_category + "'>" + category.genre + "</td>" +

                    "<td><button onclick=' deleteCategory(" + category.id_category + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +
                    "<td><button onclick=' updateCategory(" + category.id_category + ")'><i class='fas fa-edit' id='update'></i></button></td>" +
                    "</tr>"
            });
            $('table').append(html);
        }
    });
}

init(); // Call the init function

$("#btn-form").click((event) => {
    event.preventDefault(); //! empêche la page de se recharger

    //? form values
    const idCategory = $("#categorieId").val();
    const title = $("#title").val();
    const checked = [];

    $("input:checkbox:checked").each(function () {
        checked.push($(this).val())

    });

    if (idCategory.trim() == '') { //? Si l'identifiant n'est pas défini dans le formulaire, insérez un category



        $.ajax({

            url: "flux_category.php",
            type: 'POST',
            data: {
                choice: "insert",
                ftitle: title,
                genders: checked
            },
            dataType: "json",
            success: (res, status) => {
                console.log(res);
                if (res['success']) {

                    init();
                    $("input:checkbox").prop("checked", false);
                    document.getElementById(form).reset();
                } else alert("erreur lors de l'insertion"); //? else envoi un message d'alerte 

                // document.getElementById("form").reset();
            }
        });

    } else { //? else update an category
        $.ajax({
            url: "flux_category.php", // The called file/url
            type: "POST", // Request type GET/POST
            data: { // Request parameters
                choice: "update",
                ftitle: title,
                // fgenre: genre,
                id: idCategory,
                genders: checked
            },
            dataType: "json", // Response type
            success: (res, status) => { // Success function
                //console.log(res)
                if (res.success) { //? If success update the category in the HTML table
                    init();

                    $("input:checkbox").prop("checked", false);
                    document.getElementById(form).reset();

                }
            }
        })
    }

})

$.ajax({
    url: "../genre/flux_genre.php",
    type: "GET",
    data: {
        choice: "select_all",
    },
    dataType: "json",
    success: (res, status) => {
        let html = '';
        res.genres.forEach(genre => {
            html += "<input type='checkbox' id='check-" + genre.id_genre + "' value='" + genre.id_genre + "'>" + genre.label;
        })
        $('form').append(html);
    }
})