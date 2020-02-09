<?php



class bestellung_hat_wein implements JsonSerializable
{
    private $bestellung_id;
    private $wein_id;
    private $anzahl;


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

    /**
     * @return mixed
     */
    public function getBestellungId()
    {
        return $this->bestellung_id;
    }

    /**
     * @param mixed $bestellung_id
     */
    public function setBestellungId($bestellung_id)
    {
        $this->bestellung_id = $bestellung_id;
    }

    /**
     * @return mixed
     */
    public function getWeinId()
    {
        return $this->wein_id;
    }

    /**
     * @param mixed $wein_id
     */
    public function setWeinId($wein_id)
    {
        $this->wein_id = $wein_id;
    }

    /**
     * @return mixed
     */
    public function getAnzahl()
    {
        return $this->anzahl;
    }

    /**
     * @param mixed $anzahl
     */
    public function setAnzahl($anzahl)
    {
        $this->anzahl = $anzahl;
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
        $sql = 'INSERT INTO bestellung_hat_wein (bestellung_id,wein_id,anzahl)'
            . 'VALUES (:bestellung_id,:wein_id,:anzahl)';
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray(false));
        $this->id = Database::getDB()->lastInsertId();
    }

    public function update()
    {
        $sql = 'UPDATE bestellung_hat_wein SET bestellung_id=:bestellung_id, wein_id=:wein_id, anzahl=:anzahl'
            . 'WHERE bestellung_id=:bestellung_id and wein_id=:wein_id';
        $query = Database::getDB()->prepare($sql);

    }

    public static function findeNachBestellungsId(Bestellung $bestellung)
    {
        $sql = 'SELECT * FROM bestellung b join bestellung_hat_wein bes_hat_wein on b.id = bes_hat_wein.bestellung_id join wein w on bes_hat_wein.wein_id = w.id where bes_hat_wein.bestellung_id=?';
        $abfrage = Database::getDB()->prepare($sql);
        $abfrage->execute(array($bestellung->getId()));
        $abfrage->setFetchMode(PDO::FETCH_ASSOC);
        return $abfrage->fetchAll();
    }



    public function jsonSerialize()
    {
        return get_object_vars($this);
    }



}