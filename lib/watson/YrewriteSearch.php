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
        return ['forward'];
    }

    /**
     * @return Documentation
     */
    public function documentation()
    {
        $documentation = new Documentation($this->commands());
        $documentation->setDescription(Watson::translate('watson_yrewrite_documentation_description'));
        $documentation->setUsage('forward url');
        $documentation->setExample('forward special');

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
// https://dev.fact-finder.de/redaxo/index.php?page=yrewrite/forward&data_id=1606&func=edit&start=&list=edb9240a
                $url = Watson::getUrl([
                    'page' => 'yrewrite/forward',
                    'data_id' => $item['id'],
                    'func' => 'edit',
                    'start' => '',
                    'list' => 'edb9240a'
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

