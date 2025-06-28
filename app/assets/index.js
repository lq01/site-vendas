function navegar(pagina) {
    history.pushState({pagina}, "", `?pagina=${pagina}`);
    carregarConteudo(pagina);
}

window.onpopstate = function (event) {
    const pagina = new URLSearchParams(window.location.search).get("pagina") || "produtos";
    carregarConteudo(pagina);
};

function carregarConteudo(pagina) {
    fetch(`views/${pagina}.php`)
        .then(resp => resp.text())
        .then(html => {
            document.getElementById("conteudo").innerHTML = html;
            if (pagina === "produtos") {
                document.dispatchEvent(new Event("paginaProdutosCarregada"));
            }
            
        })
        .catch(() => {
            document.getElementById("conteudo").innerHTML = "<p>Erro ao carregar página.</p>";
        });
}

document.addEventListener("DOMContentLoaded", () => {
    const pagina = new URLSearchParams(window.location.search).get("pagina") || "venda";
    carregarConteudo(pagina);
});

