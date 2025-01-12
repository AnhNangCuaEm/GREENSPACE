<?php
class TextHelper {
    public static function convertToSearchableText($text) {
        // Chuyển đổi half-width sang full-width katakana
        $text = mb_convert_kana($text, "KV", "UTF-8");
        
        // Chuyển đổi katakana sang hiragana
        $text = mb_convert_kana($text, "c", "UTF-8");
        
        // Loại bỏ tất cả dấu cách
        $textWithoutSpaces = str_replace(' ', '', $text);
        
        return [$text, $textWithoutSpaces];
    }
}