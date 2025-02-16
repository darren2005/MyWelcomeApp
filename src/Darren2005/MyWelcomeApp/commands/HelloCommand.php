<?php

declare(strict_types=1);

namespace Darren2005\MyWelcomeApp\commands;  // Ensure this matches your actual namespace

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Darren2005\MyWelcomeApp\Main;  // Correct namespace for Main class

class HelloCommand extends Command {
    private Main $plugin; // Declare the plugin property

    public function __construct(Main $plugin) {
        parent::__construct("hello", "Say hello!", "/hello");
        $this->setPermission("mywelcomeapp.hello"); // Correctly setting permission
        $this->plugin = $plugin;  // Properly initializing the plugin property
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$this->testPermission($sender)) { // Correctly checks for permission
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
