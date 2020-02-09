<?php


class Bestellung implements JsonSerializable
{
    private $id = 0;
    private $datum;
    private $kunde_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getKundeId()
    {
        return $this->kunde_id;
    }

    /**
     * @param mixed $kunde_id
     */
    public function setKundeId($kunde_id)
    {
        $this->kunde_id = $kunde_id;
    }


    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */


    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
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

    public function save()
    {
        if ($this->getBId() > 0) {
            $this->update();
        } else {
            $this->insert();
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


    public function insert()
    {
        $sql = 'INSERT INTO bestellung (datum,kunde_id)'
            . 'VALUES (:datum,:kunde_id)';
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray(false));
        $this->id = Database::getDB()->lastInsertId();
    }

    public function update()
    {
        $sql = 'UPDATE bestellung SET id=:b_id, datum=:datum, k_id=:k_id'
            . 'WHERE id=:id';
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray());
    }
    public static function findeAlleBestellungen()
    {
        $sql = 'SELECT * FROM bestellung';
        $abfrage = Database::getDB()->query($sql);
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Bestellung');
        return $abfrage->fetchAll();
    }

    public static function findeNachWeine(Wein $weine)
    {
        $sql = 'SELECT b.* FROM bestellung b join bestellung_hat_wein bes_hat_wein on b.id = bes_hat_wein.bestellung_id where bes_hat_wein.wein_id=?';
        $abfrage = Database::getDB()->prepare($sql);
        $abfrage->execute(array($weine->getId()));
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Bestellung');
        return $abfrage->fetchAll();
    }

    public function getWeine()
    {
        return Wein::findeNachBestellung($this);
    }

    public static function findeBestellungNachKunde(Kunde $kunden)
    {
        $sql = 'SELECT b.* FROM kunde k,bestellung b where k.id = b.kunde_id AND b.kunde_id=?';
        $abfrage = Database::getDB()->prepare($sql);
        $abfrage->execute(array($kunden->getId()));
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Bestellung');
        return $abfrage->fetchAll();
    }

    public function getKunde()
    {
        return Kunde::findeNachBestellung($this);
    }

    public static function findById($id)
    {
        $sql = "SELECT * FROM bestellung WHERE id = '$id'";

        $query = Database::getDB()->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Bestellung");
        return $query->fetch();
    }
}