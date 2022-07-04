let page = 1;
const loadMoreButton = document.querySelector("#load-more-articles-button");

if (amountOfPages === 1) {
    loadMoreButton.style.display = "none";
}

function nextPage() {
    page++;
    sendReq();

    if (page === amountOfPages) {
        loadMoreButton.style.display = "none";
    }
}

function sendReq() {
    let req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            const articles = document.querySelector("#articles");
            articles.innerHTML += this.responseText;
        }
    };

    let url = `components/articles.php?page=${page}&currentPath=${currentPath}`;

    req.open("GET", url, true);
    req.send();
}