@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('UNOS KORISNIKA') }}</div>
                <div class="container">
                    <div class="row">
                    </div>
                </div>
                <div class="card-body">

                    <form class="row g-3 needs-validation" action="{{ route('updateMember') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                  
                        <div class="col-md-6">
                            <input style="display:none" type="id" name="id" value="{{$member->id}}"/>
                            <label for="inputEmail4" class="form-label">Ime</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{$member->name}}">
                            
                        </div>
                        <div class="col-md-6">
                            <label for="inputPassword4" class="form-label">Prezime</label>
                            <input type="text" class="form-control" id="surname" name="surname" required value="{{$member->surname}}">
                        </div>
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Code</label>
                            <input type="text" class="form-control" id="code" placeholder="" name="code" required value="{{$member->code}}">
                        </div>
                        <div class="col-5">
                            <label for="inputAddress" class="form-label">JMBG</label>
                            <input type="text" class="form-control" id="jmbg" placeholder="" name="jmbg" required value="{{$member->jmbg}}">
                        </div>
                        <div class="col-4">
                            <label for="inputAddress" class="form-label">E-mail</label>
                            <input type="text" class="form-control" id="email" placeholder="" name="email" required value="{{$member->email}}">
                        </div>
                   
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Datum registracije</label>
                            <?php 
                           
                            $mytime = Carbon\Carbon::now();
                            ?>
                            <input type="text" class="form-control" id="register_date" name="register_date" required value="{{$member->register_date}}">
                        </div>
                        
                        <div class="image col-md-6">
                            <label for="inputState" class="form-label">Upload slike</label>
                            <input class="form-control" type="file" id="image" name="image">
                        </div>
                        <div class="col-3">
                            <label for="inputAddress" class="form-label">Mobitel</label>
                            <input type="text" class="form-control" id="mobile" placeholder="" name="mobile" value="{{$member->mobile}}" required>
                        </div>
                        <div class="col-md-5">
                            <label for="inputZip" class="form-label">Ulica</label>
                            <input type="text" class="form-control" id="street" name="street" required style="text-align: left" aria-describedby="customFileInput" value="{{$member->street}}">
                        </div>
                        <div class="col-md-3">
                            <label for="inputZip" class="form-label">Poštanski broj</label>
                            <input type="number" class="form-control" id="post_no" name="post_no" required style="text-align: left" aria-describedby="customFileInput" value="{{$member->post_no}}">
                        </div>
                        <div class="col-md-4">
                            <label for="inputZip" class="form-label">Grad</label>
                            <input type="text" class="form-control" id="city" name="city" required style="text-align: left" aria-describedby="customFileInput" value="{{$member->city}}">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                                <label class="form-check-label" for="gridCheck">
                                    Aktiviraj
                                </label>
                            </div>
                        </div>
                     
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Snimi</button>
                        </div>
                    </form>
                    <hr>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                         
                        <a style="float: right;" href="{{ route('members')}}" class="btn btn-light border">Početna</a>

                </div>

                </div>
            </div>
        </div>
    </div>
  @endsection