<?php

class Utilitaires {
    public static function initiale(?string $texte): string {
        $initiale = '';
        if (isset($texte)) {
            $initiale = mb_strtoupper(mb_substr($texte, 0, 1, 'UTF-8'), 'UTF-8');
        }
        return $initiale !== '' ? $initiale : '♪';
    }
}
