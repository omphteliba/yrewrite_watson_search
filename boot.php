<?php
if (rex_addon::get('watson')->isAvailable()) {

    function yrewritesearch(rex_extension_point $ep){
        dd();
        $subject = $ep->getSubject();
        $subject[] = 'Watson\Workflows\YrewriteSearch\YrewriteProvider';
        return $subject;
    }

    rex_extension::register('WATSON_PROVIDER', 'yrewritesearch', rex_extension::LATE);

}
