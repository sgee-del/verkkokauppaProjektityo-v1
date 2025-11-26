// admin/assets/js/admin.js funktio suoritttaa php kutsun mikä hkaee käyttäjien tilauskien tiedot ja kaikki

function fetchAndLoad() {

    console.log("FetchAndLoad");

    const ordersDiv = document.getElementById("fetchOutput");

    // Tee API-kutsu PHP:lle
    fetch(`../backend/api/orders/get_orders.php?user_id=a`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                ordersDiv.innerHTML = `<p>${data.error}</p>`;
            } else if (data.message) {
                ordersDiv.innerHTML = `<p>${data.message}</p>`;
            } else {
                data.forEach(order => {
                    html = `
                        <div class="output-row rowJS" style="padding-inline:5px" id="r1">
                            <div>
                                <p id="r1-reservationID">
                                ${order.orderID}
                                </p>
                            </div>
                            <div>
                                <p id="r1-userID">
                                USERID?
                                </p>
                            </div>
                            <div>
                                <p id="r1-reservationDate">
                                ${order.orderDate}
                                </p>
                            </div>
                            <div>
                                <p id="r1-subtotal">
                                ${order.totalPrice}
                                </p>
                            </div>
                            <div>
                                <p id="r1-reservationState">
                                ${order.orderStatus}
                                </p>
                            </div>
                            <div>
                                <p id="r1-paymentState">
                                ${order.paymentStatus}
                                </p>
                            </div>
                        </div>
                    `;
                });
                
                ordersDiv.innerHTML = html;
            }
        })
        .catch(error => {
            ordersDiv.innerHTML = 'Virhe tilauksia haettaessa.';
            console.error('Virhe:', error);
        });
}