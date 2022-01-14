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

        $gender = $this->_getGender($result);
        if (! empty($gender)) {
            $data['gender'] = $gender;
        }

        if (property_exists($result, 'type')) {
            $data['type'] = $result->type;
        }

        if (property_exists($result, 'word')) {
            $data['word'] = $result->word;
        }

        return $data;
    }

    protected function _getGender($result)
    {
        if (property_exists($result, 'lexicalEntries')) {
            $lexicales = $result->lexicalEntries;
            foreach ($lexicales as $lexical) {
                if (property_exists($lexical, 'entries')) {
                    foreach ($lexical->entries as $entry) {
                        if (property_exists($entry, 'grammaticalFeatures')) {
                            foreach ($entry->grammaticalFeatures as $feature) {
                                if (isset($feature->type) && $feature->type == 'Gender' && isset($feature->id)) {
                                    if (config('oxford.lang') == 'es' && $feature->id == 'masculine') {
                                        // es: exists multi genders, get masculine.
                                        return $feature->id;
                                    }
                                    if (config('oxford.lang') == 'fr' && !empty($feature->id)) {
                                        // fr: exists multi genders, get first
                                        return $feature->id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return '';
    }

    public function getResult()
    {
        return $this->result;
    }
}
