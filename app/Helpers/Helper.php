<?php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

function get_base_path($model): string
{
    return strtolower(class_basename($model));
}

function convert_into_default_select_box($objects = null, $key = 'id', $value = 'name', $type = 'default'): array
{
    $def = __('common.select_option');
    if ($type != 'default') {
        $def = $type;
    }

    return collect($objects)->mapWithKeys(function ($item) use ($key, $value) {
        return [$item->$key => $item->$value];
    })->prepend($def, null)->all();
}

function convert_crop_categories_into_default_select_box($objects = null): array
{
    $def = __('common.crop_category_name');
    $unknown = __('common.unknown');
    return collect($objects)->mapWithKeys(function ($item) {
        return [$item->id => $item->name];
    })->prepend($unknown, 0)->prepend($def, null)->all();
}

function convert_into_select_box($objects, $key = 'id', $value = 'name'): array
{
    return collect($objects)->mapWithKeys(function ($item) use ($key, $value) {
        return [$item->$key => $item->$value];
    })->all();
}

function limitTo($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos = array_keys($words);
        $text = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

function limitCharacter($text, $limit = null)
{
    if ($limit == null) {
        $limit = config('constant.limit_character');
    }
    return Str::limit($text, $limit, '...');
}

function db_date($date, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d'): ?string
{
    if (!$date) {
        return null;
    }

    return Carbon::createFromFormat($fromFormat, $date)->format($toFormat);
}

function db_end_date_filter($date, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
{
    return db_date($date, $fromFormat, $toFormat) . ' 23:59:59';
}

function view_date($date, $fromFormat = 'Y-m-d', $toFormat = 'd/m/Y'): ?string
{
    if (!$date) {
        return null;
    }

    return Carbon::createFromFormat($fromFormat, $date)->format($toFormat);
}

function db_date_time($time, $fromFormat = 'd/m/Y H:i:s', $toFormat = 'Y-m-d H:i:s'): ?string
{
    if (!$time) {
        return null;
    }

    return Carbon::createFromFormat($fromFormat, $time)->format($toFormat);
}


function view_date_time($time, $fromFormat = 'Y-m-d H:i:s', $toFormat = 'd/m/Y H:i'): ?string
{
    if (!$time) {
        return null;
    }

    return Carbon::createFromFormat($fromFormat, $time)->format($toFormat);
}

function checkMultiLang($array, $locate, $modelObject, $arrs = [])
{
    $locates = config('constant.languages');
    $fieldArray = [];
    foreach ($array as $value) {
        if ($locate != config('constant.languages.vi') && in_array($locate, $locates)) {
            foreach ($arrs as $arr) {
                if (!$modelObject->$arr) {
                    $fieldArray[$value] = $value . '_en';
                } else {
                    $fieldArray[$value] = $value . '_' . $locate;
                }
            }
        } else {
            $fieldArray[$value] = $value;
        }
    }
    return $fieldArray;
}

function startImport($type)
{
    logger("Start import $type");
}

function endImport($type)
{
    logger("End import $type");
}
