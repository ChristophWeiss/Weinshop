<?php



class Kunden implements JsonSerializable
{
    private $id = 0;
    private $vorname;
    private $nachname;
    private $ort;


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


    /**
     * @return mixed
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * @param mixed $vorname
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * @return mixed
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * @param mixed $nachname
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;
    }

    /**
     * @return mixed
     */
    public function getOrt()
    {
        return $this->ort;
    }

    /**
     * @param mixed $ort
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;
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
        $sql = 'INSERT INTO kunde (vorname,nachname,ort)'
            . 'VALUES (:vorname,:nachname,:ort)';
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray(false));
        $this->id = Database::getDB()->lastInsertId();
    }

    public function update()
    {

        $sql = "UPDATE kunde SET id=:id, vorname=:vorname, nachname=:nachname, ort=:ort WHERE id=:id";
        $query = Database::getDB()->prepare($sql);
        $query->execute($this->toArray());
    }


    public static function findById($id)
    {
        $sql = "SELECT * FROM kunde WHERE id = '$id'";

        $query = Database::getDB()->query($sql);
        $query->setFetchMode(PDO::FETCH_CLASS, "Kunde");
        return $query->fetch();
    }


    public function findeBestellung()
    {
        return Bestellung::findeBestellungNachKunde($this);
    }
    public static function findeNachBestellung(Bestellung $bestellung)
    {
        $sql = 'SELECT kunde.* FROM kunde k '
            . 'JOIN bestellung b ON k.id=b.kunde_id '
            . 'WHERE b.id=?';
        $abfrage = Database::getDB()->prepare($sql);
        $abfrage->execute(array($bestellung->getId()));
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kunden');
        return $abfrage->fetchAll();
    }

    public static function findeAlleKunden()
    {
        $sql = 'SELECT * FROM kunde';
        $abfrage = Database::getDB()->query($sql);
        $abfrage->setFetchMode(PDO::FETCH_CLASS, 'Kunden');
        return $abfrage->fetchAll();
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }



}