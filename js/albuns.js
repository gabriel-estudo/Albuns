async function incluirAlterar() {
    const ctrlFormulario = document.getElementById("ctrlFormulario");
    const formularioAlbuns = document.getElementById("formularioAlbuns");

    if (ctrlFormulario.value == 'incluir') {
        if (validar() === true) {
            const dados = new FormData(formularioAlbuns);

            try {
                const resposta = await fetch("albuns_incluir.php", {
                    method: "POST",
                    body: dados
                });

                const resultado = await resposta.json();

                if (resultado.status === "sucesso") {
                    alert("Album cadastrada com sucesso!");

                    formularioAlbuns.reset();

                    // limpando o preview
                    document.getElementById("imgPreview").src = '';
                    document.getElementById("preview").style.display = "none";


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
            const dados = new FormData(formularioAlbuns);

            try {
                const resposta = await fetch("albuns_alterar.php", {
                    method: "POST",
                    body: dados
                });

                const resultado = await resposta.json();

                if (resultado.status === "sucesso") {
                    alert("Album atualizada com sucesso!");

                    formularioAlbuns.reset();

                    // limpando o preview
                    document.getElementById("imgPreview").src = '';
                    document.getElementById("preview").style.display = "none";

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
    const frmBandaId = document.getElementById("frmBandaId");
    const frmNome = document.getElementById("frmNome");
    const frmNota = document.getElementById("frmNota");

    let validacaoOK = true;
    let mensagemErro = '';

    if (frmBandaId.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo banda não foi preenchido\n";
    }

    if (frmNome.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo nome não foi preenchido\n";
    }

    if (frmNota.value == '') {
        validacaoOK = false;
        mensagemErro += "o campo nota não foi preenchido";
    }

    if (validacaoOK === false) {
        alert(mensagemErro);
    }

    return validacaoOK;
}

async function preencherSelectBandaId() {
    try {
        const resposta = await fetch("bandas_consultar.php", {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const registros = resultado.registros;
            const selectBandas = document.getElementById("frmBandaId");
            let options = '<option value="">selecione...</option>';

            registros.forEach(dado => {
                options += `<option value="${dado.id}">${dado.nome}</option>`;
            });

            selectBandas.innerHTML = options;
        } else {
            alert("Erro: " + resultado.mensagem);
        }

    } catch (erro) {
        alert("Falha ao enviar: " + erro.message);
    }
}

async function preencherGrade() {
    try {
        const resposta = await fetch("albuns_consultar.php", {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const registros = resultado.registros;
            const gradeRegistros = document.getElementById("gradeRegistros");
            let grade = '';

            registros.forEach(dado => {
                grade += `<tr>
                            <td class="tabela-coluna-foto"><img class="foto-avatar" src='img/album_${dado.id}.png'/></td>
                            <td class="tabela-coluna-banda">${dado.banda_nome}</td>
                            <td class="tabela-coluna-nome">${dado.nome}</td>
                            <td>${dado.nota}</td>
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
        const resposta = await fetch("albuns_pegar_registro.php?id=" + id, {
            method: "GET"
        });

        const resultado = await resposta.json();

        if (resultado.status === "sucesso") {
            const ctrlFormulario = document.getElementById("ctrlFormulario");
            ctrlFormulario.value = 'alterar';


            const registro = resultado.registro;

            const frmBandaId = document.getElementById("frmBandaId");
            const frmNome = document.getElementById("frmNome");
            const frmNota = document.getElementById("frmNota");
            const preview = document.getElementById("preview");
            const imgPreview = document.getElementById("imgPreview");


            registro.forEach(dado => {
                const frmId = document.getElementById("frmId");
                frmId.value = dado.id;

                frmBandaId.value = dado.banda_id;
                frmNome.value = dado.nome;
                frmNota.value = dado.nota;

                preview.style.display = "block";
                imgPreview.src = "img/album_" + dado.id + ".png";
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
            const resposta = await fetch("albuns_excluir.php?id=" + id, {
                method: "GET"
            });

            const resultado = await resposta.json();

            if (resultado.status === "sucesso") {
                alert("Album excluido com sucesso");
                preencherGrade();
            } else {
                alert("Erro: " + resultado.mensagem);
            }

        } catch (erro) {
            alert("Falha ao enviar: " + erro.message);
        }

    }

}

//Execução apos renderização da tela
document.addEventListener('DOMContentLoaded', function () {
    const botaoConfirmarInclusao = document.getElementById("botaoConfirmarInclusao");

    botaoConfirmarInclusao.addEventListener("click", function () {
        incluirAlterar();
    });


    preencherGrade();
    preencherSelectBandaId();

    // preview de imagem
    document.getElementById("frmFoto").addEventListener("change", function (e) {
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                document.getElementById("imgPreview").src = evt.target.result;
                document.getElementById("preview").style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    })
});
