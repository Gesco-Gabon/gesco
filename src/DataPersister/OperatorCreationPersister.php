<?php declare(strict_types=1);

namespace Gesco\DataPersister;

use Gesco\Entity\Operator;
use Gesco\Helper\NationalitiesHelper;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class OperatorCreationPersister implements DataPersisterInterface
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param mixed $data
     */
    public function supports($data): bool
    {
        return $data instanceof Operator;
    }

    /**
     * Persists the data.
     * @param mixed $data
     *
     * @return object|void Void will not be supported in API Platform 3, an object should always be returned
     */
    public function persist($data)
    {
        if ($data->getPlainBirthDate()) {
            $data->setBirthDate(
                new \DateTime($data->getPlainBirthDate())
            );
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