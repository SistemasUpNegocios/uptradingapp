const msgerForm2 = document.querySelector(".msger-inputarea");
const msgerInput2 = document.querySelector(".msger-input");
const msgerChat2 = document.querySelector(".msger-chat");
let PERSON_IMG2 = "";
const chatWith2 = document.querySelector(".chatWith");
const typing2 = document.querySelector(".typing");
const chatStatus2 = document.querySelector(".chatStatus");
const chatId2 = window.location.pathname.substr(12);
let authUser2;
let typingTimer2 = false;

$(document).ready(function () {
    axios
        .get("/admin/auth/user")
        .then((res) => {
            authUser2 = res.data.authUser;
        })
        .then(() => {
            axios.get(`/admin/chat/${chatId2}/get_users`).then((res) => {
                let results = res.data.users.filter(
                    (user) => user.id != authUser2.id
                );

                if (results.length > 0) {
                    PERSON_IMG2 =
                        "../../img/usuarios/" + results[0].foto_perfil;
                    chatWith2.innerHTML = results[0].nombre;
                }
            });
        })
        .then(() => {
            axios.get(`/admin/chat/${chatId2}/get_messages`).then((res) => {
                appendMessages2(res.data.messages);
            });
        })
        .then(() => {
            Echo.join(`chat.${chatId2}`)
                .listen("MessageSent", (e) => {
                    appendMessage2(
                        e.message.user.nombre,
                        PERSON_IMG2,
                        "left",
                        e.message.content,
                        formatDate2(new Date(e.message.created_at))
                    );
                })
                .here((users) => {
                    let result = users.filter(
                        (user) => user.id != authUser2.id
                    );

                    if (result.length > 0)
                        chatStatus2.className = "chatStatus online";
                })
                .joining((user) => {
                    if (user.id != authUser2.id)
                        chatStatus2.className = "chatStatus online";
                })
                .leaving((user) => {
                    if (user.id != authUser2.id)
                        chatStatus2.className = "chatStatus offline";
                })
                .listenForWhisper("typing", (e) => {
                    if (e > 0) typing.style.display = "";

                    if (typingTimer2) {
                        clearTimeout(typingTimer2);
                    }

                    typingTimer2 = setTimeout(() => {
                        typing.style.display = "none";

                        typingTimer2 = false;
                    }, 3000);
                });
        });
});

msgerForm2.addEventListener("submit", (event) => {
    event.preventDefault();

    const msgText = msgerInput2.value;

    if (!msgText) return;

    axios
        .post("/admin/message/sent", {
            message: msgText,
            chat_id: chatId2,
        })
        .then((res) => {
            let data = res.data;

            appendMessage2(
                data.user.nombre,
                PERSON_IMG2,
                "right",
                data.content,
                formatDate2(new Date(data.created_at))
            );
        })
        .catch((error) => {
            console.log("Ha ocurrido un error");
            console.log(error);
        });

    msgerInput2.value = "";
});

function appendMessages2(messages) {
    let side = "left";

    messages.forEach((message) => {
        side = message.user_id == authUser2.id ? "right" : "left";

        appendMessage2(
            message.user.nombre,
            PERSON_IMG2,
            side,
            message.content,
            formatDate2(new Date(message.created_at))
        );
    });
}

function appendMessage2(name, img, side, text, date) {
    //   Simple solution for small apps
    const msgHTML = `
    <div class="msg ${side}-msg">
      <div class="msg-img" style="background-image: url(${img})"></div>

      <div class="msg-bubble">
        <div class="msg-info">
          <div class="msg-info-name">${name}</div>
          <div class="msg-info-time">${date}</div>
        </div>

        <div class="msg-text">${text}</div>
      </div>
    </div>
  `;

    msgerChat2.insertAdjacentHTML("beforeend", msgHTML);

    scrollToBottom2();
}

function sendTypingEvent2() {
    typingTimer2 = true;

    Echo.join(`chat.${chatId2}`).whisper("typing", msgerInput2.value.length);
}

// Utils
function get(selector) {
    return document.querySelector(selector);
}

function formatDate2(date) {
    const d = date.getDate();
    const mo = date.getMonth() + 1;
    const y = date.getFullYear();
    const h = "0" + date.getHours();
    const m = "0" + date.getMinutes();

    return `${d}/${mo}/${y} ${h.slice(-2)}:${m.slice(-2)}`;
}

function scrollToBottom2() {
    msgerChat2.scrollTop = msgerChat2.scrollHeight;
}
