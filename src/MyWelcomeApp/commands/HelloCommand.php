<?php

declare(strict_types=1);

namespace MyWelcomeApp\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use MyWelcomeApp\Main;

class HelloCommand extends Command {
    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("hello", "Say hello!", "/hello");
        $this->setPermission("mywelcomeapp.hello"); // ✅ Correctly setting permission
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$this->testPermission($sender)) { // ✅ Correctly checks for permission
            $sender->sendMessage(TextFormat::RED . "❌ You don't have permission to use this command.");
            return false;
        }

        if ($sender instanceof Player) {
            $sender->sendMessage(TextFormat::GREEN . "👋 Hello, " . $sender->getName() . "! Welcome to the server!");
        } else {
            $sender->sendMessage(TextFormat::YELLOW . "👋 Hello from the console!");
        }
        return true;
    }
}
