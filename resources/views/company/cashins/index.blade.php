@extends('layouts.app')

@section('content')

@section('title')
    {{ $title }}
@endsection

<div class="container" data-bs-theme="light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div data-bs-theme="light" class="card border-1 mb-4" style="max-height: 850px;">
                <div class="card-header d-flex fw-bold">
                    <div class="me-auto">
                        New Transaction
                    </div>
                    <div class="ms-auto">
                        {{ $title }}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('cashins-index.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="cp_index" class="ms-2 fw-bold">Company Index</label>
                            <input type="text" value="{{ $cp_index }}" name="cp_index" id="cp_index" class="form-control mb-3 fs-5" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" name="title" id="title" class="form-control fs-5" required>
                        </div>
                        <div class="mb-3">
                            <label for="account_id" class="form-label fw-bold">Select Account</label>
                            <select name="account_id" id="account_id" class="form-select me-2 fs-5" required>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label fw-bold">Amount</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control fs-5" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control fs-5" row="3" style="resize:none;"></textarea>
                        </div>
                        <button class="btn btn-primary px-4" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
