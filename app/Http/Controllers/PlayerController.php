<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\Country; // Asegúrate de incluir el modelo de Country
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayerController extends Controller
{
    // Mostrar la lista paginada de jugadores
    public function index()
    {
        $players = Player::paginate(10); // O el método que uses para obtener los jugadores
        return Inertia::render('Players/Index', [
            'players' => $players
        ]);
    }

    // Mostrar formulario de creación de jugador
    public function create()
    {
        $teams = Team::all();
        $countries = Country::all(); // Asegúrate de que estás recuperando los países correctamente.
    
        return Inertia::render('Players/Create', [
            'teams' => $teams,
            'countries' => $countries, // Pasa las nacionalidades (countries) a la vista.
        ]);
    }
    

    // Guardar un nuevo jugador
    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'description' => 'required|max:200',
            'nationality' => 'required|exists:countries,id', // Cambié 'country_id' por 'nationality'
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // Validación de la imagen
        ]);

        // Crear el nuevo jugador en la base de datos
        $player = Player::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'team_id' => $validated['team_id'],
            'nationality' => $validated['nationality'], // Cambié 'country_id' por 'nationality'
            'description' => $validated['description'], // Guardamos la descripción
        ]);

        // Si se sube una imagen, guardarla
        if ($request->hasFile('image')) {
            $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/img', $imgName);
            $player->image = '/img/' . $imgName; // Actualizamos el campo 'image' en el jugador
            $player->save(); // Guardamos los cambios en la base de datos
        }

        // Redirigir al listado de jugadores con un mensaje de éxito
        return redirect()->route('players.index')->with('success', 'Jugador creado con éxito.');
    }

    // Mostrar los detalles de un jugador específico
    public function show(Player $player)
    {
        return Inertia::render('Players/Show', [
            'player' => $player,
        ]);
    }

    // Mostrar formulario de edición de un jugador
    public function edit(Player $player)
    {
        // Obtener los equipos y países disponibles
        $teams = Team::all();
        $countries = Country::all(); // Asegúrate de que el modelo Country esté bien configurado

        return Inertia::render('Players/Edit', [
            'player' => $player,
            'teams' => $teams,
            'countries' => $countries, // Pasamos los países a la vista
        ]);
    }

    // Actualizar la información de un jugador
    public function update(Request $request, Player $player)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'nationality' => 'required|exists:countries,id', // Cambié 'country_id' por 'nationality'
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validación de la imagen
        ]);

        // Mantener la ruta de la imagen actual
        $path = $player->image;

        // Si se sube una nueva imagen, se guarda y se elimina la anterior si existía
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            // Guardar la nueva imagen
            $path = $request->file('image')->store('players', 'public');
        }

        // Actualizar el jugador con los nuevos datos
        $player->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'team_id' => $validated['team_id'],
            'nationality' => $validated['nationality'], // Cambié 'country_id' por 'nationality'
            'image' => $path,  // Actualizar la ruta de la imagen
        ]);

        // Redirigir al listado de jugadores con un mensaje de éxito
        return redirect()->route('players.index')->with('success', 'Jugador actualizado con éxito.');
    }

    // Eliminar un jugador
    public function destroy(Player $player)
    {
        // Si el jugador tiene una imagen, eliminarla del almacenamiento
        if ($player->image) {
            Storage::disk('public')->delete($player->image);
        }

        // Eliminar el jugador de la base de datos
        $player->delete();

        // Redirigir al listado de jugadores con un mensaje de éxito
        return redirect()->route('players.index')->with('success', 'Jugador eliminado con éxito.');
    }
}
