<?php

namespace App\Models;

class Card
{
    private $id;
    private $image;
    private $estRetournee;
    private $estTrouvee;

    public function __construct($id, $image)
    {
        $this->id = $id;
        $this->image = $image;
        // Par défaut, la carte est face cachée et non trouvée
        $this->estRetournee = false;
        $this->estTrouvee = false;
    }

    // Getters (Lecture)
    public function getId()
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getEstRetournee()
    {
        return $this->estRetournee;
    }

    public function getEstTrouvee()
    {
        return $this->estTrouvee;
    }

    // Setters (Modification)
    public function setEstRetournee($valeur)
    {
        $this->estRetournee = $valeur;
    }

    public function setEstTrouvee($valeur)
    {
        $this->estTrouvee = $valeur;
    }
}
