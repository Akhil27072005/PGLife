window.addEventListener("load" , function(){
    const cityButtons = document.querySelectorAll(".city-button");


    cityButtons.forEach(button =>{
        button.addEventListener("mouseenter",()=>{
            cityButtons.forEach(btn=>{
                if(btn!=button){
                    btn.classList.add("shrink");
                }
            });
            button.classList.add("enlarge");
        });

        button.addEventListener("mouseleave",()=>{
            cityButtons.forEach(btn=>{
                btn.classList.remove("shrink","enlarge");
            })
        });
    });

    cityButtons.forEach(button =>{
        button.addEventListener("click" , function(){
            const city = this.dataset.city;
            if(city){
                window.location.href = "property_list.php?city_name=" + encodeURIComponent(city);
            }
        });
        button.style.cursor = "pointer";
    });
});