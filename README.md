# regular-library


Перед установкой локальной библиотеки необходимо установить и запустить [Docker](https://desktop.docker.com/win/main/amd64/Docker%20Desktop%20Installer.exe?utm_source=docker&utm_medium=webreferral&utm_campaign=dd-smartbutton&utm_location=module)

Программа с базой данных занимает около 275Гб, перед установкой необходимо убедиться в наличии свободного места на жестком диске.

Распакуйте скачанный архив в нужную папку `D:\terratensor\`

Перейдите в распакованную папку `D:\terrratensor\regular-library`

Для запуска приложения запустите файл `start.bat`

Для остановки приложения запустите файл `stop.bat`

Локальная библиотека будет доступна в браузере по адресу http://localhost:8030

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
