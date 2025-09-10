FROM mariadb:10.11

# Add custom configuration
COPY my.cnf /etc/mysql/conf.d/my.cnf

# Add initialization script
COPY ./init.sql /docker-entrypoint-initdb.d/