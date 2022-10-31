# Twitter23
**Twitter23** - This is a 2009 Twitter parody. This service allows friends, family and colleagues to communicate and stay connected by exchanging quick and frequent tweets in response to one simple question: **What's new**? 

## How to create instance
That's very easy. Instuction tested on Debian 10.
1) First, twitter23 uses php7.3, so install require dependences:
```bash
sudo apt install php php-pdo php-mysql php-xml php-gd php-tokenizer php-mbstring
sudo apt install php-curl php-zip php-yaml composer git mariadb-server
```
2) Clone repository and move folders from /src directory to root directory. Install requirements
```bash
git clone https://github.com/twitter23/twitter23
composer install
```
3) Create database `twitter23` or change database name in [db.php](http://github.com/twitter23/twitter23/blob/master/src/frontend/config/db.php  "db.php")
Now make migration [twitter23.sql](http://github.com/twitter23/twitter23/blob/master/mysql/twitter23.sql "twitter23.sql")
4) Init twitter23. Choose need responses
```bash
php init
```
5) For test start `php -S localhost:8080` in /frontend/web/index.php.

## How can I make bug report?
You can do it in [issues](https://github.com/twitter23/twitter23/issues "issues")
