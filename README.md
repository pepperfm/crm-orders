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

# There is two routes available for test:
```
Pre-built: [Breezy](https://laravel.com/docs/12.x/starter-kits#vue) starter kit
Front. framework: Vue.js (Composition API)
UI/UX libraries: [Element Plus](https://element-plus.org/en-US/component/button.html)

URL:
get: /dashboard
```
```
Pre-built: [Filament](https://filamentphp.com/docs/3.x/panels/getting-started)

URL:
get: /panel
```

## Test user:
`test@example.com`

`password`
