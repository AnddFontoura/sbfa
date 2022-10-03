
function activateCart()
{
    if (localStorage.hasOwnProperty('products')) {
        let productsArray = JSON.parse(localStorage.getItem('products'));
        let productsAmount = productsArray.length;

        if(productsAmount >= 1)
        {
            $('.shoppingCartAmount').html(productsAmount);
        } else {
            $('.shoppingCartAmount').html("0");
        } 
    }

}