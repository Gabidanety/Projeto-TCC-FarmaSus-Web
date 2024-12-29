<!--CSS OK (ASS:Duda)-->
@include('includes.headerFarmacia')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Prescrição.css')}}">

<div class="navbar">
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Pesquisar...">
        <button class="search-button"><i class="fas fa-search"></i></button>
    </div>
</div>

<div class="container-um">
    <div class="jumbotron-um">
        <h1 style="font-weight: bold;"> Prescrições </h1>
    </div>
    <div class="image-container">
        <img src="{{ asset('Image/lista.png') }}" alt="Saída De Medicamentos" class="img-fluid">
    </div>
</div>

<main>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-wrapper">
        <form action="/Cadprescricao" method="POST" class="styled-form">
            @csrf
            <input type="hidden" id="prescricaoId" name="prescricaoId">

            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th colspan="2">Cadastro de Prescrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="date" class="form-control" id="dataPrescricao" name="dataPrescricao" required></td>
                        <td><label for="dataPrescricao">Data da Prescrição:</label></td>
                    </tr>

                    <tr>
                        <td><input type="number" class="form-control" id="quantPrescricao" name="quantPrescricao" required></td>
                        <td><label for="quantPrescricao">Quantidade:</label></td>
                    </tr>

                    <tr>
                        <td><input type="text" class="form-control" id="dosagemPrescricao" name="dosagemPrescricao" required></td>
                        <td><label for="dosagemPrescricao">Dosagem:</label></td>
                    </tr>

                    <tr>
                        <td><input type="number" class="form-control" id="duracaoRemedio" name="duracaoRemedio" required></td>
                        <td><label for="duracaoRemedio">Duração (em dias):</label></td>
                    </tr>

                    <tr>
                        <td>
                            <select class="form-control" id="idMedicamento" name="idMedicamento" required>
                                <option value="">Selecione um medicamento</option>
                                @foreach ($medicamento as $med)
                                    <option value="{{ $med->idMedicamento }}">{{ $med->nomeMedicamento }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><label for="idMedicamento">Medicamento:</label></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="submit-btn" id="submitBtn" style="margin-left: 18%;">
                Salvar Prescrição
            </button>
        </form>
    </div>


    <div class="col-md-8">
            <div class="head-title">
                <h4>Prescrições</h4>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Medicamento</th>
                        <th>Quantidade</th>
                        <th>Dosagem</th>
                        <th>Duração</th>
                        <th>Situação</th>

                        <th>Ações</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($prescricoes as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->dataPrescricao)->format('d/m/Y') }}</td>
                        <td>{{ $p->medicamento->nomeMedicamento }}</td>
                        <td>{{ $p->quantPrescricao }}</td>
                        <td>{{ $p->dosagemPrescricao }}</td>
                        <td>{{ $p->duracaoRemedio }} dias</td>
                        <td>{{ $p->situacaoPrescricao  == 'A' ? 'Ativo' : 'Inativo' }}</td>

                        <td>
                            <button class="btn btn-warning btn-sm edit-btn"
                                data-id="{{ $p->idPrescricao }}"
                                data-data-prescricao="{{ $p->dataPrescricao }}"
                                data-quant-prescricao="{{ $p->quantPrescricao }}"
                                data-dosagem-prescricao="{{ $p->dosagemPrescricao }}"
                                data-duracao-remedio="{{ $p->duracaoRemedio }}"
                                data-id-medicamento="{{ $p->idMedicamento }}">
                                Editar
                            </button>
                        </td>
                        <td>
                            <form action="{{ route('prescricao.desativar', $p->idPrescricao) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja desativar esta prescrição?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Desativar</button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@include('includes.footer')
<script>
        $(document).ready(function() {
            // Quando o botão "Editar" é clicado
            $('.edit-btn').click(function() {
                const dataPrescricao = $(this).data('data-prescricao');
                const quantPrescricao = $(this).data('quant-prescricao');
                const dosagemPrescricao = $(this).data('dosagem-prescricao');
                const duracaoRemedio = $(this).data('duracao-remedio');
                const idMedicamento = $(this).data('id-medicamento');
                const prescricaoId = $(this).data('id');

                $('#dataPrescricao').val(dataPrescricao);
                $('#quantPrescricao').val(quantPrescricao);
                $('#dosagemPrescricao').val(dosagemPrescricao);
                $('#duracaoRemedio').val(duracaoRemedio);
                $('#idMedicamento').val(idMedicamento);
                $('#prescricaoId').val(prescricaoId);

                // Atualiza a ação e o método do formulário
                $('#prescricaoForm').attr('action', `/Cadprescricao/${prescricaoId}`);
                $('#prescricaoForm').append('<input type="hidden" name="_method" value="PUT">'); // Adiciona método PUT

                // Mostra o botão "Salvar Alterações" e esconde o botão "Cadastrar Prescrição"
                $('#saveChangesBtn').show();
                $('#submitBtn').hide();
            });

            // Ao clicar no botão "Salvar Alterações", envia o formulário
            $('#saveChangesBtn').click(function() {
                $('#prescricaoForm').submit(); // Submete o formulário
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>