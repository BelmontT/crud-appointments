function showHide(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-fill");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye-fill");
    }
}

function hideMessage(){
    setTimeout(function(){
        var messageBox = document.getElementById("messageBox");
        
        if (messageBox){
            messageBox.style.display = "none";
        }
    }, 3000);
}