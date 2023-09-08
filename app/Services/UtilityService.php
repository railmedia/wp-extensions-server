<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Extension;

class UtilityService {

    public function generate_unique_value( Request $request, $try = 0 ) {

        switch( $request->type ) {

            case 'extension-slug':

                $string = $request->slug;

                if( ! $string ) {
                    $string = $request->title;
                }

                if( $try > 0 ) {
                    $string .= '-' . strval( $try );
                }

                $slug = strtolower( str_replace( ' ', '-', preg_replace( "/[^A-Za-z0-9- ]/", '', $string ) ) );
                $extension = Extension::where( 'slug', $slug )->first();

                return ! $extension ? $slug : $this->generate_unique_value( $request, ($try + 1) );

            break;

        }

        return $string;

    }

}
?>