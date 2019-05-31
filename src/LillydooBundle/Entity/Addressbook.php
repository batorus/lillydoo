<?php

namespace LillydooBundle\Entity;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Addressbook
 *
 * @ORM\Table(name="addressbook")
 * @ORM\Entity(repositoryClass="LillydooBundle\Repository\AddressbookRepository")
 */
class Addressbook
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=55, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lastname", type="string", length=50, nullable=true)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street", type="string", length=50, nullable=true)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phonenumber", type="string", length=50, nullable=true)
     */
    private $phonenumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zipcode", type="string", length=50, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\OneToMany(targetEntity="Documents", mappedBy="addressbook", cascade={"persist"})
     */
    protected $documents;

     /**
     * @var int
     *
     * @ORM\Column(name="enabled", 
      *            type="integer", 
     *             options={"default": 0})
     */
    private $enabled;
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set firstname.
     *
     * @param string|null $firstname
     *
     * @return Addressbook
     */
    public function setFirstname(?string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string|null $lastname
     *
     * @return Addressbook
     */
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string|null
     */
    public function getLastname(): ?string 
    {
        return $this->lastname;
    }

    /**
     * Set street.
     *
     * @param string $street
     *
     * @return Addressbook
     */
    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street.
     *
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set number.
     *
     * @param int|null $number
     *
     * @return Addressbook
     */
    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * Set country.
     *
     * @param string|null $country
     *
     * @return Addressbook
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Set phonenumber.
     *
     * @param string|null $phonenumber
     *
     * @return Addressbook
     */
    public function setPhonenumber(?string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber.
     *
     * @return string|null
     */
    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    /**
     * Set birthday.
     *
     * @param \DateTime $birthday
     *
     * @return Addressbook
     */
    public function setBirthday(?DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday.
     *
     * @return \DateTime
     */
    public function getBirthday(): ?DateTime
    {
        return $this->birthday;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Addressbook
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }



    /**
     * Set enabled.
     *
     * @param int $enabled
     *
     * @return Addressbook
     */
    public function setEnabled(?int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return int
     */
    public function getEnabled(): ?int
    {
        return $this->enabled;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add document.
     *
     * @param \LillydooBundle\Entity\Documents $document
     *
     * @return Addressbook
     */
    public function addDocument(\LillydooBundle\Entity\Documents $document): self
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document.
     *
     * @param \LillydooBundle\Entity\Documents $document
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDocument(\LillydooBundle\Entity\Documents $document): bool
    {
        return $this->documents->removeElement($document);
    }

    /**
     * Get documents.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    /**
     * Set zipcode.
     *
     * @param string|null $zipcode
     *
     * @return Addressbook
     */
    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode.
     *
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }
}
