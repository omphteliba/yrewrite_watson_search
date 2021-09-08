<?php
if (rex_addon::get('watson')->isAvailable()) {
    if (!function_exists('register_yrewritesearch')) {
        function register_yrewritesearch(\rex_extension_point $ep)
        {
            $subject = $ep->getSubject();
            $subject[] = 'Watson\Workflows\YrewriteSearch\YrewriteProvider';

            return $subject;
        }
    }

    \rex_extension::register('WATSON_PROVIDER', 'register_yrewritesearch', rex_extension::LATE);

}

