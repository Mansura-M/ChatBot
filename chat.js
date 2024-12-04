const form = document.querySelector(".typing-area"),
    inputField = form.querySelector(".input-field"),
    sendbtn = form.querySelector("button"),
    chatbox = document.querySelector(".chat-screen");

form.onsubmit = (e) => {
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = () => {
    if (inputField.value != "") {
        sendbtn.classList.add("active");
    } else {
        sendbtn.classList.remove("active");
    }
}

sendbtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = "";
                scrollToBottom();
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatbox.onmouseenter = () => {
    chatbox.classList.add("active");
}

chatbox.onmouseleave = () => {
    chatbox.classList.remove("active");
}

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatbox.innerHTML = data;
                if (!chatbox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    const incoming_id = form.querySelector('.incoming_id').value;
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + incoming_id);
}, 500);

function scrollToBottom() {
    chatbox.scrollTop = chatbox.scrollHeight;
}
