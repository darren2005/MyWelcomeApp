<?php

declare(strict_types=1);

namespace Darren2005\MyWelcomeApp\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class HelloCommand extends Command {

    public function __construct() {
        parent::__construct("hello", "Say hello to the server!", "/hello");
        $this->setPermission("mywelcomeapp.hello"); 
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$this->testPermission($sender)) { 
            $sender->sendMessage(TextFormat::RED . "❌ You don't have permission to use this command.");
            return false;
        }

        $message = $sender instanceof Player 
            ? TextFormat::GREEN . "👋 Hello, " . $sender->getName() . "! Welcome to the server!"
            : TextFormat::YELLOW . "👋 Hello from the console!";

        $sender->sendMessage($message);
        return true;
    }
}
