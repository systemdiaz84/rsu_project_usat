<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Family;
use App\Models\admin\Familyphoto;
use App\Models\admin\Specie;
use App\Models\admin\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $families = Family::all();
        return view('admin.families.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.families.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Family::create($request->all());
        return Redirect()->route('admin.families.index')->with('success', 'Familia Registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $family = Family::find($id);

        $photos = Familyphoto::where('family_id', $id)->get();

        return view('admin.families.show', compact('family', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $family = Family::find($id);
        return view('admin.families.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $family = Family::find($id);
        $family->update($request->all());

        //return view('admin.families.show', compact('family'));
        return Redirect()->route('admin.families.index')->with('success', 'Familia Actualizada');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $family = Family::find($id);
        $countSpecies = Specie::where('family_id',$id)->count();
        $counttrees = Tree::where('family_id',$id)->count();

        if ($countSpecies>0 || $counttrees>0){
            return Redirect()->route('admin.families.index')->with('error','No se puede eliminar ya que tiene registros asociados');
        }else{
            $family->delete();
            return Redirect()->route('admin.families.index')->with('success','Familia Eliminada');
        }  
    }

    public function species_family($id)
    {
        $species = Specie::where('family_id',$id)->get();

        return $species;
        //return response()->json($species);
    }
}