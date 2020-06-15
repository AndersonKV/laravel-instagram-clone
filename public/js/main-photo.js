window.onload = initPhoto;

function initPhoto() {
    const img = document.querySelectorAll(".like-img");
    const getLikes = document.querySelector(".get-likes");
    const faHeart = document.querySelector(".first .fa-heart");

    const APP_URL = "http://127.0.0.1:8000/";
    const apiLike = "api/like";
    const apiLikes = "api/likes";

    const submitDoubleClick = function(data) {
        (async () => {
            const id_post = document.querySelector(".title-user");
            const post_url = document.querySelector(".img-id");
            const token = document.getElementById("token").value;
            const myRequest = APP_URL + apiLike;

            const data = { _token: token, id_post: id_post.id };

            fetch(myRequest, {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    try {
                        if (data.like == "200") {
                            updatePeopleLiked(data);
                            handleSubmitLike("like");
                        }
                        if (data.deslike == "200") {
                            updatePeopleLiked(data);
                            handleSubmitLike("not-like");
                        }
                    } catch (err) {
                        console.log(err);
                    }
                });
        })();
    };

    const submitLikeOneClick = function(data) {
        (async () => {
            const id_post = document.querySelector(".title-user");
            const post_url = document.querySelector(".img-id");
            const token = document.getElementById("token").value;
            const myRequest = APP_URL + apiLike;

            const data = { _token: token, id_post: id_post.id };

            fetch(myRequest, {
                method: "post",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    try {
                        if (data.like == "200") {
                            updatePeopleLiked(data);
                            handleSubmitLike("like");
                        }
                        if (data.deslike == "200") {
                            updatePeopleLiked(data);
                            handleSubmitLike("not-like");
                        }
                    } catch (err) {
                        console.log(err);
                    }
                });
        })();
    };

    img.forEach(element => {
        element.addEventListener("dblclick", submitDoubleClick);
    });

    faHeart.addEventListener("click", submitLikeOneClick);

    const tableListLike = function(data) {
        cleanTemplate();
        const output = templateUsers(data);
        const name = "Curtidas";

        appendTemplateUsers(output, name);
    };

    const templateUsers = function(data) {
        const string = data
            .map(perfil => {
                return `
            <div>
             <a href="/${perfil.user}">
            <div>
                <img class="avatar" src="${APP_URL}storage/upload/${perfil.image}"/>
            </div>
            <span>${perfil.user}</span>
            </a>
            </div>`;
            })
            .join("");
        return string;
    };

    const appendTemplateUsers = function(output, name) {
        const containerAjax = document.querySelector(".container-ajax-likes");

        const boxing = document.querySelector(".container-ajax-likes .boxing");

        const div = document.createElement("div");
        const firstDiv = document.createElement("div");

        const appendDiv = `<div>${name}</div><span class="closer2">X</span>`;

        firstDiv.innerHTML = appendDiv;
        firstDiv.classList.add("first");

        div.innerHTML = output;
        div.classList.add("ajax");

        div.insertBefore(firstDiv, div.childNodes[0]);

        containerAjax.classList.add("z-index-2");
        boxing.classList.add("visible");
        boxing.appendChild(div);

        const closer = document.querySelector(".closer2");
        closer.addEventListener("click", cleanTemplate);
    };

    const cleanTemplate = function(data) {
        const containerAjax = document.querySelector(".container-ajax-likes");
        const boxing = document.querySelector(".container-ajax-likes .boxing");

        if (containerAjax.children.length != 0) {
            while (boxing.firstChild) {
                containerAjax.classList.remove("z-index-2");
                boxing.classList.remove("visible");
                boxing.removeChild(boxing.firstChild);
            }
        }
    };

    const changeIconLike = function(setClass) {
        const span = document.createElement("span");

        if (setClass == "like") {
            const output = `<i class="fa fa-heart" aria-hidden="true"></i>`;
            span.classList.add(setClass);
            span.innerHTML = output;
        } else {
            const output = `<i class="far fa-heart" aria-hidden="true"></i>`;
            span.classList.add(setClass);
            span.innerHTML = output;
        }
        span.addEventListener("click", submitLikeOneClick);

        return span;
    };

    const handleSubmitLike = function(setClass) {
        const icons = document.querySelector(".list-icon .first");
        const likeImg = document.querySelector(".like-img");

        if (setClass == "like") {
            const heart = `<span class="like heart-white"><i class="fa fa-heart" aria-hidden="true"></i></span>`;
            const div = document.createElement("div");

            div.innerHTML = heart;
            likeImg.insertBefore(div, likeImg.firstChild);

            icons.removeChild(icons.firstChild);
            const content = changeIconLike(setClass);
            icons.insertBefore(content, icons.firstChild);
        } else {
            icons.removeChild(icons.firstChild);
            const content = changeIconLike(setClass);
            icons.insertBefore(content, icons.firstChild);
        }
    };

    const updatePeopleLiked = function(data) {
        const likes = document.querySelector(".count-likes");
        const likesLen = document.querySelector(".get-likes");
        const len = data.users.length;

        if (len == 0) {
            while (likes.firstChild) {
                likes.removeChild(likes.firstChild);
            }
        } else if (len == 1) {
            const showList = `<span>Curtido por <b><a href="/${data.users[0].user}">${data.users[0].user}</a></b> e outras 
                                <b class="get-likes">${len} pessoas</b></span>
                                <div class="container-ajax-likes z-index-1">
                                <div class="boxing visibility"></div></div>`;

            const div = document.createElement("div");
            div.innerHTML = showList;
            const get = div.querySelector(".get-likes");
            get.addEventListener("click", getUsers);

            likes.appendChild(div);
        } else if (len >= 2) {
            while (likes.firstChild) {
                likes.removeChild(likes.firstChild);
            }

            const showList = `<span>Curtido por <b><a href="/${data.users[0].user}">${data.users[0].user}</a></b> e outras 
                                    <b class="get-likes">${len} pessoas</b></span>
                                    <div class="container-ajax-likes z-index-1">
                                    <div class="boxing visibility"></div></div>`;

            const div = document.createElement("div");
            div.innerHTML = showList;

            likes.appendChild(div);
        }
    };

    const getUsers = function(e) {
        const id_post = document.querySelector(".title-user");

        const token = document.getElementById("token").value;
        const data = { _token: token, id_post: id_post.id };

        $.ajax({
            url: APP_URL + apiLikes,
            type: "post",
            data: data,
            success: function(data) {
                tableListLike(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    };

    if (getLikes != null) {
        getLikes.addEventListener("click", function(e) {
            const id_post = document.querySelector(".title-user");
            const token = document.getElementById("token").value;

            $.ajax({
                url: APP_URL + apiLikes,
                type: "post",
                data: {
                    _token: token,
                    id_post: id_post.id
                },
                success: function(data) {
                    tableListLike(data);
                    console.log(data);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    }

    initHeader();
}
