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
        $listitems = [];

        $sql = "SELECT"
            . " rr.platz,re.date as re_date,r.name as r_name,rp.name as rp_name"
            . " FROM tl_rankingresult rr"
            . " LEFT JOIN tl_rankingevent re ON (re.id=rr.pid)"
            . " LEFT JOIN tl_ranking r ON (r.id=re.pid)"
            . " LEFT JOIN tl_rankingplayer rp ON (rr.name=rp.id)"
        ;
        $data = \Database::getInstance()->prepare($sql)->execute();
        if ($data) {
            while ($data->next()) {
                $listitems[] = json_encode($data->row(), true);
            }
        }
        $this->Template->listitems = $listitems;
    }

}