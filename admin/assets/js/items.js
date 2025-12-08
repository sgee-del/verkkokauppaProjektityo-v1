const popup = document.getElementById("popup");
const btnClose = document.getElementById("btnClose");
const rowName = document.getElementById("rowName");



//fillable js content
const productID = document.getElementById("productID");
const productImg = document.getElementById("productImg");
const productName = document.getElementById("productName");
const productCategory = document.getElementById("productCategory");
const stock = document.getElementById("stock");

//adds eventlistener to every rowJS object

document.querySelectorAll('.rowJS').forEach(e => {

    e.addEventListener('click', () => {
        //checks if other popup is open or not opened
        if (popup.style.display === "none") {
            //removes letter "r" from the order row
            const substringId = e.id.substring(1)
            //changed few values and shows
            rowName.textContent = substringId
            popup.style.display = "block";
            //function to fetch
            fetchOrder(substringId);
        }
    });

});

btnClose.addEventListener("click", () => {
    popup.style.display = "none";
})


//fetch function
function fetchOrder(id) {
    //tries to fecth content 
    async function fetchUrl(file) {
    try {
        //for checking file content and its succcess
        const response = await fetch(file);
        if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
        }
        //turns response into usable form (json)
        const res = await response.json();

        //changes values of html objects from json file when fetch is succeess
        productImg.src = "../" + res[0]["imagePath"];
        productID.textContent = res[0]["productID"];
        productName.textContent = res[0]["productName"];
        productCategory.textContent = res[0]["categoryName"];
        stock.textContent = res[0]["stock"];

    } catch (error) {
        console.error(`Fetch error: ${error.message}`);
        }
    }
    //fetch url (needs to be changed when other device is api host)
    const url = "http://localhost/verkkokauppaProjektityo-v1/backend/api/products/get_product.php?product_id="+id;
    fetchUrl(url);
}