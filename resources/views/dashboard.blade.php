@extends('layouts.app')

@section('content')

@section('title')
    User Dashboard
@endsection

<div class="container d-flex flex-column">
    <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 400px;">
        <div class="card-header d-flex fw-bold">
            <div class="me-auto">
                {{ __('Manage Companies') }}
            </div>
            <div class="ms-auto">
                <button type="button" data-bs-toggle="modal"
                    data-bs-target="#addCompModal"
                    class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                    <i class='bx bx-edit'></i> New
                </button>
            </div>
        </div>
        <div class="modal fade" id="addCompModal" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Register Company</h1>
                        <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                            aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('user-index.store') }}" method="post">
                            @csrf
                            <div class="mb-5">
                                <label for="name" class="ms-2">Company Name</label>
                                <input type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                <label for="email" class="ms-2">Company Email</label>
                                <input type="email" name="email" id="email" class="form-control mb-3 fs-5" required>
                                <label for="phone" class="ms-2">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control mb-3 fs-5" required>
                                <label for="address" class="ms-2">Address</label>
                                <input type="text" name="address" id="address" class="form-control mb-3 fs-5" required>
                                <label for="website" class="ms-2">Website</label>
                                <input type="text" name="website" id="website" class="form-control mb-3 fs-5">
                                <label for="description" class="ms-2">Description</label>
                                <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;"></textarea>
                            </div>
                            <div class="d-flex my-3 align-items-center justify-content-center gap-2">
                                <button class="btn btn-primary" type="submit">
                                    Create
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body card-data-table">
            @if ($companies->count() > 0)
                <div class="table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-start" scope="col">No</th>
                                <th class="text-start" scope="col">Company Name</th>
                                <th class="text-start" scope="col">Address</th>
                                <th class="text-center" scope="col">Balance</th>
                                <th class="text-end" scope="col">Item Count</th>
                                <th class="text-end" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $key => $company)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td style="max-width: 100px;">{{ $company->name }}</td>
                                    <td class="text-start" style="max-width: 200px;">{{ $company->address }}</td>
                                    @php
                                        $balance = 0;
                                        $accounts = $company->accounts;
                                        foreach ($accounts as $account) {
                                            $balance += $account->balance;
                                        };
                                    @endphp
                                    <td class="text-center" style="max-width: 200px;">Rp{{ number_format($balance) }}</td>
                                    @if ($company->products->count() > 0)
                                        <td class="text-end">{{ number_format($company->products->count()) }} items</td>
                                    @else
                                        <td class="text-end">empty</td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            @php
                                                $cp_index = $companies->pluck('name')->search($company->name) + 1;
                                            @endphp
                                            <a type="button" href="/manage/{{ $cp_index }}/"
                                                class="btn btn-sm btn-success text-white d-flex align-items-center gap-2">
                                                <i class='bx bxs-key'></i> Manage
                                            </a>
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#addModal{{ $company->company_id }}"
                                                class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                                                <i class='bx bx-edit'></i> Edit
                                            </button>
                                            {{-- @if ($company->id > 0) --}}
                                            <form action="{{ route('user-index.destroy', $company->company_id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm d-flex align-items-center gap-2 py-2"
                                                    onclick="return confirm('Delete {{ $company->name }} ?')">
                                                    <i class='bx bxs-trash' ></i>
                                                </button>
                                            </form>
                                            {{-- @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="addModal{{ $company->company_id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit {{ $company->name }}</h1>
                                                <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                                    aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('user-index.update', $company->company_id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-5">
                                                        <label for="name" class="ms-2">Company Name</label>
                                                        <input value="{{ $company->name }}" type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                                        <label for="email" class="ms-2">Company Email</label>
                                                        <input value="{{ $company->email }}" type="email" name="email" id="email" class="form-control mb-3 fs-5" required>
                                                        <label for="phone" class="ms-2">Phone Number</label>
                                                        <input value="{{ $company->phone }}" type="text" name="phone" id="phone" class="form-control mb-3 fs-5" required>
                                                        <label for="address" class="ms-2">Address</label>
                                                        <input value="{{ $company->address }}" type="text" name="address" id="address" class="form-control mb-3 fs-5" required>
                                                        <label for="website" class="ms-2">Website</label>
                                                        <input value="{{ $company->website }}" type="text" name="website" id="website" class="form-control mb-3 fs-5">
                                                        <label for="description" class="ms-2">Description</label>
                                                        <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;">{{ $company->description }}</textarea>
                                                    </div>
                                                    <button class="btn btn-primary px-4" type="submit">
                                                        Save Changes
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="my-4 text-danger text-center fst-italic fs-4 fw-bold">No Data</p>
            @endif
        </div>
    </div>
</div>
@endsection