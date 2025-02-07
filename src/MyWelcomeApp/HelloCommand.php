<?php

declare(strict_types=1);

namespace MyWelcomeApp\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use MyWelcomeApp\Main; // Import Main plugin class

class HelloCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("hello", "Say hello!", "/hello");
        $this->setPermission("mywelcomeapp.hello");
        $this->plugin = $plugin; // Assign plugin instance
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "This command can only be used in-game!");
            return false;
        }

        if (!$this->testPermission($sender)) {
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command.");
            return false;
        }

        // ✅ Example of using $plugin (logging player usage)
        $this->plugin->getLogger()->info("Player " . $sender->getName() . " used /hello command.");

        $sender->sendMessage(TextFormat::GREEN . "Hello, " . $sender->getName() . "! Welcome to the server!");
        return true;
    }
}
