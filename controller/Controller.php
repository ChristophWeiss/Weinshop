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

    public function addBestellung()
    {
        if (isset($_POST['bestellung'])) {
            $bestellung = json_decode($_POST['bestellung']);
            foreach ($bestellung as $key => $value) {

            }
            var_dump($bestellung);
        }


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
            $bestellung = json_encode($_POST['bestellung']);

            $b = new Bestellung();
            $b->setDatum(date("h:i:sa"));
            $b->setKundeId(1);
            $b->insert();
            foreach ($bestellung as $key => $value) {
                $bhw = new Bestellung_hat_Wein();
                $bhw->setWeinId($key);
                $bhw->setAnzahl($value);
                $bhw->setBestellungId($b->getId());
                $bhw->insert();
            }
        }
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
