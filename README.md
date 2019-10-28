## Задача
Целта е да разработите проста система за приемане на депозити по сметки и олихвяването им на дневна база.
Депозитите се приемат само в BGN (левове) и се добавят към сумата по сметка. Сметките са в левове. Лихвения процент е фиксиран и е 0.01% на дневна база. Лихвата се изчислява веднъж дневно, като не трябва да позволява по време на изчислението да се правят депозити. Същевременно, времето за което се изчисляват лихвите, трябва да е минимално.
След този процес на изчислениетона лихви, да се генерира прост репорт показващ колко общо лихви са платени за предния ден и колко са общо депозитите.Въпросните суми да се изчислят и в USD. За целта да се ползва това rest api:
[Link](http://data.fixer.io/api/latest?access_key=0d52da9f2090212bec148d7cd9d858b1)
За целта на задачата приемаме 2 хардкоднати клиента, всеки от тях с по 2 сметки.
UI е прост HTML с input клиент, сметка, сума за депозиране. За репорта - таблица HTML.

***
## Setup

* Clone the project `git clone https://github.com/nikraz/credissimo.git`
* Run `docker compose up` ; 
* Ssh into php container `docker exec -it sf4_php /bin/bash` && `cd /home/wwwroot/sf4` && `composer install`;
* Create database `CREATE DATABASE sf4`
* Adjust .env or .env.local for your database `DATABASE_URL=mysql://root:root@mysql:3306/sf4`
* Run the migrations from php container:  `php bin/console doctrine:migrations:migrate`           

* Add some data:
```
INSERT INTO `client`(`name`) VALUES ("client1")
INSERT INTO `client`(`name`) VALUES ("client2")

INSERT INTO `account`(`total`, `client_id`,`available`,`updated_at`) VALUES (0,1,1,now());
INSERT INTO `account`(`total`, `client_id`, `available`,`updated_at`) VALUES (0,2,1,now());
```
OR run the fixtures

`docker exec -it sf4_php /bin/bash` && `cd /home/wwwroot/sf4` && `php bin/console doctrine:fixtures:load`

## Custom commands and useful urls

* Run custom calculate and add interest command: 
`docker exec -it sf4_php /bin/bash` && `cd /home/wwwroot/sf4` && `php bin/console Deposit`
* Run tests
`docker exec -it sf4_php /bin/bash` && `cd /home/wwwroot/sf4` && `./bin/phpunit`
* Useful project urls:
[Link](http://localhost:8080/) - php myadmin
[Link](http://localhost/command-scheduler/list) - for scheduling commands
[Link]( http://localhost/deposit) - deposit form
* To create cron job every day at 11:30 PM to execute the Deposit command, add this line in crontab -e
`30 23 * * *  php  /home/wwwroot/sf4/bin/console Deposit`
