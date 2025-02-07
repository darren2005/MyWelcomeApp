<?php

declare(strict_types=1);

namespace MyWelcomeApp;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;
use pocketmine\network\mcpe\protocol\SetTitlePacket;
use pocketmine\world\particle\HugeExplodeParticle;
use pocketmine\math\Vector3;
use pocketmine\item\VanillaItems;

class EventListener implements Listener {
    private Main $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $config = $this->plugin->getConfigData();
        $player = $event->getPlayer();

        // ✅ First-time join rewards
        $playerData = $this->plugin->getPlayerData();
        if (!$playerData->exists($player->getName())) {
            $playerData->set($player->getName(), true);
            $playerData->save();

            $player->sendMessage(TextFormat::GREEN . "You received a welcome gift!");
            $player->getInventory()->addItem(VanillaItems::GOLDEN_APPLE()->setCount(3));
        }

        // ✅ Custom join messages
        if ($config->get("enable-welcome", true)) {
            $message = str_replace("{player}", $player->getName(), $config->get("welcome-message"));
            $player->sendMessage($message);
        }

        // ✅ Custom title messages
        if ($config->get("enable-title-message", true)) {
            $pk = new SetTitlePacket();
            $pk->type = SetTitlePacket::TYPE_SET_TITLE;
            $pk->text = "Welcome, " . $player->getName() . "!";
            $player->getNetworkSession()->sendDataPacket($pk);
        }

        // ✅ Action bar message
        if ($config->get("enable-actionbar-message", true)) {
            $player->sendActionBarMessage(TextFormat::GOLD . "Enjoy your stay on the server!");
        }

        // ✅ Randomized welcome messages
        $messages = $config->get("welcome-messages", []);
        if (!empty($messages)) {
            $randomMessage = str_replace("{player}", $player->getName(), $messages[array_rand($messages)]);
            $player->sendMessage($randomMessage);
        }

        // ✅ Fireworks on join (Corrected version)
        if ($config->get("enable-fireworks", true)) {
            $position = $player->getPosition();
            $world = $player->getWorld();
            $world->addParticle(new Vector3($position->x, $position->y + 1, $position->z), new HugeExplodeParticle());
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event): void {
        $config = $this->plugin->getConfigData();
        $player = $event->getPlayer();

        // ✅ Custom leave message
        $leaveMessage = str_replace("{player}", $player->getName(), $config->get("custom-leave-message"));
        $event->setQuitMessage($leaveMessage);
    }
}
