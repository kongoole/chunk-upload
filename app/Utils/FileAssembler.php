<?php
/**
 * Date: 2018/8/24
 * Time: 16:36
 */

namespace App\Utils;


use Illuminate\Support\Facades\Log;

class FileAssembler
{
    use Error;

    const BUFFER_SIZE = 104857600; // 100M

    /**
     * @param array $files Files to be assembled
     * @param $path string Target file path
     * @return bool
     */
    public function assemble(array $files, $path)
    {
        if (empty($files)) {
            $this->setErr('empty files cannot be assembled');
            return false;
        }

        $targetHandler = fopen($path, 'ab+');
        foreach ($files as $file) {
            if (!file_exists($file)) {
                continue;
            }
            // read file
            $inputHandler = fopen($file, 'rb');
            while ($buffer = fread($inputHandler, self::BUFFER_SIZE)) {
                fwrite($targetHandler, $buffer);
            }
            fclose($inputHandler);
            unlink($file);
        }

        fclose($targetHandler);

        return true;
    }
}