<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * category.index
     * category.store
     * category.create
     * category.show
     * category.edit
     * category.update
     * category.destroy
     */

    public function index()
    {
        $categories = Category::all();
        return view('todos.category', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos ()
        $request->validate([
            'title' => 'required|unique:categories|min:3'
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }
    /**
     * Eliminar una categoría.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Categoría eliminada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $category = Category::findOrFail($id);
        $category->title = $request->input('title');
        $category->save();
        return redirect()->route('category.index')->with('success', 'Categoría actualizada correctamente');
    }

    public function toggleState($id)
    {
        // Encuentra la categoría por su ID
        $category = Category::findOrFail($id);

        // Cambia el estado de la categoría (si está activo, lo desactiva y viceversa)
        $category->state = !$category->state;
        $category->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('category.index')->with('success', 'Estado de la categoría actualizado correctamente');
    }

}
