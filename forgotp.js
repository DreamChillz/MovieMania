document.getElementById("forgot-password-link").addEventListener("click", function (event) {
    event.preventDefault();

    var email = prompt("Please enter your email address:");
    
    if (email) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (this. responseText.includes("Email exists")) {
                alert("Email exists. You can reset your password.");
            
                window.location.href = "resetp.php?email=" + encodeURIComponent(email);
            } else {
                alert("Email does not exist in out database.");
            }
        };
        xhr.send("forgot-email=" + encodeURIComponent(email));
    } else {
        alert("Please enter a valid email.");
    }
});