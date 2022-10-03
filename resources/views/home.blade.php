@extends('layouts.adminlte')

@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53</h3>
                <p>Jogadores Cadastrados</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>53</h3>
                <p>Times Cadastrados</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>53</h3>
                <p>Jogadores sem time</p>
            </div>

            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>

            <a href="#" class="small-box-footer">Ver lista <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header"> 
                <b> Últimos Jogos </b> 
            </div>

            <div class="card-body">
                <table class="table stripped">
                    <thead>
                        <tr>
                            <th> Mandante </th>
                            <th> </th>
                            <th> X </th>
                            <th> </th>
                            <th> Visitante </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td> Ibis </td>
                            <td> 5 </td>
                            <td> X </td>
                            <td> 3 </td>
                            <td> <b> Tabajara </b> </td>
                        </tr>

                        <tr>
                            <td> Mandaguaçu </td>
                            <td> 2 </td>
                            <td> X </td>
                            <td> 5 </td>
                            <td> <b> Tabajara </b> </td>
                        </tr>

                        <tr>
                            <td> <b> Tabajara </b> </td>
                            <td> 6 </td>
                            <td> X </td>
                            <td> 0 </td>
                            <td> Sua Mãe </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-header"> 
                <b> Próximos Jogos </b> 
            </div>

            <div class="card-body">
                <table class="table stripped">
                <thead>
                    <tr>
                        <th> Mandante </th>
                        <th> X </th>
                        <th> Visitante </th>
                        <th> Data </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td> Ibis </td>
                        <td> X </td>
                        <td> <b> Tabajara </b> </td>
                        <td> 22/02/2022 </td>
                    </tr>

                    <tr>
                        <td> Mandaguaçu </td>
                        <td> X </td>
                        <td> <b> Tabajara </b> </td>
                        <td> 09/10/2023 </td>
                    </tr>

                    <tr>
                        <td> <b> Tabajara </b> </td>
                        <td> X </td>
                        <td> Sua Mãe </td>
                        <td> 07/11/2023 </td>
                    </tr>
                </tbody>
            </table>
        </div>
       
    </div>
</div>
@endsection
