let loadMoreBtn = document.getElementById("loadMoreBtn");
let homeCardsSection = document.getElementById("home-cards");
let offset = 0;

let data = [];

async function getCards() {
    let r = await fetch(`https://127.0.0.1:8000/api/figures/${offset}`, {
        method: "GET",
        headers: {
            Accept: "application/json",
        },
    });
    if (r.ok === true) {
        return r.json();
    }
}

async function displayCards() {
    let getData = getCards();
    const data = Array.from(await getData);

    if (data.length > 0) {
        data.forEach((element) => {
            //création de l'article
            let article = document.createElement("article");
            article.setAttribute("class", "figure-card");

            //création de la partie photo
            let topSection = document.createElement("section");
            topSection.setAttribute("class", "figure-card-top");
            let link = document.createElement("a");
            link.setAttribute("href", `/figure/show/${element.slug}`);
            topSection.appendChild(link);
            if (element.media_path != "") {
                let image = document.createElement("img");
                image.setAttribute("src", `${element.media_path}`);
                link.appendChild(image);
            } else {
                let placeholder = document.createElement("div");
                placeholder.setAttribute("class", "figure-card-imgplaceholder");
                link.appendChild(placeholder);
            }

            //création de la partie titre
            let botSection = document.createElement("section");
            botSection.setAttribute("class", "figure-card-bot");
            let text = document.createElement("p");
            botSection.appendChild(text);
            let textLink = document.createElement('a')
            textLink.setAttribute('href', `/figure/show/${element.slug}`)
            textLink.innerText = `${element.name}`
            text.appendChild(textLink)

            article.appendChild(topSection);
            article.appendChild(botSection);
            homeCardsSection.appendChild(article);
        });

        offset += 3
    }
    
    if (data.length === 0) {
        loadMoreBtn.classList.add('hide-loadMore-btn')
    }
}

displayCards();

loadMoreBtn.addEventListener('click', displayCards)