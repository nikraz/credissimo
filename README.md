Целта е да разработите проста система за приемане на депозити по сметки и олихвяването им на дневна база.

Депозитите се приемат само в BGN (левове) и се добавят към сумата по сметка. Сметките са в левове. Лихвения процент е фиксиран и е 0.01% на дневна база. Лихвата се изчислява веднъж дневно, като не трябва да позволява по време на изчислението да се правят депозити. Същевременно, времето за което се изчисляват лихвите, трябва да е минимално.

 

След този процес на изчислениетона лихви, да се генерира прост репорт показващ колко общо лихви са платени за предния ден и колко са общо депозитите.Въпросните суми да се изчислят и в USD. За целта да се ползва това rest api: http://data.fixer.io/api/latest?access_key=0d52da9f2090212bec148d7cd9d858b1

 

За целта на задачата приемаме 2 хардкоднати клиента, всеки от тях с по 2 сметки.


UI е прост HTML с input клиент, сметка, сума за депозиране. За репорта - таблица HTML.


Clone the project, run docker compose up ; ssh into php container and run : composer install; make database; adjust .env or .env.local for your database.
DATABASE_URL=mysql://root:root@mysql:3306/sf4
 run the migrations from withing the php container:  
      php bin/console doctrine:migrations:migrate             

add some data:
 
INSERT INTO `client`(`name`) VALUES ("client1")
INSERT INTO `client`(`name`) VALUES ("client2")

INSERT INTO `account`(`total`, `client_id`,`available`,`updated_at`) VALUES (0,1,1,now());
INSERT INTO `account`(`total`, `client_id`, `available`,`updated_at`) VALUES (0,2,1,now());

Run custom deposit command: 

ssh into sf4-php container and in project root run : php bin/console Deposit

useful urls:
 http://localhost/command-scheduler/list
 http://localhost/deposit