<?php namespace Anomaly\UsersModule\User\Permission;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Illuminate\Routing\Redirector;

/**
 * Class PermissionFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UsersModule\User\Permission
 */
class PermissionFormHandler
{

    /**
     * Handle the form.
     *
     * @param PermissionFormBuilder   $builder
     * @param UserRepositoryInterface $users
     * @param Redirector              $redirect
     */
    public function handle(PermissionFormBuilder $builder, UserRepositoryInterface $users, Redirector $redirect)
    {
        /* @var UserInterface|EloquentModel $user */
        $user = $builder->getEntry();

        $users->save($user->setAttribute('permissions', array_filter(array_flatten($builder->getFormInput()))));

        $builder->setFormResponse($redirect->refresh());
    }
}
