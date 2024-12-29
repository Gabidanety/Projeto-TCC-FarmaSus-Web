<!--CSS OK, NÃO TEM BACK-END SOMENTE O BOTÃO DE LOGOUT (ASS:DUDA)-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Tags Obrigatórias -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link correto para a versão mais recente do Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS do Bootstrap (não alterado) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Seu CSS personalizado -->
	<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/headerFarmacia.css')}}"> 

    <!-- Título e favicon da página -->
    <title>Dashboard Farmácia | FarmaSUS</title>
    <link rel="shortcut icon" href="{{ asset('Image/favicon-farmacia.ico')}}" type="image/x-icon">
</head>
<header>
    <div class="header">
        <div class="side-nav">
            <div class="logo">
                <img src="{{ asset('Image/3a.png')}}" alt="Logo do FarmaSUS" class="logo">
            </div>

            <!-- Menu lateral -->
            <ul>
                <li><a href="/homeFarmacia"><i class="fas fa-tachometer-alt"></i><p>Painel</p></a></li>
                <li><a href="/estoqueHome"><i class="fas fa-boxes"></i><p>Estoque</p></a></li>
                <li><a href="/MedicamentoHome"><i class="fas fa-pills"></i><p>Medicamentos</p></a></li>
                <li><a href="/EntradaMedicamentoHome"><i class="fas fa-arrow-circle-down"></i><p>Entrada Medicamentos</p></a></li>
                <li><a href="/saidaLista"><i class="fas fa-arrow-circle-up"></i><p>Saída Medicamentos</p></a></li>
                <li><a href="/funcionarios"><i class="fas fa-user-friends"></i><p>Funcionário</p></a></li>
                <li><a href="/entrada_medicamento"><i class="fas fa-exchange-alt"></i><p>Tipo Movimentação</p></a></li>
            </ul>

            <!-- Logout -->
            <ul class="saida">
                <li class="li-saida">
                    <form id="logout-form" action="/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i><p>Sair</p></a>
                </li>
            </ul>
        </div>
    </div>
</header>

