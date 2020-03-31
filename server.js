var echo = require('laravel-echo-server');

var options = {
  "authHost": "http://localhost:8000",
  "authEndpoint": "/broadcasting/auth",
  "clients": [],
  "database": "redis",
  "databaseConfig": {
    "redis": {
      "port": "6379",
      "host": "localhost"
    }
  },
  "devMode": true,
  "host": null,
  "port": "6001",
  "protocol": "http",
  "socketio": {},
  "sslCertPath": "",
  "sslKeyPath": "",
  "sslCertChainPath": "",
  "sslPassphrase": "",
  "apiOriginAllow": {
    "allowCors": true,
    "allowOrigin": "http://localhost:6001",
    "allowMethods": "GET,POST",
    "allowHeaders": "Origin, Content-Type, X-Auth-Token, X-Requested-With, Accept, Authorization, X-CSRF-TOKEN, X-Socket-Id"
  }
};

echo.run(options);
