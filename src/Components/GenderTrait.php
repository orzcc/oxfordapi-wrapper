<?php

namespace Inani\OxfordApiWrapper\Components;

use Inani\OxfordApiWrapper\Exceptions\TranslateException;
use Exception;

trait GenderTrait
{
    /**
     * get gender of a word
     *
     * @return $this
     * @throws TranslateException
     * @throws Exception
     */
    public function gender()
    {
        try{
            $this->result = $this->client->get(
                "{$this->base}/words/{$this->lang}?q={$this->word}"
            );

            if($this->result->getStatusCode() == 200){
                $this->reset_gender();
                return new GenderParser(
                    json_decode(
                        $this->result->getBody()->getContents()
                    )->results
                );
            }
            throw new Exception('An error occurred');

        } catch (Exception $e){
            throw new TranslateException($e->getCode());
        }
    }

    /**
     * Reset fields
     */
    public function reset_gender()
    {
        $this->reset();
    }
}
