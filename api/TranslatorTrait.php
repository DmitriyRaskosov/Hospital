<?php

trait Translator
{
    public static function getTranslation($ru)
    {
        $all_data = (array)json_decode(file_get_contents(__DIR__.'/../data/translations.json'), true);
        $result = 'Перевод этого слова отсутствует';
        foreach ($all_data as $value) {
            if ($value['ru'] == $ru) {
                $result = $value['en'];
                break;
            }
        }
        return $result;
    }
}