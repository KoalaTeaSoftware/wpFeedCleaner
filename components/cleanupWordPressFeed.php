<?php
require_once "util-errorHandler.php";

/**
 * read an XML feed from WordPress and remove little yellow wobbly bits
 * ToDo: It has the new class attributes embedded right in the body, they may need to be a bit more flexible
 *
 * @param $resource
 * - a fully specified resource that will yield WP XML feed
 * - eg https://thegreenlands.home.blog/category/the-bestiary/feed/
 * @return SimpleXMLElement|null - null if it fails to read the file, or fails to interpret it
 * @uses $msg is set, if there is an error
 */
function cleanupWordPressFeed($resource)
{
    $feed = file_get_contents($resource);
    if ($feed == false) {
        $msg = "Failed to find the xml file at " . $feed;
        error_log($msg);
        return null;
    } else {
        // this modifier breaks it all, so remove it
        $data = str_replace("content:encoded>", "content>", $feed);
        // these are the wrong sort of quote
        $data = preg_replace('/&raquo;/', '&apos;', $data);
        // these are scattered around and not desired
        $data = preg_replace('/&nbsp;/', ' ', $data);
        // the feed from the WP can contain this stuff. It could be put there by a plugin.
        $data = preg_replace('/data-image-meta="[^"]+"/', ' ', $data);

        // All figure tags (img, or embed) - clean the class attribute for
        $data = preg_replace('/<figure +class="[^"]+"/', '<figure class="figure" ', $data);

        // Static images (they do not have the sizing information)
        $data = preg_replace('/class="wp-image-\d+"/', 'class="img-fluid img-thumbnail" ', $data);

        // clean up youtube embeds
        $data = preg_replace('/wp-block-embed__wrapper/', 'embed-responsive embed-responsive-16by9 img-thumbnail', $data);
        $data = preg_replace('/youtube-player/', "embed-responsive-item", $data);
        $data = preg_replace("/width='[^']+'/", "", $data);
        $data = preg_replace("/height='[^']+'/", "", $data);
        $data = preg_replace("/style='[^']+'/", "", $data);

        //error_log("this is what was read\n" . $data . "\n-----------------------");
        $xml = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
        if ($xml === false) {
            // this file can't be used, give up
            $msg = "Failed to understand the xml file for the stories chapter at " . $feed;
            foreach (libxml_get_errors() as $error) {
                $msg .= $error->message . "\n";
            }
            error_log($msg);
            return null;
        } else {
            //error_log("Interpreted as " . print_r($xml, true));
            return $xml;
        }
    }
}
