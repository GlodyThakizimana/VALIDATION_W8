<?php
class Archer extends Character
{
    // équivalent à $arrowPoints == 0 
    protected $arrowPoints = 5;
    protected $nbTourAttendu = 0;
    protected $currentAttack = "";


    public function __construct($name) {
        $this->name = $name;
    }


    public function turn($target) {
         // si il a une attaque en cours 
        // faire l'attaque en cours et currentAttack = ""
        /* $status = l'attaque en count_chars
        current attack = ""
        return $status */

        // Sinon choisir aléatoirement entre tirer une flèche, ou viser un point critique ou tirer deux flèches
        return $this->throwArrow($target);
    }
    
    private function attack($target, $damage = 0, $weapon = "Fleche") {
        $target->setHealthPoints($damage);
        $status = "$this->name donne un coup de $weapon  à $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        return $status;
    }

    public function isCarquoisEmpty() : bool
    {
        return $this->arrowPoints <= 0;
    }

    // on a besoin de savoir s'il est en train de faire une attaque

    // tirer une flèche
    public function throwArrow($target) 
    {
        // si le carquois est vide on attaque avec la dague
        if ($this->isCarquoisEmpty()) {
            return $this->attackWithDague($target);
        }
        
        // sinon on tire une flèche
        $this->arrowPoints -= 1;
        return $this->attack($target, $this->damage, "une flèche");

    }

    public function throwTwoArrows($target)
    {
        // il faut qu'il y ait suffisamment de flèche
        if ($this->arrowPoints < 2) {
            // on n'a pas assez de flèche
            return $this->attackWithDague($target);
        }

        // on a assez de flèches
        if($this->nbTourAttendu < 1){
            // on doit attendre un tour
            $this->nbTourAttendu +=1;
            // l'attaque en cours devient attaquer avec deux flèches
            $this->currentAttack = "throwTwoArrows";
            return "$this->name attend avant de tirer ses deux flèches";
        }

        // on peut tirer deux flèches
        $this->arrowPoints -= 2;
        return $this->throwArrow($target) + $this->throwArrow($target); // concatène les deux status de chaque attaque
    }

    // viser un point faible
    // il faut savoir s'il a attendu, et si il était en train de viser un point critique
    public function shootAtCriticalPoint($target)
    {
        // il faut qu'il y ait suffisamment de flèche
        if ($this->arrowPoints < 1) {
            // on n'a pas assez de flèche
            return $this->attackWithDague($target);
        }

        // on a assez de flèches
        if ($this->nbTourAttendu < 1) {
            // on doit attendre un tour
            $this->nbTourAttendu += 1;
            // l'attaque en cours devient attaquer avec deux flèches
            $this->currentAttack = "shootAtCriticalPoint";
            return "$this->name attend avant de tirer un coup critique";
        }

        // on peut tirer deux flèches
        $this->arrowPoints -= 1;
        $combo = rand(15, 30) / 10;
        return $this->attack($target, $damage = $this->damage * $combo, "flèche critique");
    }

    // attaquer avec la dague
    public function attackWithDague($target)
    {
        return $this->attack($target, $damage = $this->damage * 0.80, "dague");
    }

}
  


