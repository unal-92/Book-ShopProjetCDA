/**
 * @desc Delete an genre
 * @param string id - Id of the genre
 * @return Remove an article from the HTML table or send an alert message
 */

function deleteGenre(idGenre) {
    $.ajax({
        url: 'flux_genre.php',
        type: 'POST',
        data: {
            choice: 'delete',
            id: idGenre
        },
        dataType: 'json',
        success: (res, status) => {
            console.log(res['success'])
            if (res['success']) {
                $('#tr-' + idGenre).remove(); //! fonction déclarée ligne 58
            } else alert("Erreur lors de la suppression");
        }
    });
}

// recuperer le nom du genre et le mettre dans le formulaire 

function updateGenre(idGenre) {

    console.log(idGenre);
    $.ajax({
        url: "flux_genre.php",
        type: "GET",
        data: {
            choice: "select_id",
            id: idGenre
        },
        dataType: "json",
        success: (res, status) => {
            const genre = res.genre
            if (res['success']) {
                console.log(res)

                $("#genreId").val(genre.id_genre);
                $("#title").val(genre.label);
                //  $("#-title-" + idGenre).html(title); // Update the title

            }
        }
    })
}

/**
 * @desc Select all the genres
 * @return Add the different genre in the HTML table
 */

function init() {
    $(".row").remove();
    $("#title").val("");
    $("#genreId").val("");

    $.ajax({
        url: 'flux_genre.php',
        type: 'GET',
        data: {
            choice: 'select_all',
        },
        dataType: 'json',
        success: (res, status) => {
            console.log(res.genres);
// IF res.success TODO
            let html = '';
            console.log(res.genres);
            res.genres.forEach(genre => {
                html +=
                    "<tr class='row' id='tr-" + genre.id_genre + "'>" +
                    "<td id='td-title-" + genre.id_genre + "'>" + genre.label + "</td>" +
                    "<td><button onclick='deleteGenre(" + genre.id_genre + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +
                    "<td><button onclick='updateGenre(" + genre.id_genre + ")'><i class='fas fa-edit' id='update'></i></button></td>" +
                    "</tr>"
            });
            $('table').append(html);
        }
    });
}

init(); // Appel la fonction init

$("#btn-form").click((event) => {
    event.preventDefault(); //! évite de recharger la page

    //? valeurs du form
    const idGenre = $("#genreId").val();
    const title = $("#title").val();

    if (idGenre.trim() == '') { //?Si le genre n'est pas défini dans le formulaire, insérez un le genre 
        $.ajax({
            url: "flux_genre.php",
            type: "POST",
            data: {
                choice: "insert",
                ftitle: title,
            },
            dataType: "json",
            success: (res, status) => {
                console.log(res);
                if (res['success']) {

                    init();


                } else alert("erreur lors de l'insertion"); //? else envoi un message d'alerte 

            }
        });


    } else { //? else update an category
        $.ajax({
            url: "flux_genre.php",
            type: "POST",
            data: {
                choice: "update",
                ftitle: title,
                id: idGenre
            },
            dataType: "json",
            success: (res, status) => {
                console.log(res)
                if (res.success) { //? En cas de succès, mettre à jour le genre dans le tableau HTML
                    init();

                }

            }
        })
    }
})