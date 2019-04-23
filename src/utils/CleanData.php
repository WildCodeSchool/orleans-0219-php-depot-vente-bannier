<?php


namespace App\utils;

class CleanData
{
    /**
     * Clean data
     *
     * @param array $dirtyData
     * @return array
     */
    public function dataCleaner(array $dirtyData) : array
    {
        $cleanData = [];
        foreach ($dirtyData as $datum => $value) {
            $cleanData[$datum] = strip_tags(stripslashes(trim($value)));
        }
        return $cleanData;
    }
}

