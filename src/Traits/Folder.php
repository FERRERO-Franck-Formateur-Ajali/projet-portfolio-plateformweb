<?php

/**
 * FLEUR-DE-FLANELLE
 * PHP version 7.
 *
 * @category Raptor\Traits
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/fleur_de_flanelle
 */

namespace App\Traits;

/**
 * FLEUR-DE-FLANELLE
 * PHP version 7.
 *
 * @category Raptor\Traits
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/fleur_de_flanelle
 */
trait Folder
{
    /**
     * Change le mode d'un dossier — chmod.
     *
     * @param string $path  comment
     * @param int    $chmod comment
     *
     * @return boolean
     */
    public function folderChmod(string $path, int $chmod = 0755): bool
    {
        return chmod($path, $chmod);
    }

    /**
     * Change le mode des dossiers et fichiers en recursive — chmod.
     *
     * @param string $path  comment
     * @param int    $chmod comment
     *
     * @return void
     */
    public function chmod_r(string $path, int $chmod = 0755)
    {
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $item) {
            chmod($item->getPathname(), $chmod);
            if ($item->isDir() && !$item->isDot()) {
                $this->chmod_r($item->getPathname());
            }
        }
    }

    /**
     * Crée un dossier.
     *
     * @param string $target    comment
     * @param int    $chmod     comment
     * @param bool   $htaccess  comment
     * @param bool   $gitignore comment
     *
     * @return boolean
     */
    public function folderCreate(string $target, $chmod = 0755, $htaccess = false, $gitignore = false): bool
    {
        if (!is_dir($target)) {
            mkdir($target, $chmod);
            if ($htaccess == true && !\file_exists($target.'/.htaccess')) {
                $fichier = fopen($target.'/.htaccess', 'w+');
                fwrite($fichier, 'Options All -Indexes');
                fclose($fichier);
            }
            if ($gitignore == true && !\file_exists($target.'/.gitignore')) {
                $fichier = fopen($target.'/.gitignore', 'w+');
                fwrite($fichier, "/*\n!.gitignore\n!.htaccess\n");
                fclose($fichier);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Supprime le dossier ainsi que tout son contenu.
     *
     * @param string $target comment
     *
     * @return bool
     */
    public function folderDelete(string $target): bool
    {
        if (is_dir($target)) {
            $objects = scandir($target);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($target.'/'.$object) == 'dir') {
                        $this->folderDelete($target.'/'.$object);
                    } else {
                        unlink($target.'/'.$object);
                    }
                }
            }
            reset($objects);
            rmdir($target);
        }

        return !is_dir($target) ? true : false;
    }

    /**
     * Renomme un dossier.
     *
     * @param string $url_old comment
     * @param string $url_new comment
     *
     * @return boolean
     */
    public function folderRename(string $url_old, string $url_new): bool
    {
        is_dir($url_old) ? rename($url_old, $url_new) : '';

        return is_dir($url_new) ? true : false;
    }

    /**
     * Teste si un dossier existe.
     *
     * @param string $target comment
     *
     * @return boolean
     */
    public function folderExist(string $target): bool
    {
        return is_dir($target) ? true : false;
    }

    /**
     * Scan les fichiers appartenant a un dossier.
     *
     * @param string $target     comment
     * @param array  $extensions comment
     *
     * @return array
     */
    public function folderScan(string $target, array $extensions = []): array
    {
        $scan = [];

        if (is_dir($target)) {
            $files = scandir($target);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $extensions)) {
                    array_push($scan, $file);
                }
            }
        }

        return $scan;
    }
}
