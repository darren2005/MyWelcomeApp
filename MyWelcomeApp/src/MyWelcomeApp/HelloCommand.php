<?php

declare(strict_types=1);

namespace MyWelcomeApp;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HelloCommand extends Command {
    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("hello", "Say hello!");
        $this->setPermission("mywelcomeapp.hello"); // ✅ Ensure command has a permission
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$this->testPermission($sender)) {  // ✅ Check if sender has permission
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command.");
            return false;
        }

        if (!$this->plugin->getConfigData()->get("enable-hello-command", true)) {
            $sender->sendMessage(TextFormat::RED . "This command is disabled!");
            return false;
        }

        if ($sender instanceof Player) {
            $sender->sendMessage(TextFormat::GREEN . "Hello, " . TextFormat::AQUA . $sender->getName() . TextFormat::GREEN . "! Welcome to the server!");
        } else {
            $sender->sendMessage(TextFormat::YELLOW . "Hello from the console!");
        }

        return true;
    }
}
