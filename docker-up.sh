#! /bin/bash

clear

# http://patorjk.com/software/taag/#p=display&f=Big&t=Docker-up
cat <<\EOF
  _____             _
 |  __ \           | |
 | |  | | ___   ___| | _____ _ __ ______ _   _ _ __
 | |  | |/ _ \ / __| |/ / _ \ '__|______| | | | '_ \
 | |__| | (_) | (__|   <  __/ |         | |_| | |_) |
 |_____/ \___/ \___|_|\_\___|_|          \__,_| .__/
                                              | |
                                              |_|

EOF

if [ ! -f ".env" ]; then
    printf '\e[1;31m%-6s\n\e[m' "Warning: the file \".env\" is missing. Default values will be used."
    printf '\e[1;31m%-6s\n\n\e[m' "Please run \"cp .env.example .env\" to create the file then edit it to adjust the settings to your needs."
fi

docker-compose up -d

# Read configuration from the .env file
APPLICATION_NAME="myDockerApp"
APACHE_PORT=8080

if [ -f .env ]; then
    APPLICATION_NAME="$(grep "APPLICATION_NAME" .env | cut -d "=" -f 2)"
    APACHE_PORT="$(grep "APACHE_PORT" .env | cut -d "=" -f 2)"
fi

printf '\e[1;32m\n%-6s\n\n\e[m' "Open a browser and navigate to http://127.0.0.1:$APACHE_PORT to let the script starts"
printf '\e[1;32m%-6s\n\n\e[m' "Run \"docker exec -it ${APPLICATION_NAME}_php /bin/bash\" in a CLI if you need to start an interactive shell"
printf '\e[1;32m%-6s\n\n\e[m' "Run \"docker restart  ${APPLICATION_NAME}_php\" in a CLI to clear the OP cache."
