<?php

namespace Watson\Workflows\YrewriteSearch;


use Watson\Foundation\SupportProvider;
use Watson\Foundation\Workflow;

class YrewriteProvider extends SupportProvider
{
    /**
     * Register the directory to search a translation file.
     *
     * @return string
     */
    public function i18n()
    {
        return __DIR__;
    }

    /**
     * Register the service provider.
     *
     * @return Workflow|array
     */
    public function register()
    {
        if (\rex_addon::get('yrewrite')->isAvailable()) {
            return $this->registerStoreSearch();
        }
        return [];

    }

    /**
     * Register yform search.
     *
     * @return Workflow
     */
    public function registerStoreSearch()
    {
        return new YrewriteSearch();
    }
}
