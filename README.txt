ESP8266 + PIR + Buzzer Web Security System

Default web login:
username: admin
password: admin123

IMPORTANT:
1. Change password after first login.
2. Edit config.php and set your Telegram bot token + chat ID.
3. Edit the Arduino sketch and set your Wi-Fi name, password, server IP, and API key.

Pin connections (NodeMCU ESP8266):
PIR OUT > D5
Buzzer + > D6
Buzzer - > GND
PIR VCC > VIN
PIR GND > GND


Files:
  security_system.ino  > ESP8266 code
  config.php > app settings
  init.php  > auto create JSON files
  auth.php  > login protection
  index.php  > login page
  dashboard.php  > main dashboard
  change_password.php  > password change
  logout.php   > logout
  api/receive_motion.php  > receives motion from ESP8266
  api/get_settings.php   > ESP8266 reads kill switch state
  api/get_logs.php    > dashboard fetches logs
  api/toggle_system.php   > enable/disable system from web
  api/clear_logs.php   > clear motion history
  api/change_password_action.php  > update password
  assets/style.css   > full styling
  assets/app.js  > dashboard JS
  data/*.json > storage

JSON API flow:
ESP8266 > PHP receive_motion.php > saves log in JSON > sends Telegram message
ESP8266 < PHP get_settings.php < dashboard toggle writes JSON state
Dashboard < PHP get_logs.php < reads stored logs
