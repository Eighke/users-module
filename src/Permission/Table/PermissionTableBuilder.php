<?php namespace Anomaly\UsersModule\Permission\Table;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;

/**
 * Class PermissionTableBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule\Permission\Table
 */
class PermissionTableBuilder extends TableBuilder
{

    /**
     * The entries handler.
     *
     * @var string
     */
    protected $entries = 'Anomaly\UsersModule\Permission\Table\Handler\EntriesHandler@handle';

    /**
     * The columns handler.
     *
     * @var string
     */
    protected $columns = 'Anomaly\UsersModule\Permission\Table\Handler\ColumnsHandler@handle';

    /**
     * The actions handler.
     *
     * @var string
     */
    protected $actions = 'Anomaly\UsersModule\Permission\Table\Handler\ActionsHandler@handle';

    /**
     * Create a new PermissionTableBuilder instance.
     *
     * @param Table   $table
     * @param Request $request
     */
    public function __construct(Table $table, Request $request, Asset $asset)
    {
        $this->appendAssets($asset);
        $this->setTableOptions($table, $request);

        parent::__construct($table);
    }

    /**
     *
     * @param Asset $asset
     */
    protected function appendAssets(Asset $asset)
    {
        $asset->add('streams.js', 'module::js/permissions.js', ['live']);
    }

    /**
     * Set table options.
     *
     * @param Table   $table
     * @param Request $request
     * @throws \Exception
     */
    protected function setTableOptions(Table $table, Request $request)
    {
        $role    = $request->segment(4);
        $options = $table->getOptions();

        if ($role == 1) {
            throw new \Exception("Administrator permissions can not be modified.");
        }

        if (!$role) {
            throw new \Exception("The role could not be found with ID [{$role}].");
        }

        $options->put('class', 'table');
        $options->put('role_id', $role);
        $options->put('wrapper_view', 'anomaly.module.users::admin/permissions/wrapper');
    }
}