async function pegarMelhores() {
    try {
        const resposta = await fetch("melhores.php", {
            method: "GET"
        });

        const resultado = await resposta.json();


        if (resultado.status === "sucesso") {
            const banda = resultado.banda;
            const album = resultado.album;
            const musica = resultado.musica;
            const show = resultado.show;

            if (banda !== null) {
                document.getElementById("nomeMelhorBanda").innerText = banda.nome;
                document.getElementById("fotoMelhorBanda").src = "img/banda_" + banda.id + ".png";
            }
            if (album !== null) {
                document.getElementById("nomeMelhorAlbum").innerText = album.nome;
                document.getElementById("fotoMelhorAlbum").src = "img/album_" + album.id + ".png";
            }
            if (musica !== null) {
                document.getElementById("fotoMelhorMusicaAlbum").src = "img/album_" + musica.album_id + ".png";
                document.getElementById("nomeMelhorMusica").innerText = musica.nome;
            }
            if (show !== null) {
                document.getElementById("nomeUltimoShow").innerText = show.local;
            }

        }
        else {
            alert("Erro: " + resultado.mensagem);
        }

    } catch (erro) {
        alert("Falha ao enviar: " + erro.message);
    }
}

//Execução apos renderização da tela
document.addEventListener('DOMContentLoaded', function () {
    pegarMelhores();
});
