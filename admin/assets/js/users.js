const popup = document.getElementById("popup");
const btnClose = document.getElementById("btnClose");
const rowName = document.getElementById("rowName");



//fillable js content
const userID = document.getElementById("userID");
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
const email = document.getElementById("email");
const phone = document.getElementById("phone");

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
        userID.textContent = res[0]["userID"];
        firstname.textContent = res[0]["firstname"];
        lastname.textContent = res[0]["lastname"];
        email.textContent = res[0]["email"];
        phone.textContent = res[0]["phone"];

    } catch (error) {
        console.error(`Fetch error: ${error.message}`);
        }
    }
    //fetch url (needs to be changed when other device is api host)
    const url = "http://localhost/verkkokauppaProjektityo-v1/backend/api/users/get_user.php?user_id="+id;
    fetchUrl(url);
}