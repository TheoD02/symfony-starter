<?php

declare(strict_types=1);

namespace App\User\Infrastructure\ApiPlatform\State\Controller;

use App\Shared\Security\GroupPermissions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class UserRolesCollectionController extends AbstractController
{
    public function __invoke(): JsonResponse
    {
        $roles = $this->getGroupedRoles();

        return $this->json([
            '@context' => '/api/contexts/UserRolesCollection',
            '@id' => '/api/users/roles',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => \count($roles),
            'hydra:member' => $this->getGroupedRoles(),
        ]);
    }

    /**
     * @return array<string, list<string>>
     */
    public function getGroupedRoles(): array
    {
        $defaultRoles = ['ROLE_USER', 'ROLE_ADMIN'];

        /** @var array<string, list<string>> $groupedPermissions */
        $groupedPermissions = array_reduce(
            GroupPermissions::cases(),
            static function (array $roles, GroupPermissions $groupPermission): array {
                foreach ($groupPermission->getPermissions() as $permission) {
                    // @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible (How to type callable parameter?)
                    $roles[$groupPermission->value][] = $permission;
                }

                return $roles;
            },
            [],
        );

        return array_merge([
            'role' => $defaultRoles,
        ], $groupedPermissions);
    }

    /**
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];

        foreach (GroupPermissions::cases() as $groupPermission) {
            foreach ($groupPermission->getPermissions() as $permission) {
                $roles[] = $permission;
            }
        }

        return $roles;
    }
}
