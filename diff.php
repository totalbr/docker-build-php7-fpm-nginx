<?php

/**
 * Script para calcular diferenças entre arquivos
 *
 * Install libxdiff
 * wget http://www.xmailserver.org/libxdiff-0.22.tar.gz
 * tar -xzf libxdiff-0.22.tar.gz
 * cd libxdiff-0.22
 * ./configure
 * make
 * make install
 * 
 * 
 * apt-get install php-pear
 * pecl install xdiff
 * pecl/xdiff requires PHP (version >= 7.0.0)
 *
 * add extension=xdiff.so in the php.ini
 * restart apache or php-fpm
 * check the instalation php -m | grep xdiff
 *
 * @author Lucas Alves
 * @email luk4z_7@hotmail.com
 */

$projeto1 = '/var/www/ecidade1';
$projeto2 = '/var/www/ecidade2';

if (isset($argv[1]) and !empty($argv[1])) {

    if (file_exists($argv[1])) {

        $file = file($argv[1]);

        $lista = array_map(function($item) use ($projeto1) {
            return trim($projeto1 . '/' . $item);
        }, $file);

        /**
         * Função recursiva para calcular a diferença entre arquivos
         * parâmetro $pasta, o caminho do projeto número 1 a ser scaneado,
         * parâmetro $arquivolista,, lista com todos os arquivos alterados
         *
         * @param $pasta
         * @param $arquivolista
         */
        function verify($pasta, $arquivolista)
        {
            if ($handle = opendir($pasta)) {
                while (false !== ($entry = readdir($handle))) {
                    $dir = "$pasta/$entry";
                    if (is_dir($dir)) {
                        if (is_bool(strpos($dir, '.'))) {
                            if ($handle2 = opendir($dir)) {
                                while (false !== ($entry2 = readdir($handle2))) {
                                    $newDir = $dir . "/$entry2";
                                    if (is_dir($newDir)) {
                                        if (is_bool(strpos($newDir, '.'))) {
                                            verify($newDir, $arquivolista);
                                        }
                                    } else {
                                        if ( in_array( $newDir, $arquivolista ) ) {
                                            echo 'arquivo analisado ==> ' . $newDir . PHP_EOL;
                                            $diff = str_replace( '/', '_', $newDir) . '.diff';
                                            xdiff_file_diff(str_replace( 'ecidade1', 'ecidade2', $newDir ), $newDir, $diff, false);

                                            $check = file_get_contents( $diff );
                                            if ( empty($check) ) unlink( $diff );
                                        }
                                    }
                                }
                                closedir($handle2);
                            }
                        }
                    } else {
                        if ( in_array( $dir, $arquivolista ) ) {
                            echo 'arquivo analisado ==> ' . $dir . PHP_EOL;
                            $diff = str_replace( '/', '_', $dir) . '.diff';
                            xdiff_file_diff(str_replace( 'ecidade1', 'ecidade2', $dir ), $dir, $diff, false);

                            $check = file_get_contents( $diff );
                            if ( empty($check) ) unlink( $diff );
                        }
                    }
                }
                closedir($handle);
            }
        }

        verify($projeto1, $lista);

    } else
        echo 'Nenhum arquivo encontrado com esse nome!' . PHP_EOL;

} else
    echo 'Passe o caminho do arquivo listando os arquivos alterados!' . PHP_EOL;
