#!/bin/sh
mysql -uroot -e 'drop database ezdemo'
mysql -uroot -e 'create database ezdemo character set utf8mb4 collate utf8mb4_general_ci'
