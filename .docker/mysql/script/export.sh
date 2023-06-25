#!/bin/bash

# --extended-insert=FALSE
mysqldump -uroot -proot $1 > /var/lib/mysql/desastreshow.sql