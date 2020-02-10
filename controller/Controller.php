<?php

class Controller
{

    private $context = array();


    public function run($action)
    {
        $this->$action();
        $this->generatePage($action);
    }

    //Alle Weine
    public function alleWeine()
    {
        $this->addContext("weine", Weine::findeAllWeine());
    }

    //Alle Kunden
    public function alleKunden()
    {
        $this->addContext("kunden", Kunden::findeAlleKunden());
    }

    public function alleBestellungen()
    {
        $this->addContext("bestellungen", Bestellung::findeAlleBestellungen());
    }

    public function findeWeinNachName()
    {
        var_dump(Weine::findeWeinNachName($_GET["name"]));
    }

    public function WeinAnlegen()
    {
        $w = new Weine();
        $w->setName($_GET["name"]);
        $w->setPreis($_GET["preis"]);
        $w->insert();
    }

    public function KundeAnlegen()
    {
        $k = new Kunden();
        $k->setVorname($_GET["vorname"]);
        $k->setNachname($_GET["nachname"]);
        $k->setOrt($_GET["ort"]);
        $k->insert();
    }

    public function BestellungAnlegen()
    {
        if (isset($_POST['bestellung'])) {
            $bestellung = $_POST['bestellung'];
            $ar = explode(',', $bestellung);
            $temp = array();
            for ($v = 0; $v < sizeof($ar); $v += 2) {
                $temp[$ar[$v]] = $ar[$v + 1];
            }
            var_dump($temp);

            $b = new Bestellung();
            $b->setDatum(date("h:i:sa"));
            $b->setKundeId(1);
            $b->insert();
            foreach ($temp as $key => $value) {
                $bhw = new Bestellung_hat_Wein();
                $bhw->setWeinId($key);
                $bhw->setAnzahl($value);
                $bhw->setBestellungId($b->getId());
                $bhw->insert();
            }
        }
    }

    public function BestellungAnlegenOhneArray()
    {


        $b = new Bestellung();
        $b->setDatum(time());
        $b->setKundeId($_GET["kunde_id"]);
        $b->insert();

        $bhw = new Bestellung_hat_Wein();
        $bhw->setWeinId($_GET["wein_id"]);
        $bhw->setAnzahl($_GET["anzahl"]);
        $bhw->setBestellungId($b->getId());
        $bhw->insert();


    }

    public function getKundebyID()
    {
        var_dump(Kunden::findById($_GET["id"]));
    }

    public function getWeinbyID()
    {
        var_dump(Weine::findeWeinNachID($_GET["id"]));
    }

    private function generatePage($template)
    {
        extract($this->context);
        require_once 'view/' . $template . ".tpl.php";

    }

    private function addContext($key, $value)
    {
        $this->context[$key] = $value;
    }
}
