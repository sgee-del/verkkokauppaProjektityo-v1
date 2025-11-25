// admin/assets/js/admin.js funktio suoritttaa php kutsun mikä hkaee käyttäjien tilauskien tiedot ja kaikki

function fetchOrders() {
    const userId = document.getElementById('user_id').value; // Valitaan käyttäjän ID syötekentästä
    const ordersDiv = document.getElementById('orders');
    
    if (!userId) {
        ordersDiv.innerHTML = 'Syötä käyttäjän ID';
        return;
    }

    // Tee API-kutsu PHP:lle
    fetch(`get_orders.php?user_id=${userId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                ordersDiv.innerHTML = `<p>${data.error}</p>`;
            } else if (data.message) {
                ordersDiv.innerHTML = `<p>${data.message}</p>`;
            } else {
                // Luo taulukko tilauksista
                let html = '<table border="1"><thead><tr><th>Tilauksen ID</th><th>Päivämäärä</th><th>Status</th><th>Tuote</th><th>Hinta</th><th>Kuvaluokka</th></tr></thead><tbody>';
                
                data.forEach(order => {
                    html += `
                        <tr>
                            <td>${order.orderID}</td>
                            <td>${order.orderDate}</td>
                            <td>${order.orderStatus}</td>
                            <td>${order.productName}</td>
                            <td>${order.productPrice} €</td>
                            <td><img src="${order.productImage}" alt="${order.productName}" width="100"></td>
                        </tr>
                    `;
                });

                html += '</tbody></table>';
                ordersDiv.innerHTML = html;
            }
        })
        .catch(error => {
            ordersDiv.innerHTML = 'Virhe tilauksia haettaessa.';
            console.error('Virhe:', error);
        });
}