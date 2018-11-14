<?php

namespace Railken\Amethyst\Http\Controllers\Admin;

use Railken\Amethyst\Api\Http\Controllers\RestManagerController;
use Railken\Amethyst\Api\Http\Controllers\Traits as RestTraits;
use Railken\Amethyst\Managers\EventLogManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Railken\SQ\Exceptions\QuerySyntaxException;

class EventLogsController extends RestManagerController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestCreateTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestRemoveTrait;

    /**
     * The class of the manager.
     *
     * @var string
     */
    public $class = EventLogManager::class;

    /**
     * Stats
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function stats(Request $request)
    {
        $query = $this->getQuery();
        /*$query->leftJoin(
            Config::get('amethyst.event-logger.data.event-log-attribute.table')." as attributes", 
            "attributes.event_log_id", 
            "=", 
            Config::get('amethyst.event-logger.data.event-log.table').".id"
        );*/

        try {
            if ($request->input('query')) {
                $filter = new Filter($this->manager->newEntity()->getTable(), $this->queryable);
                $filter->build($query, $request->input('query'));
            }
        } catch (QuerySyntaxException $e) {
            return $this->error(['code' => 'QUERY_SYNTAX_ERROR', 'message' => 'Syntax error']);
        }


        $query->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"), DB::raw('count(*) as total'));
        $query->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"));

        $result = $query->paginate($request->input('show', 10), ['*'], 'page', $request->input('page'));

        $resources = $result->getCollection();

        return $this->success([
            'data' => $resources->map(function($record) {
                return $record;
            })->toArray()
        ]);
    }
}
