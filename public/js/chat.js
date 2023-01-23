const msgerForm = document.querySelector(".msger-inputarea");
const msgerInput = document.querySelector(".msger-input");
const msgerChat = document.querySelector(".msger-chat");
let PERSON_IMG = "";
const chatWith = document.querySelector(".chatWith");
const typing = document.querySelector(".typing");
const chatStatus = document.querySelector(".chatStatus");
let chatId = "";
let authUser;
let typingTimer = false;

$(document).ready(function () {
    $(".chatModal").click(function () {
        $("#formModalChat").modal("show");

        let id = $(this).data("chatid");

        $("#chat-mensajes").empty();
        $("#chat-mensajes").append(
            `
            <div class="text-center" style="margin-top: 5rem">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-primary">Cargando mensajes<span class="dotting"> </span></p>
            </div>
            `
        );
        chatWith.innerHTML = "Buscando...";

        $.get({
            url: `/admin/chat/with/${id}`,
            success: function (response) {
                chatId = response.pivot.chat_id;
                axios
                    .get("/admin/auth/user")
                    .then((res) => {
                        authUser = res.data.authUser;
                    })
                    .then(() => {
                        axios
                            .get(`/admin/chat/${chatId}/get_users`)
                            .then((res) => {
                                let results = res.data.users.filter(
                                    (user) => user.id != authUser.id
                                );

                                if (results.length > 0) {
                                    chatWith.innerHTML = results[0].nombre;
                                    $(".msg-img").attr(
                                        "src",
                                        "../../img/usuarios/" +
                                            results[0].foto_perfil
                                    );
                                }
                            });
                    })
                    .then(() => {
                        axios
                            .get(`/admin/chat/${chatId}/get_messages`)
                            .then((res) => {
                                $("#chat-mensajes").empty();
                                appendMessages(res.data.messages);
                            });
                    })
                    .then(() => {
                        Echo.join(`chat.${chatId}`)
                            .listen("MessageSent", (e) => {
                                appendMessage(
                                    "left",
                                    e.message.content,
                                    formatoFecha(new Date(e.message.created_at))
                                );
                            })
                            .here((users) => {
                                let result = users.filter(
                                    (user) => user.id != authUser.id
                                );

                                if (result.length > 0)
                                    chatStatus.className = "chatStatus online";
                            })
                            .joining((user) => {
                                if (user.id != authUser.id)
                                    chatStatus.className = "chatStatus online";
                            })
                            .leaving((user) => {
                                if (user.id != authUser.id)
                                    chatStatus.className = "chatStatus offline";
                            })
                            .listenForWhisper("typing", (e) => {
                                if (e > 0) typing.style.display = "";

                                if (typingTimer) {
                                    clearTimeout(typingTimer);
                                }

                                typingTimer = setTimeout(() => {
                                    typing.style.display = "none";

                                    typingTimer = false;
                                }, 3000);
                            });
                    });
            },
        });
    });
});

msgerForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const msgText = msgerInput.value;

    if (!msgText) return;

    axios
        .post("/admin/message/sent", {
            message: msgText,
            chat_id: chatId,
        })
        .then((res) => {
            let data = res.data;

            appendMessage(
                "right",
                data.content,
                formatoFecha(new Date(data.created_at))
            );
        })
        .catch((error) => {
            console.log("Ha ocurrido un error");
            console.log(error);
        });

    msgerInput.value = "";
});

function appendMessages(messages) {
    let side = "left";

    messages.forEach((message) => {
        side = message.user_id == authUser.id ? "right" : "left";

        appendMessage(
            side,
            message.content,
            formatoFecha(new Date(message.created_at))
        );
    });
}

function appendMessage(side, text, date) {
    // date = date.split(", ");
    // let fecha = date[0];
    // let hora = date[1];
    const msgHTML = `
    <div class="msg ${side}-msg">
      <div class="msg-bubble">
        <div class="msg-date">
            <div class="msg-text">${text}</div>
            <div class="msg-hora">${date}</div>
        </div>
      </div>
    </div>
  `;

    msgerChat.insertAdjacentHTML("beforeend", msgHTML);

    scrollToBottom();
}

function sendTypingEvent() {
    typingTimer = true;

    Echo.join(`chat.${chatId}`).whisper("typing", msgerInput.value.length);
}

// Utils
function get(selector) {
    return document.querySelector(selector);
}

function formatoFecha(fecha) {
    var fecha_hora = new Date(fecha);
    var opciones = {
        year: "numeric",
        month: "2-digit",
        day: "2-digit",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    };
    let date = fecha_hora.toLocaleString("es-MX", opciones);

    return date;
}

function scrollToBottom() {
    msgerChat.scrollTop = msgerChat.scrollHeight;
}
