<?php
function smarty_block_mtputcontents ( $args, $content, &$ctx, &$repeat ) {
    if (! isset( $content ) ) {
    } else {
        $repeat = FALSE;
        $no_output = $args[ 'no_output' ];
        global $mt;
        if (! $mt->config( 'allowputcontents' ) ) {
            if (! $no_output ) {
                return $contents;
            }
        }
        $file = $args[ 'file' ];
        if ( preg_match( '/\.\./', $file ) ) {
            return '';
        }
        $sep = DIRECTORY_SEPARATOR;
        if ( $sep != '/' ) {
            $file = str_replace( '/', $sep, $file );
        }
        $absolute = $args[ 'absolute' ];
        if ( $absolute && (! $mt->config( 'allowputcontentsabsolute' ) ) ) {
            if (! $no_output ) {
                return $contents;
            }
        }
        if (! $absolute ) {
            $blog = $ctx->stash( 'blog' );
            $site_path = $blog->site_path();
            if (! preg_match( '/\/$/', $site_path ) ) {
                if (! preg_match( '/^\//', $file ) ) {
                    $site_path .= '/';
                }
            }
            $file = $site_path . $file;
        }
        file_put_contents( $file, $content );
        if (! $no_output ) {
            return $content;
        }
    }
}
?>