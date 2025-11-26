// admin/assets/js/admin.js funktio suoritttaa php kutsun mikä hkaee käyttäjien tilauskien tiedot ja kaikki

function fetchOrdersPopup(id) {

    const ordersDiv = document.getElementById("popupContent");

    // Tee API-kutsu PHP:lle
    fetch(`../backend/api/orders/get_orders.php?user_id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                ordersDiv.innerHTML = `<p>${data.error}</p>`;
            } else if (data.message) {
                ordersDiv.innerHTML = `<p>${data.message}</p>`;
            } else {
                data.forEach(order => {
                    html = `
                        <div class="row space-between">
                            <a href="#">Päivitä</a>
                            <a href="#">Poista</a>
                        </div>
                        <h2>Tiedot</h2>
                        <div class="row space-between">
                            <p>
                                TilausID
                            </p>
                            <p>
                                ${order.orderID}
                            </p>
                        </div>
                        <div class="row space-between">
                            <p>
                                TilaajaID
                            </p>
                            <p>
                                ${order.orderID}
                            </p>
                        </div>
                        <div class="row space-between">
                            <p>
                                TilausPVM
                            </p>
                            <p>
                                ${order.orderDate}
                            </p>
                        </div>
                        <div class="row space-between">
                            <p>
                                Tilauksen tila
                            </p>
                            <p>
                                ${order.orderStatus}
                            </p>
                        </div>
                        <div class="row space-between">
                            <p>
                                Maksun tila
                            </p>
                            <p>
                                ${order.paymentStatus}
                            </p>
                        </div>
                        <div class="row space-between">
                            <h4>
                                Kokonaissumma
                            </h4>
                            <h4>
                                ${order.totalPrice}
                            </h4>
                        </div>

                        <h2>Tuotteet</h2>
                    `;
                });
                let i = 1;
                for (const item of data) {
                    html += `
                        <h3>Tuote ${i}</h4>
                        <div class="row space-between">
                            <p>
                                Nimi
                            </p>
                            <p>
                                ${item.productName}
                            </p>
                        </div>

                        <div class="row space-between">
                            <p>
                                Määrä
                            </p>
                            <p>
                                ${item.productAmount}
                            </p>
                        </div>

                        <div class="row space-between">
                            <p>
                                Tuotteen hinta (kpl)
                            </p>
                            <p>
                                ${item.productPrice}
                            </p>
                        </div>
                    `;
                    i++;
                }
                ordersDiv.innerHTML = html;
            }
        })
        .catch(error => {
            ordersDiv.innerHTML = 'Virhe tilauksia haettaessa.';
            console.error('Virhe:', error);
        });
}