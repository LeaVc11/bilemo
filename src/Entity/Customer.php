<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;


#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[UniqueEntity('email')]
#[UniqueEntity('name', message: 'Ce nom existe déjà')]
/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "detail_customer",
 *          parameters = { "id" = "expr(object.getId())" }
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getCustomers")
 * )
 *
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "deleteCustomer",
 *          parameters = { "id" = "expr(object.getId())" },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getCustomers", excludeIf = "expr(not is_granted('ROLE_ADMIN'))"),
 * )
 *
 * * @Hateoas\Relation(
 *      "update",
 *      href = @Hateoas\Route(
 *          "updateCustomer",
 *          parameters = { "id" = "expr(object.getId())" },
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups="getCustomers", excludeIf = "expr(not is_granted('ROLE_ADMIN'))"),
 * )
 */
class Customer
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCustomers", "getUsers"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getCustomers", "getUsers"])]
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le nom doit faire au moins {{ limit }} caractère",
        maxMessage: "Le nom ne peut pas faire plus de {{ limit }} caractères")]
    private ?string $name = null;


    #[ORM\Column(length: 255)]
    #[Groups(["getCustomers", "getUsers"])]
    #[Assert\NotBlank(message: "Email est obligatoire.")]
    #[Assert\Email(message: "Votre email doit être valide.")]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'customer')]
    #[Groups(["getCustomers", "getUsers"])]

    private ?User $user = null;


    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }
}
