<?php
/**
 * User voter.
 */

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Class UserVoter.
 */
class UserVoter extends Voter
{
    /**
     * Constructor.
     *
     * @param Security $security Security
     */
    public function __construct(private Security $security)
    {
    }

    /**
     * Edit permission.
     *
     * @const string
     */
    private const EDIT = 'EDIT';

    /**
     * Delete permission.
     *
     * @const string
     */
    private const DELETE = 'DELETE';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool Result
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof User;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute Permission name
     * @param mixed          $subject   Object
     * @param TokenInterface $token     Security token
     *
     * @return bool Vote result
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $watcher = $token->getUser();
        if (!$watcher instanceof UserInterface) {
            return false;
        }
        if (!$subject instanceof User) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($subject, $watcher),
            self::DELETE => $this->canDelete($subject, $watcher),
            default => false,
        };
    }

    /**
     * Checks if user can edit.
     *
     * @param User          $user  User entity
     * @param UserInterface $watch User
     *
     * @return bool Result
     */
    private function canEdit(User $user, UserInterface $watch): bool
    {
        return $user->getEmail() === $watch;
    }

    /**
     * Checks if user can delete.
     *
     * @param User          $user  User entity
     * @param UserInterface $watch User
     *
     * @return bool Result
     */
    private function canDelete(User $user, UserInterface $watch): bool
    {
        return $user->getEmail() === $watch;
    }
}
