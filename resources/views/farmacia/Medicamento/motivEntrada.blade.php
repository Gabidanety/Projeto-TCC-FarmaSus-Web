@include('includes.headerFarmacia')

<!-- Aqui vai o forms do motivo entrada-->

<!-- Main content -->
<div class="col-md-9 col-lg-10 main-content">
    <div class="head-title">
        <div class="left">
            <h1>Entrada do Medicamento</h1>

        </div>
    </div>

    <form action="/motivEntrada" method="POST">
            @csrf <!-- Token de segurança para o formulário -->
            
            <div class="form-group">
                <label for="motivoEntrada">Motivo de Entrada:</label>
                <input type="text" class="form-control" id="motivoEntrada" name="motivoEntrada" required>
               
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
        </form>
    
</div>

@include('includes.footer')
