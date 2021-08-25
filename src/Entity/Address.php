<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: 'Ihr Vorname sollte mindestens {{ limit }} Zeichen enthalten',
        maxMessage: 'Ihr Vorname darf eine Länge von {{ limit }} Zeichen nicht überschreiten',
    )]
    private $vorname;

    /**
     * @ORM\Column(type="string", length=40)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 40,
        minMessage: 'Ihr Nachname sollte mindestens {{ limit }} Zeichen enthalten',
        maxMessage: 'Ihr Nachname darf eine Länge von {{ limit }} Zeichen nicht überschreiten',
    )]
    private $nachname;

    /**
     * @ORM\Column(type="smallint")
     */
    private $anrede;

    /**
     * @ORM\Column(type="string", length=150)
     */
    #[Assert\Length(
        min: 3,
        minMessage: 'Ihr Straßename sollte mindestens {{ limit }} Zeichen enthalten',
    )]
    #[Assert\Regex(
       pattern: '/^([A-ZÄÖÜa-zäöüß]{2,}\.?[ -]?)+$/',
       message: 'Ihr Straßename ist ungültig',     
    )]
    private $strasse;

    /**
     * @ORM\Column(type="string", length=10)
     */
    #[Assert\Regex(
        pattern: '/^[0-9]{5}$/',
        message: 'Ihr Plz muss 5 Zeichen enthalten',
    )]
    private $plz;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $ort;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    #[Assert\LessThanOrEqual('-18 years',
            message: 'Ihr Geburtsdatum ist ungültig.')]
    private $geburtsdatum;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    #[Assert\Regex(
       pattern: '/^(\+)?[0-9 ]{10,}$/',
       message: 'Ihr Telefonnummer ist ungültig',     
    )]
    private $telefon;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    #[Assert\Email(
        message: 'Die E-mail-Adresse {{ value }} ist nicht gültig.',
    )]
    private $email;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $hausnummer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): self
    {
        $this->vorname = ucfirst($vorname);

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): self
    {
        $this->nachname = ucfirst($nachname);

        return $this;
    }

    public function getAnrede(): ?int
    {
        return $this->anrede;
    }

    public function setAnrede(int $anrede): self
    {
        $this->anrede = $anrede;

        return $this;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): self
    {
        $this->strasse = ucwords($strasse);

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): self
    {
        $this->ort = ucfirst($ort);

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getTelefon(): ?string
    {
        return $this->telefon;
    }

    public function setTelefon(?string $telefon): self
    {
        $this->telefon = preg_replace('/\s+/', '', $telefon);//delete whitespace 

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHausnummer(): ?string
    {
        return $this->hausnummer;
    }

    public function setHausnummer(string $hausnummer): self
    {
        $this->hausnummer = $hausnummer;

        return $this;
    }
    public static function convertAnrede(int $i): String{
        switch($i){
            case 0: return 'Herr';
            case 1: return 'Frau';
            case 2: return 'Dr.';
            case 3: return 'Prof.';
            default: return 'Anrede ist ungültig';
        }
    }
}
