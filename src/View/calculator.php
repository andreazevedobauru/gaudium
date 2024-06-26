<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimativa de Tarifas</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .box {
            flex: 1;
            margin: 10px;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        form > select, form > input, form > button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box" id="formBox">
            <form id="tarifaForm">
                <select id="cidade" required>
                    <option value="">Selecione uma cidade</option>
                    <!-- Opções adicionadas dinamicamente -->
                </select>
                <select id="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <!-- Opções adicionadas dinamicamente -->
                </select>
                <input type="text" id="origem" placeholder="Endereço de origem" required>
                <input type="text" id="destino" placeholder="Endereço de destino" required>
                <button type="submit">Calcular Tarifa</button>
            </form>
        </div>
        <div class="box" id="historicoBox">
            <h2>Histórico de Cálculos</h2>
            <ul id="historicoList">
                <!-- Itens adicionados dinamicamente -->
            </ul>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const cidadeSelect = document.getElementById('cidade');
    const categoriaSelect = document.getElementById('categoria');
    const form = document.getElementById('tarifaForm');
    const historicoList = document.getElementById('historicoList');

    // Carregar cidades
    fetch('http://localhost:8000/cities')
    .then(response => response.json())
    .then(data => {
        data.forEach(cidade => {
            let option = document.createElement('option');
            option.value = cidade.id;
            option.textContent = cidade.nome;
            cidadeSelect.appendChild(option);
        });
    });

    // Evento ao mudar de cidade
    cidadeSelect.addEventListener('change', function() {
        const cityId = this.value;
        fetch(`http://localhost:8000/categorias?city_id=${cityId}`)
        .then(response => response.json())
        .then(data => {
            categoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';
            data.forEach(categoria => {
                let option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nome;
                categoriaSelect.appendChild(option);
            });
        });
    });

    // Evento de submit do formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const origem = document.getElementById('origem').value;
        const destino = document.getElementById('destino').value;
        const cidadeId = cidadeSelect.value;
        const categoriaId = categoriaSelect.value;

        // Chamar a API de cálculo
        fetch('http://localhost:8000/calculate-fare', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `cidadeId=${cidadeId}&categoriaId=${categoriaId}&origem=${encodeURIComponent(origem)}&destino=${encodeURIComponent(destino)}`
        })
        .then(response => response.json())
        .then(data => {
            // Adicionar ao histórico
            let item = document.createElement('li');
            item.textContent = `Em ${cidadeSelect.options[cidadeSelect.selectedIndex].text}, ${categoriaSelect.options[categoriaSelect.selectedIndex].text}, de ${origem} para ${destino}, às ${new Date().toLocaleTimeString()}: R$ ${data.estimativa}`;
            historicoList.prepend(item);
        })
        .catch(error => {
            console.error('Erro ao calcular tarifa:', error);
        });
    });

    // Carregar histórico existente
    fetch('http://localhost:8000/historico')
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                let li = document.createElement('li');
                li.textContent = `Em ${item.cidade}, ${item.categoria}, de ${item.origem} para ${item.destino}, às ${item.hora}: R$ ${item.estimativa}`;
                historicoList.appendChild(li);
            });
        });
    });
    </script>
</body>
</html>
