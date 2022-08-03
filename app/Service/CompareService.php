<?php

declare(strict_types=1);

namespace App\Service;

class CompareService
{
    public function getComparison(string $first, string $second): array
    {
        $stringArray = $this->convertToArray($first);
        $newArray = $this->convertToArray($second);
//        var_dump($stringArray);
//        var_dump($newArray);


        $result = [];
        $firstOffset = 0;
        $secondOffset = 0;
        $firstIndex = 0;
        $secondIndex = 0;

        for ($i = 0; $i < max(count($stringArray), count($newArray)); $i++) {
            $currentItem = [];

            $firstIndex = $i + $firstOffset;
            $secondIndex = $i + $secondOffset;
            if (isset($stringArray[$firstIndex]) && isset($newArray[$secondIndex])) {
                $currentFirstElement = $stringArray[$firstIndex];
                $currentSecondElement = $newArray[$secondIndex];


                similar_text($currentFirstElement, $currentSecondElement, $percent);
                $percent = (int)$percent;

                if ($percent > 50 && $percent < 100) {
                    $currentItem['text'] = $currentSecondElement;
                    $currentItem['color'] = 'yellow';
                    $currentItem['prev'] = $currentFirstElement;
                    $result[] = $currentItem;

                } else if ($percent <= 50) {

                    $result = array_merge($result, $this->notSimilar($stringArray, $firstIndex, $newArray, $secondIndex, $firstOffset, $secondOffset, $i));

                } else if ($percent === 100){
                    $currentItem['text'] = $currentFirstElement;
                    $result[] = $currentItem;
                }



            } else if (isset($stringArray[$firstIndex])){
                $currentItem['text'] = $stringArray[$firstIndex];
                $currentItem['color'] = 'red';
                $result[] = $currentItem;
            } else if (isset($newArray[$firstIndex])) {
                $currentItem['text'] = $newArray[$secondIndex];
                $currentItem['color'] = 'green';
                $result[] = $currentItem;
            }

        }

        if ($firstOffset < 0) {
            for ($j = $firstIndex + 1; $j < count($stringArray); $j++) {
                $currentItem = [];
                $currentItem['text'] = $stringArray[$j];
                $currentItem['color'] = 'red';
                $result[] = $currentItem;
            }
        }

        if ($secondOffset < 0) {
            for ($j = $secondIndex + 1; $j < count($newArray); $j++) {
                $currentItem = [];
                $currentItem['text'] = $newArray[$j];
                $currentItem['color'] = 'green';
                $result[] = $currentItem;
            }
        }

        return $result;

    }

    protected function convertToArray(string $str): array
    {
        return  preg_split('/(?<=[!?.])./', $str,-1,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
    }



    protected function notSimilar(
        array $stringArray,
        $firstIndex,
        array $newArray,
        $secondIndex,
        &$firstOffset,
        &$secondOffset,
        &$i
    )
    {
        $restArray = [];
        for ($j = 1; $i + $j < max(count($stringArray), count($newArray)); $j++) {
            if (isset($newArray[$secondIndex + $j])) {
                similar_text($stringArray[$firstIndex], $newArray[$secondIndex + $j], $percentWithNextSecondElement);
            }

            if (isset($stringArray[$firstIndex + $j])) {
                similar_text($newArray[$secondIndex], $stringArray[$firstIndex + $j], $percentWithFirstSecondElement);
            }

            $currentItem = [];
            if (
                $j === 1 &&
                isset($percentWithNextSecondElement) &&
                (int)$percentWithNextSecondElement === 100 &&
                isset($percentWithFirstSecondElement) &&
                (int)$percentWithFirstSecondElement === 100
            ) {
                $i = $i + $j;
                $currentItem['text'] = $newArray[$secondIndex + $j];
                $currentItem['color'] = 'yellow';
                $currentItem['prev'] = $stringArray[$firstIndex + $j];
                $restArray[] = $currentItem;
            } else if (
                isset($percentWithNextSecondElement) &&
                (int)$percentWithNextSecondElement === 100
            ) {
                $currentItem['text'] = $newArray[$secondIndex + $j];
                $currentItem['color'] = 'green';
                $firstOffset = $firstOffset - $j;
                $restArray[] = $currentItem;
            } else if (
                isset($percentWithFirstSecondElement) &&
                (int)$percentWithFirstSecondElement === 100
            ) {
                $currentItem['text'] = $stringArray[$firstIndex + $j];
                $currentItem['color'] = 'red';
                $secondOffset = $secondOffset - $j;
                $restArray[] = $currentItem;
            }


        }
        return $restArray;
    }
}