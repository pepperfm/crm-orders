# Build
`cp .env.example .env`

Set system `uid` amd `gid` to `WWWUSER` and `WWWGROUP` variables

Then
```bash

./sail up -d --build
```
```bash

./sail artisan key:gen
```
```bash

./sail artisan migrate:fresh --seed
```
```bash

./sail bun install
```
```bash

./sail bun run build
```
