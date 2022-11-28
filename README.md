# StudentsApi

<details>
    <summary>Prerequisites 🧾</summary>

|          |      Version      |
|:--------:|:-----------------:|
|   Php    | v8.1.12 or higher |
|  MySQL   |      latest       |
| Artisan  |      latest       |
| Composer |      latest       |
| Postman  |      latest       |

</details>

<details>
    <summary>Setup ⚙</summary>

- Configure an *.env* file, check the example [.env](./.env.example)

```sh
# Onetime command as this might delete the already existing DB
# When it does not exist then a new DB will get created
php artisan migrate

# Start the project
php artisan serve
```

</details>

<details>
    <summary>Usage 🐱‍🚀</summary>

Open [Postman](postman:///) and import the [collection](./StudentsApi.postman_collection.json)

Don't forget to change the [Api key](https://github.com/ssadrian/StudentsApi/blob/main/CrudApi.postman_collection.json#L573) to a valid one

</details>
