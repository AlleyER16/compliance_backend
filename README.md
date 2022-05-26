# Compliance project Backend PHP

Backend for compliance project

# Deployment instructions

1. Change variable `$type` in `v1/helpers/cors.php` to either `production` or `development`
2. If in `development` copy the whole directory to your server root except the `dbSchema.sql` file but if in `production` copy the whole directory to `/api` in your server root.
3. Create a database and add the credentials to `ebl/config/Dbh.config.php`.
4. Run the sql query in dbSchema.sql.
5. If your frontend is on the same URL as your backend uncomment the codes in `v1/includes/admin_logged.php` and `v1/includes/employee_logged.php`.

Note: Step 5 is because session cannot be persisted across different domains
