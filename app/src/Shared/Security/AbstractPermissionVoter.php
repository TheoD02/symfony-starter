<?php

declare(strict_types=1);

namespace App\Shared\Security;

use App\Shared\Trait\PermissionTrait;
use App\Shared\Trait\SecurityTrait;
use App\User\Domain\Model\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * @template TAttribute of string
 * @template TSubject of mixed
 *
 * @template-extends Voter<TAttribute, TSubject>
 */
abstract class AbstractPermissionVoter extends Voter
{
    use SecurityTrait;

    #[\Override]
    public function supportsType(string $subjectType): bool
    {
        return is_a($subjectType, $this->getSubjectClass(), true) || \in_array(
            $subjectType,
            $this->getAdditionalAuthorizedSubjects(),
            true,
        );
    }

    /**
     * @return class-string<TSubject>
     */
    abstract public function getSubjectClass(): string;

    /**
     * @return list<class-string>
     */
    public function getAdditionalAuthorizedSubjects(): array
    {
        return [];
    }

    #[\Override]
    public function supportsAttribute(string $attribute): bool
    {
        return \in_array($attribute, $this->getPermissionValues(), true);
    }

    /**
     * @return list<string>
     */
    protected function getPermissionValues(): array
    {
        $class = $this->getPermissionsEnum();

        /** @var list<string> */
        return $class::values();
    }

    /**
     * @return class-string
     */
    abstract public function getPermissionsEnum(): string;

    public function hasPermission(string|\BackedEnum $permission): bool
    {
        $value = $permission instanceof \BackedEnum ? $permission->value : $permission;

        return \in_array($value, $this->security->getUser()?->getRoles() ?? [], true);
    }

    /**
     * @param list<string|\BackedEnum> $permissions
     */
    public function hasPermissions(array $permissions): bool
    {
        $values = array_map(
            static fn (string|\BackedEnum $permission): int|string => $permission instanceof \BackedEnum ? $permission->value : $permission,
            $permissions,
        );

        return \in_array($values, $this->security->getUser()?->getRoles() ?? [], true);
    }

    public function isSelfUser(mixed $subject): bool
    {
        if (! $subject instanceof User) {
            return false;
        }

        return $subject->getUserIdentifier() === $this->security->getUser()?->getUserIdentifier();
    }

    #[\Override]
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        // TODO: This should be only run in dev mode
        foreach ($this->getPermissionsCases() as $backedEnum) {
            if (! method_exists($backedEnum, 'getMethodName')) {
                throw new \LogicException(\sprintf(
                    'Please add use of "%s" trait to "%s"',
                    PermissionTrait::class,
                    $backedEnum::class,
                ));
            }

            /** @var string $methodName */
            $methodName = $backedEnum->getMethodName();
            if (! method_exists(static::class, $methodName)) {
                throw new \LogicException(\sprintf(
                    'Please implement the "%s" method in "%s"',
                    $methodName,
                    static::class,
                ));
            }
        }

        if ($this->bypass($attribute, $subject, $token)) {
            return true;
        }

        /** @phpstan-ignore-next-line method.nonObject (Already checked in foreach on top) */
        $methodName = $this->getPermissionsEnum()::from($attribute)->getMethodName();

        /** @var bool */
        return $this->{$methodName}($attribute, $subject, $token);
    }

    /**
     * @return list<\BackedEnum>
     */
    public function getPermissionsCases(): array
    {
        $class = $this->getPermissionsEnum();

        /** @var list<\BackedEnum> */
        return $class::cases();
    }

    public function bypass(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        return false;
    }
}
