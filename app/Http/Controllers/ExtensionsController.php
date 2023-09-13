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

        $validate_fields = [
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
        ];

        if( $extension->type == 'plugin' ) {

            $validate_fields['banner_low']  = 'image|mimes:jpg,png|max:2048|dimensions:min_width=772,min_height=250,max_width=772,max_height=250';
            $validate_fields['banner_high'] = 'image|mimes:jpg,png|max:2048|dimensions:min_width=1544,min_height=500,max_width=1544,max_height=500';
            $validate_fields['icon']        = 'image|mimes:jpg,png|max:2048|dimensions:min_width=128,min_height=128,max_width=256,max_height=256';

        }

        if( $extension->type == 'theme' ) {

            $validate_fields['screenshot'] = 'image|mimes:jpg,png|max:2048|dimensions:min_width=1200,min_height=900,max_width=1200,max_height=900';

        }
        
        $validated = $request->validate( $validate_fields );

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
            ],
            'banners' => [
                'low'  => isset( $extension->manifest['banners']['low'] ) ? $extension->manifest['banners']['low'] : '',
                'high' => isset( $extension->manifest['banners']['high'] ) ? $extension->manifest['banners']['high'] : ''
            ],
            'icons'   => [
                'default' => isset( $extension->manifest['icons']['default'] ) ? $extension->manifest['icons']['default'] : ''
            ]
        ];

        if( $extension->type == 'plugin' ) {

            $extension_url = url('/') . '/extensions-uploads/' . $extension->slug . '/';

            if( $request->banner_low ) {
                $manifest['banners']['low'] = $this->uploadExtensionImage( $extension, $request->banner_low, 'banner-772x250' ) ? $extension_url . 'banner-772x250.' . $request->banner_low->getClientOriginalExtension() : '';
            }

            if( $request->banner_high ) {
                $manifest['banners']['high'] = $this->uploadExtensionImage( $extension, $request->banner_high, 'banner-1544x500' ) ? $extension_url . 'banner-1544x500.' . $request->banner_high->getClientOriginalExtension() : '';
            }

            if( $request->icon ) {
                $manifest['icons']['default'] = $this->uploadExtensionImage( $extension, $request->icon, 'icon-128x128' ) ? $extension_url . 'icon-128x128.' . $request->icon->getClientOriginalExtension() : '';
            }

        }

        if( $extension->type == 'theme' && $request->screenshot ) {

            $manifest['screenshot_url'] = $this->uploadExtensionImage( $extension, $request->screenshot, 'screenshot-1200x900' ) ? $extension_url . 'screenshot-1200x900.' . $request->screenshot->getClientOriginalExtension() : '';

        }

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

        if( $extension && $extension->manifest && File::exists( public_path( 'extensions-uploads/' . $extension->slug ) . '/' . $extension->slug . '.zip') ) {
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

        $file->move( $destinationPath, $extension->slug . '.zip' );

        return redirect()->back()->with( 'message-success', 'Extension file saved!' );

    }

    function uploadExtensionImage( Extension $extension, $file, $file_type ) {

        $destinationPath = public_path( 'extensions-uploads/' . $extension->slug );

        $upload = $file->move( $destinationPath, $file_type . '.' . $file->getClientOriginalExtension() );
        
        return $upload ? $file->getClientOriginalName() : null;

    }

}
