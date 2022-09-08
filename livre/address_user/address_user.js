let key = 'basketmanga';
$("#btn-form").click((event) => {
    event.preventDefault(); //! évite de recharger la page

    // console.log($("#addressId").val());

    //? valeurs du form
    // const idAddress = $("#addressId").val();
    const street_number = $("#street_number").val(); //! déclaration variable et on affecte une valeur
    const street_name = $("#street_name").val(); //! déclaration variable et on affecte une valeur
    const zip_code = $("#zip_code").val(); //! déclaration variable et on affecte une valeur
    const country = $("#country").val(); //! déclaration variable et on affecte une valeur
    const city = $("#city").val(); //! déclaration variable et on affecte une valeur

    let cache = localStorage.getItem(key);
    let basket = JSON.parse(cache);

    if (!basket) { //! si panier vide, ne pas faire la commande
        alert("votre panier est vide")
        return;
    }

    let price = generatePrice(basket)
    let products = [];
    basket.forEach(item => {
        products.push(item.id_product)
    })
    $.ajax({
        url: "address_user.php",
        type: "POST",

        data: {

            choice: "insert",
            products: products,
            street_number: street_number,
            street_name: street_name,
            zip_code: zip_code,
            country: country,
            city: city,
            price: price
        },
        dataType: "json",
        success: (res, status) => {
            console.log(res);
            if (res.success) {
                alert("Merci pour votre achat, votre commande est cours de préparation"); //? else envoi un message d'alerte 
                localStorage.setItem(key, null); //! vider le panier après l'achat
                window.location = "../home/index.html"
            }

        }
    })

})

function generatePrice(basket) {
    let price = 0
    basket.forEach(product => { //! pour chaque produit du panier
        price += parseInt(product.price) //! on rajoute à price la valeur du produit convertie en entier(int) 
    })
    return price //! on insere dans la div avec la class basket-price la chaine de caractere avec le prix prix total+price+€

}