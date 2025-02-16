<?php

declare(strict_types=1);

namespace Darren2005\MyWelcomeApp\commands; // Correct namespace

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use Darren2005\MyWelcomeApp\Main; // Correct namespace for Main

class HomeCommand extends Command {

    private Main $plugin;

    public function __construct(Main $plugin) {
        parent::__construct("home", "Teleport to your home", "/home");
        $this->setPermission("mywelcomeapp.home");
        $this->plugin = $plugin;
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

        // Get player's home data from homes.yml using the getter method
        $homes = $this->plugin->getHomes();
        $playerName = $sender->getName();

        // Check if the player has set a home
        if (!$homes->exists($playerName)) {
            $sender->sendMessage(TextFormat::RED . "You haven't set a home yet. Use /sethome to set your home location.");
            return false;
        }

        // Get home data
        $homeData = $homes->getNested($playerName);

        // Retrieve home coordinates
        $worldName = $homeData["world"];
        $x = $homeData["x"];
        $y = $homeData["y"];
        $z = $homeData["z"];
        $yaw = $homeData["yaw"];
        $pitch = $homeData["pitch"];

        // Retrieve the world the player is in
        $world = $this->plugin->getServer()->getWorldManager()->getWorldByName($worldName);
        if ($world === null) {
            $sender->sendMessage(TextFormat::RED . "The world for your home could not be found!");
            return false;
        }

        // Teleport the player to their home
        $position = new \pocketmine\math\Vector3($x, $y, $z);
        $sender->teleport($position, $yaw, $pitch);
        $sender->sendMessage(TextFormat::GREEN . "Teleported to your home in " . $worldName . "!");

        return true;
    }
}
