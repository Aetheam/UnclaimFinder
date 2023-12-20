<?php

namespace ShadowMikado\UnclaimFinder;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use ShadowMikado\UnclaimFinder\listeners\UnclaimFinder;

class Main extends PluginBase implements Listener
{
    use SingletonTrait;

    public static Config $config;

    public function onLoad(): void
    {
        self::setInstance($this);
    }

    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        self::$config = $this->getConfig();

        $this->getServer()->getPluginManager()->registerEvents(new UnclaimFinder(), $this);

    }
}
