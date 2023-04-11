<?php

namespace App\Core\Clone;

use Symfony\Component\Process\Process;

class Github
{
    public static function clone($repositoryUrl, $app): void{
        $process = new Process(['git', 'clone', $repositoryUrl, config('services.github.clone_path') . '/' . $app]);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }

}
