<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use App\Models\Category;

use Illuminate\Http\Request;

class TodosController extends Controller
{
    /**
     * todos.create
     * todos.show Muestra un todo específico.
     * todos.index para mostar los todos.
     * todos.edit para mostrar el formulario de edicion de un todo.
     * todos.update para actualizar un todo.
     * todos.store para guardar un todo.
     * todos.destroy para eliminar un todo.
     */

    /**
     * Muestra la lista de todos.
     *
     * @return \Illuminate\View\View
     */

    public function index()
    {
        // Capturar el filtro de la URL, o 'all' si no está presente
        $filter = request()->input('filter', 'all');

        switch ($filter) {
            case 'completed':
                $todos = Todos::where('completed', true)->get();
                break;
            case 'pending':
                $todos = Todos::where('completed', false)->get();
                break;
            case 'all':
            default:
                $todos = Todos::all();
                break;
        }

        return view('todos.index', [
            'todos' => $todos,
            'filter' => $filter,
            'categories' => Category::where('state', true)->get(),
        ]);
    }

    /**
     * Almacena un nuevo todo en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'category_id' => 'required|exists:categories,id' ?: 'required'
        ]);

        $todo = new Todos();
        $todo->title = $request->title;
        $todo->category_id = $request->category_id;
        $todo->save();

        return redirect()->route('todos.index')->with('success', 'Tarea creada correctamente');
    }

    /**
     * Muestra el formulario para editar un todo existente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $todo = Todos::findOrFail($id);
        return view('todos.edit', ['todo' => $todo]);
    }

    /**
     * Actualiza un todo existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $todo = Todos::findOrFail($id);
        $todo->completed = $request->boolean('completed');
        $todo->save();

        return redirect()->route('todos.index')->with('success', 'Tarea actualizada correctamente');
    }

    /**
     * Elimina un todo de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $todo = Todos::findOrFail($id);
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Tarea eliminada correctamente');
    }

}
