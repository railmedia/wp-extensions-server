<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\SiteRequest;

class SiteRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $search_sites = SiteRequest::distinct()->get(['site_id']);
        $search_terms = ['' => 'Click to search'];

        foreach( $search_sites as $term ) {
            $search_terms[ $term->site->host ] = $term->site->host;
        }
        
        return view('requests.list')
            ->with('items', SiteRequest::orderBy('created_at', 'desc')->take(20)->get())
            ->with('search_terms', $search_terms)
            ->with('search_data', [ 'site' => '', 'date_from' => '', 'date_to' => '' ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function searchRequest( Request $request ) {

        $where = [];
        
        if( $request->site ) {
            $site = Site::where('host', $request->site)->first();
            if( $site ) {
                $where[] = [ 'site_id', $site->id ];
            }
        }

        if( $request->date_from ) {
            $where[] = [ 'created_at', '>=', $request->date_from ];
        }

        if( $request->date_to ) {
            $where[] = [ 'created_at', '<=', $request->date_to ];
        }

        $search_sites = SiteRequest::distinct()->get(['site_id']);
        $search_terms = ['' => 'Click to search'];

        foreach( $search_sites as $term ) {
            $search_terms[ $term->site->host ] = $term->site->host;
        }

        return view('requests.list')
            ->with('items', SiteRequest::where( $where )->orderBy('created_at', 'desc')->get())
            ->with('search_terms', $search_terms)
            ->with('search_data', [ 'site' => $request->site, 'date_from' => $request->date_from, 'date_to' => $request->date_to ]);

    }

}
