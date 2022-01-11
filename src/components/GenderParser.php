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
        $lexicales = $this->result[0]->lexicalEntries;
        $gender = '';

        foreach($lexicales as $lexical){
            if(property_exists($lexical, 'entries')){
                foreach($lexical->entries as $entry){
                    if(property_exists($entry, 'grammaticalFeatures')){
                        foreach($entry->grammaticalFeatures as $feature){
                            if (isset($feature->type) && $feature->type == 'Gender' && isset($feature->id)) {
                                $gender = $feature->id;
                            }
                        }
                    }
                }
            }
        }

        return $gender;
    }

    public function getResult()
    {
        return $this->result;
    }
}
