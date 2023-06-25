FROM dov118/laravel_image:1.0.1

# Define workdir
WORKDIR /var/www/html

# Define exposed port
EXPOSE 443
## TODO rendre le port dynamique

# Copy source files
COPY src/ .
RUN if [ "$APP_ENV" == "development" ] ; then rm -rf /var/www/html ; fi

# Copy start script
COPY start.sh /tmp/

# Change file right
RUN if [ "$APP_ENV" != "development" ] ; then chmod 777 -R /var/www/html/ ; fi

# Execute start script
ENTRYPOINT ["/bin/sh", "/tmp/start.sh"]