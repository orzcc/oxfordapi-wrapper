<?php

namespace Inani\OxfordApiWrapper;

use Inani\OxfordApiWrapper\Components\DefinerTrait;
use Inani\OxfordApiWrapper\Components\DictionaryTrait;
use Inani\OxfordApiWrapper\Components\TalkerTrait;
use Inani\OxfordApiWrapper\Components\TranslatorTrait;
use Inani\OxfordApiWrapper\Components\GenderTrait;
use GuzzleHttp\Client;

class OxfordWrapper
{
    use TranslatorTrait,
        DefinerTrait,
        GenderTrait,
        DictionaryTrait,
        TalkerTrait;

    protected $client;

    protected $word;

    protected $base = 'api/v2';

    protected $result;

    protected $lang = 'en';

    public function __construct(Client $client, $lang = 'en')
    {
        $this->client = $client;
        $this->lang = $lang;
    }

    /**
     * The word to look for
     *
     * @param $word
     * @return $this
     */
    public function lookFor($word)
    {
        $this->word = $word;
        return $this;
    }

    /**
     * Reset the parameters
     */
    protected function reset()
    {
        $this->word = null;
    }
}
