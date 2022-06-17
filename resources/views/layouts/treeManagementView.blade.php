@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">{{ __('Manage tree') }}</div>

                    <div class="card-body">
                        <!-- do wywalenia ten status-->
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            @if(auth()->user()->isAdmin())
                                <div id="tree" class="tree well col-md-8"></div>
                                <div class="col-md-4">
                                    <div class="container">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="add-tab" data-bs-toggle="pill" href="#tab-pane">Add</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="edit-tab" data-bs-toggle="pill" href="#tab-edit">Edit</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="delete-tab" data-bs-toggle="pill" href="#tab-delete">Delete</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane container active p-0" id="tab-pane">


                                                <div class="mt-4">
                                                    <h2>Add new a node or a leaf</h2>
                                                    <form id="addCategoryForm" class="needs-validation">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="inputNameAdd">Name</label>
                                                            <input type="text" class="form-control" id="inputNameAdd" placeholder="Name" required>
                                                            <div class="invalid-feedback">Please enter a valid name.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="selectParentAdd">Parent</label>
                                                            <select class="form-select parent-select" id="selectParentAdd" aria-label="Default select example">
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Add</button>
                                                    </form>
                                                </div>


                                            </div>
                                            <div class="tab-pane container fade p-0" id="tab-edit">


                                                <div class="mt-4">
                                                    <h2>Edit a node or a leaf</h2>
                                                    <form id="editCategoryForm" class="needs-validation">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <input type="hidden" id="inputIdCategoryEdit">
                                                            <label class="form-label" for="inputNameEdit">Name</label>
                                                            <input type="text" class="form-control" id="inputNameEdit" placeholder="Name" required>
                                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="selectParentEdit">Parent</label>
                                                            <select class="form-select parent-select" id="selectParentEdit" aria-label="Default select example">

                                                            </select>
                                                        </div>
                                                        <button type="submit" id="editCategory" class="btn btn-primary">Edit</button>
                                                    </form>
                                                </div>


                                            </div>
                                            <div class="tab-pane container fade p-0" id="tab-delete">

                                                <div class="mt-4">
                                                    <h2>Select a node or a leaf to remove </h2>
                                                    <form id="deleteCategoryForm" class="needs-validation">
                                                        <div class="mb-3">
                                                            <input type="hidden" id="inputIdCategoryDelete">
                                                            <label class="form-label" for="readonlyInputNameForDelete">Name</label>
                                                            <input type="text" class="form-control" id="readonlyInputNameForDelete" value="Name..." aria-label="Name..." readonly>
                                                            <div class="invalid-feedback">Please enter a valid name.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="readonlyInputParentForDelete">Parent</label>
                                                            <input type="text" class="form-control" id="readonlyInputParentForDelete" value="Parent name..." aria-label="Parent name..." readonly>
                                                            <div class="invalid-feedback">Please enter a valid email address.</div>
                                                        </div>
                                                        <button type="submit" id="deleteCategory" class="btn btn-primary">Delete</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="tree" class="tree well col-md-12"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
