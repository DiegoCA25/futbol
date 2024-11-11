<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Country;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    
    public function index()
    {
        $countries=Country::all();
        $teams =Team::with('country:id,country','players:id')->get();
        return Inertia::render('Teams/Index',[
            'teams'=>$teams,
            'countries'=>$countries
        ]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
       $request->validate([
        'name'=>'required|max:80',
        'league'=>'required|max:80',
        'country_id'=>'required|numeric',
       ]);
       $team =new team($request->input());
       $team->save();
       return redirect('teams');
    }

    
    public function show(Team $team)
    {
        //
    }

   
    public function edit(Team $team)
    {
       //
    }

    
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'league' => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);
        
        $team->update($validated);
        
        return redirect()->route('teams.index')->with('success', 'Equipo actualizado correctamente');
    }
    
    

    
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect('teams');
    }
}
