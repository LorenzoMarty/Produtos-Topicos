document.addEventListener("DOMContentLoaded", () => {
    listarTodos();
    document.getElementById("btn-gerar-pdf").addEventListener("click", gerarPDF);
    M.Modal.init(document.querySelectorAll('.modal'));
});

function listarTodos() {
    fetch("listar.php", {
        method: "GET",
        headers: { 'Content-Type': "application/json; charset=UTF-8" }
    })
        .then(response => response.json())
        .then(produtos => {
            window.produtosCache = produtos;
            inserirprodutos(produtos);
        })
        .catch(error => console.log(error));
}

function inserirprodutos(produtos) {
    const tbody = document.getElementById("produtos");
    tbody.innerHTML = "";
    produtos.forEach(produto => inserirProduto(produto));
}

function gerarPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    if (!window.produtosCache || window.produtosCache.length === 0) {
        M.toast({ html: "Nenhum produto disponível para gerar o PDF.", classes: "red darken-4" });
        return;
    }

    const img = new Image();
    img.src = 'img/icon.png'; 

    img.onload = () => {

        doc.addImage(img, 'PNG', 80, 10, 20, 20);

        doc.setFontSize(20);
        doc.setFont("helvetica", "bold");
        doc.setTextColor(0, 123, 255); 
        doc.text("SuperTudo", 104, 20); 

        doc.setFontSize(20);
        doc.setTextColor(0, 0, 0);
        doc.text("Lista de Produtos", 20, 35); 

        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text("Detalhes dos produtos cadastrados no sistema.", 20, 45);

        const colunas = ["ID", "Nome", "Descrição", "Preço"];
        const linhas = [];

        window.produtosCache.forEach(produto => {
            linhas.push([produto.id_produto, produto.nome, produto.descricao, produto.preco]);
        });

        doc.autoTable({
            head: [colunas],
            body: linhas,
            startY: 50,  
            theme: 'striped',
            headStyles: {
                fillColor: [0, 123, 255], 
                textColor: [255, 255, 255], 
                fontSize: 12,
                font: "helvetica",
                halign: 'center',
            },
            bodyStyles: {
                fontSize: 10,
                font: "helvetica",
                halign: 'center',
                valign: 'middle',
                fillColor: (rowIndex) => rowIndex % 2 === 0 ? [220, 220, 220] : [169, 169, 169],
            },
            columnStyles: {
                0: { halign: 'center' }, 
                1: { halign: 'left' }, 
                2: { halign: 'left' }, 
                3: { halign: 'right' }, 
            },
            margin: { top: 30, left: 10, right: 10 },
            pageBreak: 'auto',
        });
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            doc.setFontSize(8);
            doc.setFont("helvetica", "normal");
            doc.text(`Página ${i} de ${pageCount}`, doc.internal.pageSize.width - 20, doc.internal.pageSize.height - 10);
        }

        doc.save("produtos.pdf");

        M.toast({ html: "PDF gerado com sucesso!", classes: "green darken-4" });
    };
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

    let tdOpcoes = document.createElement('td');
    let btnAlterar = document.createElement('button');
    btnAlterar.innerHTML = "Alterar";
    btnAlterar.classList.add('btn', 'blue', 'darken-4', 'waves-effect', 'waves-light', 'btn-small');
    btnAlterar.addEventListener("click", buscaProduto, false);
    btnAlterar.id_produto = produto.id_produto;
    let btnExcluir = document.createElement('button');
    btnExcluir.innerHTML = "Excluir";
    btnExcluir.classList.add('btn', 'red', 'darken-4', 'waves-effect', 'waves-light', 'btn-small', 'ml-1');
    btnExcluir.addEventListener("click", abrirModalConfirmacao, false);
    btnExcluir.id_produto = produto.id_produto;
    tdOpcoes.appendChild(btnAlterar);
    tdOpcoes.appendChild(document.createTextNode(" "));
    tdOpcoes.appendChild(btnExcluir);

    tr.appendChild(tdId);
    tr.appendChild(tdNome);
    tr.appendChild(tdDescricao);
    tr.appendChild(tdPreco);
    tr.appendChild(tdImagem);
    tr.appendChild(tdOpcoes);

    tbody.appendChild(tr);

    M.Materialbox.init(document.querySelectorAll('.materialboxed'));
}


function abrirModalConfirmacao(evt) {
    let id_produto = evt.currentTarget.id_produto;
    let modal = M.Modal.getInstance(document.getElementById('modal-confirmacao'));
    let btnConfirmar = document.getElementById('btn-confirmar-exclusao');
    let btnCancelar = document.getElementById('btn-cancelar-exclusao');

    modal.open();

    btnConfirmar.onclick = function () {
        excluir(id_produto);
        modal.close();
    };

    btnCancelar.onclick = function () {
        modal.close();
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

        let modal = M.Modal.getInstance(document.getElementById('modal-sucesso'));
        modal.open(); 

        limparFormulario();
    }
}

function limparFormulario() {
    const form = document.querySelector('form');
    if (form) {
        form.reset();
    }
    resetarCampos();
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

    resetarCampos(); 

    let valid = true;

    if (!nome) {
        mostrarErro("O nome do produto é obrigatório.", "nome");
        valid = false;
    } else {
        limparErro("nome");
    }

    if (!descricao) {
        mostrarErro("A descrição do produto é obrigatória.", "descricao");
        valid = false;
    } else {
        limparErro("descricao");
    }

    if (!preco || isNaN(preco) || preco <= 0) {
        mostrarErro("O preço do produto deve ser um número positivo.", "preco");
        valid = false;
    } else {
        limparErro("preco");
    }

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

    if (!valid) {
        return false;
    }

    let reader = new FileReader();
    reader.onload = function (e) {
        let imagemBase64 = e.target.result;

        if (id_produto === "") {
            cadastrar(id_produto, nome, descricao, preco, imagemBase64);
        } else {
            alterar(id_produto, nome, descricao, preco, imagemBase64);
        }

        document.querySelector('form').reset(); 
    };
    reader.readAsDataURL(inputImagem.files[0]);  
}

function resetarCampos() {
    const campos = document.querySelectorAll('.input-field input');
    campos.forEach(input => {
        input.classList.remove('invalid', 'valid');
    });
}

function mostrarErro(mensagem, campo) {
    M.toast({ html: mensagem, classes: 'red darken-4' });

    let input = document.getElementsByName(campo)[0];
    input.classList.add('invalid');
}

function limparErro(campo) {
    let campoInput = document.getElementsByName(campo)[0];
    campoInput.classList.remove('invalid');  
    campoInput.classList.add('valid'); 
}

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
