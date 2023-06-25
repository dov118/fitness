#!/bin/bash

echo "SET FOREIGN_KEY_CHECKS = 0;" > temp.sql
mysqldump --add-drop-table --no-data --column-statistics=0 --user=root --password=root $1 | grep 'DROP TABLE' >> temp.sql
echo "SET FOREIGN_KEY_CHECKS = 1;" >> temp.sql
mysql -uroot -proot $1 < temp.sql
rm -f temp.sql

mysql -uroot -proot $1 < /var/lib/mysql/desastreshow.sql