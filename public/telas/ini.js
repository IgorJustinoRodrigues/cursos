function confirmacao(link, descricao) {
    $("#div-confirmacao").html(descricao);
    $("#link-confirmacao").attr('href', link);
    $("#modalConfirmacao").modal('show');
}