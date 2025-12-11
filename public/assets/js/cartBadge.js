//obviously the item that the textContent needs to be changed of
const cartBadge = document.getElementById("cartBadge");


//fetch function
async function updateBadge() {

    //api path where cart data is stored
    const apiPath = "../backend/api/cart/get_cart.php?userID=?";

    try {
        const response = await fetch(apiPath);
        if (!response.ok) {
            throw new Error(`Vastauksen tila: ${response.status}`);
        }
        const res = await response.json();

        //if api doesnt return succes value of true
        if (!res["success"]) {
            //returns and doesnt update if json does not have success value
            return;
        }

        cartBadge.textContent = res["items"].length

    } catch (error) {
        console.log(error.message);
    }
}

updateBadge();

//waits till dom is loaded
document.addEventListener("DOMContentLoaded", () => {
    //adds timeout because content on the page is loaded with js after domContentLoaded
    setTimeout(() => {

        ///adds eventlistener to each button to give real-time update on cart item count

        let buttons = document.querySelectorAll("button");

        buttons.forEach(button => {
            button.addEventListener("click", function() {
                updateBadge();
            });
        });
    }, 100);
});
