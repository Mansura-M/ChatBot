const form = document.querySelector(".container form"),
    contbtn = form.querySelector(".container button"),
    errorText = form.querySelector(".error");
form.onsubmit = (e) => {
    e.preventDefault();
}
contbtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;

                if (data == "success") {
                    location.href = "users.php";
                } else {
                    errorText.textContent = data;
                    errorText.style.display = "block";

                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    // xhr.send()
}