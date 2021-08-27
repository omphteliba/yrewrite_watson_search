<?php

namespace Watson\Workflows\YrewriteSearch;

use Watson\Foundation\Command;
use Watson\Foundation\Documentation;
use Watson\Foundation\Result;
use Watson\Foundation\ResultEntry;
use Watson\Foundation\Watson;
use Watson\Foundation\Workflow;

class YrewriteSearch extends Workflow
{
    /**
     * Provide the commands of the search.
     *
     * @return array
     */
    public function commands()
    {
        return ['re'];
    }

    /**
     * @return Documentation
     */
    public function documentation()
    {
        $documentation = new Documentation();
        $documentation->setDescription(Watson::translate('watson_rewrite_documentation_description'));
        $documentation->setUsage('re url');
        $documentation->setExample('re special');

        return $documentation;
    }

    /**
     * Return array of registered page params.
     *
     * @return array
     */
    public function registerPageParams()
    {
        return [];
    }

    /**
     * Execute the command for the given Command.
     *
     * @param Command $command
     *
     * @return Result
     */
    public function fire(Command $command)
    {
        dump(1);
        $result = new Result();

        $fields = ['url','extern',];

        $sql_query = '
       SELECT      * 
       FROM       ' . Watson::getTable('yrewrite_forward') . ' 
       WHERE       ' . $command->getSqlWhere($fields) . ' 
       ORDER BY   id DESC';

        $items = $this->getDatabaseResults($sql_query);

        if (count($items)) {
            $counter = 0;

            foreach ($items as $item) {

                $url = Watson::getUrl([
                    'page' => 'yrewrite/forward',
                    'base_path' => 'yrewrite/forward',
                    'id' => $item['id'],
                    'func' => 'edit',
                ]);

                ++$counter;
                $entry = new ResultEntry();
                if ($counter === 1) {
                    $entry->setLegend('Yrewrite');
                }

                if (isset($item['url'])) {
                    $entry->setValue($item['url'] . '', '(' . $item['id'] . ')');
                } else {
                    $entry->setValue($item['id']);
                }

                $entry->setIcon('watson-icon-yform');
                $entry->setUrl($url);
                $entry->setQuickLookUrl($url);

                $result->addEntry($entry);
            }
        }

        return $result;
    }

}

