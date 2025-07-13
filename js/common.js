window.addEventListener("load",function(){
    var signup_form=document.getElementById("signup-form");
    signup_form.addEventListener("submit",function(event){
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(signup_form);

        XHR.addEventListener("load",signup_success);

        XHR.addEventListener("error",on_error);

        XHR.open("api/signup_submit.php");

        XHR.send(form_data);

        document.getElementById("loading").style.display="block";
        event.preventDefault();
    });

    var login_form = document.getElementById("login-form");
    login_form.addEventListener("submit",function(event){
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(login_form);

        XHR.addEventListener("load",login_success);

        XHR.addEventListener("error",on_error);

        XHR.open("POST" , "api/login_submit.php");

        XHR.send(form_data);

        document.getElementById("loading").style.display="block";
        event.preventDefault();
    });
})

var signup_success = function(event){
    document.getElementById("loading").style.display='none';

    var response=JSON.parse(event.target.responseText);
    if(response.success){
        window.location.href = "home_page.php";
    }
    else{
        alert(response.message);
    }
};


var login_success = function(event){
    document.getElementById("loading").style.display='none';

    var response=JSON.parse(event.target.responseText)
    if(response.success){
        window.location.href = "home_page.php";
    }
    else{
        alert(response.message);
    }

};

var on_error = function(event){
    document.getElementById("loading").style.display='none';

    alert("Something went wrong!");
};