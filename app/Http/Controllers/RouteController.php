<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Route;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $routes = $request->user()->routes()->latest()->paginate(6);

        return view('home', compact('routes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexTrashed(Request $request)
    {
        $routes = $request->user()->routes()->onlyTrashed()->latest()->paginate(6);

        return view('trash', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('routes/create', [
            'items' => '[{"id":"13b62580-9c7b-467c-98b4-eb974418090e","url":"/","type":"route","subType":"closure","content":"return view(\'welcome\');","name":"","get":true,"post":false,"patch":false,"put":false,"delete":false,"options":false,"where":"","middlewares":"","parameters":""},{"id":"448dc1e5-283e-4f93-bbaa-6ed0853f0308","type":"auth","verify":false}]'           ,
            'name' => 'name',
            'id' => -1,
            'auth' => auth()->check(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:routes'
            ]
        ]);

        $route = new Route ([
            'name' => $request->name,
            'route' => $request->route
        ]);

        $request->user()->routes()->save($route);
    }

    /**
     * Copy the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request, Route $route)
    {
        $this->authorize('manage', $route);

        $copy = new Route ([
            'name' => str_random(12),
            'route' => $route->route
        ]);

        $request->user()->routes()->save($copy);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        $this->authorize('manage', $route);

        return view('routes/create', [
            'items' => $route->route,
            'name' => $route->name,
            'id' => $route->id,
            'auth' => auth()->check(),
        ]);
    }

    /**
     * Restore a route.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Route::onlyTrashed()->findOrFail($id)->restore();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        $this->authorize('manage', $route);

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('routes')->ignore($route->id),
            ]
        ]);

        $route->name = $request->name;
        $route->route = $request->route;
        $route->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Route::onlyTrashed()->findOrFail($id)->forceDelete();
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  \App\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Route $route)
    {
        $this->authorize('manage', $route);

        $route->delete();
    }
}
