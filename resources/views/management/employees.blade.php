@extends('layouts.app')

@section('content')

@section('title')
    Managing Employees
@endsection

<div class="container d-flex flex-column">
    <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 200px;">
        <div class="card-header d-flex fw-bold">
            <div class="me-auto">
                {{ __('Staff Positions') }}
            </div>
            <div class="ms-auto">
                <button type="button" data-bs-toggle="modal"
                    data-bs-target="#addPosModal"
                    class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                    <i class='bx bx-edit'></i> New
                </button>
            </div>
        </div>
        <div class="modal fade" id="addPosModal" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Create Position</h1>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            aria-label="Close">x</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('index') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="name">Position Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                                <label for="name">Position Description</label>
                                <input type="text" name="description" id="description" class="form-control" required>
                            </div>
                            <button class="btn btn-primary px-4" type="submit">
                                Create
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body card-data-table">
            @if ($positions->count() > 0)
                <div class="table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-start" scope="col">No</th>
                                <th class="text-start" scope="col">Position</th>
                                <th class="text-center" scope="col">Assigned</th>
                                <th class="text-start" scope="col">Description</th>
                                <th class="text-center" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($positions as $key => $position)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $position->name }}</td>
                                    @if ($position->count() > 0)
                                        <td class="text-center">{{ number_format($position->count()) }} orang</td>
                                    @else
                                        <td class="text-center">Vacant</td>
                                    @endif
                                    <td>{{ $position->description }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            @if ($position->id > 1)
                                                <form action="{{ route('index', "pos-".$position->id) }}" method="post"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                                        onclick="return confirm('Delete {{ $position->name }} position?')">
                                                        <i class="bx bx-trash-alt"></i> Remove
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#addModal{{ $position->id }}"
                                                class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                                                <i class='bx bx-edit'></i> Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="addModal{{ $position->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit Position {{ $position->name }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('index', 'pos-'.$position->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name">Position Name</label>
                                                        <input type="text" name="name" id="name"
                                                            value="{{ $position->name }}" class="form-control"
                                                            required>
                                                        <label for="name">Position Description</label>
                                                        <input type="text" name="description" id="description"
                                                            value="{{ $position->description }}" class="form-control"
                                                            required>
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
                <p class="mb-0 text-danger text-center">Belum ada Posisi Staff</p>
            @endif
        </div>
    </div>
    <div data-bs-theme="light" class="card border-1" style="height: 450px">
        <div class="card-header fw-bold">{{ __('Registered Staff') }}</div>
        <div class="card-body card-data-table">
            @if ($users->count() > 0)
                <div class="table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="">No</th>
                                <th class="">Name</th>
                                <th class="">Position</th>
                                <th class="">Email</th>
                                <th class="">Join at</th>
                                <th class="text-center">opt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $user->name }}</td>
                                    @if ($user->position)
                                        <td>{{ $user->position->name }}</td>
                                    @else
                                        <td>None</td>
                                    @endif
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <form action="{{ route('index', "user-".$user->id) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm d-flex align-items-center gap-2"
                                                    onclick="return confirm('Delete {{ $user->name }} from user database?')">
                                                    <i class="bx bx-trash-alt"></i> Remove
                                                </button>
                                            </form>
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#addModalUser{{ $user->id }}"
                                                class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                                                <i class='bx bx-edit'></i> Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="addModalUser{{ $user->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5">Edit Position For {{ $user->name }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('index', 'user-'.$user->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name">Staff Name</label>
                                                        <input type="text" name="name" id="name"
                                                            value="{{ $user->name }}" class="form-control"
                                                            required readonly>
                                                        <label for="position_id">Choose Position</label>
                                                        <select name="position_id" id="position_id" class="form-control" required>
                                                            @foreach ($positions as $position)
                                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                                            @endforeach
                                                        </select>
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
                <p class="mb-0 text-danger text-center">Belum ada Posisi Staff</p>
            @endif
        </div>
    </div>
</div>

@endsection