@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 800px;">
                <div class="card-body">
                    <div class="row justify-content-end px-4 fs-2">
                        {{ $account->name }}
                    </div>
                    <div class="row my-1 px-1">
                        <div class="col-md-3 text-center border border-danger" style="height: 600px">
                            asu
                        </div>
                        <div class="col-md-9 text-center border border-danger">
                            <div class="card-body card-data-table">
                                <div class="table">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Nama Akun</th>
                                                <th scope="col">Kategori</th>
                                                <th scope="col">Saldo Awal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
