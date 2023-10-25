## How to use

1. Run `composer install`.
2. Run `yarn` or `npm install`.
3. Setup `.env` first. Especially redis connection.
4. Run `yarn dev` or `npm run dev`.
5. Run `php artisan serve`.
6. Run `php artisan schedule:work` or setup Laravel Task Scheduler using Cron (Linux-based).

Note:
  - Make sure `composer` installed.
  - Make sure `node` version 18 installed.
  - Make sure `redis` installed. (I'm using `sync` driver for now, my PC cannot install WSL so it might be successful when trying using `redis` driver)