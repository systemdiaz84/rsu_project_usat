<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\admin\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $families = Tree::select(
            'families.name as name',
            DB::raw('count(*) as y'),
            'families.name as drilldown'
        )
            ->join('species', 'species.id', '=', 'trees.specie_id')
            ->join('families', 'families.id', '=', 'species.family_id')
            ->groupBy('families.name')->get();

        $families_list = Tree::select('families.name', 'families.id')
            ->join('species', 'species.id', '=', 'trees.specie_id')
            ->join('families', 'families.id', '=', 'species.family_id')
            ->distinct()
            ->get();

        $species_families = [];

        for ($i = 0; $i < count($families_list); $i++) {
            $data = [];
            $species_families[$i]['name'] = $families_list[$i]->name;
            $species_families[$i]['id'] = $families_list[$i]->name;
            $id = $families_list[$i]->id;

            $species_counter = Tree::select('species.name', DB::raw('count(*) as  cant'))
                ->join('species', 'species.id', '=', 'trees.specie_id')
                ->where('species.family_id', '=', $id)
                ->groupBy('species.name')
                ->get();

            foreach ($species_counter as $specie) {
                array_push($data, array($specie->name, $specie->cant));
            }

            $species_families[$i]['data'] = $data;
        }

        $species = Tree::select(
            'species.name as name',
            DB::raw('count(*) as y')
        )
            ->join('species', 'species.id', '=', 'trees.specie_id')
            ->groupBy('species.name')->get();

        $zones = Tree::select(
            'zones.name as name',
            DB::raw('count(*) as y')
        )
            ->join('home_trees', 'home_trees.tree_id', '=', 'trees.id')
            ->join('home', 'home.id', '=', 'home_trees.home_id')
            ->join('zones', 'zones.id', '=', 'home.zone_id')
            ->groupBy('zones.name')->get();

        return View('admin.graphs.index', compact('families', 'species_families', 'species', 'zones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
