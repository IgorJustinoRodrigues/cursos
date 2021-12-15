function excluir(id, info) {
    $("#msgConfirmacao").text('Administrador(a) "' + info + '"');
    $("#id-delete").val(id);
    $("#modalExcluir").modal("show");
}