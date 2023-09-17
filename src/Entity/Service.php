<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class Service
{
    private $id;
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 9,
        max: 30,
        minMessage: 'doit avoir plus de  {{ limit }} caracters',
        maxMessage: 'doit avoir moin que {{ limit }} caracters',
    )]
    private string $titre;

    /**
     * @return mixed
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @param mixed $id
     * @return Service
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'doit avoir plus de  {{ limit }} caracters',
        maxMessage: 'doit avoir moin que {{ limit }} caracters',
    )]
    private string $nom_service;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 30,
        minMessage: 'doit avoir plus de  {{ limit }} caracters',
        maxMessage: 'doit avoir moin que {{ limit }} caracters',
    )]
    private string $label_Prix;

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return Service
     */
    public function setTitre(string $titre): Service
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomService(): string
    {
        return $this->nom_service;
    }

    /**
     * @param string $nom_service
     * @return Service
     */
    public function setNomService(string $nom_service): Service
    {
        $this->nom_service = $nom_service;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelPrix(): string
    {
        return $this->label_Prix;
    }

    /**
     * @param string $label_Prix
     * @return Service
     */
    public function setLabelPrix(string $label_Prix): Service
    {
        $this->label_Prix = $label_Prix;
        return $this;
    }
    public function getNewId()
    {
        return $this->id;
    }
}