@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 600px;">
                <div class="card-header d-flex fw-bold">
                    <div class="me-auto">
                        {{ $title }}
                    </div>
                    <div class="ms-auto">
                        <button type="button" data-bs-toggle="modal"
                            data-bs-target="#addAccModal"
                            class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                            <i class='bx bx-plus-circle fs-4'></i> New Category
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="addAccModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Create Category</h1>
                                <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                    aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('categories-index.store') }}" method="post">
                                    @csrf
                                    <div class="mb-5">
                                        <label for="cp_index" class="ms-2">Company Index</label>
                                        <input type="text" value="{{ $cp_index }}" name="cp_index" id="cp_index" class="form-control mb-3 fs-5" readonly>
                                        <label for="name" class="ms-2">Category Name</label>
                                        <input type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
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
                    @if ($categories->count() > 0)
                        @php
                            $cp_index += 1;
                        @endphp
                        <div class="table">
                            <table class="table table-striped table-primary align-middle">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">No</th>
                                        <th class="text-start" scope="col">Category Name</th>
                                        <th class="text-center" scope="col">Items</th>
                                        <th class="text-start" scope="col">Description</th>
                                        <th class="text-end" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key => $category)
                                        <tr>
                                            <td class="text-center">{{ ++$key }}</td>
                                            @php
                                                $ct_index = $categories->pluck('name')->search($category->name) + 1;
                                            @endphp
                                            <td style="max-width: 100px;">
                                                <a href="/manage/{{ $cp_index }}/categories/{{ $ct_index }}/">
                                                    {{ $category->name }}
                                                </a>
                                            </td>
                                            <td class="text-center" style="max-width: 200px;">{{ $category->products->count() }} items</td>
                                            <td class="text-start" style="max-width: 200px;">{{ $category->description }}</td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-end gap-2">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#addModal{{ $category->category_id }}"
                                                        class="btn btn-sm btn-primary text-white d-flex align-items-center gap-2">
                                                        <i class='bx bx-edit'></i> Edit
                                                    </button>
                                                    {{-- @if ($company->id > 0) --}}
                                                    <form action="{{ route('categories-index.destroy', $category->category_id) }}" method="post"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm d-flex align-items-center gap-2 py-2"
                                                            onclick="return confirm('Delete {{ $category->name }} ?')">
                                                            <i class='bx bxs-trash' ></i>
                                                        </button>
                                                    </form>
                                                    {{-- @endif --}}
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="addModal{{ $category->category_id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Edit {{ $category->name }}</h1>
                                                        <button type="button" class="btn btn-danger px-1 py-0 my-0" data-bs-dismiss="modal"
                                                            aria-label="Close"><i class='bx bx-x fs-3 pt-1'></i></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('categories-index.update', $category->category_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-5">
                                                                <label for="name" class="ms-2">Category Name</label>
                                                                <input value="{{ $category->name }}" type="text" name="name" id="name" class="form-control mb-3 fs-5" required>
                                                                <label for="description" class="ms-2">Description</label>
                                                                <textarea name="description" id="description" class="form-control mb-3 fs-5" row="3" style="resize:none;">{{ $category->description }}</textarea>
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
                        <p class="mb-0 text-danger text-center">Nothing here</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
