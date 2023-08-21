<?php

namespace App\Entity;

class ImageCar
{
    private $id;
    private $voiture_occassion_id;
    private $path_image;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ImageCar
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVoitureOccassionId()
    {
        return $this->voiture_occassion_id;
    }

    /**
     * @param mixed $voiture_occassion_id
     * @return ImageCar
     */
    public function setVoitureOccassionId($voiture_occassion_id)
    {
        $this->voiture_occassion_id = $voiture_occassion_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPathImage()
    {
        return $this->path_image;
    }

    /**
     * @param mixed $path_image
     * @return ImageCar
     */
    public function setPathImage($path_image)
    {
        $this->path_image = $path_image;
        return $this;
    }


}