@extends('layouts.report')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ČLANARINA') }}</div>
                    <div class="container">

                        <div class="row">
                            <form action="izvjestaj" method="post">
                                @csrf
                                <div class="row">
                                   
                                   
                                    <div class="col">
                                     
                                    </div>
                                    <div class="col">
                                        <label></label>
                                        <div class="d-flex justify-content-end">
                                    
                                            <a href="{{ route('createFee',$id)}}" class="btn btn-success">Dodaj članarinu</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>


                    <div class="card-body">
                  
                        {{-- Tabela početak --}}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Ime</th>
                                    <th scope="col">Prezime</th>
                                    <th scope="col" style="text-align: center">Datum uplate</th>
                                    <th scope="col" style="text-align: center">Datum početka</th>
                                    <th scope="col" style="text-align: center">Datum isteka</th> 
                                    <th scope="col" style="text-align: center">Izmijeni</th> 
                                    <th scope="col" style="text-align: center">Briši</th> 

                                    
                                 
                                </tr>
                            </thead>
                            <tbody>
                            
                                @if (isset($stanje))
                                    @foreach ($stanje as $key => $data)
                                        <tr>
                                            <td scope="row">{{ $data->name }}</td>
                                            <td scope="row">{{ $data->surname }}</td>
                                            <td scope="row" style="text-align: center">{{ $data->code }}</td>
                                            {{--   <td scope="row" style="text-align: center">{{$data->start}}</td> --}}
                                            {{-- <td scope="row" style="text-align: center">{{$data->end}}</td> --}}
                                             <td scope="row" style="text-align: center"> {{ date("d.m.Y", strtotime($data->start))}}</td>
                                            <td scope="row" style="text-align: center"> {{ date("d.m.Y", strtotime($data->end))}}</td>
                                            <td scope="row" style="text-align: center" ><a href="{{ route('editFee',$data->fees_id)}}" class="btn btn-warning">Izmijeni</a></td>
                                            <td scope="row" style="text-align: center" ><a href="{{ route('feesDelete',$data->fees_id)}}" class="btn btn-danger">Briši</a></td>
                                            
                                        </tr>
                                    @endforeach
                                @else
                                    <div class="text-center alert alert-success">
                                        Član nema uplata članarine.
                                    </div>
                                @endif
                            </tbody>
                        </table>
                    {{--    <span>@if (isset($stanje))
                            {{ $stanje->links('pagination::bootstrap-4') }}
                            
                        @endif</span>   --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
