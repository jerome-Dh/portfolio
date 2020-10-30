<?php

// ================================================================================
//
//      Custums functions
//
//      @author Jerome Dh <jdieuhou@gmail.com>
//      @date 25/03/2020 15:45
//
// ================================================================================

if( ! function_exists('currency')) {

    /**
     * Get the Currency
     *
     * @param bool $format
     * @return string
     */
    function currency($format = true) {
        return $format ? '<span class="currency">XAF</span>' : 'XAF';
    }
}


if( ! function_exists('formatDisplayName')) {
    /**
     * Get display name from an attribute
     * <p>Example: If the name is "first_name", then the display name must be "First Name"</p>
     *
     * @param string $name
     * @return string
     */
    function formatDisplayName(string $name) {
        $ret = '';
        $tabWords = explode('_', $name);
        foreach ($tabWords as $word) {
            $ret .= $word. ' ';
        }

        return trim($ret);
    }
}


if( ! function_exists('displayFullDate')) {
    /**
     * Get display full date
     * <p>Example: If the date is "2020-04-01 00:00:00", then the display date must be "01 avril 2020"</p>
     *
     * @param string $date
     * @return string
     */
    function displayFullDate(string $date) {

		if(preg_match('/^[0-9]{4}(-[0-9]{2}){2}/i', $date)) {
            try {
                return (new Carbon\Carbon($date))->isoFormat('DD MMMM YYYY');
            } catch (Exception $e) {
            }
        }

        return $date;
    }
}

if( ! function_exists('is_active_link')) {

    /**
     * Check if the given uri is active
     *
     * @param $uri
     * @return bool
     */
    function is_active_link($uri)
    {
        $active_uri = request()->getRequestUri();
        if($uri == '/')
        {
            $locale = app()->getLocale();
            return $active_uri == '/public/'.$locale or $active_uri == '/public/' or $active_uri == '/public/'.$locale.'/';
        }
        else
        {
            return strstr($active_uri, $uri) ? true : false;
        }

    }
}

if( ! function_exists('show'))
{
    /**
     * Return the text corresponding of locale
     *
     * @param $text_en
     * @param $text_fr
     * @return mixed
     */
    function show($text_en, $text_fr)
    {
        return app()->getLocale() == 'fr' ? $text_fr : $text_en;
    }
}
