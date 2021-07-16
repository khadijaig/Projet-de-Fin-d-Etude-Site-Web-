<?php
namespace App\Entity;

class projetChercher {

    /**
     * @var boolean|null
     */
    private $realisation;

    /**
     * @return bool|null
     */
    public function getRealisation()
    {
        return $this->realisation;
    }

    /**
     * @param bool|null $realisation
     * @return projetChercher
     */
    public function setRealisation($realisation)
    {
        $this->realisation = $realisation;
        return $this;
    }

    /**
     * @return bool|null
     */




}

