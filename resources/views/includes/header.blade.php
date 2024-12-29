<!--CSS OK, ASS:DUDA-->
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
	
	<!--CSS nosso-->
	<link rel="stylesheet" href="{{ asset('css/Adm-CSS/header.css')}}">

	<!--Título e favicon da página-->
	<title>Dashboard Administrador | FarmaSUS</title>
	<link rel="shortcut icon" href="{{ asset('Image/favicon.ico')}}" type="image/x-icon">
</head>
<header>
	<div class="header">
		<div class="side-nav">
			<div class="logo">
                <img src="{{ asset('Image/3a.png')}}" alt="Logo do FarmaSUS" class="logo">
            </div>

			<!-- Menu lateral -->
			<ul>
                <li><a href="/"><i class="fas fa-tachometer-alt"></i><p>Painel</p></a></li>
                <li><a href="/medicamento"><i class="fas fa-boxes"></i><p>Medicamentos</p></a></li>
                <li><a href="/medicamentoForm"> <i class="fas fa-prescription-bottle-alt"></i><p>Cadastro Medicamentos</p></a></li>
                <li><a href="/detentor"><i class="fas fa-users-cog"></i><p>Cadastro Detentor</p></a></li>
                <li><a href="/selectUBS"><i class="fas fa-clinic-medical"></i><p>Unidades Básicas de Saúde</p></a></li>
                <li><a href="/selectRegiaoForm"><i class="fas fa-map-marked-alt"></i><p>Cadastro de UBS</p></a></li>
                <li><a href="/cliente"><i class="fas fa-user-injured"></i><p>Pacientes</p></a></li>
				<li><a href="/contato"><i class="fas fa-comment-alt"></i><p>Mensagens</p></a></li>
            </ul>

			<!-- Logout -->
           
            <ul class="saida">
                <li class="li-saida">
                    <a href="/verificacao" ></i><p>Sair</p></a>
                </li>
            </ul>
		</div>
	</div>
</header>


