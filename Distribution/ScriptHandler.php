<?php

namespace SonataExtensionsBundle\Distribution;

use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as SensionScriptHandler;

require '../../autoload.php';

class ScriptHandler extends SensionScriptHandler
{
    public static function notifyAboutAssetic(CommandEvent $event)
    {
        $io = $event->getIO();
        $io->write('');
        $io->write('!!! Do not forget to call "console assetic:dump" to compile assets.');
        $io->write('TODO: fix it to be automatic.');
        $io->write('');
    }
}