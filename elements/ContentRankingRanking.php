<?php


/**
 * Content element "Gesamt-Ranking eines Rankingturniers".
 *
 * @author Andreas Fieger <https://github.com/fiedsch>
 */
class ContentRankingRanking extends \ContentElement
{
    /**
     * Template
     *
     * @var string
     */
    protected $strTemplate = 'ce_rankingranking';

    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->title = $this->headline;


            $objTemplate->wildcard = "### " . $GLOBALS['TL_LANG']['CTE']['rankingranking'][0] . " ###";
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate the content element
     */
    public function compile()
    {
        $tempdata = [];
        $result = [];

        // Rohdaten holen
        $sql = "SELECT"
            . " re.id,rr.platz,re.date as re_date,r.name as r_name,rp.name as rp_name"
            . " FROM tl_rankingresult rr"
            . " LEFT JOIN tl_rankingevent re ON (re.id=rr.pid)"
            . " LEFT JOIN tl_ranking r ON (r.id=re.pid)"
            . " LEFT JOIN tl_rankingplayer rp ON (rr.name=rp.id)"
            . " WHERE re.published='1'"
        ;
        $data = \Database::getInstance()->prepare($sql)->execute();
        if ($data) {
            while ($data->next()) {
                $tempdata[$data->id][] = $data->row();
            }
        }

        // Daten anreichern
        foreach ($tempdata as $event => $data) {
            // Anzahl Teilnehmer
            foreach ($data as $i => $playerdata) {
                $tempdata[$event][$i]['teilnehmerzahl'] = count($data);
            }
            // Punkte
            foreach ($data as $i => $playerdata) {
                $tempdata[$event][$i]['punkte'] = $this->getPunkte($tempdata[$event][$i]['platz'], $tempdata[$event][$i]['teilnehmerzahl']);
            }
        }

        // Aggregieren (nach Spieler)
        foreach ($tempdata as $event => $data) {
            foreach ($data as $playerdata) {
                $result[$playerdata['rp_name']]['punkte'] += $playerdata['punkte'];
                $result[$playerdata['rp_name']]['teilnahmen']++;
                $result[$playerdata['rp_name']]['plaetze'][] = $playerdata['platz'];
            }
        }

        // Benutzerdefiniertes Sortieren:
        //   "Die Vergleichsfunktion muss einen Integer
        //     kleiner als, gleich oder größer als Null
        //   zurückgeben, wenn das erste Argument
        //     respektive kleiner, gleich oder größer
        //   als das zweite ist."
        // (für aufsteigende Sortieruung!).

        uasort($result, function($a, $b) { return -1*($a['punkte'] - $b['punkte']); });

        // Berechnung Ranglplatz (Ties berücksichtigen!)
        // TODO
        $rang = 0;
        $skipraenge = 0;
        $lastpunkte = PHP_INT_MAX;
        foreach ($result as $player => $playerdata) {
            if ($playerdata['punkte'] < $lastpunkte) {
                $rang += $skipraenge;
                $result[$player]['rang'] = ++$rang;
                $skipraenge = 0;
            } else {
                $result[$player]['rang'] = $rang;
                $skipraenge++;
            }
            $lastpunkte = $result[$player]['punkte'];
        }

        // Ergebnisse an das Template weiterreichen

        $this->Template->tempdata = $tempdata;
        $this->Template->result = $result;
    }

    /**
     * Berechnung der Punkte für erreichten $platz bei $teilnehmerzahl Teilnehmern.
     *
     * @param integer $platz
     * @param integer $teilnehmerzahl
     * @return integer
     */
    protected function getPunkte($platz, $teilnehmerzahl)
    {
        return $teilnehmerzahl - $platz; // simple Dummyimplementierung (nur Debug)

        // 1. Größe des "Felds" aus Anzahl der Teilnehmer, aufgerundet auf die
        // nächst höhere Zweierpotenz (Bsp.: 7 Teilnehmer => 8er Spielplan,
        // 8 Teilnehmer => 8er Spielplan, 9 Teilnehmer => 16er Spielplan, usw.).

        // 2. Abhängig von Feld-Größe und erreichtem $platz die Punkte vergeben

    }
}