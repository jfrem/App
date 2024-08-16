@extends('app')

@section('content')

<div class="container mt-5" style="max-width: 600px">
    <div class="p-4 bg-white shadow rounded">
        <div class="text-center mb-4">
            <h4 class="fw-bold">DOTO List</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('category.store') }}" method="post" aria-label="Formulario de Creación de Categoría">
                @csrf

                @if (session('success'))
                <div role="alert" aria-live="assertive" class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @error('title')
                <div role="alert" aria-live="assertive" class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror

                <label for="title" class="form-label fw-bold">Título categoría *</label>
                <div class="input-group mb-3">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Escribe una nueva categoría" aria-describedby="taskHelp" />
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <small id="taskHelp" class="form-text text-muted">Este campo es obligatorio.</small>
            </form>
            <ul class="list-unstyled mt-4">
                @forelse ($categories as $category)
                <li class="d-flex align-items-center justify-content-between p-2" style="border-bottom: 1px solid #d0d0d0">
                    <div class="d-flex align-items-center">
                        <span class="card-text" style="color: #333; font-size: 16px;">
                            <i class="fas fa-layer-group text-primary"></i> {{ $category->title }}
                        </span>
                    </div>
                    <div>
                        <!-- Edit button trigger modal -->
                        <button type="button" class="btn btn-sm" style="background: none; border: none; color: #007bff" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#editCategoryModal" data-id="{{ $category->id }}" data-title="{{ $category->title }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- State button -->
                        <form action="{{ route('category.toggleState', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button
                                type="submit"
                                class="btn btn-sm"
                                style="background: none; border: none; color: #f44336; cursor: pointer;"
                                title="{{ $category->state ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-trash {{ $category->state ? 'text-success' : 'text-danger' }}"></i>
                            </button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="text-muted text-center" style="color: #777;">No hay Categorías 😏</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Título</label>
                        <input type="text" name="title" id="editTitle" class="form-control" placeholder="Escribe el nuevo título de la categoría">
                    </div>
                    <input type="hidden" name="id" id="editCategoryId">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editCategoryButtons = document.querySelectorAll('[data-id]');
        editCategoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-id');
                const categoryTitle = this.getAttribute('data-title');

                // Set the values in the modal form
                document.getElementById('editCategoryId').value = categoryId;
                document.getElementById('editTitle').value = categoryTitle;

                // Set the form action
                document.getElementById('editCategoryForm').action = `/category/${categoryId}`;
            });
        });
    });
</script>