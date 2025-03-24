<?php

namespace App\Services;

use PHPUnit\Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageFormat
{
    private $params;

    private $slugger;

    /**
     * @param $params
     */
    public function __construct( ParameterBagInterface $params , SluggerInterface $slugger)
    {
        $this->params = $params;
        $this->slugger = $slugger;
    }

    /**
     * @param UploadedFile $img
     * @param string|null $repertoire
     * @param int|null $width
     * @param int|null $height
     * @return string nom du fichier
     * @throws \Exception
     */
    public function add(UploadedFile $img , ?string $repertoire = '' , ?int $width = 300 , ?int $height = 300 ):string
    {

        // récupere les infos de l'image
        $fichierInfos = getimagesize($img);

        if(!$fichierInfos){
            throw new \Exception('image non Valide !!!');
        }

        // recupere le format de img
        switch ($fichierInfos['mime'])
        {
            case 'image/jpeg':
                $imgSource = imagecreatefromjpeg($img);
                break;
            case'image/png':
                $imgSource = imagecreatefrompng($img);
                break;
            case 'image/webp':
                $imgSource = imagecreatefromwebp($img);
                break;
            default :
                throw new \Exception('creation image ressource non réussit !!!');
        }
        // ==============    redimention img =============

        $imgWidth = $fichierInfos[0];
        $imgHeight = $fichierInfos[1];

        /**
         * @link https://www.php.net/manual/fr/language.operators.comparison.php
         * @descript  1 <=> 1; return 0
                      1 <=> 2; return -1
                      2 <=> 1; return 1
         */
        // spread comparaison
        switch($imgWidth <=> $imgHeight)
        {
            case 0 : // carre
                $squareSize = 0;
                $srcX = 0;
                $srcY = 0;
                break;

            case 1 : // paysage
                $squareSize = $imgHeight;
                $srcY = 0;
                $srcX = ($imgWidth - $squareSize) /2;
                break;

            case -1: // portrait
                $squareSize = $imgWidth;
                $srcX = 0;
                $srcY = ($imgHeight -$squareSize)/2;
                break;

            default: throw new \Exception('erreur sur la comparaison !!!');

        }
        // image viérge  de la taille prédefini
        $imgResized = imagecreatetruecolor($width ,$height);

        // dessin l'img appartire du calque
        imagecopyresampled($imgResized,$imgSource ,0,0,$srcX,$srcY,$width,$height,$squareSize,$squareSize);

        // ========= destination de l'image ===========

        // defini le chemin du dossier
        $pathImg = $this->params->get('imageCar_directory').$repertoire;


        if(!file_exists($pathImg.'/mini/'))
        {
            // création du dossier
            mkdir($pathImg.'/mini/',0755,false);
        }
        // cree un nom de fichier unique pour l'image
        //$fichier = md5(uniqid(rand(),true)).'.webp';

        $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $this->slugger->slug($originalFilename);
        $fichier = $safeFilename.'_'.uniqid().'.webp';

        // enregistre l'img donne les dossier
        imagewebp($imgResized,$pathImg.'/mini/'.$width.'X'.$height.'_'.$fichier);

        // deplace l'image originale dans le dossier aussi
        $img->move($pathImg.'/', $fichier);

        return $fichier ;

    }
    public function delect(string $name ,?string $repertoire = '' , ?int $width = 300 , ?int $height = 300 ):bool
    {
        $sucess = false;

        $path = $this->params->get('imageCar_directory').$repertoire;

        $pathMini = $path.'/mini/'.$width.'X'.$height.'_'.$name;

        if(file_exists($pathMini))
        {
            // suprime le fichier
            unlink($pathMini);
        }

        $fichierImg = $path.'/'.$name;
        if(file_exists($fichierImg))
        {
            unlink($fichierImg);
            $sucess = true;
        }

        return $sucess;
    }


}