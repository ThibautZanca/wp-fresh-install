<?php

namespace App\Providers;

use Rareloop\Lumberjack\Providers\ServiceProvider;
use Rareloop\Lumberjack\QueryBuilder;

class QueryBuilderProvider extends ServiceProvider
{
    /**
     * Perform any additional boot required for this application
     */
    public function boot()
    {
        // Allows to add taxonomies arrays to query
        QueryBuilder::macro('whereTaxonomies', function ($query) {
            $this->params['tax_query'] = $query;
            return $this;
        });

        // Allows to search for a specific string
        QueryBuilder::macro('search', function ($term) {
            $this->params['s'] = $term;
            return $this;
        });
    }
}
