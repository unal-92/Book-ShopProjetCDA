// init local storage
let basket = [];
let key = 'basketmanga';
let cache = localStorage.getItem(key) || '';
if (!cache) {
    localStorage.setItem(key, JSON.stringify(basket));
}

basket = JSON.parse(cache);
if (basket.length) $("#check").show();
else $("#check").hide();
generateTable()
generatePrice()

function generateTable() {
    let html = '';
    $('.item-row').remove();
    // console.log(basket)
    basket.forEach((product, index) => {
        html +=
        
            "<tr class='item-row' id='tr-" + product.id_product + "'>" +
            "<td id='td-title-" + product.id_product + "'>" + product.name_product + "</td>" +
            "<td id='td-author-" + product.id_product + "'>" + product.author + "</td>" +
            "<td id='td-age-" + product.id_product + "'>" + product.min_age + "</td>" +
            "<td id='td-file-" + product.id_product + "'><img src='" + product.image + "'></td>" +
            "<td id='td-desc-" + product.id_product + "'>" + product.description + "</td>" +
            "<td id='td-price-" + product.id_product + "'>" + product.price + "</td>" +
            "<td id='td-category-" + product.id_product + "'>" + product.label + "</td>" +
            "<td id='td-action-" + index + "'><button type='button' onclick='removeToBasket(" + index + ")'><i class='fas fa-trash-alt' id='delete'></i></button></td>" +

            //window.location.replace('../address_user/address_user.html');
            "</tr>"
    });
    $('table').append(html);
}


function generatePrice() {
    let price = 0
    basket.forEach(product => { //! pour chaque produit du panier
        price += parseInt(product.price) //! on rajoute à price la valeur du produit convertie en entier(int) 
    })
    $('.basket-price').text("prix total " + price + "€"); //! on insere dans la div avec la class basket-price la chaine de caractere avec le prix prix total+price+€

}

function removeToBasket(index) {
    basket.splice(index, 1) //? vider ou remplacer une partie du tableau
    // console.log(basket);
    localStorage.setItem(key, JSON.stringify(basket));
    if (basket.length) $("#check").show();
    else $("#check").hide();
    generateTable()
    generatePrice()
}