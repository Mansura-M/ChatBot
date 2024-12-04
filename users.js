const searchbar = document.querySelector("#search-input"),
    searchbtn = document.querySelector(".search-bar button i")
userList = document.querySelector(".container .contact-list");
searchbtn.onclick = () => {
    searchbar.value = "";
}
searchbar.onkeyup = () => {
    // console.log("hello");
    let searchTerm = searchbar.value;
    if (searchTerm != "") {
        searchbar.classList.add("active");
    } else {
        searchbar.classList.remove("active");
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                // console.log(data);
                userList.innerHTML = data;

            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchterm=" + searchTerm);
}
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/users.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!searchbar.classList.contains("active")) {
                    userList.innerHTML = data;

                }
                // console.log(data);

            }
        }
    }
    xhr.send();
}, 500);
