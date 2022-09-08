// init local storage
let basket = [];
let key = 'basketmanga';
let cache = localStorage.getItem(key);
if (!cache) { //! initialisation dans le localstorage du panier
    localStorage.setItem(key, JSON.stringify(basket));
} else {
    basket = JSON.parse(cache);
}

let products = [];
    $.ajax({
        url: 'home.php',
        type: 'GET',
        data: {
            choice: 'select_all',
        },
        dataType: 'json',
        success: (res, status) => {
    
            let html = '';
            res.products.forEach(product => {
                products.push(product)
                html +=
                    "<tr id='tr-" + product.id_product + "'>" +
                    "<td id='td-title-" + product.id_product + "'>" + product.name_product + "</td>" +
                    "<td id='td-author-" + product.id_product + "'>" + product.author + "</td>" +
                    "<td id='td-age-" + product.id_product + "'>" + product.min_age + "</td>" +
                    "<td id='td-file-" + product.id_product + "'><img src='" + product.image + "'></td>" +
                    "<td id='td-desc-" + product.id_product + "'>" + product.description + "</td>" +
                    "<td id='td-price-" + product.id_product + "'>" + product.price + "</td>" +
                    "<td id='td-category-" + product.id_product + "'>" + product.label + "</td>";
                if (res.connexion == true) {
                    html +=
    
                        // "<td id='td-action-" + product.id_product + "'><button type='button' onclick='addToBasket(" + product.id_product + ")'>Ajouter au panier</button> </td>" +
                        "<td id='td-action-" + product.id_product + "'><button type='button' onclick='addToBasket(" + product.id_product + ")'><i class='fas fa-cart-plus' id= 'panier'></i></button></td>"
    
                    "</tr>"
    
                }
            });
            $('table').append(html);
        }
    });

//! fonction ajouter au panier
function addToBasket(id_product) {
    // itèrer sur la liste des produits qu'on souhaite ajouter au panier
    const product = products.find(function(item) {
        return item.id_product == id_product;
    });
    if (!basket) {
        basket = [] //! si le panier est vide initialiser le panier
    }
    basket.push(product); //* ajout du produit au panier
    localStorage.setItem(key, JSON.stringify(basket)); //* mise à jour de la valeur panier dans le local storage
}

function logout() {
    console.log($.ajax({
        url: 'login/logout.php',
        type: 'GET',
        dataType: 'json',
        success: (res, status) => {
            console.log(res);
            localStorage.removeItem('user');
            localStorage.removeItem('basket');
            window.location.replace('index.html');
           
        }
    }))
}