## Simple API Laravel Perpustakaan
API ini dibuat untuk aplikasi perpustakaan minimalis, fitur diantaranya ialah:

    - Master
        - Author
        - Bookshelf
        - Category
        - Publisher
        - Gender
    - Main
        - Book
        - Member
        - User
    - Inventory
        - Stock
    - Transaction
        - Loan
        - Return
    - Setting
        - Charge
        - Duration
        
        
## Dibuat dengan :

    - Laravel Framework versi 7.23
    - Laravel Sanctum (sebagai auth)
    
## Instalasi :

    - clone atau download repo git ini
    - buat database kosong namakan sesuai selera
    - edit file .env dan isi database dengan nama database tadi itu
    - jalankan perintah **php artisan migrate** dengan kondisi berada di dalam folder project ini
    - setelah selesai jalankan perintah **php artisan db:seed** untuk mengisi table yang kita migrasi tadi
    - buka aplikasi postman, lalu import file **json collection** yang ada di root folder project ini**
    - selesai
    - jalankan proses login dengan **email: admin@admin.com** dan **password: 123**
    - ketika login selesai copy token tersebut untuk digunakan pada setiap request yang akan dilakukan 
    - copy token tersebut pada tab auth pilih **type: Bearer Token** lalu isi value **token: dengan token yang di copy setelah login tadi**
