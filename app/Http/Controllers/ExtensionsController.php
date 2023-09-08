<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Models\Extension;
use App\Models\Site;
use App\Models\SiteRequest;

class ExtensionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('extensions.list')
            ->with('items', Extension::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('extensions.create_edit')
            ->with('item', new Extension);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:extensions|max:255'
        ]);

        $extension = new Extension;
        $extension->name = $request->name;
        $extension->slug = $request->slug;
        $extension->type = $request->type;
        $extension->description = $request->description;

        if( ! $extension->save() ) {
            return redirect()->back()->withErrors(['msg' => 'There was an error adding the extension. Please try again.']);
        } else {
            return redirect( route('extensions.list') );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Extension $extension)
    {

        // $extension = Extension::where('id', $id)->first();

        return view('extensions.create_edit')
            ->with('item', $extension);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $validated = $request->validate([
            'name' => 'required|unique:extensions,name,' . $id . '|max:255'
        ]);
        
        $extension = Extension::where('id', $id)->first();

        $extension->name = $request->name;
        $extension->slug = $request->slug;
        $extension->type = $request->type;
        $extension->description = $request->description;

        if( ! $extension->save() ) {
            return redirect()->back()->withErrors(['msg' => 'There was an error editing the extension. Please try again.']);
        } else {
            // return redirect( route('extensions.list') );
            return redirect()->back()->with( 'message-success', 'Saved!' );
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $extension = Extension::where('id', $id)->first();

        $extension->delete();

        return redirect()->route('extensions.list')->with( 'message-success', 'Deleted!' );

    }

    public function showManifest( Extension $extension ) {

        return view('extensions.create_edit_manifest')
            ->with('item', $extension)
            ->with('manifest', $extension->manifest);
        
    }

    public function saveManifest( Request $request, Extension $extension ) {

        $validated = $request->validate([
            'name'           => 'required',
            'slug'           => 'required',
            'author'         => 'required',
            'author_profile' => 'required',
            'version'        => 'required',
            'download_url'   => 'required',
            'requires'       => 'required',
            'tested'         => 'required',
            'requires_php'   => 'required',
            'last_updated'   => 'required',
            'description'    => 'required',
            'installation'   => 'required',
            'changelog'      => 'required'
        ]);

        $manifest = [
            'name'           => $request->name,
            'slug'           => $request->slug,
            'author'         => $request->author,
            'author_profile' => $request->author_profile,
            'version'        => $request->version,
            'download_url'   => $request->download_url,
            'requires'       => $request->requires,
            'tested'         => $request->tested,
            'requires_php'   => $request->requires_php,
            'last_updated'   => $request->last_updated,
            'sections' => [
                'description'  => $request->description,
                'installation' => $request->installation,
                'changelog'    => $request->changelog,
            ]
        ];

        $extension->manifest = $manifest;

        if( ! $extension->save() ) {
            return redirect()->back()->withErrors(['msg' => 'There was an error saving the extension\'s manifest. Please try again.']);
        } else {
            return redirect()->back()->with( 'message-success', 'Saved manifest!' );
        }

    }

    public function publicExtensionData( Request $request ) {

        $host_full = $request->userAgent();
        $host      = explode('; ', $host_full);
        $host      = $host[1];

        $site_id  = 0;
        $get_site = Site::where('host', $host)->first();
        if( ! $get_site ) {

            $site = new Site;
            $site->host = $host;
            $site->host_full = $host_full;

            $site->save();

            $site_id = $site->id;

        } else {

            $site_id = $get_site->id;

        }

        $extension = Extension::where( 'slug', $request->slug )->first();

        if( $extension ) {
            
            $site_request = new SiteRequest;

            $site_request->site_id = $site_id;
            $site_request->extension_id = $extension->id;

            $site_request->save();

        }

        if( $extension && $extension->manifest ) {
            return json_encode( $extension->manifest );
        }

    }

    function uploadExtensionFileForm( Extension $extension ) {

        $destinationPath = public_path( 'extensions-uploads/' . $extension->slug );
        
        return view('extensions.upload_extension_file')
            ->with('item', $extension)
            ->with('file', File::exists( $destinationPath . '/' . $extension->slug . '.zip') ? URL::to('/') . '/extensions-uploads/' . $extension->slug . '/' . $extension->slug . '.zip' : '' );

    }

    function uploadExtensionFile( Extension $extension, Request $request ) {

        $validated = $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file;

        $errors = [];

        if( $file->getClientOriginalExtension() != 'zip' ) {
            $errors['extension'] = 'The extension file type needs to be ZIP. Any other file type is not permitted';
        }

        if( $errors ) {
            return redirect()->back()->withErrors( $errors );
        }

        $destinationPath = public_path( 'extensions-uploads/' . $extension->slug );
        
        if( File::exists( $destinationPath . '/' . $extension->slug . '.zip') ) {
            
            $manifest = $extension->manifest;

            File::move( $destinationPath . '/' . $extension->slug . '.zip', $destinationPath . '/' . $extension->slug . '-' . $manifest['version'] . '-' . date('Y-m-d-H-i-s') . ' .zip');

        }

        $file->move( $destinationPath,'woocommerce-byjuno.zip' );

        return redirect()->back()->with( 'message-success', 'Extension file saved!' );

    }

}
