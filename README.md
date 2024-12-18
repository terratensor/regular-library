# library-app

Manual Docker Setup
If you prefer to set up Docker manually, follow these steps for Library App.

Step 1: Pull the Library App Image
Start by pulling the latest Library App Docker image from the GitHub Container Registry.

```
docker pull ghcr.io/terratensor/library-app:main
```

Step 2: Run the Container
Run the container with default settings. This command includes a volume mapping to ensure persistent data storage.

```
docker run -d -p 8030:80 -v library-app:/app/data --name library-app ghcr.io/terratensor/library-app:main
```


Important Flags
Volume Mapping (-v library-app:/app/data): Ensures persistent storage of your data. This prevents data loss between container restarts.
Port Mapping (-p 8030:80): Exposes the Library App on port 8030 of your local machine.


# regular-library


Перед установкой локальной библиотеки необходимо установить и запустить [Docker](https://desktop.docker.com/win/main/amd64/Docker%20Desktop%20Installer.exe?utm_source=docker&utm_medium=webreferral&utm_campaign=dd-smartbutton&utm_location=module)

Программа с базой данных занимает около 275Гб, перед установкой необходимо убедиться в наличии свободного места на жестком диске.

Распакуйте скачанный архив в нужную папку `D:\terratensor\`

Перейдите в распакованную папку `D:\terrratensor\regular-library`

Для запуска приложения запустите файл `start.bat`

Запускать файл надо под обычным пользователем, это не «запуск от имени администратора».
Если запуск bat файла по каким-то причинам невозможен, то запустите через меню пуск приложение «коммандная строка» — cmd.exe, в коммандной строке выберите папку в которую установили программу.

Если устанавливали на диск отличный от C, то сначала выбирите нужный диск, наберите и нажмите клавишу Enter:
```
D:
```
Затем папку с установленной программой, наберите и нажмите клавишу Enter:
```
cd D:\terratensor
```
Затем наберите команду для запуска локльного сайта:
```
docker compose up -d
```

Для остановки приложения запустите файл `stop.bat`
Команда для остановки сайта с помощью консоли:
```
docker compose down --remove-orphans
```

Локальная библиотека будет доступна в браузере по адресу http://localhost:8030

### Сайт не отображается в браузере

Если сайт не отображается, то скорее всего не запущен контейнер php-1, надо посмотреть, что отображается в docker в секции Logs.
Нажмите на иконку Docker Desktop в системном трее, в открывшемся окне в списке найдите строку `regular-library`, найдите под этой строкой контейнер `php-1` нажмите на строку с именем контейенра, скопируйте текст из секции logs.
Создайте issue и скопируйте текст из секции Logs в сообщение.

![2023-09-26_16-59-36](https://github.com/terratensor/book-parser/assets/10896447/556e19b8-632c-487d-aeec-4055a883fe80)

<details><summary>Посмотреть скриншот полного окна Docker Desktop</summary>
<p>

![2023-09-26_17-47-55](https://github.com/terratensor/regular-library/assets/10896447/066d9375-09a9-4cc2-a853-42bb25408a25)

</p>
</details>

- php-1 — это контейнер с сайтом, php код и веб сервер apache2;
- manticore — контейнер с базой мантикоры;
- postgres — контейнер с БД postgres.

### Дополнительная информация:
База данных находиться в папке с установленной программой: `D:\terratensor\regular-library\manticore\regular_library_manticore\data`

### Настройки файла docker-compose.yml

Если на компьютере уже есть программа, которая занимает порт 8030, то вы можете изменить порт, например на 8040 в файле docker-compose.yml в строке 32:
```
    ports:
      - '8030:80'
```

Том с базой данных монтируется в строке 60:

```
    volumes:
      - manticore:/var/lib/manticore
      - manticore:/var/log/manticore
      - ./docker/manticore/manticore.conf:/etc/manticoresearch/manticore.conf
      - ./manticore/regular_library_manticore/data:/var/lib/manticore/data
```

Выше в строке 59 монтируется файл конфигурации мантикоры. 
