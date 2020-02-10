<?php

class Weine implements JsonSerializable
{
    private $id = 0;
    private $name;
    private $preis;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPreis()
    {
        return $this->preis;
    }

    /**
     * @param mixed $preis
     */
    public function setPreis($preis)
    {
        $this->preis = $preis;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    public function __construct($data = array())
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $setterName = "set" . ucfirst($key);
                if (method_exists($this, $setterName)) {
                    if (empty($value))
                        $value = null;
                    $this->$setterName($value);
                }
            }
        }
    }



    public function toArray($mitId = true)
    {
        $attributs = get_object_vars($this);
        if ($mitId === false) {
            unset($attributs['id']);
        }
        return $attributs;
    }


    public function save()
    {
        if ($this->getId() > 0) {
            $this->update();
        } else {
            $this->insert();
        }
    }


    public function insert()
    {
        $sql = 'INSERT INTO wein (name, preis) '
            . 'VALUES (:name, :preis)';
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray(false));
        $this->id = Database::getDB()->lastInsertId();
    }


    public function update()
    {
        $sql = "UPDATE wein SET name=:name, preis=:preis WHERE id=:id;";
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray());
    }

    public static function findeWeinNachID($id)
    {
        $sql = "SELECT * FROM wein WHERE id = '$id'";
        $query = Database::getDB()->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Weine");
        return $query->fetch();
    }
    public static function findeWeinNachName($name)
    {
        $sql = "SELECT * FROM wein WHERE name LIKE '%$name%'";
        $query = Database::getDB()->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Weine");
        return $query->fetch();
    }


    public static function findeAllWeine()
    {
        $sql = 'SELECT * FROM wein';
        $abfrage = Database::getDB()->query($sql);
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Weine');
        return $abfrage->fetchAll();
    }
    public static function findeNachBestellung(Bestellung $bestellung)
    {
        $sql = 'SELECT wein.*FROM wein w JOIN bestellung_has_wein bes_hat_wein on w.id = bes_hat_wein.wein_id
                WHERE bes_hat_wein.bestellung_id = ?';
        $abfrage = Database::getDB()->prepare($sql);
        $abfrage->execute(array($bestellung->getId()));
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Weine');
        return $abfrage->fetchAll();
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


    public function findeWeinNachBestellung()
    {
        return Bestellung::findeNachWeine($this);
    }


}
