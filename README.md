## Authors
Rights Owned By: Defenzelite Private Limited
- [@defenzelite](https://github.com/Defenzelite-HQ)
The code and any related materials provided by zStarter are for company project purpose use only and may not be used, shared, cloned, or sold for any commercial or non-personal purposes without the express written consent of Defenzelite. Any unauthorized use, sharing, cloning, or selling of the code or related materials is strictly prohibited and may result in legal action.



## Run Locally

Clone zStarter Repo
```bash
    Goto Git Desktop
    File > Clone Repository
    Make Sure Tab GitHub.com is selected
    Find Your Repository & Select It
    Set Proper Local Path
    Hit Clone Button
```
Config .env
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307 / 3306
    DB_DATABASE=your_database_name_here
    DB_USERNAME=root / your_database_username_here
    DB_PASSWORD=leave_blank / your_database_password_here
```
Prepare Database
```bash
  php artisan migrate 
  php artisan db:seed --class=DatabaseSeeder
```
Install Dependencies
```bash
  composer install
```
Update Essential Infomations in .env
```bash
  APP_NAME=project_name_here
  APP_DEBUG=true / false
  DEV_MODE = 1 / 0
  IS_DEV = 1 / 0
```
Happy Coding!

    
## Support

For support, email hq@defenzelite.com or join our Slack channel.


## Advice

As a developer, it's important to stay up to date with the latest technologies and best practices in your field. A good way to do this is to regularly read industry blogs, participate in online forums, and attend conferences and meetups. Additionally, don't be afraid to experiment and try new things, even if they may seem difficult at first. It's also important to practice good coding habits, such as commenting your code, using version control, and writing readable and maintainable code. Finally, don't be afraid to ask for help or collaborate with other developers, as you can learn a lot from others in the community.

