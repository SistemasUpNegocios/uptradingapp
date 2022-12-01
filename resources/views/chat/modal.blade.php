<div class="modal fade" id="formModalChat" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="msger">
                    <header class="msger-header">
                        <div class="msger-header-title">
                            <img src="{{ asset('img/usuarios/default.png') }}" alt="Imagen del usuario" class="msg-img">
                            <span class="chatWith"></span> 
                            <span class="typing" style="display: none;"> está escribiendo</span>
                        </div>
                        <div class="msger-header-options">
                            <span class="chatStatus offline">
                                <i class="bi bi-globe"></i>
                            </span>
                        </div>
                    </header>
        
                    <div class="msger-chat" id="chat-mensajes"></div>
        
                    <form class="msger-inputarea">
                        <input type="text" class="msger-input" oninput="sendTypingEvent()" placeholder="Escribe un mensaje aquí...">
                        <button type="submit" class="msger-send-btn"><i class="bi bi-send"></i></button>
                    </form>
        
                </section>
            </div>
        </div>
    </div>
</div>