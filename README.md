1) copy .evn.example to .env
2) add 
   DB_CONNECTION=sqlite
   DB_FOREIGN_KEY=true 
   MAIL_FEEDBACK=<e-mail address to which we will send> 
3) php artisan migrate --seed
4) php artisan serve
5) localhost:8000
