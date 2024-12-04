const pswrfield = document.querySelector("form input[type='password']"),
    togglrbtn = document.querySelector("form .password-container i");
togglrbtn.onclick = () => {
    if (pswrfield.type == "password") {
        pswrfield.type = "text"
        togglrbtn.classList.add("active")
    } else {
        pswrfield.type = "password"
        togglrbtn.classList.remove("active")
    }
}