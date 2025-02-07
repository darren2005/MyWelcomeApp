<?php

declare(strict_types=1);

namespace MyWelcomeApp;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use MyWelcomeApp\commands\HelloCommand;
use MyWelcomeApp\commands\SetHomeCommand;
use MyWelcomeApp\commands\HomeCommand;
use MyWelcomeApp\EventListener;

class Main extends PluginBase {

    private static ?Main $instance = null; // ✅ Singleton instance
    private Config $configData;
    private Config $playerData;
    private Config $homes; // ✅ Home storage

    public function onEnable(): void {
        self::$instance = $this; // ✅ Set instance safely

        // Ensure data folder exists
        @mkdir($this->getDataFolder());

        // ✅ Save default config.yml
        $this->saveDefaultConfig();
        $this->configData = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        // ✅ Create PlayerData.yml for tracking first-time join rewards
        $this->playerData = new Config($this->getDataFolder() . "PlayerData.yml", Config::YAML);

        // ✅ Create Homes.yml for storing home locations
        $this->homes = new Config($this->getDataFolder() . "homes.yml", Config::YAML);

        $this->getLogger()->info("✅ MyWelcomeApp has been enabled!");

        // ✅ Register commands safely
        $this->registerCommands();

        // ✅ Register event listeners
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    // ✅ Centralized method to register all commands
    private function registerCommands(): void {
        $commandMap = $this->getServer()->getCommandMap();

        // Check if hello command is enabled and register it
        if ($this->configData->get("enable-hello-command", true)) {
            if (class_exists(HelloCommand::class)) {
                $commandMap->register("hello", new HelloCommand($this));
            } else {
                $this->getLogger()->error("❌ HelloCommand class not found!");
            }
        }

        // Register SetHomeCommand
        if (class_exists(SetHomeCommand::class)) {
            $commandMap->register("sethome", new SetHomeCommand($this));
        } else {
            $this->getLogger()->error("❌ SetHomeCommand class not found!");
        }

        // Register HomeCommand
        if (class_exists(HomeCommand::class)) {
            $commandMap->register("home", new HomeCommand($this));
        } else {
            $this->getLogger()->error("❌ HomeCommand class not found!");
        }
    }

    // ✅ Save homes and player data when plugin is disabled
    public function onDisable(): void {
        $this->homes->save();
        $this->playerData->save();
        $this->getLogger()->info("❌ MyWelcomeApp has been disabled!");
    }

    // ✅ Getter methods for config data, player data, and homes
    public function getConfigData(): Config {
        return $this->configData;
    }

    public function getPlayerData(): Config {
        return $this->playerData;
    }

    public function getHomes(): Config {
        return $this->homes;
    }

    // ✅ Singleton pattern for easy access to plugin instance
    public static function getInstance(): ?Main {
        return self::$instance;
    }
}
