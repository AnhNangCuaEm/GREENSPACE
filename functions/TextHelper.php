<?php
class TextHelper {
    public static function convertToSearchableText($text) {
        error_log("Input text: " . $text); // Debug log
        
        // Ensure UTF-8 encoding
        if (!mb_check_encoding($text, 'UTF-8')) {
            $text = mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text));
        }
        
        //Convert half-width to full-width katakana
        $text = mb_convert_kana($text, "KV", "UTF-8");
        error_log("After KV conversion: " . $text); // Debug log
        
        //Convert katakana to hiragana
        $text = mb_convert_kana($text, "c", "UTF-8");
        error_log("After hiragana conversion: " . $text); // Debug log
        
        //Remove all spaces
        $textWithoutSpaces = str_replace(' ', '', $text);
        
        return [$text, $textWithoutSpaces];
    }
}