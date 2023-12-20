<?php


namespace ShadowMikado\UnclaimFinder\listeners;


namespace ShadowMikado\UnclaimFinder\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use pocketmine\Server;
use ShadowMikado\UnclaimFinder\Main;

class UnclaimFinder implements Listener {

    public function onMove(PlayerMoveEvent $e) {
        $player = $e->getPlayer();

        if ($this->hasUnclaimFinderPermission($player) && $this->isUnclaimFinder($player->getInventory()->getItemInHand())) {
            $pos = $player->getPosition();
            $tiles_list = array_map(function($blockname) {
                return StringToItemParser::getInstance()->parse($blockname)->getBlock()->getTypeId();
            }, Main::$config->get("blocks"));

            $world_list = empty(Main::$config->get("worlds")) ? [$player->getWorld()] : array_map(function($worldname) {
                return Server::getInstance()->getWorldManager()->getWorldByName($worldname);
            }, Main::$config->get("worlds"));

            if (in_array($player->getWorld(), $world_list)) {
                $count = 0;

                foreach ($player->getWorld()->getChunk(intval($pos->getX()) >> 4, intval($pos->getZ()) >> 4)->getTiles() as $tile) {
                    if (in_array($tile->getBlock()->getTypeId(), $tiles_list)) {
                        ++$count;
                    }

                    $player->sendTip(str_replace(["{count}", "%"], [$count, "%%"], Main::$config->get("format")));
                }
            }
        }
    }

    private function hasUnclaimFinderPermission(Player $player): bool {
        $permissionEnabled = Main::$config->getNested("permission.enabled");
        $permissionName = Main::$config->getNested("permission.name");

        return $permissionEnabled ? $player->hasPermission("unclaimfinder" . $permissionName) : true;
    }

    private function isUnclaimFinder(Item $item): bool {
        $unclaimfinder = $this->nameToItem(Main::$config->get("item"))->getTypeId();
        return $item->getTypeId() === $unclaimfinder;
    }

    private function nameToItem(string $name): Item {
        return StringToItemParser::getInstance()->parse($name);
    }
}
