document.addEventListener("DOMContentLoaded", () => {
    listarTodos();
    // Inicializando o modal
    M.Modal.init(document.querySelectorAll('.modal'));
});

function listarTodos() {
    fetch("listar.php", {
        method: "GET",
        headers: { 'Content-Type': "application/json; charset=UTF-8" }
    })
        .then(response => response.json())
        .then(produtos => inserirprodutos(produtos))
        .catch(error => console.log(error));
}

function inserirprodutos(produtos) {
    produtos.forEach(produto => inserirProduto(produto));
}

document.addEventListener("DOMContentLoaded", () => {
    listarTodos(); // Carrega os produtos na inicialização
    document.getElementById("btn-gerar-pdf").addEventListener("click", gerarPDF); // Gera PDF
});

function gerarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    if (!window.produtosCache || window.produtosCache.length === 0) {
        M.toast({ html: "Nenhum produto disponível para gerar o PDF.", classes: "red darken-4" });
        return;
    }

    doc.setFontSize(16);
    doc.text("Lista de Produtos", 14, 20);

    const colunas = ["ID", "Nome", "Descrição", "Preço"];
    const linhas = [];

    window.produtosCache.forEach(produto => {
        linhas.push([produto.id_produto, produto.nome, produto.descricao, produto.preco]);
    });

    doc.autoTable({
        head: [colunas],
        body: linhas,
        startY: 30
    });

    doc.save("produtos.pdf");

    M.toast({ html: "PDF gerado com sucesso!", classes: "green darken-4" });
}
function inserirProduto(produto) {
    let tbody = document.getElementById('produtos');
    let tr = document.createElement('tr');

    let tdId = document.createElement('td');
    tdId.innerHTML = produto.id_produto;

    let tdNome = document.createElement('td');
    tdNome.innerHTML = produto.nome;

    let tdDescricao = document.createElement('td');
    tdDescricao.innerHTML = produto.descricao;

    let tdPreco = document.createElement('td');
    tdPreco.innerHTML = produto.preco;

    let tdImagem = document.createElement('td');
    let img = document.createElement('img');
    img.src = produto.imagem;
    img.alt = produto.nome;
    img.classList.add('materialboxed', 'img-tabela');
    tdImagem.appendChild(img);

    let tdAlterar = document.createElement('td');
    let btnAlterar = document.createElement('button');
    btnAlterar.innerHTML = "Alterar";
    btnAlterar.classList.add('btn', 'blue', 'darken-4');
    btnAlterar.addEventListener("click", buscaProduto, false);
    btnAlterar.id_produto = produto.id_produto;
    tdAlterar.appendChild(btnAlterar);

    let tdExcluir = document.createElement('td');
    let btnExcluir = document.createElement('button');
    btnExcluir.innerHTML = "Excluir";
    btnExcluir.classList.add('btn', 'red', 'darken-4');
    btnExcluir.addEventListener("click", abrirModalConfirmacao, false);
    btnExcluir.id_produto = produto.id_produto;
    tdExcluir.appendChild(btnExcluir);

    tr.appendChild(tdId);
    tr.appendChild(tdNome);
    tr.appendChild(tdDescricao);
    tr.appendChild(tdPreco);
    tr.appendChild(tdImagem);
    tr.appendChild(tdAlterar);
    tr.appendChild(tdExcluir);

    tbody.appendChild(tr);

    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
}

function abrirModalConfirmacao(evt) {
    let id_produto = evt.currentTarget.id_produto;
    let modal = M.Modal.getInstance(document.getElementById('modal-confirmacao'));
    let btnConfirmar = document.getElementById('btn-confirmar-exclusao');
    let btnCancelar = document.getElementById('btn-cancelar-exclusao');

    modal.open();  // Abre o modal

    btnConfirmar.onclick = function () {
        excluir(id_produto);
        modal.close();  // Fecha o modal
    };

    btnCancelar.onclick = function () {
        modal.close();  // Fecha o modal
    };
}

function excluir(id_produto) {
    fetch('excluir.php?id_produto=' + id_produto, {
        method: "GET",
        headers: { 'Content-Type': "application/json; charset=UTF-8" }
    })
        .then(response => response.json())
        .then(retorno => excluirProduto(retorno, id_produto))
        .catch(error => console.log(error));
}

function excluirProduto(retorno, id_produto) {
    if (retorno === true) {
        let tbody = document.getElementById('produtos');
        for (const tr of tbody.children) {
            if (tr.children[0].innerHTML == id_produto) {
                tbody.removeChild(tr);
                break;
            }
        }
    }
}

function alterarProduto(produto) {
    let tbody = document.getElementById('produtos');
    for (const tr of tbody.children) {
        if (tr.children[0].innerHTML == produto.id_produto) {
            tr.children[1].innerHTML = produto.nome;
            tr.children[2].innerHTML = produto.descricao;
            tr.children[3].innerHTML = produto.preco;

            let img = tr.children[4].querySelector('img');
            img.src = produto.imagem;
        }
    }
}

function buscaProduto(evt) {
    let id_produto = evt.currentTarget.id_produto;
    fetch('buscaproduto.php?id_produto=' + id_produto, {
        method: "GET",
        headers: { 'Content-Type': "application/json; charset=UTF-8" }
    })
        .then(response => response.json())
        .then(produto => preencheForm(produto))
        .catch(error => console.log(error));
}

function preencheForm(produto) {
    document.getElementsByName("id_produto")[0].value = produto.id_produto;
    document.getElementsByName("nome")[0].value = produto.nome;
    document.getElementsByName("descricao")[0].value = produto.descricao;
    document.getElementsByName("preco")[0].value = produto.preco;
    document.getElementsByName("imagem")[0].value = produto.imagem;
}

function salvarProduto(event) {
    event.preventDefault();

    let id_produto = document.getElementsByName("id_produto")[0].value;
    let nome = document.getElementsByName("nome")[0].value;
    let descricao = document.getElementsByName("descricao")[0].value;
    let preco = document.getElementsByName("preco")[0].value;
    let inputImagem = document.getElementsByName("imagem")[0];

    resetarCampos(); // Reseta os campos antes de realizar a validação

    let valid = true;

    // Validação do nome
    if (!nome) {
        mostrarErro("O nome do produto é obrigatório.", "nome");
        valid = false;
    } else {
        limparErro("nome");
    }

    // Validação da descrição
    if (!descricao) {
        mostrarErro("A descrição do produto é obrigatória.", "descricao");
        valid = false;
    } else {
        limparErro("descricao");
    }

    // Validação do preço
    if (!preco || isNaN(preco) || preco <= 0) {
        mostrarErro("O preço do produto deve ser um número positivo.", "preco");
        valid = false;
    } else {
        limparErro("preco");
    }

    // Validação da imagem
    if (inputImagem.files.length === 0) {
        mostrarErro("Por favor, selecione uma imagem para o produto.", "imagem");
        valid = false;
    } else {
        let file = inputImagem.files[0];
        let validExtensao = ['image/jpeg', 'image/png', 'image/gif'];
        if (!validExtensao.includes(file.type)) {
            mostrarErro("A imagem deve ser um arquivo válido (JPG, PNG ou GIF).", "imagem");
            valid = false;
        } else {
            limparErro("imagem");
        }
    }

    // Se não for válido, retorna
    if (!valid) {
        return false;
    }

    // Se os dados estiverem corretos, segue com a leitura da imagem e envio dos dados
    let reader = new FileReader();
    reader.onload = function (e) {
        let imagemBase64 = e.target.result;

        // Cadastrar ou alterar produto dependendo da presença do id_produto
        if (id_produto === "") {
            cadastrar(id_produto, nome, descricao, preco, imagemBase64);
        } else {
            alterar(id_produto, nome, descricao, preco, imagemBase64);
        }

        document.querySelector('form').reset();  // Limpa o formulário após a submissão
    };
    reader.readAsDataURL(inputImagem.files[0]);  // Converte a imagem para base64
}

function resetarCampos() {
    // Limpa todos os campos de erro e estilos de validação
    const campos = document.querySelectorAll('.input-field input');
    campos.forEach(input => {
        input.classList.remove('invalid', 'valid');
    });
}

function mostrarErro(mensagem, campo) {
    // Exibe a mensagem de erro no topo e marca o campo com erro
    M.toast({ html: mensagem, classes: 'red darken-4' });

    let input = document.getElementsByName(campo)[0];
    input.classList.add('invalid');
}

function limparErro(campo) {
    // Limpa o erro e a classe "invalid" dos campos
    let campoInput = document.getElementsByName(campo)[0];
    campoInput.classList.remove('invalid');  // Remove a classe de erro
    campoInput.classList.add('valid');  // Marca o campo como válido
}

// Funções de cadastro e alteração continuam as mesmas
function cadastrar(id_produto, nome, descricao, preco, imagem) {
    fetch('inserir.php', {
        method: 'POST',
        body: JSON.stringify({ id_produto, nome, descricao, preco, imagem }),
        headers: {
            'Content-Type': 'application/json; charset=UTF-8'
        }
    })
        .then(response => response.json())
        .then(produto => inserirProduto(produto))
        .catch(error => console.log(error));
}

function alterar(id_produto, nome, descricao, preco, imagem) {
    fetch('alterar.php', {
        method: 'POST',
        body: JSON.stringify({ id_produto, nome, descricao, preco, imagem }),
        headers: {
            'Content-Type': 'application/json; charset=UTF-8'
        }
    })
        .then(response => response.json())
        .then(produto => alterarProduto(produto))
        .catch(error => console.log(error));
}
