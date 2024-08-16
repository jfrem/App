<?php

use App\Http\Controllers\TodosController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// // Ruta para mostrar la lista de todos
// Route::get('/todos', [TodosController::class, 'index'])->name('todos.index');

// // Ruta para almacenar un nuevo todo
// Route::post('/todos', [TodosController::class, 'store'])->name('todos.store');

// // Ruta para mostrar un todo específico
// Route::get('/todos/{id}', [TodosController::class, 'show'])->name('todos.show');

// // Ruta para mostrar el formulario de edición de un todo
// Route::get('/todos/{id}/edit', [TodosController::class, 'edit'])->name('todos.edit');

// // Ruta para actualizar un todo existente
// Route::patch('/todos/{id}', [TodosController::class, 'update'])->name('todos.update');

// // Ruta para eliminar un todo
// Route::delete('/todos/{id}', [TodosController::class, 'destroy'])->name('todos.destroy');
Route::resource('todos', TodosController::class);

// Ruta para mostrar el formulario de
Route::resource('category', CategoryController::class);

// Ruta para cambiar el estado de la categoría
Route::patch('category/{id}/toggle-state', [CategoryController::class, 'toggleState'])->name('category.toggleState');