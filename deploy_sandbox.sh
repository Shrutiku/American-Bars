#!/bin/sh

ssh -i ~/.ssh/sandboxAB.pem ubuntu@sandbox.americanbars.com 'cd /var/www/html/; git pull origin sandbox'