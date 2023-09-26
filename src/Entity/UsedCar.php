<?php

namespace App\Entity;
use App\Entity\OptionUsedCar;
use App\Entity\CaracteristiqueCar;
use Symfony\Component\Validator\Constraints as Assert;
class UsedCar
{
    protected $id ;
    #[Assert\LessThan(999999)]
    protected $prix;
    protected $annee_fabrication;
    #[Assert\LessThan(999999)]
    protected $kilometrage;

    /**
     * @var OptionUsedCar
     */
    protected $option;

    /**
     * @var CaracteristiqueCar
     */
    protected $caracteristique;

    /**
     * @return \App\Entity\CaracteristiqueCar
     */
    public function getCaracteristique(): ?\App\Entity\CaracteristiqueCar
    {
        return $this->caracteristique;
    }

    /**
     * @param \App\Entity\CaracteristiqueCar $caracteristique
     * @return UsedCar
     */
    public function setCaracteristique(bool|\App\Entity\CaracteristiqueCar $caracteristique): UsedCar
    {
        if($caracteristique && is_object($caracteristique)){
            $this->caracteristique = $caracteristique;
        }
        return $this;
    }

    /**
     * @return \App\Entity\OptionUsedCar
     */
    public function getOption(): ?\App\Entity\OptionUsedCar
    {

        return $this->option;
    }

    /**
     * @param \App\Entity\OptionUsedCar $option
     * @return UsedCar
     */
    public function setOption(bool |\App\Entity\OptionUsedCar $option): UsedCar
    {
        if($option && is_object($option)) {
            $this->option = $option;
        }
        return $this;
    }
    protected $lstImage = [];

    /**
     * @return ImageCar[]
     */
    public function getLstImage(): array
    {
        if(empty($this->lstImage)){
            $this->getRandomImage();
        }
        return $this->lstImage;
    }

    /**
     * @param ImageCar $img
     * @return UsedCar
     */
    public function setImage(ImageCar $img): UsedCar
    {
        if(!in_array($img ,$this->lstImage)){
            $this->lstImage[] = $img;
        }
        return $this;
    }
    public function setLstImage(array $img):UsedCar
    {
        if(!empty($img)){
            $this->lstImage = $img;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId():?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UsedCar
     */
    public function setId($id):self
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrix():int
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     * @return UsedCar
     */
    public function setPrix($prix):self
    {
        $this->prix = (int) $prix;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAnneeFabrication():\DateTime
    {
        if(is_object($this->annee_fabrication ))
        {
            return $this->annee_fabrication;
        }else{
            return new \DateTime($this->annee_fabrication);

        }
    }

    /**
     * @param mixed $annee_fabrication
     * @return UsedCar
     */
    public function setAnneeFabrication($annee_fabrication):self
    {
        $this->annee_fabrication = $annee_fabrication;
        return $this;
    }

    /**
     * @return int
     */
    public function getKilometrage():int
    {
        return $this->kilometrage;
    }

    /**
     * @param mixed $kilometrage
     * @return UsedCar
     */
    public function setKilometrage($kilometrage):self
    {
        $this->kilometrage = (int) $kilometrage;
        return $this;
    }
    public function jsonSerialize(){
        return [
            'prix' => $this->getPrix(),
            'anneeFabrication'=> $this->getAnneeFabrication()->format('Y'),
            'kilometrage'=> number_format($this->getKilometrage(), 0,'',' '),
            'pathImage'=>'https://127.0.0.1:8001/image_voiture_occassion/'.$this->getLstImage()[0]->getPathImage()
        ];
    }
    public function getRandomImage()
    {
        $lstDefault = ['default1.jpg','default2.jpg','default3.jpg','default3.jpg','default4.jpg','default5.jpg'];
        $rand = array_rand($lstDefault) ;
        $img = new ImageCar();
        //$img->setPathImage('defaultCar.jpg');
        $img->setPathImage("default/$lstDefault[$rand]");
        $this->setImage($img);
    }


}