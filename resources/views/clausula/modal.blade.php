<div class="modal fade" id="formModalClausula" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Añadir cláusula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="clausulaForm" method="post">
                    @csrf
                    <input type="hidden" name="id" id="idInput">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea type="text" class="form-control"
                                    placeholder="Ingresa la redacción de la cláusula" id="redaccionInput"
                                    name="redaccion" style="height: 100px" required></textarea>
                                <label for="redaccionInput">Redacción de la cláusula</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="tipoid" id="TipoIdInput">
                    <div id="alertMessage"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btnCancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn principal-button" id="btnSubmit">Añadir cláusula</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>