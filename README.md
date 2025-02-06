# MyWelcomeApp
MyWelcomeApp – A feature-packed welcome plugin for PocketMine! 🎉 Automatically greet players with custom messages, titles, action bar texts, and even fireworks! 

🚀 Reward first-time joiners, set personalized join/quit messages, and make your server feel alive! 🔥
📌 MyWelcomeApp – A Feature-Rich Welcome Plugin for PocketMine-MP 🎆

✨ Features
✅ Custom Welcome Messages – Personalize join & quit messages.
✅ Title & Action Bar Messages – Greet players in a stylish way.
✅ Firework Effects – Celebrate new players with an explosion! 🎆
✅ First-Time Join Rewards – Reward new players with in-game items.
✅ Randomized Messages – Send different welcome messages each time.
✅ Configurable Options – Fully adjustable via config.yml.

📥 Installation
1️⃣ Download the latest version of MyWelcomeApp.phar.
2️⃣ Upload the .phar file to your server's /plugins/ folder.
3️⃣ Restart your server to activate the plugin.
4️⃣ Modify config.yml to customize messages and effects.

⚙️ Configuration (config.yml)
Modify the config.yml file to customize the plugin to your liking:

# Enable or disable welcome features
enable-welcome: true

# Welcome message settings
welcome-message: "Welcome, {player}! Enjoy your stay!"
enable-title-message: true
enable-actionbar-message: true

# Fireworks on join
enable-fireworks: true

# First-time join reward
enable-join-reward: true
reward-item: "golden_apple"
reward-amount: 3

# Custom leave message
custom-leave-message: "{player} has left the server."
🔹 {player} will be replaced with the player's name.

🛠 Commands
Command	Description	Permission
/hello	Greets the player with a friendly message	mywelcomeapp.hello

🔑 Permissions
Permission	Description	Default
mywelcomeapp.hello	Allows use of /hello command	true

📌 Upcoming Features
✅ Admin commands to change settings in-game
✅ Discord integration for logging joins/leaves
✅ More particle & sound effects

📜 License
This plugin is licensed under the MIT License – free to use and modify!

Credits
Developer: Darren Edwards
