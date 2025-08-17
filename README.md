# Document/File/Image Manager

> Note: This is work in progress

### Features

* Solid stack: Laravel, Blade, TailwindCSS. 
* Intuitive and responsive (not yet) UI
* Navigate documents using a simple search query
* Categorize your documents into descriptive sections 
* Easily upload one or multiple documents
* View, update, or delete any uploaded document 
* Selection feature allowing you to select multiple documents and perform different actions on them (e.g. download in zip format)

### Installation

```
$ git clone https://github.com/MrNesli/Document-Web-Manager.git
```

```
$ cd Document-Web-Manager/
```

```
$ composer install
```

```
$ npm install
```

```
$ php artisan key:generate
```

```
$ cp .env.example .env
```

```
DB_DATABASE=<Your database>
DB_USERNAME=<DB user>
DB_PASSWORD=<DB user's password>
```

```
$ php artisan migrate
```

Start Vite and Laravel servers:

```
$ php artisan serve
```

```
$ npm run dev
```

And then, go to this link in your browser:

```
http://localhost:8000
```
