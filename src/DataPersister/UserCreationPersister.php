<?php declare(strict_types=1);

namespace Gesco\DataPersister;

use Gesco\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserCreationPersister implements DataPersisterInterface
{

    private EntityManagerInterface $em;

    private UserPasswordEncoderInterface $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @param mixed $data
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * Persists the data.
     * @param mixed $data
     *
     * @return object|void Void will not be supported in API Platform 3, an object should always be returned
     */
    public function persist($data)
    {
        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->encoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }

        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * @param mixed $data
     */
    public function remove($data): Void
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}