async function incluirAlterar() {
    const ctrlFormulario = document.getElementById("ctrlFormulario");
    const formularioMusicas = document.getElementById("formularioMusicas");

    if (ctrlFormulario.value == 'incluir') {
        if (validar() === true) {
            const dados = new FormData(formularioMusicas);

            try {
                const resposta = await fetch("musicas_incluir.php", {
                    method: "POST",
                    body: dados
                });

                const resultado = await resposta.json();

                if (resultado.status === "sucesso") {
                    alert("musica cadastrada com sucesso!");

                    formularioMusicas.reset();

                    preencherGrade();
                } else {
                    alert("Erro: " + resultado.mensagem);
                }

            } catch (erro) {
                alert("Falha ao enviar: " + erro.message);
            }
        }
        return;
    };

    if (ctrlFormulario.value == 'alterar') {
        if (validar() === true) {
            const dados = new FormData(formularioMusicas);

            try {
                const resposta = await fetch("musicas_alterar.php", {
                    method: "POST",
                    body: dados
                });

                const resultado = await resposta.json();

                if (resultado.status === "sucesso") {
                    alert("musica atualizada com sucesso!");

                    formularioMusicas.reset();

                    preencherGrade();
                } else {
                    alert("Erro: " + resultado.mensagem);
                }

            } catch (erro) {
                alert("Falha ao enviar: " + erro.message);
            }
        }
        return;
    };
}

function validar() {
    const frmAlbumId = document.getElementById("frmAlbumId");
    const frmNome = document.getElementById("frmNome");
    const frmNota = document.getElementById("frmNota");
    const frmDuracao = document.getElementById("frmDuracao");


    let validacaoOK = true;
    let mensagemErro = '';

    if (frmAlbumId.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo album não foi preenchido\n";
    }

    if (frmNome.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo nome não foi preenchido\n";
    }

    if (frmNota.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo nota não foi preenchido";
    }

    if (frmDuracao.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo duração não foi preenchido";
    } else {
        const regex = /^([0-9]{2}):([0-5][0-9]):([0-5][0-9])$/;

        if (regex.test(frmDuracao.value) === false) {
            validacaoOK = false;
            mensagemErro += "o campo duração esta invalido";
        }

    }

    if (validacaoOK === false) {
        alert(mensagemErro);
    }

    return validacaoOK;
}

async function preencherSelectAlbumId() {
    try {
        const resposta = await fetch("albuns_consultar.php", {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const registros = resultado.registros;
            const selectAlbuns = document.getElementById("frmAlbumId");
            let options = '<option value="">selecione...</option>';

            registros.forEach(dado => {
                options += `<option value="${dado.id}">${dado.nome}</option>`;
            });

            selectAlbuns.innerHTML = options;
        } else {
            alert("Erro: " + resultado.mensagem);
        }

    } catch (erro) {
        alert("Falha ao enviar: " + erro.message);
    }
}

async function preencherGrade() {
    try {
        const resposta = await fetch("musicas_consultar.php", {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const registros = resultado.registros;
            const gradeRegistros = document.getElementById("gradeRegistros");
            let grade = '';

            registros.forEach(dado => {
                grade += `<tr>
                            <td class="tabela-coluna-banda">${dado.album_nome}</td>
                            <td class="tabela-coluna-nome">${dado.nome}</td>
                            <td>${dado.nota}</td>
                            <td>${dado.duracao}</td>
                            <td> 
                            <div class="container-botao">
                              <button class="botao-alterar" onclick="pegarRegistro(${dado.id})"><i class="fa fa-pencil"></i></button>
                              <button class="botao-excluir" onclick="excluirRegistro(${dado.id})"><i class="fa fa-trash"></i></button>
                              </div>
                            </td>
                          </tr>`;
            });

            gradeRegistros.innerHTML = grade;
        } else {
            alert("Erro: " + resultado.mensagem);
        }

    } catch (erro) {
        alert("Falha ao enviar: " + erro.message);
    }
}

async function pegarRegistro(id) {
    try {
        const resposta = await fetch("musicas_pegar_registro.php?id=" + id, {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const ctrlFormulario = document.getElementById("ctrlFormulario");
            ctrlFormulario.value = 'alterar';


            const registro = resultado.registro;

            const frmAlbumId = document.getElementById("frmAlbumId");
            const frmNome = document.getElementById("frmNome");
            const frmNota = document.getElementById("frmNota");
            const frmDuracao = document.getElementById("frmDuracao");

            registro.forEach(dado => {
                const frmId = document.getElementById("frmId");
                frmId.value = dado.id;

                frmAlbumId.value = dado.album_id;
                frmNome.value = dado.nome;
                frmNota.value = dado.nota;
                frmDuracao.value = dado.duracao;
            });

        } else {
            alert("Erro: " + resultado.mensagem);
        }

    } catch (erro) {
        alert("Falha ao enviar: " + erro.message);
    }
}

async function excluirRegistro(id) {
    let confirma = confirm("confirme a exclusão?");

    if (confirma === true) {

        try {
            const resposta = await fetch("musicas_excluir.php?id=" + id, {
                method: "GET"
            });

            const resultado = await resposta.json();

            if (resultado.status === "sucesso") {
                alert("musica excluida com sucesso");
                preencherGrade();
            } else {
                alert("Erro: " + resultado.mensagem);
            }

        } catch (erro) {
            alert("Falha ao enviar: " + erro.message);
        }

    }

}

// Mascara para manter o campo frmDuracao no padrão 00:00:00
function mascaraDuracao() {
    const frmDuracao = document.getElementById("frmDuracao");

    let v = frmDuracao.value.replace(/\D/g, ""); // remove tudo que não é número
    if (v.length > 6) v = v.slice(0, 6);     // limita 6 dígitos HHMMSS

    // Formata HH:MM:SS
    let h = v.slice(0, 2);
    let m = v.slice(2, 4);
    let s = v.slice(4, 6);

    let resultado = "";

    if (h) resultado += h;
    if (m) resultado += ":" + m;
    if (s) resultado += ":" + s;

    frmDuracao.value = resultado;

}

//Execução apos renderização da tela
document.addEventListener('DOMContentLoaded', function () {
    const botaoConfirmarInclusao = document.getElementById("botaoConfirmarInclusao");

    botaoConfirmarInclusao.addEventListener("click", function () {
        incluirAlterar();
    });


    preencherGrade();
    preencherSelectAlbumId();
});
