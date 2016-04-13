<?php

namespace App\Import\Persons;

class BioDataExtractor
{

    protected $birthDate;
    protected $deathDate;

    public function extract($bioData)
    {
        $this->reset();

        if ($bioData === null || empty($bioData)) {
            return;
        }

        $bioData = str_replace('bis', '-', $bioData);

        $terms = explode('-', $bioData);

        if (count($terms) !== 2) {
            $this->tryComplexExtraction($bioData);

            return;
        }

        if ($terms[0] !== '') {
            $this->birthDate = trim($terms[0]);
        }

        if ($terms[1] !== '') {
            $this->deathDate = trim($terms[1]);
        }
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function getDeathDate()
    {
        return $this->deathDate;
    }

    private function reset()
    {
        $this->birthDate = null;
        $this->deathDate = null;
    }

    private function tryComplexExtraction($bioData)
    {
        if (preg_match('/gest(?:\\.|orben) (.*)/', $bioData, $output_array)) {
            $this->deathDate = $output_array[1];
        } else {
            if (preg_match('/(?:geb(?:\\.|oren)|\*) (.*)/', $bioData, $output_array)) {
                $this->birthDate = $output_array[1];
            }
        }
    }
}
