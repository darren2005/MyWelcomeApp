<?php

declare(strict_types=1);

namespace MyWelcomeApp\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use MyWelcomeApp\Main;

class SetHomeCommand extends Command {
    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("sethome", "Set your home location", "/sethome");
        $this->setPermission("mywelcomeapp.sethome");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "❌ This command can only be used in-game!");
            return false;
        }

        if (!$this->testPermission($sender)) {
            $sender->sendMessage(TextFormat::RED . "❌ You don't have permission to use this command.");
            return false;
        }

        // ✅ Use getHomes() instead of accessing $homes directly
        $homes = $this->plugin->getHomes();
        $playerName = $sender->getName();

        // ✅ Store home location
        $homes->setNested($playerName, [
            "world" => $sender->getWorld()->getFolderName(),
            "x" => $sender->getPosition()->getX(),
            "y" => $sender->getPosition()->getY(),
            "z" => $sender->getPosition()->getZ(),
            "yaw" => $sender->getLocation()->getYaw(),
            "pitch" => $sender->getLocation()->getPitch(),
        ]);
        $homes->save();

        $sender->sendMessage(TextFormat::GREEN . "🏡 Home set successfully!");
        return true;
    }
}
