/**
 * @desc Delete an product
 * @param string id - Id of the product
 * @return Remove an product from the HTML table or send an alert message
 */

function deleteProduct(idProduct) {
    $.ajax({
        url: 'product.php',
        type: 'POST',
        data: {
            choice: 'delete',
            id: idProduct
        },
        dataType: 'json',
        success: (res, status) => {
            console.log(res['success'])
            if (res['success']) {
                $('#tr-' + idProduct).remove();
            } else alert("Erreur lors de la suppression");
        }
    });
}

// recuperer le nom du product et le mettre dans le formulaire 

function updateProduct(idProduct) {

    $.ajax({
        url: "product.php",
        type: "GET",
        data: {
            choice: "select_id",
            id: idProduct
        },
        dataType: "json",
        success: (res, status) => {
            // res = JSON.parse(res)
            const product = res.product
            if (res['success']) {
                console.log(res)

                $("#productId").val(product.id_product);
                $("#title").val(product.name_product);
                $("#author").val(product.author);
                $("#age").val(product.min_age);
                $("#desc").val(product.description);
                $("#price").val(product.price);
                $("#category").val(product.category_id_category);

                // $("#-title-" + idProduct).html(title); // Update the title
                // $("#-author-" + idProduct).html(author); // Update the author
                // $("#-age-" + idProduct).html(age); // Update the age
                // $("#-file-" + idProduct).html(file); // Update the file
                // $("#-desc-" + idProduct).html(desc); // Update the desccription
                // $("#-price-" + idProduct).html(price); // Update the price
                // $("#-cateIDcate-" + idProduct).html(cateIDcate); // Update the cateIDcate


            }
        }
    })
}


/**
 * @desc Select all the products
 * @return Add the different product in the HTML table
 */

function init() {
    $.ajax({
        url: 'product.php',
        type: 'GET',
        data: {
            choice: 'select_all',
        },
        dataType: 'json',
        success: (res, status) => {
            // console.log(products);

            let html = '';
            // console.log(products);
            res.products.forEach(product => {
                html +=
                    "<tr id='tr-" + product.id_product + "'>" +
                    "<td id='td-title-" + product.id_product + "'>" + product.name_product + "</td>" +
                    "<td id='td-author-" + product.id_product + "'>" + product.author + "</td>" +
                    "<td id='td-age-" + product.id_product + "'>" + product.min_age + "</td>" +
                    "<td id='td-file-" + product.id_product + "'><img src='" + product.image + "'></td>" +
                    "<td id='td-desc-" + product.id_product + "'>" + product.description + "</td>" +
                    "<td id='td-price-" + product.id_product + "'>" + product.price + "</td>" +
                    "<td id='td-category-" + product.id_product + "'>" + product.label + "</td>" +

                    "<td><button onclick='deleteProduct(" + product.id_product + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +
                    "<td><button onclick='updateProduct(" + product.id_product + ")'><i class='fas fa-edit' id='update'></i></button></td>" +
                    "</tr>"
            });
            $('table').append(html);
        }
    });
}

init(); // Appel la fonction init

$("#btn-form").click((event) => {
    event.preventDefault(); //! évite de recharger la page

    // console.log($("#productId").val());

    //? valeurs du form
    const idProduct = $("#productId").val();
    const title = $("#title").val();
    const author = $("#author").val();
    const age = $("#age").val();
    //  const file = $("#file").val();
    const desc = $("#desc").val();
    const price = $("#price").val();
    const cateIDcate = $("#category").val();

    if (idProduct.trim() == '') { //?Si l'identifiant n'est pas défini dans le formulaire, insérez le product 


        console.log($.ajax({
            url: "product.php",
            type: "POST",

            data: {

                choice: "insert",
                ftitle: title,
                fauthor: author,
                fage: age,
                fdesc: desc,
                fprice: price,
                fcateIdcate: cateIDcate
            },
            dataType: "json",
            success: (res, status) => {
                console.log(res);
                if (res['success']) {
                    $('table').append(
                        "<tr id='tr'-" + res.id_product + "'>" +
                        "<td id='td-title-" + res.id_product + "'>" + title + "</td>" +
                        "<td id='td-author-" + res.id_product + "'>" + author + "</td>" +
                        "<td id='td-age-" + res.id_product + "'>" + age + "</td>" +
                        //  "<td id='td-file-" + res.id_product + "'>" + file + "</td>" +
                        "<td id='td-desc-" + res.id_product + "'>" + desc + "</td>" +
                        "<td id='td-price-" + res.id_product + "'>" + price + "</td>" +
                        "<td id='td-cateIDcate-" + res.id_product + "'>" + cateIDcate + "</td>" +

                        "<td><button onclick='deleteProduct(" + res.id_product + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +
                        "<td><button onclick='updateProduct(" + res.id_product + ")'><i class='fas fa-edit' id='update'></i></button></td>" +
                        "</tr>"
                    );
                    // $('table').append(newGame);
                } else alert("erreur lors de l'insertion"); //? else envoi un message d'alerte 

            }
        }));





    } else { //? else update an product
        $.ajax({
                url: "product.php", // The called file/url
                type: "POST", // Request type GET/POST
                data: { // Request parameters
                    choice: "update",
                    ftitle: title,
                    fauthor: author,
                    fage: age,
                    fdesc: desc,
                    fprice: price,
                    fcateIdcate: cateIDcate,
                    id: idProduct
                },
                dataType: "json", // Response type
                success: (res, status) => { // Success function
                    console.log(res)
                    if (res.success) { //? If success update the category in the HTML table
                        //$("#td-idCategory-" + idProduct).html(idCategory);
                        $("#td-title-" + idProduct).html(title);
                        $("#td-author-" + idProduct).html(author);
                        $("#td-age-" + idProduct).html(age);
                        //  $("#td-file-" + idProduct).html(file);
                        $("#td-desc-" + idProduct).html(desc);
                        $("#td-price-" + idProduct).html(price);
                        $("#-cateIDcate-" + idProduct).html(cateIDcate);

                    }
                    //document.getElementById("form").reset();
                }
            })
            // Upload file
            //e.preventDefault();

        const files = $("#file")[0].files;
        const formdata = new FormData();
        // $("#btn-form").click((event) => {
        //  event.preventDefault(); //! évite de recharger la page

        formdata.append('file', files[0]);
        formdata.append('id', idProduct);

        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formdata,

            dataType: "json",
            contentType: false,
            processData: false,
            success: (res, status) => {
                console.log(res);
            }
        })
    }

})


$.ajax({
    url: "../category/flux_category.php",
    type: "GET",
    data: {
        choice: "select_all",
    },
    dataType: "json",
    success: (res, status) => {
        let html;
        // console.log(categorys);

        res.categories.forEach(category => {

            html += "<option value='" + category.id_category + "'>" + category.label + "</option>"

            // value=id de la catgory >= mettre le nom de la category >

        })
        $('select').append(html);
    }
})