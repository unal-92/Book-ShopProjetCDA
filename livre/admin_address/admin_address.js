/**
 * @desc Select all the genres
 * @return Add the different genre in the HTML table
 */

function init() {
    $.ajax({
        url: 'admin_address.php', // appel l'URL
        type: 'GET', // type de requete
        data: {
            choice: 'select_all',
        },
        dataType: 'json', // type de réponse
        success: (res, status) => { // fonction succès
            console.log(res);

            let html = '';
            res.address.forEach(address => {

                html +=
                    "<tr id='tr-" + address.id_order + "'>" +
                    "<td id='td-title-" + address.id_order + "'>" + address.id_order + "</td>" +
                    "<td id='td-title-" + address.id_order + "'>" + address.date_order + "</td>" +
                    "<td id='td-title-" + address.id_order + "'>" + address.price_order + "</td>" +
                    "<td id='td-title-" + address.iduser + "'>" + address.name + "</td>" +
                    "<td id='td-title-" + address.iduser + "'>" + address.lastname + "</td>" +
                    "<td id='td-title-" + address.id_address + "'>" + address.street_number + "</td>" +
                    "<td id='td-title-" + address.id_address + "'>" + address.street_name + "</td>" +
                    "<td id='td-title-" + address.id_address + "'>" + address.zip_code + "</td>" +
                    "<td id='td-title-" + address.id_address + "'>" + address.city + "</td>" +
                    "<td id='td-title-" + address.id_address + "'>" + address.country + "</td>"
                "<td id='td-title-" + address.product + "'>" + address.id_product + "</td>"



                // "<td><button onclick='deleteOrder(" + order.id_order + ")'>Supprimer</button></td>" +
                // "<td><button onclick='updateOrder(" + order.id_order + ")'>Modifier</button></td>" +
                // "</tr>"
            });
            $('table').append(html);
        }
    });
}
init();