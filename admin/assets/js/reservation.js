const popup = document.getElementById("popup");
const btnClose = document.getElementById("btnClose");
const rowName = document.getElementById("rowName");



//fillable js content
const orderID = document.getElementById("orderID");
const orderDate = document.getElementById("orderDate");
const totalPrice = document.getElementById("totalPrice");
const orderStatus = document.getElementById("orderStatus");
const paymentStatus = document.getElementById("paymentStatus");
const productIds = document.getElementById("productIds");
const productAmounts = document.getElementById("productAmounts");
const productNames = document.getElementById("productNames");
const productPrices = document.getElementById("productPrices");


document.querySelectorAll('.rowJS').forEach(e => {

    e.addEventListener('click', () => {
        console.log('Element clicked!' + e.id);
        if (popup.style.display === "none") {
            const substringId = e.id.substring(1)
            rowName.textContent = substringId
            popup.style.display = "block";
            fetchOrder(substringId);
        }
    });

});

btnClose.addEventListener("click", () => {
    popup.style.display = "none";
})



function fetchOrder(id) {
    async function fetchUrl(file) {
    try {
        const response = await fetch(file);
        if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
        }
        const res = await response.json();
        console.log(res);

        orderID.textContent = res[0]["orderID"];
        orderDate.textContent = res[0]["orderDate"];
        totalPrice.textContent = res[0]["totalPrice"];
        orderStatus.textContent = res[0]["orderStatus"];
        paymentStatus.textContent = res[0]["paymentStatus"];
        productIds.textContent = res[0]["productIds"];
        productAmounts.textContent = res[0]["productAmounts"];
        productNames.textContent = res[0]["productNames"];
        productPrices.textContent = res[0]["productPrices"];

    } catch (error) {
        console.error(`Fetch error: ${error.message}`);
        }
    }
    const url = "http://localhost/verkkokauppaProjektityo-v1/backend/api/orders/get_orders.php?order_id="+id;
    fetchUrl(url);
}