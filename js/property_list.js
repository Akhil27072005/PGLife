window.addEventListener("load", function () {
    var is_interested_images = document.getElementsByClassName("is-interested-image");
    Array.from(is_interested_images).forEach(element => {
        element.addEventListener("click", function (event) {
            var XHR = new XMLHttpRequest();
            var property_id = event.target.getAttribute("property_id");

            // On success
            XHR.addEventListener("load", toggle_interested_success);

            // On error
            XHR.addEventListener("error", on_error);

            // Set up request
            XHR.open("GET", "api/toggle_interest.php?property_id=" + property_id);

            // Initiate the request
            XHR.send();

            document.getElementById("loading").style.display = "block";
            event.preventDefault();
        });
    });
});

var toggle_interested_success = function (event) {
    document.getElementById("loading").style.display = "none";

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        var property_id = response.property_id;

        var is_interested_image = document.querySelectorAll(".property-id-" + property_id + " .is-interested-image")[0];
        var interested_user_count = document.querySelectorAll(".property-id-" + property_id + " .interested-user-count")[0];

        if (response.is_interested) {
            is_interested_image.classList.add("fas");
            is_interested_image.classList.remove("far");
            interested_user_count.innerHTML = parseFloat(interested_user_count.innerHTML) + 1;
        } else {
            is_interested_image.classList.add("far");
            is_interested_image.classList.remove("fas");
            interested_user_count.innerHTML = parseFloat(interested_user_count.innerHTML) - 1;
        }
    } else if (!response.success && !response.is_logged_in) {
        window.$("#login-modal").modal("show");
    }
};

var on_error = function(event){
    document.getElementById("loading").style.display='none';

    alert("Something went wrong!");
};




window.addEventListener("load",function(){
    const sortAsc = document.getElementById("sort-asc");
    const sortDesc = document.getElementById("sort-desc");
    const propertyList = document.getElementById("property-list");

    if(!propertyList){
        return;
    }

    const rent = (card) => {
        const rentValue = card.querySelector(".rent")?.textContent || "";
        return parseInt(rentValue.replace(/[^0-9]/g,""),10) || 0;
    };

    const sortProperties = (order = "asc") => {
        const cards = Array.from(propertyList.children);

        cards.sort((a,b) => {
            const rentA = rent(a);
            const rentB = rent(b);

            return order === "asc" ? rentA - rentB : rentB - rentA;
        });
        cards.forEach(card => propertyList.appendChild(card));
    };

    sortAsc.addEventListener("click",() => sortProperties("asc"));
    sortDesc.addEventListener("click",() => sortProperties("desc"));
});


window.addEventListener("load",function(){
    const filterButtons = document.querySelectorAll(".gender-filter");
    const propertyCards = document.querySelectorAll(".property-card");

    filterButtons.forEach(button => {
        button.addEventListener("click",() =>{
            const selectedGender = button.getAttribute("data-gender");
            propertyCards.forEach(card =>{
                const gender = card.getAttribute("data-gender");

                if(selectedGender === "all" || selectedGender === gender){
                    card.style.display="flex";
                }
                else{
                    card.style.display="none";
                }
            });

            filterButtons.forEach(btn=>btn.classList.remove("btn-active"));
            btn.classList.add("btn-active");

            document.querySelector('[data-dismiss="modal"]').click();
        });
    });
});