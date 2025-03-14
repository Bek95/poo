<?php


class InvalidValueException extends Exception
{
}

abstract class Personne
{
    protected $nom;
    protected $age;

    public function __construct($nom, $age)
    {
        if ($age < 0) {
            throw new InvalidValueException("L'âge ne peut pas être négatif");
        }
        $this->nom = $nom;
        $this->age = $age;
    }

    public abstract function sePresenter();

}

interface TravailleurInterface
{
    public function travailler();
}

class Employe extends Personne implements TravailleurInterface
{
    private $salaire;

    public function __construct($nom, $age, $salaire)
    {
        if ($salaire < 0) {
            throw new InvalidValueException("Le salaire ne peut pas être négatif");
        }
        parent::__construct($nom, $age);
        $this->salaire = $salaire;
    }

    public function sePresenter()
    {
        echo "Je m'appelle " . $this->nom . " et j'ai " . $this->age . " ans. " . PHP_EOL;
    }

    public function travailler()
    {
        echo "Je travaille pour une entreprise." . PHP_EOL;
    }

    public function getSalaire()
    {
        return $this->salaire;
    }

    public function setSalaire($salaire)
    {
        if ($salaire < 0) {
            throw new InvalidValueException("Le salaire ne peut pas être négatif");
        }
        $this->salaire = $salaire;
    }

    public static function compareSalaire(Employe $e1, Employe $e2)
    {
        if ($e1->getSalaire() == $e2->getSalaire()) {
            echo "ils ont des salaires égaux";
        } elseif ($e1->getSalaire() > $e2->getSalaire()) {
            echo "C'est l'employé " . $e1->nom . " qui a le plus gros salaire" . PHP_EOL;
        } else {
            echo "C'est l'employé " . $e2->nom . " qui a le plus gros salaire" . PHP_EOL;
        }
    }

    public static function augmenterSalaire(Employe $employe, $montant)
    {
        if ($montant < 0) {
            throw new InvalidValueException("Le pourcentage ne peut pas être négatif");
        }

        $augmentation = $employe->getSalaire() * $montant / 100;
        $employe->setSalaire($employe->getSalaire() + $augmentation);

        echo "L'employé " . $employe->nom . " sera augmenté de " . $augmentation . ", il a maintenant " . $employe->getSalaire() . PHP_EOL;
    }

    public static function diminuerSalaire(Employe $employe, $montant)
    {
        if ($montant < 0) {
            throw new InvalidValueException("Le pourcentage ne peut pas être négatif");
        }

        $diminution = $employe->getSalaire() * $montant / 100;
        $employe->setSalaire($employe->getSalaire() - $diminution);

        echo "L'employé " . $employe->nom . " sera diminué de " . $diminution . ", il a maintenant " . $employe->getSalaire() . PHP_EOL;
    }

    public static function salaireMoyen(array $employes)
    {
        if (count($employes) === 0) {
            throw new InvalidValueException("Il n'y a pas d'employé dans la liste");
        }

        $res = 0;
        foreach ($employes as $employe) {
            $res += $employe->getSalaire();
        }
        $moyenne = $res / count($employes);

        echo "La moyenne des salaires est de " . $moyenne . PHP_EOL;
    }
}

class Freelance extends Personne implements TravailleurInterface
{

    private $salaire;

    public function __construct($nom, $age, $salaire)
    {
        if ($salaire < 0) {
            throw new InvalidValueException("Le salaire ne peut pas être négatif");
        }
        parent::__construct($nom, $age);
        $this->salaire = $salaire;
    }

    public function sePresenter()
    {
        echo "Je m'appelle " . $this->nom . " et j'ai " . $this->age . "ans. " . PHP_EOL;
    }

    public function travailler()
    {
        echo "Je travaille en freelance." . PHP_EOL;
    }

}

class Manager extends Employe
{
    private $prime = 0;

    public function __construct($nom, $age, $salaire, $prime)
    {
        if ($prime < 0) {
            throw new InvalidValueException("La prime ne peut pas être négative");
        }
        parent::__construct($nom, $age, $salaire);
        $this->prime = $prime;

    }

    public function getSalaireTotal()
    {
        return $this->getSalaire() + $this->prime;
    }

    public function travailler()
    {
        echo "Je suis manager et je gère une équipe. J'ai un salaire total de " . $this->getSalaireTotal() . PHP_EOL;
        echo "J'ai eu une prime de " . $this->prime . PHP_EOL;
    }

    public function ajouterPrime($montant)
    {
        if ($montant < 0) {
            throw new InvalidValueException("le montant ne peut pas être négatif");
        }

        $this->prime += $montant;

        echo "J'ai eu une prime d'un montant de " . $montant . PHP_EOL;
    }

    public function diminuerPrime($montant)
    {
        if ($montant < 0) {
            throw new InvalidValueException("le montant ne peut pas être négatif");
        }

        $this->prime -= $montant;
        echo "Ma prime a baisser de " . $montant . PHP_EOL;
    }
}

$tableau = [];
try {
    $employe1 = new Employe("titi", 25, 10000);
    $employe2 = new Employe("zozo", 40, 300000);
    $manager1 = new Manager("toto", 25, 10000, 100000);
    $tableau[] = $employe1;
    $tableau[] = $employe2;
    $tableau[] = $manager1;

    Employe::compareSalaire($employe1, $employe2);
    Employe::augmenterSalaire($employe1, 50);
    Employe::diminuerSalaire($employe2, 50);
    Employe::salaireMoyen($tableau);
    $manager1->travailler();
} catch (InvalidValueException $e) {
    echo $e->getMessage();
}


foreach ($tableau as $employe) {
    $employe->sePresenter();
    $employe->travailler();
    echo "_____________________________" . PHP_EOL;
}
