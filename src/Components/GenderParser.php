<?php

namespace Inani\OxfordApiWrapper\Components;


class GenderParser extends BasicResult
{
    protected $gender = '';

    /**
     * Return an array of definitions
     *
     * @return array
     */
    public function get()
    {
        if (! isset($this->result[0])) {
            return [];
        }

        $result = $this->result[0];
        $data = [];

        if (property_exists($result, 'lexicalEntries')) {
            $lexicales = $result->lexicalEntries;
            foreach($lexicales as $lexical) {
                if(property_exists($lexical, 'entries')){
                    foreach($lexical->entries as $entry){
                        if(property_exists($entry, 'grammaticalFeatures')){
                            foreach($entry->grammaticalFeatures as $feature){
                                if (isset($feature->type) && $feature->type == 'Gender' && isset($feature->id)) {
                                    $data['gender'] = $feature->id;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (property_exists($result, 'type')) {
            $data['type'] = $result->type;
        }

        if (property_exists($result, 'word')) {
            $data['word'] = $result->word;
        }

        return $data;
    }

    public function getResult()
    {
        return $this->result;
    }
}
