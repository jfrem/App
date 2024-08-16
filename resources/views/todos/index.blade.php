@extends('app')

@section('content')

<div class="container mt-5" style="max-width: 600px">
    <!-- Contenedor principal de la aplicación -->
    <div class="p-4 bg-white shadow rounded">
        <!-- Encabezado de la sección -->
        <div class="text-center mb-4">
            <h4 class="fw-bold">DOTO List</h4>
        </div>

        <div class="card-body">
            <!-- Formulario para crear una nueva tarea -->
            <form action="{{ route('todos.index') }}" method="post" aria-label="Task Creation Form" novalidate>
                @csrf
                <!-- Mensaje de éxito (si existe) -->
                @if (session('success'))
                <div role="alert" aria-live="assertive" class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Mensaje de error para el campo título (si existe) -->
                @error('title')
                <div role="alert" aria-live="assertive" class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror

                <!-- Mensaje de error para el campo categoría (si existe) -->
                @error('category_id')
                <div role="alert" aria-live="assertive" class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror

                <!-- Campo para ingresar el título de la tarea -->
                <label for="title" class="form-label fw-bold">Título *</label>
                <div class="input-group mb-3">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Escribe tu nueva tarea" aria-describedby="taskHelp" aria-required="true" aria-invalid="@error('title') true @else false @enderror" />
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <!-- Campo para seleccionar la categoría de la tarea -->
                <label for="category_id" class="form-label fw-bold">Categoría *</label>
                <div class="input-group mb-3">
                    <select class="form-select" name="category_id" id="category_id" aria-label="Categoría opcional">
                        <option value="" selected>Selecciona una categoría</option>
                        <!-- Opciones de categoría disponibles -->
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Texto de ayuda para el campo de categoría -->
                <small id="taskHelp" class="form-text text-muted">Estos campos son requeridos.</small>
            </form>

            <!-- Filtros para ver tareas -->
            <div class="d-flex align-items-start mt-4 text-muted">
                <a href="{{ route('todos.index', ['filter' => 'all']) }}" class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm mx-2" aria-label="Show All Tasks">
                    Todos
                </a>
                <a href="{{ route('todos.index', ['filter' => 'completed']) }}" class="btn {{ $filter === 'completed' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm mx-2" aria-label="Show Completed Tasks">
                    Completadas
                </a>
                <a href="{{ route('todos.index', ['filter' => 'pending']) }}" class="btn {{ $filter === 'pending' ? 'btn-primary' : 'btn-outline-secondary' }} btn-sm mx-2" aria-label="Show Pending Tasks">
                    Pendientes
                </a>
            </div>

            <!-- Lista de tareas -->
            <ul class="list-unstyled mt-4">
                @forelse ($todos as $todo)
                <li class="d-flex align-items-center justify-content-between p-2" style="border-bottom: 1px solid #e0e0e0">
                    <div class="d-flex align-items-center">
                        <!-- Formulario para marcar la tarea como completada -->
                        <form action="{{ route('todos.update', [$todo->id]) }}" method="POST" id="completeForm{{$todo->id}}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="completed" value="0">
                            <input type="checkbox" name="completed" value="1" style="margin-right: 10px" aria-label="Mark as Completed" onchange="document.getElementById('completeForm{{$todo->id}}').submit()" {{ $todo->completed ? 'checked' : '' }} />
                        </form>
                        <!-- Mostrar el título de la tarea -->
                        <span class="card-text {{ $todo->completed ? 'text-decoration-line-through' : '' }}">{{ $todo->title }}</span>
                        <!-- Mostrar la categoría asociada a la tarea (si existe) -->
                        @if ($todo->category)
                        <span class="badge rounded-pill bg-secondary ms-2">{{ $todo->category->title }}</span>
                        @endif
                    </div>
                    <!-- Formulario para eliminar la tarea -->
                    <form action="{{ route('todos.destroy', [$todo->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta tarea?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm" style="background: none; border: none; color: #f44336">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </li>
                @empty
                <!-- Mensaje cuando no hay tareas -->
                <li class="text-muted text-center">No hay tareas 😏</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection