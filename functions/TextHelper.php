<?php
class TextHelper {
    public static function convertToSearchableText($text) {
        //Convert half-width to full-width katakana
        $text = mb_convert_kana($text, "KV", "UTF-8");
        
        //Convert katakana to hiragana
        $text = mb_convert_kana($text, "c", "UTF-8");
        
        //Remove all spaces
        $textWithoutSpaces = str_replace(' ', '', $text);
        
        return [$text, $textWithoutSpaces];
    }
}