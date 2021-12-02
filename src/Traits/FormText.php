<?php

namespace App\Traits;

trait FormText
{
    /**
     * Cette méthode permet de supprimer tout
     * les caractères spéciaux d'une chaîne.
     *
     * @param string $text comment
     *
     * @return string
     */
    public function removeSpecialChar(string $text): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $text);
    }

    /**
     * Supprime les balises HTML et PHP d'une chaîne.
     *
     * @param string $text comment
     *
     * @return string
     */
    public function stripTags(string $text): string
    {
        return strip_tags($text);
    }

    /**
     * Remplace tous les accents par leur équivalent sans accent.
     *
     * @param string $text comment
     *
     * @return string
     */
    public function enleveAccents(string $text): string
    {
        return str_replace(
            array(
                'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'à', 'á', 'â', 'ã', 'ä', 'å',
                'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø',
                'È', 'É', 'Ê', 'Ë', 'è', 'é', 'ê', 'ë',
                'Ç', 'ç',
                'Ì', 'Í', 'Î', 'Ï', 'ì', 'í', 'î', 'ï',
                'Ù', 'Ú', 'Û', 'Ü', 'ù', 'ú', 'û', 'ü',
                'ÿ',
                'Ñ', 'ñ',
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'c', 'c',
                'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
                'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                'y',
                'n', 'n',
            ),
            $text
        );
    }

    /**
     * Formate un text pour un slug bdd.
     *
     * @param string $text comment
     *
     * @return string
     */
    public function slug(string $text): string
    {
        $text = strtolower(
            $this->removeSpecialChar(
                str_replace(
                    array(' ', '_', ',', '.'),
                    array('-', '-', '-', '-'),
                    $this->enleveAccents($text)
                )
            )
        );

        if (substr($text, strlen($text) - 1, strlen($text)) === '-') {
            $text = rtrim($text, '-');
            $this->slug($text);
        }

        return $text;
    }
}
