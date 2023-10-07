let loadMoreBtn = document.getElementById("loadCommentBtn");
let commentSection = document.getElementById("all-comments-section");
let getFigureName = document.querySelector(".figure-page-head-title h1");
let figureName = getFigureName.innerText;
let offset = 0;

async function getComments() {
    let r = await fetch(
        `https://127.0.0.1:8000/api/comments/${figureName}/${offset}`,
        {
            method: "GET",
            headers: {
                Accept: "application/json",
            },
        }
    );
    if (r.ok === true) {
        return r.json();
    }
}

async function displayComments() {
    const data = Array.from(await getComments());

    if (data.length > 0) {
        data.forEach((element) => {
            let article = document.createElement('article')
            let topSection = document.createElement('section')
            topSection.setAttribute('class','comment-top')
            let pfp = document.createElement('img')
            pfp.setAttribute('src','../../assets/images/dummy.webp')
            pfp.setAttribute('alt','placeHolder for profil picture')
            pfp.setAttribute('loading','lazy')
            let userName = document.createElement('p')
            userName.innerText = `${element.name} - publié le : ${element.date}`
            userName.setAttribute('class','comment-user-info')
            topSection.appendChild(pfp)
            topSection.appendChild(userName)
            article.appendChild(topSection)
            let botSection = document.createElement('section')
            botSection.setAttribute('class','comment-bot')
            let commentContent = document.createElement('p')
            commentContent.innerText = element.content
            botSection.appendChild(commentContent)
            article.appendChild(botSection)

            commentSection.appendChild(article)
        });
    }

    offset += 2

    if (data.length === 0) {
        loadMoreBtn.classList.add('hide-loadComment-btn')
    }
}

displayComments();

loadMoreBtn.addEventListener('click', displayComments)